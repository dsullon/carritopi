<?php

namespace Controllers;

use App\Router;

class PaginasController {

    public static function index(Router $router) {
       $router->renderView('paginas/index'); 
    }
    public static function error(Router $router) {

        $router->renderView('paginas/404', [
            'titulo' => 'Página no encontrada'
        ]);
    }
}