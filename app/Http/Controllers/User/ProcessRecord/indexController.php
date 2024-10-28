<?php

namespace App\Http\Controllers\User\ProcessRecord;

use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\ProcessRecord;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Illuminate\Support\Str;

class indexController extends Controller implements HasMiddleware
{
    protected static string $model = 'processrecord';

    public static function middleware(): array
    {
        $model = self::$model;
        return [
            'auth',
            new Middleware(PermissionMiddleware::using($model . '-list'), only: ['null']),
            new Middleware(PermissionMiddleware::using($model . '-create'), only: ['null', 'null']),
            new Middleware(PermissionMiddleware::using($model . '-edit'), only: ['edit', 'update']),
            new Middleware(PermissionMiddleware::using($model . '-destroy'), only: ['destroy']),
        ];
    }

    public function create(Request $request)
    {
        $demand = Demand::findOrFail($request->get('demand_id'));

        return view('user.processrecord.create', compact('demand'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'demand_id' => 'required|exists:demands,id',
            'after_status_id' => 'required|integer',
            'description' => 'nullable|string',

            // File validation: Only PDF, DOCX, and ZIP files, max size 10MB
            'file' => 'nullable|file|mimes:pdf,docx,zip|max:10240', // max 10MB

            // Image validation: Only JPEG, PNG, JPG, GIF, max size 10MB, dimensions limit
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240|dimensions:max_width=5000,max_height=5000', // max 10MB, max dimensions 5000x5000
        ]);

        // Find the demand
        $demand = Demand::findOrFail($validated['demand_id']);

        // Prepare the data for the new process record
        $processRecordData = [
            'demand_id' => $validated['demand_id'],
            'user_id' => auth()->id(),
            'before_status_id' => $demand->status_id, // Capture current status of the demand
            'after_status_id' => $validated['after_status_id'],
            'description' => $validated['description'] ?? null,
        ];

        // Handle file upload if provided (with UUID for filenames)
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension(); // Generate UUID filename
            $destinationPath = public_path('uploads/files'); // Define the path to public/uploads/files
            $file->move($destinationPath, $fileName); // Move file to public/uploads/files
            $processRecordData['file'] = 'uploads/files/' . $fileName; // Save relative file path
        }

        // Handle image upload if provided (with UUID for filenames)
        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $imageName = Str::uuid() . '.' . $image->getClientOriginalExtension(); // Generate UUID filename
            $destinationPath = public_path('uploads/images'); // Define the path to public/uploads/images
            $image->move($destinationPath, $imageName); // Move image to public/uploads/images
            $processRecordData['img'] = 'uploads/images/' . $imageName; // Save relative image path
        }



        // Save the process record using the validated data
        ProcessRecord::create($processRecordData);

        // Update the demand status
        $demand->update(['status_id' => $validated['after_status_id']]);

        // Redirect back to the demand show page with success message
        return redirect()->route('user.demand.show', $demand->id)
            ->with('success', 'Process record added successfully and demand status updated.');
    }}
