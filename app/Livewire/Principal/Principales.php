<?php

namespace App\Livewire\Principal;

use App\Models\Asignatura;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Matricula;
use App\Models\ProgramaFormacion;
use App\Models\Promocion;
use Livewire\Component;

class Principales extends Component
{
    public $data = [];

    public function mount()
    {
        $this->data = [
            'femenino' => Estudiante::where('sexo', 'femenino')->count(),
            'masculino' => Estudiante::where('sexo', 'masculino')->count(),
        ];
    }
    public function render()
    {
        $docentesCount = Docente::count();
        $estudiantesCount = Estudiante::count();
        $asignaturasCount = Asignatura::count();
        $promocionesCount = Promocion::count();
        $programasCount = ProgramaFormacion::count();

        // Obtener las 5 últimas matrículas (puedes cambiar el número según tus necesidades)
        $recentMatriculas = Matricula::orderBy('created_at','desc')->take(20)->get();

        return view('livewire.principal.principal', [
            'docentesCount'     => $docentesCount, 
            'estudiantesCount'  => $estudiantesCount,
            'asignaturasCount'  => $asignaturasCount,
            'promocionesCount'  => $promocionesCount,
            'programasCount'    => $programasCount,
            'recentMatriculas'  => $recentMatriculas,
            'data'              => $this->data,
            ])->layout('layouts.app');
    }
}
