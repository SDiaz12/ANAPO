<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignaturaEstudiante extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'asignaturaestudiantes';

    protected $fillable = [
        'asignatura_id', 
        'estudiante_id', 
        'nota', 
        'observaciones', 
        'estado'
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }
}
