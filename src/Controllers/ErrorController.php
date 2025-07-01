<?php

namespace YourNamespace\Controllers;

class ErrorController
{
    public function notFound()
    {
        http_response_code(404);
        $error_type = '404 Not Found';
        $error_message = 'The page you are looking for does not exist.';
        require_once __DIR__ . '/../Views/error.php';
    }

    public function customError($type, $message)
    {
        http_response_code(500);
        $error_type = $type;
        $error_message = $message;
        require_once __DIR__ . '/../Views/error.php';
    }
}
