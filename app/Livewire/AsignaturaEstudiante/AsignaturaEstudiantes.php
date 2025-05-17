<?php

namespace App\Livewire\AsignaturaEstudiante;

use App\Models\AsignaturaDocente;
use App\Models\AsignaturaEstudiante;
use App\Models\Periodo;
use App\Models\Matricula;
use Livewire\Component;
use Livewire\WithPagination;

class AsignaturaEstudiantes extends Component
{
    use WithPagination;

    public $search, $asignaturaestudiante_id, $matricula_id, $asignaturadocente_id, $estado = 1;
    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = false;
    public $error;
    public $viewMode = 'table';
    public $periodoSeleccionado;
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }
    public function toggleEstado($id)
    {
        $asignatura = AsignaturaEstudiante::findOrFail($id);
        $asignatura->estado = !$asignatura->estado;
        $asignatura->save();
    }
    public $inputSearchEstudiante = '';
    public $searchEstudiante = [];
    public $inputSearchAsignatura = '';
    public $searchAsignatura = [];

    public $perPage = 10;

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->matricula_id = null;
        $this->inputSearchEstudiante = '';
        $this->searchEstudiante = [];
        $this->asignaturaestudiante_id = null;
        $this->asignaturadocente_id = null;
        $this->inputSearchAsignatura = '';
        $this->searchAsignatura = [];
        $this->estado = 1;
        $this->error = null;
    }

    public function store()
    {
        $this->validate([
            'matricula_id' => 'required|integer|exists:matriculas,id',
            'asignaturadocente_id' => 'required|integer|exists:asignaturadocentes,id',
        ]);

        $periodoActivo = Periodo::where('estado', 1)->first();
        if (!$periodoActivo) {
            $this->error = 'No hay período activo.';
            return;
        }

        $matricula = Matricula::find($this->matricula_id);
        $asignaturaDocente = AsignaturaDocente::with(['asignatura.requisitos'])->find($this->asignaturadocente_id);


        if ($asignaturaDocente->asignatura->programa_formacion_id != $matricula->programaformacion_id) {
            $this->error = 'La asignatura no pertenece al programa de formación del estudiante.';
            return;
        }

        // Verificar requisitos previos
        if ($asignaturaDocente->asignatura->requisitos->isNotEmpty()) {
            foreach ($asignaturaDocente->asignatura->requisitos as $requisito) {
                $requisitoAprobado = AsignaturaEstudiante::where('estudiantes_id', $this->matricula_id)
                    ->whereHas('asignaturaDocente.asignatura', function ($query) use ($requisito) {
                        $query->where('id', $requisito->id);
                    })
                    ->whereHas('notas', function ($query) {
                        $query->where('estado', 1)
                            ->where(function ($q) {

                                $q->whereRaw('(primerparcial + segundoparcial + tercerparcial) / 3 >= 70.0')
                                    ->orWhere('recuperacion', '>=', 70.0);
                            });
                    })
                    ->exists();

                if (!$requisitoAprobado) {
                    $this->error = "El estudiante no ha aprobado el requisito previo: {$requisito->nombre}";
                    return;
                }
            }
        }

        if (!$this->asignaturaestudiante_id) {
            $existente = AsignaturaEstudiante::where('estudiantes_id', $this->matricula_id)
                ->where('asignatura_id', $this->asignaturadocente_id)
                ->where('periodo_id', $periodoActivo->id)
                ->first();

            if ($existente) {
                $this->error = 'El estudiante ya está matriculado en esta asignatura.';
                return;
            }
        }

        AsignaturaEstudiante::updateOrCreate(
            ['id' => $this->asignaturaestudiante_id],
            [
                'estudiantes_id' => $this->matricula_id,
                'asignatura_id' => $this->asignaturadocente_id,
                'periodo_id' => $periodoActivo->id,
                'estado' => $this->estado,
            ]
        );

        session()->flash(
            'message',
            $this->asignaturaestudiante_id
            ? 'Matrícula de asignatura actualizada correctamente!'
            : 'Matrícula de asignatura creada correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function updatedInputSearchEstudiante()
    {
        $this->searchEstudiante = Matricula::with('estudiante')
            ->whereHas('estudiante', function ($q) {
                $q->where('nombre', 'like', '%' . $this->inputSearchEstudiante . '%')
                    ->orWhere('apellido', 'like', '%' . $this->inputSearchEstudiante . '%')
                    ->orWhere('dni', 'like', '%' . $this->inputSearchEstudiante . '%')
                    ->orWhere('codigo', 'like', '%' . $this->inputSearchEstudiante . '%');
            })
            ->where('estado', 1)
            ->limit(10)
            ->get();
    }

    public function selectEstudiante($id)
    {
        $matricula = Matricula::with('estudiante')->find($id);
        $this->matricula_id = $matricula->id;
        $this->inputSearchEstudiante = $matricula->estudiante->nombre . ' ' . $matricula->estudiante->apellido;
        $this->searchEstudiante = [];
    }

    public function updatedInputSearchAsignatura()
    {
        if ($this->matricula_id) {
            $matricula = Matricula::find($this->matricula_id);

            $this->searchAsignatura = AsignaturaDocente::with(['asignatura', 'docente'])
                ->whereHas('asignatura', function ($q) use ($matricula) {
                    $q->where('programa_formacion_id', $matricula->programaformacion_id)
                        ->where(function ($query) {
                            $query->where('nombre', 'like', '%' . $this->inputSearchAsignatura . '%')
                                ->orWhere('codigo', 'like', '%' . $this->inputSearchAsignatura . '%');
                        });
                })
                ->where('estado', 1)
                ->limit(15)
                ->get();
        } else {
            $this->searchAsignatura = [];
            $this->error = 'Primero seleccione un estudiante';
        }
    }

    public function selectAsignatura($id)
    {
        $asignatura = AsignaturaDocente::with('asignatura')->find($id);
        $this->asignaturadocente_id = $asignatura->id;
        $this->inputSearchAsignatura = $asignatura->asignatura->nombre;
        $this->searchAsignatura = [];
    }

    public function edit($id)
    {
        $asignaturaEstudiante = AsignaturaEstudiante::with(['matricula.estudiante', 'asignaturaDocente.asignatura'])->findOrFail($id);

        $this->asignaturaestudiante_id = $asignaturaEstudiante->id;
        $this->matricula_id = $asignaturaEstudiante->estudiantes_id;
        $this->inputSearchEstudiante = $asignaturaEstudiante->matricula->estudiante->nombre . ' ' . $asignaturaEstudiante->matricula->estudiante->apellido;
        $this->asignaturadocente_id = $asignaturaEstudiante->asignatura_id;
        $this->inputSearchAsignatura = $asignaturaEstudiante->asignaturaDocente->asignatura->nombre;
        $this->estado = $asignaturaEstudiante->estado;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $asignaturaEstudiante = AsignaturaEstudiante::find($this->IdAEliminar);

            if (!$asignaturaEstudiante) {
                session()->flash('error', 'Registro no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $asignaturaEstudiante->delete();
            session()->flash('message', 'Matrícula de asignatura eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $asignaturaEstudiante = AsignaturaEstudiante::find($id);

        if (!$asignaturaEstudiante) {
            session()->flash('error', 'Registro no encontrado.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $asignaturaEstudiante->asignaturaDocente->asignatura->nombre;
        $this->confirmingDelete = true;
    }

    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function syncEstadoConPeriodo()
    {

        $periodos = Periodo::select('id', 'estado')->get();

        foreach ($periodos as $periodo) {
            AsignaturaEstudiante::where('periodo_id', $periodo->id)
                ->update(['estado' => $periodo->estado]);
        }
    }
    public function mount()
    {
        $this->syncEstadoConPeriodo();
        $periodoActual = Periodo::where('estado', true)->first();
        $this->periodoSeleccionado = $periodoActual ? $periodoActual->id : null;
    }
    public function render()
    {
        $this->syncEstadoConPeriodo();
        $periodos = Periodo::orderBy('nombre', 'desc')->get();

        $asignaturaEstudiantes = AsignaturaEstudiante::with(['asignaturaDocente.asignatura', 'asignaturaDocente.docente', 'periodo', 'matricula.estudiante'])
            ->when($this->periodoSeleccionado, function ($query) {
                $query->where('periodo_id', $this->periodoSeleccionado);
            })
            ->where(function ($q) {
                $q->whereHas('asignaturaDocente.asignatura', function ($q2) {
                    $q2->where('nombre', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('matricula.estudiante', function ($q2) {
                        $q2->where('nombre', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido', 'like', '%' . $this->search . '%')
                            ->orWhere('codigo', 'like', '%' . $this->search . '%');
                    });
            })
            ->paginate($this->perPage);

        return view('livewire.asignatura-estudiante.asignatura-estudiantes', [
            'asignaturaEstudiantes' => $asignaturaEstudiantes,
            'periodos' => $periodos,
        ])->layout('layouts.app');
    }
}