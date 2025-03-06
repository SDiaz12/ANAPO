<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramaFormacion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
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
