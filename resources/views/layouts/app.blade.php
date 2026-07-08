<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Pengadaan Material Kapal') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-100 text-slate-900">
    <div class="min-h-screen bg-gradient-to-b from-slate-100 via-blue-50 to-white">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white/90 backdrop-blur border-b border-slate-200 shadow-sm">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main class="py-6">
            {{ $slot }}
        </main>
    </div>

    {{-- ============================================================
         GLOBAL TOAST NOTIFICATION CONTAINER
         Firebase foreground notifications & chat alerts appear here
         ============================================================ --}}
    <div id="toast-container"
        class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"
        style="max-width: 360px; width: calc(100vw - 2.5rem);">
        {{-- Toasts are injected here dynamically by firebase-init.js --}}
    </div>

    <style>
        #toast-container > * {
            pointer-events: auto;
        }
        #toast-container .toast-item {
            backdrop-filter: blur(12px);
        }
    </style>

</body>

</html>
