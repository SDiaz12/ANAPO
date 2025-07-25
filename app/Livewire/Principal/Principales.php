<?php

namespace App\Livewire\Principal;

use App\Models\Estado\TipoEstado;
use App\Models\Proyecto\Proyecto;
use App\Models\Personal\Empleado;
use Livewire\Component;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class Principales extends Component
{    
    public function render()
    {
        return view('livewire.principal.principal')->layout('layouts.app');
    }
}