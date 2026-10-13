<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Product Manager') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-white">

            <!-- Logo + Tagline -->
            <div class="text-center">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-16 h-16 mx-auto object-contain">
                </a>
                <p class="mt-3 text-base font-bold text-gray-800">
                    It's finger licking good
                </p>
            </div>

            <!-- Form Card -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white border border-gray-200 shadow-sm overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <footer class="mt-8 text-center text-xs text-gray-500">
                © {{ date('Y') }} Product Manager. All rights reserved.
            </footer>
        </div>
    </body>
</html>