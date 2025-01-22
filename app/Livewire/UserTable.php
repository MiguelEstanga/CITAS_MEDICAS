<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserTable extends Component
{
    public function render()
    {
        return view('livewire.user-table' , [
            'users' => User::all()
        ]);
    }
}
