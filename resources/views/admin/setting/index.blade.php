@extends('layouts.base')

@section('styles')

@endsection

@section('content')
    <div class="container mx-auto p-6 space-y-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">General Settings</h3>
            <p class="mb-4 text-gray-700 dark:text-gray-300">Manage general settings such as app name, URL, and logo.</p>

            @if($errors->any() && request('current_tab') == '#general')
                <div class="mb-6 p-4 border border-red-400 bg-red-100 text-red-700 rounded">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.setting.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @method('PUT')
                @csrf
                <!-- App Name -->
                <div>
                    <label for="app_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">App Name</label>
                    <input type="text" name="app_name" id="app_name"
                           value="{{ old('app_name', Cache::tags('Settings')->get('app_name')) }}"
                           class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-300 dark:focus:border-indigo-300">
                    @error('app_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- App URL -->
                <div>
                    <label for="app_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300">App URL</label>
                    <input type="text" name="app_url" id="app_url"
                           value="{{ old('app_url', Cache::tags('Settings')->get('app_url')) }}"
                           class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('app_url')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- App Logo -->
                <div>
                    <label for="app_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">App Logo</label>
                    <div class="mt-2 flex items-center space-x-4">
                    <span class="inline-block h-12 w-12 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden">
                        <img id="logo-preview" src="{{ asset(Cache::tags('Settings')->get('app_logo')) }}" alt="App Logo" class="h-full w-full object-cover">
                    </span>
                        <input type="file" name="app_logo" id="app_logo"
                               class="rounded-lg border-gray-300 px-3 py-2 text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    @error('app_logo')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>


                <!-- App Email -->
                <div>
                    <label for="app_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">App Email</label>
                    <input type="email" name="app_email" id="app_email"
                           value="{{ old('app_email', Cache::tags('Settings')->get('app_email')) }}"
                           class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('app_email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>



                <!-- App Footer Text -->
                <div>
                    <label for="app_footertext" class="block text-sm font-medium text-gray-700 dark:text-gray-300">App Footer Text</label>
                    <input type="text" name="app_footertext" id="app_footertext"
                           value="{{ old('app_footertext', Cache::tags('Settings')->get('app_footertext')) }}"
                           class="mt-2 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    @error('app_footertext')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Save Button -->
                <div class="pt-4">
                    <button type="submit"
                            class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-blue-500 dark:hover:bg-blue-600 transition">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
