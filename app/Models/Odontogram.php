<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontogram extends Model
{
    protected $fillable = [
        'medical_record_id',
        'data',
        'presupuestos_id'
    ];
    protected $table = 'odontograms';
}
