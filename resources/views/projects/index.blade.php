@extends('layouts.app')

@section('title', 'Projelerimiz - ' . config('app.name'))

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <div class="site-section-title">
                    <h2>Projelerimiz</h2>
                    <p>Tamamlanmış ve devam eden projelerimizi inceleyebilirsiniz.</p>
                </div>
            </div>
        </div>
        @if($projects->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="bg-white border rounded p-5 text-center">
                        <p class="lead text-muted mb-0">Henüz proje eklenmemiş.</p>
                        <a href="{{ route('properties') }}" class="btn btn-primary rounded-0 mt-3">İlanlara Göz At</a>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('projects.show', $project) }}" class="text-decoration-none text-dark">
                            <div class="bg-white border rounded overflow-hidden h-100 d-flex flex-column">
                                <div class="position-relative" style="height: 200px; overflow: hidden; background: #eee;">
                                    @if($project->image)
                                        <img src="{{ asset('storage/'.$project->image) }}" alt="{{ $project->title }}" class="w-100 h-100" style="object-fit: cover;">
                                    @else
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                            <span class="icon icon-image" style="font-size: 3rem;"></span>
                                        </div>
                                    @endif
                                    <span class="position-absolute badge {{ $project->listing_type === 'sale' ? 'bg-danger' : 'bg-info' }}" style="top: 8px; left: 8px;">{{ $project->listing_type_label }}</span>
                                </div>
                                <div class="p-3 flex-grow-1 d-flex flex-column">
                                    <h5 class="font-weight-bold mb-2">{{ Str::limit($project->title, 50) }}</h5>
                                    <p class="text-muted small mb-2">
                                        @if($project->city || $project->district)
                                            <span class="icon-room mr-1"></span>{{ implode(' / ', array_filter([$project->city, $project->district])) }}
                                        @else
                                            —
                                        @endif
                                    </p>
                                    <div class="mt-auto pt-2 border-top">
                                        <span class="h5 font-weight-bold text-primary mb-0">{{ $project->currency_symbol }}{{ number_format($project->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $projects->links() }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
