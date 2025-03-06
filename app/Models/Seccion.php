<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seccion extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['nombre', 'created_by', 'deleted_by', 'updated_by'];
    protected $table = 'secciones';
}
