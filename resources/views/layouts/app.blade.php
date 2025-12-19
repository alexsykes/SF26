<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Slope soaring site and weather information.">
    <meta name="keywords"
          content="UK Slope soaring, Model flying, radio control soaring">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SlopeFinder UK') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://kit.fontawesome.com/086d4db9c7.js" crossorigin="anonymous"></script>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="w-full text-center text-blue-500 font-semibold">SlopeFinder UK is currently under constant
                    development. Please
                    accept our apologies for any interruption you may experience
                </div>
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->

    <main>
        {{ $slot }}
    </main>
    <x-bottom-nav></x-bottom-nav>
</div>
</body>
</html>
