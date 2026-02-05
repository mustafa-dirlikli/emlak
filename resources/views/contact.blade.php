@extends('layouts.app')

@section('title', 'İletişim - ' . config('app.name'))

@section('content')
<div class="site-section">
    <div class="container">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-7 text-center">
                <div class="site-section-title">
                    <h2>İletişim</h2>
                    <p>Bizimle iletişime geçin.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 mb-5">
                <form action="#" method="post" class="p-5 bg-white">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="text-black" for="name">Ad Soyad</label>
                            <input type="text" id="name" name="name" class="form-control rounded-0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="text-black" for="email">E-posta</label>
                            <input type="email" id="email" name="email" class="form-control rounded-0" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="subject">Konu</label>
                            <input type="text" id="subject" name="subject" class="form-control rounded-0" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <label class="text-black" for="message">Mesaj</label>
                            <textarea name="message" id="message" cols="30" rows="7" class="form-control rounded-0" placeholder="Mesajınızı yazın..." required></textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success py-2 px-4 rounded-0">Gönder</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-5">
                <div class="p-4 mb-3 bg-white rounded">
                    <span class="d-block text-black h6 mb-3">Adres</span>
                    <p class="mb-0">Örnek Mahalle, Örnek Sokak No:1</p>
                    <p class="mb-0">İstanbul, Türkiye</p>
                </div>
                <div class="p-4 mb-3 bg-white rounded">
                    <span class="d-block text-black h6 mb-3">Telefon</span>
                    <p class="mb-0">+90 (212) 000 00 00</p>
                </div>
                <div class="p-4 mb-3 bg-white rounded">
                    <span class="d-block text-black h6 mb-3">E-posta</span>
                    <p class="mb-0">info@emremlak.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
