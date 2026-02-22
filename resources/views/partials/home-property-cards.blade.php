@php
    $featuredProperties = $featuredProperties ?? collect();
@endphp
@forelse($featuredProperties as $property)
<div class="col-md-6 col-lg-4 mb-4">
    <div class="property-entry h-100">
        <a href="{{ route('properties.show', $property) }}" class="property-thumbnail">
            <div class="offer-type-wrap">
                @if($property->listing_type === 'sale')
                    <span class="offer-type bg-danger">Satılık</span>
                @else
                    <span class="offer-type bg-success">Kiralık</span>
                @endif
            </div>
            <img src="{{ $property->image ? asset('storage/'.$property->image) : asset('tema/images/img_1.jpg') }}" alt="{{ $property->title }}" class="img-fluid" style="width:100%;height:280px;object-fit:cover;display:block;">
        </a>
        <div class="p-4 property-body">
            <h2 class="property-title"><a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a></h2>
            <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> {{ $property->address ?? $property->city ?? '—' }}</span>
            <strong class="property-price text-primary mb-3 d-block text-success">{{ $property->currency_symbol }}{{ number_format($property->price, 0, ',', '.') }}</strong>
            <ul class="property-specs-wrap mb-3 mb-lg-0">
                @if(!$property->isArsaType())
                    <li><span class="property-specs">Oda Sayısı</span><span class="property-specs-number">{{ $property->oda_salon }}</span></li>
                @endif
                <li><span class="property-specs">m²</span><span class="property-specs-number">{{ $property->area_sqm ?? '—' }}</span></li>
            </ul>
        </div>
    </div>
</div>
@empty
@foreach([1,2,3,4,5,6] as $i)
<div class="col-md-6 col-lg-4 mb-4">
    <div class="property-entry h-100">
        <a href="{{ route('properties') }}" class="property-thumbnail">
            <div class="offer-type-wrap">
                <span class="offer-type bg-danger">Satılık</span>
                <span class="offer-type bg-success">Kiralık</span>
            </div>
            <img src="{{ asset('tema/images/img_' . (($i - 1) % 8 + 1) . '.jpg') }}" alt="İlan" class="img-fluid" style="width:100%;height:280px;object-fit:cover;display:block;">
        </a>
        <div class="p-4 property-body">
            <h2 class="property-title"><a href="{{ route('properties') }}">Örnek Emlak İlanı {{ $i }}</a></h2>
            <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> Örnek Adres, Şehir</span>
            <strong class="property-price text-primary mb-3 d-block text-success">₺2.265.500</strong>
            <ul class="property-specs-wrap mb-3 mb-lg-0">
                <li><span class="property-specs">Oda Sayısı</span><span class="property-specs-number">2 <sup>+</sup></span></li>
                <li><span class="property-specs">Banyo</span><span class="property-specs-number">2</span></li>
                <li><span class="property-specs">m²</span><span class="property-specs-number">150</span></li>
            </ul>
        </div>
    </div>
</div>
@endforeach
@endforelse
