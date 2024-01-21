<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //el fillable es la informacion que laravel guardara en la bd,esta es una forma  de proteger la bd, porque esta es la informacion que laravel lee para saber que es lo que tiene que enviar a la bd.
    protected $fillable=[

        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //aqui creamos la relacion inversa entre las tablas user y post, la primera que creamos en el modelo User fue de uno a muchoa,donde un usuario puede tener muchos posts,pero entonces aqui debemos crear la otra relacion,osea un posts solo puede pertenecer a un usuario especifico,lo probamos de nuevo con Tinker para ver si esta guardando bien en la bd.
    public function user(){

        return $this->belongsTo(User::class)->select(['name','username']);
    }

    //vamos a crear una relacion para mostrar los comentarios, un post pertenece a un usuario pero un post puede tener multiples comentarios
    public function comentarios(){
        return $this->hasMany(Comentario::class);
    }

    //asi creamos la relacion entre Post y Like
    public function likes(){

        return $this->hasMany(Like::class);
    }

    //funcion para revisar si ya se le dio like a un post y asi evitar duplicados,el likes es la relacion que ya tenemos y el contains() lo que hace es revisar el campo de la tabla que le pasemos,en este caso user_id de la tabla Like
    public function checkLike(User $user){

        return $this->likes->contains('user_id', $user->id);
    }
}
