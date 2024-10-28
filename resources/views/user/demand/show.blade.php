@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Demand Header -->
        <div
            class="bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md space-y-4 transition-all duration-300 ease-in-out">

            <!-- Demand Title with Status Styling -->
            <h1 class="text-xl font-semibold {{ $demand->status_css_class }}">
                {{ $demand->title }}
            </h1>

            <!-- Demand Description -->
            <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ $demand->description }}
            </p>

            <!-- Demand Meta Information -->
            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
                <!-- Project Name -->
                <div class="flex flex-col space-y-1">
                    <span class="font-semibold text-gray-500 dark:text-gray-400">Project</span>
                    <span class="text-gray-900 dark:text-gray-100 break-words max-w-40 md:max-w-full">{{ $demand->project->name }}sdasdaasdadsdasadsadsdsadsadsadsadasdasdds</span>
                </div>

                <!-- Status -->
                <div class="flex flex-col space-y-1">
                    <span class="font-semibold text-gray-500 dark:text-gray-400">Status</span>
                    <span
                        class="{{ $demand->status_css_class }} text-gray-900 dark:text-gray-100">{{ $demand->status_name }}</span>
                </div>

                <!-- Type -->
                <div class="flex flex-col space-y-1">
                    <span class="font-semibold text-gray-500 dark:text-gray-400">Type</span>
                    <span class="text-gray-900 dark:text-gray-100">{{ $demand->type_name }}</span>
                </div>
            </div>

            <!-- Created At (Human Readable) -->
            <div class="text-sm text-gray-500 dark:text-gray-400 flex justify-between items-center">
                <a href="{{route('user.project.show', ['id' => $demand->project->id])}}" class="btn-link">Go Back Project</a>
                <div>
                    <span class="font-semibold">Created:</span> {{ $demand->created_at->diffForHumans() }}
                </div>
            </div>
        </div>


        <!-- Process Records -->
        <div class="mt-6">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Process Records</h2>
                <!-- Add Process Button -->
                <div class="flex flex-row gap-2">
                    <a href="{{ route('user.demand.galleryaddview', ['demand_id' => $demand->id]) }}"
                       class="btn-secondary">
                        Add Image
                    </a>

                    <a href="{{ route('user.processrecord.create', ['demand_id' => $demand->id]) }}"
                       class="btn-primary">
                        Add Process
                    </a>
                </div>
            </div>

            <div class="mt-4 space-y-4">
                @forelse($demand->processRecords as $record)
                    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-800 dark:text-gray-300">
                                    <strong>{{ $record->user ? $record->user->username : 'System' }}</strong>
                                    changed status from
                                    <span
                                        class="{{ $record->before_status_name === 'Cancelled' ? 'line-through text-red-500' : '' }}">
                                        {{ $record->before_status_name }}
                                    </span>
                                    to
                                    <span
                                        class="{{ $record->after_status_name === 'Cancelled' ? 'line-through text-red-500' : '' }}">
                                        {{ $record->after_status_name }}
                                    </span>.
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $record->description }}</p>
                                <!-- Created At Timestamp -->
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <i>{{ $record->created_at->format('M d, Y - H:i A') }}</i>
                                </p>
                            </div>
                            @if($record->file)
                                <div class="flex flex-col text-right">
                                    <span
                                        class="dark:text-gray-400 text-xs break-words w-24">{{ basename($record->file) }}</span>
                                    <a href="{{ asset($record->file) }}" class="text-blue-500 text-sm" download>Download
                                        File</a>
                                </div>
                            @endif
                        </div>

                        @if($record->img)
                            <div class="mt-4">
                                <img src="{{ asset($record->img) }}" class="w-48 h-auto rounded-md" alt="Process Image">
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400">No process records found.</p>
                @endforelse
            </div>
        </div>

        <!-- Demand Gallery -->
        @if($demand->gallery->isNotEmpty())
            <div class="mt-6">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Demand Gallery</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                    @foreach($demand->gallery as $image)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden flex justify-center items-center">
                            <img src="{{ asset($image->img) }}" class="w-full max-h-48 object-contain"
                                 alt="Demand Image">
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection
