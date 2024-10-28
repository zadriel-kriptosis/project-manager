<!-- resources/views/projects/create.blade.php -->
@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Create a New Project for {{ $company->name }} Company</h2>

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

            <!-- Form to create a project -->
            <form action="{{ route('user.project.store', $company) }}" method="POST">
                @csrf

                <!-- Hidden field to store company ID -->
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="mb-6">
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Project Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" required>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white" required></textarea>
                </div>

{{--                <div class="mb-6">--}}
{{--                    <label class="inline-flex items-center">--}}
{{--                        <input type="checkbox" name="is_active" class="form-checkbox text-green-600 dark:text-green-400">--}}
{{--                        <span class="ml-2 text-gray-700 dark:text-gray-300">Is Active?</span>--}}
{{--                    </label>--}}
{{--                </div>--}}

                <div class="flex justify-end gap-4">
                    <a href="{{route('user.company.show', ['slug' => $company->slug])}}" class="btn-secondary">Go Back Company</a>
                    <button type="submit" class="btn-primary">
                        Create Project
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
