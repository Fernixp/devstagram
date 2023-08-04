<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request,Post $post){
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);
        return back(); //retornamos a la pagina anterior
    }

    public function destroy(Request $request, Post $post){
        $request->user()->likes()->where('post_id', $post->id)->delete(); //eliminamos el like , con el where filtramos el post actual y con delete lo eliminamos

        return back();
    }
}
