@extends('layouts.auth')

@section('content')

    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen dark:bg-gray-900">
        <!-- Logo and App Name -->
        <a href="{{ route('home') }}" class="flex items-center justify-center mb-8 text-3xl font-bold text-gray-800 dark:text-white">
            <img src="{{ asset(Cache::tags('Settings')->get('app_logo')) }}" class="h-12 mr-3" alt="{{ Cache::tags('Settings')->get('app_name') }} Logo">
            <span>{{ Cache::tags('Settings')->get('app_name') }}</span>
        </a>

        <!-- Registration Card -->
        <div class="w-full max-w-md p-6 space-y-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Create an Account</h2>

            @if ($errors->any())
                <div class="bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-400 p-4 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Registration Form -->
            <form class="space-y-6" action="{{route('register')}}" method="POST">
                @csrf
                <!-- Username Input -->
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" name="username" id="username" required autofocus
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••">
                </div>

                <!-- Confirm Password Input -->
                <div>
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-500 dark:bg-blue-500 dark:hover:bg-blue-600">Create Account</button>
            </form>

            <!-- Login Link -->
            <div class="text-sm text-center text-gray-600 dark:text-gray-300">
                Already have an account?
                <a href="{{route('login')}}" class="text-blue-600 hover:underline dark:text-blue-400">Login here</a>
            </div>
        </div>
    </div>

@endsection
