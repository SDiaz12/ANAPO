<?php

namespace Database\Seeders;

use App\Models\AsignaturaEstudiante;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignaturaEstudianteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AsignaturaEstudiante::factory()->count(10)->create();
    }
}
