<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'codigo', 
        'nombre', 
        'descripcion', 
        'creditos',
        'programaformacion_id', 
        'estado', 
        'created_by', 
        'deleted_by', 
        'updated_by'
    ];
    protected $table = 'asignaturas';

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'asignaturas_estudiantes', 'asignatura_id', 'estudiante_id');
    }

    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'seccion_asignatura', 'asignatura_id', 'seccion_id');
    }

    public function periodos()
    {
        return $this->belongsToMany(Periodo::class, 'asignatura_periodos', 'asignatura_id', 'periodo_id');
    }

    public function asignaturaDocentes()
    {
        return $this->hasMany(AsignaturaDocente::class, 'asignatura_id');
    }

    public function asignaturaEstudiantes()
    {
        return $this->hasMany(AsignaturaEstudiante::class, 'asignatura_id');
    }
    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'asignaturadocentes', 'asignatura_id', 'docente_id');
    }

}
