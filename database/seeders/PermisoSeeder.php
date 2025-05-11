<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'admin-admin-rol',
            'admin-admin-instituto',
            'docente-admin-notas',
            'admin-admin-principal',
            'estudiante-admin-dashboard',
            'estudiante-admin-notasestudiante',
            'docente-admin-editarnotas',
            'admin-admin-docente',
            'admin-admin-estudiante',
            'estudiante-admin-userestudiante',
            'admin-admin-asignatura',
            'admin-admin-seccion',
            'admin-admin-periodo',
            'admin-admin-asignaturaDocente',
            'admin-admin-asignaturaestudiante',
            'admin-admin-matricula',
            'admin-admin-promocion',
            'admin-admin-programas',
            'docente-admin-actualizarnotas',
            'docente-admin-importarnotas',
            'admin-admin-notasedit',
            'admin-admin-users',
            'admin-admin-notas',
            'admin-admin-asignaturaEstudiante',
            'admin-admin-users',
            'ver-dashboard-admin',
            'ver-dashboard-docente',
            'ver-dashboard-estudiante',
            'admin-admin-mantenimiento',
            'estudiante-admin-matricularasignatura',
            'estudiante-admin-descargarhistorial',
            'admin-admin-periodo'

         ];
         
         foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
         }
    }
}