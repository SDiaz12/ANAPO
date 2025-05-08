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

       
        $indices = $this->calcularIndices($matricula->id);

        return view('livewire.VistaNotasEstudiantes.vista-nota-estudiantes', [
            'matricula' => $matricula,
            'historialCompleto' => $historialCompleto,
            'globalIndice' => $indices['global'],
           
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
          
            'estudiante' => null,
            'programaformacion' => null,
            'instituto' => null
        ])->layout('layouts.app');
    }

    protected function calcularIndices($matriculaId)
    {
        
        $asignaturas = AsignaturaEstudiante::with(['notas', 'asignaturaDocente.asignatura', 'periodo'])
            ->where('estudiantes_id', $matriculaId)
            ->orderBy('periodo_id', 'desc')
            ->get();
    
        $sumaGlobal = ['ponderada' => 0, 'creditos' => 0];
       
    
        foreach ($asignaturas as $asignatura) {
            if (!$asignatura->notas || !$asignatura->asignaturaDocente->asignatura) continue;
    
            $creditos = $asignatura->asignaturaDocente->asignatura->creditos;
            $notaFinal = ($asignatura->notas->primerparcial + 
                         $asignatura->notas->segundoparcial + 
                         $asignatura->notas->tercerparcial) / 3;
            $ponderacion = $notaFinal * $creditos;
    
           
            $sumaGlobal['ponderada'] += $ponderacion;
            $sumaGlobal['creditos'] += $creditos;
    
            
           
        }
    
        return [
            'global' => $sumaGlobal['creditos'] > 0 ? 
                       round($sumaGlobal['ponderada'] / $sumaGlobal['creditos'], 2) : 0,
           
        ];
    }
}