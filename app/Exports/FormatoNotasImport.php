<?php

namespace App\Exports;

use App\Models\AsignaturaEstudiante;
use App\Models\Nota;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log; // Asegúrate de importar Log

class FormatoNotasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Registra el contenido de cada fila para asegurarte de que se está procesando correctamente
        Log::info('Procesando fila:', $row);

        // Usamos el valor en la columna 'no' para buscar el AsignaturaEstudiante
        $asignaturaEstudianteId = $row['no']; // 'no' es el encabezado de la columna correspondiente al número de estudiante

        // Buscar el registro de AsignaturaEstudiante
        $asignaturaEstudiante = AsignaturaEstudiante::find($asignaturaEstudianteId);

        if ($asignaturaEstudiante) {
            // Crear un nuevo registro de Nota asociado a este AsignaturaEstudiante
            return new Nota([
                'asignatura_estudiante_id' =>  $row['no'], // Este es el ID del AsignaturaEstudiante
                'primerparcial' => $row['primer_parcial'], // Primer Parcial (Columna 'primer_parcial')
                'segundoparcial' => $row['segundo_parcial'], // Segundo Parcial (Columna 'segundo_parcial')
                'tercerparcial' => $row['tercer_parcial'],  // Tercer Parcial (Columna 'tercer_parcial')
                'asistencia' => $row['asistencia'],     // Asistencia (Columna 'asistencia')
                'recuperacion' => $row['recuperacion'],   // Recuperación (Columna 'recuperacion')
                'observacion' => $row['observacion'],   // Observación (Columna 'observacion')
            ]);
        }

        // Si no se encuentra el AsignaturaEstudiante, retornamos null
        return null;
    }
}
