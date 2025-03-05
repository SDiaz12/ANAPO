<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'creditos', 'estado', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'asignaturas';
}
