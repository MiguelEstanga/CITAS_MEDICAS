<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudRespuesta extends Model
{
    protected $fillable = ['id_solicituds' , 'mensaje', 'user_type'];

    public function solicitud(){
        return Solicitud::find($this->id_solicituds);
    }

    
}
