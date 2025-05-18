<?php

namespace App\Exports;

use App\Models\AsignaturaEstudiante;
use App\Models\Nota;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class FormatoNotasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $asignaturaEstudianteId = $row['no'];

        $asignaturaEstudiante = AsignaturaEstudiante::find($asignaturaEstudianteId);

        if ($asignaturaEstudiante) {
            $exists = Nota::where('asignatura_estudiante_id', $asignaturaEstudianteId)
                ->exists();

            if ($exists) {
                Log::warning('Ya existe una nota registrada para esta combinación de asignatura, estudiante y periodo.');
                return null;
            }

            return new Nota([
                'asignatura_estudiante_id' => $asignaturaEstudianteId,
                'primerparcial' => $row['primer_parcial'],
                'segundoparcial' => $row['segundo_parcial'],
                'tercerparcial' => $row['tercer_parcial'],
                'asistencia' => $row['asistencia'],
                'recuperacion' => $row['recuperacion'],
                'observacion' => $row['observacion'],
            ]);
        }

        return null;
    }
}
