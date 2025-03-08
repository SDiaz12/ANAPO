<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignaturaDocente extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['asignatura_id', 'docente_id', 'estado', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'asignaturadocentes';

    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class);
    }
}
