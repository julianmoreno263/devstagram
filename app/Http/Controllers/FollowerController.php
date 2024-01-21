<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    //aqui el $user es la persona a la que estamos siguiendo, el $request si tiene a la persona que esta siguiendo a ese usuario. El metodo attach() es util cuando tenemos una relacion de muchos a muchos entre dos modelos, este metodo es utilizado en el modelo que representa la tabla intermedia(pivot table) que relaciona ambas tablas. Para que laravel sepa en que tabla intermedia debe almacenar el id que se esta pasando con el metodo attach() se asume que la relacion many-to-many esta definida correctamente en los modelos correspondientes.
    public function store(User $user){
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    public function destroy(User $user){
        $user->followers()->detach(auth()->user()->id);

        return back();
    }
}
