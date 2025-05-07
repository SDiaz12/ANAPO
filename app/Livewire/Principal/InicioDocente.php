<?php

namespace App\Livewire\Principal;

use App\Models\AsignaturaDocente;
use App\Models\Docente;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class InicioDocente extends Component
{
    public function render()
    {
        // Obtener el usuario autenticado y su docente asociado
        $user = Auth::user();
        $docente = Docente::where('user_id', $user->id)->first();
        
        if($docente) {
            // Obtener asignaturas actuales (periodos activos)
            $clasesActuales = AsignaturaDocente::where('docente_id', $docente->id)
                ->whereHas('periodo', function ($query) {
                    $query->where('estado', 1); // Periodos activos
                })
                ->with(['asignatura', 'periodo', 'seccion'])
                ->withCount('asignaturaEstudiantes as estudiantes_count')
                ->get();

            // Obtener asignaturas históricas (periodos inactivos)
            $clasesHistoricas = AsignaturaDocente::where('docente_id', $docente->id)
                ->whereHas('periodo', function ($query) {
                    $query->where('estado', 0); // Periodos inactivos
                })
                ->with(['asignatura', 'periodo', 'seccion'])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $clasesActuales = collect();
            $clasesHistoricas = collect();
        }

        return view('livewire.principal.iniciodocente', [
            'clasesActuales' => $clasesActuales,
            'clasesHistoricas' => $clasesHistoricas,
        ])->layout('layouts.app');
    }
}