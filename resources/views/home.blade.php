@extends('layouts.app')

@section('titulo')
    Página Principal
@endsection

@section('contenido')
    <!--Pasando los objetos al slot-->
    <x-listar-post :posts="$posts" />
@endsection
