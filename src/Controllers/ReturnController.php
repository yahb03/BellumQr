<?php

namespace YourNamespace\Controllers;

use YourNamespace\Core\DB;
use YourNamespace\Core\Sanitizer;

class ReturnController
{
    public function return()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $serie = isset($_POST['serie']) ? Sanitizer::sanitizeString($_POST['serie']) : '';

            if (empty($serie)) {
                $error_controller = new ErrorController();
                $error_controller->customError("Validation Error", "All fields are required.");
                exit();
            } else {
                try {
                    $sql = "UPDATE arma SET Ubicacion_actual = 'Armerillo' WHERE Serie = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $serie);

                    if ($stmt->execute()) {
                        $sql_delete = "DELETE FROM asignaciones WHERE serie_arma = ?";
                        $stmt_delete = $conn->prepare($sql_delete);
                        $stmt_delete->bind_param("s", $serie);
                        $stmt_delete->execute();

                        header("Location: /success?message=Weapon+returned+successfully");
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
                    if (isset($stmt_delete)) {
                        $stmt_delete->close();
                    }
                    $conn->close();
                }
            }
        } else {
            require_once __DIR__ . '/../Views/return_weapon.php';
        }
    }
}
