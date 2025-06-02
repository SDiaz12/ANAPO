<?php

namespace App\Livewire\Seccion;

use App\Models\ProgramaFormacion;
use App\Models\Seccion;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithPagination;

class Secciones extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $showDuplicateError = false; // Nueva propiedad para controlar la modal de error
    public $IdAEliminar, $nombreAEliminar;
    public $search, $seccion_id, $nombre, $estado = 1;
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
        $this->showDuplicateError = false; 
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->seccion_id = null;
        $this->nombre = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255|unique:secciones,nombre,'.$this->seccion_id,
        ]);

        try {
          
            $existingSeccion = Seccion::where('nombre', $this->nombre)
                                    ->where('id', '!=', $this->seccion_id)
                                    ->first();

            if ($existingSeccion) {
                $this->showDuplicateError = true;
                return;
            }

            $seccion = Seccion::updateOrCreate(
                ['id' => $this->seccion_id],
                [
                    'nombre' => $this->nombre,
                    'estado' => $this->estado,
                ]
            );

            session()->flash(
                'message',
                $this->seccion_id ? '¡Sección actualizada correctamente!' : '¡Sección creada correctamente!'
            );

            $this->closeModal();
            $this->resetPage(); 
        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
   
    public function edit($id)
    {
        $seccion = Seccion::findOrFail($id);
        $this->seccion_id = $id;
        $this->nombre = $seccion->nombre;
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

    public function toggleEstado($id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->estado = !$seccion->estado;
        $seccion->save();
    }

    public $perPage = 9;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function confirmDelete($id)
    {
        $seccion = Seccion::find($id);
    
        if (!$seccion) {
            session()->flash('error', 'Seccion no encontrada.');
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
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);
            
        return view('livewire.seccion.secciones', [
            'seccionesCount' => $seccionesCount,
            'secciones' => $secciones
        ])->layout('layouts.app');
    }
}