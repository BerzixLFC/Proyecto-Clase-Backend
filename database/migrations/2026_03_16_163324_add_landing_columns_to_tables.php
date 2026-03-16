<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Añadimos las 4 imágenes a la configuración del Home
        Schema::table('home_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('home_settings', 'hero_image_1')) {
                $table->string('hero_image_1')->nullable();
                $table->string('hero_image_2')->nullable();
                $table->string('hero_image_3')->nullable();
                $table->string('hero_image_4')->nullable();
            }
        });

        // 2. Añadimos la columna para saber si el producto sale en el Home
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('home_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_image_1', 'hero_image_2', 'hero_image_3', 'hero_image_4']);
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }
};