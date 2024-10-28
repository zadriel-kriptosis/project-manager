<?php

namespace App\Http\Controllers\User\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Str;
use Spatie\Permission\Middleware\PermissionMiddleware;

class indexController extends Controller implements HasMiddleware
{
    protected static string $model = 'company';

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

    public function show($slug)
    {
        // Find the company by its slug, or throw a 404 error if not found
        $company = Company::with(['owner', 'projects.users'])->where('slug', $slug)->firstOrFail();

        // Fetch employers (users associated with company's projects)
        $employers = $company->employers();

        // Check if the authenticated user is the company owner or an employer
        $user = auth()->user(); // Get the authenticated user

        if ($user->id !== $company->owner_id && !$employers->contains('id', $user->id)) {
            // If the user is neither the owner nor an employer, return 403 Forbidden
            abort(403, 'You do not have permission to view this company.');
        }

        // Calculate the counts
        $employeeCount = $employers->count();
        $projectCount = $company->projects->count();

        // Return the view with the company data
        return view('user.company.show', compact('company', 'employers', 'employeeCount', 'projectCount'));
    }



    public function create()
    {
        $model = self::$model;
        $page_title = 'Create ' . ucfirst($model);

        return view('user.' . $model . '.create', [
            'page_title' => $page_title,
            'model' => $model,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'description' => 'nullable|string',
        ]);

        // Generate the slug from the name
        $slug = Str::slug($request->input('name'));

        // Check if the slug is unique, and append a number if not
        $originalSlug = $slug;
        $counter = 1;
        while (Company::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Create the company
        $createdCompany = Company::create([
            'id' => Str::uuid(), // Generate a UUID for the company ID
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'slug' => $slug, // Use the generated slug
            'owner_id' => auth()->user()->id, // Set the owner to the authenticated user's ID
            'is_active' => true, // Default to true
        ]);

        // Redirect to the company index page with a success message
        return redirect()->route('user.company.show',['slug'=> $createdCompany['slug']])->with('success_message', 'Company created successfully!');
    }



}
