<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('metodo_de_pagos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('metodo_de_pagos')->insert([
           [
            'name' => 'Efectivo',
           ],
           [
            'name' => 'Pago movil',
           ],
           [
            'name' => 'Tarjeta de crédito',
           ],
           [
            'name' => 'Transferencia bancaria',
           ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metodo_de_pagos');
    }
};
