<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Presupuesto;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_name',
        'avatar',
        'estado',
        'edad',
        'telefono',
        'cedula',
        'id_user',
        'antecedentes_familiares',
        'direccion'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function presupuestos(){
        return $this->hasMany(Presupuesto::class, 'id_user');
    }

    public function events(){
        return $this->hasMany(Eventos::class , 'id_user') ;
    }

    public function solicitudes_doctor(){
        return $this->hasMany(Solicitud::class , 'id_doctor') ;
    }

    public function solicitudes_paciente(){
        return $this->hasMany(Solicitud::class , 'id_paciente') ;
    }

    public function precio_citas(){
        return $this->belongsTo(PresioCita::class , 'id') ;
    }

    
}
