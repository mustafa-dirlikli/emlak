@extends('layouts.app')

@section('title', 'İlanlar - ' . config('app.name'))

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Tüm İlanlar</h2>
                    <p>Satılık ve kiralık emlak ilanları.</p>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            @foreach([1,2,3,4,5,6,7,8] as $i)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="property-entry h-100">
                    <a href="#" class="property-thumbnail">
                        <div class="offer-type-wrap">
                            <span class="offer-type bg-danger">Satılık</span>
                            <span class="offer-type bg-success">Kiralık</span>
                        </div>
                        <img src="{{ asset('tema/images/img_' . (($i - 1) % 8 + 1) . '.jpg') }}" alt="İlan" class="img-fluid">
                    </a>
                    <div class="p-4 property-body">
                        <a href="#" class="property-favorite"><span class="icon-heart-o"></span></a>
                        <h2 class="property-title"><a href="#">Örnek İlan {{ $i }}</a></h2>
                        <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> Örnek Adres</span>
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
                    <a href="#" class="active">1</a>
                    <a href="#">2</a>
                    <a href="#">3</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
