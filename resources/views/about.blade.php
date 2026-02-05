@extends('layouts.app')

@section('title', 'Hakkımızda - ' . config('app.name'))

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>Hakkımızda</h2>
                </div>
                <p class="lead">{{ config('app.name') }} olarak emlak alım satım ve kiralama süreçlerinde güvenilir çözüm ortağınız olmayı hedefliyoruz.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="{{ asset('tema/images/about.jpg') }}" alt="Hakkımızda" class="img-fluid rounded">
            </div>
            <div class="col-md-6">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis maiores quisquam saepe architecto error corporis aliquam. Cum ipsam a consectetur aut sunt sint animi, pariatur corporis, eaque, deleniti cupiditate officia.</p>
                <p>İçeriği ihtiyacınıza göre düzenleyebilirsiniz.</p>
            </div>
        </div>
    </div>
</div>
@endsection
