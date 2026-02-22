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
        :root { --admin-sidebar: #1a1d23; --admin-sidebar-width: 260px; --admin-sidebar-collapsed-width: 70px; --admin-accent: #28a745; }
        body { font-family: 'Nunito Sans', sans-serif; background: #f4f5f7; min-height: 100vh; transition: margin-left .25s ease; }
        .admin-wrap { display: flex; min-height: 100vh; }
        .admin-sidebar {
            width: var(--admin-sidebar-width); background: var(--admin-sidebar); color: #a0aec0;
            flex-shrink: 0; position: fixed; top: 0; left: 0; height: 100vh; overflow-x: hidden; overflow-y: auto; z-index: 100;
            transition: width .25s ease;
        }
        body.admin-sidebar-collapsed .admin-sidebar { width: var(--admin-sidebar-collapsed-width); }
        body.admin-sidebar-collapsed .admin-main { margin-left: var(--admin-sidebar-collapsed-width); }
        .admin-sidebar .brand {
            padding: 1rem 1rem; font-weight: 700; font-size: 1.25rem; color: #fff;
            border-bottom: 1px solid rgba(255,255,255,.06);
            display: flex; align-items: center; justify-content: space-between; gap: 0.5rem;
        }
        .admin-sidebar .brand a { color: inherit; text-decoration: none; white-space: nowrap; overflow: hidden; min-width: 0; transition: opacity .2s; }
        body.admin-sidebar-collapsed .admin-sidebar .brand a { font-size: 0; opacity: 0; width: 0; }
        .admin-sidebar .brand span { color: var(--admin-accent); }
        #admin-sidebar-toggle {
            flex-shrink: 0; width: 36px; height: 36px; border: none; background: rgba(255,255,255,.08);
            color: #a0aec0; border-radius: 6px; cursor: pointer; display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; transition: background .15s, color .15s;
        }
        #admin-sidebar-toggle:hover { background: rgba(255,255,255,.12); color: #fff; }
        body.admin-sidebar-collapsed #admin-sidebar-toggle { margin: 0 auto; }
        .admin-sidebar .nav { padding: 0.75rem 0; list-style: none; }
        .admin-sidebar .nav-link {
            display: flex; align-items: center; min-height: 44px;
            padding: 0.5rem 1.25rem; margin: 0 0.5rem; border-radius: 8px;
            color: #a0aec0; text-decoration: none; font-size: 0.9375rem; font-weight: 500;
            transition: background .15s, color .15s; white-space: nowrap;
        }
        body.admin-sidebar-collapsed .admin-sidebar .nav-link {
            padding: 0.5rem; margin: 0 0.5rem; min-height: 44px; justify-content: center;
        }
        .admin-sidebar .nav-link:hover { background: rgba(255,255,255,.08); color: #fff; }
        .admin-sidebar .nav-link.active { background: rgba(40,167,69,.2); color: var(--admin-accent); }
        .admin-sidebar .nav-link .icon {
            margin-right: 0.875rem; font-size: 1.15rem; width: 1.25rem; text-align: center; flex-shrink: 0;
            line-height: 1; vertical-align: middle;
        }
        body.admin-sidebar-collapsed .admin-sidebar .nav-link .icon { margin-right: 0; }
        .admin-sidebar .nav-link .nav-text { line-height: 1.4; overflow: hidden; }
        body.admin-sidebar-collapsed .admin-sidebar .nav-link .nav-text { width: 0; opacity: 0; overflow: hidden; }
        .admin-sidebar .nav form { margin: 0 0.5rem; }
        .admin-sidebar .nav form .nav-link { width: 100%; margin: 0; }
        .admin-sidebar .nav-divider { height: 1px; background: rgba(255,255,255,.06); margin: 0.625rem 1rem; }
        body.admin-sidebar-collapsed .admin-sidebar .nav-divider { margin: 0.625rem 0.5rem; }
        .admin-main { flex: 1; margin-left: var(--admin-sidebar-width); padding: 1.5rem 2rem; transition: margin-left .25s ease; }
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
            .admin-sidebar { width: 260px !important; transform: translateX(-100%); }
            body.admin-sidebar-collapsed .admin-sidebar { transform: translateX(-100%); }
            body.admin-sidebar-collapsed .admin-main { margin-left: 0; }
            .admin-main { margin-left: 0 !important; }
            body.admin-sidebar-open .admin-sidebar { transform: translateX(0); }
            .admin-sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 99; }
            body.admin-sidebar-open .admin-sidebar-overlay { display: block; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-wrap">
    <div class="admin-sidebar-overlay" id="admin-sidebar-overlay" aria-hidden="true"></div>
    <aside class="admin-sidebar" id="admin-sidebar">
        <div class="brand">
            <a href="{{ route('admin.dashboard') }}">{{ config('app.name') }}<span>.</span></a>
            <button type="button" id="admin-sidebar-toggle" aria-label="Menüyü aç/kapat" title="Menüyü aç/kapat">
                <span class="icon icon-navicon" id="admin-sidebar-toggle-icon"></span>
            </button>
        </div>
        <nav class="nav p-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="icon icon-home"></span><span class="nav-text">Panel</span>
            </a>
            <a href="{{ route('admin.properties.index') }}" class="nav-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
                <span class="icon icon-th-large"></span><span class="nav-text">İlanlar</span>
            </a>
            <a href="{{ route('admin.properties.create') }}" class="nav-link {{ request()->routeIs('admin.properties.create') ? 'active' : '' }}">
                <span class="icon icon-plus"></span><span class="nav-text">Yeni İlan</span>
            </a>
            <div class="nav-divider"></div>
            <a href="{{ url('/') }}" class="nav-link" target="_blank">
                <span class="icon icon-external-link"></span><span class="nav-text">Siteye Git</span>
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent d-flex align-items-center" style="cursor:pointer;color:#a0aec0;">
                    <span class="icon icon-power-off"></span><span class="nav-text">Çıkış</span>
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
<script>
(function() {
    var toggle = document.getElementById('admin-sidebar-toggle');
    var overlay = document.getElementById('admin-sidebar-overlay');
    var body = document.body;

    function isCollapsed() { return body.classList.contains('admin-sidebar-collapsed'); }
    function isMobile() { return window.innerWidth <= 991; }

    function openSidebar() {
        body.classList.remove('admin-sidebar-collapsed');
        if (isMobile()) body.classList.add('admin-sidebar-open');
        try { localStorage.setItem('admin-sidebar-collapsed', '0'); } catch (e) {}
    }
    function closeSidebar() {
        body.classList.add('admin-sidebar-collapsed');
        if (isMobile()) body.classList.remove('admin-sidebar-open');
        try { localStorage.setItem('admin-sidebar-collapsed', '1'); } catch (e) {}
    }
    function toggleSidebar() {
        if (isMobile()) {
            body.classList.toggle('admin-sidebar-open');
        } else {
            if (isCollapsed()) openSidebar(); else closeSidebar();
        }
    }

    if (toggle) toggle.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', function() { body.classList.remove('admin-sidebar-open'); });

    try {
        if (!isMobile() && localStorage.getItem('admin-sidebar-collapsed') === '1') closeSidebar();
    } catch (e) {}
    window.addEventListener('resize', function() {
        if (!isMobile() && body.classList.contains('admin-sidebar-open')) body.classList.remove('admin-sidebar-open');
    });
})();
</script>
@stack('scripts')
</body>
</html>
