<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */

    public array $menuItems;

    public function __construct()
    {
        $this->menuItems = [
            [
                'group' => 'Principal',
                'items' => [
                    [
                        'name' => 'Inicio',
                        'route' => 'dashboard',
                        'icon' => 'home'
                    ]
                ]
            ],
            [
                'group' => 'Opciones',
                'items' => [
                    [
                        'name' => 'Categorias',
                        'route' => 'categorias',
                        'icon' => 'cube'
                    ],
                    [
                        'name' => 'Productos',
                        'route' => 'productos',
                        'icon' => 'cube'
                    ]
                ]
            ]
        ];
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar');
    }
}
