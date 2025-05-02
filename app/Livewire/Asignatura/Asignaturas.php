<?php

namespace App\Livewire\Asignatura;

use App\Models\Asignatura;
use App\Models\ProgramaFormacion;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
//#[Lazy()]
class Asignaturas extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $search, $asignatura_id, $nombre, $codigo, $descripcion, $creditos,$horas,$programa_formacion_id, $estado;
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

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
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
        $this->horas = '';
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
            'horas' => 'required|integer|min:1',
            'programa_formacion_id' => 'required|integer|exists:programaformaciones,id',
        ]);

        $asignatura = Asignatura::updateOrCreate(
            ['id' => $this->asignatura_id],
            [
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'descripcion' => $this->descripcion,
                'horas' => $this->horas,
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
        $asignatura = Asignatura::with('requisitos', 'programaFormacion')->findOrFail($id); 
        $this->asignatura_id = $id;
        $this->nombre = $asignatura->nombre;
        $this->codigo = $asignatura->codigo;
        $this->descripcion = $asignatura->descripcion;
        $this->creditos = $asignatura->creditos;
        $this->horas = $asignatura->horas;
        $this->programa_formacion_id = $asignatura->programa_formacion_id;
        $this->inputSearchProgramaFormacion = $asignatura->programaFormacion->nombre; 
        $this->estado = $asignatura->estado;
        $this->requisitos = $asignatura->requisitos->pluck('id')->toArray();
    
        $this->openModal();
    }
    
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

    public function toggleEstado($id)
    {
        $asignatura = Asignatura::findOrFail($id);
        $asignatura->estado = !$asignatura->estado;
        $asignatura->save();
    }

  
    public $perPage = 9;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

   
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
        if ($asignatura->programaFormacion()->exists()) {
            session()->flash('error', 'No se puede eliminar la asignatura: ' . $asignatura->nombre . ', porque está asignado a programa formacion.');
            return;
        }
    
        if ($asignatura->docentes()->exists()) {
            session()->flash('error', 'No se puede eliminar la asignatura: ' . $asignatura->nombre . ', porque está vinculada a uno o más docentes.');
            return;
        }
    
        
    
        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $asignatura->nombre;
        $this->confirmingDelete = true;
    }
    

    
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
