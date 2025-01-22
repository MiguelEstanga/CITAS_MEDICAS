<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PacienteDoctor extends Model
{
    protected $table = 'paciente_doctors';
    protected $fillable = ['id_paciente', 'id_doctor'];
}
