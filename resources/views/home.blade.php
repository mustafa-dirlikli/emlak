@extends('layouts.app')

@section('title', config('app.name') . ' - Ana Sayfa')

@section('content')
<div class="slide-one-item home-slider owl-carousel">

    <div class="site-blocks-cover overlay" style="background-image: url({{ asset('tema/images/hero_bg_1.jpg') }});" data-aos="fade" data-stellar-background-ratio="0.5">
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

    <div class="site-blocks-cover overlay" style="background-image: url({{ asset('tema/images/hero_bg_2.jpg') }});" data-aos="fade" data-stellar-background-ratio="0.5">
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
            <form class="form-search col-md-12" style="margin-top: -100px;" action="{{ route('properties') }}" method="GET">
                <div class="row align-items-end">
                    <div class="col-md-3">
                        <label for="list-types">İlan Tipi</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="type" id="list-types" class="form-control d-block rounded-0">
                                <option value="">Tümü</option>
                                <option value="daire">Daire</option>
                                <option value="arsa">Arsa</option>
                                <option value="isyeri">İş Yeri</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="offer-types">İşlem Tipi</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="offer" id="offer-types" class="form-control d-block rounded-0">
                                <option value="">Tümü</option>
                                <option value="sale">Satılık</option>
                                <option value="rent">Kiralık</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="select-city">Şehir</label>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select name="city" id="select-city" class="form-control d-block rounded-0">
                                <option value="">Tümü</option>
                                <option value="istanbul">İstanbul</option>
                                <option value="ankara">Ankara</option>
                                <option value="izmir">İzmir</option>
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
                    <div class="mr-auto">
                        <a href="{{ url('/') }}" class="icon-view view-module active"><span class="icon-view_module"></span></a>
                        <a href="{{ route('properties') }}?view=list" class="icon-view view-list"><span class="icon-view_list"></span></a>
                    </div>
                    <div class="ml-auto d-flex align-items-center">
                        <div>
                            <a href="{{ route('properties') }}" class="view-list px-3 border-right active">Tümü</a>
                            <a href="{{ route('rent') }}" class="view-list px-3 border-right">Kiralık</a>
                            <a href="{{ route('buy') }}" class="view-list px-3">Satılık</a>
                        </div>
                        <div class="select-wrap">
                            <span class="icon icon-arrow_drop_down"></span>
                            <select class="form-control form-control-sm d-block rounded-0">
                                <option value="">Sırala</option>
                                <option value="price_asc">Fiyat (Artan)</option>
                                <option value="price_desc">Fiyat (Azalan)</option>
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
        <div class="row mb-5">
            @foreach([1,2,3,4,5,6] as $i)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="property-entry h-100">
                    <a href="{{ route('properties') }}" class="property-thumbnail">
                        <div class="offer-type-wrap">
                            <span class="offer-type bg-danger">Satılık</span>
                            <span class="offer-type bg-success">Kiralık</span>
                        </div>
                        <img src="{{ asset('tema/images/img_' . (($i - 1) % 8 + 1) . '.jpg') }}" alt="İlan" class="img-fluid">
                    </a>
                    <div class="p-4 property-body">
                        <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                        <h2 class="property-title"><a href="{{ route('properties') }}">Örnek Emlak İlanı {{ $i }}</a></h2>
                        <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> Örnek Adres, Şehir</span>
                        <strong class="property-price text-primary mb-3 d-block text-success">₺2.265.500</strong>
                        <ul class="property-specs-wrap mb-3 mb-lg-0">
                            <li><span class="property-specs">Oda</span><span class="property-specs-number">2 <sup>+</sup></span></li>
                            <li><span class="property-specs">Banyo</span><span class="property-specs-number">2</span></li>
                            <li><span class="property-specs">m²</span><span class="property-specs-number">150</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
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

<div class="site-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Neden Bizi Seçmelisiniz?</h2>
                </div>
                <p>Güvenilir emlak danışmanlığı, geniş ilan portföyü ve müşteri memnuniyeti odaklı hizmet anlayışımızla yanınızdayız.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('about') }}" class="service text-center">
                    <span class="icon flaticon-house"></span>
                    <h2 class="service-heading">Araştırma</h2>
                    <p>Bölge ve fiyat analizleri ile doğru yatırım kararları.</p>
                    <p><span class="read-more">Devamı</span></p>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('properties') }}" class="service text-center">
                    <span class="icon flaticon-sold"></span>
                    <h2 class="service-heading">Satılık İlanlar</h2>
                    <p>Geniş satılık emlak seçenekleri.</p>
                    <p><span class="read-more">Devamı</span></p>
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('contact') }}" class="service text-center">
                    <span class="icon flaticon-camera"></span>
                    <h2 class="service-heading">Güvenlik</h2>
                    <p>Güvenli alım satım süreçleri ve hukuki destek.</p>
                    <p><span class="read-more">Devamı</span></p>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="site-section bg-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Son Blog Yazıları</h2>
                </div>
                <p>Emlak ve yaşam alanları hakkında güncel içerikler.</p>
            </div>
        </div>
        <div class="row">
            @foreach([4,2,3] as $i)
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                <a href="{{ route('blog') }}"><img src="{{ asset('tema/images/img_' . $i . '.jpg') }}" alt="Blog" class="img-fluid"></a>
                <div class="p-4 bg-white">
                    <span class="d-block text-secondary small text-uppercase">{{ now()->format('d M Y') }}</span>
                    <h2 class="h5 text-black mb-3"><a href="{{ route('blog') }}">Örnek Blog Başlığı</a></h2>
                    <p>Emlak sektörü ve yaşam alanları hakkında bilgilendirici içerik.</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7">
                <div class="site-section-title text-center">
                    <h2>Danışmanlarımız</h2>
                    <p>Deneyimli emlak danışmanlarımız size en uygun çözümü sunmak için hazır.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach([1,2,3] as $i)
            <div class="col-md-6 col-lg-4 mb-5 mb-lg-5">
                <div class="team-member">
                    <img src="{{ asset('tema/images/person_' . $i . '.jpg') }}" alt="Danışman" class="img-fluid rounded mb-4">
                    <div class="text">
                        <h2 class="mb-2 font-weight-light text-black h4">Danışman {{ $i }}</h2>
                        <span class="d-block mb-3 text-white-opacity-05">Emlak Danışmanı</span>
                        <p>Profesyonel emlak danışmanlığı hizmeti.</p>
                        <p>
                            <a href="#" class="text-black p-2"><span class="icon-facebook"></span></a>
                            <a href="#" class="text-black p-2"><span class="icon-twitter"></span></a>
                            <a href="#" class="text-black p-2"><span class="icon-linkedin"></span></a>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
