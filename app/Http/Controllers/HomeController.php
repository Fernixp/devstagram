<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //si no esta autenticado lo llevamos a iniciar session
    }
    public function __invoke()
    { //con invoke este metodo se manda a llamar automaticamente, solo funciona con controladores con una sola funcion
        //Obtener a quienes seguimos
        //pluck solo nos trae los campos que especificamos
        $ids = auth()->user()->followings->pluck('id')->toArray(); //toArray nos devuelve una arreglo con las personas que estoy siguiendo
        //filtramos por el user_id, cada post tiene user_id, con latest ordenas de forma descendente
        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
        return view('home', [
            'posts' => $posts,
        ]);
    }
}
