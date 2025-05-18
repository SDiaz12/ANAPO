<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\SoftDeletes;
class AsignaturaEstudiante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'asignatura_estudiantes'; 

    protected $fillable = [
        'asignatura_id', 'estudiantes_id', 'periodo_id', 'estado', 
    ];
    public function asignaturaDocente()
    {
        return $this->belongsTo(AsignaturaDocente::class, 'asignatura_id');
    }
  
    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'estudiantes_id');
    }
    
    public function notas()
    {
        return $this->hasOne(\App\Models\Nota::class, 'asignatura_estudiante_id');
    }
    public function nota()
    {
        return $this->hasOne(\App\Models\Nota::class, 'asignatura_estudiante_id');
    }
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }


    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiantes_id');
    }
    
   
}
