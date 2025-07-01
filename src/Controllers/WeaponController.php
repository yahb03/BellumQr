<?php

namespace YourNamespace\Controllers;

use YourNamespace\Core\DB;
use YourNamespace\Core\Sanitizer;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class WeaponController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $tipo_arma = isset($_POST['tipo_arma']) ? Sanitizer::sanitizeString($_POST['tipo_arma']) : '';
            $modelo = isset($_POST['modelo']) ? Sanitizer::sanitizeString($_POST['modelo']) : '';
            $serie = isset($_POST['serie']) ? Sanitizer::sanitizeString($_POST['serie']) : '';
            $ubicacion_actual = isset($_POST['ubicacion_actual']) ? Sanitizer::sanitizeString($_POST['ubicacion_actual']) : '';
            $estado_arma = isset($_POST['estado_arma']) ? Sanitizer::sanitizeString($_POST['estado_arma']) : '';

            if (empty($tipo_arma) || empty($modelo) || empty($serie) || empty($ubicacion_actual) || empty($estado_arma)) {
                $error_controller = new ErrorController();
                $error_controller->customError("Validation Error", "All fields are required.");
                exit();
            } else {
                try {
                    $sql = "INSERT INTO arma (Serie, Tipo_arma, Modelo, Ubicacion_actual, Estado_arma) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssss", $serie, $tipo_arma, $modelo, $ubicacion_actual, $estado_arma);

                    if ($stmt->execute()) {
                        $qr_data = "Tipo: $tipo_arma\nModelo: $modelo\nSerie: $serie\nUbicacion: $ubicacion_actual\nEstado: $estado_arma";
                        $qr_filename = 'weapon_' . $serie . '.png';
                        $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;

                        if (!is_dir(__DIR__ . '/../../public/qrcodes/')) {
                            mkdir(__DIR__ . '/../../public/qrcodes/', 0777, true);
                        }

                        $qr_code = QrCode::create($qr_data);
                        $writer = new PngWriter();
                        $writer->write($qr_code)->saveToFile($qr_path);

                        header("Location: /success?message=Weapon+registered+successfully&qr=$qr_filename&type=weapon");
                        exit();
                    } else {
                        throw new \Exception($stmt->error);
                    }
                } catch (\Exception $e) {
                    $error_message = $e->getMessage();
                    if (strpos($error_message, "Duplicate entry") !== false) {
                        $error_type = "Duplicate Entry";
                        $error_message = "A weapon with this serial number already exists. Please use a unique serial number.";
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
            require_once __DIR__ . '/../Views/register_weapon.php';
        }
    }

    public function search()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $serie = isset($_POST['serie']) ? $conn->real_escape_string(trim($_POST['serie'])) : '';

            if (!empty($serie)) {
                $sql = "SELECT * FROM arma WHERE Serie = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $serie);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $weapon = $result->fetch_assoc();
                    echo "Weapon found: " . $weapon['Tipo_arma'] . " " . $weapon['Modelo'] . " (" . $weapon['Estado_arma'] . ")";
                    if ($weapon['Ubicacion_actual'] == 'Asignada') {
                        echo " - Assigned";
                    } else {
                        echo " - Available";
                    }
                } else {
                    echo "Weapon not found.";
                }
            }
        }
    }

    public function edit()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $serie = Sanitizer::sanitizeString($_GET['serie']);
        $stmt = $conn->prepare("SELECT * FROM arma WHERE Serie = ?");
        $stmt->bind_param("s", $serie);
        $stmt->execute();
        $result = $stmt->get_result();
        $weapon = $result->fetch_assoc();
        require_once __DIR__ . '/../Views/admin/edit_weapon.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $db = DB::getInstance();
            $conn = $db->getConnection();

            $serie = Sanitizer::sanitizeString($_POST['serie']);
            $tipo_arma = Sanitizer::sanitizeString($_POST['tipo_arma']);
            $modelo = Sanitizer::sanitizeString($_POST['modelo']);
            $ubicacion_actual = Sanitizer::sanitizeString($_POST['ubicacion_actual']);
            $estado_arma = Sanitizer::sanitizeString($_POST['estado_arma']);

            $sql = "UPDATE arma SET Tipo_arma = ?, Modelo = ?, Ubicacion_actual = ?, Estado_arma = ? WHERE Serie = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $tipo_arma, $modelo, $ubicacion_actual, $estado_arma, $serie);

            if ($stmt->execute()) {
                header("Location: /admin/weapons?message=Weapon+updated+successfully");
                exit();
            } else {
                $error_controller = new ErrorController();
                $error_controller->customError("Database Error", "Failed to update weapon.");
                exit();
            }
        }
    }

    public function delete()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $serie = Sanitizer::sanitizeString($_GET['serie']);
        $sql = "DELETE FROM arma WHERE Serie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $serie);

        if ($stmt->execute()) {
            header("Location: /admin/weapons?message=Weapon+deleted+successfully");
            exit();
        } else {
            $error_controller = new ErrorController();
            $error_controller->customError("Database Error", "Failed to delete weapon.");
            exit();
        }
    }
}
