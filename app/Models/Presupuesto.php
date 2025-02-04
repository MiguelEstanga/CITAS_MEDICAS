<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'presupuestos';
    protected $fillable = [
        'diagnostico',
        'observacion',
        'fecha',
        'id_user',
        'a_cuenta',
        'saldo',
        'total',
        'metodo_de_pago',
        'tratamiento',
        'unidad_dental',
        'tratamiento_realizado',
         'costo',
         'abono',
        'pagado',
        'cancelado',
        'prestamo',
    ];
    public function odontograma(){
        return $this->hasOne(Odontogram::class, 'presupuestos_id');
    }
    public function control_citas()
    {
        return $this->belongsTo(ControlCita::class, 'id_control_citas');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
