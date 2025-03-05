<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $fillable = ['nombre', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'secciones';
}
