<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    public function run()
    {
        // 1. Crear o actualizar permisos necesarios
        Permission::firstOrCreate(['name' => 'admin-Notas', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'admin-Matricula', 'guard_name' => 'web']);

        // 2. Crear rol de Estudiantes (como ya tenías)
        $roleEstudiantes = Role::firstOrCreate(
            ['name' => 'Estudiantes', 'guard_name' => 'web'],
            ['name' => 'Estudiantes', 'guard_name' => 'web']
        );

        $permisosEstudiantes = Permission::whereIn('name', [
            'admin-Participante', 
            'admin-Estudiante',
            'admin-Historial'
        ])->get();

        if ($permisosEstudiantes->isNotEmpty()) {
            $roleEstudiantes->givePermissionTo($permisosEstudiantes);
        }

        // 3. Crear rol de Docentes con sus permisos
        $roleDocentes = Role::firstOrCreate(
            ['name' => 'docente', 'guard_name' => 'web'],
            ['name' => 'docente', 'guard_name' => 'web']
        );

        $permisosDocentes = Permission::whereIn('name', [
            'admin-Notas',
            'admin-Matricula'
        ])->get();

        if ($permisosDocentes->isNotEmpty()) {
            $roleDocentes->givePermissionTo($permisosDocentes);
        }
    }
}