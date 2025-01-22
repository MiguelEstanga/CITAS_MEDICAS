<?php

namespace App\Livewire;

use Livewire\Component;

class CustomModal extends Component
{
    public $isOpen = true;
    protected $listeners = ['openModal' => 'toggleModal'];
    public function toggleModal()
    {
        $this->isOpen = !$this->isOpen;
    }
    public function close()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.custom-modal');
    }
}
