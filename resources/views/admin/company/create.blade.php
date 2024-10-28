@extends('layouts.base')

@section('styles')

@endsection

@section('content')
    <div class="container mx-auto px-4 py-6 dark:bg-gray-900 dark:text-gray-100 mt-8">
        <div class="mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            <h2 class="text-3xl font-semibold dark:text-white mb-6">Create a New Company</h2>

            <form action="{{ route('user.company.store') }}" method="POST">
                @csrf

                <!-- Company Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Company Name</label>
                    <input type="text" name="name" id="name" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" placeholder="Enter the company name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-5">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" placeholder="Enter a brief description">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-md shadow-md transition ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create Company</button>
                </div>
            </form>
        </div>
    </div>
@endsection
