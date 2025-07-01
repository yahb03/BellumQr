<?php

namespace YourNamespace\Controllers;

use YourNamespace\Models\Weapon;
use YourNamespace\Core\Sanitizer;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class WeaponController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
                    if (Weapon::create($serie, $tipo_arma, $modelo, $ubicacion_actual, $estado_arma)) {
                        $qr_data = "Tipo: $tipo_arma\nModelo: $modelo\nSerie: $serie\nUbicacion: $ubicacion_actual\nEstado: $estado_arma";
                        $qr_filename = 'weapon_' . $serie . '.png';
                        $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;

                        if (!is_dir(__DIR__ . '/../../public/qrcodes/')) {
                            mkdir(__DIR__ . '/../../public/qrcodes/', 0777, true);
                        }

                        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->data($qr_data)
                            ->build();

                        $result->saveToFile($qr_path);

                        header("Location: /success?message=Weapon+registered+successfully&qr=$qr_filename&type=weapon");
                        exit();
                    } else {
                        throw new \Exception("Failed to create weapon.");
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
                }
            }

        } else {
            require_once __DIR__ . '/../Views/register_weapon.php';
        }
    }

    public function search()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $serie = isset($_POST['serie']) ? trim($_POST['serie']) : '';

            if (!empty($serie)) {
                $weapon = Weapon::find($serie);

                if ($weapon) {
                    $assigned_status = ($weapon['Ubicacion_actual'] == 'Asignada') ? 'Asignada' : 'Disponible';
                    echo "<div class='search-result-item'>Weapon found: " . htmlspecialchars($weapon['Tipo_arma']) . " " . htmlspecialchars($weapon['Modelo']) . " (" . htmlspecialchars($weapon['Estado_arma']) . ") - " . htmlspecialchars($assigned_status) . "</div>";
                } else {
                    echo "<div class='search-result-item'>Weapon not found.</div>";
                }
            }
        }
    }

    public function edit()
    {
        $serie = Sanitizer::sanitizeString($_GET['serie']);
        $weapon = Weapon::find($serie);
        require_once __DIR__ . '/../Views/admin/edit_weapon.php';
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $serie = Sanitizer::sanitizeString($_POST['serie']);
            $tipo_arma = Sanitizer::sanitizeString($_POST['tipo_arma']);
            $modelo = Sanitizer::sanitizeString($_POST['modelo']);
            $ubicacion_actual = Sanitizer::sanitizeString($_POST['ubicacion_actual']);
            $estado_arma = Sanitizer::sanitizeString($_POST['estado_arma']);

            if (Weapon::update($serie, $tipo_arma, $modelo, $ubicacion_actual, $estado_arma)) {
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
        $serie = Sanitizer::sanitizeString($_GET['serie']);
        if (Weapon::delete($serie)) {
            header("Location: /admin/weapons?message=Weapon+deleted+successfully");
            exit();
        } else {
            $error_controller = new ErrorController();
            $error_controller->customError("Database Error", "Failed to delete weapon.");
            exit();
        }
    }
}
