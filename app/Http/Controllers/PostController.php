<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show','index'); //con esto controlamos nuestra autentificacion del usuario, con el except le decimos que algunos metodos si se muestren
    }

    public function index(User $user)
    {
        $posts = Post::where('user_id', $user->id)->latest()->paginate(5);  //aca la consulta de nuestras tablas relacionadas, con get traemos los datos, con paginate,simplePaginate nos hace una paginacion de los registros
        return view('dashboard', [
            'user' => $user,
            'posts' => $posts, //aca pasamos el objeto a la vista dashboard 
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    //el store almacena el registro
    public function store(Request $request)
    {
        $this->validate($request, [
            'titulo' => ['required', 'max:255'],
            'descripcion' => ['required'],
            'imagen' => ['required'],
        ]);

        //para almacenar las publicaciones, INSERT INTO
        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id //obteniendo el id del usuario actual autenticado
        // ]);

        //otra forma de almacenar registros
        // $post = new Post;
        // $post->titulo = $request->titulo;
        // $post->descripcion = $request->descripcion;
        // $post->imagen = $request->imagen;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        //otra tercera forma de almaceenar registros con relaciones
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);
    }

    public function show(User $user, Post $post)
    {
        return view(
            'posts.show',[
                'post' => $post,
                'user' => $user  //pasando le objeto post a la vista
            ]
        );
    }

    //funcion que elimina un post
    public function destroy(Post $post){
        $this->authorize('delete',$post); //verificamos si el usuario es quien creó la publicacion
        
        $post->delete();

        //Eliminar la imagen
        $imagen_path = public_path('uploads/'.$post->imagen); //esto nos da la url completa de la imagen

        if (File::exists($imagen_path)) { //preguntamos si la imagen existe
            unlink($imagen_path); //eliminando la imagen con la funcion unlink
        }
        return redirect()->route('posts.index',auth()->user()->username);
    }
}
