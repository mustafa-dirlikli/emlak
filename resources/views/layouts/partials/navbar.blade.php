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
                        <li class="has-children {{ request()->routeIs('properties') ? 'active' : '' }}">
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
