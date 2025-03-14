<?php

namespace App\Livewire\Estudiant;

use App\Models\AsignaturaEstudiante;
use App\Models\Estudiante;
use App\Models\Nota;
use App\Models\Periodo;
use Livewire\Attributes\Lazy;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

//#[Lazy()]
class Estudiants extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search, $estudiante_id, $created_at, $codigo, $fecha_ingreso, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia, $sexo, $telefono, $correo, $estado;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = false;
    public $isOpenDatos = false;

    public $clasesEstudiante = [];
    public $clasesHistorial = [];

    public $viewMode = 'table';

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
    public function openDatos()
    {
        $this->isOpenDatos = true;
    }

    public function closeDatos()
    {
        $this->isOpenDatos = false;
    }


    public function historialAsignaturasEstudiante($idEstudiante)
    {
        // Clases con período activo usando la relación "periodo"
        $this->clasesEstudiante = AsignaturaEstudiante::where('estudiantes_id', $idEstudiante)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', true);
            })
            ->get();

        // Clases con períodos históricos (inactivos)
        $this->clasesHistorial = AsignaturaEstudiante::where('estudiantes_id', $idEstudiante)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', false);
            })
            ->get();
    }

    public function infoEstudiante($idEstudiante)
    {
        $estudiante = Estudiante::findOrFail($idEstudiante);
        $this->estudiante_id = $idEstudiante;
        $this->codigo = $estudiante->codigo;
        $this->dni = $estudiante->dni;
        $this->foto = $estudiante->foto;
        $this->nombre = $estudiante->nombre;
        $this->apellido = $estudiante->apellido;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;
        $this->residencia = $estudiante->residencia;
        $this->fecha_ingreso = $estudiante->fecha_ingreso;
        $this->sexo = $estudiante->sexo;
        $this->telefono = $estudiante->telefono;
        $this->correo = $estudiante->correo;
        $this->estado = $estudiante->estado;
        $this->created_at = $estudiante->created_at;
    }

    public function mostrarDatos($idEstudiante)
    {
        // Obtenemos las asignaturas del estudiante
        $this->historialAsignaturasEstudiante($idEstudiante);
        // Obtenemos los datos del estudiante
        $this->infoEstudiante($idEstudiante);
        // Mostramos el modal
        $this->openDatos();
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

    public function toggleEstado($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->estado = !$estudiante->estado;
        $estudiante->save();
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
            Estudiante::updateOrCreate(['id' => $this->estudiante_id], [
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
            'estado' => 1,
        ]);

        session()->flash(
            'message',
            $this->estudiante_id ? 'Estudiante actualizado correctamente!' : 'Estudiante creado correctamente!'
        );

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $this->estudiante_id = $id;
        $this->codigo = $estudiante->codigo;
        $this->dni = $estudiante->dni;
        $this->foto = $estudiante->foto;
        $this->nombre = $estudiante->nombre;
        $this->apellido = $estudiante->apellido;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;
        $this->residencia = $estudiante->residencia;
        $this->fecha_ingreso = $estudiante->fecha_ingreso;
        $this->sexo = $estudiante->sexo;
        $this->telefono = $estudiante->telefono;
        $this->correo = $estudiante->correo;
        $this->estado = $estudiante->estado;

        $this->openModal();
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $estudiante = Estudiante::find($this->IdAEliminar);

            if (!$estudiante) {
                session()->flash('error', 'Estudiante no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $estudiante->forceDelete();
            session()->flash('message', 'Estudiante eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $estudiante = Estudiante::find($id);

        if (!$estudiante) {
            session()->flash('error', 'Estudiante no encontrado.');
            return;
        }
        if ($estudiante->asignaturas()->exists()) {
            session()->flash('error', 'No se puede eliminar al estudiante:  ' .$estudiante->nombre .' ' .$estudiante->apellido .', porque está enlazado a una o más clases actualmente.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $estudiante->nombre;
        $this->confirmingDelete = true;
    }
    
    public $perPage = 10;
    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }
    public function render()
    {
        $estudiantesCount = Estudiante::count();
        $estudiantes = Estudiante::where('nombre', 'like', '%' . $this->search . '%')
        ->orWhere('apellido', 'like', '%' . $this->search . '%')
        ->orWhere('dni', 'like', '%' . $this->search . '%')
        ->orWhere('codigo', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'DESC')
        ->paginate($this->perPage);

        return view('livewire.estudiant.estudiants', [
            'estudiantes' => $estudiantes,
            'estudiantesCount' => $estudiantesCount,
            ])->layout('layouts.app');
    }
}
