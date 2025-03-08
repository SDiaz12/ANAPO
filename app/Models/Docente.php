<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docente extends BaseModel
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
        'residencia', 
        'sexo', 
        'telefono', 
        'correo', 
        'fecha_ingreso',
        'estado', 
        'created_by', 
        'deleted_by', 
        'updated_by'
    ];
    protected $table = 'docentes';
    protected $casts = [
        'estado' => 'boolean',
    ];

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programa_formacion_id');
    }


    public function asignaturas()
    {
        return $this->hasMany(AsignaturaDocente::class, 'docente_id');
    }

}
