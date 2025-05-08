<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estudiante extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'codigo', 
        'dni', 
        'foto', 
        'nombre', 
        'apellido', 
        'fecha_nacimiento', 
        'sexo', 
        'residencia', 
        'telefono', 
        'correo', 
        'fecha_ingreso',
        'user_id', 
        'created_by', 
        'deleted_by', 
        'updated_by'
    ];
    protected $table = 'estudiantes';

   
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_estudiantes', 'estudiantes_id', 'asignatura_id')
            ->withPivot('nota', 'observaciones', 'estado')
            ->withTimestamps();
    }

   
    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'asignaturaestudiantes', 'estudiante_id', 'seccion_id')
            ->withPivot('nota', 'observaciones', 'estado')
            ->withTimestamps();
    }

   
    public function periodos()
    {
        return $this->belongsToMany(Periodo::class, 'asignaturaestudiantes', 'estudiante_id', 'periodo_id')
            ->withPivot('nota', 'observaciones', 'estado')
            ->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function matricula()
    {
        return $this->hasOne(Matricula::class, 'estudiante_id', 'id');
    }
    public function matriculas()
    {
        return $this->hasOne(Matricula::class, 'estudiante_id', 'id');
    }
    public function asignaturaEstudiantes()
    {
        return $this->hasMany(\App\Models\AsignaturaEstudiante::class, 'estudiantes_id', 'id');
    }
    
    public function notas()
    {
        return $this->hasOne(\App\Models\Nota::class, 'asignatura_estudiante_id');
    }


}
