<?php

namespace Database\Factories;
use App\Models\AsignaturaEstudiante;
use App\Models\AsignaturaDocente;
use App\Models\Nota;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nota>
 */
class NotaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'asignatura_estudiante_id' => AsignaturaEstudiante::inRandomOrder()->first()->id,
            'primerparcial' => $this->faker->numberBetween(0, 10),
            'segundoparcial' => $this->faker->numberBetween(0, 10),
            'tercerparcial' => $this->faker->numberBetween(0, 10),
            'asistencia' => $this->faker->randomElement(['Presente', 'Ausente']),
            'recuperacion' =>$this->faker->numberBetween(0, 10),
            'observacion' =>  $this->faker->randomElement(['Aprobado', 'Reprobado']),
            'estado' => $this->faker->randomElement([0, 1]),
            
        ];
    }
}
