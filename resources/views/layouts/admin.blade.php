<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', 'Panel') - {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700">
    <link rel="stylesheet" href="{{ asset('tema/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/fonts/icomoon/style.css') }}">
    <style>
        :root { --admin-sidebar: #1a1d23; --admin-sidebar-width: 260px; --admin-accent: #28a745; }
        body { font-family: 'Nunito Sans', sans-serif; background: #f4f5f7; min-height: 100vh; }
        .admin-wrap { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: var(--admin-sidebar-width); background: var(--admin-sidebar); color: #a0aec0;
            flex-shrink: 0; position: fixed; top: 0; left: 0; height: 100vh; overflow-y: auto; z-index: 100;
        }
        .admin-sidebar .brand {
            padding: 1.25rem 1.5rem; font-weight: 700; font-size: 1.25rem; color: #fff;
            border-bottom: 1px solid rgba(255,255,255,.06);
        }
        .admin-sidebar .brand a { color: inherit; text-decoration: none; }
        .admin-sidebar .brand span { color: var(--admin-accent); }
        .admin-sidebar .nav { padding: 1rem 0; }
        .admin-sidebar .nav-link {
            display: flex; align-items: center; padding: 0.65rem 1.5rem; color: #a0aec0;
            text-decoration: none; transition: background .15s, color .15s;
        }
        .admin-sidebar .nav-link:hover { background: rgba(255,255,255,.05); color: #fff; }
        .admin-sidebar .nav-link.active { background: rgba(40,167,69,.15); color: var(--admin-accent); }
        .admin-sidebar .nav-link .icon { margin-right: 0.75rem; font-size: 1.1rem; width: 1.25rem; text-align: center; }
        .admin-sidebar .nav-divider { height: 1px; background: rgba(255,255,255,.06); margin: 0.5rem 1rem; }
        .admin-main { flex: 1; margin-left: var(--admin-sidebar-width); padding: 1.5rem 2rem; }
        .admin-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem; }
        .admin-header h1 { font-size: 1.5rem; font-weight: 600; color: #2d3748; margin: 0; }
        .admin-card { background: #fff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.08); padding: 1.5rem; margin-bottom: 1.5rem; }
        .admin-table { margin: 0; }
        .admin-table th { font-weight: 600; color: #4a5568; border-top: none; }
        .btn-admin { background: var(--admin-accent); color: #fff; border: none; padding: 0.5rem 1rem; border-radius: 6px; }
        .btn-admin:hover { background: #218838; color: #fff; }
        .badge-sale { background: #dc3545; }
        .badge-rent { background: #28a745; }
        @media (max-width: 991px) {
            .admin-sidebar { transform: translateX(-100%); }
            .admin-main { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-wrap">
    <aside class="admin-sidebar">
        <div class="brand">
            <a href="{{ route('admin.dashboard') }}">{{ config('app.name') }}<span>.</span></a>
        </div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon icon-home"></span> Panel
            </a>
            <a href="{{ route('admin.properties.index') }}" class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                <span class="icon icon-th-large"></span> İlanlar
            </a>
            <a href="{{ route('admin.properties.create') }}" class="nav-link {{ request()->routeIs('admin.properties.create') ? 'active' : '' }}">
                <span class="icon icon-plus"></span> Yeni İlan
            </a>
            <div class="nav-divider"></div>
            <a href="{{ url('/') }}" class="nav-link" target="_blank">
                <span class="icon icon-external-link"></span> Siteye Git
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="px-3 pt-2">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent" style="cursor:pointer;color:#a0aec0;">
                    <span class="icon icon-power-off"></span> Çıkış
                </button>
            </form>
        </nav>
    </aside>
    <main class="admin-main">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif
        @yield('content')
    </main>
</div>
<script src="{{ asset('tema/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('tema/js/popper.min.js') }}"></script>
<script src="{{ asset('tema/js/bootstrap.min.js') }}"></script>
@stack('scripts')
</body>
</html>
