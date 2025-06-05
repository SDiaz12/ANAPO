<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignaturaDocente extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'docente_id', 
        'asignatura_id',
        'periodo_id',
        'seccion_id',
        'estado', 
        'mostrarTercerParcial',
        'created_by', 
        'deleted_by', 
        'updated_by'];
    protected $table = 'asignaturadocentes';

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }
    public function asignaturaEstudiantes()
    {
        return $this->hasMany(AsignaturaEstudiante::class, 'asignatura_id', 'id');
    }
    
}
