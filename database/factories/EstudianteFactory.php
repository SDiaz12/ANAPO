<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudiante>
 */
class EstudianteFactory extends Factory
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
            'dni' => $this->faker->unique()->randomNumber(8),
            'foto' => $this->faker->imageUrl(),
            'nombre' => $this->faker->name,
            'apellido' => $this->faker->lastName,
            'correo' => $this->faker->unique()->safeEmail,
            'telefono' => $this->faker->phoneNumber,
            'residencia' => $this->faker->address,
            'fecha_nacimiento' => $this->faker->date(),
            'sexo' => $this->faker->randomElement(['M', 'F']),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
