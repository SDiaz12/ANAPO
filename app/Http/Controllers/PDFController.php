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
        
        $historial = AsignaturaEstudiante::with([
            'asignaturaDocente.asignatura', 
            'periodo', 
            'notas',
            'asignaturaDocente.seccion',
            'asignaturaDocente.docente'
        ])
        ->where('estudiantes_id', $matriculaId)
        ->orderBy('periodo_id', 'desc')
        ->get();

        $indices = $this->calcularIndices($matriculaId);
        $globalIndice = $indices['global'];
  

        $pdf = PDF::loadView('pdf.historial', [
            'matricula' => $matricula,
            'historial' => $historial,
            'estudiante' => $matricula->estudiante,
            'globalIndice' => $globalIndice,
           
         
        ]);

        return $pdf->download('historial-academico-'.$matricula->estudiante->codigo.'.pdf');
    }

    protected function calcularIndices($matriculaId)
    {
        $asignaturas = AsignaturaEstudiante::with([
            'notas', 
            'asignaturaDocente.asignatura',
            'periodo'
        ])
        ->where('estudiantes_id', $matriculaId)
        ->orderBy('periodo_id', 'desc')
        ->get();

        $sumaPonderadaGlobal = 0;
        $sumaCreditosGlobal = 0;
        
      

        foreach ($asignaturas as $asignatura) {
            $nota = $asignatura->notas;
            $creditos = $asignatura->asignaturaDocente->asignatura->creditos ?? 0;
            $periodoId = $asignatura->periodo->id ?? null;

            if ($nota && $creditos > 0) {
                $promedio = ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
                $ponderacion = $promedio * $creditos;
                
               
                $sumaPonderadaGlobal += $ponderacion;
                $sumaCreditosGlobal += $creditos;
                
               
            }
        }

        $indiceGlobal = $sumaCreditosGlobal > 0 ? 
            round($sumaPonderadaGlobal / $sumaCreditosGlobal, 2) : 0;
        
       

        return [
            'global' => $indiceGlobal,
           
        ];
    }
}