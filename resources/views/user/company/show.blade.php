@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Company Header -->
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <!-- Company Name and Description -->
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $company->name }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $company->description }}</p>
                </div>

                <!-- Company Status and Counts -->
                <div class="flex flex-row items-center gap-4">
                    <!-- Company Status -->
                    <div class="flex items-center">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $company->is_active ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-400' }}">
                            {{ $company->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <!-- Employee Count -->
                    <div class="flex items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $employeeCount }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 ml-1">Employees</p>
                    </div>

                    <!-- Project Count -->
                    <div class="flex items-center">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $projectCount }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 ml-1">Projects</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Company Team Section -->
        <div class="mt-8 bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Team</h2>
            <div class="space-y-4">
                <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Owner:</strong> {{ $company->owner->username }}</p>

                <!-- Employers (Users associated with the company's projects) -->
                @if($employers->isNotEmpty())
                    <p class="text-sm text-gray-700 dark:text-gray-300"><strong>Company Employers:</strong>
                        @foreach($employers as $employer)
                            {{ $loop->first ? '' : ', ' }}{{ $employer->username }}
                        @endforeach
                    </p>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">No employers available.</p>
                @endif
            </div>
        </div>

        <!-- Projects and Associated Users -->
        <div class="mt-8">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Associated Projects</h2>
                <!-- Create New Project Button -->
                <a href="{{ route('user.project.create', $company->id) }}" class="btn-primary">
                    Create New Project
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @forelse($company->projects as $project)
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <a href="{{ route('user.project.show', $project->id) }}" class="hover:underline">{{ $project->name }}</a>
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $project->description }}</p>

                        <!-- Associated Users -->
                        @if($project->users->isNotEmpty())
                            <div class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                <strong>Appointees:</strong>
                                @foreach($project->users as $user)
                                    {{ $loop->first ? '' : ', ' }}{{ $user->username }}
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">No users assigned</p>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No associated projects found.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
