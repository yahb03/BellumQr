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
    '' => 'Controllers/ViewController@index',
    'login' => 'Controllers/AuthController@login',
    'logout' => 'Controllers/AuthController@logout',
    'register_user' => 'Controllers/UserController@register',
    'register_weapon' => 'Controllers/WeaponController@register',
    'assign_weapon' => 'Controllers/AssignmentController@assign',
    'return_weapon' => 'Controllers/ReturnController@return',
    'search_weapon' => 'Controllers/WeaponController@search',
    'search_user' => 'Controllers/UserController@search',
    'admin' => 'Controllers/AdminController@index',
    'admin/users' => 'Controllers/AdminController@viewUsers',
    'admin/users/search' => 'Controllers/AdminController@searchUsers',
    'admin/users/edit' => 'Controllers/UserController@edit',
    'admin/users/update' => 'Controllers/UserController@update',
    'admin/users/delete' => 'Controllers/UserController@delete',
    'admin/weapons' => 'Controllers/AdminController@viewWeapons',
    'admin/weapons/search' => 'Controllers/AdminController@searchWeapons',
    'admin/weapons/edit' => 'Controllers/WeaponController@edit',
    'admin/weapons/update' => 'Controllers/WeaponController@update',
    'admin/weapons/delete' => 'Controllers/WeaponController@delete',
    'admin/assigned' => 'Controllers/AdminController@viewAssignedWeapons',
    'success' => 'Controllers/ViewController@success',
    // Add other routes here
];

if (array_key_exists($route, $routes)) {
    $target = $routes[$route];
    list($controller, $method) = explode('@', $target);
    $controller_class = 'YourNamespace\\' . str_replace('/', '\\', $controller);
    if (class_exists($controller_class)) {
        $controller_instance = new $controller_class();
        if (method_exists($controller_instance, $method)) {
            $controller_instance->$method();
        } else {
            $error_controller = new YourNamespace\Controllers\ErrorController();
            $error_controller->notFound();
        }
    } else {
        $error_controller = new YourNamespace\Controllers\ErrorController();
        $error_controller->notFound();
    }
} else {
    $error_controller = new YourNamespace\Controllers\ErrorController();
    $error_controller->notFound();
}
