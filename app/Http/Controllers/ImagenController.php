<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


class ImagenController extends Controller
{

    //funcion para almacenar las imagenes
    public function store(Request $request){

        $imagen=$request->file('file');

        //usando intervention image para darle mejor manejo a las imagenes en su tamano,aqui se genera un id unico para cada imagen
        $nombreImagen=Str::uuid() . "." . $imagen->extension();

        //la clase Image con el metodo make() es lo que nos permite crear una instancia de intervention/image, y ya con esa instancia podemos pasarle efectos,por ejemplo un tamano con el metodo fit() en pixeles.En la documentacion de intervention estan todos los eventos que se pueden aplicar.
        $imagenServidor=Image::make($imagen);
        $imagenServidor->fit(1000,1000);

        //aqui debemos mover la imagen al servidor en la carpeta public,creamos alli otra carpeta para ir guardando esas imagenes,si no se hace esto despues d eun tiempo el servidor elimina las imagenes
        $imagenPath=public_path('uploads') . '/' . $nombreImagen;
        $imagenServidor->save($imagenPath);

        return response()->json(['imagen'=>$nombreImagen]);
    }
}
