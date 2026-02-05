@extends('layouts.app')

@section('title', 'Satılık İlanlar - ' . config('app.name'))

@section('content')
<div class="site-section site-section-sm bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Satılık Emlak İlanları</h2>
                    <p>Satılık daire, arsa ve iş yeri ilanları.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center py-5">
                <p class="lead">İlanlar listelenecek. Veritabanı ve controller eklendiğinde bu sayfa doldurulacak.</p>
                <a href="{{ route('properties') }}" class="btn btn-success rounded-0">Tüm İlanları Gör</a>
            </div>
        </div>
    </div>
</div>
@endsection
