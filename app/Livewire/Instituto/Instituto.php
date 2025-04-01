<?php

namespace App\Livewire\Instituto;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Instituto as InstitutoModel; 

class Instituto extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = 0;
    public $search, $instituto_id, $codigo, $nombre, $estado;
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
        $this->instituto_id = null;
        $this->nombre = '';
        $this->codigo = '';
        $this->estado = 1;
    }
    public function store()
    {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'required|string|max:50|unique:asignaturas,codigo,' . $this->instituto_id,
        ]);

        $asignatura = InstitutoModel::updateOrCreate(
            ['id' => $this->instituto_id],
            [
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'estado' => $this->estado,
            ]
        );

        session()->flash(
            'message',
            $this->instituto_id ? 'Instituto actualizado correctamente!' : 'Instituto creado correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

   
    public function edit($id)
    {
        $instituto = InstitutoModel::findOrFail($id); 
        $this->instituto_id = $id;
        $this->nombre = $instituto->nombre;
        $this->codigo = $instituto->codigo; 
        $this->estado = $instituto->estado;
        $this->openModal();
    }
    
    public function delete()
    {
        if ($this->confirmingDelete) {
            $instituto = InstitutoModel::find($this->IdAEliminar);

            if (!$instituto) {
                session()->flash('error', 'Instituto no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $instituto->forceDelete();
            session()->flash('message', 'Instituto eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    // Método para alternar el estado de la asignatura (activo o inactivo)
    public function toggleEstado($id)
    {
        $instituto = InstitutoModel::findOrFail($id);
        $instituto->estado = !$instituto->estado;
        $instituto->save();
    }

    // Método para cargar más asignaturas
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    
    public function confirmDelete($id)
    {
        $instituto = InstitutoModel::find($id);
    
        if (!$instituto) {
            session()->flash('error', 'Instituto no encontrado.');
            return;
        }
    
        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $instituto->nombre;
        $this->confirmingDelete = true;
    }
    
    public function render()
    {
        $institutosCount = InstitutoModel::count();
        $institutos = InstitutoModel::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

        return view('livewire.instituto.instituto', [
            'institutos' => $institutos,
            'institutosCount' => $institutosCount,
        ])->layout('layouts.app');
    }
}
