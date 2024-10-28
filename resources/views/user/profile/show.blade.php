@extends('layouts.base')

@section('content')
    <div class="container mx-auto p-6">
        <div class=" mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Profile Header -->
            <div class="p-6 bg-gradient-to-r from-blue-500 to-teal-500 dark:from-gray-700 dark:to-gray-900 flex items-center space-x-6">
                <img src="{{ $user->avatar_path ? asset('uploads/avatars/' . $user->avatar_path) : asset('no_avatar.png') }}"
                     alt="{{ $user->username }}"
                     class="w-24 h-24 rounded-full ring-4 ring-white dark:ring-gray-700">

                <div>
                    <h1 class="text-3xl font-extrabold text-white dark:text-gray-100">{{ $user->username }}</h1>
                    <p class="text-sm text-gray-200 dark:text-gray-300">Registered {{ $user->created_at->diffForHumans() }}</p>
                    <p class="text-sm text-gray-200 dark:text-gray-300">{{ $user->email }}</p>
                </div>
            </div>

            <!-- Notification Area -->
            <div class="bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 p-4 rounded-lg shadow-md mt-4 flex items-center space-x-4">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0-4h.01m6.93 12.9A10.97 10.97 0 0112 21a10.97 10.97 0 01-7.93-3.1m15.86 0A10.97 10.97 0 0112 21m0 0a10.97 10.97 0 01-7.93-3.1m0 0A10.97 10.97 0 0112 3c3.037 0 5.83 1.234 7.93 3.1" />
                </svg>
                <p class="text-sm font-semibold">This profile shows the last 20 reviews only.</p>
            </div>

            <!-- Profile Stats -->
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total Exchange Made -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Exchange Activity</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Total Exchanges as Lister: <span class="font-bold">{{ $user->totalExchangesAsLister() }}</span>
                    </p>
                    <p class="text-gray-600 dark:text-gray-400">
                        Total Exchanges as Buyer: <span class="font-bold">{{ $user->totalExchangesAsBuyer() }}</span>
                    </p>
                </div>

                <!-- Reviews Made -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reviews Activity</h2>
                    <p class="text-gray-600 dark:text-gray-400">Total Reviews: <span class="font-bold">{{ $user->feedbackSubmitted()->count() }}</span></p>
                </div>

                <!-- Reviews Received as Lister -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reviews as Lister</h2>
                    <p class="text-gray-600 dark:text-gray-400">Total Received: <span class="font-bold">{{ $listerFeedbackCount }}</span></p>
                    <div class="flex items-center mt-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Average Rating:</span>
                        <div class="rating flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="star text-xl {{ $i <= round($listerAverageRating) ? 'text-yellow-500' : 'text-gray-300' }}">&#9733;</label>
                            @endfor
                        </div>
                    </div>
                </div>

                <!-- Reviews Received as Buyer -->
                <div class="bg-gray-50 dark:bg-gray-700 p-5 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Reviews as Buyer</h2>
                    <p class="text-gray-600 dark:text-gray-400">Total Received: <span class="font-bold">{{ $buyerFeedbackCount }}</span></p>
                    <div class="flex items-center mt-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400 mr-2">Average Rating:</span>
                        <div class="rating flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <label class="star text-xl {{ $i <= round($buyerAverageRating) ? 'text-yellow-500' : 'text-gray-300' }}">&#9733;</label>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Details -->
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Review Details</h2>

                <!-- Grouped by Lister Reviews -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">As Lister</h3>
                    @if ($user->feedbackAsLister->isEmpty())
                        <p class="text-sm text-gray-600 dark:text-gray-400">No reviews received as a lister yet.</p>
                    @else
                        <div class="mt-4 space-y-4">
                            @foreach ($user->feedbackAsLister->take(20) as $feedback)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Rating:
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="star text-xl {{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">&#9733;</label>
                                        @endfor
                                    </p>
                                    <p class="mt-2 text-gray-900 dark:text-gray-100">{{ $feedback->content }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Reviewed by {{ $feedback->submittedByUser->username ?? 'System' }} on {{ $feedback->created_at->format('M d, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Grouped by Buyer Reviews -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">As Buyer</h3>
                    @if ($user->feedbackAsBuyer->isEmpty())
                        <p class="text-sm text-gray-600 dark:text-gray-400">No reviews received as a buyer yet.</p>
                    @else
                        <div class="mt-4 space-y-4">
                            @foreach ($user->feedbackAsBuyer->take(20) as $feedback)
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg shadow-md">
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Rating:
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label class="star text-xl {{ $i <= $feedback->rating ? 'text-yellow-500' : 'text-gray-300' }}">&#9733;</label>
                                        @endfor
                                    </p>
                                    <p class="mt-2 text-gray-900 dark:text-gray-100">{{ $feedback->content }}</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Reviewed by {{ $feedback->submittedByUser->username ?? 'System' }} on {{ $feedback->created_at->format('M d, Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
