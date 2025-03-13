<?php

namespace Database\Seeders;

use App\Models\AsignaturaEstudiante;
use Illuminate\Database\Seeder;

class AsignaturaEstudianteSeeder extends Seeder
{
    public function run()
    {
        // Crear 50 asignaturas estudiantes aleatorias
        AsignaturaEstudiante::factory()->count(50)->create();
    }
}
