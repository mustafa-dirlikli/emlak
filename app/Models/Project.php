<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

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
        return Property::listingTypes();
    }

    public static function propertyTypes(): array
    {
        return Property::propertyTypes();
    }

    public function isKonutType(): bool
    {
        return in_array($this->property_type, ['konut', 'daire', 'villa', 'mustakil'], true);
    }

    public function isArsaType(): bool
    {
        return $this->property_type === 'arsa';
    }

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
        return Property::currencyOptions();
    }

    public function getCurrencySymbolAttribute(): string
    {
        return match ($this->currency ?? 'TRY') {
            'USD' => '$',
            'EUR' => '€',
            default => '₺',
        };
    }

    public static function roomLayoutOptions(): array
    {
        return Property::roomLayoutOptions();
    }

    public static function binaYasiOptions(): array
    {
        return Property::binaYasiOptions();
    }

    public static function bulunduguKatOptions(): array
    {
        return Property::bulunduguKatOptions();
    }

    public static function katSayisiOptions(): array
    {
        return Property::katSayisiOptions();
    }

    public static function isitmaOptions(): array
    {
        return Property::isitmaOptions();
    }

    public static function bathroomsOptions(): array
    {
        return Property::bathroomsOptions();
    }

    public static function mutfakOptions(): array
    {
        return Property::mutfakOptions();
    }

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
