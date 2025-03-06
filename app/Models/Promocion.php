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
    protected $primaryKey = 'id_promocion';
    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin', 'estado', 'id_programa_formacion'];

    public function programaFormacion()
    {
        return $this->belongsTo(ProgramaFormacion::class, 'id_programa_formacion');
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class, 'id_promocion');
    }
}
