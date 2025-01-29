<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
  
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'cantidad',
        'imagen',
        'tipo_producto',
        'estado'
    ];

    public function estado()
    {
        return EstadoInventario::find($this->estado)->name ?? '';
    }
}
