<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //para la autenticacion
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        //modificar el request
        $request->request->add(['username' => Str::slug($request->username)]); //slug lo convierte en una url
        //validacion
        $this->validate($request, [
            'username' => [
                'required',
                'unique:users,username,' . auth()->user()->id, //con username,hacemos la excepcion para el mismo usuario
                'min:3',
                'max:20',
                'not_in:twitter,editar-perfil', //lista negra de usuarios que no se pueden crear
                //'in:CLIENTE,PROVEEDOR,VENDEDOR', //con In obligamos al usuario a poner esos nombres
            ],
        ]);

        if ($request->imagen) {
            $imagen = $request->file('imagen'); //para que seleccione el archivo

            $nombreImagen = Str::uuid() . "." . $imagen->extension(); //para que los nombres no se repitan

            $imagenServidor = Image::make($imagen); //procesamos la imagen
            $imagenServidor->fit(1000, 1000); //aca asignamos la medida de cada imagen en este caso 1000x1000

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen; //creamos la carpeta uploads y creamos la ruta
            $imagenServidor->save($imagenPath); //lo que tenemos en memoria lo guardamos con save y le pasamos la ruta

        }

        //guardar cambios
        $usuario = User::find(auth()->user()->id); //obtenemos el usuario y buscamos al usuario actual que esta modificando
        $usuario->username = $request->username;
        //aca preguntamos si no hay ninguna imagen en el formulario, despues si solo cambia el nombre de user pero ya cuenta con perfil, y por ultima si no tiene ninguna lo almacenamos en la Bd como null
        $usuario->imagen=$nombreImagen ?? auth()->user()->imagen ?? null;
        $usuario->save(); //guardamos en la BD

        return redirect()->route('posts.index',$usuario->username);
 
    }
}
