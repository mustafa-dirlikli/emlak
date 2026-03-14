@extends('layouts.admin')

@section('title', 'Proje Düzenle')

@section('content')
<div class="admin-header">
    <h1>Proje Düzenle</h1>
    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary btn-sm">â† Listeye dön</a>
</div>

<div class="admin-card">
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="form-group mb-3">
                    <label for="title">Başlık <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $project->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group mb-3">
                    <label for="description">Açıklama</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $project->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="listing_type">İlan Tipi <span class="text-danger">*</span></label>
                            <select name="listing_type" id="listing_type" class="form-control @error('listing_type') is-invalid @enderror" required>
                                @foreach(\App\Models\Project::listingTypes() as $key => $label)
                                    <option value="{{ $key }}" {{ old('listing_type', $project->listing_type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('listing_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="property_type">MÃ¼lk Tipi <span class="text-danger">*</span></label>
                            <select name="property_type" id="property_type" class="form-control @error('property_type') is-invalid @enderror" required>
                                @foreach(\App\Models\Project::propertyTypes() as $key => $label)
                                    <option value="{{ $key }}" {{ old('property_type', $project->property_type) === $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('property_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="price">Fiyat <span class="text-danger">*</span></label>
                            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $project->price) }}" min="0" step="1" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="currency">Para Birimi</label>
                            <select name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror">
                                @foreach(\App\Models\Project::currencyOptions() as $code => $label)
                                    <option value="{{ $code }}" {{ old('currency', $project->currency ?? 'TRY') === $code ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="city">Åehir</label>
                            <select name="city" id="city" class="form-control @error('city') is-invalid @enderror" data-selected="{{ old('city', $project->city) }}">
                                <option value="">Åehir seÃ§in</option>
                            </select>
                            @error('city')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="district">Ä°lÃ§e</label>
                            <select name="district" id="district" class="form-control @error('district') is-invalid @enderror" data-selected="{{ old('district', $project->district) }}">
                                <option value="">Ã–nce ÅŸehir seÃ§in</option>
                            </select>
                            @error('district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="neighborhood">Mahalle / Semt</label>
                            <select name="neighborhood" id="neighborhood" class="form-control @error('neighborhood') is-invalid @enderror" data-selected="{{ old('neighborhood', $project->neighborhood) }}">
                                <option value="">Ã–nce ilÃ§e seÃ§in</option>
                            </select>
                            @error('neighborhood')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="address">Adres</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $project->address) }}">
                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group mb-3">
                    <label for="lokasyon">Lokasyon</label>
                    <textarea name="lokasyon" id="lokasyon" class="form-control @error('lokasyon') is-invalid @enderror" rows="2">{{ old('lokasyon', $project->lokasyon) }}</textarea>
                    @error('lokasyon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                @include('admin.projects.partials.map-picker', [
                    'latitude' => old('latitude', $project->latitude),
                    'longitude' => old('longitude', $project->longitude),
                ])
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="room_layout">Oda + Salon</label>
                            <select name="room_layout" id="room_layout" class="form-control @error('room_layout') is-invalid @enderror">
                                <option value="">SeÃ§iniz</option>
                                @foreach(\App\Models\Project::roomLayoutOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('room_layout', $project->room_layout) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('room_layout')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="area_sqm">mÂ²</label>
                            <input type="number" name="area_sqm" id="area_sqm" class="form-control @error('area_sqm') is-invalid @enderror" value="{{ old('area_sqm', $project->area_sqm) }}" min="0">
                            @error('area_sqm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="price_per_sqm">mÂ² FiyatÄ± (â‚º)</label>
                            <input type="number" name="price_per_sqm" id="price_per_sqm" class="form-control @error('price_per_sqm') is-invalid @enderror" value="{{ old('price_per_sqm', $project->price_per_sqm) }}" min="0" step="0.01">
                            @error('price_per_sqm')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="admin-section admin-section-konut" data-section="konut">
                <h6 class="text-muted mb-3">Konut Ã¶zellikleri</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="bathrooms">Banyo SayÄ±sÄ±</label>
                            <select name="bathrooms" id="bathrooms" class="form-control @error('bathrooms') is-invalid @enderror">
                                @foreach(\App\Models\Project::bathroomsOptions() as $val => $label)
                                    <option value="{{ $val }}" {{ (string) old('bathrooms', $project->bathrooms) === (string) $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('bathrooms')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="area_brut">mÂ² (BrÃ¼t)</label>
                            <input type="number" name="area_brut" id="area_brut" class="form-control @error('area_brut') is-invalid @enderror" value="{{ old('area_brut', $project->area_brut) }}" min="0">
                            @error('area_brut')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="bina_yasi">Bina YaÅŸÄ±</label>
                            <select name="bina_yasi" id="bina_yasi" class="form-control @error('bina_yasi') is-invalid @enderror">
                                @foreach(\App\Models\Project::binaYasiOptions() as $val => $label)
                                    <option value="{{ $val }}" {{ old('bina_yasi', $project->bina_yasi) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('bina_yasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="bulundugu_kat">BulunduÄŸu Kat</label>
                            <select name="bulundugu_kat" id="bulundugu_kat" class="form-control @error('bulundugu_kat') is-invalid @enderror">
                                @foreach(\App\Models\Project::bulunduguKatOptions() as $val => $label)
                                    <option value="{{ $val }}" {{ old('bulundugu_kat', $project->bulundugu_kat) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('bulundugu_kat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="kat_sayisi">Kat SayÄ±sÄ±</label>
                            <select name="kat_sayisi" id="kat_sayisi" class="form-control @error('kat_sayisi') is-invalid @enderror">
                                @foreach(\App\Models\Project::katSayisiOptions() as $val => $label)
                                    <option value="{{ $val }}" {{ (string) old('kat_sayisi', $project->kat_sayisi) === (string) $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('kat_sayisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="isitma">IsÄ±nma</label>
                            <select name="isitma" id="isitma" class="form-control @error('isitma') is-invalid @enderror">
                                @foreach(\App\Models\Project::isitmaOptions() as $val => $label)
                                    <option value="{{ $val }}" {{ old('isitma', $project->isitma) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('isitma')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="mutfak">Mutfak</label>
                            <select name="mutfak" id="mutfak" class="form-control @error('mutfak') is-invalid @enderror">
                                @foreach(\App\Models\Project::mutfakOptions() as $val => $label)
                                    <option value="{{ $val }}" {{ old('mutfak', $project->mutfak) === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('mutfak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="balkon">Balkon</label>
                            <select name="balkon" id="balkon" class="form-control @error('balkon') is-invalid @enderror">
                                <option value="">SeÃ§iniz</option>
                                <option value="Var" {{ old('balkon', $project->balkon) === 'Var' ? 'selected' : '' }}>Var</option>
                                <option value="Yok" {{ old('balkon', $project->balkon) === 'Yok' ? 'selected' : '' }}>Yok</option>
                            </select>
                            @error('balkon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="otopark">Otopark</label>
                            <input type="text" name="otopark" id="otopark" class="form-control @error('otopark') is-invalid @enderror" value="{{ old('otopark', $project->otopark) }}">
                            @error('otopark')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="hidden" name="asansor" value="0">
                                <input type="checkbox" name="asansor" id="asansor" value="1" class="form-check-input" {{ old('asansor', $project->asansor) ? 'checked' : '' }}>
                                <label for="asansor" class="form-check-label">AsansÃ¶r</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="hidden" name="esyali" value="0">
                                <input type="checkbox" name="esyali" id="esyali" value="1" class="form-check-input" {{ old('esyali', $project->esyali) ? 'checked' : '' }}>
                                <label for="esyali" class="form-check-label">EÅŸyalÄ±</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="hidden" name="site_icerisinde" value="0">
                                <input type="checkbox" name="site_icerisinde" id="site_icerisinde" value="1" class="form-check-input" {{ old('site_icerisinde', $project->site_icerisinde) ? 'checked' : '' }}>
                                <label for="site_icerisinde" class="form-check-label">Site Ä°Ã§erisinde</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="site_adi">Site AdÄ±</label>
                            <input type="text" name="site_adi" id="site_adi" class="form-control @error('site_adi') is-invalid @enderror" value="{{ old('site_adi', $project->site_adi) }}">
                            @error('site_adi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="kullanim_durumu">KullanÄ±m Durumu</label>
                            <input type="text" name="kullanim_durumu" id="kullanim_durumu" class="form-control @error('kullanim_durumu') is-invalid @enderror" value="{{ old('kullanim_durumu', $project->kullanim_durumu) }}">
                            @error('kullanim_durumu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="aidat">Aidat (â‚º)</label>
                            <input type="number" name="aidat" id="aidat" class="form-control @error('aidat') is-invalid @enderror" value="{{ old('aidat', $project->aidat) }}" min="0" step="0.01">
                            @error('aidat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                </div>
                <hr class="my-4">
                <div class="admin-section admin-section-isyeri" data-section="isyeri">
                <h6 class="text-muted mb-3">Ä°ÅŸ yeri Ã¶zellikleri</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="kategori" id="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $project->kategori) }}">
                            @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="isyeri_durumu">Durumu</label>
                            <input type="text" name="isyeri_durumu" id="isyeri_durumu" class="form-control @error('isyeri_durumu') is-invalid @enderror" value="{{ old('isyeri_durumu', $project->isyeri_durumu) }}">
                            @error('isyeri_durumu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="isyeri_turu">TÃ¼rÃ¼</label>
                            <input type="text" name="isyeri_turu" id="isyeri_turu" class="form-control @error('isyeri_turu') is-invalid @enderror" value="{{ old('isyeri_turu', $project->isyeri_turu) }}">
                            @error('isyeri_turu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label for="bolum_oda_sayisi">BÃ¶lÃ¼m & Oda SayÄ±sÄ±</label>
                            <input type="text" name="bolum_oda_sayisi" id="bolum_oda_sayisi" class="form-control @error('bolum_oda_sayisi') is-invalid @enderror" value="{{ old('bolum_oda_sayisi', $project->bolum_oda_sayisi) }}">
                            @error('bolum_oda_sayisi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <p class="small text-muted">Ä°ÅŸ yeri ilanlarÄ±nda mÂ², Aidat, IsÄ±tma ve Bina YaÅŸÄ± alanlarÄ± yukarÄ±daki Konut / genel bÃ¶lÃ¼mden kullanÄ±lÄ±r.</p>
                </div>
                <hr class="my-4">
                <div class="admin-section admin-section-arsa" data-section="arsa">
                <h6 class="text-muted mb-3">Ä°lan / Arsa alanlarÄ±</h6>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="ilan_no">Ä°lan No</label>
                            <input type="text" name="ilan_no" id="ilan_no" class="form-control @error('ilan_no') is-invalid @enderror" value="{{ old('ilan_no', $project->ilan_no) }}">
                            @error('ilan_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="ilan_tarihi">Ä°lan Tarihi</label>
                            <input type="date" name="ilan_tarihi" id="ilan_tarihi" class="form-control @error('ilan_tarihi') is-invalid @enderror" value="{{ old('ilan_tarihi', $project->ilan_tarihi?->format('Y-m-d')) }}">
                            @error('ilan_tarihi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="imar_durumu">Ä°mar Durumu</label>
                            <input type="text" name="imar_durumu" id="imar_durumu" class="form-control @error('imar_durumu') is-invalid @enderror" value="{{ old('imar_durumu', $project->imar_durumu) }}">
                            @error('imar_durumu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="ada_no">Ada No</label>
                            <input type="text" name="ada_no" id="ada_no" class="form-control @error('ada_no') is-invalid @enderror" value="{{ old('ada_no', $project->ada_no) }}">
                            @error('ada_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="parsel_no">Parsel No</label>
                            <input type="text" name="parsel_no" id="parsel_no" class="form-control @error('parsel_no') is-invalid @enderror" value="{{ old('parsel_no', $project->parsel_no) }}">
                            @error('parsel_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="pafta_no">Pafta No</label>
                            <input type="text" name="pafta_no" id="pafta_no" class="form-control @error('pafta_no') is-invalid @enderror" value="{{ old('pafta_no', $project->pafta_no) }}">
                            @error('pafta_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="kaks">Kaks (Emsal)</label>
                            <input type="text" name="kaks" id="kaks" class="form-control @error('kaks') is-invalid @enderror" value="{{ old('kaks', $project->kaks) }}">
                            @error('kaks')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="gabari">Gabari</label>
                            <input type="text" name="gabari" id="gabari" class="form-control @error('gabari') is-invalid @enderror" value="{{ old('gabari', $project->gabari) }}">
                            @error('gabari')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="tapu_durumu">Tapu Durumu</label>
                            <input type="text" name="tapu_durumu" id="tapu_durumu" class="form-control @error('tapu_durumu') is-invalid @enderror" value="{{ old('tapu_durumu', $project->tapu_durumu) }}">
                            @error('tapu_durumu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="hidden" name="krediye_uygunluk" value="0">
                                <input type="checkbox" name="krediye_uygunluk" id="krediye_uygunluk" value="1" class="form-check-input" {{ old('krediye_uygunluk', $project->krediye_uygunluk) ? 'checked' : '' }}>
                                <label for="krediye_uygunluk" class="form-check-label">Krediye Uygunluk</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <div class="form-check mt-4">
                                <input type="hidden" name="takas" value="0">
                                <input type="checkbox" name="takas" id="takas" value="1" class="form-check-input" {{ old('takas', $project->takas) ? 'checked' : '' }}>
                                <label for="takas" class="form-check-label">Takas</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="personel">Personel</label>
                            <input type="text" name="personel" id="personel" class="form-control @error('personel') is-invalid @enderror" value="{{ old('personel', $project->personel) }}" placeholder="DanÄ±ÅŸman adÄ±">
                            @error('personel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="ilan_detay">Ä°lan detay (JSON)</label>
                    <textarea name="ilan_detay" id="ilan_detay" class="form-control @error('ilan_detay') is-invalid @enderror" rows="3" placeholder='{"key": "value"}'>{{ old('ilan_detay', $project->ilan_detay ? json_encode($project->ilan_detay, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '') }}</textarea>
                    @error('ilan_detay')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group mb-3">
                    <label for="arsa_ozellikler">Arsa Ã¶zellikleri (JSON, nullable)</label>
                    <textarea name="arsa_ozellikler" id="arsa_ozellikler" class="form-control @error('arsa_ozellikler') is-invalid @enderror" rows="3" placeholder='{"ozellik": "deger"}'>{{ old('arsa_ozellikler', $project->arsa_ozellikler ? json_encode($project->arsa_ozellikler, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : '') }}</textarea>
                    @error('arsa_ozellikler')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group mb-3">
                    <label for="image">Ana GÃ¶rsel</label>
                    @if($project->image)
                        <div class="mb-2 position-relative d-inline-block">
                            <img src="{{ asset('storage/'.$project->image) }}" alt="" class="img-fluid rounded border" style="max-height:120px" id="current-main-image">
                            <div class="mt-1">
                                <label class="mb-0">
                                    <input type="checkbox" name="remove_main" value="1" class="remove-main-check"> Ana gÃ¶rseli kaldÄ±r
                                </label>
                            </div>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Ana gÃ¶rseli deÄŸiÅŸtirmek iÃ§in yeni dosya seÃ§in (isteÄŸe baÄŸlÄ±)</small>
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group mb-3">
                    <label>Galeri ({{ is_array($project->gallery) ? count($project->gallery) : 0 }} gÃ¶rsel)</label>
                    @if($project->gallery && count($project->gallery) > 0)
                        <div class="d-flex flex-wrap gap-3 mb-2">
                            @foreach($project->gallery as $g)
                                <div class="position-relative border rounded p-1 gallery-item" data-path="{{ $g }}">
                                    <img src="{{ asset('storage/'.$g) }}" alt="" class="rounded" style="width:70px;height:50px;object-fit:cover;">
                                    <label class="d-block mb-0 mt-1 small text-nowrap">
                                        <input type="checkbox" name="gallery_remove[]" value="{{ $g }}" class="gallery-remove-check"> KaldÄ±r
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <small class="text-muted d-block">KaldÄ±rmak istediÄŸiniz gÃ¶rselleri iÅŸaretleyin.</small>
                    @else
                        <p class="text-muted small mb-1">HenÃ¼z galeri gÃ¶rseli yok.</p>
                    @endif
                    <input type="file" name="gallery_new[]" id="gallery_new" class="form-control @error('gallery_new.*') is-invalid @enderror" accept="image/*" multiple>
                    <small class="text-muted">Galeriye eklenecek gÃ¶rselleri seÃ§in (birden fazla)</small>
                    @error('gallery_new')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @error('gallery_new.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" class="form-check-input" {{ old('is_active', $project->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Aktif</label>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_featured" value="0">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" class="form-check-input" {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Ã–ne Ã§Ä±kan</label>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <button type="submit" class="btn btn-admin">GÃ¼ncelle</button>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Ä°ptal</a>
    </form>
</div>

@push('scripts')
<script>
(function() {
    var konutTypes = ['konut', 'daire', 'villa', 'mustakil'];
    var arsaTypes = ['arsa'];
    var isyeriTypes = ['isyeri'];
    function toggleSections() {
        var type = (document.getElementById('property_type') || {}).value || '';
        document.querySelectorAll('.admin-section').forEach(function(el) {
            var section = el.getAttribute('data-section');
            var show = (section === 'konut' && konutTypes.indexOf(type) !== -1) ||
                (section === 'arsa' && arsaTypes.indexOf(type) !== -1) ||
                (section === 'isyeri' && isyeriTypes.indexOf(type) !== -1);
            el.style.display = show ? '' : 'none';
        });
    }
    var sel = document.getElementById('property_type');
    if (sel) {
        sel.addEventListener('change', toggleSections);
        toggleSections();
    }
    var citySelect = document.getElementById('city');
    var districtSelect = document.getElementById('district');
    var neighborhoodSelect = document.getElementById('neighborhood');
    var apiBase = '{{ url("admin/api") }}';
    if (citySelect && districtSelect && neighborhoodSelect) {
        function loadCities() {
            if (citySelect.getAttribute('data-loaded') === '1') return;
            citySelect.setAttribute('data-loaded', '1');
            fetch(apiBase + '/cities')
                .then(function(r) { return r.json(); })
                .then(function(arr) {
                    arr.forEach(function(c) {
                        var opt = document.createElement('option');
                        opt.value = c.name;
                        opt.setAttribute('data-city-id', c.id);
                        opt.textContent = c.name;
                        citySelect.appendChild(opt);
                    });
                    var selected = citySelect.getAttribute('data-selected');
                    if (selected) { citySelect.value = selected; loadDistricts(); }
                })
                .catch(function() { citySelect.setAttribute('data-loaded', '0'); });
        }
        function loadDistricts() {
            var opt = citySelect.options[citySelect.selectedIndex];
            var cityId = opt ? opt.getAttribute('data-city-id') : null;
            districtSelect.innerHTML = '<option value="">Ã–nce ÅŸehir seÃ§in</option>';
            neighborhoodSelect.innerHTML = '<option value="">Ã–nce ilÃ§e seÃ§in</option>';
            if (!cityId) return;
            fetch(apiBase + '/districts?city_id=' + encodeURIComponent(cityId))
                .then(function(r) { return r.json(); })
                .then(function(arr) {
                    arr.forEach(function(d) {
                        var o = document.createElement('option');
                        o.value = d.name;
                        o.setAttribute('data-district-id', d.id);
                        o.textContent = d.name;
                        districtSelect.appendChild(o);
                    });
                    var selected = districtSelect.getAttribute('data-selected');
                    if (selected) { districtSelect.value = selected; loadNeighborhoods(); }
                });
        }
        function loadNeighborhoods() {
            var opt = districtSelect.options[districtSelect.selectedIndex];
            var districtId = opt ? opt.getAttribute('data-district-id') : null;
            neighborhoodSelect.innerHTML = '<option value="">Ã–nce ilÃ§e seÃ§in</option>';
            if (!districtId) return;
            fetch(apiBase + '/neighborhoods?district_id=' + encodeURIComponent(districtId))
                .then(function(r) { return r.json(); })
                .then(function(arr) {
                    arr.forEach(function(n) {
                        var o = document.createElement('option');
                        o.value = n.name;
                        o.textContent = n.name;
                        neighborhoodSelect.appendChild(o);
                    });
                    var selected = neighborhoodSelect.getAttribute('data-selected');
                    if (selected) neighborhoodSelect.value = selected;
                });
        }
        citySelect.addEventListener('focus', loadCities);
        citySelect.addEventListener('click', loadCities);
        citySelect.addEventListener('change', loadDistricts);
        districtSelect.addEventListener('change', loadNeighborhoods);
        if (citySelect.getAttribute('data-selected')) loadCities();
    }
})();
</script>
@endpush
@endsection

