<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
class LoginComponent extends Component
{
    public $email ;
    public $emailExists;
    public $verContrasena = false;

    public function ver_contrasena()
    {
        $this->verContrasena = true;
    }

    public function ocultar_contrasena()
    {
        $this->verContrasena = false;
    }

    public function updatedEmail()
    {
        $this->emailExists = User::where('email', $this->email)->exists();
    }
    public function render()
    {
        return view('livewire.login-component');
    }
}
