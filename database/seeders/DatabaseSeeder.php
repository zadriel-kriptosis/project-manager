<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(SyncPermissionSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(SuperAdminSeeder::class);
        $this->call(TestUserSeeder::class);

        $this->call(CompanySeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ProjectUserSeeder::class);
        $this->call(DemandSeeder::class);
        $this->call(ProcessRecordSeeder::class);
        $this->call(DemandGallerySeeder::class);
//        $this->call(AdminSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


    }
}
