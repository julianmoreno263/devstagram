<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index () {
        return view('auth.register');
    }

    public function store (Request $request ) {

        // dd($request);
        // dd($request->get("username"));

        //modificar el request, esto es para que el username no se pueda repetir en dos usuarios,debe ser unico
        $request->request->add(["username"=>Str::lower($request->username)]);

        // validacion en laravel
        $this->validate($request,[
            "name"=>"required | max:30",
            "username"=>"required | unique:users|min:3 | max:20",
            "email"=>"required | unique:users|email| max:60",
            "password"=>"required | confirmed | min:6"
        ]);

        //despues de la validacion,creamos el registro utilizando el modelo User que viene  por defecto en Laravel
        User::create([

            "name"=>$request->name,
            "username"=>$request->username,
            "email"=>$request->email,
            "password"=>Hash::make( $request->password),

        ]);

        //autenticar un usuario
        // auth()->attempt([

        //     "email"=>$request->email,
        //     "password"=>$request->password,
        // ]);

        //otra forma de autenticar
        auth()->attempt($request->only("email","password"));



        //redireccionamos al usuario
        return redirect()->route("posts.index");
    }
}
