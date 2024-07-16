<?php

namespace Controllers;

use App\Router;

class DashboardController {

    public static function index(Router $router) {
        $router->renderView('admin/dashboard/index');
    }
}