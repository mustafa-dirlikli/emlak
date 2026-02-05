@extends('layouts.app')

@section('title', 'Blog - ' . config('app.name'))

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Blog</h2>
                    <p>Emlak ve yaşam alanları hakkında yazılar.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center py-5">
                <p class="lead">Blog yazıları eklendiğinde burada listelenecek.</p>
            </div>
        </div>
    </div>
</div>
@endsection
