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
         Schema::table('presupuestos', function (Blueprint $table) {
            $table->string('tratamiento')->nullable();
            $table->string('unidad_dental')->nullable();
            $table->string('tratamiento_realizado')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
