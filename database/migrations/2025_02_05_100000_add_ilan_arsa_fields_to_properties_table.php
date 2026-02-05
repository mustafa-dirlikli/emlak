<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('ilan_no')->nullable()->after('slug');           // İlan No
            $table->date('ilan_tarihi')->nullable()->after('ilan_no');      // İlan Tarihi
            $table->string('imar_durumu')->nullable()->after('property_type'); // İmar Durumu
            $table->decimal('price_per_sqm', 15, 2)->nullable()->after('area_sqm'); // m² Fiyatı
            $table->string('ada_no')->nullable()->after('price_per_sqm');   // Ada No
            $table->string('parsel_no')->nullable()->after('ada_no');       // Parsel No
            $table->string('pafta_no')->nullable()->after('parsel_no');      // Pafta No
            $table->string('kaks')->nullable()->after('pafta_no');           // Kaks (Emsal)
            $table->string('gabari')->nullable()->after('kaks');             // Gabari
            $table->boolean('krediye_uygunluk')->nullable()->after('gabari'); // Krediye Uygunluk
            $table->string('tapu_durumu')->nullable()->after('krediye_uygunluk'); // Tapu Durumu
            $table->boolean('takas')->nullable()->after('tapu_durumu');      // Takas
            $table->json('ilan_detay')->nullable()->after('takas');          // İlan detay (JSON)
            $table->text('lokasyon')->nullable()->after('address');         // Lokasyon (text)
            $table->json('arsa_ozellikler')->nullable()->after('gallery');   // Arsa özellikleri (nullable)
            $table->string('personel')->nullable()->after('user_id');       // Personel (nullable)
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'ilan_no',
                'ilan_tarihi',
                'imar_durumu',
                'price_per_sqm',
                'ada_no',
                'parsel_no',
                'pafta_no',
                'kaks',
                'gabari',
                'krediye_uygunluk',
                'tapu_durumu',
                'takas',
                'ilan_detay',
                'lokasyon',
                'arsa_ozellikler',
                'personel',
            ]);
        });
    }
};
