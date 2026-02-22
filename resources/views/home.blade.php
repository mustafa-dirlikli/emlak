@extends('layouts.app')

@section('title', config('app.name') . ' - Ana Sayfa')

@section('content')
<div class="slide-one-item home-slider owl-carousel">

    <div class="site-blocks-cover overlay" style="background-image: url('{{ asset('tema/images/hero_bg_1.jpg') }}');" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10">
                    <span class="d-inline-block bg-success text-white px-3 mb-3 property-offer-type rounded">Kiralık</span>
                    <h1 class="mb-2">Örnek Mülk 1</h1>
                    <p class="mb-5"><strong class="h2 text-success font-weight-bold">₺2.250.500</strong></p>
                    <p><a href="{{ route('properties') }}" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">Detaylar</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="site-blocks-cover overlay" style="background-image: url('{{ asset('tema/images/hero_bg_2.jpg') }}');" data-aos="fade" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10">
                    <span class="d-inline-block bg-danger text-white px-3 mb-3 property-offer-type rounded">Satılık</span>
                    <h1 class="mb-2">Örnek Mülk 2</h1>
                    <p class="mb-5"><strong class="h2 text-success font-weight-bold">₺1.000.500</strong></p>
                    <p><a href="{{ route('properties') }}" class="btn btn-white btn-outline-white py-3 px-5 rounded-0 btn-2">Detaylar</a></p>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="site-section site-section-sm pb-0">
    <div class="container">
        <div class="row">
            <form class="form-search col-md-12" style="margin-top: -100px;" action="{{ route('home') }}" method="GET" id="home-filter-form">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="list-types">İlan Tipi</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="type" id="list-types" class="form-control d-block rounded-0">
                                <option value="" {{ request('type') == '' ? 'selected' : '' }}>Tümü</option>
                                <option value="daire" {{ request('type') == 'daire' ? 'selected' : '' }}>Daire</option>
                                <option value="arsa" {{ request('type') == 'arsa' ? 'selected' : '' }}>Arsa</option>
                                <option value="isyeri" {{ request('type') == 'isyeri' ? 'selected' : '' }}>İş Yeri</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="offer-types">İşlem Tipi</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="offer" id="offer-types" class="form-control d-block rounded-0">
                                <option value="" {{ request('offer') == '' ? 'selected' : '' }}>Tümü</option>
                                <option value="sale" {{ request('offer') == 'sale' ? 'selected' : '' }}>Satılık</option>
                                <option value="rent" {{ request('offer') == 'rent' ? 'selected' : '' }}>Kiralık</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="select-city">Şehir</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="city" id="select-city" class="form-control d-block rounded-0">
                                <option value="" {{ request('city') == '' ? 'selected' : '' }}>Tümü</option>
                                <option value="istanbul" {{ request('city') == 'istanbul' ? 'selected' : '' }}>İstanbul</option>
                                <option value="ankara" {{ request('city') == 'ankara' ? 'selected' : '' }}>Ankara</option>
                                <option value="izmir" {{ request('city') == 'izmir' ? 'selected' : '' }}>İzmir</option>
                                <option value="antalya" {{ request('city') == 'antalya' ? 'selected' : '' }}>Antalya</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-success text-white btn-block rounded-0">Ara</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="view-options bg-white py-3 px-3 d-md-flex align-items-center">
                    <div class="mr-auto d-flex align-items-center">
                        <a href="{{ route('home') }}" class="icon-view view-module active mr-2" id="view-module" title="Kart görünümü"><span class="icon-view_module"></span></a>
                        <a href="{{ route('properties') }}?view=list" class="icon-view view-list" id="view-list-link" title="Liste görünümü"><span class="icon-view_list"></span></a>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        <div>
                            <a href="#" class="view-option-link view-list px-3 border-right {{ !request('offer') ? 'active' : '' }}" data-offer="">Tümü</a>
                            <a href="#" class="view-option-link view-list px-3 border-right {{ request('offer') === 'rent' ? 'active' : '' }}" data-offer="rent">Kiralık</a>
                            <a href="#" class="view-option-link view-list px-3 {{ request('offer') === 'sale' ? 'active' : '' }}" data-offer="sale">Satılık</a>
                        </div>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select class="form-control form-control-sm d-block rounded-0" name="sort" id="home-sort">
                                <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sırala</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Fiyat (Artan)</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Fiyat (Azalan)</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5" id="home-property-cards">
            @include('partials.home-property-cards', ['featuredProperties' => $featuredProperties ?? collect()])
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="site-pagination">
                    <a href="{{ route('properties') }}" class="active">1</a>
                    <a href="{{ route('properties') }}?page=2">2</a>
                    <a href="{{ route('properties') }}?page=3">3</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var form = document.getElementById('home-filter-form');
    var container = document.getElementById('home-property-cards');
    var listTypes = document.getElementById('list-types');
    var offerTypes = document.getElementById('offer-types');
    var selectCity = document.getElementById('select-city');
    var homeSort = document.getElementById('home-sort');
    var filterUrl = '{{ route("home.filter") }}';
    var propertiesUrl = '{{ route("properties") }}';

    function getFilterParams() {
        var params = new URLSearchParams();
        if (listTypes && listTypes.value) params.set('type', listTypes.value);
        if (offerTypes && offerTypes.value) params.set('offer', offerTypes.value);
        if (selectCity && selectCity.value) params.set('city', selectCity.value);
        if (homeSort && homeSort.value) params.set('sort', homeSort.value);
        return params.toString();
    }

    function setOfferActiveState(offerValue) {
        var links = document.querySelectorAll('.view-option-link');
        links.forEach(function(link) {
            var isActive = (link.getAttribute('data-offer') || '') === (offerValue || '');
            link.classList.toggle('active', isActive);
        });
    }

    function loadFiltered() {
        var query = getFilterParams();
        var url = query ? filterUrl + '?' + query : filterUrl;
        if (container) {
            container.style.opacity = '0.6';
            container.style.pointerEvents = 'none';
        }
        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' } })
            .then(function(r) { return r.text(); })
            .then(function(html) {
                if (container) {
                    container.innerHTML = html;
                    container.style.opacity = '';
                    container.style.pointerEvents = '';
                }
                if (typeof history !== 'undefined' && history.replaceState) {
                    var newUrl = window.location.pathname + (query ? '?' + query : '');
                    history.replaceState({}, '', newUrl);
                }
                setOfferActiveState(offerTypes ? offerTypes.value : '');
            })
            .catch(function() {
                if (container) {
                    container.style.opacity = '';
                    container.style.pointerEvents = '';
                }
            });
    }

    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            loadFiltered();
        });
    }
    if (listTypes) listTypes.addEventListener('change', loadFiltered);
    if (offerTypes) {
        offerTypes.addEventListener('change', function() {
            setOfferActiveState(offerTypes.value);
            loadFiltered();
        });
    }
    if (selectCity) selectCity.addEventListener('change', loadFiltered);
    if (homeSort) homeSort.addEventListener('change', loadFiltered);

    document.querySelectorAll('.view-option-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var offer = this.getAttribute('data-offer') || '';
            if (offerTypes) offerTypes.value = offer;
            setOfferActiveState(offer);
            loadFiltered();
        });
    });

    function setViewIconActive(activeView) {
        var viewModule = document.getElementById('view-module');
        var viewList = document.getElementById('view-list-link');
        if (viewModule) viewModule.classList.toggle('active', activeView === 'module');
        if (viewList) viewList.classList.toggle('active', activeView === 'list');
    }

    var viewModuleLink = document.getElementById('view-module');
    if (viewModuleLink) {
        viewModuleLink.addEventListener('click', function(e) {
            e.preventDefault();
            setViewIconActive('module');
        });
    }

    var viewListLink = document.getElementById('view-list-link');
    if (viewListLink) {
        viewListLink.addEventListener('click', function(e) {
            e.preventDefault();
            setViewIconActive('list');
            var query = getFilterParams();
            var url = propertiesUrl + (query ? '?' + query + '&view=list' : '?view=list');
            window.location.href = url;
        });
    }
})();
</script>
@endpush
@endsection
