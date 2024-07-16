<?php

namespace App;

class Router {
    public $getRoutes = [];
    public $postRoutes = [];

    public function get($url, $fun) {
        $this->getRoutes[$url] = $fun;
    }

    public function post($url, $fun) {
        $this->postRoutes[$url] = $fun;
    }

    public function comprobarRutas() {
        try {
            $urlActual = $_SERVER['PATH_INFO'] ?? '/';
            $metodo = $_SERVER['REQUEST_METHOD']; // GET / POST
            if($metodo == 'GET'){
                $funcion = $this->getRoutes[$urlActual] ?? null;
            } else {
                $funcion = $this->postRoutes[$urlActual] ?? null;
            }

            if($funcion){
                call_user_func($funcion, $this);
            } else {
                header('Location: /404');
            }

        } catch (\Throwable $th) {
            echo "Error en la petición";
        }
    }

    public function renderView($vista, $datos = []) {
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        ob_start(); // Almacenamiento en memoria temporal
        include_once __DIR__ . "/views/{$vista}.php";
        $contenido = ob_get_clean(); // Tomamos los datos en memoria y limpiamos el buffer
        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        if(str_contains($urlActual, "/admin")){
            include_once __DIR__ . "/views/admin-layout.php";
        } else {
            include_once __DIR__ . "/views/layout.php";
        }
    }
}