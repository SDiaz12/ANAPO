<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asignatura extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['codigo', 'nombre', 'descripcion', 'creditos', 'estado', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'asignaturas';
}
