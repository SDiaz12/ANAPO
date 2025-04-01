<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'promociones';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre',
        'estudiante_id', 
        'programaformacion_id',
        'periodo_id',
        'nivel_anterior',
        'nivel_actual',
        'fecha_promocion',
        'estado'
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'programaformacion_id');
    }


    public function periodo()
    {
        return $this->belongsTo(Periodo::class, 'periodo_id');
    }

}
