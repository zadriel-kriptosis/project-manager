<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends BaseModel
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'key',
        'value',
    ];

}
