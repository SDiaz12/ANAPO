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
            'asignatura_id' => $id_asignatura,
            'docente_id' => $id_docente,
            'periodo_id' => $this->faker->numberBetween(1, 10),
            'seccion_id' => $this->faker->numberBetween(1, 10),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
}
