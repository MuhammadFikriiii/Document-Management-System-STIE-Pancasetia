<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'original_name',
        'file_path',
        'size',
        'mime_type',
        'extension',
        'folder_id',
        'division_id',
        'visibility',
        'created_by'
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
