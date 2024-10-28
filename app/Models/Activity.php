<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ip_address', 'user_agent', 'last_activity',
        'last_login', 'last_logout'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Static method to handle post-creation cleanup
    public static function cleanupOldActivities($userId)
    {
        // Get the IDs of the newest 10 records that should not be deleted
        $idsToKeep = self::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->take(10)
            ->pluck('id');

        // Delete records for this user that are not in the above list of IDs to keep
        self::where('user_id', $userId)
            ->whereNotIn('id', $idsToKeep)
            ->delete();
    }
}
