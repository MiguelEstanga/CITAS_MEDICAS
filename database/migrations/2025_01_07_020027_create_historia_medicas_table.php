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
        Schema::create('historia_medicas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_informe');
            $table->string('antecedentes_familiares');
            $table->string('antecedentes_personales');
            $table->string('motivo_consulta');
            $table->string('labios');
            $table->string('encimas');
            $table->string('piso_de_boca');
            $table->string('vastibulos');
            $table->string('paladar');
            $table->string('carrillos');
            $table->string('lengua');
            $table->string('atm');
            $table->string('oclucion');
            
            $table->foreignId('id_paciente')
            ->nullable()
            ->constrained('users')
            ->cascadeOnDelete()
            ->nullOnDelete();

            $table->foreignId('id_control_citas')
            ->nullable()
            ->constrained('control_citas')
            ->cascadeOnDelete()
            ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historia_medicas');
    }
};
