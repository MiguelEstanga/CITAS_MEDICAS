<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected  $fillable = ['id_paciente', 'id_doctor', 'estado', 'descripcion'];

    public function sintomas(){
        return Sintomas::where('id_solicituds' , $this->id)->get();
    }

    public function paciente(){
        return User::find($this->id_paciente);
    }

    public function doctor()
    {
        return User::find($this->id_doctor);
    }

    public function conversacion(){
        return $this->hasMany(SolicitudRespuesta::class , 'id_solicituds');
    }
}
