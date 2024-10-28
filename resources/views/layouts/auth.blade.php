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
    <link rel="stylesheet" href="{{ asset('fonts/inter/inter.css') }}">

    <!-- Local Icons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('icons/favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/logo.svg') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- SEO Meta Tags -->
    @hasSection('meta-description')
        <meta name="description" content="@yield('meta-description')">
    @endif
    @hasSection('meta-keywords')
        <meta name="keywords" content="@yield('meta-keywords')">
    @endif

    <!-- CSS -->
    @vite('resources/css/app.css')

</head>

<body style="font-family: 'Source Code Pro', monospace;">
<div class="flex overflow-hidden">
    <div id="main-content" class="w-full h-full overflow-y-auto">
        <main class="min-h-screen">
            @yield('content')
            @isset($slot)
                {{ $slot }}
            @endisset
        </main>
    </div>
</div>
@yield('body')
</body>

</html>
