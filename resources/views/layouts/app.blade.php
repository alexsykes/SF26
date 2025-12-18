<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://kit.fontawesome.com/086d4db9c7.js" crossorigin="anonymous"></script>
{{--    <script>--}}
{{--        function success(position) {--}}
{{--            // document.cookie = "lat=" + position.coords.latitude;--}}
{{--            // document.cookie = "lng=" + position.coords.longitude;--}}
{{--            let days = 365;--}}
{{--            var date = new Date();--}}
{{--            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));--}}
{{--            var expires = "; expires=" + date.toGMTString();--}}
{{--            let lat = position.coords.latitude;--}}
{{--            let lng = position.coords.longitude;--}}
{{--            document.cookie = "lat=" + lat + "; expires=" + expires + ";path=/";--}}
{{--            document.cookie = "lng=" + lng + "; expires=" + expires + ";path=/";--}}
{{--            console.log("Cookies saved");--}}
{{--        }--}}

{{--        document.addEventListener("DOMContentLoaded", function () {--}}
{{--            if (navigator.geolocation) {--}}
{{--                navigator.geolocation.getCurrentPosition(success);--}}
{{--                console.log("Request location");--}}
{{--            } else {--}}
{{--                console.log("Geolocation is not supported by this browser.");--}}
{{--            }--}}
{{--            navigator.permissions.query({name: 'geolocation'})--}}
{{--                .then(console.log)--}}
{{--        });--}}
{{--    </script>--}}
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white shadow">
            <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8">
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
