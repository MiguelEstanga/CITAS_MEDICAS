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
        Schema::create('solicitud_respuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_solicituds')
            ->nullable()
            ->constrained('solicituds')
            ->cascadeOnDelete()
            ->nullOnDelete();

            $table->string('mensaje');
            $table->string('user_type');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_respuestas');
    }
};
