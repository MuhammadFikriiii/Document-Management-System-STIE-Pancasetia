<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use ZipArchive;

class PublicShareController extends Controller
{
    /**
     * Tampilkan isi folder publik.
     */
    public function showFolder(Request $request, $token, $folder_id = null)
    {
        $rootFolder = Folder::where('share_token', $token)->firstOrFail();
        
        $currentFolder = $rootFolder;
        if ($folder_id && $folder_id != $rootFolder->id) {
            $currentFolder = Folder::findOrFail($folder_id);
            
            // Verifikasi folder saat ini adalah turunan dari rootFolder
            if (!$this->isDescendant($currentFolder, $rootFolder)) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        $folders = Folder::where('parent_id', $currentFolder->id)->get();
        $files = File::where('folder_id', $currentFolder->id)->get();
        
        return view('public.share', compact('rootFolder', 'currentFolder', 'folders', 'files', 'token'));
    }

    /**
     * Pratinjau file di folder publik.
     */
    public function previewFile($token, $file_id)
    {
        $rootFolder = Folder::where('share_token', $token)->firstOrFail();
        $file = File::findOrFail($file_id);
        
        // Verifikasi file berada dalam turunan rootFolder
        if ($file->folder_id) {
            $fileFolder = Folder::find($file->folder_id);
            if (!$fileFolder || ($fileFolder->id != $rootFolder->id && !$this->isDescendant($fileFolder, $rootFolder))) {
                abort(403, 'Unauthorized action.');
            }
        } else {
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
     * Unduh file di folder publik.
     */
    public function downloadFile($token, $file_id)
    {
        $rootFolder = Folder::where('share_token', $token)->firstOrFail();
        $file = File::findOrFail($file_id);
        
        if ($file->folder_id) {
            $fileFolder = Folder::find($file->folder_id);
            if (!$fileFolder || ($fileFolder->id != $rootFolder->id && !$this->isDescendant($fileFolder, $rootFolder))) {
                abort(403, 'Unauthorized action.');
            }
        } else {
             abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404, 'File not found on server.');
        }

        return Storage::disk('public')->download($file->file_path, $file->original_name);
    }

    /**
     * Helper recursive check if a folder is descendant of another.
     */
    private function isDescendant($folder, $potentialAncestor)
    {
        $current = $folder->parent;
        while ($current) {
            if ($current->id === $potentialAncestor->id) {
                return true;
            }
            $current = $current->parent;
        }
        return false;
    }
}
