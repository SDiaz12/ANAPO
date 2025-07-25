<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class Usuario extends Component
{
    use WithPagination;

    public $name;
    public $email;
    public $password;
    public $user;
    public $search = '';
    public $selectedRoles = [];
    public $roles;
    public $isOpen = false;
    public $showDeleteModal = false;
    public $confirmingDelete = false;
    public $IdAEliminar;
    public $nombreAEliminar;
    public $profile_photo_path;

    protected $rules = [
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'selectedRoles' => 'required|array',
        'selectedRoles.*' => 'exists:roles,id',
    ];

    protected $listeners = ['userStored' => '$refresh'];

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
                     ->orWhere('email', 'like', '%' . $this->search . '%')
                     ->orderBy('id', 'DESC')
                     ->paginate(10);

        return view('livewire.Usuario.usuario', ['users' => $users])->layout('layouts.app');
    }

    public function create()
    {
        $this->resetInputFields();
        $this->roles = Role::all();
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email' . ($this->user ? ',' . $this->user->id : ''),
            'profile_photo_path' => 'nullable',
            'password' => 'nullable|min:8',
            'selectedRoles' => 'required|array',
            'selectedRoles.*' => 'exists:roles,id',
        ]);

        if ($this->user) {
            $this->update();
        } else {
            $this->createUser();
        }
    }

    private function createUser()
    {
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'profile_photo_path' => $this->profile_photo_path,
            'password' => Hash::make($this->password),
        ]);

        Log::info('Created User:', $user->toArray());
        Log::info('Selected Roles for Creation:', $this->selectedRoles);

        $roleIds = Role::whereIn('id', $this->selectedRoles)->pluck('id')->toArray();
        Log::info('Existing Roles for Creation:', $roleIds);

        $user->syncRoles($roleIds);

        session()->flash('message', 'Usuario creado exitosamente.');
        $this->roles = Role::all();
        $this->reset();
        $this->isOpen = false;
    }

    public function edit(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->profile_photo_path = $user->profile_photo_path;
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
        $this->roles = Role::all();
        $this->isOpen = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'profile_photo_path' => 'nullable',
            'password' => 'nullable|min:8',
            'selectedRoles' => 'required|array',
            'selectedRoles.*' => 'exists:roles,id',
        ]);

        try {
            $user = User::findOrFail($this->user->id);

            Log::info('Selected Roles for Update:', $validatedData['selectedRoles']);

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'profile_photo_path' => $this->profile_photo_path,
                'password' => $this->password ? Hash::make($this->password) : $user->password,
            ]);

            $roleIds = Role::whereIn('id', $validatedData['selectedRoles'])->pluck('id')->toArray();
            Log::info('Existing Roles for Update:', $roleIds);

            $user->syncRoles($roleIds);

            session()->flash('message', 'Usuario actualizado.');
            $this->roles = Role::all();
            $this->reset();
            $this->closeModal();

        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el usuario: ' . $e->getMessage());
            Log::error('Error updating user: ' . $e->getMessage());
        }
    }

    public function delete()
    {
        if ($this->confirmingDelete) {
            $user  = User::find($this->IdAEliminar);

            if (!$user ) {
                session()->flash('error', 'Usuario no encontrado.');
                $this->confirmingDelete = false;
                return;
            }

            $user ->forceDelete();
            session()->flash('message', 'usuario eliminado correctamente!');
            $this->confirmingDelete = false;
        }
    }

    public function confirmDelete($id)
    {
        $user  = User::find($id);

        if (!$user ) {
            session()->flash('error', 'usuario no encontrado.');
            return;
        }

        $this->IdAEliminar = $id;
        $this->nombreAEliminar = $user->name . ' ' . $user ->email;
        $this->confirmingDelete = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->profile_photo_path = '';
        $this->password = '';
        $this->selectedRoles = [];
    }
}
