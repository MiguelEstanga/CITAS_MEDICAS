<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoBucal extends Model
{
    protected $table = 'estado_bucals';
    public $timestamps = false;
    protected $fillable = [
        'labios',
        'lengua',
        'encimas',
        'atm',
        'carrillos',
        'examenes',
        'vosticulos',
        'paladar',
        'piso_lengua',
        'oculacion',
        'id_presupuesto'
    ];
}
