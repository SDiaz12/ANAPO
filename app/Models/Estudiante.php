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
        'estado', 
        'user_id', 
        'created_by', 
        'deleted_by', 
        'updated_by'
    ];
    protected $table = 'estudiantes';

    //asignaturas a las que esta enlazado
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignaturaestudiantes', 'estudiantes_id', 'asignatura_id')
            ->withPivot('nota', 'observaciones', 'estado')
            ->withTimestamps();
    }

    //secciones a las que esta enlazado
    public function secciones()
    {
        return $this->belongsToMany(Seccion::class, 'asignaturaestudiantes', 'estudiante_id', 'seccion_id')
            ->withPivot('nota', 'observaciones', 'estado')
            ->withTimestamps();
    }

    //periodos a los que esta enlazado
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

}
