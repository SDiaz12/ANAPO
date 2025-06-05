<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use App\Models\Periodo;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteNotasController extends Controller
{
    public function cuadro($codigo_asignatura, $codigo_docente, $seccion_id, $periodo_id)
    {
        $datos = AsignaturaEstudiante::with(['matricula.estudiante', 'notas', 'asignaturadocente.asignatura', 'asignaturadocente.docente', 'asignaturadocente.seccion'])
            ->whereHas('asignaturadocente.asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura);
            })
            ->whereHas('asignaturadocente.docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->whereHas('asignaturadocente.seccion', function ($q) use ($seccion_id) {
                $q->where('id', $seccion_id);
            })
            ->whereHas('asignaturadocente.periodo', function ($q) use ($periodo_id) {
                $q->where('id', $periodo_id);
            })
            ->get()
            ->map(function ($item) {
                if ($item->notas) {
                    $nota = $item->notas;
                    $mostrarTercerParcial = $item->asignaturadocente->mostrarTercerParcial ?? false;

                    if ($mostrarTercerParcial) {
                        $promedio = ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
                    } else {
                        $promedio = ($nota->primerparcial + $nota->segundoparcial) / 2;
                    }
                    if ($nota->recuperacion > 0) {
                        if ($mostrarTercerParcial) {
                            $parciales = [$nota->primerparcial, $nota->segundoparcial, $nota->tercerparcial];
                            $minParcial = min($parciales);
                            $sumaParciales = array_sum($parciales) - $minParcial;
                            $promedio = ($sumaParciales + $nota->recuperacion) / 3;
                        } else {
                            $promedio = max($promedio, $nota->recuperacion);
                        }
                    }
                    
                    $item->notas->promedio_calculado = round($promedio, 2);
                }
                return $item;
            })
            ->filter(fn($item) => $item->notas);
        
        $mostrarTercerParcial = $datos->first()->asignaturadocente->mostrarTercerParcial ?? false;

        $pdf = Pdf::loadView('pdf.cuadro', compact('datos', 'mostrarTercerParcial'))->setPaper('A4', 'landscape');
        return $pdf->stream('cuadro_consolidado.pdf');
    }
    
    public function boletas($codigo_asignatura, $codigo_docente, $seccion_id, $periodo_id)
    {
        $datos = AsignaturaEstudiante::with(['matricula.estudiante', 'notas', 'asignaturadocente.asignatura', 'asignaturadocente.docente', 'asignaturadocente.seccion'])
            ->whereHas('asignaturadocente.asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura);
            })
            ->whereHas('asignaturadocente.docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->whereHas('asignaturadocente.seccion', function ($q) use ($seccion_id) {
                $q->where('id', $seccion_id);
            })
            ->whereHas('asignaturadocente.periodo', function ($q) use ($periodo_id) {
                $q->where('id', $periodo_id);
            })
            ->get()
            ->map(function ($item) {
                if ($item->notas) {
                    $nota = $item->notas;
                    $mostrarTercerParcial = $item->asignaturadocente->mostrarTercerParcial ?? false;

                    if ($mostrarTercerParcial) {
                        $promedio = ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
                    } else {
                        $promedio = ($nota->primerparcial + $nota->segundoparcial) / 2;
                    }

                    if ($nota->recuperacion > 0) {
                        if ($mostrarTercerParcial) {
                            $parciales = [$nota->primerparcial, $nota->segundoparcial, $nota->tercerparcial];
                            $minParcial = min($parciales);
                            $sumaParciales = array_sum($parciales) - $minParcial;
                            $promedio = ($sumaParciales + $nota->recuperacion) / 3;
                        } else {
                            $promedio = max($promedio, $nota->recuperacion);
                        }
                    }
                    
                    $item->notas->promedio_calculado = round($promedio, 2);
                    $item->notas->tiene_recuperacion = $nota->recuperacion > 0;
                }
                return $item;
            })
            ->filter(fn($item) => $item->notas);
        
        $mostrarTercerParcial = $datos->first()->asignaturadocente->mostrarTercerParcial ?? false;
        $asignatura = $datos->first()->asignaturadocente->asignatura->nombre ?? '';
        $docente = $datos->first()->asignaturadocente->docente->nombre ?? '';

        $pdf = Pdf::loadView('pdf.boletas', compact('datos', 'mostrarTercerParcial', 'asignatura', 'docente'))->setPaper('A4', 'portrait');
        return $pdf->stream('boletas.pdf');
    }
}