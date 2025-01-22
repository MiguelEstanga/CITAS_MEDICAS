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
        Schema::create('control_citas', function (Blueprint $table) {
            $table->id();
          
            $table->foreignId('evento_id')
            ->nullable()
            ->constrained('eventos')
            ->cascadeOnDelete()
            ->nullOnDelete();

            $table->boolean('pagado')->default(false);
            $table->string('resumen')->nullable()->default(null);
            $table->string('diagnostico_pdf')->nullable()->default(null);
            $table->string('resultados')->nullable()->default(null);
            $table->string('monto_consulta')->nullable()->default(0);
            $table->string('referencia')->nullable()->default(null);
            $table->string('banco')->nullable()->default(null);
            $table->string('imagen')->nullable()->default(null);
            $table->enum('estado', ['Iniciada', 'Finalizada'])->default('Iniciada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_citas');
    }
};
