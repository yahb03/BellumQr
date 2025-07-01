<?php

namespace YourNamespace\Controllers;

use YourNamespace\Core\Auth;

class AuthController
{
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cedula = $_POST['cedula'];
            $password = $_POST['password'];

            if (Auth::login($cedula, $password)) {
                header("Location: /");
                exit();
            } else {
                header("Location: /login?error=1");
                exit();
            }
        } else {
            require_once __DIR__ . '/../Views/login.php';
        }
    }

    public function logout()
    {
        Auth::logout();
    }
}
