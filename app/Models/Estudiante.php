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
        'created_by', 
        'deleted_by', 
        'updated_by'
    ];
    protected $table = 'estudiantes';

    //asignaturas a las que esta enlazado
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignaturaestudiantes', 'estudiante_id', 'asignatura_id')
            ->withPivot('nota', 'observaciones', 'estado')
            ->withTimestamps();
    }
}
