<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(){

        return view("auth.login");
    }

    public function store(Request $request){

        //este dd es como el console.log de js,sirve para ir probando que todo se conecte bien
        // dd("autenticando..");

        $this->validate($request,[

            "email"=>"required | email",
            "password"=>"required"
        ]);

        

        #el $request->remember es el que permite que al marcar el checkbox de recordar usuario se cree un remeber_web token,ese token es el que se almacena en la bd en la tabla de users en la columna remember token.Asi se comparan los token y se mantiene la sesion de ese usuario abierta.
        if (!auth()->attempt($request->only("email","password"),$request->remember)) {
            
            return back()->with("mensaje","Credenciales Incorrectas");
        }

        return redirect()->route("posts.index",auth()->user()->username);
    }
}
