<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Educacion extends Model
{
    protected $fillable = ['titulo_edu', 'descripcion_edu', 'imagen_edu', 'video_edu'];
}
