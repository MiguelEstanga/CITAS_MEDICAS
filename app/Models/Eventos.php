<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    protected $fillable = ['title', 'start', 'end','id_paciente','id_user' , 'color'];

    public function doctor(){
        return $this->belongsTo(User::class, 'id_doctor');
    }

    public function paciente(){
        return $this->belongsTo(User::class, 'id_paciente');
    }

    public function control_citas() {
        return $this->hasMany(ControlCita::class, 'evento_id');
    }
    
}
