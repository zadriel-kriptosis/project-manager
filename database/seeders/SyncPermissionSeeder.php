<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class SyncPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve the boss role and log the result
        $bossRole = Role::where('name', 'boss')->first();
        if (!$bossRole) {
            Log::error('Boss role not found.');
            dd('Error: Boss role not found');
        } else {
            Log::info('Boss role found:', ['role' => $bossRole->toArray()]);
        }

        $bossPermissionNames = [
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
            'demandgallery-destroy'
        ];

        // Fetch the UUIDs of the specified permissions and log the result
        $bossPermissions = Permission::whereIn('name', $bossPermissionNames)->pluck('uuid');
        if ($bossPermissions->isEmpty()) {
            Log::error('No permissions found for boss.');
            dd('Error: No permissions found for boss');
        } else {
            Log::info('Permissions found for boss:', ['permissions' => $bossPermissions->toArray()]);
        }

        // Manually insert into role_has_permissions table
        $bossPermissions->each(function ($permissionUuid) use ($bossRole) {
            DB::table('role_has_permissions')->insert([
                'permission_uuid' => $permissionUuid,
                'role_uuid' => $bossRole->uuid,
            ]);
        });

        Log::info('Successfully inserted boss permissions into role_has_permissions table.');

        // Repeat similar logic for the employee role
        $employeeRole = Role::where('name', 'employee')->first();
        if (!$employeeRole) {
            Log::error('Employee role not found.');
            dd('Error: Employee role not found');
        } else {
            Log::info('Employee role found:', ['role' => $employeeRole->toArray()]);
        }

        $employeePermissionNames = [
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
            'demandgallery-destroy'
        ];

        // Fetch the UUIDs of the specified permissions and log the result
        $employeePermissions = Permission::whereIn('name', $employeePermissionNames)->pluck('uuid');
        if ($employeePermissions->isEmpty()) {
            Log::error('No permissions found for employee.');
            dd('Error: No permissions found for employee');
        } else {
            Log::info('Permissions found for employee:', ['permissions' => $employeePermissions->toArray()]);
        }

        // Manually insert into role_has_permissions table
        $employeePermissions->each(function ($permissionUuid) use ($employeeRole) {
            DB::table('role_has_permissions')->insert([
                'permission_uuid' => $permissionUuid,
                'role_uuid' => $employeeRole->uuid,
            ]);
        });

        Log::info('Successfully inserted employee permissions into role_has_permissions table.');
    }
}
