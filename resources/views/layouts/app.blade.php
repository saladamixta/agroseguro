<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Agro Seguro Scanner') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-slate-100 text-slate-900">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-br from-emerald-950 via-emerald-900 to-emerald-700"></div>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.14),transparent_38%)]"></div>
            <div class="pointer-events-none absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.03),transparent_30%,rgba(15,23,42,0.02))]"></div>

            <div class="relative min-h-screen">
                @include('layouts.navigation')

                @isset($header)
                    <header class="px-4 pt-4 sm:px-6 lg:px-8">
                        <div class="mx-auto max-w-7xl">
                            <div class="rounded-3xl border border-white/15 bg-white/10 px-5 py-5 shadow-[0_20px_60px_rgba(2,6,23,0.18)] backdrop-blur md:px-6">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endisset

                <main class="px-4 pb-8 pt-4 sm:px-6 lg:px-8 lg:pb-10">
                    <div class="mx-auto max-w-7xl">
                        @if (session('success'))
                            <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 shadow-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('status'))
                            <div class="mb-4 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-medium text-blue-800 shadow-sm">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-4 rounded-2xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-800 shadow-sm">
                                <div class="mb-2 font-semibold">Não foi possível concluir a ação.</div>
                                <ul class="space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-6">
                            {{ $slot ?? '' }}
                            @yield('content')
                        </div>
                    </div>
                </main>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>