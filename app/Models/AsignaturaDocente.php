<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignaturaDocente extends BaseModel
{
    protected $fillable = ['asignatura_id', 'docente_id', 'estado', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'asignaturas_docentes';
}
