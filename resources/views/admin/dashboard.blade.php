@extends('layouts.admin')

@section('title', 'Panel')

@section('content')
<div class="admin-header">
    <h1>Panel</h1>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="admin-card">
            <div class="text-muted small">Toplam İlan</div>
            <div class="h3 mb-0 text-success">{{ $stats['total_properties'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="admin-card">
            <div class="text-muted small">Aktif İlan</div>
            <div class="h3 mb-0">{{ $stats['active_properties'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="admin-card">
            <div class="text-muted small">Satılık</div>
            <div class="h3 mb-0 text-danger">{{ $stats['sale_count'] }}</div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="admin-card">
            <div class="text-muted small">Kiralık</div>
            <div class="h3 mb-0 text-success">{{ $stats['rent_count'] }}</div>
        </div>
    </div>
</div>

<div class="admin-card">
    <h5 class="mb-3">Son Eklenen İlanlar</h5>
    @if($recentProperties->isEmpty())
        <p class="text-muted mb-0">Henüz ilan yok. <a href="{{ route('admin.properties.create') }}">Yeni ilan ekleyin</a>.</p>
    @else
        <div class="table-responsive">
            <table class="table admin-table">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Tip</th>
                        <th>Fiyat</th>
                        <th>Durum</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProperties as $p)
                    <tr>
                        <td>{{ Str::limit($p->title, 40) }}</td>
                        <td>
                            <span class="badge {{ $p->listing_type === 'sale' ? 'badge-sale' : 'badge-rent' }}">{{ $p->listing_type_label }}</span>
                            <span class="badge bg-secondary">{{ $p->property_type_label }}</span>
                        </td>
                        <td>₺{{ number_format($p->price, 0, ',', '.') }}</td>
                        <td>
                            @if($p->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Pasif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.properties.edit', $p) }}" class="btn btn-sm btn-outline-primary">Düzenle</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="{{ route('admin.properties.index') }}" class="btn btn-admin btn-sm mt-2">Tümünü gör</a>
    @endif
</div>
@endsection
