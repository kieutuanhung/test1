<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col bg-ink">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-ink border-b border-neutral-800">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="border-t-2 border-accent bg-ink mt-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <x-application-logo class="h-6 w-auto fill-current text-white" />
                            <span class="text-lg font-extrabold tracking-widest2 uppercase text-white">{{ config('app.name', 'Shop') }}</span>
                        </a>
                        <p class="text-xs text-neutral-400 tracking-wide">&copy; {{ date('Y') }} {{ config('app.name', 'Shop') }}. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
