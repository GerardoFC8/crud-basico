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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->text('summary');
            $table->longText('content');
            $table->string('image', 255)->nullable();
            $table->string('source', 255)->nullable();
            $table->text('tags')->nullable();
            $table->enum('status', ["draft","published","archived"])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
