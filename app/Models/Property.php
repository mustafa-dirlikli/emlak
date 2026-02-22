<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'listing_type',
        'property_type',
        'kategori',
        'isyeri_durumu',
        'isyeri_turu',
        'bolum_oda_sayisi',
        'price',
        'currency',
        'city',
        'district',
        'neighborhood',
        'address',
        'lokasyon',
        'latitude',
        'longitude',
        'rooms',
        'salon',
        'room_layout',
        'bathrooms',
        'area_sqm',
        'area_brut',
        'price_per_sqm',
        'bina_yasi',
        'bulundugu_kat',
        'kat_sayisi',
        'isitma',
        'mutfak',
        'balkon',
        'asansor',
        'otopark',
        'esyali',
        'kullanim_durumu',
        'site_icerisinde',
        'site_adi',
        'aidat',
        'image',
        'gallery',
        'user_id',
        'personel',
        'is_active',
        'is_featured',
        // Arsa / genel ilan alanları
        'ilan_no',
        'ilan_tarihi',
        'imar_durumu',
        'ada_no',
        'parsel_no',
        'pafta_no',
        'kaks',
        'gabari',
        'krediye_uygunluk',
        'tapu_durumu',
        'takas',
        'ilan_detay',
        'arsa_ozellikler',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'price_per_sqm' => 'decimal:2',
            'aidat' => 'decimal:2',
            'ilan_tarihi' => 'date',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'krediye_uygunluk' => 'boolean',
            'takas' => 'boolean',
            'asansor' => 'boolean',
            'esyali' => 'boolean',
            'site_icerisinde' => 'boolean',
            'gallery' => 'array',
            'ilan_detay' => 'array',
            'arsa_ozellikler' => 'array',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function listingTypes(): array
    {
        return [
            'sale' => 'Satılık',
            'rent' => 'Kiralık',
        ];
    }

    public static function propertyTypes(): array
    {
        return [
            'konut' => 'Konut',
            'daire' => 'Daire',
            'arsa' => 'Arsa',
            'isyeri' => 'İş Yeri',
            'villa' => 'Villa',
            'mustakil' => 'Müstakil',
        ];
    }

    /** Konut tipi mi (konut, daire, villa, mustakil) */
    public function isKonutType(): bool
    {
        return in_array($this->property_type, ['konut', 'daire', 'villa', 'mustakil'], true);
    }

    /** Arsa tipi mi */
    public function isArsaType(): bool
    {
        return $this->property_type === 'arsa';
    }

    /** İş yeri tipi mi */
    public function isIsyeriType(): bool
    {
        return $this->property_type === 'isyeri';
    }

    public function getListingTypeLabelAttribute(): string
    {
        return self::listingTypes()[$this->listing_type] ?? $this->listing_type;
    }

    public function getPropertyTypeLabelAttribute(): string
    {
        return self::propertyTypes()[$this->property_type] ?? $this->property_type;
    }

    public static function currencyOptions(): array
    {
        return [
            'TRY' => '₺ TL',
            'USD' => '$ USD',
            'EUR' => '€ EUR',
        ];
    }

    public function getCurrencySymbolAttribute(): string
    {
        return match ($this->currency ?? 'TRY') {
            'USD' => '$',
            'EUR' => '€',
            default => '₺',
        };
    }

    /** Oda + Salon seçenekleri (form listesi) */
    public static function roomLayoutOptions(): array
    {
        return [
            '1+0' => 'Stüdyo (1+0)',
            '1+1' => '1+1',
            '1.5+1' => '1.5+1',
            '2+0' => '2+0',
            '2+1' => '2+1',
            '2.5+1' => '2.5+1',
            '2+2' => '2+2',
            '3+0' => '3+0',
            '3+1' => '3+1',
            '3.5+1' => '3.5+1',
            '3+2' => '3+2',
            '3+3' => '3+3',
            '4+0' => '4+0',
            '4+1' => '4+1',
            '4.5+1' => '4.5+1',
            '4.5+2' => '4.5+2',
            '4+2' => '4+2',
            '4+3' => '4+3',
            '4+4' => '4+4',
            '5+1' => '5+1',
            '5.5+1' => '5.5+1',
            '5+2' => '5+2',
            '5+3' => '5+3',
            '5+4' => '5+4',
            '6+1' => '6+1',
            '6+2' => '6+2',
            '6.5+1' => '6.5+1',
            '6+3' => '6+3',
            '6+4' => '6+4',
            '7+1' => '7+1',
            '7+2' => '7+2',
            '7+3' => '7+3',
            '8+1' => '8+1',
            '8+2' => '8+2',
            '8+3' => '8+3',
            '8+4' => '8+4',
            '9+1' => '9+1',
            '9+2' => '9+2',
            '9+3' => '9+3',
            '9+4' => '9+4',
            '9+5' => '9+5',
            '9+6' => '9+6',
            '10+1' => '10+1',
            '10+2' => '10+2',
            '10-uzeri' => '10 Üzeri',
        ];
    }

    /** Bina yaşı seçenekleri */
    public static function binaYasiOptions(): array
    {
        return [
            '' => 'Seçiniz',
            '0 (Oturuma Hazır)' => '0 (Oturuma Hazır)',
            '0 (Yapım Aşamasında)' => '0 (Yapım Aşamasında)',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6-10 arası' => '6-10 arası',
            '11-15 arası' => '11-15 arası',
            '16-20 arası' => '16-20 arası',
            '21-25 arası' => '21-25 arası',
            '26-30 arası' => '26-30 arası',
            '31 ve üzeri' => '31 ve üzeri',
        ];
    }

    /** Bulunduğu kat seçenekleri */
    public static function bulunduguKatOptions(): array
    {
        $opts = ['' => 'Seçiniz'];
        $opts['Giriş Altı Kot 4'] = 'Giriş Altı Kot 4';
        $opts['Giriş Altı Kot 3'] = 'Giriş Altı Kot 3';
        $opts['Giriş Altı Kot 2'] = 'Giriş Altı Kot 2';
        $opts['Giriş Altı Kot 1'] = 'Giriş Altı Kot 1';
        $opts['Bodrum Kat'] = 'Bodrum Kat';
        $opts['Zemin Kat'] = 'Zemin Kat';
        $opts['Bahçe Katı'] = 'Bahçe Katı';
        $opts['Giriş Katı'] = 'Giriş Katı';
        $opts['Yüksek Giriş'] = 'Yüksek Giriş';
        $opts['Müstakil'] = 'Müstakil';
        $opts['Villa Tipi'] = 'Villa Tipi';
        $opts['Çatı Katı'] = 'Çatı Katı';
        for ($i = 1; $i <= 29; $i++) {
            $opts[(string) $i] = (string) $i;
        }
        $opts['30 ve üzeri'] = '30 ve üzeri';
        return $opts;
    }

    /** Kat sayısı seçenekleri */
    public static function katSayisiOptions(): array
    {
        $opts = ['' => 'Seçiniz'];
        for ($i = 1; $i <= 29; $i++) {
            $opts[(string) $i] = (string) $i;
        }
        $opts['30'] = '30 ve üzeri';
        return $opts;
    }

    /** Isınma seçenekleri */
    public static function isitmaOptions(): array
    {
        return [
            '' => 'Seçiniz',
            'Yok' => 'Yok',
            'Soba' => 'Soba',
            'Doğalgaz Sobası' => 'Doğalgaz Sobası',
            'Kat Kaloriferi' => 'Kat Kaloriferi',
            'Merkezi' => 'Merkezi',
            'Merkezi (Pay Ölçer)' => 'Merkezi (Pay Ölçer)',
            'Kombi (Doğalgaz)' => 'Kombi (Doğalgaz)',
            'Kombi (Elektrik)' => 'Kombi (Elektrik)',
            'Yerden Isıtma' => 'Yerden Isıtma',
            'Klima' => 'Klima',
            'Fancoil Ünitesi' => 'Fancoil Ünitesi',
            'Güneş Enerjisi' => 'Güneş Enerjisi',
            'Elektrikli Radyatör' => 'Elektrikli Radyatör',
            'Jeotermal' => 'Jeotermal',
            'Şömine' => 'Şömine',
            'VRV' => 'VRV',
            'Isı Pompası' => 'Isı Pompası',
        ];
    }

    /** Banyo sayısı seçenekleri */
    public static function bathroomsOptions(): array
    {
        return [
            '' => 'Seçiniz',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6 ve üzeri',
        ];
    }

    /** Mutfak seçenekleri */
    public static function mutfakOptions(): array
    {
        return [
            '' => 'Seçiniz',
            'Açık (Amerikan)' => 'Açık (Amerikan)',
            'Kapalı' => 'Kapalı',
        ];
    }

    /** Oda + Salon metni (listeleme ve detayda) */
    public function getOdaSalonAttribute(): string
    {
        if ($this->room_layout !== null && $this->room_layout !== '') {
            return self::roomLayoutOptions()[$this->room_layout] ?? $this->room_layout;
        }
        if ($this->rooms !== null || $this->salon !== null) {
            $oda = $this->rooms !== null ? (string) $this->rooms : '—';
            $salon = $this->salon !== null ? (string) $this->salon : '—';
            return $oda . '+' . $salon;
        }
        return '—';
    }
}
