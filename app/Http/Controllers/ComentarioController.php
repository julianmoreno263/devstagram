<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;


class ComentarioController extends Controller
{
    public function store(Request $request,User $user,Post $post){

        //validar
        $this->validate($request,[
            'comentario'=>'required|max:255'
        ]);


        //almacenar el resultado, aqui el usuario que se utiliza es el que esta autenticado,es el que esta comentando sobre el post de otro usuario.
        Comentario::create([
            'user_id'=>auth()->user()->id ,
            'post_id'=> $post->id,
            'comentario'=>$request->comentario ,
        ]);


        //imprimir un mensaje
        return back()->with('mensaje','Comentario Creado Correctamente');
    }
}
