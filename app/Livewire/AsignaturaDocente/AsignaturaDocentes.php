<?php

namespace App\Livewire\AsignaturaDocente;

use Livewire\Component;

class AsignaturaDocentes extends Component
{
    public function render()
    {
        return view('livewire.asignatura-docente.asignatura-docentes')->layout('layouts.app');
    }
}
