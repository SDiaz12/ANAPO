<?php

namespace App\Livewire\VistaNotasEstudiantes;

use App\Models\AsignaturaEstudiante;
use Livewire\Component;

class VistaNotaEstudiantes extends Component
{
    public $asignaturaEstudianteId;

    // Recibimos el ID de la asignatura del estudiante
    public function mount($asignaturaEstudianteId)
    {
         $this->asignaturaEstudianteId = $asignaturaEstudianteId;
    }

    public function render()
    {
        // Cargar la asignatura del estudiante junto con sus notas y la asignatura relacionada
        $asignaturaEstudiante = AsignaturaEstudiante::with([
            'notas',
            'asignatura',
            'periodo',
            'asignaturaDocente',
            'estudiante',
            'matricula'
        ])
        ->whereHas('estudiante', function ($query) {
            $query->where('estado', '!=', 0);
        })
        ->whereHas('matricula', function ($query) {
            $query->where('estado', '!=', 0); // Asumiendo que el ID de la matrícula es el campo relevante
        })
        ->find($this->asignaturaEstudianteId);

        // Verificar si se encontró la asignatura del estudiante
        if ($asignaturaEstudiante) {
            $notas = $asignaturaEstudiante->notas; // Información de las notas
            $asignatura = $asignaturaEstudiante->asignatura; // Información de la asignatura
            $periodo = $asignaturaEstudiante->periodo; // Información del periodo
            $seccion = $asignaturaEstudiante->asignaturaDocente; // Información de la sección
            $datos = $asignaturaEstudiante->estudiante; // Información del estudiante
            $instituto = $asignaturaEstudiante->estudiante->matricula; // Información del instituto
            $programaformacion = optional($asignaturaEstudiante->estudiante->matricula)->programaFormacion;// Información del programa de formación
            $promedioCalculado = $notas->map(function ($nota) {
                return ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
            })->avg();
            $promedio = round($promedioCalculado); // Calcular el promedio de las notas


            // Calcular el índice global: promedia todas las notas de todas las asignaturas del estudiante
            $globalNotas = AsignaturaEstudiante::with('notas')
                ->where('estudiantes_id', $datos->id)
                ->get()
                ->pluck('notas')
                ->collapse();

            $globalPromedio = $globalNotas->map(function ($nota) {
                return ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
            })->avg();
            $globalIndice = $globalPromedio ? round($globalPromedio) : 0;

            // Calcular el índice del período: filtrar asignaturas del estudiante que pertenezcan al mismo período que la asignatura actual
            $periodNotas = AsignaturaEstudiante::with('notas')
                ->where('estudiantes_id', $datos->id)
                ->whereHas('periodo', function ($q) use ($periodo) {
                    $q->where('id', $periodo->id);
                })
                ->get()
                ->pluck('notas')
                ->collapse();

            $periodPromedio = $periodNotas->map(function ($nota) {
                return ($nota->primerparcial + $nota->segundoparcial + $nota->tercerparcial) / 3;
            })->avg();
            $periodIndice = $periodPromedio ? round($periodPromedio) : 0;
        } else {
            $notas = collect();
            $asignatura = null;
            $periodo = null;
            $seccion = null;
            $datos = null;
            $instituto = null;
            $promedio = 0;
            $globalIndice = 0;
            $periodIndice = 0;
            $programaformacion = null;
        }

        // Pasar los datos a la vista
        return view('livewire.VistaNotasEstudiantes.vista-nota-estudiantes', compact(
            'notas',
            'asignatura',
            'periodo',
            'seccion',
            'datos',
            'promedio',
            'instituto',
            'programaformacion',
            'globalIndice',
            'periodIndice',
            'asignaturaEstudiante'
        ))->layout('layouts.app');
    }
}
