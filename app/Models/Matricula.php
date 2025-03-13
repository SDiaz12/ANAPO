<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'matriculas';

    protected $fillable = [
        'fecha_matricula',
        'programaformacion_id',
        'estado',
        'motivo_estado',
        'observacion_estado',
        'estudiante_id',
        'instituto'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programaformacion_id');
    }

    public function asignacionDocentesEstudiantes()
    {
        return $this->hasMany(AsignacionDocentesEstudiantes::class, 'matricula_id');
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class, 'matricula_id');
    }

    public function asignaturasEstudiantes()
    {
        return $this->hasMany(Nota::class, 'matricula_id');
    }

}
