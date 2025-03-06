<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\Docente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AsignaturaDocente>
 */
class AsignaturaDocenteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $id_asignatura = Asignatura::inRandomOrder()->first()-> id;
        $id_docente = Docente::inRandomOrder()->first()-> id;
        return [
            'id_asignatura' => $id_asignatura,
            'id_docente' => $id_docente,
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
