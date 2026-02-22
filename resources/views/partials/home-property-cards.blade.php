@php
    $featuredProperties = $featuredProperties ?? collect();
    $layout = $layout ?? 'card';
@endphp
@forelse($featuredProperties as $property)
@if($layout === 'list')
<div class="col-12 mb-3">
    <a href="{{ route('properties.show', $property) }}" class="property-entry property-entry-list bg-white border rounded overflow-hidden h-100 d-block text-body" style="text-decoration: none;">
        <div class="row no-gutters align-items-stretch">
            <div class="col-md-4 col-lg-3">
                <div class="property-thumbnail d-block h-100 position-relative" style="min-height: 200px;">
                    <div class="offer-type-wrap position-absolute m-2">
                        @if($property->listing_type === 'sale')
                            <span class="offer-type bg-danger">Satılık</span>
                        @else
                            <span class="offer-type bg-success">Kiralık</span>
                        @endif
                    </div>
                    <img src="{{ $property->image ? asset('storage/'.$property->image) : asset('tema/images/img_1.jpg') }}" alt="{{ $property->title }}" class="img-fluid w-100 h-100" style="object-fit: cover; min-height: 200px;">
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="p-4 property-body d-flex flex-column justify-content-center h-100">
                    <h2 class="property-title h5 mb-2">{{ $property->title }}</h2>
                    <span class="property-location d-block mb-2 text-muted small"><span class="property-icon icon-room"></span> {{ $property->address ?? $property->city ?? '—' }}</span>
                    <strong class="property-price text-primary mb-2 d-block">{{ $property->currency_symbol }}{{ number_format($property->price, 0, ',', '.') }}</strong>
                    <ul class="property-specs-wrap mb-0 list-unstyled d-flex flex-wrap">
                        @if(!$property->isArsaType())
                            <li class="mr-3"><span class="property-specs text-muted">Oda Sayısı:</span> <span class="property-specs-number">{{ $property->oda_salon }}</span></li>
                        @endif
                        <li class="mr-3"><span class="property-specs text-muted">m²:</span> <span class="property-specs-number">{{ $property->area_sqm ?? '—' }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </a>
</div>
@else
<div class="col-md-6 col-lg-4 mb-4">
    <a href="{{ route('properties.show', $property) }}" class="property-entry h-100 d-block text-body" style="text-decoration: none;">
        <div class="property-thumbnail">
            <div class="offer-type-wrap">
                @if($property->listing_type === 'sale')
                    <span class="offer-type bg-danger">Satılık</span>
                @else
                    <span class="offer-type bg-success">Kiralık</span>
                @endif
            </div>
            <img src="{{ $property->image ? asset('storage/'.$property->image) : asset('tema/images/img_1.jpg') }}" alt="{{ $property->title }}" class="img-fluid" style="width:100%;height:280px;object-fit:cover;display:block;">
        </div>
        <div class="p-4 property-body">
            <h2 class="property-title">{{ $property->title }}</h2>
            <span class="property-location d-block mb-3"><span class="property-icon icon-room"></span> {{ $property->address ?? $property->city ?? '—' }}</span>
            <strong class="property-price text-primary mb-3 d-block text-success">{{ $property->currency_symbol }}{{ number_format($property->price, 0, ',', '.') }}</strong>
            <ul class="property-specs-wrap mb-3 mb-lg-0">
                @if(!$property->isArsaType())
                    <li><span class="property-specs">Oda Sayısı</span><span class="property-specs-number">{{ $property->oda_salon }}</span></li>
                @endif
                <li><span class="property-specs">m²</span><span class="property-specs-number">{{ $property->area_sqm ?? '—' }}</span></li>
            </ul>
        </div>
    </a>
</div>
@endif
@empty
<div class="col-12 py-5 text-center">
    <p class="lead text-muted mb-0">Henüz ilan eklenmedi.</p>
</div>
@endforelse