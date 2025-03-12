<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nota>
 */
class NotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'estudiante_id' => $this->faker->numberBetween(1, 10),
            'asignatura_id' => $this->faker->numberBetween(1, 10),
            'docente_id' => $this->faker->numberBetween(1, 10),
            'periodo_id' => $this->faker->numberBetween(1, 10),
            'nota' => $this->faker->randomFloat(2, 0, 10),
            'observacion' => $this->faker->text(),
            'estado' => $this->faker->randomElement([1, 0]),

        ];
    }
}
