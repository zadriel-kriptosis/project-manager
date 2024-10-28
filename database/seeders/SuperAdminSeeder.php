<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utilities\Mnemonic\Mnemonic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Log::debug('Starting SuperAdminSeeder.');

        $this->command->info('Creating super admin account...');
        $superAdminPassword = 'superadmin';
        $hashedPassword = Hash::make($superAdminPassword);
        $mnemonic_length = 12;
        $mnemonic = (new Mnemonic())->generate($mnemonic_length);
        $superAdmin = new User();
        $superAdmin->username = 'superadmin';
        $superAdmin->password = $hashedPassword;
        $superAdmin->mnemonic = bcrypt(hash('sha256', $mnemonic));
        $superAdmin->login2fa_id = 0;
        $superAdmin->referral_code = strtoupper(Str::random(6));
        $superAdmin->save();

        Log::info('Super admin created', ['id' => $superAdmin->id, 'username' => $superAdmin->username]);

        // Retrieve role by name
        $role = Role::where('name', 'super_admin')->first();
        if (!$role) {
            $this->command->error('Role super_admin not found.');
            Log::error('Role super_admin not found.');
            return;
        }

        Log::info('Role retrieved', ['role_id' => $role->uuid, 'role_name' => $role->name]);

        // Fetch all permissions dynamically
        $permissions = Permission::all();

        if ($permissions->isEmpty()) {
            $this->command->error('Permissions not found.');
            Log::error('Permissions not found.');
            return;
        } else {
            $this->command->info('Permissions found: ' . $permissions->count());
            Log::info('Permissions details', $permissions->pluck('name', 'uuid')->toArray());
        }

        $permissionUUIDs = $permissions->pluck('uuid')->toArray();

        Log::debug('Syncing permissions to role', ['role_id' => $role->uuid, 'permissions' => $permissionUUIDs]);
        Log::debug('Permissions UUIDs to sync', ['uuids' => $permissionUUIDs]);

        DB::beginTransaction();
        try {
            // Sync permissions to the role
            foreach ($permissionUUIDs as $permissionUUID) {
                DB::table('role_has_permissions')->insert([
                    'permission_uuid' => $permissionUUID,
                    'role_uuid' => $role->uuid,
                ]);
            }

            // Assign role to super admin
            DB::table('model_has_roles')->insert([
                'role_uuid' => $role->uuid,
                'model_uuid' => $superAdmin->id,
                'model_type' => User::class,
            ]);

            DB::commit();
            $this->command->info('Successfully assigned role and permissions to superadmin.');
            Log::info('Assigned role and permissions successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to assign role and permissions', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permissions' => $permissionUUIDs,
                'role_uuid' => $role->uuid,
                'superadmin_id' => $superAdmin->id,
            ]);
            $this->command->error('Error assigning role and permissions. Check logs for details.');
        }
    }
}
