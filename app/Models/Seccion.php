<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seccion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'nombre', 
        'programaformacion_id', 
        'created_by', 
        'deleted_by', 
        'updated_by'];
    protected $table = 'secciones';

    public function programaformacion()
    {
        return $this->belongsTo(ProgramaFormacion::class);
    }

    public function asignaturadocentes()
    {
        return $this->hasMany(AsignaturaDocente::class);
    }

    public function asignaturaestudiantes()
    {
        return $this->hasMany(Nota::class);
    }

}
