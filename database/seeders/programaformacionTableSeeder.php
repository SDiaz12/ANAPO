<?php

namespace Database\Seeders;

use App\Models\ProgramaFormacion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class programaformacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProgramaFormacion::factory()->count(50)->create();
    }
}
