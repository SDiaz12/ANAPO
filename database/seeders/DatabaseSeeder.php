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
         
            PermisoSeeder::class,
            RolSeeder::class,
            UserTableSeeder::class,
            PeriodoTableSeeder::class,       
            
            
        ]);

        
    }
}
