<?php

use App\Router;
use Controllers\CategoriaController;
use Controllers\DashboardController;
use Controllers\PaginasController;
use Controllers\ProductoController;

require_once __DIR__ .'/../includes/app.php';

$router = new Router();

// Acceso privado
$router->get('/admin', [DashboardController::class, 'index']);
$router->get("/admin/categorias", [CategoriaController::class, "admin"]);
$router->get('/admin/categorias/crear', [CategoriaController::class, 'crear']);
$router->get('/admin/productos', [ProductoController::class, 'crear']);
$router->get('/admin/productos/crear', [ProductoController::class, 'crear']);

// Acceso público
$router->get("/", [PaginasController::class, 'index']);
$router->get('/404', [PaginasController::class, 'error']);


$router->comprobarRutas();