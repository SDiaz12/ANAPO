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
       
        $roleEstudiantes = Role::firstOrCreate(
            ['name' => 'Estudiante', 'guard_name' => 'web'],
            ['name' => 'Estudiante', 'guard_name' => 'web']
        );

        $permisosEstudiantes = Permission::whereIn('name', [
            'estudiante-admin-userestudiante', 
            'estudiante-admin-dashboard',
            'ver-dashboard-estudiante',
            'estudiante-admin-notasestudiante',
            'estudiante-admin-matricularasignatura',
            'estudiante-admin-descargarhistorial',

        ])->get();

        if ($permisosEstudiantes->isNotEmpty()) {
            $roleEstudiantes->givePermissionTo($permisosEstudiantes);
        }

        // 3. Crear rol de Docentes con sus permisos
        $roleDocentes = Role::firstOrCreate(
            ['name' => 'Docente', 'guard_name' => 'web'],
            ['name' => 'Docente', 'guard_name' => 'web']
        );

        $permisosDocentes = Permission::whereIn('name', [
            'docente-admin-editarnotas',
            'docente-admin-notasestudiante',
            'ver-dashboard-docente',
            'docente-admin-notas',
            'docente-admin-importarnotas',
            'docente-admin-actualizarnotas',
            'estudiante-admin-dashboard'

        ])->get();

        if ($permisosDocentes->isNotEmpty()) {
            $roleDocentes->givePermissionTo($permisosDocentes);
        }
    }
}