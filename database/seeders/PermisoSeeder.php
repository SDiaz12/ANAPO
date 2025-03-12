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
            'admin-dashboard',
            'admin-departamento',
            'admin-carrera',
            'admin-persona',
            'admin-rol',
            'admin-asistencia',
            'admin-usuario',
            'admin-Participante',
            'admin-miAsistencia',
            'admin-Historial',
            'admin-Mantenimiento',
            'admin-Estudiante',
         ];
         
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}