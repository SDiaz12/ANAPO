<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\Docente;
use App\Models\AsignaturaDocente;
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
        do {
            $id_asignatura = Asignatura::inRandomOrder()->first()->id;
            $id_docente = Docente::inRandomOrder()->first()->id;
    
            // Verificar si ya existe una entrada con la misma combinación de asignatura_id y docente_id
            $exists = AsignaturaDocente::where('asignatura_id', $id_asignatura)
                        ->where('docente_id', $id_docente)
                        ->exists();
        } while ($exists);
    
        return [
            'asignatura_id' => $id_asignatura,
            'docente_id' => $id_docente,
            'periodo_id' => $this->faker->numberBetween(1, 10),
            'seccion_id' => $this->faker->numberBetween(1, 10),
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
    
}
