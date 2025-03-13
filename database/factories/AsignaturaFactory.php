<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asignatura>
 */
class AsignaturaFactory extends Factory
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
            'descripcion' => $this->faker->sentence(),
            'creditos' => $this->faker->randomNumber(2),
            'horas' => $this->faker->randomNumber(2),
            'programa_formacion_id' => $this->faker->numberBetween(1, 10),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
