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
        Schema::create('medical_histories', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_informe');
            $table->string('fecha_nacimiento');
            $table->string('genero');
            $table->string('estado_civil');
            $table->string('antecedentes_familiares');
            $table->string('treatment_plan');
            $table->string('doctor');
            $table->string('lab_results')->nullable();
            $table->string('ultimo_diagnostico')->nullable();
            $table->string('examen_fisico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
