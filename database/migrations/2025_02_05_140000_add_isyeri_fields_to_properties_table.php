<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('kategori')->nullable()->after('property_type');           // İş yeri: Kategori
            $table->string('isyeri_durumu')->nullable()->after('kategori');            // İş yeri: Durumu
            $table->string('isyeri_turu')->nullable()->after('isyeri_durumu');          // İş yeri: Türü
            $table->string('bolum_oda_sayisi')->nullable()->after('area_sqm');          // İş yeri: Bölüm & Oda Sayısı
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'isyeri_durumu', 'isyeri_turu', 'bolum_oda_sayisi']);
        });
    }
};
