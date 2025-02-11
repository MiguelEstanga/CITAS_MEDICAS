<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpcionesTratamiento extends Model
{
    protected $table = 'opciones_tratamientos';
    protected $fillable = ['label', 'color'];
}
