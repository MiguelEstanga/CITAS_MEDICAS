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
        Schema::create('estado_bucals', function (Blueprint $table) {
            $table->id();
            $table->string('abios')->nullable()->max(100);
            $table->string('lengua')->nullable()->max(100);
            $table->string('encimas')->nullable()->max(100);
            $table->string('atm')->nullable()->max(100);
            $table->string('carrillos')->nullable()->max(100);
            $table->string('examenes')->nullable()->max(100);
            $table->string('vosticulos')->nullable()->max(100);
            $table->string('paladar')->nullable()->max(100);
            $table->string('piso_lengua')->nullable()->max(100);
            $table->string('oculacion')->nullable()->max(100);
            $table->foreignId('id_presupuesto')
            ->nullable()
            ->constrained('presupuestos')
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
        Schema::dropIfExists('estado_bucals');
    }
};
