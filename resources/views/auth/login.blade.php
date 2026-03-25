<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Agro Seguro Scanner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f5f7fa;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .card {
            background: #ffffff;
            padding: 32px 28px;
            border-radius: 12px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .18);
            width: 100%;
            max-width: 420px;
        }
        .logo {
            display: block;
            margin: 0 auto 16px;
            max-width: 120px;
        }
        h1 {
            margin: 0 0 4px;
            text-align: center;
            font-size: 1.4rem;
        }
        p.subtitle {
            text-align: center;
            margin-top: 0;
            margin-bottom: 20px;
            color: #555;
        }
        label {
            display: block;
            margin-bottom: 4px;
            font-size: .9rem;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: .95rem;
            margin-bottom: 12px;
            box-sizing: border-box;
        }
        .btn-primary {
            width: 100%;
            padding: 11px 16px;
            border-radius: 999px;
            border: none;
            background: #1c8753;
            color: #fff;
            font-weight: 600;
            font-size: .98rem;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #156b41;
        }
        .error {
            color: #b91c1c;
            font-size: .85rem;
            margin-bottom: 8px;
        }
        .remember {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 16px;
            font-size: .9rem;
        }
    </style>
</head>
<body>
<div class="card">
    <img src="{{ asset('assets/img/logo-agroseguro.png') }}"
     alt="Agro Seguro Scanner"
     class="logo">


    <p class="subtitle">Acesso restrito a usuários autorizados</p>

    @if ($errors->any())
        <div class="error">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <label for="email">E-mail</label>
        <input
            id="email"
            type="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
        >

        <label for="password">Senha</label>
        <input
            id="password"
            type="password"
            name="password"
            required
        >

        <div class="remember">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" style="margin: 0;">Manter conectado</label>
        </div>

        <button type="submit" class="btn-primary">
            Entrar
        </button>
    </form>
</div>
</body>
</html>