<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteNotasController extends Controller
{
    public function cuadro($codigo_asignatura, $codigo_docente)
    {
        $datos = AsignaturaEstudiante::with(['matricula.estudiante', 'notas', 'asignaturadocente.asignatura', 'asignaturadocente.docente'])
            ->whereHas('asignaturadocente.asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura);
            })
            ->whereHas('asignaturadocente.docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->get()
            ->filter(fn($item) => $item->notas);
    
        $pdf = Pdf::loadView('pdf.cuadro', compact('datos'))->setPaper('A4', 'landscape');
        return $pdf->stream('cuadro_consolidado.pdf');
    }
    
    public function boletas($codigo_asignatura, $codigo_docente)
    {
        $datos = AsignaturaEstudiante::with(['matricula.estudiante', 'notas', 'asignaturadocente.asignatura', 'asignaturadocente.docente'])
            ->whereHas('asignaturadocente.asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura);
            })
            ->whereHas('asignaturadocente.docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            })
            ->get()
            ->filter(fn($item) => $item->notas);
    
        $pdf = Pdf::loadView('pdf.boletas', compact('datos'))->setPaper('A4', 'portrait');
        return $pdf->stream('boletas.pdf');
    }
}

