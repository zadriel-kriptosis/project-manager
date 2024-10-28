@extends('layouts.auth')

@section('content')

    <div class="flex flex-col items-center justify-center min-h-screen px-6 py-8 bg-gray-50 dark:bg-gray-900">
        <!-- Logo and App Name -->
        <a href="{{ route('home') }}" class="flex items-center justify-center mb-8 text-3xl font-bold text-gray-800 dark:text-white">
            <img src="{{ asset(Cache::tags('Settings')->get('app_logo')) }}" class="h-12 mr-3" alt="{{ Cache::tags('Settings')->get('app_name') }} Logo">
            <span>{{ Cache::tags('Settings')->get('app_name') }}</span>
        </a>

        <!-- Login Card -->
        <div class="w-full max-w-md p-6 space-y-6 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Log in to the app</h2>

            <!-- Error Messages -->
            @if ($errors->any() || session('error_message'))
                <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        @if (session('error_message'))
                            <li>{{ session('error_message') }}</li>
                        @endif
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form class="space-y-6" action="{{ route('login.post') }}" method="POST">
                @csrf
                <!-- Username Input -->
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username') }}" required autofocus
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-gray-900 dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                </div>

{{--                <!-- Remember Me Checkbox and Forgot Password Link -->--}}
{{--                <div class="flex items-center justify-between">--}}
{{--                    <div class="flex items-center">--}}
{{--                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 focus:ring-blue-500">--}}
{{--                        <label for="remember" class="ml-2 text-sm text-gray-900 dark:text-gray-300">Remember me</label>--}}
{{--                    </div>--}}
{{--                    <a href="#" class="text-sm text-blue-600 hover:underline dark:text-blue-400">Forgot Password?</a>--}}
{{--                </div>--}}

                <!-- Login Button -->
                <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 dark:bg-blue-500 dark:hover:bg-blue-600">Log In</button>
            </form>

            <!-- Divider -->
            <div class="flex items-center justify-center my-6">
                <span class="text-xs font-semibold text-gray-400">or</span>
            </div>

            <!-- Create Account Section -->
            <div class="text-sm font-medium text-center text-gray-600 dark:text-gray-300">
                <span>Not registered?</span>
                <a href="{{ route('register') }}" class="ml-2 text-blue-600 hover:underline dark:text-blue-400">Create an account</a>
            </div>
        </div>
    </div>

@endsection
