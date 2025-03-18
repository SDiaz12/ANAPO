<?php

namespace App\Livewire\Estudiant;

use App\Models\Estudiante;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
//#[Lazy()]
class EstudiantePorUsuario extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search, $user_id, $estudiante_id, $created_at, $codigo, $fecha_ingreso, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia, $sexo, $telefono, $correo, $estado = 1;

    public $isOpen = false;

    public function closeModal()
    {
        redirect('dashboard');
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->estudiante_id = null;
        $this->codigo = '';
        $this->dni = '';
        $this->foto = '';
        $this->nombre = '';
        $this->apellido = '';
        $this->fecha_nacimiento = '';
        $this->residencia = '';
        $this->fecha_ingreso = '';
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
                'unique:estudiantes,codigo,' . $this->estudiante_id,
            ],
            'dni' => [
                'required',
                'string',
                'max:255',
                'unique:estudiantes,dni,' . $this->estudiante_id,
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
            $this->foto = $this->foto->store('estudiantesFotos', 'public');
        } elseif ($this->estudiante_id) {
            $estudiante = Estudiante::findOrFail($this->estudiante_id);
            $this->foto = $estudiante->foto;
        }
            $this->user_id = Auth::user()->id;
            Estudiante::updateOrCreate(['id' => $this->estudiante_id], [
            'user_id' => $this->user_id,
            'codigo' => $this->codigo,
            'dni' => $this->dni,
            'foto' => $this->foto ? str_replace('public/', 'storage/', $this->foto) : null,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'residencia' => $this->residencia,
            'fecha_ingreso' => now(),
            'sexo' => $this->sexo,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
            'estado'         => $this->estado,
        ]);

        session()->flash(
            'message',
            $this->estudiante_id ? 'Estudiante actualizado correctamente!' : 'Estudiante creado correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }
   
    public function render()
    {
        return view('livewire.estudiant.estudiante-por-usuario')->layout('layouts.app');
    }
}
