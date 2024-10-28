<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @hasSection('title')
        <title>@yield('title') - {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    <!-- Local Font Style -->

{{--    <link rel="stylesheet" href="{{ asset('css/css') }}">--}}
    <!-- Local Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.svg') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.svg') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.svg') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">

    <!-- SEO Meta Tags -->
    @hasSection('meta-description')
        <meta name="description" content="@yield('meta-description')">
    @endif
    @hasSection('meta-keywords')
        <meta name="keywords" content="@yield('meta-keywords')">
    @endif

    <!-- CSS -->
    @vite('resources/css/app.css')
    {{--    <link rel="stylesheet" href="{{ asset('css/extra-styles.css') }}">--}}
    @yield('styles')

</head>

<body class="bg-gray-50 dark:bg-gray-800" style="font-family: 'Roboto', sans-serif;">
<input type="checkbox" id="toggleSidebarMobile" class="hidden">
@include('partials.navbar')
@include('partials.sidebar')
<div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
    <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-diesel-950">
        <main class="min-h-screen">
            <div class="px-4 pt-6">
                @if(session()->has('success_message'))
                    <div class="container mx-auto px-4 pt-4">
                        <div
                            class="flex flex-col sm:flex-row items-center justify-center bg-green-800 text-white leading-snug font-bold p-2 sm:p-4 rounded-lg shadow-lg fade-out-collapse transition duration-500 ease-in-out transform hover:shadow-2xl overflow-hidden text-xs sm:text-sm lg:text-md 2xl:text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 sm:mb-0 sm:mr-2 flex-shrink-0"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span
                                class="flex-grow text-center sm:text-left">{{session()->get('success_message')}}</span>
                        </div>
                    </div>
                @endif
                @if(session()->has('error_message'))
                    <div class="container mx-auto px-4 pt-4">
                        <div
                            class="flex flex-col sm:flex-row items-center justify-center bg-red-800 text-white leading-snug font-bold p-2 sm:p-4 rounded-lg shadow-lg fade-out-collapse transition duration-500 ease-in-out transform hover:shadow-2xl overflow-hidden text-xs sm:text-sm lg:text-md 2xl:text-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 sm:mb-0 sm:mr-2 flex-shrink-0"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            <span class="flex-grow text-center sm:text-left">{{session()->get('error_message')}}</span>
                        </div>
                    </div>
                @endif
                @yield('content')
                @isset($slot)
                    {{ $slot }}
                @endisset
            </div>
        </main>
        @include('partials.footer')
    </div>
</div>
@yield('body')
</body>

</html>
