<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LikePost extends Component
{

    //lo bueno de livewire es que nos permite ahorrar codigo, por ejemplo nosotros tenemos en likecontroller dos funciones,una para alamcenar un post y otra para eliminarlo,con livewire en este archivo podemos ahorrarnos esas funciones y solo crear una unica funcion que haga esas dos cosas.

    public $post;
    public $isLiked;
    public $likes;


    //esta funcion mount() es una funcion que se llama automaticamente una vez se instancie la clase LikePost, es como un constructor en php pero aqui en livewire se le llama mount()
    public function mount($post){

        $this->isLiked=$post->checkLike(auth()->user());
        $this->likes=$post->likes->count();
    }

    public function like(){

        if ($this->post->checkLike(auth()->user())) {

            $this->post->likes()->where('post_id',$this->post->id)->delete();
            $this->isLiked=false;
            $this->likes--;
        }else{
            $this->post->likes()->create([
                'user_id'=>auth()->user()->id
            ]);

            $this->isLiked=true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
