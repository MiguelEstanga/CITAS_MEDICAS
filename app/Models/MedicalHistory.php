<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_informe',
        'fecha_nacimiento',
        'genero',
        'estado_civil',
        'antecedentes_familiares',
        'treatment_plan',
        'doctor',
        'ultimo_diagnostico',   
        'examen_fisico',
        'lab_results',
        'id_user',
        'monto_consulta',
        'estado',
    ];
}
