<?php

namespace YourNamespace\Core;

class Auth
{
    public static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function check()
    {
        self::startSession();
        if (!isset($_SESSION['cedula']) || !isset($_SESSION['role'])) {
            header("Location: login.php");
            exit();
        }
    }

    public static function checkRole($required_roles)
    {
        self::check();
        if (!in_array($_SESSION['role'], $required_roles)) {
            header("Location: unauthorized.php");
            exit();
        }
    }

    public static function login($cedula, $password)
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                self::startSession();
                $_SESSION['cedula'] = $user['cedula'];
                $_SESSION['role'] = $user['role'];
                return true;
            }
        }

        return false;
    }

    public static function logout()
    {
        self::startSession();
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit();
    }
}
