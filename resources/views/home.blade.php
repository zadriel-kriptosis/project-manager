@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/custom/home.css') }}">
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6 dark:bg-gray-900 dark:text-gray-100 mt-8">
        <div class="flex flex-wrap justify-between items-center mb-6">
            <!-- Welcome Header -->
            <div class="w-full lg:w-1/2 mb-4 lg:mb-0">
                <h1 class="text-3xl font-bold dark:text-white">Welcome to Your Dashboard</h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Here's an overview of your activity.</p>
            </div>
            <!-- Action Buttons -->
            <div class="w-full lg:w-1/2 flex justify-end space-x-2">
                <a href="{{ route('user.company.create') }}" class="btn-primary">Create New Company</a>
{{--                <a href="{{ route('user.project.create') }}" class="btn-secondary">Create New Project</a>--}}
            </div>
        </div>

        <!-- Responsive Flex Layout (1 item per row on small screens, 2 items per row on larger screens) -->
        <div class="flex flex-wrap -mx-2">
            <!-- My Companies -->
            <div class="w-full md:w-1/2 px-2 mb-4">
                <div class="card flex flex-col">
                    <h2 class="card-title">My Companies</h2>
                    <div class="scrollable-section">
                        <ul>
                            @forelse($companies->take(3) as $company)
                                <li class="card-item">
                                    <h3 class="font-bold dark:text-white">{{ $company->name }}</h3>
                                    <p class="card-description">{{ $company->description }}</p>
                                    <a href="{{ route('user.company.show', $company->slug) }}" class="card-link">View Company</a>
                                </li>
                            @empty
                                <li>No companies available</li>
                            @endforelse
                        </ul>
                    </div>
{{--                    @if($companies->count() > 3)--}}
{{--                        <a href="{{ route('user.company.index') }}" class="btn-link mt-4">View All Companies</a>--}}
{{--                    @endif--}}
                </div>
            </div>

            <!-- My Projects -->
            <div class="w-full md:w-1/2 px-2 mb-4">
                <div class="card flex flex-col">
                    <h2 class="card-title">My Projects</h2>
                    <div class="scrollable-section">
                        <ul>
                            @forelse($projects->take(3) as $project)
                                <li class="card-item">
                                    <h3 class="font-bold dark:text-white">{{ $project->name }}</h3>
                                    <p class="card-description">{{ $project->description }}</p>
                                    <p class="flex items-center text-sm text-gray-500 dark:text-gray-400 mt-2 italic mb-1">
                                        <span class="inline-block mr-2">
                                            @include('partials.svg.building-svg')
                                        </span>
                                        <span class="ml-1">{{ $project->company->name ?? 'No Company' }}</span>
                                    </p>
                                    <a href="{{ route('user.project.show', $project->id) }}" class="card-link">View Project</a>
                                </li>
                            @empty
                                <li>No projects available</li>
                            @endforelse
                        </ul>
                    </div>
                    @if($projects->count() > 3)
                        <a href="{{ route('user.project.index') }}" class="btn-link mt-4">View All Projects</a>
                    @endif
                </div>
            </div>

            <!-- My Demands -->
            <div class="w-full md:w-1/2 px-2 mb-4">
                <div class="card flex flex-col">
                    <h2 class="card-title">My Last Demands</h2>
                    <div class="scrollable-section">
                        <ul>
                            @forelse($demands->take(3) as $demand)
                                <li class="card-item">
                                    <h3 class="font-bold dark:text-white">{{ $demand->title }}</h3>
                                    <p class="card-description">{{ \Illuminate\Support\Str::limit($demand->description, 80, '...') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Status: {{ $demand->status_name }} - Type: {{ $demand->type_name }}
                                    </p>
                                    <a href="{{ route('user.demand.show', $demand->id) }}" class="card-link">View Demand</a>
                                </li>
                            @empty
                                <li>No demands available</li>
                            @endforelse
                        </ul>
                    </div>
{{--                    @if($demands->count() > 3)--}}
{{--                        <a href="{{ route('user.demand.index') }}" class="btn-link mt-4">View All Demands</a>--}}
{{--                    @endif--}}
                </div>
            </div>

            <!-- My Process Records -->
            <div class="w-full md:w-1/2 px-2 mb-4">
                <div class="card flex flex-col">
                    <h2 class="card-title">My Last Process Records</h2>
                    <div class="scrollable-section">
                        <ul>
                            @forelse($processRecords->take(3) as $record)
                                <li class="card-item">
                                    <h3 class="font-bold dark:text-white text-sm">{{ \Illuminate\Support\Str::limit($record->description, 80, '...') }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Status changed from {{ $record->before_status_name }} to {{ $record->after_status_name }} by {{ $record->user->username ?? 'Unknown' }}
                                    </p>
                                    <a href="{{ route('user.demand.show', $record->demand->id) }}" class="card-link text-xs">View Record</a>
                                </li>
                            @empty
                                <li>No process records available</li>
                            @endforelse
                        </ul>
                    </div>
{{--                    @if($processRecords->count() > 3)--}}
{{--                        <a href="{{ route('user.processrecord.index') }}" class="btn-link mt-4">View All Process Records</a>--}}
{{--                    @endif--}}
                </div>
            </div>

        </div>
    </div>
@endsection
