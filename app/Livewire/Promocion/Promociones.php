<?php

namespace App\Livewire\Promocion;

use App\Models\Promocion;
use App\Models\Estudiante;
use App\Models\ProgramaFormacion;
use App\Models\Periodo;
use Livewire\Component;
use Livewire\WithPagination;

class Promociones extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $idEliminar, $nombreEliminar;
    public $search, $promocion_id, $nombre, $estudiante_id, $programaformacion_id, $periodo_id, $nivel_anterior, $nivel_actual, $fecha_promocion, $estado;
    public $isOpen = false;
    public $viewMode = 'table';
    public $inputSearchEstudiante = '';
    public $inputSearchProgramaFormacion = '';
    public $inputSearchPeriodo = '';
    public $searchEstudiantes = [];
    public $searchProgramasFormacion = [];
    public $searchPeriodos = [];

   
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    public function resetInputFields()
    {
        $this->promocion_id = null;
        $this->nombre = '';
        $this->estudiante_id = null;
        $this->programaformacion_id = null;
        $this->periodo_id = null;
        $this->nivel_anterior = '';
        $this->nivel_actual = '';
        $this->fecha_promocion = '';
        $this->estado = 1;

        $this->inputSearchEstudiante = '';
        $this->inputSearchProgramaFormacion = '';
        $this->inputSearchPeriodo = '';
        $this->searchEstudiantes = [];
        $this->searchProgramasFormacion = [];
        $this->searchPeriodos = [];
    }
    public function updatedInputSearchPeriodo()
    {
        
        if (!empty($this->inputSearchPeriodo)) {
            $this->searchPeriodos = Periodo::where('nombre', 'like', '%' . $this->inputSearchPeriodo . '%')
                ->limit(10)
                ->get();
        } else {
            $this->searchPeriodos = []; 
        }
    }
    
    public function selectPeriodo($id)
    {
        $periodo = Periodo::find($id);
    
        if ($periodo) {
            $this->periodo_id = $periodo->id;
            $this->inputSearchPeriodo = $periodo->nombre; 
            $this->searchPeriodos = []; 
        }
    }
    public function updatedInputSearchProgramaFormacion()
    {
        
        if (!empty($this->inputSearchProgramaFormacion)) {
            $this->searchProgramasFormacion = ProgramaFormacion::where('nombre', 'like', '%' . $this->inputSearchProgramaFormacion . '%')
                ->limit(10)
                ->get();
        } else {
            $this->searchProgramasFormacion = []; 
        }
    }
    
    public function selectProgramaFormacion($id)
    {
        $programa = ProgramaFormacion::find($id);
    
        if ($programa) {
            $this->programaformacion_id = $programa->id;
            $this->inputSearchProgramaFormacion = $programa->nombre;
            $this->searchProgramasFormacion = []; 
        }
    }
    public function updatedInputSearchEstudiante()
    {
        
        if (!empty($this->inputSearchEstudiante)) {
            $this->searchEstudiantes = Estudiante::where('nombre', 'like', '%' . $this->inputSearchEstudiante . '%')
                ->limit(10)
                ->get();
        } else {
            $this->searchEstudiantes = []; 
        }
    }
    
    public function selectEstudiante($id)
    {
        $estudiante = Estudiante::find($id);
    
        if ($estudiante) {
            $this->estudiante_id = $estudiante->id;
            $this->inputSearchEstudiante = $estudiante->nombre; 
            $this->searchEstudiantes = []; 
        }
    }
            
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function store()
    {
       
        $this->validate([
            'nombre' => 'required|string|max:255',
            'estudiante_id' => 'required|integer|exists:estudiantes,id',
            'programaformacion_id' => 'required|integer|exists:programaformaciones,id',
            'periodo_id' => 'required|integer|exists:periodos,id',
            'nivel_anterior' => 'required|string|max:100',
            'nivel_actual' => 'required|string|max:100',
            'fecha_promocion' => 'required|date',
            'estado' => 'required|integer',
        ]);

        Promocion::updateOrCreate(
            ['id' => $this->promocion_id],
            [
                'nombre' => $this->nombre,
                'estudiante_id' => $this->estudiante_id,
                'programaformacion_id' => $this->programaformacion_id,
                'periodo_id' => $this->periodo_id,
                'nivel_anterior' => $this->nivel_anterior,
                'nivel_actual' => $this->nivel_actual,
                'fecha_promocion' => $this->fecha_promocion,
                'estado' => $this->estado,
            ]
        );

        session()->flash(
            'message',
            $this->promocion_id ? 'Promoción actualizada correctamente!' : 'Promoción creada correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function toggleEstado($id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->estado = !$promocion->estado;
        $promocion->save();
    }

  
    public $perPage = 9;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function edit($id)
    {
        $promocion = Promocion::findOrFail($id);
        $this->promocion_id = $id;
        $this->nombre = $promocion->nombre;
        $this->estudiante_id = $promocion->estudiante_id;
        $this->programaformacion_id = $promocion->programaformacion_id;
        $this->periodo_id = $promocion->periodo_id;
        $this->nivel_anterior = $promocion->nivel_anterior;
        $this->nivel_actual = $promocion->nivel_actual;
        $this->fecha_promocion = $promocion->fecha_promocion;
        $this->estado = $promocion->estado;

        $this->openModal();
    }


    public function confirmDelete($id)
    {
        $promocion = Promocion::find($id);

        if (!$promocion) {
            session()->flash('error', 'Promoción no encontrada.');
            return;
        }

        $this->idEliminar = $id;
        $this->nombreEliminar = $promocion->nombre;
        $this->confirmingDelete = true;
    }

    
    public function delete()
    {
        if ($this->confirmingDelete) {
            Promocion::find($this->idEliminar)->delete();

            session()->flash('message', 'Promoción eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function render()
{
    $promociones = Promocion::query()
        ->where('nombre', 'like', '%' . $this->search . '%')
        ->orWhereHas('estudiante', function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate(9);

    return view('livewire.promocion.promociones', [
        'promociones' => $promociones,
        
    ])->layout('layouts.app');
}

}
