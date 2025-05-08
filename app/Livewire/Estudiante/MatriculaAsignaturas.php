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

class MatriculaAsignaturas extends Component
{
    use WithPagination;

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

     
        $yaMatriculado = AsignaturaEstudiante::where('estudiantes_id', $matricula->id)
            ->where('asignatura_id', $this->asignaturaSeleccionada->id)
            ->where('periodo_id', $this->asignaturaSeleccionada->periodo_id)
            ->exists();

        if ($yaMatriculado) {
            $this->errorMessage = 'Ya estás matriculado en esta asignatura para este período.';
            $this->confirmingMatricula = false;
            return;
        }

        
        $asignaturaAprobada = AsignaturaEstudiante::where('estudiantes_id', $matricula->id)
            ->whereHas('asignaturaDocente.asignatura', function($query) {
                $query->where('codigo', $this->asignaturaSeleccionada->asignatura->codigo);
            })
            ->whereHas('notas', function($query) {
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
                ->whereHas('asignaturaDocente.asignatura', function($query) use ($requisito) {
                    $query->where('codigo', $requisito->requisito->codigo);
                })
                ->whereHas('notas', function($query) {
                    $query->where('observacion', 'Aprobado')
                          ->where('estado', 1);
                })
                ->exists();

            if (!$requisitoAprobado) {
                $this->errorMessage = "No cumples con el requisito previo: {$requisito->requisito->nombre} ({$requisito->requisito->codigo})";
                $this->confirmingMatricula = false;
                return;
            }
        }

        // Crear la matrícula
        AsignaturaEstudiante::create([
            'asignatura_id' => $this->asignaturaSeleccionada->id,
            'estudiantes_id' => $matricula->id,
            'periodo_id' => $this->asignaturaSeleccionada->periodo_id,
            'estado' => 1
        ]);

        $this->successMessage = '¡Matriculado exitosamente en ' . $this->asignaturaSeleccionada->asignatura->nombre . '!';
        $this->confirmingMatricula = false;
    }

    public function resetMessages()
    {
        $this->errorMessage = '';
        $this->successMessage = '';
    }

    public function render()
    {
        $estudiante = Auth::user()->estudiante;
        $matricula = Matricula::where('estudiante_id', $estudiante->id)
            ->where('estado', 1)
            ->first();

        if (!$matricula) {
            return view('livewire.estudiante.matricula-asignaturas', [
                'asignaturas' => [],
                'matricula' => null
            ])->layout('layouts.app');
        }

        $periodoActivo = Periodo::where('estado', 1)->first();

        if (!$periodoActivo) {
            return view('livewire.estudiante.matricula-asignaturas', [
                'asignaturas' => [],
                'matricula' => $matricula
            ])->layout('layouts.app');
        }

        // Consulta optimizada para obtener asignaturas disponibles
        $asignaturas = AsignaturaDocente::with(['asignatura', 'docente', 'periodo', 'seccion'])
            ->where('periodo_id', $periodoActivo->id)
            ->where('estado', 1)
            ->whereHas('asignatura', function($query) use ($matricula) {
                $query->where('programa_formacion_id', $matricula->programaformacion_id)
                      ->where(function($q) {
                          $q->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('codigo', 'like', '%' . $this->search . '%');
                      });
            })
            ->whereDoesntHave('asignaturaEstudiantes', function($query) use ($matricula, $periodoActivo) {
                $query->where('estudiantes_id', $matricula->id)
                      ->where('periodo_id', $periodoActivo->id);
            })
            ->paginate($this->perPage);

        return view('livewire.estudiante.matricula-asignaturas', [
            'asignaturas' => $asignaturas,
            'matricula' => $matricula,
            'periodoActivo' => $periodoActivo
        ])->layout('layouts.app');
    }
}