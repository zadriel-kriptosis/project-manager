<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;
    use HasUuids;
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    // multi language role display name
    // Usage:
    // $role = Role::find(1);
    // echo $role->display_name;
    public function getDisplayNameAttribute(): string
    {
        return __('roles.' . $this->name);
    }
}
