<?php

namespace App\Livewire\Instituto;

use Livewire\Component;
use Livewire\WithPagination;

class Instituto extends Component
{
    use WithPagination;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
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

        $asignatura = Instituto::updateOrCreate(
            ['id' => $this->instituto_id],
            [
                'nombre' => $this->nombre,
                'codigo' => $this->codigo,
                'estado' => $this->estado,
            ]
        );

        session()->flash(
            'message',
            $this->instituto_id ? 'Instituto actualizada correctamente!' : 'Instituto creado correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

   
    public function edit($id)
    {
        $instituto = Instituto::with('requisitos', 'programaFormacion')->findOrFail($id); 
        $this->instituto_id = $id;
        $this->nombre = $instituto->nombre;
        $this->codigo = $instituto->codigo; 
        $this->estado = $instituto->estado;
        $this->openModal();
    }
    
    public function delete()
    {
        if ($this->confirmingDelete) {
            $instituto = Instituto::find($this->IdAEliminar);

            if (!$instituto) {
                session()->flash('error', 'Instituto no encontrada.');
                $this->confirmingDelete = false;
                return;
            }

            $instituto->forceDelete();
            session()->flash('message', 'Instituto eliminada correctamente!');
            $this->confirmingDelete = false;
        }
    }

    // Método para alternar el estado de la asignatura (activo o inactivo)
    public function toggleEstado($id)
    {
        $instituto = Instituto::findOrFail($id);
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
        $instituto = Instituto::find($id);
    
        if (!$instituto) {
            session()->flash('error', 'Instituto no encontrada.');
            return;
        }
    
        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $instituto->nombre;
        $this->confirmingDelete = true;
    }
    
    public function render()
    {
        $institutos = Instituto::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

        return view('livewire.instituto.instituto', [
            'institutos' => $institutos,
        ]);
    }
}
