<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Demand;
use App\Models\ProjectUser;

class DemandSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Get all projects
        $projects = Project::all();

        foreach ($projects as $project) {
            // Get users assigned to this project from the pivot table (project_user)
            $assignedUsers = $project->users;

            // Helper function to assign demands
            $this->createDemandsForProject($project, $assignedUsers, $faker);
        }
    }

    private function createDemandsForProject($project, $assignedUsers, $faker)
    {
        // Ensure that we have users assigned to the project
        if ($assignedUsers->isEmpty()) {
            return; // Skip this project if no users are assigned
        }

        // Create demands based on the required distribution of status_id
        $statusDistribution = [
            0 => 3, // 3 demands with status_id = 0 (Waiting Start)
            1 => 2, // 2 demands with status_id = 1 (Working)
            2 => 2, // 2 demands with status_id = 2 (Controlling)
            3 => 2, // 2 demands with status_id = 3 (Completed)
            4 => 2  // 2 demands with status_id = 4 (Cancelled)
        ];

        foreach ($statusDistribution as $statusId => $count) {
            for ($i = 0; $i < $count; $i++) {
                // Select a random creator_id from users assigned to the project
                $creator = $assignedUsers->random();

                // Ensure the creator is assigned to the relevant project via pivot model (if not already)
                ProjectUser::firstOrCreate([
                    'project_id' => $project->id,
                    'user_id' => $creator->id,
                ], [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Create a new demand
                Demand::create([
                    'id' => \Illuminate\Support\Str::uuid(),
                    'creator_id' => $creator->id,
                    'title' => $faker->sentence(6), // Generates a random title with 6 words
                    'description' => $faker->optional()->paragraph, // Optional description
                    'project_id' => $project->id,
                    'status_id' => $statusId,
                    'type_id' => $faker->numberBetween(0, 3), // Random type_id (Bug, Development, Test, Other)
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
