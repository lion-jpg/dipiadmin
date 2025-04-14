<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $fillable = [
        'nombre',
        'contenido',
        'user_id',
        'comentarioable_id',
        'comentarioable_type',
        'imagen_com'
    ];

    /**
     * Obtiene el usuario que hizo el comentario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el modelo comentado (polimórfico).
     */
    public function comentarioable()
    {
        return $this->morphTo();
    }
}
