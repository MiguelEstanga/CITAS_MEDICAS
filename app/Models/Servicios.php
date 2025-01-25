<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    protected $table = 'servicios';
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'precio',
        'id_usuer',
        'estado'
    ];
}
