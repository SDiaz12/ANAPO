<?php

namespace App\Livewire\Estudiant;

use App\Models\AsignaturaEstudiante;
use App\Models\Estudiante;
use App\Models\Nota;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Estudiants extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search, $estudiante_id, $codigo, $dni, $foto, $nombre, $apellido, $fecha_nacimiento, $residencia,$fecha_ingreso, $sexo, $telefono, $correo, $estado = 1, $created_at;
    
   
    public $user_email, $user_password, $user_password_confirmation;
    public $showPasswordFields = false;

    public $confirmingDelete = false;
    public $IdAEliminar, $nombreAEliminar;
    public $isOpen = false;
    public $isOpenDatos = false;

    public $clasesEstudiante = [];
    public $clasesHistorial = [];
    public $viewMode = 'table';
    public $perPage = 10;

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
        $this->clasesEstudiante = AsignaturaEstudiante::where('estudiantes_id', $idEstudiante)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', true);
            })
            ->get();

        $this->clasesHistorial = AsignaturaEstudiante::where('estudiantes_id', $idEstudiante)
            ->whereHas('periodo', function ($query) {
                $query->where('estado', false);
            })
            ->get();
    }

    public function infoEstudiante($idEstudiante)
    {
        $estudiante = Estudiante::with('user')->findOrFail($idEstudiante);
        $this->estudiante_id = $idEstudiante;
        $this->codigo = $estudiante->codigo;
        $this->dni = $estudiante->dni;
        $this->foto = $estudiante->foto;
        $this->nombre = $estudiante->nombre;
        $this->apellido = $estudiante->apellido;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;
        $this->residencia = $estudiante->residencia;
        $this->fecha_ingreso= $estudiante->fecha_ingreso;
        $this->sexo = $estudiante->sexo;
        $this->telefono = $estudiante->telefono;
        $this->correo = $estudiante->correo;
        $this->estado = $estudiante->estado;
        $this->created_at = $estudiante->created_at;
        
        if ($estudiante->user) {
            $this->user_email = $estudiante->user->email;
        } else {
            $this->user_email = '';
        }
    }

    public function mostrarDatos($idEstudiante)
    {
        $this->historialAsignaturasEstudiante($idEstudiante);
        $this->infoEstudiante($idEstudiante);
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
        $this->user_email = '';
        $this->user_password = '';
        $this->user_password_confirmation = '';
        $this->showPasswordFields = false;
    }

    public function toggleEstado($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        
        if (!$estudiante->estado) {
            DB::transaction(function () use ($estudiante) {
                $user = User::where('email', $estudiante->correo)->first();
                
                if (!$user) {
                    $user = User::create([
                        'name' => $estudiante->nombre . ' ' . $estudiante->apellido,
                        'email' => $estudiante->correo,
                        'password' => Hash::make('12345678'),
                    ]);
                }
                $user->assignRole('Estudiante');
                $estudiante->user_id = $user->id;
                $estudiante->estado = true;
                $estudiante->save();
            });
        } else {
            $this->confirmDeactivation($id);
        }
    }

    public $confirmingDeactivation = false;
    public $idADesactivar, $nombreADesactivar;

    public function confirmDeactivation($id)
    {
        $estudiante = Estudiante::find($id);
        
        if (!$estudiante) {
            session()->flash('error', 'Estudiante no encontrado.');
            return;
        }

        $this->idADesactivar = $id;
        $this->nombreADesactivar = $estudiante->nombre . ' ' . $estudiante->apellido;
        $this->confirmingDeactivation = true;
    }

    public function deactivate()
    {
        if ($this->confirmingDeactivation) {
            DB::transaction(function () {
                $estudiante = Estudiante::findOrFail($this->idADesactivar);
                $estudiante->estado = false;
                
                if ($estudiante->user) {
                    $estudiante->user->removeRole('Estudiante');
                }
                
                $estudiante->save();
            });

            session()->flash('message', 'Estudiante desactivado correctamente!');
            $this->confirmingDeactivation = false;
        }
    }
    public function store()
    {
        $rules = [
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
            'fecha_nacimiento' => 'required|date',
            'residencia' => 'required|string|max:255',
            'sexo' => 'required',
            'telefono' => 'required',
            'correo' => 'required|email',
        ];

        if (!$this->estudiante_id || $this->user_email != Estudiante::find($this->estudiante_id)->user->email) {
            $rules['user_email'] = 'required|email|unique:users,email,' . ($this->estudiante_id ? Estudiante::find($this->estudiante_id)->user_id : 'NULL');
        }

        if ($this->user_password) {
            $rules['user_password'] = 'min:8|same:user_password_confirmation';
        } elseif (!$this->estudiante_id) {
            $rules['user_password'] = 'required|min:8|same:user_password_confirmation';
        }

        $this->validate($rules);
        
        $fotoPath = $this->foto 
            ? $this->foto->store('estudiantesFotos', 'public')
            : ($this->estudiante_id ? Estudiante::find($this->estudiante_id)->foto : null);

        try {
            DB::transaction(function () use ($fotoPath) {
                $userData = [
                    'name' => $this->nombre . ' ' . $this->apellido,
                    'email' => $this->user_email,
                    'active' => $this->estado,
                ];

                if ($this->user_password) {
                    $userData['password'] = Hash::make($this->user_password);
                }

                if ($this->estudiante_id) {
                    $estudiante = Estudiante::findOrFail($this->estudiante_id);
                    $user = User::updateOrCreate(
                        ['id' => $estudiante->user_id],
                        $userData
                    );
                    if ($user && !$user->roles()->exists()) {
                        $user->assignRole('Estudiante');
                    }
                } else {
                    $user = User::create($userData);
                    $user->assignRole('Estudiante');
                }

                $estudianteData = [
                    'codigo' => $this->codigo,
                    'dni' => $this->dni,
                    'foto' => $fotoPath ? str_replace('public/', 'storage/', $fotoPath) : null,
                    'nombre' => $this->nombre,
                    'apellido' => $this->apellido,
                    'fecha_nacimiento' => $this->fecha_nacimiento,
                    'residencia' => $this->residencia,
                    'fecha_ingreso' => now(),
                    'sexo' => $this->sexo,
                    'telefono' => $this->telefono,
                    'correo' => $this->correo,
                    'estado' => $this->estado,
                    'user_id' => $user->id,
                ];

                $estudiante = Estudiante::updateOrCreate(['id' => $this->estudiante_id], $estudianteData);

                if ($user && !$user->roles()->exists()) {
                    $user->assignRole('Estudiante');
                }
            });

            session()->flash(
                'message',
                $this->estudiante_id 
                    ? 'Estudiante actualizado correctamente!' 
                    : 'Estudiante creado correctamente!'
            );

            $this->closeModal();
            $this->resetInputFields();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al guardar: ' . $e->getMessage());
            \Log::error('Error en Estudiants@store', ['error' => $e->getMessage(), 'trace' => $e->getTrace()]);
        }
    }

    public function edit($id)
    {
        $estudiante = Estudiante::with('user')->findOrFail($id);
        $this->estudiante_id = $id;
        $this->codigo = $estudiante->codigo;
        $this->dni = $estudiante->dni;
        $this->foto = null;
        $this->nombre = $estudiante->nombre;
        $this->apellido = $estudiante->apellido;
        $this->fecha_nacimiento = $estudiante->fecha_nacimiento;
        $this->residencia = $estudiante->residencia;
        $this->fecha_ingreso = $estudiante->fecha_ingreso;
        $this->sexo = $estudiante->sexo;
        $this->telefono = $estudiante->telefono;
        $this->correo = $estudiante->correo;
        $this->estado = $estudiante->estado;
        $this->showPasswordFields = false;
        
        if ($estudiante->user) {
            $this->user_email = $estudiante->user->email;
        }

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

            if ($estudiante->asignaturas()->exists()) {
                session()->flash('error', 'No se puede eliminar al estudiante: ' . $estudiante->nombre . ' ' . $estudiante->apellido . ', porque está enlazado a una o más clases actualmente.');
                $this->confirmingDelete = false;
                return;
            }

            if ($estudiante->user_id) {
                User::find($estudiante->user_id)->delete();
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

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $estudiante->nombre;
        $this->confirmingDelete = true;
    }

    public function placeholder()
    {
        return view('livewire.Placeholder.loader')->layout('layouts.app');
    }

    public function loadMore($suma)
    {
        $this->perPage = $suma;
    }

    public function render()
    {
        $estudiantes = Estudiante::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('apellido', 'like', '%' . $this->search . '%')
            ->orWhere('dni', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate($this->perPage);

        $estudiantesCount = Estudiante::count();
        return view('livewire.estudiant.estudiants', [
            'estudiantes' => $estudiantes,
            'estudiantesCount' => $estudiantesCount,
        ])->layout('layouts.app');
    }
}