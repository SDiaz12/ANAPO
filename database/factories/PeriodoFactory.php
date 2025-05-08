<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Periodo>
 */
class PeriodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    
    $periodos = [
        ['nombre' => 'I', 'inicio' => '2025-01-15', 'fin' => '2025-04-14'],
        ['nombre' => 'II', 'inicio' => '2025-05-15', 'fin' => '2025-08-14'],
        ['nombre' => 'III', 'inicio' => '2025-09-15', 'fin' => '2025-12-14'],
    ];

    
    $periodo = $this->faker->randomElement($periodos);

    return [
        'nombre' => $periodo['nombre'],
        'fecha_inicio' => $periodo['inicio'],
        'fecha_fin' => $periodo['fin'],
        'estado' => $this->faker->randomElement([1, 0]),
    ];
}



}
