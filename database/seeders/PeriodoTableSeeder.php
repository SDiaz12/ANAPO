<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $periodos = [
        ['nombre' => 'I', 'fecha_inicio' => '2025-01-15', 'fecha_fin' => '2025-04-14'],
        ['nombre' => 'II', 'fecha_inicio' => '2025-05-15', 'fecha_fin' => '2025-08-14'],
        ['nombre' => 'III', 'fecha_inicio' => '2025-09-15', 'fecha_fin' => '2025-12-14'],
    ];

    foreach ($periodos as $periodo) {
        Periodo::create([
            'nombre' => $periodo['nombre'],
            'fecha_inicio' => $periodo['fecha_inicio'],
            'fecha_fin' => $periodo['fecha_fin'],
            'estado' => 1,
        ]);
    }
}

}
