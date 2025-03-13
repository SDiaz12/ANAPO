<?php

namespace App\Livewire\Nota;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use App\Models\AsignaturaDocente;
use Livewire\Component;
use Livewire\WithPagination;

class Notas extends Component
{
    use WithPagination;

    public $isOpen = false;
    public $viewMode = 'table'; // Vista por defecto: tabla
    public $selectedEstudiante;
    public $primerparcial, $segundoparcial, $tercerparcial, $asistencia, $recuperacion, $observacion, $estado;
    public $asignatura_estudiante_id;
    public $search;

    // Método que se ejecuta cuando se inicializa el componente
    public function mount()
    {
        $this->asignaturasEstudiantes = $this->getAsignaturasEstudiantes();
    }

    // Obtener las asignaturas según el rol del usuario
    public function getAsignaturasEstudiantes()
    {
        if (auth()->user()->hasRole('root')) {
            // Si es root (admin), carga todas las asignaturas y estudiantes
            return AsignaturaEstudiante::with('asignatura', 'estudiante')
                ->orderBy('asignatura_id')
                ->paginate(10);
        } else {
            // Si es docente, solo carga las asignaturas que están asignadas a él
            return AsignaturaEstudiante::with('asignatura', 'estudiante')
                ->whereHas('asignaturaDocente', function ($query) {
                    $query->where('docente_id', auth()->user()->id);
                })
                ->orderBy('asignatura_id')
                ->paginate(10);
        }
    }

    // Cambiar la vista entre tabla y tarjetas
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    // Cargar los datos de las notas de un estudiante
    public function loadNota($asignatura_estudiante_id)
    {
        $nota = Nota::where('asignatura_estudiante_id', $asignatura_estudiante_id)->first();

        if ($nota) {
            $this->selectedEstudiante = $nota->asignaturaEstudiante->estudiante->nombre;
            $this->primerparcial = $nota->primerparcial;
            $this->segundoparcial = $nota->segundoparcial;
            $this->tercerparcial = $nota->tercerparcial;
            $this->asistencia = $nota->asistencia;
            $this->recuperacion = $nota->recuperacion;
            $this->observacion = $nota->observacion;
            $this->estado = $nota->estado;
            $this->asignatura_estudiante_id = $nota->asignatura_estudiante_id;
        } else {
            $this->resetNotaFields();
        }

        $this->isOpen = true;
    }

    // Limpiar los campos de las notas
    public function resetNotaFields()
    {
        $this->primerparcial = null;
        $this->segundoparcial = null;
        $this->tercerparcial = null;
        $this->asistencia = '';
        $this->recuperacion = null;
        $this->observacion = '';
        $this->estado = 1; // Por defecto activo
        $this->asignatura_estudiante_id = null;
    }

    // Guardar o actualizar las notas
    public function saveNota()
    {
        $this->validate([
            'primerparcial' => 'required|numeric',
            'segundoparcial' => 'required|numeric',
            'tercerparcial' => 'required|numeric',
            'asistencia' => 'required|string',
            'recuperacion' => 'nullable|numeric',
            'observacion' => 'nullable|string',
            'estado' => 'required|integer',
        ]);

        Nota::updateOrCreate(
            [
                'asignatura_estudiante_id' => $this->asignatura_estudiante_id,
            ],
            [
                'primerparcial' => $this->primerparcial,
                'segundoparcial' => $this->segundoparcial,
                'tercerparcial' => $this->tercerparcial,
                'asistencia' => $this->asistencia,
                'recuperacion' => $this->recuperacion,
                'observacion' => $this->observacion,
                'estado' => $this->estado,
                'created_by' => auth()->id(),
            ]
        );

        session()->flash('message', 'Nota guardada correctamente.');
        $this->closeModal();
    }

    // Cerrar el modal de edición
    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetNotaFields();
    }

    public function render()
    {
        $asignaturasEstudiantes = $this->getAsignaturasEstudiantes();

        return view('livewire.nota.notas', [
            'asignaturasEstudiantes' => $asignaturasEstudiantes,
        ]);
    }
}
