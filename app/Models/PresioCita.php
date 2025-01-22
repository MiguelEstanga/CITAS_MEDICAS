<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresioCita extends Model
{
   protected $fillable = ['doctor_id' , 'precio'];

    public function doctor(){
        return $this->belongsTo(User::class , 'doctor_id');
    }
}
