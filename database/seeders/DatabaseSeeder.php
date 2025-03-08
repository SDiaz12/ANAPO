<?php

namespace Database\Seeders;

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
            PermisoSeeder::class,
            RolSeeder::class,
            UserTableSeeder::class,
            AsignaturaTableSeeder::class,
            DocenteTableSeeder::class,
            EstudianteTableSeeder::class,
            AsignaturaTableSeeder::class,
            SeccionTableSeeder::class,
            MatriculaTableSeeder::class,
            
           
        ]);

        
    }
}
