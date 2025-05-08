<?php

namespace App\Livewire\VistaNotasEstudiantes;

use App\Models\Matricula;
use App\Models\AsignaturaEstudiante;
use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VistaNotaEstudiantes extends Component
{
    public $matriculaId;

    public function mount($matriculaId = null)
    {
        $this->matriculaId = $matriculaId;
    }

    public function render()
    {
       
        $user = Auth::user();
        
       
        $estudiante = Estudiante::where('user_id', $user->id)->first();
        
        if (!$estudiante) {
            return $this->emptyState();
        }

       
        $matricula = Matricula::with(['programaFormacion', 'instituto'])
            ->when($this->matriculaId, function($q) {
                $q->where('id', $this->matriculaId);
            })
            ->where('estudiante_id', $estudiante->id)
            ->where('estado', 1)
            ->first();

        if (!$matricula) {
            return $this->emptyState();
        }

      
        $historialCompleto = AsignaturaEstudiante::with([
            'notas',
            'asignatura',
            'periodo',
            'asignaturaDocente.docente'
        ])
        ->where('estudiantes_id', $matricula->id) 
        ->get();

        // Calcular índices académicos
        $indices = $this->calcularIndices($matricula->id);

        return view('livewire.VistaNotasEstudiantes.vista-nota-estudiantes', [
            'matricula' => $matricula,
            'historialCompleto' => $historialCompleto,
            'globalIndice' => $indices['global'],
            'periodIndice' => $indices['periodo'],
            'estudiante' => $estudiante,
            'programaformacion' => $matricula->programaFormacion,
            'instituto' => $matricula->instituto
        ])->layout('layouts.app');
    }

    protected function emptyState()
    {
        return view('livewire.VistaNotasEstudiantes.vista-nota-estudiantes', [
            'matricula' => null,
            'historialCompleto' => collect(),
            'globalIndice' => 0,
            'periodIndice' => 0,
            'estudiante' => null,
            'programaformacion' => null,
            'instituto' => null
        ])->layout('layouts.app');
    }

    protected function calcularIndices($matriculaId)
    {
        $asignaturas = AsignaturaEstudiante::with(['notas', 'asignatura', 'periodo'])
            ->where('estudiantes_id', $matriculaId) 
            ->get();

        $sumaPonderadaGlobal = 0;
        $sumaCreditosGlobal = 0;
        
        $sumaPonderadaPeriodo = [];
        $sumaCreditosPeriodo = [];

        foreach ($asignaturas as $asignatura) {
            $nota = $asignatura->notas;
            $creditos = $asignatura->asignatura->creditos ?? 0;
            $periodoId = $asignatura->periodo->id ?? null;

            if ($nota && $creditos > 0) {
                $promedio = ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
                
              
                $sumaPonderadaGlobal += $promedio * $creditos;
                $sumaCreditosGlobal += $creditos;
                
                
                if ($periodoId) {
                    if (!isset($sumaPonderadaPeriodo[$periodoId])) {
                        $sumaPonderadaPeriodo[$periodoId] = 0;
                        $sumaCreditosPeriodo[$periodoId] = 0;
                    }
                    $sumaPonderadaPeriodo[$periodoId] += $promedio * $creditos;
                    $sumaCreditosPeriodo[$periodoId] += $creditos;
                }
            }
        }

      
        $indiceGlobal = $sumaCreditosGlobal > 0 ? 
            round($sumaPonderadaGlobal / $sumaCreditosGlobal, 2) : 0;
        
       
        $indicesPeriodo = [];
        foreach ($sumaPonderadaPeriodo as $periodoId => $suma) {
            $indicesPeriodo[$periodoId] = round($suma / $sumaCreditosPeriodo[$periodoId], 2);
        }

        return [
            'global' => $indiceGlobal,
            'periodo' => $indicesPeriodo
        ];
    }
}