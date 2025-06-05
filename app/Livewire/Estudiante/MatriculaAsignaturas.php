<?php

namespace App\Livewire\Estudiante;

use App\Models\AsignaturaDocente;
use App\Models\AsignaturaEstudiante;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Periodo;
use App\Models\AsignaturaRequisito;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon; 
class MatriculaAsignaturas extends Component
{
    use WithPagination;
    public $matriculadas = [];
    public $search = '';
    public $perPage = 12;
    public $confirmingMatricula = false;
    public $asignaturaSeleccionada;
    public $errorMessage = '';
    public $successMessage = '';

    public function mount()
    {
        if (!Auth::check() || !Auth::user()->estudiante) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }
    }

    public function loadMore()
    {
        $this->perPage += 12;
    }

    public function confirmMatricula($asignaturaId)
    {
        $this->asignaturaSeleccionada = AsignaturaDocente::with(['asignatura', 'docente', 'periodo', 'seccion'])
            ->find($asignaturaId);

        $this->confirmingMatricula = true;
        $this->errorMessage = '';
    }

    public function matricular()
    {
        $this->resetMessages();

        $estudiante = Auth::user()->estudiante;
        $matricula = Matricula::where('estudiante_id', $estudiante->id)
            ->where('estado', 1)
            ->first();

        if (!$matricula) {
            $this->errorMessage = 'No tienes una matrícula activa.';
            $this->confirmingMatricula = false;
            return;
        }
        
        $yaMatriculadoMismaMateria = AsignaturaEstudiante::where('estudiantes_id', $matricula->id)
            ->whereHas('asignaturaDocente.asignatura', function($query) {
                $query->where('codigo', $this->asignaturaSeleccionada->asignatura->codigo);
            })
            ->where('periodo_id', $this->asignaturaSeleccionada->periodo_id)
            ->exists();

        if ($yaMatriculadoMismaMateria) {
            $this->errorMessage = 'Ya estás matriculado en esta materia ('.$this->asignaturaSeleccionada->asignatura->codigo.') para este período.';
            $this->confirmingMatricula = false;
            return;
        }

        $yaMatriculadoMismoDocente = AsignaturaEstudiante::where('estudiantes_id', $matricula->id)
            ->whereHas('asignaturaDocente', function($query) {
                $query->where('docente_id', $this->asignaturaSeleccionada->docente_id)
                    ->where('periodo_id', $this->asignaturaSeleccionada->periodo_id)
                    ->where('seccion_id', $this->asignaturaSeleccionada->seccion_id);
            })
            ->exists();

        if ($yaMatriculadoMismoDocente) {
            $this->errorMessage = 'Ya estás matriculado con este docente en la misma sección y período.';
            $this->confirmingMatricula = false;
            return;
        }

        $asignaturaAprobada = AsignaturaEstudiante::where('estudiantes_id', $matricula->id)
            ->whereHas('asignaturaDocente.asignatura', function ($query) {
                $query->where('codigo', $this->asignaturaSeleccionada->asignatura->codigo);
            })
            ->whereHas('notas', function ($query) {
                $query->where('observacion', 'Aprobado')
                    ->where('estado', 1);
            })
            ->exists();

        if ($asignaturaAprobada) {
            $this->errorMessage = 'Ya has aprobado esta asignatura y no puedes matricularte nuevamente.';
            $this->confirmingMatricula = false;
            return;
        }

        $requisitos = AsignaturaRequisito::where('asignatura_id', $this->asignaturaSeleccionada->asignatura->id)
            ->with('requisito')
            ->get();

        foreach ($requisitos as $requisito) {
            $requisitoAprobado = AsignaturaEstudiante::where('estudiantes_id', $matricula->id)
                ->whereHas('asignaturaDocente.asignatura', function ($query) use ($requisito) {
                    $query->where('codigo', $requisito->requisito->codigo);
                })
                ->whereHas('notas', function ($query) {
                    $query->where(function($q) {
                        $q->where('observacion', 'Aprobado')
                        ->orWhere('observacion', 'Excelente')
                        ->orWhere('observacion', 'Muy Bueno')
                        ->orWhere('observacion', 'Bueno');
                    })->where('estado', 1);
                })
                ->exists();

            if (!$requisitoAprobado) {
                $this->errorMessage = "No cumples con el requisito previo: {$requisito->requisito->nombre} ({$requisito->requisito->codigo})";
                $this->confirmingMatricula = false;
                return;
            }
        }

        AsignaturaEstudiante::create([
            'asignatura_id' => $this->asignaturaSeleccionada->id,
            'estudiantes_id' => $matricula->id,
            'periodo_id' => $this->asignaturaSeleccionada->periodo_id,
            'estado' => 1
        ]);

        $this->successMessage = '¡Matriculado exitosamente en ' . $this->asignaturaSeleccionada->asignatura->nombre . '!';
        $this->confirmingMatricula = false;
        
        $this->cargarMatriculadas();
        $this->resetPage();
    }
    public function cargarMatriculadas()
    {
        $estudiante = Auth::user()->estudiante;
        if (!$estudiante) {
            $this->matriculadas = collect();
            return;
        }

        $matricula = Matricula::where('estudiante_id', $estudiante->id)
            ->where('estado', 1)
            ->first();

        if (!$matricula) {
            $this->matriculadas = collect();
            return;
        }

        $periodoActivo = Periodo::where('estado', 1)->first();

        $this->matriculadas = $periodoActivo 
            ? AsignaturaEstudiante::with([
                'asignaturaDocente.asignatura',
                'asignaturaDocente.docente',
                'asignaturaDocente.periodo',
                'asignaturaDocente.seccion',
                'notas'
            ])
            ->where('estudiantes_id', $matricula->id)
            ->whereHas('asignaturaDocente', function($query) use ($periodoActivo) {
                $query->where('periodo_id', $periodoActivo->id);
            })
            ->orderBy('id', 'DESC')
            ->get()
            : collect();
    }
    public function quitarAsignatura($id)
    {
        $this->resetMessages();

        $periodoActivo = Periodo::where('estado', 1)->first();
        if (!$periodoActivo) {
            $this->errorMessage = 'No hay un período activo.';
            return;
        }
        $hoy = now();
       
        $fechaLimiteAdicion = Carbon::parse($periodoActivo->fecha_inicio)->addWeeks(2);
        
        if ($hoy >= $fechaLimiteAdicion) {
            $this->errorMessage = 'El período para quitar asignaturas ha finalizado.';
            return;
        }

        $matriculada = AsignaturaEstudiante::with('notas')->find($id);

        if (!$matriculada) {
            $this->errorMessage = 'La asignatura no existe o no está matriculada.';
            return;
        }

        if ($matriculada->notas) {
            $this->errorMessage = 'No se puede quitar la asignatura porque tiene una nota asignada.';
            return;
        }

        $matriculada->delete();
        $this->successMessage = 'La asignatura ha sido quitada exitosamente.';
        $this->cargarMatriculadas();
        $this->resetPage(); 
    }
    public function resetMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function render()
    {
        $this->cargarMatriculadas();
        $estudiante = Auth::user()->estudiante;

        $matricula = null;
        $periodoActivo = null;
        $asignaturas = collect();
        $hoy = now();
        $mostrarAsignaturas = false;
        $enPeriodoMatricula = false;
        $enPeriodoAdicion = false;

        
        $matricula = Matricula::where('estudiante_id', $estudiante->id)
            ->where('estado', 1)
            ->first();


        $periodoActivo = Periodo::where('estado', 1)->first();

    
        if ($periodoActivo) {
            $fechaInicioPeriodo = Carbon::parse($periodoActivo->fecha_inicio);
            $fechaLimiteAdicion = $fechaInicioPeriodo->copy()->addWeeks(2);
            $mostrarAsignaturas = $hoy < $fechaLimiteAdicion;
            $enPeriodoMatricula = $hoy < $fechaInicioPeriodo;
            $enPeriodoAdicion = $hoy >= $fechaInicioPeriodo && $hoy < $fechaLimiteAdicion;
        }

       
        if ($matricula && $periodoActivo) {
            $asignaturasMatriculadasIds = collect($this->matriculadas)
                ->pluck('asignaturaDocente.id')
                ->filter()
                ->toArray();

            $asignaturasQuery = AsignaturaDocente::with(['asignatura', 'docente', 'periodo', 'seccion'])
                ->where('periodo_id', $periodoActivo->id)
                ->where('estado', 1)
                ->whereHas('asignatura', function ($query) use ($matricula) {
                    $query->where('programa_formacion_id', $matricula->programaformacion_id)
                        ->where(function ($q) {
                            $q->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('codigo', 'like', '%' . $this->search . '%');
                        });
                });

            if ($mostrarAsignaturas) {
                $asignaturasQuery->whereNotIn('id', $asignaturasMatriculadasIds);
            } else {
                $asignaturasQuery->where('id', '<', 0);
            }

            $asignaturas = $asignaturasQuery->paginate($this->perPage);
        }

        return view('livewire.estudiante.matricula-asignaturas', [
            'asignaturas' => $asignaturas,
            'matricula' => $matricula,
            'periodoActivo' => $periodoActivo,
            'matriculadas' => $this->matriculadas,
            'mostrarAsignaturas' => $mostrarAsignaturas,
            'FechaActual' => $hoy,
            'enPeriodoMatricula' => $enPeriodoMatricula,
            'enPeriodoAdicion' => $enPeriodoAdicion,
        ])->layout('layouts.app');
    }
}