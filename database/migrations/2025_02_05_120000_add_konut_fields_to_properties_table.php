<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Konut: m² Brüt (net için mevcut area_sqm kullanılıyor)
            $table->unsignedInteger('area_brut')->nullable()->after('area_sqm'); // m² (Brüt)
            $table->string('bina_yasi')->nullable()->after('bathrooms');        // Bina Yaşı
            $table->string('bulundugu_kat')->nullable()->after('bina_yasi');    // Bulunduğu Kat
            $table->unsignedTinyInteger('kat_sayisi')->nullable()->after('bulundugu_kat'); // Kat Sayısı
            $table->string('isitma')->nullable()->after('kat_sayisi');           // Isıtma
            $table->string('mutfak')->nullable()->after('isitma');               // Mutfak
            $table->string('balkon')->nullable()->after('mutfak');               // Balkon
            $table->boolean('asansor')->nullable()->after('balkon');             // Asansör
            $table->string('otopark')->nullable()->after('asansor');             // Otopark
            $table->boolean('esyali')->nullable()->after('otopark');             // Eşyalı
            $table->string('kullanim_durumu')->nullable()->after('esyali');      // Kullanım Durumu
            $table->boolean('site_icerisinde')->nullable()->after('kullanim_durumu'); // Site İçerisinde
            $table->string('site_adi')->nullable()->after('site_icerisinde');    // Site Adı
            $table->decimal('aidat', 12, 2)->nullable()->after('site_adi');      // Aidat (TL)
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'area_brut',
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
            ]);
        });
    }
};
