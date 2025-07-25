<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Promocion>
 */
class PromocionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name,
            'fecha_promocion' => $this->faker->date(),
            'estudiante_id' => $this->faker->numberBetween(1, 10),
            'programaformacion_id' => $this->faker->numberBetween(1, 10),
            'periodo_id' => $this->faker->numberBetween(1, 10),
            'nivel_anterior' => $this->faker->numberBetween(1, 10),
            'nivel_actual' => $this->faker->numberBetween(1, 10),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
