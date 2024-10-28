<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        $users = User::where('username', '!=', 'superadmin')->get();

        $owners = $users->random(5);

        $companyNames = [
            'NeuraCorp',
            'ZeroVoid Corporation',
            'VoidNet Systems',
            'Eclipsion Holdings',
            'Umbra Dynamics'
        ];

        foreach ($owners as $index => $owner) {
            Company::create([
                'id' => Str::uuid(),
                'name' => $companyNames[$index],
                'description' => $faker->optional()->paragraph,
                'slug' => Str::slug($companyNames[$index]),
                'owner_id' => $owner->id,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
