<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class SetRoleController extends Controller
{
    //
    public function SetRole(Request $request, $role_id)
    {

        $request->merge(['role_id' => $role_id]); // Añade el parámetro al request para validarlo

        $request->validate([
            'role_id' => ['required', 'exists:roles,id']
        ]);



        $user = Auth::user();
        $roleToChange = Role::findOrFail($request->role_id);

        // Verificar si el usuario tiene el rol antes de cambiarlo
        if (!$user->hasRole($roleToChange->name)) {
            // Si el usuario no tiene el rol, redirigir a la ruta 'inicio' con un mensaje de error
            session()->flash(
                'error',
                'No tienes permiso para cambiar a este rol. :('
            );
            return redirect()->route('dashboard')->with('error', 'No tienes permiso para cambiar a este rol.');
        }


        // Asignar el nuevo rol si pasa la validación
        $user->active_role_id = $request->role_id;
        $user->save();

        session()->flash(
                'message',
             'Rol cambiado a ' . $roleToChange->name
            );

        // Redirigir a la ruta 'inicio' con un mensaje de éxito
        return redirect()->route('dashboard')->with('success', 'Rol cambiado a '. $roleToChange->name);
    }
}
