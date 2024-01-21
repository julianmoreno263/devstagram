<div>
    <!-- Simplicity is the essence of happiness. - Cedric Bledsoe -->

    {{-- 1-se pueden crear componentes en laravel como en react, los componentes sirven para evitar repetir codigo, si uso un componente en varias paginas de mi sitio y necesito hacerle un cambio,simplemente lo hago en la vista del componente y ese cambio se replica en las demas paginas donde se este usando.Para crear un componente en laravel se pone este codigo:  php artisan make:component NombreComponente.  Al crearlo,se crean dos carpetas, una en app\View\Components\ListarPost.php, este archivo es el que llevara la logica del compoente, y se crea otro en resources\views\components\listar-post.blade.php, aqui estara el template del componente. Para utilizar este componente en otras vistas debemos utilizar la etiqueta <x-NombreComponente/>, si utilizamos esta etiqueta simple sin etiqueta de cierre no podemos pasarle informacion dinamica al componente, pero si necesitamos pasar informacion dinamicamente debemos utilizar la etiqueta de cierre asi:

                <x-NombreComponente>
                    <h1>aqui va la informacion</h1>
                </x-NombreComponente>

    utilizando esta etiqueta ya podemos utilizar slots, los cuales nos permiten enviar datos al componente y renderizarlos dinamicamente.Con esta informacion entre las etiquetas del componente podemos ir entonces al template del componente e indicarle que esa informacion viajara a traves de un slot asi: {{$slot}}.Estos slots trabajan como variables, si creo varias etiquetas <x-></x-> puedo psar diferente informacion y solo lo indico en el template con {{$slot}}.Tambien los puedo crear con un titulo para identificarlos asi: 
    
                <x-slot:nombre del slot></x-slot:nombre>
    
    y en el template pongo {{nombre del slot}} y asi los identifica.

    --------------------------------------------------------------------

    2- ahora, para pasar informacion al componente,por ejemplo en este caso tenemos la variable $post en HomeController y esta se pasa a la vista de home.blade, comomestamos utilizando la etiqueta para usar el componente <x-></x-> la forma de pasar esa variable del controlador a esta etiqueta es:

                    <x-listar-post :posts="$posts/>

    asi esta variable ya se pasa al template del componente, pero asi no mas no funciona, debemos hacerle saber al componente que recibira esa variable, esto lo hacemos en el archivo ListarPost.php que se creo al crear el componente, en el constructor del archivo es donde se le indica que recibira esa variable.

    --}}


    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{route('posts.show', ['post'=>$post,'user'=>$post->user])}}">
                        <img src="{{asset('uploads') . '/' . $post->imagen}}" alt="Imagen del post {{$post->titulo}}">
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">No hay Posts,sigue a alguien para poder mostrar sus posts</p>
    @endif


</div>