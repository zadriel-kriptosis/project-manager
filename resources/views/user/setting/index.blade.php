@extends('layouts.base')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-50 mb-10">User Settings</h1>

        <form action="{{ route('user.setting.update') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="bg-white dark:bg-gray-900 shadow-md hover:shadow-lg rounded-lg p-8 space-y-6 transition-all">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-50">Personal Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Username -->
                    <div class="space-y-2">
                        <label for="username" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Username</label>
                        <input type="text" name="username" id="username"
                               value="{{ old('username', auth()->user()->username) }}"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition"
                               readonly>
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Email Address</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email', auth()->user()->email) }}"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>

            <!-- Security -->
            <div class="bg-white dark:bg-gray-900 shadow-md hover:shadow-lg rounded-lg p-8 space-y-6 transition-all">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-50">Change Password</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label for="old_password" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Old Password</label>
                        <input type="password" name="old_password" id="old_password"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">New Password</label>
                        <input type="password" name="password" id="password"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>

            <!-- Preferences -->
            <div class="bg-white dark:bg-gray-900 shadow-md hover:shadow-lg rounded-lg p-8 space-y-6 transition-all">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-50">Preferences</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label for="currency" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Currency</label>
                        <select name="currency" id="currency"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @foreach(App\Enums\FiatCurrency::FiatCurrency_options() as $currency)
                                <option value="{{ $currency['name'] }}"
                                        @if(auth()->user()->currency == $currency['name']) selected @endif>
                                    {{ strtoupper($currency['name']) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="language" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Language</label>
                        <select name="language" id="language"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @foreach(App\Enums\Language::Language_options() as $language)
                                <option value="{{ $language['name'] }}"
                                        @if(auth()->user()->language == $language['name']) selected @endif>
                                    {{ $language['desc'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label for="timezone" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Timezone</label>
                        <select name="timezone" id="timezone"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            @foreach(timezone_identifiers_list() as $timezone)
                                <option value="{{ $timezone }}"
                                        @if(auth()->user()->timezone == $timezone) selected @endif>
                                    {{ $timezone }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Appearance -->
            <div class="bg-white dark:bg-gray-900 shadow-md hover:shadow-lg rounded-lg p-8 space-y-6 transition-all">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-50">Appearance</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="avatar" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Avatar</label>
                        <div class="flex items-center space-x-4">
                            <!-- Show current avatar preview or placeholder -->
                            @if(auth()->user()->avatar_path)
                                <img class="h-24 w-24 sm:h-32 sm:w-32 rounded-full border border-gray-300 dark:border-gray-700 object-cover"
                                     src="{{ asset('uploads/avatars/' . auth()->user()->avatar_path) }}" alt="User Avatar">
                            @else
                                <span class="inline-block w-12 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-600">
                <svg class="h-full w-full text-gray-300 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 0H0v24h24V0z" fill="none"/>
                    <path d="M12 12c2.21 0 4.15-1.64 4.44-3.75h-8.88C7.85 10.36 9.79 12 12 12z"/>
                </svg>
            </span>
                            @endif
                            <!-- Traditional file input -->
                            <input type="file" name="avatar" id="avatar"
                                   class="block text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 dark:file:bg-indigo-700 dark:hover:file:bg-indigo-500">
                        </div>
                    </div>


                    <div class="space-y-2">
                        <label for="theme_color" class="block text-sm font-semibold text-gray-600 dark:text-gray-400">Theme Color</label>
                        <select name="theme_color" id="theme_color"
                                class="w-full border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 rounded-md p-3 dark:text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 transition">
                            <option value="light" @if(auth()->user()->theme_color == 'light') selected @endif>Light</option>
                            <option value="dark" @if(auth()->user()->theme_color == 'dark') selected @endif>Dark</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection
