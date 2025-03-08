<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramaFormacion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'programaformaciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel_formacion',
        'duracion',
        'estado',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'programa_formacion_id');
    }

    public function secciones()
    {
        return $this->hasMany(Seccion::class, 'programa_formacion_id');
    }

    public function periodos()
    {
        return $this->hasMany(Periodo::class, 'programa_formacion_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'programa_formacion_id');
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class, 'programa_formacion_id');
    }

}
