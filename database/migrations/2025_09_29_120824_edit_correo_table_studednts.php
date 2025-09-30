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
        // Verifica si la columna 'correo' existe antes de intentar renombrarla
        if (Schema::hasColumn('students', 'correo')) {
            Schema::table('students', function (Blueprint $table) {
                $table->renameColumn('correo', 'email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Verifica si la columna 'email' existe antes de intentar renombrarla de vuelta
        if (Schema::hasColumn('students', 'email')) {
            Schema::table('students', function (Blueprint $table) {
                $table->renameColumn('email', 'correo');
            });
        }
    }
};
