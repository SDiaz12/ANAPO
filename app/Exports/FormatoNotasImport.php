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
       
        Log::info('Procesando fila:', $row);

       
        $asignaturaEstudianteId = $row['no']; 

      
        $asignaturaEstudiante = AsignaturaEstudiante::find($asignaturaEstudianteId);

        if ($asignaturaEstudiante) {
            
            return new Nota([
                'asignatura_estudiante_id' =>  $row['no'], 
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
