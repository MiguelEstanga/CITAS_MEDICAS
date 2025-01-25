<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $fillable = [
        'id_usuario',
        'id_servicio',
        'nombre',
        'apellido',
        'cedula',
        'telefono',
        'fecha',
        'precio',
    ];

    public function servicio(){
        return $this->belongsTo(Servicios::class , 'id_servicio');
    }
}
