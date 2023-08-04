<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post){
        //validar
        $this->validate($request, [
            'comentario' => 'required|max:255',

        ]);
        //almacenar el resultado
        Comentario::create([
            //aca no utilizamos el user que viene por el parametro, por que el comentario es del usuario actual
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);
        //imprimir un mensaje
        return back()->with('mensaje','Comentario Realizado Correctamente'); //regresar a la pagina anterior con datos.
    }
}
