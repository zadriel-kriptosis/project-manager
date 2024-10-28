<?php

namespace App\Http\Controllers\User\Project;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Http\Request;

class indexController extends Controller implements HasMiddleware
{
    protected static string $model = 'project';

    public static function middleware(): array
    {
        $model = self::$model;
        return [
            'auth',
            new Middleware(PermissionMiddleware::using($model . '-list'), only: ['null']),
            new Middleware(PermissionMiddleware::using($model . '-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using($model . '-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using($model . '-destroy'), only: ['destroy']),
        ];
    }

    public function show($id)
    {
        // Find the project by its ID or throw a 404 error if not found
        $project = Project::with(['company', 'users', 'demands'])->findOrFail($id);

        // Get the authenticated user
        $user = auth()->user();

        // Check if the authenticated user is either the company owner or assigned to the project
        if ($user->id !== $project->company->owner_id && !$project->users->contains('id', $user->id)) {
            // If the user is neither the company owner nor assigned to the project, return 403 Forbidden
            abort(403, 'You do not have permission to view this project.');
        }

        // Define the status order
        $statuses = [
            0 => 'Waiting Start',
            1 => 'Working',
            2 => 'Controlling',
            3 => 'Completed',
            4 => 'Cancelled'
        ];

        // Group demands by their type and sort by status in the order of $statuses
        $demands = $project->demands
            ->sortBy(function ($demand) use ($statuses) {
                return array_search($demand->status_id, array_keys($statuses));
            })
            ->groupBy('type_id'); // Grouping after sorting

        // Return the view with the project and demands data
        return view('user.project.show', compact('project', 'demands'));
    }

    public function create(Company $company)
    {
        // Check if the authenticated user is the owner of the company
        if ($company->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this company.');
        }

        return view('user.project.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
//            'is_active' => 'sometimes|boolean',
        ]);

        // Ensure the authenticated user is the owner of the company
        if ($company->owner_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Create the project linked to the company
        $createdProject = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => $company->id,
//            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        ProjectUser::create([
            'project_id' => $createdProject->id,
            'user_id' => $company->owner_id ,
            'is_active' => true,
        ]);

        return redirect()->route('user.company.show', $company->slug)->with('success', 'Project created successfully!');
    }


    public function adduser(Request $request, $project_id)
    {
        // Validate the username input
        $request->validate([
            'username' => 'required|string|exists:users,username',
        ]);

        // Find the user by username
        $user = User::where('username', $request->username)->firstOrFail();

        // Fetch the project by project_id
        $project = Project::findOrFail($project_id);

        // Check if the user is already added to the project
        if ($project->users()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'User is already assigned to this project.');
        }

        // Use ProjectUser to handle the pivot table insertion with UUID
        ProjectUser::create([
            'project_id' => $project->id,
            'user_id' => $user->id,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'User added to project successfully.');
    }

    // Remove user from the project
    public function deleteuser($project_id, $user_id)
    {
        // Fetch the project by the project_id
        $project = Project::findOrFail($project_id);

        // Check if the authenticated user is the owner of the company
        if (auth()->id() !== $project->company->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if the user is associated with the project
        if ($project->users()->where('user_id', $user_id)->exists()) {
            // Detach the user from the project
            $project->users()->detach($user_id);

            return redirect()->back()->with('success', 'User removed from project successfully.');
        }

        return redirect()->back()->with('error', 'User is not associated with this project.');
    }
}
