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
        $this->call([
            ProgramaFormacionTableSeeder::class,
            AsignaturaTableSeeder::class,
            UserTableSeeder::class,
            RolSeeder::class,
            PermisoSeeder::class,
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
