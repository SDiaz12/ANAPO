<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Matricula;
use App\Models\AsignaturaEstudiante;

class PDFController extends Controller
{
    public function generarHistorial($matriculaId)
{
    $matricula = Matricula::with(['estudiante', 'programaFormacion', 'instituto'])->findOrFail($matriculaId);
    
    $historial = AsignaturaEstudiante::with(['asignatura', 'periodo', 'notas'])
        ->where('estudiantes_id', $matriculaId)
        ->get();

 
    $indices = $this->calcularIndices($matriculaId);
    $globalIndice = $indices['global'];
    $periodIndice = $indices['periodo'];

   
    $pdf = PDF::loadView('pdf.historial', [
        'matricula' => $matricula,
        'historial' => $historial,
        'estudiante' => $matricula->estudiante,
        'globalIndice' => $globalIndice,
        'periodIndice' => $periodIndice
    ]);

    return $pdf->download('historial-academico-'.$matricula->estudiante->codigo.'.pdf');
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
