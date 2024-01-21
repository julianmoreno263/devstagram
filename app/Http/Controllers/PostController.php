<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    //con este constructor,al instanciar PostController,se protege la cuenta del usuario que se este logeando,al utilizar el middleware laravel protege la cuenta del usuario para que solo se pueda acceder a ella cuando se este logeado.Un middleware es una funcion que se jecuta antes que el resto del codigo,entonces al ejecutarse este middleware y pasandole el metodo de auth() se va a asegurar que primero se haya autenticado el usuario y despues si se ejecuta la funcion index().
    public function __construct(){

        //con except se restringe el acceso a ciertas funciones a menos que el usuario este logeado
        $this->middleware("auth")->except(['show','index']);
    }

    public function index(User $user){

        //este codigo sera para filtrar los posts del usuario y despues poder mostrarlos en el dashboard de ese usuario, en si este codigo consulta el modelo de Post y va a esa tabla post en la bd y captura con el get() toda la informacion de los posts que hay alli.Despues esa informacion se la paso a la vista. El metodo paginate de laravel nos sirve para crear la paginacion.
        $posts=Post::where('user_id', $user->id)->paginate(20);

       return view("dashboard",[
            "user"=>$user,
            "posts"=>$posts
       ]);
    }

    public function create(){

        return view('posts.create');
    }

    public function store(Request $request){

        $this->validate($request,[

            'titulo'=>'required|max:255',
            'descripcion'=>'required',
            'imagen'=>'required',

        ]);

        //este codigo almacena el post en la bd
        // Post::create([

        //     'titulo'=>$request->titulo,
        //     'descripcion'=>$request->descripcion,
        //     'imagen'=>$request->imagen,
        //     'user_id'=>auth()->user()->id,
        // ]);

        //esta es otra forma de guardar la informacion de los posts creados por un usuario en la bd,aqui ya se esta usando las relaciones que creamos entre esos dos modelos de User y Post,usamos las funciones en los modelos que crean las relaciones,osea la funcion user() y la funcion posts().Esta forma es mas al estilo de laravel.
        $request->user()->posts()->create([

            'titulo'=>$request->titulo,
            'descripcion'=>$request->descripcion,
            'imagen'=>$request->imagen,
            'user_id'=>auth()->user()->id,
        ]);

        return redirect()->route('posts.index',auth()->user()->username);
    }


    public function show(User $user,Post $post){

        return view('posts.show',[
            'post'=>$post,
            'user'=>$user
        ]);
    }

    public function destroy(Post $post){
        //aqui utilizamos una policy,la creamos con php artisan make:policy PostPolicy --model=Post y este archivo tendra funcionalidades que se pueden usar con los modelos asociados en la policy,usaremos el metodo delete de esta policy
        $this->authorize('delete',$post);
        $post->delete();

        //eliminar la imagen
        $imagen_path=public_path('uploads/' . $post->imagen);

        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        };

        return redirect()->route('posts.index',auth()->user()->username);
    }
}
