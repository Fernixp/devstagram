<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user){
        //agregamos la persona que le esta siguiendo, en este caso el autenticado
        $user->followers()->attach(auth()->user()->id); //el attach es muy util para relaciones de m a m
        return back();
    }

    public function destroy(User $user){
        $user->followers()->detach(auth()->user()->id); //el detach elimina al usuario
        return back();
    }
}
