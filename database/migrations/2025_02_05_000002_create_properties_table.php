<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('listing_type', ['sale', 'rent'])->default('sale'); // satılık / kiralık
            $table->string('property_type')->default('daire'); // daire, arsa, isyeri
            $table->decimal('price', 15, 2);
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->unsignedTinyInteger('rooms')->nullable(); // oda sayısı
            $table->unsignedTinyInteger('bathrooms')->nullable();
            $table->unsignedInteger('area_sqm')->nullable(); // m²
            $table->string('image')->nullable(); // ana görsel
            $table->json('gallery')->nullable(); // ek görseller
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
