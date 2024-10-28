<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['id', 'name', 'description', 'slug', 'owner_id', 'is_active'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function employers()
    {
        return User::whereHas('projects', function ($query) {
            $query->where('company_id', $this->id);
        })
            ->where('id', '!=', $this->owner_id) // Exclude the owner
            ->distinct()
            ->get();
    }

}
