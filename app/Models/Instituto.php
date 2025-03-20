<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instituto extends Model
{
    protected $fillable = ['nombre', 'codigo', 'estado'];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'instituto_id');
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class, 'instituto_id');
    }

    public function docentes()
    {
        return $this->hasMany(Docente::class, 'instituto_id');
    }
}
