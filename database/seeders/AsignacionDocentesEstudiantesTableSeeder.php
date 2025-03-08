<?php

namespace Database\Seeders;

use App\Models\AsignacionDocentesEstudiantes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignacionDocentesEstudiantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AsignacionDocentesEstudiantes::factory()->count(5)->create();
    }
}
