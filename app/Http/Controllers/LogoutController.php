<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store(){

        auth()->logout(); //helper
        return redirect()->route('login');
    }
}
