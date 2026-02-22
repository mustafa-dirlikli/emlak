@extends('layouts.app')

@section('title', $property->title . ' - ' . config('app.name'))

@push('styles')
<style>
.spec-table td { padding: 0.35rem 0.5rem 0.35rem 0; vertical-align: top; }
.spec-table td:first-child { width: 45%; }
#detailTabs .nav-link { color: #333; }
#detailTabs .nav-link.active { background: #ffc107 !important; color: #000; font-weight: 600; }
/* Sabit ebatlar: ana görsel ve galeri thumb'ları */
.property-detail-main-wrap { width: 100%; max-width: 720px; height: 480px; overflow: hidden; background: #eee; cursor: pointer; }
.property-detail-main-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
.property-gallery-thumbs { display: flex; flex-wrap: wrap; gap: 8px; }
.property-gallery-thumb { width: 70px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #dee2e6; cursor: pointer; flex-shrink: 0; }
/* Lightbox popup galeri */
.property-gallery-lightbox { display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,.92); align-items: center; justify-content: center; }
.property-gallery-lightbox.is-open { display: flex; }
.property-gallery-lightbox img.lightbox-main { max-width: 90vw; max-height: 85vh; width: auto; height: auto; object-fit: contain; }
.property-gallery-lightbox .lightbox-close { position: absolute; top: 16px; right: 20px; width: 44px; height: 44px; border: none; background: rgba(255,255,255,.2); color: #fff; font-size: 28px; line-height: 1; cursor: pointer; border-radius: 8px; }
.property-gallery-lightbox .lightbox-close:hover { background: rgba(255,255,255,.35); }
.property-gallery-lightbox .lightbox-prev, .property-gallery-lightbox .lightbox-next { position: absolute; top: 50%; transform: translateY(-50%); width: 48px; height: 48px; border: none; background: rgba(255,255,255,.2); color: #fff; font-size: 24px; cursor: pointer; border-radius: 50%; }
.property-gallery-lightbox .lightbox-prev { left: 16px; }
.property-gallery-lightbox .lightbox-next { right: 16px; }
.property-gallery-lightbox .lightbox-prev:hover, .property-gallery-lightbox .lightbox-next:hover { background: rgba(255,255,255,.35); }
.property-gallery-lightbox .lightbox-counter { position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%); color: rgba(255,255,255,.9); font-size: 14px; }
</style>
@endpush

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        {{-- Başlık, fiyat, konum --}}
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="h2 font-weight-bold text-dark mb-2">{{ $property->title }}</h1>
                <p class="text-muted mb-0">
                    <span class="icon-room mr-1"></span>
                    @if($property->city || $property->district || $property->neighborhood || $property->address)
                        {{ implode(' / ', array_filter([$property->city, $property->district, $property->neighborhood, $property->address])) }}
                    @else
                        —
                    @endif
                </p>
            </div>
            <div class="col-lg-4 text-lg-right mt-2 mt-lg-0">
                <div class="h2 font-weight-bold text-primary mb-0">{{ $property->currency_symbol }}{{ number_format($property->price, 0, ',', '.') }}</div>
                <small class="text-muted">{{ $property->listing_type_label }} · {{ $property->property_type_label }}</small>
            </div>
        </div>

        <div class="row">
            {{-- Sol: Görsel ve galeri --}}
            <div class="col-lg-8 mb-4">
                <div class="bg-white border rounded overflow-hidden">
                    @php
                            $mainImage = $property->image ? asset('storage/'.$property->image) : asset('tema/images/img_1.jpg');
                            $gallery = $property->gallery ?? [];
                            if ($property->image) {
                                $gallery = array_merge([$property->image], is_array($gallery) ? $gallery : []);
                            }
                            $gallery = array_unique(array_filter($gallery));
                            $galleryUrls = array_map(function($p) { return asset('storage/'.$p); }, $gallery);
                        @endphp
                    <div class="position-relative">
                        <div class="property-detail-main-wrap property-gallery-trigger" data-gallery-index="0" data-gallery-urls="{{ json_encode($galleryUrls) }}">
                            <img id="propertyMainImage" src="{{ $mainImage }}" alt="{{ $property->title }}">
                            @if($property->ilan_no)
                                <span class="position-absolute badge bg-light text-dark m-2" style="top:0; left:0;">{{ $property->ilan_no }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="px-3 py-2 border-top d-flex align-items-center">
                        <span class="text-muted small">Görsellere tıklayarak galeriyi açabilirsiniz.</span>
                        @if(count($gallery) > 0)
                            <span class="text-muted small ml-auto">{{ count($gallery) }} Fotoğraf</span>
                        @endif
                    </div>
                    @if(count($gallery) > 0)
                        <div class="px-3 pb-3 property-gallery-thumbs">
                            @foreach($gallery as $idx => $imgPath)
                                <img src="{{ asset('storage/'.$imgPath) }}" alt="" class="property-gallery-thumb property-gallery-trigger" data-gallery-index="{{ $idx }}" data-gallery-urls="{{ json_encode($galleryUrls) }}">
                            @endforeach
                        </div>
                    @endif
                    {{-- Popup galeri --}}
                    <div id="propertyGalleryLightbox" class="property-gallery-lightbox" role="dialog" aria-label="Galeri">
                        <button type="button" class="lightbox-close" id="lightboxClose" aria-label="Kapat">&times;</button>
                        <button type="button" class="lightbox-prev" id="lightboxPrev" aria-label="Önceki">&lsaquo;</button>
                        <img src="" alt="" class="lightbox-main" id="lightboxMainImage">
                        <button type="button" class="lightbox-next" id="lightboxNext" aria-label="Sonraki">&rsaquo;</button>
                        <span class="lightbox-counter" id="lightboxCounter"></span>
                    </div>
                </div>
            </div>

            {{-- Sağ: Özellikler listesi --}}
            <div class="col-lg-4 mb-4">
                <div class="bg-white border rounded p-4">
                    <table class="table table-sm table-borderless mb-0 spec-table">
                        <tbody>
                            @if($property->ilan_no)
                                <tr><td class="text-muted">İlan No</td><td class="font-weight-bold text-danger">{{ $property->ilan_no }}</td></tr>
                            @endif
                            @if($property->ilan_tarihi)
                                <tr><td class="text-muted">İlan Tarihi</td><td>{{ $property->ilan_tarihi->format('d.m.Y') }}</td></tr>
                            @endif
                            <tr><td class="text-muted">Emlak Tipi</td><td>{{ $property->listing_type_label }} {{ $property->property_type_label }}</td></tr>
                            @if($property->area_brut !== null && $property->area_brut != '')
                                <tr><td class="text-muted">m² (Brüt)</td><td>{{ $property->area_brut }}</td></tr>
                            @endif
                            @if($property->area_sqm !== null && $property->area_sqm != '')
                                <tr><td class="text-muted">m² (Net)</td><td>{{ $property->area_sqm }}</td></tr>
                            @endif
                            @if(!$property->isArsaType() && (($property->rooms !== null && $property->rooms != '') || ($property->salon !== null && $property->salon != '')))
                                <tr><td class="text-muted">Oda Sayısı</td><td>{{ $property->oda_salon }}</td></tr>
                            @endif
                            @if($property->bina_yasi !== null && $property->bina_yasi != '')
                                <tr><td class="text-muted">Bina Yaşı</td><td>{{ $property->bina_yasi }}</td></tr>
                            @endif
                            @if($property->bulundugu_kat !== null && $property->bulundugu_kat != '')
                                <tr><td class="text-muted">Bulunduğu Kat</td><td>{{ $property->bulundugu_kat }}</td></tr>
                            @endif
                            @if($property->kat_sayisi !== null && $property->kat_sayisi != '')
                                <tr><td class="text-muted">Kat Sayısı</td><td>{{ $property->kat_sayisi }}</td></tr>
                            @endif
                            @if($property->isitma)
                                <tr><td class="text-muted">Isıtma</td><td>{{ $property->isitma }}</td></tr>
                            @endif
                            @if($property->bathrooms !== null && $property->bathrooms != '')
                                <tr><td class="text-muted">Banyo Sayısı</td><td>{{ $property->bathrooms }}</td></tr>
                            @endif
                            @if($property->mutfak)
                                <tr><td class="text-muted">Mutfak</td><td>{{ $property->mutfak }}</td></tr>
                            @endif
                            @if($property->isKonutType())
                                <tr><td class="text-muted">Balkon</td><td>{{ $property->balkon === 'Var' ? 'Var' : ($property->balkon === 'Yok' ? 'Yok' : '—') }}</td></tr>
                            @endif
                            @if($property->otopark)
                                <tr><td class="text-muted">Otopark</td><td>{{ $property->otopark }}</td></tr>
                            @endif
                            @if($property->isKonutType())
                                <tr><td class="text-muted">Eşyalı</td><td>{{ $property->esyali ? 'Evet' : 'Hayır' }}</td></tr>
                            @endif
                            @if($property->kullanim_durumu)
                                <tr><td class="text-muted">Kullanım Durumu</td><td>{{ $property->kullanim_durumu }}</td></tr>
                            @endif
                            @if($property->isKonutType())
                                <tr><td class="text-muted">Site İçerisinde</td><td>{{ $property->site_icerisinde ? 'Evet' : 'Hayır' }}</td></tr>
                            @endif
                            @if($property->site_adi)
                                <tr><td class="text-muted">Site Adı</td><td>{{ $property->site_adi }}</td></tr>
                            @endif
                            @if($property->aidat !== null && $property->aidat != '')
                                <tr><td class="text-muted">Aidat (₺)</td><td>{{ number_format($property->aidat, 0, ',', '.') }}</td></tr>
                            @endif
                            @if($property->tapu_durumu)
                                <tr><td class="text-muted">Tapu Durumu</td><td>{{ $property->tapu_durumu }}</td></tr>
                            @endif
                            @if($property->imar_durumu)
                                <tr><td class="text-muted">İmar Durumu</td><td>{{ $property->imar_durumu }}</td></tr>
                            @endif
                            @if($property->isArsaType())
                                @if($property->ada_no)<tr><td class="text-muted">Ada No</td><td>{{ $property->ada_no }}</td></tr>@endif
                                @if($property->parsel_no)<tr><td class="text-muted">Parsel No</td><td>{{ $property->parsel_no }}</td></tr>@endif
                                @if($property->pafta_no)<tr><td class="text-muted">Pafta No</td><td>{{ $property->pafta_no }}</td></tr>@endif
                                @if($property->kaks)<tr><td class="text-muted">Kaks (Emsal)</td><td>{{ $property->kaks }}</td></tr>@endif
                                @if($property->gabari)<tr><td class="text-muted">Gabari</td><td>{{ $property->gabari }}</td></tr>@endif
                                <tr><td class="text-muted">Krediye Uygunluk</td><td>{{ $property->krediye_uygunluk ? 'Evet' : 'Hayır' }}</td></tr>
                                <tr><td class="text-muted">Takas</td><td>{{ $property->takas ? 'Evet' : 'Hayır' }}</td></tr>
                            @endif
                            @if($property->isIsyeriType())
                                @if($property->kategori)<tr><td class="text-muted">Kategori</td><td>{{ $property->kategori }}</td></tr>@endif
                                @if($property->isyeri_durumu)<tr><td class="text-muted">Durumu</td><td>{{ $property->isyeri_durumu }}</td></tr>@endif
                                @if($property->isyeri_turu)<tr><td class="text-muted">Türü</td><td>{{ $property->isyeri_turu }}</td></tr>@endif
                                @if($property->bolum_oda_sayisi)<tr><td class="text-muted">Bölüm / Oda Sayısı</td><td>{{ $property->bolum_oda_sayisi }}</td></tr>@endif
                            @endif
                            <tr><td class="text-muted">Kimden</td><td class="font-weight-bold text-danger">{{ $property->personel ?: 'Sahibinden' }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sekmeler ve Açıklama --}}
        <div class="bg-white border rounded overflow-hidden mb-4">
            <ul class="nav nav-tabs border-0 bg-light" id="detailTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active rounded-0 border-0 py-3" id="tab-detail" data-toggle="tab" href="#content-detail" role="tab">İlan Detayları</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 border-0 py-3" id="tab-location" data-toggle="tab" href="#content-location" role="tab">Konumu ve Sokak Görünümü</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 border-0 py-3" id="tab-index" data-toggle="tab" href="#content-index" role="tab">Emlak Endeksi</a>
                </li>
            </ul>
            <div class="tab-content p-4" id="detailTabsContent">
                <div class="tab-pane fade show active" id="content-detail" role="tabpanel">
                    <h5 class="mb-3">Açıklama</h5>
                    @if($property->description)
                        <div class="text-body">{!! nl2br(e($property->description)) !!}</div>
                    @else
                        <p class="text-muted mb-0">Açıklama eklenmemiş.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="content-location" role="tabpanel">
                    @if($property->lokasyon || $property->address)
                        <p class="mb-2"><strong>Adres:</strong> {{ $property->address ?? $property->lokasyon ?? '—' }}</p>
                        @if($property->city)<p class="mb-0 text-muted">{{ $property->city }}@if($property->district) / {{ $property->district }}@endif</p>@endif
                    @else
                        <p class="text-muted mb-0">Konum bilgisi eklenmemiş.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="content-index" role="tabpanel">
                    <p class="text-muted mb-0">Emlak endeksi verileri bu alanda gösterilebilir.</p>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <a href="{{ route('properties') }}" class="btn btn-outline-primary">← Tüm ilanlara dön</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var lightbox = document.getElementById('propertyGalleryLightbox');
    var lightboxImg = document.getElementById('lightboxMainImage');
    var lightboxClose = document.getElementById('lightboxClose');
    var lightboxPrev = document.getElementById('lightboxPrev');
    var lightboxNext = document.getElementById('lightboxNext');
    var lightboxCounter = document.getElementById('lightboxCounter');
    var mainImg = document.getElementById('propertyMainImage');
    var galleryUrls = [];
    var currentIndex = 0;

    function openLightbox(index) {
        if (!galleryUrls.length) return;
        currentIndex = Math.max(0, Math.min(index, galleryUrls.length - 1));
        lightboxImg.src = galleryUrls[currentIndex];
        lightboxCounter.textContent = (currentIndex + 1) + ' / ' + galleryUrls.length;
        lightbox.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeLightbox() {
        lightbox.classList.remove('is-open');
        document.body.style.overflow = '';
    }
    function showPrev() {
        currentIndex = currentIndex <= 0 ? galleryUrls.length - 1 : currentIndex - 1;
        lightboxImg.src = galleryUrls[currentIndex];
        lightboxCounter.textContent = (currentIndex + 1) + ' / ' + galleryUrls.length;
    }
    function showNext() {
        currentIndex = currentIndex >= galleryUrls.length - 1 ? 0 : currentIndex + 1;
        lightboxImg.src = galleryUrls[currentIndex];
        lightboxCounter.textContent = (currentIndex + 1) + ' / ' + galleryUrls.length;
    }

    document.querySelectorAll('.property-gallery-trigger').forEach(function(el) {
        el.addEventListener('click', function() {
            var urls = this.getAttribute('data-gallery-urls');
            var idx = parseInt(this.getAttribute('data-gallery-index'), 10) || 0;
            if (urls) {
                try { galleryUrls = JSON.parse(urls); } catch (e) { galleryUrls = []; }
            }
            if (mainImg && galleryUrls[idx]) mainImg.src = galleryUrls[idx];
            openLightbox(idx);
        });
    });

    if (lightboxClose) lightboxClose.addEventListener('click', closeLightbox);
    if (lightboxPrev) lightboxPrev.addEventListener('click', showPrev);
    if (lightboxNext) lightboxNext.addEventListener('click', showNext);
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function(e) {
        if (!lightbox.classList.contains('is-open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') showPrev();
        if (e.key === 'ArrowRight') showNext();
    });
})();
</script>
@endpush
@endsection
