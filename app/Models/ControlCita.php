<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlCita extends Model
{
    protected $table = 'control_citas';
    protected $fillable = [
        'evento_id',
        'pagado',
        'resumen',
        'diagnostico_pdf',
        'resultados',
        'monto_consulta',
        'referencia',
        'banco',
        'imagen'
    ];

    public function evento(){
        return $this->belongsTo(Eventos::class , 'evento_id');
    }

    public function historia_medica(){
        return $this->belongsTo(HistoriaMedica::class , 'id');
    }

    public function presupuesto(){
        return $this->hasMany(Presupuesto::class , 'id_control_citas');
    }
}
