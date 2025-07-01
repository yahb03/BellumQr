<?php

require_once __DIR__ . '/../vendor/autoload.php';

use YourNamespace\Core\Auth;

Auth::startSession();

$request_uri = $_SERVER['REQUEST_URI'];
$base_path = '/';

$route = str_replace($base_path, '', $request_uri);
$route = trim($route, '/');
$route = parse_url($route, PHP_URL_PATH);

$routes = [
    '' => 'src/Views/index.php',
    'login' => 'src/Controllers/AuthController.php@login',
    'logout' => 'src/Controllers/AuthController.php@logout',
    'register_user' => 'src/Controllers/UserController.php@register',
    'register_weapon' => 'src/Controllers/WeaponController.php@register',
    'assign_weapon' => 'src/Controllers/AssignmentController.php@assign',
    'return_weapon' => 'src/Controllers/ReturnController.php@return',
    'search_weapon' => 'src/Controllers/WeaponController.php@search',
    'search_user' => 'src/Controllers/UserController.php@search',
    'admin' => 'src/Controllers/AdminController.php@index',
    'admin/users' => 'src/Controllers/AdminController.php@viewUsers',
    'admin/users/edit' => 'src/Controllers/UserController.php@edit',
    'admin/users/update' => 'src/Controllers/UserController.php@update',
    'admin/users/delete' => 'src/Controllers/UserController.php@delete',
    'admin/weapons' => 'src/Controllers/AdminController.php@viewWeapons',
    'admin/weapons/edit' => 'src/Controllers/WeaponController.php@edit',
    'admin/weapons/update' => 'src/Controllers/WeaponController.php@update',
    'admin/weapons/delete' => 'src/Controllers/WeaponController.php@delete',
    'admin/assigned' => 'src/Controllers/AdminController.php@viewAssignedWeapons',
    // Add other routes here
];

if (array_key_exists($route, $routes)) {
    $target = $routes[$route];
    if (strpos($target, '@') !== false) {
        list($controller, $method) = explode('@', $target);
        $controller_class = 'YourNamespace\\' . str_replace('/', '\\', $controller);
        $controller_instance = new $controller_class();
        $controller_instance->$method();
    } else {
        require_once __DIR__ . '/../' . $target;
    }
} else {
    $error_controller = new YourNamespace\Controllers\ErrorController();
    $error_controller->notFound();
}
