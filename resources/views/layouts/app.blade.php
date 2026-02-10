<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title', config('app.name'))</title>
    @include('layouts.partials.head')
</head>
<body class="{{ request()->routeIs('home') ? '' : 'inner-page' }}">

<div class="site-loader"></div>

<div class="site-wrap">

    @include('layouts.partials.navbar')

    <main class="site-main">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

</div>

@include('layouts.partials.scripts')

</body>
</html>
