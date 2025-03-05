<?php

namespace Database\Seeders;

use App\Models\AsignaturaDocente;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignatutaDocenteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AsignaturaDocente::factory()->count(10)->create();
    }
}
