<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('listing_type', ['sale', 'rent'])->default('sale');
            $table->string('property_type')->default('daire');
            $table->string('kategori')->nullable();
            $table->string('isyeri_durumu')->nullable();
            $table->string('isyeri_turu')->nullable();
            $table->string('bolum_oda_sayisi')->nullable();
            $table->decimal('price', 15, 2);
            $table->string('currency', 10)->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('address')->nullable();
            $table->text('lokasyon')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->unsignedTinyInteger('rooms')->nullable();
            $table->unsignedTinyInteger('salon')->nullable();
            $table->string('room_layout', 20)->nullable();
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedInteger('area_sqm')->nullable();
            $table->unsignedInteger('area_brut')->nullable();
            $table->decimal('price_per_sqm', 15, 2)->nullable();
            $table->string('bina_yasi')->nullable();
            $table->string('bulundugu_kat')->nullable();
            $table->unsignedTinyInteger('kat_sayisi')->nullable();
            $table->string('isitma')->nullable();
            $table->string('mutfak')->nullable();
            $table->string('balkon')->nullable();
            $table->boolean('asansor')->nullable();
            $table->string('otopark')->nullable();
            $table->boolean('esyali')->nullable();
            $table->string('kullanim_durumu')->nullable();
            $table->boolean('site_icerisinde')->nullable();
            $table->string('site_adi')->nullable();
            $table->decimal('aidat', 12, 2)->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('personel')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('ilan_no')->nullable();
            $table->date('ilan_tarihi')->nullable();
            $table->string('imar_durumu')->nullable();
            $table->string('ada_no')->nullable();
            $table->string('parsel_no')->nullable();
            $table->string('pafta_no')->nullable();
            $table->string('kaks')->nullable();
            $table->string('gabari')->nullable();
            $table->boolean('krediye_uygunluk')->nullable();
            $table->string('tapu_durumu')->nullable();
            $table->boolean('takas')->nullable();
            $table->json('ilan_detay')->nullable();
            $table->json('arsa_ozellikler')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
