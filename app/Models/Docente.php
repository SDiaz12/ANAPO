<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $fillable = ['codigo', 'dni', 'foto', 'nombre', 'apellido', 'fecha_nacimiento', 'residencia', 'sexo', 'telefono', 'correo', 'estado', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'docentes';
}
