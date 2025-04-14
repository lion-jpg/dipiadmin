<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nutricion extends Model
{
    protected $fillable = ['titulo_nut', 'descripcion_nut', 'imagen_nut', 'video_nut'];
}
