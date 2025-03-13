<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    // Propiedad fillable
    protected $fillable = [
        'estudiante_id',
        'asignatura_id',
        'docente_id',
        'periodo_id',
        'primerparcial',
        'segundoparcial',
        'tercerparcial',
        'asistencia',
        'recuperacion',
        'observacion',
        'estado',
    ];

    /**
     * Relación con AsignaturaEstudiante.
     * Esto asume que una nota pertenece a una asignatura-estudiante específica.
     */
    public function asignaturaEstudiante()
    {
        return $this->belongsTo(AsignaturaEstudiante::class, 'asignatura_estudiante_id');
    }

    /**
     * Relación con Asignatura.
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    /**
     * Relación con Docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    /**
     * Relación con Periodo.
     */
    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

    /**
     * Relación con Estudiante.
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }
}
