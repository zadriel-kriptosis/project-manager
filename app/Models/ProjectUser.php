<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProjectUser extends BaseModel
{
    protected $table = 'project_user';
    protected $fillable = [
        'project_id',
        'user_id',
        'is_active',
    ];
}
