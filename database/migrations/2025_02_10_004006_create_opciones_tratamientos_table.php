<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Tratamiento;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opciones_tratamientos', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('color');
            $table->timestamps();
        });

        $estadoOpciones = [
            ["label" => "empastizado", "color" => "#B5651D"],
            ["label" => "caries", "color" => "#FF0000"],
            ["label" => "sano", "color" => "#00FF00"],
            ["label" => "extraccion", "color" => "#000000"],
            ["label" => "odontopediatria", "color" => "#FF69B4"],
            ["label" => "ortodoncia", "color" => "#0000FF"],
            ["label" => "protesis dental", "color" => "#8A2BE2"],
            ["label" => "endodoncia", "color" => "#FFA500"],
            ["label" => "eliminar", "color" => "#FFFFFF"] // "blanco" para resetear
        ];
        DB::table('opciones_tratamientos')->insert($estadoOpciones);
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_tratamientos');
    }
};
