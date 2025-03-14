<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'asignatura_estudiante_id',
        'primerparcial',
        'segundoparcial',
        'tercerparcial',
        'asistencia',
        'recuperacion',
        
        'observacion',
        'estado',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    
    public function asignaturaEstudiante()
    {
        return $this->belongsTo(AsignaturaEstudiante::class, 'asignatura_estudiante_id');
    }
}
