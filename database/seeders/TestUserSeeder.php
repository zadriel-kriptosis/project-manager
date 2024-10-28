<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;

class TestUserSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Seed 9 users
        for ($i = 0; $i < 9; $i++) {
            $referralCode = Str::random(10);
            $role = Role::where('name', 'employee')->first();
            $createdTestUser = User::create([
                'id' => Str::uuid(),
                'username' => "user" . $i,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('user' . $i), // default password for all users
                'mnemonic' => $faker->text(200), // Random text for mnemonic
                'referral_code' => $referralCode,
                'referred_by' => null, // Adjust logic for referred_by if needed
                'login2fa_id' => 0, // Default 2FA option
                'is_active' => true,
                'remember_token' => Str::random(10),
                'banned_until' => null, // No ban initially
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $createdTestUser->roles()->attach($role->uuid);

        }
    }
}
