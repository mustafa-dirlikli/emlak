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
<style>
  /* Navbar: tüm sayfalarda koyu arka plan, yazılar okunaklı */
  .site-navbar {
    background: #25262a !important;
  }
  .site-navbar .container.site-navbar-container { padding-top: 0.5rem; padding-bottom: 0.5rem; }
  body.inner-page .site-navbar {
    position: relative;
  }
  .site-navbar .site-logo-wrap { line-height: 0; padding-top: 0.25rem; padding-bottom: 0.25rem; }
  .site-navbar .site-logo-wrap h1 { line-height: 0; margin: 0; }
  .site-navbar .site-logo-wrap a { line-height: 0; display: inline-block; }
  .site-navbar .site-logo-img { max-height: 80px; width: auto; height: auto; display: block; vertical-align: middle; }
  .site-navbar .site-navigation .site-menu > li > a,
  .site-navbar .site-menu-toggle {
    color: #fff !important;
  }
  .site-navbar .site-navigation .site-menu > li > a:hover {
    color: #fff !important;
    opacity: 1;
  }
  .site-navbar .site-navigation .site-menu .active > a {
    color: #fff !important;
  }
  /* İç sayfalarda içerik navbar altında başlasın (navbar artık relative, ekstra padding gerekmez) */
  .inner-page .site-main {
    padding-top: 0;
  }
  /* Footer: koyu arka plan, okunaklı metin */
  .site-footer {
    background: #25262a !important;
    color: #a0aec0;
  }
  .site-footer .footer-heading,
  .site-footer h3 {
    color: #fff !important;
  }
  .site-footer a {
    color: #a0aec0 !important;
  }
  .site-footer a:hover {
    color: #fff !important;
  }
  .site-footer p {
    color: #a0aec0 !important;
  }
  .site-footer .text-center p {
    color: #888 !important;
  }
</style>
@stack('styles')
