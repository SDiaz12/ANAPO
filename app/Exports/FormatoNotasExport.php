<?php

namespace App\Exports;

use App\Models\AsignaturaEstudiante;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FormatoNotasExport implements FromCollection, WithHeadings
{
    /**
     * Devuelve los encabezados del archivo Excel.
     */
    public function headings(): array
    {
        return [
            'Código Estudiante',
            'Nombre Estudiante',
            'Apellido Estudiante',
            'Código Asignatura',
            'Nombre Asignatura',
            'Primer Parcial',
            'Segundo Parcial',
            'Tercer Parcial',
            'Asistencia',
            'Recuperación',
            'Promedio',
            'Observación',
        ];
    }

    /**
     * Devuelve la colección de datos para exportar.
     */
    public function collection()
    {
        return AsignaturaEstudiante::with([
            'estudiante', // Relación con estudiantes
            'asignaturadocente.asignatura', // Relación con asignatura
            'notas' // Relación con las notas
        ])->get()->map(function ($item) {
            return [
                'codigo_estudiante' => $item->estudiante->codigo ?? 'Sin código',
                'nombre_estudiante' => $item->estudiante->nombre ?? 'Sin nombre',
                'apellido_estudiante' => $item->estudiante->apellido ?? 'Sin apellido',
                'codigo_asignatura' => $item->asignaturadocente->asignatura->codigo ?? 'Sin código',
                'nombre_asignatura' => $item->asignaturadocente->asignatura->nombre ?? 'Sin nombre',
                'primer_parcial' => $item->notas->primerparcial ?? 'Sin nota',
                'segundo_parcial' => $item->notas->segundoparcial ?? 'Sin nota',
                'tercer_parcial' => $item->notas->tercerparcial ?? 'Sin nota',
                'asistencia' => $item->notas->asistencia ?? 'Sin dato',
                'recuperacion' => $item->notas->recuperacion ?? 'Sin nota',
                'promedio' => $item->notas->promedio ?? 'Sin promedio',
                'observacion' => $item->notas->observacion ?? 'Sin observación',
            ];
        });
    }
}
