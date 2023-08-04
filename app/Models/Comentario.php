<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    //creando la relacion de las tablas un comentario pertenece a un usuario
    public function user(){ 
        return $this->belongsTo(User::class)->select(['name','username']); //sin el select nos trae todos los campos, para en espeficar los campos usamos select
    }
}
