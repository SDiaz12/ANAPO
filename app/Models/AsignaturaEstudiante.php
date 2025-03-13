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
        'asignatura_id', 'estudiante_id', 'periodo_id'
    ];
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}
