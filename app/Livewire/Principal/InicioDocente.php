<?php

namespace App\Livewire\Principal;

use App\Models\AsignaturaDocente;
use App\Models\Docente;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class InicioDocente extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        $docente = Docente::where('user_id', $user->id)->first();
        
        if($docente) {
            
            $clasesActuales = AsignaturaDocente::where('docente_id', $docente->id)
                ->whereHas('periodo', fn($query) => $query->where('estado', 1))
                ->with(['asignatura', 'periodo', 'seccion'])
                ->withCount(['asignaturaEstudiantes' => function($query) {
                    $query->where('estado', 1); 
                }])
                ->paginate(10, ['*'], 'current_page');

            $clasesHistoricas = AsignaturaDocente::where('docente_id', $docente->id)
                ->whereHas('periodo', fn($query) => $query->where('estado', 0))
                ->with(['asignatura', 'periodo', 'seccion'])
                
                ->orderBy('created_at', 'desc')
                ->paginate(10, ['*'], 'historic_page');

       
            $totalClasesActuales = $clasesActuales->total();
            $totalEstudiantesActuales = $clasesActuales->sum('asignatura_estudiantes_count');
            $totalClasesHistoricas = $clasesHistoricas->total();
           
        } else {
            $clasesActuales = collect();
            $clasesHistoricas = collect();
            $totalClasesActuales = 0;
            $totalEstudiantesActuales = 0;
            $totalClasesHistoricas = 0;
          
        }

        return view('livewire.principal.iniciodocente', [
            'clasesActuales' => $clasesActuales,
            'clasesHistoricas' => $clasesHistoricas,
            'totalClasesActuales' => $totalClasesActuales,
            'totalEstudiantesActuales' => $totalEstudiantesActuales,
            'totalClasesHistoricas' => $totalClasesHistoricas,
           
            'docente' => $docente,
        ])->layout('layouts.app');
    }
}