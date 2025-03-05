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
            'nombre' => $this->faker->name,
            'descripcion' => $this->faker->text,
            'nivel_formacion' => $this->faker->randomElement(['Tecnico', 'Tecnologo', 'Profesional', 'Especializacion', 'Maestria', 'Doctorado']),
            'estado' => $this->faker->randomElement(['A', 'I']),

        ];
    }
}
