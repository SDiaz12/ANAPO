<?php

namespace Database\Factories;

use App\Models\Asignatura;
use App\Models\AsignaturaDocente;
use App\Models\Estudiante;
use App\Models\Periodo;
use Illuminate\Database\Eloquent\Factories\Factory;

class AsignaturaEstudianteFactory extends Factory
{
    protected $model = \App\Models\AsignaturaEstudiante::class;

    public function definition()
    {
        return [
            'asignatura_id' => AsignaturaDocente::inRandomOrder()->first()->id, 
            'estudiantes_id' => Estudiante::inRandomOrder()->first()->id,  
            'estado' => $this->faker->randomElement([1, 0]),
        ];
    }
    public function estudiante()
{
    return $this->belongsTo(Estudiante::class, 'estudiantes_id');
}

}
