<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 * 
 * Los archivos factory son archivos que nos permiten hacer testing a las tablas de nuestra bd,son utilies  en desarrollo.Laravel implementa la libreria faker que es util para hacer estas pruebas, podemos probar todos los campos de la tabla o solo unos si queremos,en esta prueba lo que necesitamos probar es que los campos de la tabla efectivamente tengan el tipo de dato que se necesita.
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            
            //indicamos con sentence() cuantas palabras quiero para el campo, con randomElement como en la bd los usuarios no tienen un id consecutivo porque he venido creando y borrando usuarios,le ponemos el array con 1,2,3 y esto debe dar error,porque esos ids no existen.Para probar estos factorys debemos llamar a la libreria tinker via artisan la cual es un cli(una consola de laravel) que nos permite interactuar con nuestra bd.Ejecutamos en consola php artisan tinker.Entonces en esta consola puedo poner:

            //$usuario=User::find(3) y como yo no tengo un usuario con ese id me sacara null,si le paso un id que si tenga en mi bd me saca la informacion de ese usuario y asi pruebo los campos de la tabla.

            //ahora, el factory ya esta atado al modelo correspondiente,entonces para correr ese factory ponemos en consola: Post::factory()->times(200)->create(), con esto le indicamos que cree 200 posts de prueba, si llega a salir un error es porque en algun momento en el randomElement() de pronto colocamos un id de usuario que no existe,entonces para que la prueba de creacion de posts funcione debemos poner en ese array solo ids que esten en nuestra bd,en mi caso el 11,12 y 15.En caso de que de un error debemos salir de la consola tinker y volver a entrar porque ella guarda en cache esos errores y no va a dejar ejecutar bien de nuevo,toca salir y volver a entrar y ejecutar.Estos posts de prueba apareceran en la bd en la tabla de posts. En caso de que debamos corregir el archivo de la migracion, hacemos el cambio,revertimos la migracion con php artisan migrate:rollback --step=1 y despues le volvemos a dar php artisan migrate.

            //de esta forma los factorys nos ayudan a generar datos de pruebas aleatorios en las tablas y asi comprobar si todo esta bien en nuestra bd, pero esto es solo para la bd local.

            'titulo'=>$this->faker->sentence(5),
            'descripcion'=>$this->faker->sentence(20),
            'imagen'=>$this->faker->uuid() . '.jpg',
            'user_id'=>$this->faker->randomElement([11,12,15])
        ];
    }
}
