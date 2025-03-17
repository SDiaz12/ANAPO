<?php

namespace App\Livewire\AsignaturaEstudiante;

use App\Models\Asignatura;
use App\Models\AsignaturaEstudiante;
use App\Models\Periodo;
use App\Models\Estudiante;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class AsignaturaEstudiantes extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search, $asignaturaestudiante_id, $estudiantes_id, $asignatura_id, $periodo_id, $estado = 1;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = false;
    public $isOpenDatos = false;
    public $error;
    public $inputSearchEstudiante = '';
    public $searchEstudiante = [];

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
        $this->estudiantes_id = null;
        $this->inputSearchEstudiante = '';
        $this->searchEstudiante = [];
        $this->asignaturaestudiante_id = null;
        $this->asignatura_id = null;
        $this->estado = '';
    }

    public function store()
    {
        $this->validate([
            'estudiantes_id' => 'required|integer|exists:estudiantes,id',
            'asignatura_id'  => 'required',
        ]);
    
        // Obtenemos el período activo
        $periodoActivo = Periodo::where('estado', 1)->first();
    
        if (!$periodoActivo) {
            $this->error = 'No hay período activo.';
            return;
        }
    
        // Verificamos si ya existe una matrícula para el estudiante en esa asignatura y período (en creación)
        if (!$this->asignaturaestudiante_id) {
            $matriculaExistente = AsignaturaEstudiante::where('estudiantes_id', $this->estudiantes_id)
                ->where('asignatura_id', $this->asignatura_id)
                ->where('periodo_id', $periodoActivo->id)
                ->first();
            if ($matriculaExistente) {
                $this->error = 'La asignatura ya está matriculada para este estudiante.';
                return;
            }
        }
    
        // Si $this->estado está vacío, asignamos 1 por defecto
        $estado = ($this->estado === '' || is_null($this->estado)) ? 1 : $this->estado;
    
        // Procedemos a crear o actualizar la matrícula
        AsignaturaEstudiante::updateOrCreate(
            ['id' => $this->asignaturaestudiante_id],
            [
                'estudiantes_id' => $this->estudiantes_id,
                'asignatura_id'  => $this->asignatura_id,
                'periodo_id'     => $periodoActivo->id,
                'estado'         => $estado,
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
        $this->searchEstudiante = Estudiante::where('nombre', 'like', '%' . $this->inputSearchEstudiante . '%')
            ->whereHas('matricula', function($query) {
                $query->whereNotNull('programaformacion_id');
            })
            ->whereHas('matricula', function($query) {
                $query->where('estado', 1);
            })
            ->where('estado', 1)

            ->limit(10)
            ->get();
    }

    public function selectEstudiante($id)
    {
        $this->estudiantes_id = $id;
        $this->inputSearchEstudiante = Estudiante::find($id)->nombre . ' ' . Estudiante::find($id)->apellido;
        $this->searchEstudiante = [];
    }

    public function edit($id)
    {
        $asiganturaestudiante = AsignaturaEstudiante::findOrFail($id);
        $this->asignaturaestudiante_id = $asiganturaestudiante->id;
        $this->estudiantes_id = $asiganturaestudiante->estudiante->id;
        $this->inputSearchEstudiante = $asiganturaestudiante->estudiante->nombre . ' ' . $asiganturaestudiante->estudiante->apellido;
        $this->asignatura_id = $asiganturaestudiante->asignatura_id;
        $this->estado = $asiganturaestudiante->estado;
        $this->openModal();
    }


    public $inputSearchAsignatura = '';
    public $searchAsignatura = [];
    public $requisitos = [];

    public function updatedinputSearchAsignatura()
    {

        if ($this->inputSearchAsignatura) {
            $this->searchAsignatura = Asignatura::where('nombre', 'like', '%' . $this->inputSearchAsignatura . '%')
                ->orWhere('codigo', 'like', '%' . $this->inputSearchAsignatura . '%')
                ->limit(15)
                ->get();


        } else {
            $this->searchAsignatura = [];
        }
    }

    public function mount()
    {
        $this->searchAsignatura = Asignatura::all();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $asiganturaestudiante = AsignaturaEstudiante::find($this->IdAEliminar);

            if (!$asiganturaestudiante) {
                session()->flash('error', 'Docente no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $asiganturaestudiante->forceDelete();
            session()->flash('message', 'Matricula de asignatura eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $asiganturaestudiante = AsignaturaEstudiante::find($id);

        if (!$asiganturaestudiante) {
            session()->flash('error', 'Docente no encontrado.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $asiganturaestudiante->asignatura->nombre;
        $this->confirmingDelete = true;
    }
    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function render()
    {
        $asignaturaestudiantes = AsignaturaEstudiante::with('estudiante', 'asignatura', 'periodo')
            ->where(function ($query) {
                $query->whereHas('estudiante', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('apellido', 'like', '%' . $this->search . '%');
                })->orWhereHas('asignatura', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('id', 'DESC')
            ->paginate(10);

            $asignaturas = Asignatura::whereHas('asignaturaEstudiantesA', function ($q) {
                $q->whereHas('periodo', function ($q2) {
                    $q2->where('estado', 1);
                });
            })->where('estado', 1)->get();

        $asignaturaestudianteCount = AsignaturaEstudiante::count();

        return view('livewire.asignatura-estudiante.asignatura-estudiantes', [
            'asignaturaestudiantes' => $asignaturaestudiantes,
            'asignaturaestudianteCount' => $asignaturaestudianteCount,
            'asignaturas' => $asignaturas,
        ])->layout('layouts.app');
    }
}
