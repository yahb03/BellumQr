<?php

namespace YourNamespace\Controllers;

use YourNamespace\Models\User;
use YourNamespace\Core\Sanitizer;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class UserController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                    if (User::create($cedula, $nombre, $apellido, $rango, $hashed_password, $role)) {
                        // Generate QR code
                        $qr_data = "Cedula: $cedula\nNombre: $nombre $apellido\nGrado: $rango";
                        $qr_filename = 'user_' . $cedula . '.png';
                        $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;
                        
                        if (!is_dir(__DIR__ . '/../../public/qrcodes/')) {
                            mkdir(__DIR__ . '/../../public/qrcodes/', 0777, true);
                        }
                        
                        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->data($qr_data)
                            ->build();
                        
                        $result->saveToFile($qr_path);

                        header("Location: /success?message=User+registered+successfully&qr=$qr_filename&type=user");
                        exit();
                    } else {
                        throw new \Exception("Failed to create user.");
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
                }
            }

        } else {
            require_once __DIR__ . '/../Views/register_user.php';
        }
    }

    public function search()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cedula = isset($_POST['cedula']) ? trim($_POST['cedula']) : '';

            if (!empty($cedula)) {
                $user = User::find($cedula);

                if ($user) {
                    echo "<div class='search-result-item'>User found: " . htmlspecialchars($user['nombre']) . " " . htmlspecialchars($user['apellido']) . "</div>";
                } else {
                    echo "<div class='search-result-item'>User not found.</div>";
                }
            }
        }
    }

    public function edit()
    {
        $cedula = Sanitizer::sanitizeString($_GET['cedula']);
        $user = User::find($cedula);
        require_once __DIR__ . '/../Views/admin/edit_user.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cedula = Sanitizer::sanitizeString($_POST['cedula']);
            $nombre = Sanitizer::sanitizeString($_POST['nombre']);
            $apellido = Sanitizer::sanitizeString($_POST['apellido']);
            $rango = Sanitizer::sanitizeString($_POST['rango']);
            $role = Sanitizer::sanitizeString($_POST['role']);

            if (User::update($cedula, $nombre, $apellido, $rango, $role)) {
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
        $cedula = Sanitizer::sanitizeString($_GET['cedula']);
        if (User::delete($cedula)) {
            header("Location: /admin/users?message=User+deleted+successfully");
            exit();
        } else {
            $error_controller = new ErrorController();
            $error_controller->customError("Database Error", "Failed to delete user.");
            exit();
        }
    }
}
