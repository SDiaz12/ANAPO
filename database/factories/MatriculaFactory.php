<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\Estudiante;
use App\Models\Instituto;
use App\Models\ProgramaFormacion;
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
        $id_estudiante = Estudiante::inRandomOrder()->first()->id;
        $id_insituto = Instituto::inRandomOrder()->first()->id;
        $id_programaformacion = ProgramaFormacion::inRandomOrder()->first()->id;
        return [
            'fecha_matricula' => $this->faker->date(),
            'programaformacion_id' => $id_programaformacion,
            'estudiante_id' => $id_estudiante,
            'estado' => 1,
            'motivo_estado' => $this->faker->sentence(),
            'observacion_estado' => $this->faker->sentence(),
            'instituto_id' => $id_insituto,
        ];
    }
}
