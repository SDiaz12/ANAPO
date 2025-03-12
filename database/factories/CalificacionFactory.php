<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Calificacion>
 */
class CalificacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'promedio' => $this->faker->randomFloat(2, 0, 5),
            'observacion' => $this->faker->text(),
            'estudiante_id' => $this->faker->numberBetween(1, 10),
            'periodo_id' => $this->faker->numberBetween(1, 10),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
