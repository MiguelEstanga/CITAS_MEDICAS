<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriaMedica extends Model
{
    protected $table = 'historia_medicas';
    protected $fillable = [
        'nombre_informe',
        'antecedentes_familiares',
        'antecedentes_personales',
        'motivo_consulta',
        'labios',
        'encimas',
        'piso_de_boca',
        'vastibulos',
        'paladar',
        'carrillos',
        'lengua',
        'atm',
        'oclucion',
        'id_paciente',
    ];

    public function user(){
        return $this->belongsTo(User::class , 'id_paciente');
    }
}
