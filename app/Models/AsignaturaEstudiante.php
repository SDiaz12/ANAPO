<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignaturaEstudiante extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'asignaturas_estudiantes';
    protected $primaryKey = 'id_asignatura_estudiante';
    protected $fillable = ['id_asignatura', 'id_estudiante', 'nota', 'observaciones', 'estado'];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'id_asignatura');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'id_estudiante');
    }
}
