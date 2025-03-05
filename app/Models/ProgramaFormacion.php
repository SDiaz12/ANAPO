<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramaFormacion extends Model
{
    protected $table = 'programa_formaciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel_formacion',
        'estado',
    ];

    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class, 'programa_formacion_id');
    }
}
