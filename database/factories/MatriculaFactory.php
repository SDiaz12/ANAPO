<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\Estudiante;
use App\Models\Seccion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matricula>
 */
class MatriculaFactory extends Factory
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
        $id_seccion = Seccion::inRandomOrde()->first()->id;
        return [
            'fecha_matricula' => $this->faker->date(),
            'id_estudiante' => $id_estudiante,
            'id_asignatura' => $id_asignatura,
            'id_seccion' => $id_seccion,
            'periodo' => $this->faker->sentence(),
            'estado' => $this->faker->randomElement(['A', 'I']),
            'motivo_estado' => $this->faker->sentence(),
            'observacion_estado' => $this->faker->sentence(),
            'instituto' => $this->faker->sentence(),
        ];
    }
}
