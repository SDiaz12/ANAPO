<?php

namespace Database\Seeders;

use App\Models\Nota;
use App\Models\Periodo;
use App\Models\ProgramaFormacion;
use App\Models\Promocion;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            ProgramaFormacionTableSeeder::class,
            AsignaturaTableSeeder::class,
            DocenteTableSeeder::class,
            EstudianteTableSeeder::class,
            AsignaturaTableSeeder::class,
            SeccionTableSeeder::class,
            PeriodoTableSeeder::class,
           // MatriculaTableSeeder::class,
            AsignaturaEstudianteTableSeeder::class,
            AsignatutaDocenteTableSeeder::class,
            PromocionTableSeeder::class,
            AsignacionDocentesEstudiantesTableSeeder::class,
            NotaTableSeeder::class,
            CalificacionTableSeeder::class,
            
        ]);
    }
}
