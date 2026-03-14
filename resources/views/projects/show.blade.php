@extends('layouts.app')

@section('title', $project->title . ' - ' . config('app.name'))

@push('styles')
<style>
.spec-table td { padding: 0.35rem 0.5rem 0.35rem 0; vertical-align: top; }
.spec-table td:first-child { width: 45%; }
.property-detail-main-wrap { width: 100%; max-width: 720px; height: 480px; overflow: hidden; background: #eee; }
.property-detail-main-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.property-gallery-thumbs { display: flex; flex-wrap: wrap; gap: 8px; }
.property-gallery-thumb { width: 70px; height: 50px; object-fit: cover; border-radius: 4px; cursor: pointer; }
.property-gallery-lightbox { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,.92); align-items: center; justify-content: center; }
.property-gallery-lightbox.is-open { display: flex; }
.property-gallery-lightbox img.lightbox-main { max-width: 90vw; max-height: 85vh; object-fit: contain; }
.property-gallery-lightbox .lightbox-close { position: absolute; top: 16px; right: 20px; width: 44px; height: 44px; border: none; background: rgba(255,255,255,.2); color: #fff; font-size: 28px; cursor: pointer; border-radius: 8px; }
.property-gallery-lightbox .lightbox-prev, .property-gallery-lightbox .lightbox-next { position: absolute; top: 50%; transform: translateY(-50%); width: 48px; height: 48px; border: none; background: rgba(255,255,255,.2); color: #fff; font-size: 24px; cursor: pointer; border-radius: 50%; }
.property-gallery-lightbox .lightbox-prev { left: 16px; }
.property-gallery-lightbox .lightbox-next { right: 16px; }
.property-gallery-lightbox .lightbox-counter { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,.9); font-size: 14px; }
#detailTabs .nav-link { color: #333; }
#detailTabs .nav-link.active { background: #ffc107 !important; color: #000; font-weight: 600; }
</style>
@endpush

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="h2 font-weight-bold text-dark mb-2">{{ $project->title }}</h1>
                <p class="text-muted mb-0">
                    <span class="icon-room mr-1"></span>
                    @if($project->city || $project->district || $project->neighborhood || $project->address)
                        {{ implode(' / ', array_filter([$project->city, $project->district, $project->neighborhood, $project->address])) }}
                    @else
                        —
                    @endif
                </p>
            </div>
            <div class="col-lg-4 text-lg-right mt-2 mt-lg-0">
                <div class="h2 font-weight-bold text-primary mb-0">{{ $project->currency_symbol }}{{ number_format($project->price, 0, ',', '.') }}</div>
                <small class="text-muted">{{ $project->listing_type_label }} · {{ $project->property_type_label }}</small>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="bg-white border rounded overflow-hidden">
                    @php
                        $mainImage = $project->image ? asset('storage/'.$project->image) : asset('tema/images/img_1.jpg');
                        $gallery = $project->gallery ?? [];
                        if ($project->image) {
                            $gallery = array_merge([$project->image], is_array($gallery) ? $gallery : []);
                        }
                        $gallery = array_unique(array_filter($gallery));
                        $galleryUrls = array_map(function($p) { return asset('storage/'.$p); }, $gallery);
                    @endphp
                    <div class="property-detail-main-wrap property-gallery-trigger" data-gallery-index="0" data-gallery-urls="{{ json_encode($galleryUrls) }}">
                        <img id="propertyMainImage" src="{{ $mainImage }}" alt="{{ $project->title }}">
                    </div>
                    @if(count($gallery) > 0)
                        <div class="px-3 pb-3 property-gallery-thumbs">
                            @foreach($gallery as $idx => $imgPath)
                                <img src="{{ asset('storage/'.$imgPath) }}" alt="" class="property-gallery-thumb property-gallery-trigger" data-gallery-index="{{ $idx }}" data-gallery-urls="{{ json_encode($galleryUrls) }}">
                            @endforeach
                        </div>
                    @endif
                    <div id="propertyGalleryLightbox" class="property-gallery-lightbox" role="dialog">
                        <button type="button" class="lightbox-close" id="lightboxClose">&times;</button>
                        <button type="button" class="lightbox-prev" id="lightboxPrev">&lsaquo;</button>
                        <img src="" alt="" class="lightbox-main" id="lightboxMainImage">
                        <button type="button" class="lightbox-next" id="lightboxNext">&rsaquo;</button>
                        <span class="lightbox-counter" id="lightboxCounter"></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="bg-white border rounded p-4">
                    <table class="table table-sm table-borderless mb-0 spec-table">
                        <tbody>
                            <tr><td class="text-muted">Tip</td><td>{{ $project->listing_type_label }} {{ $project->property_type_label }}</td></tr>
                            @if($project->area_sqm)<tr><td class="text-muted">m²</td><td>{{ $project->area_sqm }}</td></tr>@endif
                            @if($project->oda_salon && !$project->isArsaType())<tr><td class="text-muted">Oda + Salon</td><td>{{ $project->oda_salon }}</td></tr>@endif
                            @if($project->city)<tr><td class="text-muted">Konum</td><td>{{ $project->city }}@if($project->district) / {{ $project->district }}@endif</td></tr>@endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="bg-white border rounded overflow-hidden mb-4">
            <div class="p-4">
                <h5 class="mb-3">Açıklama</h5>
                @if($project->description)
                    <div class="text-body">{!! nl2br(e($project->description)) !!}</div>
                @else
                    <p class="text-muted mb-0">Açıklama eklenmemiş.</p>
                @endif
            </div>
            @if($project->latitude && $project->longitude && config('services.google_maps.api_key'))
                <div class="p-4 border-top">
                    <h6 class="mb-2">Konum</h6>
                    <div id="project-show-map" style="width:100%; height:300px; border-radius:8px; overflow:hidden;"></div>
                </div>
                @push('scripts')
                <script>
                (function() {
                    var lat = {{ (float) $project->latitude }};
                    var lng = {{ (float) $project->longitude }};
                    var key = @json(config('services.google_maps.api_key'));
                    function init() {
                        var map = new google.maps.Map(document.getElementById('project-show-map'), { center: { lat: lat, lng: lng }, zoom: 16 });
                        new google.maps.Marker({ position: { lat: lat, lng: lng }, map: map });
                    }
                    if (typeof google !== 'undefined' && google.maps) init();
                    else { window.initProjectMap = init; var s = document.createElement('script'); s.src = 'https://maps.googleapis.com/maps/api/js?key=' + key + '&callback=initProjectMap'; s.async = true; document.head.appendChild(s); }
                })();
                </script>
                @endpush
            @endif
        </div>

        <div class="mb-4">
            <a href="{{ route('projects') }}" class="btn btn-outline-primary">← Projelerimize dön</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var lightbox = document.getElementById('propertyGalleryLightbox');
    var lightboxImg = document.getElementById('lightboxMainImage');
    var mainImg = document.getElementById('propertyMainImage');
    var galleryUrls = [];
    document.querySelectorAll('.property-gallery-trigger').forEach(function(el) {
        el.addEventListener('click', function() {
            var urls = this.getAttribute('data-gallery-urls');
            var idx = parseInt(this.getAttribute('data-gallery-index'), 10) || 0;
            if (urls) { try { galleryUrls = JSON.parse(urls); } catch (e) { galleryUrls = []; } }
            if (galleryUrls.length && lightboxImg) { lightboxImg.src = galleryUrls[idx]; lightbox.classList.add('is-open'); document.body.style.overflow = 'hidden'; }
        });
    });
    if (document.getElementById('lightboxClose')) document.getElementById('lightboxClose').addEventListener('click', function() { lightbox.classList.remove('is-open'); document.body.style.overflow = ''; });
})();
</script>
@endpush
@endsection
