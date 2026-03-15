<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Verifica y agrega la columna de stock si no existe
            if (!Schema::hasColumn('products', 'is_in_stock')) {
                $table->boolean('is_in_stock')->default(true);
            }
            
            // Verifica y agrega las columnas para las imágenes extra si no existen
            if (!Schema::hasColumn('products', 'image_2')) {
                $table->string('image_2')->nullable();
            }
            if (!Schema::hasColumn('products', 'image_3')) {
                $table->string('image_3')->nullable();
            }
            if (!Schema::hasColumn('products', 'image_4')) {
                $table->string('image_4')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_in_stock', 'image_2', 'image_3', 'image_4']);
        });
    }
};