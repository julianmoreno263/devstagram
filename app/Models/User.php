<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //la relacion es un metodo que existe en los modelos(eloquent), se refiere a las relaciones entre los modelos de la app,osea las relaciones entre las tablas de la bd, hasMany es la relacion one to many,sino que se escribe hasMany, es donde un usuario puede tener multiples posts.Se le indica el modelo con el cual se relaciona,osea Post::class en este caso.Para probar que esta funcion esta relacionando los usuarios con los posts, abrimos tinker para probar la bd con php artisan tinker, despues podemos poner en una variable este codigo para ver la informacion de un usuario: $usuario=User::find(11), y con esta variable puedo usar la funcion de la relacion que cree,osea la funcion posts y me traera los posts de ese usuario,asi se que esta relacion se creo exitosamente:  $usuario->posts
    public function posts(){

        return $this->hasMany(Post::class);
    }

    public function likes(){

        return $this->hasMany(Like::class);
    }

    //Almacena los seguidores de un usuario, aqui le indicamos que el metodo followers usara la tabla de followers y que pertenecera  a muchos usuarios,osea un usuario puede tener muchos seguidores.Como nos estamos saliendo de las convenciones de laravel debemos especificar los campos de la tabla followers que es una tabla intermedia que se creo para relacionar usuarios.El user_id es el usuario que estamos visitando y el follower_id el el usuario que le esta dando seguir a ese otro usuario.
    public function followers(){

        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    //Almacenar los que seguimos, aqui solo cambiamos el orden de los ids de follower_id y user_id
    public function followings(){

        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }

    //Comprobar si un usuario ya sigue a otro, aqui usamos el metodo followers,contains() valida si ya se esta siguiendo a ese usuario con ese id.
    public function siguiendo(User $user){

        return $this->followers->contains($user->id);
    }


}
