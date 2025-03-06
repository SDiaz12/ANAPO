<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Asignatura;
use App\Models\Estudiante;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsignaturaEstudiante>
 */
class AsignaturaEstudianteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_asignatura = Asignatura::inRandomOrder()->first()-> id;
        $id_estudiante = Estudiante::inRandomOrder()->first()-> id;
        return [
            'id_asignatura' => $id_asignatura,
            'id_estudiante' => $id_estudiante,
            'nota' => $this->faker->randomFloat(2, 0, 10),
            'observaciones' => $this->faker->text(),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
