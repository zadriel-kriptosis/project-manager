<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcessRecord;
use App\Models\Demand;
use App\Models\ProjectUser;
use Illuminate\Support\Str;


class ProcessRecordSeeder extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        // Get all demands
        $demands = Demand::all();

        foreach ($demands as $demand) {
            // Get users assigned to the relevant project via pivot table
            $assignedUsers = $demand->project->users;

            // Check if there are assigned users for this demand's project
            if ($assignedUsers->isEmpty()) {
                continue; // Skip to the next demand if no users are assigned
            }

            // Choose a random user from the assigned users for this process record
            $user = $assignedUsers->random();

            // Define random file and image paths or null
            $filePaths = [null, 'uploads/files/testpdf1.pdf', 'uploads/files/testpdf2.pdf', 'uploads/files/testpdf.pdf'];
            $imgPaths = [null, 'uploads/images/testimg.jpg', 'uploads/images/testimg2.jpg', 'uploads/images/testimg1.jpg'];

            // Generate a random after_status_id
            $afterStatusId = $faker->numberBetween(0, 4);

            // Create a new process record
            ProcessRecord::create([
                'id' => Str::uuid(),
                'demand_id' => $demand->id,
                'user_id' => $user->id,
                'description' => $faker->optional()->paragraph, // Optional description
                'before_status_id' => $demand->status_id, // Get the current status of the demand
                'after_status_id' => $afterStatusId, // New status after the process (random between 0 and 4)
                'file' => $faker->randomElement($filePaths), // Randomly select a file path or null
                'img' => $faker->randomElement($imgPaths), // Randomly select an image path or null
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update the demand's status to the new after_status_id
            $demand->update([
                'status_id' => $afterStatusId,
            ]);
        }
    }
}
