<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salud extends Model
{
    protected $fillable = [
        'titulo_sal', 
        'descripcion_sal', 
        'imagen_sal', 
        'video_sal'
        ];

    protected $table = 'saluds';
}
