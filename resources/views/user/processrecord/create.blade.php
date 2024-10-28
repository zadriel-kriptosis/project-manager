@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-lg">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Add New Process Record</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">For Demand: {{ $demand->title }}</p>

            <!-- Process Record Form -->
            <form action="{{ route('user.processrecord.store') }}" method="POST" enctype="multipart/form-data"
                  class="mt-6">
                @csrf
                <input type="hidden" name="demand_id" value="{{ $demand->id }}">

                @if ($errors->any())
                    <div class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400 p-4 rounded-lg mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- After Status -->
                <div class="mb-4">
                    <label for="after_status_id" class="block text-sm font-medium text-gray-800 dark:text-gray-300">
                        Updated Status
                    </label>
                    <select name="after_status_id" id="after_status_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 rounded-md shadow-sm">
                        <option value="0" {{ $demand->status_id == 0 ? 'selected' : '' }}>Waiting Start</option>
                        <option value="1" {{ $demand->status_id == 1 ? 'selected' : '' }}>Working</option>
                        <option value="2" {{ $demand->status_id == 2 ? 'selected' : '' }}>Controlling</option>
                        <option value="3" {{ $demand->status_id == 3 ? 'selected' : '' }}>Completed</option>
                        <option value="4" {{ $demand->status_id == 4 ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-800 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 rounded-md shadow-sm"
                              placeholder="Enter process details here..."></textarea>
                </div>

                <!-- File Upload -->
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-800 dark:text-gray-300">
                        Upload File [OPTIONAL] <span class="text-gray-600 dark:text-gray-400 text-xs">(Supported: PDF, DOCX, ZIP, max 10MB)</span>
                    </label>
                    <input type="file" name="file" id="file"
                           class="mt-3 block w-full text-gray-900 dark:text-gray-300 dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label for="img" class="block text-sm font-medium text-gray-800 dark:text-gray-300">
                        Upload Image [OPTIONAL] <span class="text-gray-600 dark:text-gray-400 text-xs">(Supported: JPEG, PNG, JPG, GIF, max 10MB)</span>
                    </label>
                    <input type="file" name="img" id="img" accept="image/*"
                           class="mt-3 block w-full text-gray-900 dark:text-gray-300 dark:bg-gray-800 border-gray-300 dark:border-gray-600 rounded-md shadow-sm">
                </div>

                <!-- Submit Button -->
                <div class="mt-6 text-right">
                    <a href="{{ route('user.demand.show', $demand->id) }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary ml-2">Submit Process Record</button>
                </div>
            </form>
        </div>
    </div>
@endsection
