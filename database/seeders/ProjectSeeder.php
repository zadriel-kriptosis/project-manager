<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Company;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Get all companies
        $companies = Company::all();

        // Predefined project names
        $projectNames = [
            'Project Nullwave',
            'Directive VoidSignal',
            'Operation Blackout',
            'Protocol Nightfall',
            'Project CryoNet',
            'Project Grimwire',
            'Initiative CryoSync',
            'Project Neurovoid',
            'Directive Quantum',
            'Operation Darkfiber',
            'Project Etherlock',
            'Protocol Mindlock',
            'Project Synapse',
            'Project BlackVortex',
            'Operation ZeroCore'
        ];

        // Seed 15 projects with predefined names
        foreach ($projectNames as $name) {
            // Pick a random company_id from the companies or null
            $company = $companies->random();

            Project::create([
                'id' => Str::uuid(),
                'name' => $name, // Use predefined project names
                'description' => $faker->optional()->paragraph,
                'company_id' => $company->id ?? null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
