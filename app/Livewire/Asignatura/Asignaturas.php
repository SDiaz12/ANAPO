<?php

namespace App\Livewire\Asignatura;

use Livewire\Component;

class Asignaturas extends Component
{
    public function render()
    {
        return view('livewire.asignatura.asignaturas')->layout('layouts.app');
    }
}
