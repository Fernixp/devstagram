<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    //creando atributo
    public $post;
    //atributo para saber si el user ya le dio me gusta
    public $isLiked;
    public $likes;

    //se va ejecutar cuando se ha instanciado este LikePost, es como un constructor en php
    public function mount($post){
        //este isLiked va devolver un 0 o 1, primero que es lo que va evaluar, y segundo le cambiamos el valor en los metodos
        $this->isLiked =$post->checkLike(auth()->user());
        $this->likes = $post->likes->count();
    }

    public function like()
    {

        if ($this->post->checkLike( auth()->user() )) {
            #Si el usuario ya le dio me gusta....
            //eliminamos el like , con el where filtramos el post actual y con delete lo eliminamos
            $this->post->likes()->where('post_id', $this->post->id)->delete(); //eliminamos el like , con el where filtramos el post actual y con delete lo eliminamos
            $this->isLiked=false;
            $this->likes--; 
        } else{
            #si el usuario no le dio me gusta.....
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
