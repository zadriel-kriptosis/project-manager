@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            <a href="{{ route('user.company.show', $project->company->slug) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $project->company->name }}</a>
            >
            <a href="{{ route('user.project.show', $project->id) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $project->name }}</a>
            >
            <span>Create {{ $demandTypeName }} Demand</span>
        </nav>

        <!-- Demand Creation Header -->
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Create New {{ $demandTypeName }} Demand</h2>

            <!-- Show validation errors if any -->
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400 p-4 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Create Demand Form -->
            <form action="{{ route('user.demand.store', ['project_id' => $project_id, 'type_id' => $type_id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Demand Title -->
                <div class="mb-6">
                    <label for="title" class="block text-gray-700 dark:text-gray-300">Demand Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" placeholder="Enter demand title" required>
                </div>

                <!-- Demand Description -->
                <div class="mb-6">
                    <label for="description" class="block text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" placeholder="Enter demand description" required></textarea>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label for="status" class="block text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status_id" id="status" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                        <option value="0">Waiting Start</option>
                        <option value="1">Working</option>
                        <option value="2">Controlling</option>
                        <option value="3">Completed</option>
                        <option value="4">Cancelled</option>
                    </select>
                </div>

                <!-- Image Upload Section (Multiple Image Upload) -->
                <div class="mb-6">
                    <label for="gallery" class="block text-gray-700 dark:text-gray-300">Add Images - (You can choose multiple images with CTRL + Click) - [OPTIONAL]</label>
                    <input type="file" name="images[]" multiple class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white mt-2" accept="image/*">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-4">
                    <a href="{{route('user.project.show', ['id' => $project->id])}}" class="btn-secondary">Go Back Project</a>
                    <button type="submit" class="btn-primary">Create Demand</button>
                </div>
            </form>
        </div>
    </div>
@endsection
