<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaRequisito extends Model
{
    use HasFactory;

    protected $table = 'asignatura_requisitos';

    protected $fillable = [
        'asignatura_id',
        'requisito_id'
    ];

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    public function requisito()
    {
        return $this->belongsTo(Asignatura::class, 'requisito_id');
    }
}