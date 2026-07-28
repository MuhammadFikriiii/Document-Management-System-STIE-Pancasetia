<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Division;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Halaman Admin Dashboard khusus (Summary stats + 5 aktivitas terbaru)
     */
    public function dashboard()
    {
        $totalUsers    = User::count();
        $activeUsers   = User::where('is_active', true)->count();
        $totalFolders  = \App\Models\Folder::count();
        $totalFiles    = \App\Models\File::count();
        $totalStorage  = \App\Models\File::sum('size');
        $recentLogs    = ActivityLog::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeUsers',
            'totalFolders',
            'totalFiles',
            'totalStorage',
            'recentLogs'
        ));
    }

    /**
     * Tampilkan daftar semua user.
     */
    public function users(Request $request)
    {
        $search  = $request->input('search');
        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = User::with('division')
            ->withCount('files')
            ->withSum('files', 'size');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('email', 'LIKE', '%' . $search . '%');
            });
        }

        $users     = $query->orderBy('name')->paginate($perPage)->withQueryString();
        $divisions = Division::orderBy('name')->get();

        $totalStorage = \App\Models\File::sum('size');
        $totalUsers   = User::count();
        $activeUsers  = User::where('is_active', true)->count();

        return view('admin.users.index', compact('users', 'divisions', 'search', 'perPage', 'totalStorage', 'totalUsers', 'activeUsers'));
    }


    /**
     * Tambah user baru (Create User).
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|string|min:6',
            'role'        => 'required|in:admin,divisi',
            'division_id' => 'nullable|exists:divisions,id',
            'is_active'   => 'nullable|boolean',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'division_id' => $request->division_id,
            'is_active'   => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        ActivityLog::record('create_user', 'Admin membuat user baru "' . $user->name . '" (' . $user->email . ')');

        return back()->with('success', "User {$user->name} berhasil ditambahkan.");
    }

    /**
     * Edit/Update user (Update User).
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'    => 'nullable|string|min:6',
            'role'        => 'required|in:admin,divisi',
            'division_id' => 'nullable|exists:divisions,id',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = [
            'name'        => $request->name,
            'email'       => $request->email,
            'role'        => $request->role,
            'division_id' => $request->division_id,
            'is_active'   => $request->has('is_active') ? (bool)$request->is_active : $user->is_active,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        ActivityLog::record('update_user', 'Admin memperbarui data user "' . $user->name . '"');

        return back()->with('success', "Data user {$user->name} berhasil diperbarui.");
    }

    /**
     * Toggle status aktif/nonaktif user.
     */
    public function toggleActive(User $user)
    {
        // Jangan bisa menonaktifkan sesama admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat mengubah status akun Admin.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        ActivityLog::record('toggle_user_status', "Admin {$status} akun user \"{$user->name}\"");

        return back()->with('success', "Akun {$user->name} berhasil {$status}.");
    }

    /**
     * Hapus user beserta semua file-nya.
     */
    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Tidak dapat menghapus akun Admin.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $name = $user->name;
        $user->delete();

        ActivityLog::record('delete_user', 'Admin menghapus akun user "' . $name . '"');

        return back()->with('success', "Akun {$name} berhasil dihapus.");
    }

    /**
     * Halaman audit log lengkap dengan berbagai filter (Action, User, Keyword).
     */
    public function auditLog(Request $request)
    {
        $search  = $request->input('search');
        $action  = $request->input('action');
        $userId  = $request->input('user_id');
        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = ActivityLog::with('user')->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'LIKE', '%' . $search . '%')
                  ->orWhere('ip_address', 'LIKE', '%' . $search . '%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%'));
            });
        }

        if ($action) {
            $query->where('action', $action);
        }

        if ($userId) {
            $query->where('user_id', $userId);
        }

        $logs = $query->paginate($perPage)->withQueryString();

        // Get list of all distinct actions in DB plus standard preset list
        $recordedActions = ActivityLog::select('action')->distinct()->pluck('action')->toArray();
        $defaultActions  = [
            'upload_file'        => 'Upload File',
            'delete_file'        => 'Hapus File',
            'create_folder'      => 'Buat Folder',
            'delete_folder'      => 'Hapus Folder',
            'rename_file'        => 'Rename File',
            'rename_folder'      => 'Rename Folder',
            'move_file'          => 'Pindah File',
            'move_folder'        => 'Pindah Folder',
            'create_user'        => 'Buat User',
            'update_user'        => 'Edit User',
            'toggle_user_status' => 'Status User',
            'delete_user'        => 'Hapus User',
            'login'              => 'Login',
            'logout'             => 'Logout',
        ];

        // Combine DB actions and presets nicely
        $actionOptions = [];
        foreach ($defaultActions as $key => $label) {
            $actionOptions[$key] = $label;
        }
        foreach ($recordedActions as $actKey) {
            if (!isset($actionOptions[$actKey])) {
                $actionOptions[$actKey] = ucfirst(str_replace('_', ' ', $actKey));
            }
        }

        $allUsers = User::orderBy('name')->get();

        return view('admin.logs.index', compact('logs', 'search', 'action', 'userId', 'perPage', 'actionOptions', 'allUsers'));
    }

    /**
     * Tampilkan daftar divisi (Division Management).
     */
    public function divisions(Request $request)
    {
        $search  = $request->input('search');
        $perPage = (int) $request->input('per_page', 10);

        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $query = Division::withCount(['users', 'folders', 'files'])
            ->withSum('files', 'size');

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $divisions = $query->orderBy('name')->paginate($perPage)->withQueryString();

        $totalDivisions = Division::count();
        $totalUsers     = User::count();
        $totalFiles     = \App\Models\File::count();

        return view('admin.divisions.index', compact('divisions', 'search', 'perPage', 'totalDivisions', 'totalUsers', 'totalFiles'));
    }

    /**
     * Tambah divisi baru (Create Division).
     */
    public function storeDivision(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:divisions,name',
        ], [
            'name.unique' => 'Nama divisi ini sudah ada di sistem.'
        ]);

        $division = Division::create([
            'name' => trim($request->name),
        ]);

        ActivityLog::record('create_division', 'Admin membuat divisi baru "' . $division->name . '"');

        return back()->with('success', "Divisi {$division->name} berhasil ditambahkan.");
    }

    /**
     * Edit/Update nama divisi (Update Division).
     */
    public function updateDivision(Request $request, Division $division)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('divisions')->ignore($division->id)],
        ], [
            'name.unique' => 'Nama divisi ini sudah ada di sistem.'
        ]);

        $oldName = $division->name;
        $division->update([
            'name' => trim($request->name),
        ]);

        ActivityLog::record('update_division', 'Admin memperbarui nama divisi "' . $oldName . '" → "' . $division->name . '"');

        return back()->with('success', "Nama divisi {$division->name} berhasil diperbarui.");
    }

    /**
     * Hapus divisi (Delete Division).
     */
    public function destroyDivision(Division $division)
    {
        if ($division->users()->count() > 0) {
            return back()->with('error', "Tidak dapat menghapus divisi \"{$division->name}\" karena masih memiliki user terdaftar.");
        }

        if ($division->files()->count() > 0 || $division->folders()->count() > 0) {
            return back()->with('error', "Tidak dapat menghapus divisi \"{$division->name}\" karena masih memiliki dokumen atau folder tersimpan.");
        }

        $name = $division->name;
        $division->delete();

        ActivityLog::record('delete_division', 'Admin menghapus divisi "' . $name . '"');

        return back()->with('success', "Divisi {$name} berhasil dihapus.");
    }
}

