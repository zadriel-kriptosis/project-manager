@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Project Header -->
        <div class="bg-gray-100 dark:bg-gray-900 p-6 rounded-lg shadow-md">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                <!-- Project Name and Description -->
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ $project->name }}</h1>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $project->description }}</p>
                </div>

                <!-- Project Status -->
                <div class="mt-4 sm:mt-0">
                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                        {{ $project->is_active ? 'bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-400' : 'bg-red-100 text-red-600 dark:bg-red-900 dark:text-red-400' }}">
                        {{ $project->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Project Details Section -->
        <div class="mt-8 bg-gray-50 dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Project Information</h2>

            <!-- Associated Company -->
            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <strong>Company:</strong>
                    <a href="{{ route('admin.company.show', $project->company->slug) }}"
                       class="text-blue-600 dark:text-blue-400 hover:underline">
                        {{ $project->company->name }}
                    </a>
                </p>
            </div>

            <!-- Associated Users -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Project Assigned Users</h3>
                <ul class="mt-2 space-y-1 text-sm text-gray-700 dark:text-gray-300">
                    @forelse($project->users as $user)
                        <li class="flex justify-between">
                            {{ $user->username }}
                            @hasanyrole('super_admin|admin|demo_admin|moderator|support')
                            <!-- Show the form if the user has any of the specified roles -->
                            <form action="{{ route('admin.project.deleteuser', [$project->id, $user->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">Remove</button>
                            </form>
                            @else
                                <!-- Show the form if the user is the owner of the project -->
                                @if(auth()->id() === $project->company->owner_id)
                                    <form action="{{ route('admin.project.deleteuser', [$project->id, $user->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Remove</button>
                                    </form>
                                @endif
                                @endhasanyrole

                        </li>
                    @empty
                        <li>No users assigned to this project.</li>
                    @endforelse
                </ul>

                @hasanyrole('super_admin|admin|demo_admin|moderator|support')
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Add User to Project</h3>
                    <form action="{{ route('admin.project.adduser', $project->id) }}" method="POST">
                        @csrf
                        <div class="flex items-center space-x-4 mt-2">
                            <input type="text" name="username"
                                   class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                   placeholder="Enter username" required>
                            <button type="submit" class="btn-primary whitespace-nowrap">Add User</button>
                        </div>
                    </form>
                </div>
                @else
                    @if(auth()->id() === $project->company->owner_id)
                        <div class="mt-6">
                            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Add User to Project</h3>
                            <form action="{{ route('admin.project.adduser', $project->id) }}" method="POST">
                                @csrf
                                <div class="flex items-center space-x-4 mt-2">
                                    <input type="text" name="username"
                                           class="block w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                           placeholder="Enter username" required>
                                    <button type="submit" class="btn-primary whitespace-nowrap">Add User</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    @endhasanyrole

            </div>
        </div>

        <!-- Project Demands Section -->
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Demands</h2>

            <!-- Flexbox Demand Cards with Create Button -->
            <div class="flex flex-col sm:flex-row items-stretch gap-4">
                <!-- Bug Demand Card -->
                <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col min-h-full">
                    <h3 class="text-xl font-semibold text-red-500 dark:text-red-400 mb-4">Bugs</h3>
                    <a href="{{ route('admin.demand.create', ['project_id' => $project->id, 'type_id' => 0]) }}"
                       class="btn-primary mb-4">Create Bug</a>
                    <ul class="space-y-2 flex-grow">
                        @forelse($demands[0] ?? [] as $demand)
                            <li class="text-sm flex justify-between">
                                <a href="{{ route('admin.demand.show', $demand->id) }}"
                                   class="hover:underline flex-1 {{ $demand->status_css_class }}">
                                    {{ $demand->title }}
                                </a>
                                <span class="ml-2 {{ $demand->status_css_class }}">
                                    ({{ $demand->status_name }})
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 dark:text-gray-400">No bug demands.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Development Demand Card -->
                <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col min-h-full">
                    <h3 class="text-xl font-semibold text-blue-500 dark:text-blue-400 mb-4">Development</h3>
                    <a href="{{ route('admin.demand.create', ['project_id' => $project->id, 'type_id' => 1]) }}"
                       class="btn-primary mb-4">Create Development</a>
                    <ul class="space-y-2 flex-grow">
                        @forelse($demands[1] ?? [] as $demand)
                            <li class="text-sm flex justify-between">
                                <a href="{{ route('admin.demand.show', $demand->id) }}"
                                   class="hover:underline flex-1 {{ $demand->status_css_class }}">
                                    {{ $demand->title }}
                                </a>
                                <span class="ml-2 {{ $demand->status_css_class }}">
                                    ({{ $demand->status_name }})
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 dark:text-gray-400">No development demands.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Test Demand Card -->
                <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col min-h-full">
                    <h3 class="text-xl font-semibold text-green-500 dark:text-green-400 mb-4">Test</h3>
                    <a href="{{ route('admin.demand.create', ['project_id' => $project->id, 'type_id' => 2]) }}"
                       class="btn-primary mb-4">Create Test</a>
                    <ul class="space-y-2 flex-grow">
                        @forelse($demands[2] ?? [] as $demand)
                            <li class="text-sm flex justify-between">
                                <a href="{{ route('admin.demand.show', $demand->id) }}"
                                   class="hover:underline flex-1 {{ $demand->status_css_class }}">
                                    {{ $demand->title }}
                                </a>
                                <span class="ml-2 {{ $demand->status_css_class }}">
                                    ({{ $demand->status_name }})
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 dark:text-gray-400">No test demands.</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Other Demand Card -->
                <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md flex flex-col min-h-full">
                    <h3 class="text-xl font-semibold text-purple-500 dark:text-purple-400 mb-4">Other</h3>
                    <a href="{{ route('admin.demand.create', ['project_id' => $project->id, 'type_id' => 3]) }}"
                       class="btn-primary mb-4">Create Other</a>
                    <ul class="space-y-2 flex-grow">
                        @forelse($demands[3] ?? [] as $demand)
                            <li class="text-sm flex justify-between">
                                <a href="{{ route('admin.demand.show', $demand->id) }}"
                                   class="hover:underline flex-1 {{ $demand->status_css_class }}">
                                    {{ $demand->title }}
                                </a>
                                <span class="ml-2 {{ $demand->status_css_class }}">
                                    ({{ $demand->status_name }})
                                </span>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 dark:text-gray-400">No other demands.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection