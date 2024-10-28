<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessRecord extends BaseModel
{
    protected $fillable = ['id', 'demand_id', 'user_id', 'description', 'before_status_id', 'after_status_id', 'file', 'img'];

    public function demand()
    {
        return $this->belongsTo(Demand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for before_status_name
    public function getBeforeStatusNameAttribute()
    {
        return $this->getStatusName($this->before_status_id);
    }

    // Accessor for after_status_name
    public function getAfterStatusNameAttribute()
    {
        return $this->getStatusName($this->after_status_id);
    }

    // Helper function to convert status ID to name
    private function getStatusName($statusId)
    {
        $statuses = [
            0 => 'Waiting Start',
            1 => 'Working',
            2 => 'Controlling',
            3 => 'Completed',
            4 => 'Cancelled'
        ];

        return $statuses[$statusId] ?? 'Unknown Status';
    }
}
