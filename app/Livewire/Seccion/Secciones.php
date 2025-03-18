<?php

namespace App\Livewire\Seccion;

use App\Models\ProgramaFormacion;
use App\Models\Seccion;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;
//#[Lazy()]
class Secciones extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $search, $seccion_id, $nombre, $programa_formacion_id, $estado = 1;
    public $isOpen = false;
    public $viewMode = 'table';  

    public $inputSearchProgramaFormacion = '';  
    public $searchProgramasFormacion = [];  
   
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
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->seccion_id = null;
        $this->nombre = '';
        $this->programa_formacion_id = null;
        $this->inputSearchProgramaFormacion = '';
        $this->searchProgramasFormacion = [];
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'programa_formacion_id' => 'required|integer|exists:programaformaciones,id',
        ]);

        $seccion = Seccion::updateOrCreate(
            ['id' => $this->seccion_id],
            [
                'nombre' => $this->nombre,
                'programa_formacion_id' => $this->programa_formacion_id,
                'estado'         => $this->estado,
            ]
        );

        session()->flash(
            'message',
            $this->seccion_id ? 'Seccion actualizada correctamente!' : 'Seccion creada correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

   
    public function edit($id)
    {
        $seccion = Seccion::with('programaFormacion')->findOrFail($id); 
        $this->seccion_id = $id;
        $this->nombre = $seccion->nombre;
        $this->programa_formacion_id = $seccion->programa_formacion_id;
        $this->inputSearchProgramaFormacion = $seccion->programaFormacion->nombre; 
        $this->estado = $seccion->estado;
        $this->openModal();
    }
    
    public function delete()
    {
        if ($this->confirmingDelete) {
            $seccion = Seccion::find($this->IdAEliminar);

            if (!$seccion) {
                session()->flash('error', 'Seccion no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $seccion->forceDelete();
            session()->flash('message', 'Seccion eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    // Método para alternar el estado de la seccion (activo o inactivo)
    public function toggleEstado($id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->estado = !$seccion->estado;
        $seccion->save();
    }

    // Método para cargar más seccions
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
        $seccion = Seccion::find($id);
    
        if (!$seccion) {
            session()->flash('error', 'Seccion no encontrada.');
            return;
        }
    
        if ($seccion->programaFormacion()->exists()) {
            session()->flash('error', 'No se puede eliminar la seccion: ' . $seccion->nombre . ', porque enlazada a programas de formacion.');
            return;
        }
    
    
        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $seccion->nombre;
        $this->confirmingDelete = true;
    }
    public function render()
    {
        $seccionesCount = Seccion::count();
        $secciones = Seccion::where('nombre', 'like', '%' . $this->search . '%')
        ->orWhereHas('programaFormacion', function ($q) {
            $q->where('nombre', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'DESC')
        ->paginate($this->perPage);
        return view('livewire.seccion.secciones', [
            'seccionesCount' => $seccionesCount,
            'secciones' => $secciones
        ])->layout('layouts.app');
    }
}
