<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignacionDocentesEstudiantes extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asignaciondocentesestudiantes';

    protected $fillable = [
        'docente_id',
        'estudiante_id',
        'periodo_id',
        'estado'
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function asignaturaEstudiante()
    {
        return $this->hasMany(Nota::class, 'asignacion_docente_estudiante_id');
    }

    public function asignaturaDocente()
    {
        return $this->hasMany(AsignaturaDocente::class, 'asignacion_docente_estudiante_id');
    }

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }

    public function promocion()
    {
        return $this->belongsTo(Promocion::class, 'promocion_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }

}
