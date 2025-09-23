<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Crear la tabla 'categories'
        Schema::create('categories', function (Blueprint $table) {
            // BIGINT sin signo autoincremental (PK)
            $table->id(); 

            // VARCHAR con un límite de 100 caracteres
            $table->string('name', 100)->unique(); 
            
            // TEXT para descripciones más largas, puede ser nulo
            $table->text('description')->nullable(); 

            // Timestamps para created_at y updated_at
            $table->timestamps(); 
        });

        // Crear la tabla 'posts'
        Schema::create('posts', function (Blueprint $table) {
            // BIGINT sin signo autoincremental (PK)
            $table->id(); 

            // VARCHAR con un límite de 255 caracteres
            $table->string('title')->default('Untitled Post'); 

            // TEXT para el contenido del post
            $table->longText('content'); 

            // Columna de tipo ENUM para el estado del post
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');

            // BIGINT sin signo para la llave foránea
            $table->unsignedBigInteger('category_id'); 

            // BOOLEAN con valor por defecto
            $table->boolean('is_featured')->nullable()->default(false); 

            // INTEGER para contador de vistas
            $table->integer('views_count')->nullable()->unsigned()->default(0);

            // TIMESTAMP para la fecha de publicación, puede ser nulo
            $table->timestamp('published_at')->nullable(); 

            // Agrega las columnas created_at y updated_at
            $table->timestamps(); 
            
            // Agrega la columna deleted_at para soft deletes
            $table->softDeletes(); 

            // --- ÍNDICES Y LLAVES FORÁNEAS ---

            // Definición de la llave foránea
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade') // o set null, restrict, etc.
                  ->onUpdate('cascade');

            // Crear un índice para la columna 'status' para mejorar búsquedas
            $table->index('status');

            // Crear un índice compuesto
            $table->index(['status', 'is_featured']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Eliminar las tablas en el orden inverso a su creación
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
    }
};
