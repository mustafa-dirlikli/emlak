<footer class="site-footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="mb-5">
                    <h3 class="footer-heading mb-4">{{ config('app.name', 'Emremlak') }} Hakkında</h3>
                    <p>Emlak alım satım ve kiralama işlemlerinizde güvenilir çözüm ortağınız.</p>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h3 class="footer-heading mb-4">Menü</h3>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="{{ url('/') }}">Ana Sayfa</a></li>
                            <li><a href="{{ route('buy') }}">Satılık</a></li>
                            <li><a href="{{ route('rent') }}">Kiralık</a></li>
                            <li><a href="{{ route('properties') }}">İlanlar</a></li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                            <li><a href="{{ route('contact') }}">İletişim</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
                <h3 class="footer-heading mb-4">Bizi Takip Edin</h3>
                <div>
                    <a href="#" class="pl-0 pr-3"><span class="icon-facebook"></span></a>
                    <a href="#" class="pl-3 pr-3"><span class="icon-twitter"></span></a>
                    <a href="#" class="pl-3 pr-3"><span class="icon-instagram"></span></a>
                    <a href="#" class="pl-3 pr-3"><span class="icon-linkedin"></span></a>
                </div>
            </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Tüm hakları saklıdır.</p>
            </div>
        </div>
    </div>
</footer>
