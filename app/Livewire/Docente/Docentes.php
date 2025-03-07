<?php

namespace App\Livewire\Docente;

use App\Models\Docente;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;

class Docentes extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search, $docente_id, $codigo, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia, $sexo, $telefono, $correo, $estado;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;

    public $viewMode = 'table';

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }
   public $isOpen = 0;

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
        $this->docente_id = null;
        $this->codigo = '';
        $this->dni = '';
        $this->foto = '';
        $this->nombre = '';
        $this->apellido = '';
        $this->fecha_nacimiento = '';
        $this->residencia = '';
        $this->sexo = '';
        $this->telefono = '';
        $this->correo = '';
        $this->estado = '';
    }

    public function toggleEstado($id)
    {
        $docente = Docente::findOrFail($id);
        $docente->estado = !$docente->estado;
        $docente->save();
    }

    public function store()
    {
        $this->validate([
            'codigo' => [
                'required',
                'string',
                'max:255',
                'unique:docentes,codigo,' . $this->docente_id,
            ],
            'dni' => [
                'required',
                'string',
                'max:255',
                'unique:docentes,dni,' . $this->docente_id,
            ],
            'foto' => 'nullable|image',
            'nombre' => 'required',
            'apellido' => 'required',
            'fecha_nacimiento' => 'required',
            'residencia' => 'required|string|max:255',
            'sexo' => 'required',
            'telefono' => 'required',
            'correo' => 'required',

        ]);
        // Manejo de archivo foto
        if ($this->foto) {
            // Guardamos el archivo en la carpeta dentro de storage/app/public
            $this->foto = $this->foto->store('docentesFotos', 'public');
        } elseif ($this->docente_id) {
            $docente = Docente::findOrFail($this->docente_id);
            $this->foto = $docente->foto;
        }
        Docente::updateOrCreate(['id' => $this->docente_id], [
            'codigo' => $this->codigo,
            'dni' => $this->dni,
            'foto' => $this->foto ? str_replace('public/', 'storage/', $this->foto) : null,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'residencia' => $this->residencia,
            'sexo' => $this->sexo,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'estado' => 1,
        ]);

        session()->flash(
            'message',
            $this->docente_id ? 'Docente actualizado correctamente!' : 'Docente creado correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $docente = Docente::findOrFail($id);
        $this->docente_id = $id;
        $this->codigo = $docente->codigo;
        $this->dni = $docente->dni;
        $this->foto = $docente->foto;
        $this->nombre = $docente->nombre;
        $this->apellido = $docente->apellido;
        $this->fecha_nacimiento = $docente->fecha_nacimiento;
        $this->residencia = $docente->residencia;
        $this->sexo = $docente->sexo;
        $this->telefono = $docente->telefono;
        $this->correo = $docente->correo;
        $this->estado = $docente->estado;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $docente = Docente::find($this->IdAEliminar);

            if (!$docente) {
                session()->flash('error', 'Docente no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $docente->forceDelete();
            session()->flash('message', 'Docente eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $docente = Docente::find($id);

        if (!$docente) {
            session()->flash('error', 'Docente no encontrado.');
            return;
        }
        if ($docente->asignaturadocente()->exists()) {
            session()->flash('error', 'No se puede eliminar al docente:  ' .$docente->nombre .' ' .$docente->apellido .', porque está enlazado a una o más clases actualmente.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $docente->nombre;
        $this->confirmingDelete = true;
    }

    public $perPage = 9;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }
    public function render()
    {
        $docentes = Docente::where('nombre', 'like', '%' . $this->search . '%')
        ->orWhere('apellido', 'like', '%' . $this->search . '%')
        ->orWhere('dni', 'like', '%' . $this->search . '%')
        ->orWhere('codigo', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'DESC')
        ->paginate($this->perPage);
        
        return view('livewire.docente.docentes', ['docentes' => $docentes])->layout('layouts.app');
    }
}
