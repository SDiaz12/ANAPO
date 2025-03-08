<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsignacionDocentesEstudiantes>
 */
class AsignacionDocentesEstudiantesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'docente_id' => $this->faker->numberBetween(1, 10),
            'estudiante_id' => $this->faker->numberBetween(1, 10),
            'periodo_id' => $this->faker->numberBetween(1, 10),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
