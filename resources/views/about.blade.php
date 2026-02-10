@extends('layouts.app')

@section('title', 'Hakkımızda - ' . config('app.name'))

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <div class="site-section-title">
                    <h2>Hakkımızda</h2>
                </div>
                <p class="lead">{{ config('app.name') }} olarak emlak alım satım ve kiralama süreçlerinde güvenilir çözüm ortağınız olmayı hedefliyoruz.</p>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('tema/images/about.jpg') }}" alt="Hakkımızda" class="img-fluid rounded shadow-sm">
            </div>
            <div class="col-md-6">
                <p class="text-black">Satılık ve kiralık konut, arsa ve iş yeri ilanlarıyla hayalinizdeki mülke ulaşmanız için buradayız. Müşteri memnuniyetini ön planda tutarak şeffaf ve güvenilir hizmet sunuyoruz.</p>
                <p class="text-black">Daire, villa, müstakil ev, arsa ve iş yeri kategorilerinde güncel ilanlarımızı inceleyebilir; bize ulaşarak danışmanlık alabilirsiniz.</p>
                <p class="mb-0"><a href="{{ route('properties') }}" class="btn btn-primary rounded-0">İlanları İncele</a> <a href="{{ route('contact') }}" class="btn btn-outline-dark rounded-0 ml-2">İletişime Geç</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
