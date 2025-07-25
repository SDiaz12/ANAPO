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
        'user_id',
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
        'permanente',
        'lugar_asignado',
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
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asignaturas()
    {
        return $this->hasMany(AsignaturaDocente::class, 'docente_id');
    }

}
