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
    <body class="font-sans antialiased bg-slate-950 text-slate-900">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,0.30),transparent_32%),radial-gradient(circle_at_bottom_right,rgba(59,130,246,0.18),transparent_28%),linear-gradient(135deg,#022c22_0%,#064e3b_35%,#0f172a_100%)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.04),transparent_28%,rgba(255,255,255,0.02))]"></div>

            <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
                <div class="grid w-full gap-6 lg:grid-cols-[1.1fr_520px] lg:gap-10">
                    <section class="hidden lg:flex lg:flex-col lg:justify-between">
                        <div>
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-white/90">
                                <span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/15 bg-white/10 backdrop-blur">
                                    <x-application-logo class="h-8 w-8 fill-current text-white" />
                                </span>
                                <span>
                                    <span class="block text-sm font-semibold uppercase tracking-[0.22em] text-emerald-200/90">
                                        Agro Seguro Scanner
                                    </span>
                                    <span class="block text-xs text-white/60">
                                        Plataforma de análise e conferência documental
                                    </span>
                                </span>
                            </a>
                        </div>

                        <div class="max-w-xl">
                            <div class="inline-flex items-center rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-100 backdrop-blur">
                                Acesso seguro
                            </div>

                            <h1 class="mt-6 text-4xl font-extrabold leading-tight text-white xl:text-5xl">
                                Gestão moderna para análise de notas fiscais e documentos.
                            </h1>

                            <p class="mt-5 text-base leading-7 text-white/75 xl:text-lg">
                                Entre no sistema para acompanhar análises, consultar resultados, baixar arquivos
                                e centralizar todo o fluxo de conferência em uma experiência mais clara e profissional.
                            </p>

                            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                                    <div class="text-sm font-semibold text-white">Análises</div>
                                    <div class="mt-1 text-xs leading-6 text-white/65">Envio simples de nota em imagem ou PDF.</div>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                                    <div class="text-sm font-semibold text-white">OCR</div>
                                    <div class="mt-1 text-xs leading-6 text-white/65">Extração estruturada para revisão e conferência.</div>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                                    <div class="text-sm font-semibold text-white">Parecer</div>
                                    <div class="mt-1 text-xs leading-6 text-white/65">Resultado organizado com foco operacional.</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="flex items-center justify-center">
                        <div class="w-full max-w-md">
                            <div class="mb-5 flex justify-center lg:hidden">
                                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-white">
                                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/15 bg-white/10 backdrop-blur">
                                        <x-application-logo class="h-8 w-8 fill-current text-white" />
                                    </span>
                                </a>
                            </div>

                            <div class="overflow-hidden rounded-3xl border border-white/20 bg-white/95 shadow-[0_30px_90px_rgba(2,6,23,0.35)] backdrop-blur">
                                <div class="border-b border-slate-200/80 px-6 py-5 sm:px-8">
                                    <div class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                        Área restrita
                                    </div>
                                    <h2 class="mt-2 text-2xl font-bold text-slate-900">
                                        Acessar plataforma
                                    </h2>
                                    <p class="mt-1 text-sm text-slate-600">
                                        Faça login para continuar no Agro Seguro Scanner.
                                    </p>
                                </div>

                                <div class="px-6 py-6 sm:px-8 sm:py-8">
                                    {{ $slot }}
                                </div>
                            </div>

                            <p class="mt-4 text-center text-xs text-white/65">
                                Ambiente autenticado e preparado para desktop e mobile.
                            </p>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>