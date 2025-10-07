<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Columna para tags (array de strings)
            $table->json('tags')->nullable()->after('content');

            // Columna para metadatos (array de objetos clave-valor)
            $table->json('meta_data')->nullable()->after('tags');

            // Columna para una galería de imágenes (array de rutas)
            $table->json('gallery_images')->nullable()->after('meta_data');
            
            // Columna para información estructurada (objeto simple)
            $table->json('author_info')->nullable()->after('gallery_images');
            $table->timestamp('manual_created_at')->nullable()->after('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['tags', 'meta_data', 'gallery_images', 'author_info', 'manual_created_at']);
        });
    }
};
