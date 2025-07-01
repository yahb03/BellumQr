<?php

namespace YourNamespace\Controllers;

class ViewController
{
    public function index()
    {
        require_once __DIR__ . '/../Views/index.php';
    }

    public function success()
    {
        require_once __DIR__ . '/../Views/success.php';
    }
}
