<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['id', 'name', 'description', 'company_id', 'is_active'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function demands()
    {
        return $this->hasMany(Demand::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withTimestamps()
            ->withPivot('is_active');
    }
}
