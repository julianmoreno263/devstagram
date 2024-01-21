<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    //el constructor protege esta ruta con el middleware asi
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){

        return view('perfil.index');
    }

    public function store(Request $request){

        //modificar el request, esto es para que el username no se pueda repetir en dos usuarios,debe ser unico
        $request->request->add(["username"=>Str::slug($request->username)]);

        //aqui se establecen las reglas para cada parametro, cuando son mas de 3 reglas se recomienda poner todo en un arreglo, tambien puedo poner otra regla que es como una lista de nombres que no puedo usar al editar mi perfil por ejemplo el nombre twitter o facebook o la misma ruta de editar-perfil, tambien puedo hacer que el usuario deba elegir el nombre de perfil al que quiere cambiar de una lista ya establecida,esto con el parametro 'in', aunque esto serviria mas cuando estemos haciendo un crm donde solo pueden haber clientes,proveedores,vendedores,etc,asi se esta obligado solo a escoger uno de esos roles.

        //esta regla: 'unique:users,username,'.auth()->user()->id, me permite dejar el username que tengo y solo editar mi foto de perfil.
        $this->validate($request,[
            "username"=>['required','unique:users,username,'.auth()->user()->id,'min:3','max:20', 'not_in:twitter,editar-perfil,facebook'],
        ]);

        //aqui se almacena la imagen del perfil
        if ($request->imagen) {
            $imagen=$request->file('imagen');

        //usando intervention image para darle mejor manejo a las imagenes en su tamano,aqui se genera un id unico para cada imagen
        $nombreImagen=Str::uuid() . "." . $imagen->extension();

        //la clase Image con el metodo make() es lo que nos permite crear una instancia de intervention/image, y ya con esa instancia podemos pasarle efectos,por ejemplo un tamano con el metodo fit() en pixeles.En la documentacion de intervention estan todos los eventos que se pueden aplicar.
        $imagenServidor=Image::make($imagen);
        $imagenServidor->fit(1000,1000);

        //aqui debemos mover la imagen al servidor en la carpeta public,creamos alli otra carpeta para ir guardando esas imagenes,si no se hace esto despues d eun tiempo el servidor elimina las imagenes
        $imagenPath=public_path('perfiles') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        }

        //Guardar cambios
        $usuario=User::find(auth()->user()->id);

        $usuario->username=$request->username;
        $usuario->imagen=$nombreImagen ?? auth()->user()->imagen ?? null;

        $usuario->save();

        //redireccionar al usuario
        redirect()->route('posts.index',$usuario->username);

    }
}
