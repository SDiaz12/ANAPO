<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProgramaFormacion>
 */
class ProgramaFormacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->name,
            'nombre' => $this->faker->name,
            'fecha_aprobacion' => $this->faker->date(),
            'fecha_final' => $this->faker->date(),
            'hora_finalizacion' => $this->faker->time(),
            'instituto' => $this->faker->name,
            'procentaje_aprobacion' => $this->faker->randomNumber(),
            'tipo_programa' => $this->faker->randomElement(['Tecnico', 'Tecnologo', 'Profesional', 'Especializacion', 'Maestria', 'Doctorado']),
            'estado' => $this->faker->randomElement([1, 0]),

        ];
    }
}
