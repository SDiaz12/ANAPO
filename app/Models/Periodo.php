<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'periodos';

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programa_formacion_id');
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class, 'periodo_id');
    }

    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_periodos', 'periodo_id', 'asignatura_id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'estudiante_periodos', 'periodo_id', 'estudiante_id');
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'periodo_id');
    }
    public function asignaturasEstudiantes()
    {
        return $this->hasMany(AsignaturaEstudiante::class);
    }

}
