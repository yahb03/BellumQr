<?php

namespace YourNamespace\Controllers;

use YourNamespace\Core\DB;
use YourNamespace\Core\Sanitizer;

class AssignmentController
{
    public function assign()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $cedula = isset($_POST['cedula']) ? Sanitizer::sanitizeString($_POST['cedula']) : '';
            $serie = isset($_POST['serie']) ? Sanitizer::sanitizeString($_POST['serie']) : '';

            if (empty($cedula) || empty($serie)) {
                $error_controller = new ErrorController();
                $error_controller->customError("Validation Error", "All fields are required.");
                exit();
            } else {
                try {
                    $sql = "INSERT INTO asignaciones (cedula_usuario, serie_arma) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $cedula, $serie);

                    if ($stmt->execute()) {
                        $sql_update = "UPDATE arma SET Ubicacion_actual = 'Asignada' WHERE Serie = ?";
                        $stmt_update = $conn->prepare($sql_update);
                        $stmt_update->bind_param("s", $serie);
                        $stmt_update->execute();

                        header("Location: /success?message=Weapon+assigned+successfully");
                        exit();
                    } else {
                        throw new \Exception($stmt->error);
                    }
                } catch (\Exception $e) {
                    $error_message = $e->getMessage();
                    $error_controller = new ErrorController();
                    $error_controller->customError("Database Error", $error_message);
                    exit();
                } finally {
                    if (isset($stmt)) {
                        $stmt->close();
                    }
                    if (isset($stmt_update)) {
                        $stmt_update->close();
                    }
                    $conn->close();
                }
            }
        } else {
            require_once __DIR__ . '/../Views/assign_weapon.php';
        }
    }
}
