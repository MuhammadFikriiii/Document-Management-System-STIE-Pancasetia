<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\File;
use App\Models\User;
use App\Models\Division;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use ZipArchive;
use Illuminate\Support\Facades\Response;

class DocumentController extends Controller
{
    public function index(Request $request, $folder_id = null)
    {
        $user       = Auth::user();
        $isAdmin    = $user->role === 'admin';
        $divisionId = $user->division_id;
        $search     = $request->input('search');

        $currentFolder = null;
        if ($folder_id) {
            $currentFolder = Folder::findOrFail($folder_id);
        }

        // Fetch folders for Move dropdown
        $allFolders = $isAdmin ? Folder::all() : Folder::where('division_id', $divisionId)->get();

        // Fetch folders query
        $folderQuery = Folder::query();
        if (!$isAdmin) {
            $folderQuery->where(function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId)
                      ->orWhere('visibility', 'public');
            });
        }

        if ($search) {
            $folderQuery->where('name', 'LIKE', '%' . $search . '%');
        } else {
            $folderQuery->where('parent_id', $folder_id);
        }

        $folders = $folderQuery->get();

        // Fetch files query
        $fileQuery = File::query();
        if (!$isAdmin) {
            $fileQuery->where(function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId)
                      ->orWhere('visibility', 'public');
            });
        }

        if ($search) {
            $fileQuery->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('original_name', 'LIKE', '%' . $search . '%');
            });
        } else {
            $fileQuery->where('folder_id', $folder_id);
        }

        $files = $fileQuery->get();

        return view('divisi.documents.index', compact('folders', 'files', 'currentFolder', 'allFolders', 'search'));
    }


    public function storeFolder(Request $request)
    {
        $divisionId = $this->resolveDivisionId($request->parent_id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('folders')->where(function ($query) use ($request, $divisionId) {
                    if (is_null($request->parent_id)) {
                        return $query->whereNull('parent_id')->where('division_id', $divisionId);
                    }
                    return $query->where('parent_id', $request->parent_id)
                                 ->where('division_id', $divisionId);
                })
            ],
            'parent_id' => 'nullable|exists:folders,id',
            'visibility' => 'nullable|in:private,public',
        ], [
            'name.unique' => 'A folder with this name already exists in this location.'
        ]);

        $folder = Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'division_id' => $divisionId,
            'visibility' => $request->input('visibility', 'public'),
            'created_by' => Auth::id(),
        ]);

        ActivityLog::record('create_folder', 'Membuat folder "' . $folder->name . '"');

        return back()->with('success', 'Folder created successfully.');
    }

    public function storeFile(Request $request)
    {
        $divisionId = $this->resolveDivisionId($request->folder_id);
        $originalName = $request->file('file') ? $request->file('file')->getClientOriginalName() : '';
        $fileNameNoExt = pathinfo($originalName, PATHINFO_FILENAME);

        $request->validate([
            'file' => [
                'required',
                'file',
                'max:10240',
                function ($attribute, $value, $fail) use ($request, $divisionId, $fileNameNoExt) {
                    if (str_starts_with($value->getMimeType(), 'video/')) {
                        $fail('File video tidak diperbolehkan.');
                    }
                    
                    $exists = File::where('folder_id', $request->folder_id)
                                  ->where('division_id', $divisionId)
                                  ->where('name', $fileNameNoExt)
                                  ->exists();
                    if ($exists) {
                        $fail('A file with this name already exists in this location.');
                    }
                }
            ],
            'folder_id' => 'nullable|exists:folders,id',
            'visibility' => 'nullable|in:private,public',
        ]);

        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->getClientOriginalExtension();
        $mimeType = $uploadedFile->getMimeType();
        $size = $uploadedFile->getSize();

        // Enforce 2 GB storage limit check per division
        $this->checkStorageLimit($size, $divisionId);

        $path = $uploadedFile->store('documents', 'public');

        $fileRecord = File::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'original_name' => $originalName,
            'file_path' => $path,
            'size' => $size,
            'mime_type' => $mimeType,
            'extension' => $extension,
            'folder_id' => $request->folder_id,
            'division_id' => $divisionId,
            'visibility' => $request->input('visibility', 'public'),
            'created_by' => Auth::id(),
        ]);

        ActivityLog::record('upload_file', 'Mengunggah file "' . $originalName . '" (' . round($size / 1024, 1) . ' KB)');

        return back()->with('success', 'File uploaded successfully.');
    }

    public function storeFolderUpload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => [
                'file',
                'max:10240',
                function ($attribute, $value, $fail) {
                    if (str_starts_with($value->getMimeType(), 'video/')) {
                        $fail('File video tidak diperbolehkan.');
                    }
                }
            ],
            'paths' => 'required|array',
            'parent_id' => 'nullable|exists:folders,id',
            'visibility' => 'nullable|in:private,public',
        ]);

        $files = $request->file('files');
        $paths = $request->input('paths');
        $divisionId = $this->resolveDivisionId($request->parent_id);
        $userId = Auth::id();
        $visibility = $request->input('visibility', 'public');

        if (count($files) !== count($paths)) {
            return back()->with('error', 'Path data mismatch.');
        }

        // Calculate total size of incoming folder upload
        $totalUploadSize = 0;
        foreach ($files as $f) {
            $totalUploadSize += $f->getSize();
        }

        // Enforce 2 GB storage limit check per division
        $this->checkStorageLimit($totalUploadSize, $divisionId);

        // Cache folder IDs during upload to prevent massive DB queries
        $folderCache = [];

        foreach ($files as $index => $uploadedFile) {
            $path = $paths[$index]; // e.g., "Folder/SubFolder/file.txt"
            $parts = explode('/', $path);
            $fileName = array_pop($parts); // Extract file name

            $currentParentId = $request->parent_id;

            // Reconstruct the folder hierarchy
            $pathTracker = '';
            foreach ($parts as $folderName) {
                $pathTracker .= '/' . $folderName;
                
                $cacheKey = $currentParentId . '_' . $pathTracker;

                if (isset($folderCache[$cacheKey])) {
                    $currentParentId = $folderCache[$cacheKey];
                } else {
                    $folder = Folder::firstOrCreate(
                        [
                            'name' => $folderName,
                            'parent_id' => $currentParentId,
                            'division_id' => $divisionId
                        ],
                        [
                            'visibility' => $visibility,
                            'created_by' => $userId,
                        ]
                    );
                    $currentParentId = $folder->id;
                    $folderCache[$cacheKey] = $folder->id;
                }
            }

            // Save the actual file
            $originalName = $uploadedFile->getClientOriginalName(); // Or use $fileName
            $extension = $uploadedFile->getClientOriginalExtension();
            $mimeType = $uploadedFile->getMimeType();
            $size = $uploadedFile->getSize();

            $storagePath = $uploadedFile->store('documents', 'public');

            File::create([
                'name' => pathinfo($originalName, PATHINFO_FILENAME),
                'original_name' => $originalName,
                'file_path' => $storagePath,
                'size' => $size,
                'mime_type' => $mimeType,
                'extension' => $extension,
                'folder_id' => $currentParentId,
                'division_id' => $divisionId,
                'visibility' => $visibility,
                'created_by' => $userId,
            ]);
        }

        return back()->with('success', 'Folder structure uploaded successfully.');
    }

    public function destroyFolder($id)
    {
        $folder = Folder::findOrFail($id);
        if (Auth::user()->role !== 'admin' && $folder->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }
        $folderName = $folder->name;
        $folder->delete();
        ActivityLog::record('delete_folder', 'Menghapus folder "' . $folderName . '"');
        return back()->with('success', 'Folder deleted successfully.');
    }

    public function destroyFile($id)
    {
        $file = File::findOrFail($id);
        if (Auth::user()->role !== 'admin' && $file->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }
        // Optionally delete the physical file from storage
        // Storage::disk('public')->delete($file->file_path);
        
        $fileName = $file->original_name;
        $file->delete();
        ActivityLog::record('delete_file', 'Menghapus file "' . $fileName . '"');
        return back()->with('success', 'File deleted successfully.');
    }

    public function updateFolder(Request $request, $id)
    {
        $folder = Folder::findOrFail($id);
        
        if (Auth::user()->role !== 'admin' && $folder->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('folders')->where(function ($query) use ($folder) {
                    if (is_null($folder->parent_id)) {
                        return $query->whereNull('parent_id')->where('division_id', $folder->division_id);
                    }
                    return $query->where('parent_id', $folder->parent_id)
                                 ->where('division_id', $folder->division_id);
                })->ignore($folder->id)
            ],
            'visibility' => 'nullable|in:private,public'
        ], [
            'name.unique' => 'A folder with this name already exists in this location.'
        ]);

        $oldName = $folder->name;
        $folder->update([
            'name' => $request->name,
            'visibility' => $request->input('visibility', 'public')
        ]);

        ActivityLog::record('rename_folder', 'Mengganti nama folder "' . $oldName . '" → "' . $request->name . '"');

        return back()->with('success', 'Folder updated successfully.');
    }

    public function updateFile(Request $request, $id)
    {
        $file = File::findOrFail($id);
        
        if (Auth::user()->role !== 'admin' && $file->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('files')->where(function ($query) use ($file) {
                    if (is_null($file->folder_id)) {
                        return $query->whereNull('folder_id')->where('division_id', $file->division_id);
                    }
                    return $query->where('folder_id', $file->folder_id)
                                 ->where('division_id', $file->division_id);
                })->ignore($file->id)
            ],
            'visibility' => 'nullable|in:private,public'
        ], [
            'name.unique' => 'A file with this name already exists in this location.'
        ]);

        $oldName = $file->original_name;
        $file->update([
            'name' => $request->name, 
            'original_name' => $request->name . '.' . $file->extension,
            'visibility' => $request->input('visibility', 'public')
        ]);

        ActivityLog::record('rename_file', 'Mengganti nama file "' . $oldName . '" → "' . $request->name . '.' . $file->extension . '"');

        return back()->with('success', 'File updated successfully.');
    }

    /**
     * Move a folder to a different parent.
     */
    public function moveFolder(Request $request, $id)
    {
        $folder = Folder::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $folder->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        // Prevent moving folder into itself or its descendants
        $newParentId = $request->parent_id ?: null;
        if ($newParentId) {
            $newParent = Folder::findOrFail($newParentId);
            // Walk up the new parent's ancestors to ensure it's not a descendant
            $ancestor = $newParent;
            while ($ancestor) {
                if ($ancestor->id == $folder->id) {
                    return back()->with('error', 'Cannot move a folder into itself or its subfolder.');
                }
                $ancestor = $ancestor->parent;
            }
        }

        $folder->update(['parent_id' => $newParentId]);

        ActivityLog::record('move_folder', 'Memindahkan folder "' . $folder->name . '"');

        return back()->with('success', 'Folder moved successfully.');
    }

    /**
     * Move a file to a different folder.
     */
    public function moveFile(Request $request, $id)
    {
        $file = File::findOrFail($id);

        if (Auth::user()->role !== 'admin' && $file->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $file->update(['folder_id' => $request->folder_id ?: null]);

        ActivityLog::record('move_file', 'Memindahkan file "' . $file->original_name . '"');

        return back()->with('success', 'File moved successfully.');
    }

    /**
     * Download a single file.
     */
    public function downloadFile($id)
    {
        $file = File::findOrFail($id);
        $user = Auth::user();

        // Check access: admin, own division, or public
        if ($user->role !== 'admin' && $file->division_id !== $user->division_id && $file->visibility !== 'public') {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File not found on server.');
        }

        return Storage::disk('public')->download($file->file_path, $file->original_name);
    }

    /**
     * Download a folder and all its contents as a ZIP file.
     */
    public function downloadFolderZip($id)
    {
        $folder = Folder::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin' && $folder->division_id !== $user->division_id && $folder->visibility !== 'public') {
            abort(403, 'Unauthorized action.');
        }

        $zipFileName = $folder->name . '_' . now()->format('Ymd_His') . '.zip';
        $zipFilePath = storage_path('app/temp/' . $zipFileName);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new ZipArchive();
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            return back()->with('error', 'Could not create ZIP file.');
        }

        // Recursively add files from folder and subfolders
        $this->addFolderToZip($zip, $folder, $folder->name);

        $zip->close();

        // Stream and delete temp file after download
        return Response::download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }

    /**
     * Recursively add folder contents to a ZipArchive.
     */
    private function addFolderToZip(ZipArchive $zip, Folder $folder, string $zipPath): void
    {
        // Add files in this folder
        foreach ($folder->files as $file) {
            $storagePath = Storage::disk('public')->path($file->file_path);
            if (file_exists($storagePath)) {
                $zip->addFile($storagePath, $zipPath . '/' . $file->original_name);
            }
        }

        // Recurse into subfolders
        foreach ($folder->children as $subFolder) {
            $this->addFolderToZip($zip, $subFolder, $zipPath . '/' . $subFolder->name);
        }
    }

    /**
     * Stream a file inline (for in-browser preview).
     * Uses Laravel response so URL is always relative to the current host:port,
     * avoiding the Apache/port-80 mismatch issue with Storage::url().
     */
    public function previewFile($id)
    {
        $file = File::findOrFail($id);
        $user = Auth::user();

        if ($user->role !== 'admin' && $file->division_id !== $user->division_id && $file->visibility !== 'public') {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File not found on server.');
        }

        $storagePath = Storage::disk('public')->path($file->file_path);

        return Response::file($storagePath, [
            'Content-Type'        => $file->mime_type,
            'Content-Disposition' => 'inline; filename="' . $file->original_name . '"',
        ]);
    }

    /**
     * Tampilkan Halaman Sampah / Recycle Bin.
     */
    public function trash(Request $request)
    {
        $user       = Auth::user();
        $isAdmin    = $user->role === 'admin';
        $divisionId = $user->division_id;
        $search     = $request->input('search');

        $folderQuery = Folder::onlyTrashed();
        $fileQuery   = File::onlyTrashed();

        if (!$isAdmin) {
            $folderQuery->where('division_id', $divisionId);
            $fileQuery->where('division_id', $divisionId);
        }

        if ($search) {
            $folderQuery->where('name', 'LIKE', '%' . $search . '%');
            $fileQuery->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('original_name', 'LIKE', '%' . $search . '%');
            });
        }

        $trashedFolders = $folderQuery->orderBy('deleted_at', 'desc')->get();
        $trashedFiles   = $fileQuery->orderBy('deleted_at', 'desc')->get();

        return view('divisi.documents.trash', compact('trashedFolders', 'trashedFiles', 'search'));
    }

    /**
     * Restore folder from Trash.
     */
    public function restoreFolder($id)
    {
        $folder = Folder::onlyTrashed()->findOrFail($id);
        if (Auth::user()->role !== 'admin' && $folder->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $folder->restore();

        // Restore child files
        File::onlyTrashed()->where('folder_id', $folder->id)->restore();

        ActivityLog::record('restore_folder', 'Memulihkan folder "' . $folder->name . '" dari Sampah');

        return back()->with('success', 'Folder berhasil dipulihkan.');
    }

    /**
     * Restore file from Trash.
     */
    public function restoreFile($id)
    {
        $file = File::onlyTrashed()->findOrFail($id);
        if (Auth::user()->role !== 'admin' && $file->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $file->restore();

        ActivityLog::record('restore_file', 'Memulihkan file "' . $file->original_name . '" dari Sampah');

        return back()->with('success', 'File berhasil dipulihkan.');
    }

    /**
     * Force Delete (Permanent delete) folder.
     */
    public function forceDeleteFolder($id)
    {
        $folder = Folder::onlyTrashed()->findOrFail($id);
        if (Auth::user()->role !== 'admin' && $folder->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $name = $folder->name;

        // Force delete child files and physical files
        $childFiles = File::withTrashed()->where('folder_id', $folder->id)->get();
        foreach ($childFiles as $f) {
            Storage::disk('public')->delete($f->file_path);
            $f->forceDelete();
        }

        $folder->forceDelete();

        ActivityLog::record('force_delete_folder', 'Menghapus permanen folder "' . $name . '"');

        return back()->with('success', 'Folder berhasil dihapus secara permanen.');
    }

    /**
     * Force Delete (Permanent delete) file.
     */
    public function forceDeleteFile($id)
    {
        $file = File::onlyTrashed()->findOrFail($id);
        if (Auth::user()->role !== 'admin' && $file->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }

        $name = $file->original_name;
        Storage::disk('public')->delete($file->file_path);
        $file->forceDelete();

        ActivityLog::record('force_delete_file', 'Menghapus permanen file "' . $name . '"');

        return back()->with('success', 'File berhasil dihapus secara permanen.');
    }

    /**
     * Empty all trashed items in user's scope.
     */
    public function emptyTrash()
    {
        $user       = Auth::user();
        $isAdmin    = $user->role === 'admin';
        $divisionId = $user->division_id;

        $fileQuery   = File::onlyTrashed();
        $folderQuery = Folder::onlyTrashed();

        if (!$isAdmin) {
            $fileQuery->where('division_id', $divisionId);
            $folderQuery->where('division_id', $divisionId);
        }

        $files = $fileQuery->get();
        foreach ($files as $f) {
            Storage::disk('public')->delete($f->file_path);
            $f->forceDelete();
        }

        $folders = $folderQuery->get();
        foreach ($folders as $fold) {
            $fold->forceDelete();
        }

        ActivityLog::record('empty_trash', 'Mengosongkan Sampah / Recycle Bin');

        return back()->with('success', 'Sampah berhasil dikosongkan secara permanen.');
    }

    /**
     * Halaman Dashboard khusus Divisi.
     */
    public function divisiDashboard()
    {
        $user       = Auth::user();
        $divisionId = $user->division_id;

        $totalFiles   = File::where('division_id', $divisionId)->count();
        $totalFolders = Folder::where('division_id', $divisionId)->count();
        $totalStorage = File::where('division_id', $divisionId)->sum('size');
        $publicFiles  = File::where('division_id', $divisionId)->where('visibility', 'public')->count();

        $maxStorage = env('MAX_STORAGE_GB', 50) * 1024 * 1024 * 1024; // Default 50 GB
        $storagePct = min(100, round(($totalStorage / $maxStorage) * 100, 1));

        $divisionUserIds = $divisionId ? User::where('division_id', $divisionId)->pluck('id') : [$user->id];
        $recentLogs      = ActivityLog::with('user')
            ->whereIn('user_id', $divisionUserIds)
            ->latest()
            ->take(5)
            ->get();


        $recentFiles = File::with('creator')
            ->where('division_id', $divisionId)
            ->latest()
            ->take(5)
            ->get();

        return view('divisi.dashboard', compact(
            'user', 'totalFiles', 'totalFolders', 'totalStorage',
            'publicFiles', 'storagePct', 'recentLogs', 'recentFiles'
        ));
    }

    /**
     * Resolve division_id safely for uploads/folders (user division, target folder division, or fallback division).
     */
    private function resolveDivisionId(?int $folderId = null): ?int
    {
        $user = Auth::user();
        if ($user && $user->division_id) {
            return $user->division_id;
        }

        if ($folderId) {
            $folder = Folder::find($folderId);
            if ($folder && $folder->division_id) {
                return $folder->division_id;
            }
        }

        return Division::first()?->id;
    }

    /**
     * Check if upload exceeds 50 GB division storage limit.
     */
    private function checkStorageLimit(int $incomingBytes, ?int $divisionId = null): void
    {
        if (!$divisionId) {
            $divisionId = Auth::user()->division_id;
        }
        if (!$divisionId || Auth::user()->role === 'admin') return;

        $limitGB = env('MAX_STORAGE_GB', 50);
        $limitBytes  = $limitGB * 1024 * 1024 * 1024; // Default 50 GB limit per division
        $currentUsed = File::where('division_id', $divisionId)->sum('size');

        if (($currentUsed + $incomingBytes) > $limitBytes) {
            $usedGB = round($currentUsed / 1073741824, 2);
            abort(422, "Kapasitas penyimpanan divisi Anda ({$usedGB} GB / {$limitGB} GB) telah penuh. Harap hapus file yang tidak terpakai dari Sampah.");
        }
    }
}




