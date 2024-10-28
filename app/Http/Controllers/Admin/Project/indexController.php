<?php

namespace App\Http\Controllers\Admin\Project;

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
            new Middleware(PermissionMiddleware::using($model . '-list'), only: ['show']),
            new Middleware(PermissionMiddleware::using($model . '-create'), only: ['create', 'store']),
            new Middleware(PermissionMiddleware::using($model . '-edit'), only: ['edit', 'update','adduser']),
            new Middleware(PermissionMiddleware::using($model . '-destroy'), only: ['destroy','deleteuser']),
        ];
    }

    public function show($id)
    {
        // Find the project by its ID or throw a 404 error if not found
        $project = Project::with(['company', 'users', 'demands'])->findOrFail($id);

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

        return view('admin.project.show', compact('project', 'demands'));
    }

    public function create(Company $company)
    {
//        // Check if the authenticated user is the owner of the company
//        if ($company->owner_id !== auth()->id()) {
//            abort(403, 'Unauthorized access to this company.');
//        }

        return view('admin.project.create', compact('company'));
    }

    public function store(Request $request, Company $company)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
//            'is_active' => 'sometimes|boolean',
        ]);

//        // Ensure the authenticated user is the owner of the company
//        if ($company->owner_id !== auth()->id()) {
//            abort(403, 'Unauthorized action.');
//        }

        // Create the project linked to the company
        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'company_id' => $company->id,
//            'is_active' => $request->has('is_active') ? $request->is_active : true,
        ]);

        return redirect()->route('admin.company.show', $company->slug)->with('success', 'Project created successfully!');
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

        // Check if the user is associated with the project
        if ($project->users()->where('user_id', $user_id)->exists()) {
            // Detach the user from the project
            $project->users()->detach($user_id);

            return redirect()->back()->with('success', 'User removed from project successfully.');
        }

        return redirect()->back()->with('error', 'User is not associated with this project.');
    }
}
