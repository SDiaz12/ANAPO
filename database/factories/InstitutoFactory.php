<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instituto>
 */
class InstitutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->randomNumber(8),
            'nombre' => $this->faker->name,
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
