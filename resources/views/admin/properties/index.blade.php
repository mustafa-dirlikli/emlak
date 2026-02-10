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
        <div class="text-center py-5">
            <p class="text-muted mb-2">Henüz ilan yok.</p>
            <a href="{{ route('admin.properties.create') }}" class="btn btn-admin">İlk ilanı ekle</a>
        </div>
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
                        <td class="text-nowrap">
                            <a href="{{ route('admin.properties.edit', $p) }}" class="btn btn-sm btn-admin">Düzenle</a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-delete-property" data-toggle="modal" data-target="#deleteModal" data-delete-url="{{ route('admin.properties.destroy', $p) }}" data-title="{{ e($p->title) }}">Sil</button>
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

{{-- Silme onay modalı --}}
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">İlanı sil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong id="deleteModalTitle"></strong> ilanını silmek istediğinize emin misiniz? Bu işlem geri alınamaz.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">İptal</button>
                <form id="deleteModalForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var form = document.getElementById('deleteModalForm');
    if (!form) return;
    document.querySelectorAll('.btn-delete-property').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var url = this.getAttribute('data-delete-url');
            var title = this.getAttribute('data-title') || 'Bu ilan';
            if (url) form.action = url;
            var titleEl = document.getElementById('deleteModalTitle');
            if (titleEl) titleEl.textContent = title;
        });
    });
})();
</script>
@endpush
@endsection
