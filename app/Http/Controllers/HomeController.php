<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    //si me sale este error cuando voy a la ruta raiz http://127.0.0.1:8000/, Attempt to read property "followings" on null, es porque intento ingresar a la pagina principal pero no estoy autenticado, entonces lo que puedo hacer es crear aqui un constructor que automaticamente revise con el middleware auth si estoy autenticado o no.
    public function __construct(){

        $this->middleware('auth');
    }



    //si en un controlador solo voy a tener un solo metodo,puedo utilizar el __invoke, este es como un constructor que se llama automaticamente porque solo existe un unico metodo,en la ruta solo especificamos el nombre de la clase.
     public function __invoke()
    {
        //obtener a quienes seguimos, pluck() me trae solo los campos que yo quiero de un objeto, en este caso los ids.
        $ids=(auth()->user()->followings->pluck('id')->toArray());
        $posts=Post::whereIn('user_id',$ids)->paginate(20);

        return view('home',[
            'posts'=>$posts
        ]);
    }
}
