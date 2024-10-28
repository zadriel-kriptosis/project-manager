<?php

namespace App\Http\Controllers\User\Demand;

use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Support\Str;
use App\Models\DemandGallery;

class indexController extends Controller implements HasMiddleware
{
    protected static string $model = 'demand';

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
        // Fetch the demand along with its gallery, process records (ordered by created_at DESC), and related project
        $demand = Demand::with([
            'gallery',
            'processRecords' => function ($query) {
                $query->orderBy('created_at', 'desc'); // Latest process records first
            },
            'processRecords.user',  // Eager load the user related to the process record
            'project'
        ])->findOrFail($id);

        return view('user.demand.show', compact('demand'));
    }

    public function create($project_id, $type_id)
    {
        // Find the project by its ID to ensure it exists
        $project = Project::findOrFail($project_id);

        // Map the type_id to human-readable type names
        $demandTypeNames = [
            0 => 'Bug',
            1 => 'Development',
            2 => 'Test',
            3 => 'Other'
        ];

        // Get the name of the demand type based on the type_id
        $demandTypeName = $demandTypeNames[$type_id] ?? 'Unknown';

        // Pass the necessary data to the view
        return view('user.demand.create', [
            'project' => $project,
            'project_id' => $project_id,
            'type_id' => $type_id,
            'demandTypeName' => $demandTypeName
        ]);
    }

    public function store(Request $request, $project_id, $type_id)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status_id' => 'required|integer|between:0,4',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096', // Validate multiple images
        ]);

        // Create the demand
        $demand = Demand::create([
            'creator_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'project_id' => $project_id,
            'status_id' => $request->status_id,
            'type_id' => $type_id,
        ]);

        // Handle image uploads with UUID filenames
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension(); // Generate UUID filename
                $destinationPath = public_path('uploads/demandgallery'); // Define the path to public/uploads/demandgallery
                $image->move($destinationPath, $imageName); // Move image to public/uploads/demandgallery

                // Save the relative path in the DemandGallery model
                DemandGallery::create([
                    'demand_id' => $demand->id,
                    'img' => 'uploads/demandgallery/' . $imageName, // Save relative image path
                ]);
            }
        }

        return redirect()->route('user.project.show', $project_id)->with('success', 'Demand created successfully.');
    }

    public function galleryadd(Request $request, $demand_id)
    {
        $demand = Demand::findOrFail($demand_id);

        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Validate multiple images
        ]);

        foreach ($request->file('images') as $image) {
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension(); // Generate UUID filename
            $destinationPath = public_path('uploads/demandgallery'); // Define the path to public/uploads/demandgallery
            $image->move($destinationPath, $imageName); // Move image to public/uploads/demandgallery

            // Save the relative path in the DemandGallery model
            DemandGallery::create([
                'demand_id' => $demand->id,
                'img' => 'uploads/demandgallery/' . $imageName, // Save relative image path
            ]);
        }

        return redirect()->route('user.demand.show', $demand->id)->with('success_message', 'Demand created successfully.');
    }

    public function galleryaddview(Request $request, $demand_id)
    {
        // Find the demand by its ID to ensure it exists
        $demand = Demand::findOrFail($demand_id);

        // Return a view, passing the demand data (or just the demand ID if you prefer)
        return view('user.demand.image', [
            'demand' => $demand, // Pass demand ID to the view
        ]);
    }

}
