<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Shortcut helper to record an activity log entry.
     *
     * @param string $action      e.g. 'upload_file', 'delete_folder'
     * @param string $description Human-readable description
     */
    public static function record(string $action, string $description): void
    {
        static::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'description'=> $description,
            'ip_address' => request()->ip(),
        ]);
    }
}
