<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', config('app.name'))</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,700,900|Roboto+Mono:300,400,500">
    <link rel="stylesheet" href="{{ asset('tema/fonts/icomoon/style.css') }}">

    <link rel="stylesheet" href="{{ asset('tema/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/mediaelementplayer.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/fonts/flaticon/font/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/fl-bigmug-line.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('tema/css/style.css') }}">

    @stack('styles')
</head>
<body>

<div class="site-loader"></div>

<div class="site-wrap">

    <div class="site-mobile-menu">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <div class="site-navbar mt-4">
        <div class="container py-1">
            <div class="row align-items-center">
                <div class="col-8 col-md-8 col-lg-4">
                    <h1 class="mb-0">
                        <a href="{{ url('/') }}" class="text-white h2 mb-0">
                            <strong>{{ config('app.name', 'Emremlak') }}<span class="text-danger">.</span></strong>
                        </a>
                    </h1>
                </div>
                <div class="col-4 col-md-4 col-lg-8">
                    <nav class="site-navigation text-right text-md-right" role="navigation">
                        <div class="d-inline-block d-lg-none ml-md-0 mr-auto py-3">
                            <a href="#" class="site-menu-toggle js-menu-toggle text-white"><span class="icon-menu h3"></span></a>
                        </div>
                        <ul class="site-menu js-clone-nav d-none d-lg-block">
                            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                                <a href="{{ url('/') }}">Ana Sayfa</a>
                            </li>
                            <li class="{{ request()->routeIs('buy') ? 'active' : '' }}"><a href="{{ route('buy') }}">Satılık</a></li>
                            <li class="{{ request()->routeIs('rent') ? 'active' : '' }}"><a href="{{ route('rent') }}">Kiralık</a></li>
                            <li class="has-children">
                                <a href="{{ route('properties') }}">İlanlar</a>
                                <ul class="dropdown arrow-top">
                                    <li><a href="{{ route('properties') }}">Tümü</a></li>
                                    <li><a href="{{ route('properties', ['type' => 'daire']) }}">Daire</a></li>
                                    <li><a href="{{ route('properties', ['type' => 'arsa']) }}">Arsa</a></li>
                                    <li><a href="{{ route('properties', ['type' => 'isyeri']) }}">İş Yeri</a></li>
                                </ul>
                            </li>
                            <li class="{{ request()->routeIs('blog') ? 'active' : '' }}"><a href="{{ route('blog') }}">Blog</a></li>
                            <li class="{{ request()->routeIs('about') ? 'active' : '' }}"><a href="{{ route('about') }}">Hakkımızda</a></li>
                            <li class="{{ request()->routeIs('contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">İletişim</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-5">
                        <h3 class="footer-heading mb-4">{{ config('app.name', 'Emremlak') }} Hakkında</h3>
                        <p>Emlak alım satım ve kiralama işlemlerinizde güvenilir çözüm ortağınız.</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <div class="row mb-5">
                        <div class="col-md-12">
                            <h3 class="footer-heading mb-4">Menü</h3>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ url('/') }}">Ana Sayfa</a></li>
                                <li><a href="{{ route('buy') }}">Satılık</a></li>
                                <li><a href="{{ route('rent') }}">Kiralık</a></li>
                                <li><a href="{{ route('properties') }}">İlanlar</a></li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <ul class="list-unstyled">
                                <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                                <li><a href="{{ route('contact') }}">İletişim</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <h3 class="footer-heading mb-4">Bizi Takip Edin</h3>
                    <div>
                        <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                        <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                        <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                        <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                    </div>
                </div>
            </div>
            <div class="row pt-5 mt-5 text-center">
                <div class="col-md-12">
                    <p>
                        &copy; {{ date('Y') }} {{ config('app.name') }}. Tüm hakları saklıdır.
                    </p>
                </div>
            </div>
        </div>
    </footer>

</div>

<script src="{{ asset('tema/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('tema/js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('tema/js/jquery-ui.js') }}"></script>
<script src="{{ asset('tema/js/popper.min.js') }}"></script>
<script src="{{ asset('tema/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('tema/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('tema/js/mediaelement-and-player.min.js') }}"></script>
<script src="{{ asset('tema/js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('tema/js/jquery.countdown.min.js') }}"></script>
<script src="{{ asset('tema/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('tema/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('tema/js/aos.js') }}"></script>
<script src="{{ asset('tema/js/main.js') }}"></script>

@stack('scripts')
</body>
</html>
