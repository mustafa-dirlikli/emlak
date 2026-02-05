@extends('layouts.admin')

@section('title', 'İlanlar')

@section('content')
<div class="admin-header d-flex flex-wrap align-items-center justify-content-between gap-2">
    <h1>İlanlar</h1>
    <a href="{{ route('admin.properties.create') }}" class="btn btn-admin">+ Yeni İlan</a>
</div>

<div class="admin-card">
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Başlık, adres, şehir..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <select name="listing_type" class="form-control form-control-sm">
                <option value="">Tüm tipler</option>
                @foreach(\App\Models\Property::listingTypes() as $key => $label)
                    <option value="{{ $key }}" {{ request('listing_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="property_type" class="form-control form-control-sm">
                <option value="">Tüm kategoriler</option>
                @foreach(\App\Models\Property::propertyTypes() as $key => $label)
                    <option value="{{ $key }}" {{ request('property_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-sm btn-admin">Filtrele</button>
        </div>
    </form>

    @if($properties->isEmpty())
        <p class="text-muted mb-0">Henüz ilan yok. <a href="{{ route('admin.properties.create') }}">İlk ilanı ekleyin</a>.</p>
    @else
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Başlık</th>
                        <th>Tip</th>
                        <th>Fiyat</th>
                        <th>Şehir</th>
                        <th>Durum</th>
                        <th style="width:140px">İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($properties as $p)
                    <tr>
                        <td>
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" alt="" style="width:50px;height:40px;object-fit:cover;border-radius:4px">
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($p->title, 35) }}</td>
                        <td>
                            <span class="badge {{ $p->listing_type === 'sale' ? 'badge-sale' : 'badge-rent' }}">{{ $p->listing_type_label }}</span>
                            <span class="badge bg-secondary">{{ $p->property_type_label }}</span>
                        </td>
                        <td>₺{{ number_format($p->price, 0, ',', '.') }}</td>
                        <td>{{ $p->city ?? '—' }}</td>
                        <td>
                            @if($p->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Pasif</span>
                            @endif
                            @if($p->is_featured)
                                <span class="badge bg-warning text-dark">Öne çıkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.properties.edit', $p) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                            <form action="{{ route('admin.properties.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Sil</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
