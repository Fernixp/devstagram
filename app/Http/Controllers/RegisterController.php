<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(){

        return view('auth.register');
    }

    public function store(Request $request)
    {
        //dd($request); //dd funcion de laravel para imprimir lo que le pases y detiene la ejecucion, detiene las siguientes lineas
        //dd($request->get('password'));
        //Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);//slug lo convierte en una url
        //Validacion
        $this->validate($request, [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6',
        ]);

        //create es igual a INSERT INTO
        User::create ([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,

        ]);

        //Autenticar un usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password,
        // ]);
        
        //otra forma
        auth()->attempt($request->only('email','password'));

        //Redireccionar

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
