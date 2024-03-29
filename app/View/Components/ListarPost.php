<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListarPost extends Component
{
    public $posts;
    
    public function __construct($posts)
    {
        //aqui le indicamos al componente que recibira variables con informacion
        $this->posts=$posts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.listar-post');
    }
}
