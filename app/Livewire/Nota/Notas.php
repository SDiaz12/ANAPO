<?php

namespace App\Livewire\Nota;

use App\Models\Nota;
use App\Models\AsignaturaEstudiante;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FormatoNotasExport;

class Notas extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar, $search, $estudiantes, $nota_id;
    public $promedio, $asignatura_estudiante_id, $primerparcial, $segundoparcial, $tercerparcial;
    public $asistencia, $recuperacion, $observacion, $estado, $asignatura_id;
    public $isOpen = false, $viewMode = 'table', $codigo_estudiante, $nombre_estudiante, $apellido_estudiante;
    public $perPage = 9, $notas = [];

   
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    
    
    public function create($codigo_asignatura, $codigo_docente)
    {
        $this->resetInputFields();

        $asignaturaEstudiantes = AsignaturaEstudiante::whereHas('asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente) {
            $query->whereHas('asignatura', function ($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function ($query) use ($codigo_docente) {
                $query->where('codigo', $codigo_docente);
            });
        })
        ->with(['estudiante', 'asignaturadocente.asignatura', 'asignaturadocente.docente'])
        ->get();
        

        if ($asignaturaEstudiantes->isEmpty()) {
            session()->flash('error', 'No hay estudiantes vinculados a esta asignatura y docente.');
            return;
        }

        // Agrupar estudiantes con su asignatura y docente
        $this->estudiantes = $asignaturaEstudiantes->map(function ($asignaturaEstudiante) {
            return [
                'asignatura_estudiante_id' => $asignaturaEstudiante->id,
                'id' => $asignaturaEstudiante->estudiante->id,
                'codigo' => $asignaturaEstudiante->estudiante->codigo,
                'nombre' => $asignaturaEstudiante->estudiante->nombre,
                'apellido' => $asignaturaEstudiante->estudiante->apellido,
                'docente' => $asignaturaEstudiante->asignaturadocente->docente->nombre ?? 'Sin docente',
            ];
        });

        $this->openModal();
        

    }

    
    public function openModal()
    {
        $this->isOpen = true;
    }

       public function closeModal()
    {
        $this->isOpen = false;
    }

    
    public function resetInputFields()
    {
        $this->nota_id = null;
        $this->asignatura_estudiante_id = null;
        $this->primerparcial = '';
        $this->segundoparcial = '';
        $this->tercerparcial = '';
        $this->asistencia = '';
        $this->recuperacion = '';
        $this->promedio = '';
        $this->observacion = '';
        $this->estado = 1;
    }

    // Guardar las notas en la base de datos
    public function store()
    {
       
        $this->validate([
            'notas.*.asignatura_estudiante_id' => 'required|integer|exists:asignatura_estudiantes,id',
            'notas.*.primerparcial' => 'required|numeric',
            'notas.*.segundoparcial' => 'nullable|numeric',
            'notas.*.tercerparcial' => 'nullable|numeric',
            'notas.*.asistencia' => 'nullable|string',
            'notas.*.recuperacion' => 'nullable|numeric',
            'notas.*.observacion' => 'nullable|string',
        ]);

        foreach ($this->notas as $id => $nota) {
            // Asegurarse de que se reciba un ID de asignatura_estudiante
            if (empty($nota['asignatura_estudiante_id'])) {
                session()->flash('error', "Falta el ID de asignatura para el estudiante con ID $id.");
                return;
            }

            // Usar updateOrCreate para guardar o actualizar la nota
            Nota::updateOrCreate(
                ['id' => $this->nota_id],
                [
                    'asignatura_estudiante_id' => $nota['asignatura_estudiante_id'],
                    'primerparcial' => $nota['primerparcial'],
                    'segundoparcial' => $nota['segundoparcial'],
                    'tercerparcial' => $nota['tercerparcial'],
                    'asistencia' => $nota['asistencia'],
                    'recuperacion' => $nota['recuperacion'],
                    'observacion' => $nota['observacion'],
                    'estado' => $this->estado,
                ]
            );
        }

        session()->flash('success', 'Notas guardadas correctamente.');
        $this->closeModal();
        $this->resetInputFields();
    }

    // Eliminar la nota de un estudiante
    public function delete()
    {
        if ($this->confirmingDelete) {
            Nota::find($this->IdAEliminar)?->delete();
            session()->flash('message', 'Nota eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    // Cambiar el estado de la nota (activo/inactivo)
    public function toggleEstado($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->estado = !$nota->estado;
        $nota->save();
    }

    // Cargar más notas por página
    public function loadMore($suma)
    {
        $this->perPage += $suma;
    }

    // Renderizar el componente con las asignaturas y estudiantes
    public function render()
    {
        $asignaturas = AsignaturaEstudiante::with('asignaturadocente.asignatura', 'estudiante')
            ->whereHas('asignaturadocente.asignatura', function ($query) {
                $query->where('estado', 1);
            })
            ->selectRaw('asignatura_id, COUNT(id) as estudiantes_count')
            ->groupBy('asignatura_id')
            ->paginate($this->perPage);

        return view('livewire.nota.notas', [
            'asignaturas' => $asignaturas,
        ])->layout('layouts.app');
    }
}
