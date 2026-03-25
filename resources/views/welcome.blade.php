<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Agro Seguro Scanner') }}</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            * { box-sizing: border-box; }
            body {
                margin: 0;
                font-family: Arial, Helvetica, sans-serif;
                background: linear-gradient(135deg, #022c22 0%, #064e3b 35%, #0f172a 100%);
                color: #0f172a;
                min-height: 100vh;
            }
            .page {
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 24px;
            }
            .grid {
                width: 100%;
                max-width: 1200px;
                display: grid;
                gap: 24px;
            }
            @media (min-width: 1024px) {
                .grid {
                    grid-template-columns: 1.1fr 0.9fr;
                    gap: 40px;
                }
            }
            .hero h1 {
                color: #fff;
                font-size: 2.3rem;
                line-height: 1.1;
                margin: 18px 0 14px;
            }
            .hero p {
                color: rgba(255,255,255,.78);
                font-size: 1rem;
                line-height: 1.7;
                margin: 0 0 22px;
                max-width: 700px;
            }
            .badge {
                display: inline-block;
                padding: 8px 14px;
                border-radius: 999px;
                background: rgba(255,255,255,.10);
                border: 1px solid rgba(255,255,255,.15);
                color: #d1fae5;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: .18em;
                text-transform: uppercase;
            }
            .actions {
                display: flex;
                flex-direction: column;
                gap: 12px;
                margin-top: 22px;
            }
            @media (min-width: 640px) {
                .actions {
                    flex-direction: row;
                }
            }
            .btn {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 14px 22px;
                border-radius: 18px;
                text-decoration: none;
                font-weight: 700;
                font-size: 14px;
                transition: .2s ease;
            }
            .btn-primary {
                background: #fff;
                color: #065f46;
            }
            .btn-primary:hover {
                background: #ecfdf5;
            }
            .btn-secondary {
                background: rgba(255,255,255,.10);
                color: #fff;
                border: 1px solid rgba(255,255,255,.18);
            }
            .btn-secondary:hover {
                background: rgba(255,255,255,.16);
            }
            .feature-grid {
                display: grid;
                gap: 12px;
                margin-top: 28px;
            }
            @media (min-width: 640px) {
                .feature-grid {
                    grid-template-columns: repeat(3, 1fr);
                }
            }
            .feature {
                border-radius: 20px;
                background: rgba(255,255,255,.10);
                border: 1px solid rgba(255,255,255,.10);
                padding: 18px;
                backdrop-filter: blur(8px);
            }
            .feature strong {
                display: block;
                color: #fff;
                font-size: 14px;
                margin-bottom: 8px;
            }
            .feature span {
                color: rgba(255,255,255,.68);
                font-size: 13px;
                line-height: 1.6;
            }
            .panel-wrap {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .panel-outer {
                width: 100%;
                max-width: 520px;
                border-radius: 30px;
                border: 1px solid rgba(255,255,255,.16);
                background: rgba(255,255,255,.10);
                padding: 16px;
                box-shadow: 0 30px 90px rgba(2,6,23,.35);
            }
            .panel {
                background: #fff;
                border-radius: 26px;
                overflow: hidden;
            }
            .panel-head {
                padding: 26px 26px 20px;
                border-bottom: 1px solid #e2e8f0;
                display: flex;
                gap: 16px;
                align-items: center;
            }
            .logo-box {
                width: 68px;
                height: 68px;
                border-radius: 18px;
                background: #ecfdf5;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 8px;
                flex-shrink: 0;
            }
            .logo-box img {
                max-width: 100%;
                max-height: 48px;
            }
            .panel-head small {
                display: block;
                color: #047857;
                font-size: 11px;
                font-weight: 700;
                letter-spacing: .16em;
                text-transform: uppercase;
                margin-bottom: 6px;
            }
            .panel-head h2 {
                margin: 0;
                font-size: 1.35rem;
                color: #0f172a;
            }
            .panel-body {
                padding: 24px 26px 28px;
            }
            .info-box {
                background: #f8fafc;
                border-radius: 20px;
                padding: 18px;
            }
            .info-box strong {
                display: block;
                color: #0f172a;
                margin-bottom: 10px;
                font-size: 14px;
            }
            .info-box ul {
                padding-left: 18px;
                margin: 0;
                color: #475569;
                font-size: 14px;
                line-height: 1.7;
            }
            .panel-body .btn {
                width: 100%;
                margin-top: 18px;
                background: #059669;
                color: #fff;
            }
            .panel-body .btn:hover {
                background: #047857;
            }
        </style>
    @endif
</head>
<body>
    <div class="page">
        <div class="grid">
            <section class="hero">
                <span class="badge">Plataforma inteligente</span>

                <h1>
                    Agro Seguro Scanner
                </h1>

                <p>
                    Ambiente moderno para envio, leitura OCR e análise documental de notas fiscais,
                    com experiência mais clara, organizada e preparada para desktop e mobile.
                </p>

                <div class="actions">
                    @auth
                        <a href="{{ route('agro.index') }}" class="btn btn-primary">
                            Entrar no sistema
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                            Ir para o dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Acessar sistema
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">
                                Criar conta
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="feature-grid">
                    <div class="feature">
                        <strong>Upload simples</strong>
                        <span>Envio rápido de imagem ou PDF para iniciar a análise.</span>
                    </div>

                    <div class="feature">
                        <strong>OCR estruturado</strong>
                        <span>Extração de conteúdo para revisão e conferência mais eficiente.</span>
                    </div>

                    <div class="feature">
                        <strong>Parecer organizado</strong>
                        <span>Consulta centralizada do resultado e do histórico das análises.</span>
                    </div>
                </div>
            </section>

            <section class="panel-wrap">
                <div class="panel-outer">
                    <div class="panel">
                        <div class="panel-head">
                            <div class="logo-box">
                                <img src="{{ asset('assets/img/logo-agroseguro.png') }}" alt="Agro Seguro Scanner">
                            </div>

                            <div>
                                <small>Agro Seguro Scanner</small>
                                <h2>Painel de acesso</h2>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="info-box">
                                <strong>O que você encontra aqui</strong>
                                <ul>
                                    <li>Histórico completo das análises realizadas</li>
                                    <li>Visualização do OCR bruto e do parecer final</li>
                                    <li>Fluxo mais confortável em celular e computador</li>
                                    <li>Ambiente autenticado e preparado para operação</li>
                                </ul>
                            </div>

                            @auth
                                <a href="{{ route('agro.index') }}" class="btn">
                                    Continuar para o sistema
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn">
                                    Ir para o login
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>
</html>