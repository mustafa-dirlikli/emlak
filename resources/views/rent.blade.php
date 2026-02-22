@extends('layouts.app')

@section('title', 'Kiralık İlanlar - ' . config('app.name'))

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Kiralık Emlak İlanları</h2>
                    <p>Kiralık daire, rezidans ve iş yeri ilanları.</p>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            @forelse($properties ?? [] as $property)
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="{{ route('properties.show', $property) }}" class="property-entry h-100 d-block text-body bg-white" style="text-decoration: none;">
                    <div class="property-thumbnail">
                        <div class="offer-type-wrap">
                            <span class="offer-type bg-success">Kiralık</span>
                        </div>
                        <img src="{{ $property->image ? asset('storage/'.$property->image) : asset('tema/images/img_1.jpg') }}" alt="{{ $property->title }}" class="img-fluid" style="width:100%;height:280px;object-fit:cover;display:block;">
                    </div>
                    <div class="p-4 property-body">
                        <h2 class="property-title">{{ $property->title }}</h2>
                        <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> {{ $property->address ?? $property->city ?? '—' }}</span>
                        <strong class="property-price text-primary mb-3 d-block">{{ $property->currency_symbol }}{{ number_format($property->price, 0, ',', '.') }}/ay</strong>
                        <ul class="property-specs-wrap mb-0">
                            @if(!$property->isArsaType())
                                <li><span class="property-specs">Oda Sayısı</span><span class="property-specs-number">{{ $property->oda_salon }}</span></li>
                            @endif
                            <li><span class="property-specs">m²</span><span class="property-specs-number">{{ $property->area_sqm ?? '—' }}</span></li>
                        </ul>
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <p class="lead text-muted">Şu an kiralık ilan bulunmuyor.</p>
                <a href="{{ route('properties') }}" class="btn btn-primary rounded-0">Tüm İlanları Gör</a>
            </div>
            @endforelse
        </div>
        @if(isset($properties) && $properties->hasPages())
        <div class="row">
            <div class="col-12 text-center">
                {{ $properties->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
