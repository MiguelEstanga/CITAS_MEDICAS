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
        Schema::table('inventarios', function (Blueprint $table) {
            $table->string('estado')->nullable(); // Agregar una nueva columna de tipo string que puede ser nula
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
        Schema::table('inventarios', function (Blueprint $table) {
            $table->dropColumn('estado'); // Eliminar la columna agregada en la migración
        });
    }
};
