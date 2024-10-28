<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions =
            [
                'activity-list',
                'activity-create',
                'activity-edit',
                'activity-destroy',

                'user-list',
                'user-create',
                'user-edit',
                'user-destroy',
                'user-ban',

                'setting-list',
                'setting-create',
                'setting-edit',
                'setting-destroy',

                'permission-list',
                'permission-create',
                'permission-edit',
                'permission-destroy',

                'role-list',
                'role-create',
                'role-edit',
                'role-destroy',

                'company-list',
                'company-create',
                'company-edit',
                'company-destroy',

                'project-list',
                'project-create',
                'project-edit',
                'project-destroy',

                'demand-list',
                'demand-create',
                'demand-edit',
                'demand-destroy',

                'processrecord-list',
                'processrecord-create',
                'processrecord-edit',
                'processrecord-destroy',

                'demandgallery-list',
                'demandgallery-create',
                'demandgallery-edit',
                'demandgallery-destroy',
            ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
