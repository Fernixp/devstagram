<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; //clases que solamente tienen el proposito de hacer algo

class ImagenController extends Controller
{
    public function store(Request $request){
        $imagen = $request->file('file'); //para que seleccione el archivo

        $nombreImagen = Str::uuid().".".$imagen->extension(); //para que los nombres no se repitan

        $imagenServidor = Image::make($imagen); //procesamos la imagen
        $imagenServidor->fit(1000,1000); //aca asignamos la medida de cada imagen en este caso 1000x1000

        $imagenPath = public_path('uploads').'/'.$nombreImagen; //creamos la carpeta uploads y creamos la ruta
        $imagenServidor->save($imagenPath); //lo que tenemos en memoria lo guardamos con save y le pasamos la ruta
        

        return response()->json(['imagen' => $nombreImagen]);
    }
}
