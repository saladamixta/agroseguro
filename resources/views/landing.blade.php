<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Agro Seguro Scanner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-slate-900 antialiased">
    <div class="relative min-h-screen overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,0.30),transparent_30%),radial-gradient(circle_at_bottom_right,rgba(59,130,246,0.16),transparent_30%),linear-gradient(135deg,#022c22_0%,#064e3b_35%,#0f172a_100%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.04),transparent_30%,rgba(255,255,255,0.02))]"></div>

        <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:gap-12">
                <section class="flex flex-col justify-center">
                    <div class="inline-flex w-fit items-center rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-[11px] font-semibold uppercase tracking-[0.22em] text-emerald-100 backdrop-blur">
                        Plataforma inteligente
                    </div>

                    <h1 class="mt-6 text-4xl font-extrabold leading-tight text-white sm:text-5xl lg:text-6xl">
                        Validação inteligente de notas fiscais de agrotóxicos.
                    </h1>

                    <p class="mt-5 max-w-2xl text-base leading-7 text-white/75 sm:text-lg">
                        O Agro Seguro Scanner centraliza o envio, a leitura OCR e a análise documental
                        em um fluxo mais claro, moderno e seguro para consulta e conferência.
                    </p>

                    <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                        @auth
                            <a href="{{ route('agro.index') }}"
                               class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3.5 text-sm font-semibold text-emerald-900 shadow-sm transition hover:bg-emerald-50">
                                Entrar no sistema
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center justify-center rounded-2xl bg-white px-6 py-3.5 text-sm font-semibold text-emerald-900 shadow-sm transition hover:bg-emerald-50">
                                Acessar com usuário e senha
                            </a>
                        @endauth
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-3">
                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm font-semibold text-white">Upload simples</div>
                            <p class="mt-2 text-xs leading-6 text-white/65">
                                Envio rápido de imagem ou PDF para análise.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm font-semibold text-white">OCR completo</div>
                            <p class="mt-2 text-xs leading-6 text-white/65">
                                Extração estruturada de conteúdo para revisão.
                            </p>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/10 p-4 backdrop-blur">
                            <div class="text-sm font-semibold text-white">Parecer organizado</div>
                            <p class="mt-2 text-xs leading-6 text-white/65">
                                Resultado consolidado para consulta e tomada de decisão.
                            </p>
                        </div>
                    </div>
                </section>

                <section class="flex items-center justify-center">
                    <div class="w-full max-w-xl rounded-[2rem] border border-white/15 bg-white/10 p-4 shadow-[0_30px_90px_rgba(2,6,23,0.35)] backdrop-blur sm:p-6">
                        <div class="overflow-hidden rounded-[1.75rem] bg-white shadow-2xl">
                            <div class="border-b border-slate-100 px-6 py-6 sm:px-8">
                                <div class="flex items-center gap-4">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 p-2 shadow-sm">
                                        <img src="{{ asset('assets/img/logo-agroseguro.png') }}" alt="Agro Seguro Scanner" class="max-h-12 w-auto">
                                    </div>

                                    <div>
                                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700">
                                            Agro Seguro Scanner
                                        </div>
                                        <div class="mt-1 text-lg font-bold text-slate-900 sm:text-xl">
                                            Painel de acesso
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="px-6 py-6 sm:px-8 sm:py-8">
                                <div class="rounded-2xl bg-slate-50 p-5">
                                    <div class="text-sm font-semibold text-slate-900">
                                        O que você encontra aqui
                                    </div>

                                    <ul class="mt-4 space-y-3 text-sm leading-6 text-slate-600">
                                        <li>• Histórico completo das análises já realizadas</li>
                                        <li>• Consulta de OCR bruto e parecer final</li>
                                        <li>• Fluxo mais confortável para desktop e celular</li>
                                        <li>• Ambiente autenticado e organizado para operação</li>
                                    </ul>
                                </div>

                                <div class="mt-6">
                                    @auth
                                        <a href="{{ route('agro.index') }}"
                                           class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                            Continuar para o sistema
                                        </a>
                                    @else
                                        <a href="{{ route('login') }}"
                                           class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-6 py-3.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700">
                                            Ir para o login
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</body>
</html>