<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Verifica si el rol 'Estudiantes' ya existe
        $role = Role::firstOrCreate(
            ['name' => 'Estudiantes', 'guard_name' => 'web'],
            ['name' => 'Estudiantes', 'guard_name' => 'web']
        );

        // Encuentra los permisos 'Admin-Participante' y 'Admin-Estudiante' y 'Admin-Historial'
        $permissions = Permission::whereIn('name', ['admin-Participante', 'admin-Estudiante','admin-Historial'])->get();

        // Asigna los permisos al rol
        if ($permissions) {
            $role->givePermissionTo($permissions);
        }
    }
}
