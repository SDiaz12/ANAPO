<?php

namespace App\Livewire\Docente;

use App\Models\AsignaturaDocente;
use App\Models\Periodo;
use App\Models\Seccion;
use Livewire\Attributes\Lazy;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
class Docentes extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search, $docente_id, $codigo, $fecha_ingreso, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia, $sexo, $telefono, $correo, $estado = 1, $created_at;
    
    // Campos para el usuario
    public $user_email, $user_password, $user_password_confirmation;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = false;
    public $isOpenDatos = false;

    public $clasesDocente = [];
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

    public function historialAsignaturasDocente($idDocente)
    {
        $this->clasesDocente = AsignaturaDocente::where('docente_id', $idDocente)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', true);
            })
            ->get();

        $this->clasesHistorial = AsignaturaDocente::where('docente_id', $idDocente)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', false);
            })
            ->get();
    }

    public function infoDocente($idDocente)
    {
        $docente = Docente::with('user')->findOrFail($idDocente);
        $this->docente_id = $idDocente;
        $this->codigo = $docente->codigo;
        $this->dni = $docente->dni;
        $this->foto = $docente->foto;
        $this->nombre = $docente->nombre;
        $this->apellido = $docente->apellido;
        $this->fecha_nacimiento = $docente->fecha_nacimiento;
        $this->residencia = $docente->residencia;
        $this->fecha_ingreso = $docente->fecha_ingreso;
        $this->sexo = $docente->sexo;
        $this->telefono = $docente->telefono;
        $this->correo = $docente->correo;
        $this->estado = $docente->estado;
        $this->created_at = $docente->created_at;
        
        // Datos del usuario asociado
        if ($docente->user) {
            $this->user_email = $docente->user->email;
        } else {
            $this->user_email = '';
        }
    }

    public function mostrarDatos($idDocente)
    {
        $this->historialAsignaturasDocente($idDocente);
        $this->infoDocente($idDocente);
        $this->openDatos();
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
        $this->fecha_ingreso = '';
        $this->sexo = '';
        $this->telefono = '';
        $this->correo = '';
        $this->estado = '';
        $this->user_email = '';
        $this->user_password = '';
        $this->user_password_confirmation = '';
    }

    public function toggleEstado($id)
    {
        $docente = Docente::findOrFail($id);
        $docente->estado = !$docente->estado;
        $docente->save();
        
        // Si tiene usuario asociado, actualizar su estado también
        if ($docente->user) {
            $docente->user->active = $docente->estado;
            $docente->user->save();
        }
    }

    public function store()
    {
        // Validación de datos del docente
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
            'fecha_nacimiento' => 'required|date',
            'residencia' => 'required|string|max:255',
            'sexo' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
            'user_email' => 'required|email|unique:users,email,' . ($this->docente_id ? Docente::find($this->docente_id)->user_id : 'NULL'),
            'user_password' => $this->docente_id ? 'nullable|min:8|same:user_password_confirmation' : 'required|min:8|same:user_password_confirmation',
        ]);
    
        // Manejo de la foto
        $fotoPath = $this->foto 
            ? $this->foto->store('docentesFotos', 'public')
            : ($this->docente_id ? Docente::find($this->docente_id)->foto : null);
    
        try {
            DB::transaction(function () use ($fotoPath) {
                // Preparar datos del usuario
                $userData = [
                    'name' => $this->nombre . ' ' . $this->apellido,
                    'email' => $this->user_email,
                    'active' => $this->estado,
                ];
    
                // Solo actualizar password si se proporcionó
                if ($this->user_password) {
                    $userData['password'] = Hash::make($this->user_password);
                }
    
                // Gestionar usuario (crear o actualizar)
                if ($this->docente_id) {
                    // Modo edición
                    $docente = Docente::findOrFail($this->docente_id);
                    $user = User::updateOrCreate(
                        ['id' => $docente->user_id],
                        $userData
                    );
    
                    // Asignar rol si no tiene ninguno
                    if ($user && !$user->roles()->exists()) {
                        $user->assignRole('docente');
                    }
                } else {
                    // Modo creación
                    $user = User::create($userData);
                    $user->assignRole('docente'); // Asignar rol automáticamente
                }
    
                // Preparar datos del docente
                $docenteData = [
                    'codigo' => $this->codigo,
                    'dni' => $this->dni,
                    'foto' => $fotoPath ? str_replace('public/', 'storage/', $fotoPath) : null,
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'residencia' => $this->residencia,
                    'fecha_ingreso' => $this->fecha_ingreso ?? now(),
                    'sexo' => $this->sexo,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'estado' => $this->estado,
                    'user_id' => $user->id,
                ];
    
                // Crear o actualizar docente
                Docente::updateOrCreate(['id' => $this->docente_id], $docenteData);
            });
    
            // Mensaje de éxito
            session()->flash(
                'message',
                $this->docente_id 
                    ? 'Docente actualizado correctamente!' 
                    : 'Docente creado correctamente!'
            );
    
            $this->closeModal();
            $this->resetInputFields();
    
        } catch (\Exception $e) {
            // Manejo de errores
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
            \Log::error('Error en Docentes@store', ['error' => $e->getMessage(), 'trace' => $e->getTrace()]);
        }
    }
    public function edit($id)
    {
        $docente = Docente::with('user')->findOrFail($id);
        $this->docente_id = $id;
        $this->codigo = $docente->codigo;
        $this->dni = $docente->dni;
        $this->foto = $docente->foto;
        $this->nombre = $docente->nombre;
        $this->apellido = $docente->apellido;
        $this->fecha_nacimiento = $docente->fecha_nacimiento;
        $this->residencia = $docente->residencia;
        $this->fecha_ingreso = $docente->fecha_ingreso;
        $this->sexo = $docente->sexo;
        $this->telefono = $docente->telefono;
        $this->correo = $docente->correo;
        $this->estado = $docente->estado;
        
        // Datos del usuario
        if ($docente->user) {
            $this->user_email = $docente->user->email;
        }

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

            // Eliminar el usuario asociado si existe
            if ($docente->user_id) {
                User::find($docente->user_id)->delete();
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
        if ($docente->asignaturas()->exists()) {
            session()->flash('error', 'No se puede eliminar al docente:  ' . $docente->nombre . ' ' . $docente->apellido . ', porque está enlazado a una o más clases actualmente.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $docente->nombre;
        $this->confirmingDelete = true;
    }

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }

    public $perPage = 10;
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

        $docentesCount = Docente::count();
        return view('livewire.docente.docentes', [
            'docentes' => $docentes,
            'docentesCount' => $docentesCount,
        ])->layout('layouts.app');
    }
}