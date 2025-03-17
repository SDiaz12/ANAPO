<?php

namespace App\Livewire\Nota;

use App\Models\Nota;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AsignaturaEstudiante;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ActualizarNotas;
use App\Exports\ActualizarNotasExport;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;
class EditarNotas extends Component
{
    use WithPagination;
    public $archivo;

    public function actualizarNotas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
    
        
        Excel::import(new ActualizarNotas, $request->file('file'));
    
        return back()->with('success', 'Notas importadas y actualizadas exitosamente.');
    }
    
    public $file;    

    public function exportNotas($codigo_asignatura, $codigo_docente)
    {
        return Excel::download(new ActualizarNotasExport($codigo_asignatura, $codigo_docente), 'notas.xlsx');
    }
    public $notas = [];
    public $isOpen = false;
    public $nota_id, $asignatura_estudiante_id, $primerparcial, $segundoparcial, $tercerparcial, $asistencia;
    public $recuperacion, $observacion, $estado;

    public function toggleEstado($id)
    {
        $nota = Nota::findOrFail($id);
        $nota->estado = !$nota->estado;
        $nota->save();
        session()->flash('message', 'Estado de la nota actualizado correctamente!');
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
        $this->observacion = '';
        $this->estado = 1;
    }

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
    
        foreach ($this->estudiantes as $key => $estudiante) {
            $nota = Nota::find($estudiante['id_nota']);
        
            if ($nota) {
        
                $nota->update([  
                    'asignatura_estudiante_id' => $estudiante['asignatura_estudiante_id'],
                    'primerparcial' => $estudiante['primerparcial'],
                    'segundoparcial' => $estudiante['segundoparcial'],
                    'tercerparcial' => $estudiante['tercerparcial'],
                    'asistencia' => $estudiante['asistencia'],
                    'recuperacion' => $estudiante['recuperacion'],
                    'observacion' => $estudiante['observacion'],
                    
                ]);
            }
        }
        
    
        session()->flash('success', 'Notas actualizadas correctamente.');
        $this->closeModal();
        $this->resetInputFields();
    }
    
    public $perPage = 9, $viewMode = 'table';
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    public function loadMore($suma)
    {
        $this->perPage += $suma;
    }
    public $estudiantes;
    public function mount()
    {
        $this->estudiantes = AsignaturaEstudiante::all(); 
    }
    public function edit($codigo_asignatura, $codigo_docente)
    {
        $notas = Nota::whereHas('asignaturaEstudiante.asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente) {
            $query->whereHas('asignatura', function ($q) use ($codigo_asignatura) {
                $q->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function ($q) use ($codigo_docente) {
                $q->where('codigo', $codigo_docente);
            });
        })->with('asignaturaEstudiante.estudiante')->get();
   
        if ($notas->isEmpty()) {
            session()->flash('error', 'No hay notas registradas para esta asignatura y docente.');
            return;
        }
    
        $this->estudiantes = $notas->map(function ($nota) {
            return [
                'asignatura_estudiante_id' => $nota->asignatura_estudiante_id,
                'id' => $nota->asignaturaEstudiante->estudiante->id,
                'codigo' => $nota->asignaturaEstudiante->estudiante->codigo,
                'nombre' => $nota->asignaturaEstudiante->estudiante->nombre,
                'apellido' => $nota->asignaturaEstudiante->estudiante->apellido,
                'id_nota' => $nota->id,  
                'primerparcial' => $nota->primerparcial,
                'segundoparcial' => $nota->segundoparcial,
                'tercerparcial' => $nota->tercerparcial,
                'asistencia' => $nota->asistencia,
                'recuperacion' => $nota->recuperacion,
                'observacion' => $nota->observacion,
            ];
        })->toArray();
    
        $this->openModal(); 
    }
    


    public function hasNotas($codigo_asignatura, $codigo_docente)
    {
        return Nota::whereHas('asignaturaEstudiante.asignaturadocente', function ($query) use ($codigo_asignatura, $codigo_docente) {
            $query->whereHas('asignatura', function ($query) use ($codigo_asignatura) {
                $query->where('codigo', $codigo_asignatura);
            })
            ->whereHas('docente', function ($query) use ($codigo_docente) {
                $query->where('codigo', $codigo_docente);
            });
        })->exists();
    }
    public function render()
    {
        $asignaturas = AsignaturaEstudiante::with('asignaturadocente.asignatura', 'estudiante')
            ->whereHas('notas') 
            ->whereHas('asignaturadocente.asignatura', function ($query) {
                $query->where('estado', 1); 
            })
            ->selectRaw('asignatura_id, COUNT(id) as estudiantes_count')
            ->groupBy('asignatura_id')
            ->paginate($this->perPage);
    
        return view('livewire.nota.editar-notas', [
            'notas' => $this->notas,
            'asignaturas' => $asignaturas,
        ])->layout('layouts.app');
    }
    
}
