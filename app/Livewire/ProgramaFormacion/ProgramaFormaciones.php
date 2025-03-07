<?php

namespace App\Livewire\ProgramaFormacion;

use Livewire\Component;

class ProgramaFormaciones extends Component
{
    public function render()
    {
        return view('livewire.programa-formacion.programa-formaciones')->layout('layouts.app');
    }
}
