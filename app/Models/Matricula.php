<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'matriculas';

    protected $fillable = [
        'fecha_matricula',
        'estado',
        'motivo_estado',
        'observacion_estado',
        'alumno_id',
        'asignatura_id',
        'seccion_id',
        'periodo',
        'instituto'
    ];

    public function alumno()
    {
        return $this->belongsTo(Estudiante::class, 'alumno_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

}
