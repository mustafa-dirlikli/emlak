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
        'city',
        'district',
        'address',
        'lokasyon',
        'rooms',
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
        ];
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
}
