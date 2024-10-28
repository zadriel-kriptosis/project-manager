<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\ProjectUser;

class ProjectUserSeeder extends Seeder
{
    public function run()
    {
        // Get all users except the superadmin
        $users = User::where('username', '!=', 'superadmin')->get();

        // Get all projects
        $projects = Project::all();

        foreach ($projects as $project) {
            // Get the owner of the company that this project belongs to
            $companyOwner = $project->company->owner_id ?? null;

            // Assign the owner to the project (if they are not already assigned)
            if ($companyOwner) {
                ProjectUser::firstOrCreate([
                    'project_id' => $project->id,
                    'user_id' => $companyOwner,
                ], [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Exclude the owner from the users list to avoid assigning them again
            $availableUsers = $users->where('id', '!=', $companyOwner);

            // Randomly select 2 users from the available users
            $randomUsers = $availableUsers->random(2);

            // Assign the 2 random users to the project
            foreach ($randomUsers as $user) {
                ProjectUser::firstOrCreate([
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                ], [
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
