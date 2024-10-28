<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Demand extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['id', 'creator_id', 'title', 'description', 'project_id', 'status_id', 'type_id'];

    // Accessor for status_name
    public function getStatusNameAttribute()
    {
        return $this->getStatusName($this->status_id);
    }

    // Accessor for type_name
    public function getTypeNameAttribute()
    {
        return $this->getTypeName($this->type_id);
    }

    // Helper function to convert status_id to human-readable status
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

    // Helper function to convert type_id to human-readable type
    private function getTypeName($typeId)
    {
        $types = [
            0 => 'Bug',
            1 => 'Development',
            2 => 'Test',
            3 => 'Other'
        ];

        return $types[$typeId] ?? 'Unknown Type';
    }

    // Method to get CSS class based on status_id
    public function getStatusCssClassAttribute()
    {
        $classes = [
            0 => 'text-gray-600 dark:text-gray-300',    // Waiting Start
            1 => 'text-orange-600 dark:text-orange-400', // Working
            2 => 'text-blue-600 dark:text-blue-400',     // Controlling
            3 => 'text-green-600 dark:text-green-400',   // Completed
            4 => 'line-through text-red-600 dark:text-gray-400', // Cancelled
        ];

        return $classes[$this->status_id] ?? 'text-gray-600 dark:text-gray-400';
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    // Relationship with DemandGallery (a demand has many images)
    public function gallery()
    {
        return $this->hasMany(DemandGallery::class, 'demand_id');
    }

    // Relationship with ProcessRecord (a demand has many process records)
    public function processRecords()
    {
        return $this->hasMany(ProcessRecord::class, 'demand_id');
    }
}
