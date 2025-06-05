<?php

namespace App\Imports;

use App\Models\AsignaturaEstudiante;
use App\Models\Nota;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class ActualizarNotas implements ToCollection, WithStartRow
{
    public function startRow(): int
    {
        return 14;
    }

    public function collection(Collection $filas)
    {
        foreach ($filas as $fila) {
           
            $asignaturaEstudianteId = null;
            $tentativoId3Parciales = $fila[12] ?? null;
            $tentativoId2Parciales = $fila[12] ?? null;
            $asignaturaEstudiante = null;

            if ($tentativoId3Parciales) {
                $asignaturaEstudiante = AsignaturaEstudiante::with('asignaturadocente')->find($tentativoId3Parciales);
            }

            if (!$asignaturaEstudiante && $tentativoId2Parciales) {
                $asignaturaEstudiante = AsignaturaEstudiante::with('asignaturadocente')->find($tentativoId2Parciales);
            }

            if (!$asignaturaEstudiante) {
                Log::error("No se encontró asignatura_estudiante con ID: {$tentativoId3Parciales} o {$tentativoId2Parciales}");
                continue;
            }

            $nota = Nota::firstOrNew([
                'asignatura_estudiante_id' => $asignaturaEstudiante->id,
            ]);

            $mostrarTercerParcial = $asignaturaEstudiante->asignaturadocente
                ? $asignaturaEstudiante->asignaturadocente->mostrarTercerParcial
                : 0;

            if ($mostrarTercerParcial == 1) {
                $nota->primerparcial = is_numeric($fila[4]) ? max(0, min(100, $fila[4])) : null;
                $nota->segundoparcial = is_numeric($fila[5]) ? max(0, min(100, $fila[5])) : null;
                $nota->tercerparcial = is_numeric($fila[6]) ? max(0, min(100, $fila[6])) : null;
                $nota->recuperacion = is_numeric($fila[8]) ? max(0, min(100, $fila[8])) : null;
                $nota->asistencia = is_numeric($fila[9]) ? $fila[9] : null;
                $nota->observacion = $fila[11] ?? null;
            } else {
                $nota->primerparcial = is_numeric($fila[4]) ? max(0, min(100, $fila[4])) : null;
                $nota->segundoparcial = is_numeric($fila[5]) ? max(0, min(100, $fila[5])) : null;
                $nota->tercerparcial = null;
                $nota->recuperacion = is_numeric($fila[7]) ? max(0, min(100, $fila[7])) : null;
                $nota->asistencia = is_numeric($fila[9]) ? $fila[9] : null;
                $nota->observacion = $fila[10] ?? null;
            }

            try {
                $nota->save();
                Log::info("Notas actualizadas para asignatura_estudiante_id: {$asignaturaEstudiante->id}");
            } catch (\Exception $e) {
                Log::error("Error al guardar nota: " . $e->getMessage());
            }
        }
    }
}

