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
        ->whereHas('periodo', function($query) {
            $query->where('estado', 0); 
        })
        ->where('estudiantes_id', $matricula->id) 
        ->get();
       
        $indices = $this->calcularIndices($matricula->id);

        $tieneRegistros = $historialCompleto->isNotEmpty();

        $indices = $tieneRegistros ? $this->calcularIndices($matricula->id) : ['global' => 0];

        return view('livewire.VistaNotasEstudiantes.vista-nota-estudiantes', [
            'matricula' => $matricula,
            'historialCompleto' => $historialCompleto,
            'globalIndice' => $indices['global'],
            'tieneRegistros' => $tieneRegistros, 
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
        $asignaturas = AsignaturaEstudiante::with(['notas', 'asignaturaDocente.asignatura', 'asignaturaDocente', 'periodo'])
            ->where('estudiantes_id', $matriculaId)
            ->orderBy('periodo_id', 'desc')
            ->get();

        $sumaGlobal = ['ponderada' => 0, 'creditos' => 0];

        foreach ($asignaturas as $asignatura) {
            
            if (!$asignatura->notas || !$asignatura->asignaturaDocente || !$asignatura->asignaturaDocente->asignatura) {
                $asignatura->nota_final_calculada = 0; 
                continue;
            }

            $creditos = $asignatura->asignaturaDocente->asignatura->creditos;
            $mostrarTercerParcial = $asignatura->asignaturaDocente->mostrarTercerParcial ?? false;

            $p1 = is_numeric($asignatura->notas->primerparcial) ? $asignatura->notas->primerparcial : 0;
            $p2 = is_numeric($asignatura->notas->segundoparcial) ? $asignatura->notas->segundoparcial : 0;
            $p3 = is_numeric($asignatura->notas->tercerparcial) ? $asignatura->notas->tercerparcial : 0;
            $rec = is_numeric($asignatura->notas->recuperacion) ? $asignatura->notas->recuperacion : 0;

           
            if ($mostrarTercerParcial) {
                
                $notaFinal = ($p1 + $p2 + $p3) / 3;
            } else {
                
                $notaFinal = ($p1 + $p2) / 2;
            }

         
            if ($rec > 0) {
                if ($mostrarTercerParcial) {
                    
                    $parciales = [$p1, $p2, $p3];
                    $minParcial = min($parciales);
                    $sumaParciales = array_sum($parciales) - $minParcial;
                    $notaFinal = ($sumaParciales + $rec) / 3;
                } else {
                   
                    $notaFinal = max($notaFinal, $rec);
                }
            }

            $ponderacion = $notaFinal * $creditos;

            $sumaGlobal['ponderada'] += $ponderacion;
            $sumaGlobal['creditos'] += $creditos;
            
            
            $asignatura->nota_final_calculada = round($notaFinal, 2);
        }

        return [
            'global' => $sumaGlobal['creditos'] > 0 ? 
                    round($sumaGlobal['ponderada'] / $sumaGlobal['creditos'], 2) : 0,
        ];
    }
}