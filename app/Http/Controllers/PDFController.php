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
        ->whereHas('periodo', function($query) {
            $query->where('estado', 0);
        })
        ->where('estudiantes_id', $matriculaId)
        ->orderBy('periodo_id', 'desc')
        ->get();

      
        $tieneRegistros = $historial->isNotEmpty();
        $globalIndice = $tieneRegistros ? $this->calcularIndices($matriculaId)['global'] : 0;

        $pdf = PDF::loadView('pdf.historial', [
            'matricula' => $matricula,
            'historial' => $historial,
            'estudiante' => $matricula->estudiante,
            'globalIndice' => $globalIndice,
            'tieneRegistros' => $tieneRegistros 
        ]);

        return $pdf->download('historial-academico-'.$matricula->estudiante->codigo.'.pdf');
    }

    protected function calcularIndices($matriculaId)
    {
        $asignaturas = AsignaturaEstudiante::with([
            'notas', 
            'asignaturaDocente.asignatura',
            'asignaturaDocente',
            'periodo'
        ])
        ->whereHas('periodo', function($query) {
            $query->where('estado', 0); 
        })
        ->where('estudiantes_id', $matriculaId)
        ->orderBy('periodo_id', 'desc')
        ->get();

        $sumaPonderadaGlobal = 0;
        $sumaCreditosGlobal = 0;

        foreach ($asignaturas as $asignatura) {
            if (!$asignatura->notas || !$asignatura->asignaturaDocente || !$asignatura->asignaturaDocente->asignatura) {
                continue;
            }

            $creditos = $asignatura->asignaturaDocente->asignatura->creditos;
            $mostrarTercerParcial = $asignatura->asignaturaDocente->mostrarTercerParcial ?? false;
            $p1 = (float)($asignatura->notas->primerparcial ?? 0);
            $p2 = (float)($asignatura->notas->segundoparcial ?? 0);
            $rec = (float)($asignatura->notas->recuperacion ?? 0);

            if ($mostrarTercerParcial) {
                $p3 = (float)($asignatura->notas->tercerparcial ?? 0);
                $promedio = ($p1 + $p2 + $p3) / 3;
                
                if ($rec > 0) {
                    $minParcial = min($p1, $p2, $p3);
                    $promedio = ($p1 + $p2 + $p3 - $minParcial + $rec) / 3;
                }
            } else {
                $promedio = ($p1 + $p2) / 2;
                
                if ($rec > 0) {
                    $promedio = max($promedio, $rec);
                }
            }

            $sumaPonderadaGlobal += $promedio * $creditos;
            $sumaCreditosGlobal += $creditos;
        }

        return [
            'global' => $sumaCreditosGlobal > 0 ? 
                round($sumaPonderadaGlobal / $sumaCreditosGlobal, 2) : 0,
        ];
    }
}