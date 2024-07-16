<?php

namespace Controllers;

use App\Router;
use Models\Categoria;

class CategoriaController {
    public static function admin(Router $router){
        $categorias = Categoria::listar();
        $router->renderView('admin/categoria/index', [
            'categorias' => $categorias
        ]);
    }

    public static function crear(Router $router) {
        $router->renderView('admin/categoria/crear');
    }

    public static function procesar() {
        
    }
}