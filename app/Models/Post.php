<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    //Este es el fillable para que laravel sepa que debe almacenar en la BD, esto paara que no ocurra ingreso de datos masivos
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //creano la relacion Belongs to, pertenece a...

    public function user(){  //autor
        //si no seguimos las convenciones de laravel, debemos especificar el FK de la otra tabla
        //return $this->belongsTo(User::class, 'user_id')->select(['name','username']);
        return $this->belongsTo(User::class)->select(['name','username']); //sin el select nos trae todos los campos, para en espeficar los campos usamos select
    }

    //la relacion de 1 a n un post puede ttener varios comentarios
    public function comentarios(){
        return $this->hasMany(Comentario::class); //has Manu 1 a n esto reemplaza el select * from comentarios where user_id=id etc..
    }

    //la relacion de 1 a n de los likes
    public function likes(){
        return $this->hasMany(Like::class);
    }
    
    //creando un metodo para verificar si el usuario ya le dio like al post
    public function checkLike(User $user){
        return $this->likes->contains('user_id',$user->id); //debido a la relacion que ya tenemos, el contains revisa la columna especificada,en este caso revisa la columna user_id y busca el id del usuario ingresado
        
    }
}
