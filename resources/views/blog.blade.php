@extends('layouts.app')

@section('title', 'Blog - ' . config('app.name'))

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <div class="site-section-title">
                    <h2>Blog</h2>
                    <p>Emlak piyasası, ev alım satım ipuçları ve yaşam alanları hakkında yazılar.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="bg-white border rounded p-5 text-center">
                    <p class="lead text-muted mb-4">Yeni yazılar yakında burada yer alacak.</p>
                    <p class="text-black">Konut kredisi, taşınma, mahalle rehberi ve emlak vergileri gibi konularda içerikler eklenecektir.</p>
                    <a href="{{ route('properties') }}" class="btn btn-primary rounded-0 mt-3">İlanlara Göz At</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
