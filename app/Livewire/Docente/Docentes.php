<?php

namespace App\Livewire\Docente;

use App\Models\Docente;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;


class Docentes extends Component
{
    use WithFileUploads;

    public $search, $docente_id, $codigo, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia, $sexo, $telefono, $correo, $estado;

   public $isOpen = 1;

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
            'estado' => 'required'

        ]);
        // Manejo de archivo foto
        if ($this->foto) {
            // Guardamos el archivo en la carpeta dentro de storage/app/public
            $this->foto = $this->logo->store('docentesFotos', 'public');
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
            'estado' => $this->estado
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

    public $perPage = 0;
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
        ->orderBy('id', 'ASC')
        ->paginate($this->perPage);
        
        return view('livewire.docente.docentes', ['docentes' => $docentes])->layout('layouts.app');
    }
}
