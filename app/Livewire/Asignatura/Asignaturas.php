<?php

namespace App\Livewire\Asignatura;

use App\Models\Asignatura;
use App\Models\ProgramaFormacion;
use Livewire\Component;
use Livewire\WithPagination;

class Asignaturas extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $search, $asignatura_id, $nombre, $codigo, $descripcion, $creditos, $programa_formacion_id, $estado;
    public $isOpen = false;
    public $viewMode = 'table';  

    public $tiene_requisitos = false; 
    public $cantidad_requisitos;
    public $requisitoSeleccionado = null;  
    public $inputSearchProgramaFormacion = '';  
    public $searchProgramasFormacion = [];  
   
    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

   
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
    }

    public function resetInputFields()
    {
        $this->asignatura_id = null;
        $this->nombre = '';
        $this->codigo = '';
        $this->descripcion = '';
        $this->creditos = '';
        $this->programa_formacion_id = null;
        $this->estado = 1;
        $this->requisitos = [];
        $this->tiene_requisitos = false;
        $this->cantidad_requisitos = 0;
        $this->inputSearchRequisito = '';
        $this->searchRequisitos = [];
        $this->inputSearchProgramaFormacion = '';
        $this->searchProgramasFormacion = [];
    }
    public $inputSearchRequisito = ''; 
    public $searchRequisitos = [];      
    public $requisitos = [];          

    public function updatedInputSearchRequisito()
    {
        
        if ($this->inputSearchRequisito) {
            $this->searchRequisitos = Asignatura::where('nombre', 'like', '%' . $this->inputSearchRequisito . '%')
                ->orWhere('codigo', 'like', '%' . $this->inputSearchRequisito . '%')
                ->limit(15)
                ->get();

            
        } else {
            $this->searchRequisitos = []; 
        }
    }
    public function mount()
    {
        
        $this->searchRequisitos = Asignatura::all();

        
        for ($i = 0; $i < $this->cantidad_requisitos; $i++) {
            $this->inputSearchRequisito[$i] = '';  
            $this->requisitos[$i] = null; 
        }
    }

    public function selectRequisito($id, $index)
    {
        
        if (!isset($this->requisitos[$index])) {
            $this->requisitos[$index] = null;  
        }

      
        if (!in_array($id, $this->requisitos)) {
            $this->requisitos[$index] = $id;  
        }

       
        $this->inputSearchRequisito = '';
        $this->searchRequisitos = [];
    }


    
    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:asignaturas,codigo,' . $this->asignatura_id,
            'descripcion' => 'nullable|string',
            'creditos' => 'required|integer|min:1',
            'programa_formacion_id' => 'required|integer|exists:programaformaciones,id',
        ]);

        $asignatura = Asignatura::updateOrCreate(
            ['id' => $this->asignatura_id],
            [
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'descripcion' => $this->descripcion,
                'creditos' => $this->creditos,
                'programa_formacion_id' => $this->programa_formacion_id,
                'estado' => $this->estado,
            ]
        );

       
        if (!empty($this->requisitos)) {
            if (count($this->requisitos) > 3) {
                session()->flash('error', 'Una asignatura no puede tener más de 3 requisitos.');
                return;
            }
            $asignatura->requisitos()->sync($this->requisitos);
        }

        session()->flash(
            'message',
            $this->asignatura_id ? 'Asignatura actualizada correctamente!' : 'Asignatura creada correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

   
    public function edit($id)
    {
        $asignatura = Asignatura::with('requisitos', 'programaFormacion')->findOrFail($id); // Asegúrate de cargar el programa de formación
        $this->asignatura_id = $id;
        $this->nombre = $asignatura->nombre;
        $this->codigo = $asignatura->codigo;
        $this->descripcion = $asignatura->descripcion;
        $this->creditos = $asignatura->creditos;
        $this->programa_formacion_id = $asignatura->programa_formacion_id;
        $this->inputSearchProgramaFormacion = $asignatura->programaFormacion->nombre; // Precarga el nombre del programa de formación
        $this->estado = $asignatura->estado;
        $this->requisitos = $asignatura->requisitos->pluck('id')->toArray();
    
        $this->openModal();
    }
    

    // Método para eliminar una asignatura
    public function delete()
    {
        if ($this->confirmingDelete) {
            $asignatura = Asignatura::find($this->IdAEliminar);

            if (!$asignatura) {
                session()->flash('error', 'Asignatura no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $asignatura->forceDelete();
            session()->flash('message', 'Asignatura eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    // Método para alternar el estado de la asignatura (activo o inactivo)
    public function toggleEstado($id)
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->estado = !$asignatura->estado;
        $asignatura->save();
    }

    // Método para cargar más asignaturas
    public $perPage = 9;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    // Método para buscar programas de formación dinámicamente
    public function updatedInputSearchProgramaFormacion()
    {
        
        $this->searchProgramasFormacion = ProgramaFormacion::where('nombre', 'like', '%' . $this->inputSearchProgramaFormacion . '%')
            ->limit(10)
            ->get();
    }

    public function selectProgramaFormacion($id)
    {
        $this->programa_formacion_id = $id;
        $this->inputSearchProgramaFormacion = ProgramaFormacion::find($id)->nombre;
        $this->searchProgramasFormacion = [];
    }

    // Método para buscar requisitos dinámicamente
    public function confirmDelete($id)
    {
        $asignatura = Asignatura::find($id);
    
        if (!$asignatura) {
            session()->flash('error', 'Asignatura no encontrada.');
            return;
        }
    
        if ($asignatura->requisitos()->exists()) {
            session()->flash('error', 'No se puede eliminar la asignatura: ' . $asignatura->nombre . ', porque tiene requisitos asociados.');
            return;
        }
    
        if ($asignatura->docentes()->exists()) {
            session()->flash('error', 'No se puede eliminar la asignatura: ' . $asignatura->nombre . ', porque está vinculada a uno o más docentes.');
            return;
        }
    
        if ($asignatura->notas()->exists()) {
            session()->flash('error', 'No se puede eliminar la asignatura porque está vinculada a una o más notas.');
            return;
        }
    
        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $asignatura->nombre;
        $this->confirmingDelete = true;
    }
    

    // Método para renderizar la vista
    public function render()
    {
        $asignaturas = Asignatura::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

        return view('livewire.asignatura.asignaturas', [
            'asignaturas' => $asignaturas,
        ])->layout('layouts.app');
    }
}
