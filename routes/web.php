<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PerfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', HomeController::class)->name('home');


Route::get('/register',[RegisterController::class,'index'])->name("register");
Route::post('/register',[RegisterController::class,'store'])->name("register");

Route::get('/login',[LoginController::class,'index'])->name("login");
Route::post('/login',[LoginController::class,'store'])->name("login");
Route::post('/logout',[LogoutController::class,'store'])->name("logout");

//rutas para el perfil(modificarlo,etc)
Route::get('/editar-perfil',[PerfilController::class,'index'])->name("perfil.index");
Route::post('/editar-perfil',[PerfilController::class,'store'])->name("perfil.store");


#laravel tiene funcionalidades avanzadas,una de ellas es el route model binding, con esta funcionalidad podemos crear rutas personalizadas para cada usuario,por ejemplo en vez de que al logearse un usuario y la url en su muro solo indique localhost/muro,podemos hacer que la url indique el nombre de usuario del que se logeo.Para hacer las url mas dinamicas ponemos el modelo user entre {} en nuestra ruta.El metodo index de ese controlador ya espera entonces un parametro que sera ese modelo User asi que se lo indicamos en el controlador.Para ponerle el valor especifico del username de cada usuario se lo indicamos a la ruta despues de los dos puntos en el parametro {user}
Route::get('/posts/create',[PostController::class,'create'])->name("posts.create");
Route::post('/posts',[PostController::class,'store'])->name("posts.store");
Route::get('/{user:username}/posts/{post}',[PostController::class,'show'])->name("posts.show");
Route::delete('/posts/{post}',[PostController::class,'destroy'])->name("posts.destroy");


Route::post('/{user:username}/posts/{post}',[ComentarioController::class,'store'])->name("comentarios.store");


#ruta para almacenar las imagenes de los posts
Route::post('/imagenes',[ImagenController::class,'store'])->name("imagenes.store");

//Like a las fotos
Route::post('/posts/{post}/likes',[LikeController::class,'store'])->name("posts.likes.store");
Route::delete('/posts/{post}/likes',[LikeController::class,'destroy'])->name("posts.likes.destroy");

Route::get('/{user:username}',[PostController::class,'index'])->name("posts.index");

//NOTA IMPORTANTE: cuando haga cambios en mis rutas pero no los detecte puedo poner el siguiente comando:  php artisan route:cache, si sigue sin funcionar puedo listar las rutas del proyecto que soporta laravel con:  php artisan route:list. Aqui podemos ver que para este proyecto las rutas van en orden alfabetico, la ruta editar-perfil esta mas arriba que la variable {user}, como esta ruta necesita el user pues no la encuentra porque esta variable esta por encima,entonces simplemente ponemos las rutas de editar-perfil arriba, puede ser despues de las rutas de login y logout en el archivo web.php,y la ruta de Route::get('/{user:username}'  la pasamos  abajo de todo,asi si se leeran bien las variables,las detecta el route.

//Ruta de Followers o siguiendo usuarios
Route::post('/{user:username}/follow',[FollowerController::class,'store'])->name("users.follow");
Route::delete('/{user:username}/unfollow',[FollowerController::class,'destroy'])->name("users.unfollow");










