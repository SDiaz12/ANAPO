<?php

namespace App\Imports;

use App\Models\AsignaturaEstudiante;
use App\Models\Nota;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
class ActualizarNotas implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
       
        Log::info('Procesando fila:', $row);

        
        $asignaturaEstudianteId = $row['no']; 
        $asignaturaEstudiante = AsignaturaEstudiante::find($asignaturaEstudianteId);

        if ($asignaturaEstudiante) {
           
            $nota = Nota::where('asignatura_estudiante_id', $asignaturaEstudiante->id)->first();

            if ($nota) {
                
                $nota->update([
                    'primerparcial' => $row['primer_parcial'], 
                    'segundoparcial' => $row['segundo_parcial'],
                    'tercerparcial' => $row['tercer_parcial'], 
                    'asistencia' => $row['asistencia'],    
                    'recuperacion' => $row['recuperacion'],   
                    'observacion' => $row['observacion'],   
                ]);
            } else {
              
                return new Nota([
                    'asignatura_estudiante_id' => $asignaturaEstudiante->id,
                    'primerparcial' => $row['primer_parcial'],
                    'segundoparcial' => $row['segundo_parcial'],
                    'tercerparcial' => $row['tercer_parcial'],
                    'asistencia' => $row['asistencia'],
                    'recuperacion' => $row['recuperacion'],
                    'observacion' => $row['observacion'],
                ]);
            }
        }

       
        return null;
    }
}
