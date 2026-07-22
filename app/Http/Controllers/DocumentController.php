<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DocumentController extends Controller
{
    public function index($folder_id = null)
    {
        $user = Auth::user();
        $divisionId = $user->division_id;

        $currentFolder = null;
        if ($folder_id) {
            $currentFolder = Folder::findOrFail($folder_id);
            // Optional: Check if user has access to this folder
        }

        // Fetch folders:
        // 1. Where division_id = user's division OR visibility = 'public'
        // 2. Where parent_id = $folder_id
        $folders = Folder::where(function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId)
                      ->orWhere('visibility', 'public');
            })
            ->where('parent_id', $folder_id)
            ->get();

        // Fetch files
        $files = File::where(function ($query) use ($divisionId) {
                $query->where('division_id', $divisionId)
                      ->orWhere('visibility', 'public');
            })
            ->where('folder_id', $folder_id)
            ->get();

        return view('divisi.documents.index', compact('folders', 'files', 'currentFolder'));
    }

    public function storeFolder(Request $request)
    {
        $divisionId = Auth::user()->division_id;

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
            'visibility' => 'required|in:private,public',
        ], [
            'name.unique' => 'A folder with this name already exists in this location.'
        ]);

        Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'division_id' => Auth::user()->division_id,
            'visibility' => $request->visibility,
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'Folder created successfully.');
    }

    public function storeFile(Request $request)
    {
        $divisionId = Auth::user()->division_id;
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
            'visibility' => 'required|in:private,public',
        ]);

        $uploadedFile = $request->file('file');
        $originalName = $uploadedFile->getClientOriginalName();
        $extension = $uploadedFile->getClientOriginalExtension();
        $mimeType = $uploadedFile->getMimeType();
        $size = $uploadedFile->getSize();

        $path = $uploadedFile->store('documents', 'public');

        File::create([
            'name' => pathinfo($originalName, PATHINFO_FILENAME),
            'original_name' => $originalName,
            'file_path' => $path,
            'size' => $size,
            'mime_type' => $mimeType,
            'extension' => $extension,
            'folder_id' => $request->folder_id,
            'division_id' => Auth::user()->division_id,
            'visibility' => $request->visibility,
            'created_by' => Auth::id(),
        ]);

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
            'visibility' => 'required|in:private,public',
        ]);

        $files = $request->file('files');
        $paths = $request->input('paths');
        $divisionId = Auth::user()->division_id;
        $userId = Auth::id();
        $visibility = $request->visibility;

        if (count($files) !== count($paths)) {
            return back()->with('error', 'Path data mismatch.');
        }

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
        // Ensure user belongs to the division that owns the folder
        if ($folder->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }
        $folder->delete();
        return back()->with('success', 'Folder deleted successfully.');
    }

    public function destroyFile($id)
    {
        $file = File::findOrFail($id);
        if ($file->division_id !== Auth::user()->division_id) {
            abort(403, 'Unauthorized action.');
        }
        // Optionally delete the physical file from storage
        // Storage::disk('public')->delete($file->file_path);
        
        $file->delete();
        return back()->with('success', 'File deleted successfully.');
    }

    public function updateFolder(Request $request, $id)
    {
        $folder = Folder::findOrFail($id);
        
        if ($folder->division_id !== Auth::user()->division_id) {
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
            'visibility' => 'required|in:private,public'
        ], [
            'name.unique' => 'A folder with this name already exists in this location.'
        ]);

        $folder->update([
            'name' => $request->name,
            'visibility' => $request->visibility
        ]);

        return back()->with('success', 'Folder updated successfully.');
    }

    public function updateFile(Request $request, $id)
    {
        $file = File::findOrFail($id);
        
        if ($file->division_id !== Auth::user()->division_id) {
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
            'visibility' => 'required|in:private,public'
        ], [
            'name.unique' => 'A file with this name already exists in this location.'
        ]);

        $file->update([
            'name' => $request->name, 
            'original_name' => $request->name . '.' . $file->extension,
            'visibility' => $request->visibility
        ]);

        return back()->with('success', 'File updated successfully.');
    }
}
