<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Yönetici Girişi - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:400,600,700">
    <link rel="stylesheet" href="{{ asset('tema/css/bootstrap.min.css') }}">
    <style>
        body { font-family: 'Nunito Sans', sans-serif; background: linear-gradient(135deg, #1a1d23 0%, #252a33 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .login-card { max-width: 400px; width: 100%; background: #fff; border-radius: 12px; box-shadow: 0 20px 60px rgba(0,0,0,.3); padding: 2.5rem; }
        .login-card h1 { font-size: 1.5rem; font-weight: 700; color: #2d3748; margin-bottom: 0.25rem; }
        .login-card .subtitle { color: #718096; font-size: 0.9rem; margin-bottom: 1.5rem; }
        .login-card .form-control { border-radius: 8px; padding: 0.6rem 0.85rem; }
        .login-card .btn-primary { background: #28a745; border: none; border-radius: 8px; padding: 0.65rem; font-weight: 600; }
        .login-card .btn-primary:hover { background: #218838; }
        .login-card a { color: #28a745; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>{{ config('app.name') }}</h1>
        <p class="subtitle">Yönetici paneli girişi</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $err) {{ $err }} @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">E-posta</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Beni hatırla</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Giriş yap</button>
        </form>
        <p class="mt-3 mb-0 text-center small text-muted">
            <a href="{{ url('/') }}">← Siteye dön</a>
        </p>
    </div>
</body>
</html>
