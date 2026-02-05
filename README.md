# Emremlak

Emlak ilan sitesi projesi. Satılık ve kiralık emlak ilanlarının listelendiği, Laravel tabanlı web uygulaması.

## İçindekiler

- [Teknolojiler](#teknolojiler)
- [Gereksinimler](#gereksinimler)
- [Kurulum](#kurulum)
- [Yapılandırma](#yapılandırma)
- [Proje Yapısı](#proje-yapısı)
- [Route'lar ve Sayfalar](#routelar-ve-sayfalar)
- [Tema](#tema)
- [Geliştirme](#geliştirme)

---

## Teknolojiler

| Bileşen | Sürüm / Açıklama |
|--------|-------------------|
| **Laravel** | 12.x |
| **PHP** | 8.2+ |
| **Veritabanı** | SQLite (varsayılan), MySQL/PostgreSQL uyumlu |
| **Ön yüz** | Blade şablonları, Bootstrap tabanlı tema (Homeland / Colorlib) |
| **JavaScript** | jQuery, Owl Carousel, AOS, Magnific Popup |

---

## Gereksinimler

- PHP 8.2 veya üzeri
- Composer
- (İsteğe bağlı) Node.js & npm (Vite için)
- XAMPP/WAMP veya yerel PHP sunucusu

---

## Kurulum

### 1. Bağımlılıkları yükleyin

```bash
composer install
```

### 2. Ortam dosyasını oluşturun

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Veritabanını hazırlayın

Varsayılan SQLite kullanılıyorsa ek ayar gerekmez. Migration'ları çalıştırın:

```bash
php artisan migrate
```

MySQL kullanacaksanız `.env` içinde `DB_*` değişkenlerini düzenleyin, sonra tekrar:

```bash
php artisan migrate
```

### 4. Uygulamayı çalıştırın

**Artisan ile:**

```bash
php artisan serve
```

Tarayıcıda: **http://127.0.0.1:8000**

**XAMPP ile:**

Projeyi `htdocs` altına koyduysanız:

- **http://localhost/emremlak/public**

Apache ile doğrudan `public` klasörünü kullanacak şekilde Virtual Host tanımlayabilirsiniz.

---

## Yapılandırma

### .env önemli değişkenler

| Değişken | Açıklama |
|----------|----------|
| `APP_NAME` | Site adı (örn. `Emremlak`) |
| `APP_URL` | Uygulama adresi (örn. `http://localhost/emremlak/public`) |
| `DB_CONNECTION` | `sqlite`, `mysql` vb. |
| `DB_DATABASE` | Veritabanı adı / SQLite dosya yolu |
| `DB_USERNAME` / `DB_PASSWORD` | MySQL kullanıcı adı ve şifre |

---

## Proje Yapısı

```
emremlak/
├── app/
│   ├── Http/Controllers/   # Controller'lar
│   ├── Models/              # Eloquent modelleri
│   └── Providers/
├── config/                  # Uygulama ayarları
├── database/
│   ├── migrations/          # Veritabanı migration'ları
│   └── seeders/
├── public/
│   ├── tema/                # Tema varlıkları (css, js, fonts, images)
│   │   ├── css/
│   │   ├── js/
│   │   ├── fonts/
│   │   └── images/
│   ├── index.php
│   └── .htaccess
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php    # Ana layout (navbar, footer)
│       ├── home.blade.php       # Ana sayfa
│       ├── buy.blade.php        # Satılık
│       ├── rent.blade.php       # Kiralık
│       ├── properties.blade.php # İlan listesi
│       ├── blog.blade.php
│       ├── about.blade.php
│       ├── contact.blade.php
│       └── welcome.blade.php    # Laravel varsayılan (kullanılmıyor)
├── routes/
│   └── web.php             # Web route'ları
├── storage/                # Log, cache, session
├── tema/                   # Orijinal tema kaynağı (referans)
└── .env                    # Ortam değişkenleri (git’e eklenmez)
```

---

## Route'lar ve Sayfalar

| URL | Route adı | Açıklama |
|-----|-----------|----------|
| `/` | `home` | Ana sayfa (slider, arama formu, öne çıkan ilanlar, hizmetler, blog önizleme, danışmanlar) |
| `/satilik` | `buy` | Satılık ilanlar |
| `/kiralik` | `rent` | Kiralık ilanlar |
| `/ilanlar` | `properties` | Tüm ilanlar (liste/grid) |
| `/blog` | `blog` | Blog sayfası |
| `/hakkimizda` | `about` | Hakkımızda |
| `/iletisim` | `contact` | İletişim formu ve bilgiler |

View'larda `route('isim')` ve `url('/')` kullanılır; linkler bu route'lara göre üretilir.

---

## Tema

- **Kaynak:** Proje kökündeki `tema/` klasörü (orijinal HTML/CSS/JS).
- **Yayınlanan varlıklar:** `public/tema/` altında (css, js, fonts, images).
- **Layout:** `resources/views/layouts/app.blade.php` — navbar, footer ve tüm tema CSS/JS burada yüklenir.
- **Asset kullanımı:** Blade içinde `{{ asset('tema/css/style.css') }}` gibi `asset('tema/...')` kullanılır.

Tema (Homeland / Colorlib) Bootstrap, Owl Carousel, AOS ve jQuery eklentileri kullanır. Mobil menü ve slider tema JS’i ile çalışır.

---

## Geliştirme

### Yeni sayfa eklemek

1. `routes/web.php` içine route tanımlayın.
2. `resources/views/` altında `layouts.app`’i extend eden bir Blade view oluşturun.
3. Gerekirse `layouts/app.blade.php` menüsüne link ekleyin.

### Veritabanı değişikliği

```bash
php artisan make:migration create_ilanlar_table
# migration dosyasını düzenleyin
php artisan migrate
```

### Test

```bash
php artisan test
# veya
./vendor/bin/phpunit
```

### Kod stili (Laravel Pint)

```bash
./vendor/bin/pint
```

---

## Lisans

Laravel framework [MIT lisansı](https://opensource.org/licenses/MIT) altındadır. Tema lisansı için tema kaynak dosyalarına bakınız.
