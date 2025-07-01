<?php

namespace YourNamespace\Controllers;

use YourNamespace\Core\DB;
use YourNamespace\Core\Sanitizer;

class UserController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $cedula = isset($_POST['cedula']) ? Sanitizer::sanitizeString($_POST['cedula']) : '';
            $nombre = isset($_POST['nombre']) ? Sanitizer::sanitizeString($_POST['nombre']) : '';
            $apellido = isset($_POST['apellido']) ? Sanitizer::sanitizeString($_POST['apellido']) : '';
            $rango = isset($_POST['rango']) ? Sanitizer::sanitizeString($_POST['rango']) : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $role = isset($_POST['role']) ? Sanitizer::sanitizeString($_POST['role']) : 'user';

            if (empty($cedula) || empty($nombre) || empty($apellido) || empty($rango) || empty($password)) {
                $error_controller = new ErrorController();
                $error_controller->customError("Validation Error", "All fields are required.");
                exit();
            } else {
                try {
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO usuarios (cedula, nombre, apellido, rango, password, role) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssss", $cedula, $nombre, $apellido, $rango, $hashed_password, $role);

                    if ($stmt->execute()) {
                        header("Location: /success?message=User+registered+successfully");
                        exit();
                    } else {
                        throw new \Exception($stmt->error);
                    }
                } catch (\Exception $e) {
                    $error_message = $e->getMessage();
                    if (strpos($error_message, "Duplicate entry") !== false) {
                        $error_type = "Duplicate Entry";
                        $error_message = "A user with this ID already exists. Please use a unique ID.";
                    } else {
                        $error_type = "Database Error";
                    }
                    $error_controller = new ErrorController();
                    $error_controller->customError($error_type, $error_message);
                    exit();
                } finally {
                    if (isset($stmt)) {
                        $stmt->close();
                    }
                    $conn->close();
                }
            }
        } else {
            require_once __DIR__ . '/../Views/register_user.php';
        }
    }

    public function search()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $cedula = isset($_POST['cedula']) ? $conn->real_escape_string(trim($_POST['cedula'])) : '';

            if (!empty($cedula)) {
                $sql = "SELECT * FROM usuarios WHERE cedula = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $cedula);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $user = $result->fetch_assoc();
                    echo "User found: " . $user['nombre'] . " " . $user['apellido'];
                } else {
                    echo "User not found.";
                }
            }
        }
    }

    public function edit()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $cedula = Sanitizer::sanitizeString($_GET['cedula']);
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE cedula = ?");
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        require_once __DIR__ . '/../Views/admin/edit_user.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $cedula = Sanitizer::sanitizeString($_POST['cedula']);
            $nombre = Sanitizer::sanitizeString($_POST['nombre']);
            $apellido = Sanitizer::sanitizeString($_POST['apellido']);
            $rango = Sanitizer::sanitizeString($_POST['rango']);
            $role = Sanitizer::sanitizeString($_POST['role']);

            $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, rango = ?, role = ? WHERE cedula = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $nombre, $apellido, $rango, $role, $cedula);

            if ($stmt->execute()) {
                header("Location: /admin/users?message=User+updated+successfully");
                exit();
            } else {
                $error_controller = new ErrorController();
                $error_controller->customError("Database Error", "Failed to update user.");
                exit();
            }
        }
    }

    public function delete()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $cedula = Sanitizer::sanitizeString($_GET['cedula']);
        $sql = "DELETE FROM usuarios WHERE cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cedula);

        if ($stmt->execute()) {
            header("Location: /admin/users?message=User+deleted+successfully");
            exit();
        } else {
            $error_controller = new ErrorController();
            $error_controller->customError("Database Error", "Failed to delete user.");
            exit();
        }
    }
}
