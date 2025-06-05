<?php

namespace App\Exports;

use App\Models\AsignaturaEstudiante;
use App\Models\Nota;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class FormatoNotasImport implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 14; 
    }

  public function collection(Collection $filas)
    {
        foreach ($filas as $fila) {
            $asignaturaEstudianteId = $fila[12] ?? null;
            if (!$asignaturaEstudianteId) {
                Log::error("No hay ID de asignatura_estudiante en la fila.");
                continue;
            }

            $asignaturaEstudiante = AsignaturaEstudiante::with('asignaturadocente')->find($asignaturaEstudianteId);
            if (!$asignaturaEstudiante) {
                Log::error("AsignaturaEstudiante no encontrada para ID: {$asignaturaEstudianteId}");
                continue;
            }

            $mostrarTercerParcial = $asignaturaEstudiante->asignaturadocente
                ? $asignaturaEstudiante->asignaturadocente->mostrarTercerParcial
                : 0;

            $nota = Nota::firstOrNew([
                'asignatura_estudiante_id' => $asignaturaEstudiante->id,
            ]);

            if (!isset($fila[4]) || $fila[4] === '' || !is_numeric($fila[4])) {
                Log::error("Primer parcial obligatorio y no válido en fila para asignatura_estudiante_id: {$asignaturaEstudiante->id}");
                continue;
            }

            $nota->primerparcial = max(0, min(100, $fila[4]));
            $nota->segundoparcial = (isset($fila[5]) && $fila[5] !== '' && is_numeric($fila[5])) ? max(0, min(100, $fila[5])) : null;

            if ($mostrarTercerParcial == 1) {
                $nota->tercerparcial = (isset($fila[6]) && $fila[6] !== '' && is_numeric($fila[6])) ? max(0, min(100, $fila[6])) : null;
                $nota->recuperacion = (isset($fila[8]) && $fila[8] !== '' && is_numeric($fila[8])) ? max(0, min(100, $fila[8])) : null;
                $nota->asistencia = (isset($fila[9]) && is_numeric($fila[9])) ? $fila[9] : null;
                $nota->observacion = $fila[11] ?? null;
            } else {
                $nota->tercerparcial = null;
                $nota->recuperacion = (isset($fila[7]) && $fila[7] !== '' && is_numeric($fila[7])) ? max(0, min(100, $fila[7])) : null;
                $nota->asistencia = (isset($fila[9]) && is_numeric($fila[9])) ? $fila[9] : null;
                $nota->observacion = $fila[10] ?? null;
            }

            try {
                $nota->save();
            } catch (\Exception $e) {
                Log::error("Error guardando nota: " . $e->getMessage());
                continue;
            }
        }
    }


}

