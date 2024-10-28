<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    // multi language permission display name
    // Usage:
    // $permission = Permission::find(1);
    // echo $permission->display_name;
    public function getDisplayNameAttribute(): string
    {
        return __('permissions.' . $this->name);
    }
}
