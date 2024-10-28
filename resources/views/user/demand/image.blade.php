@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <!-- Demand Creation Header -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-lg shadow-md">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Add Images to {{ $demand->title }} Demand</h2>

            <!-- Show validation errors if any -->
            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-400 p-4 rounded-lg mb-6">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Image Upload Form -->
            <form action="{{ route('user.demand.galleryadd', ['demand_id' => $demand->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Image Upload Section -->
                <div>
                    <label for="gallery" class="block text-lg font-medium text-gray-700 dark:text-gray-300 mb-2">Add Images</label>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">You can select multiple images (Ctrl + Click or Cmd + Click).</p>
                    <input type="file" name="images[]" id="gallery" multiple
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:ring-indigo-300 dark:focus:border-indigo-300"
                           accept="image/*">
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end gap-3">
                    <a href="{{route('user.demand.show', ['id' => $demand->id])}}" class="btn-secondary">Go Back To Demand</a>
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition">
                        Add Image(s)
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
