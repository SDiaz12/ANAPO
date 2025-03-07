<?php

namespace App\Livewire\Estudiant;

use Livewire\Component;

class Estudiants extends Component
{
    public function render()
    {
        return view('livewire.estudiant.estudiants')->layout('layouts.app');
    }
}
