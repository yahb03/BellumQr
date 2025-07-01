<?php

namespace YourNamespace\Controllers;

use YourNamespace\Models\Assignment;
use YourNamespace\Models\Weapon;
use YourNamespace\Core\Sanitizer;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class AssignmentController
{
    public function assign()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cedula = isset($_POST['cedula']) ? Sanitizer::sanitizeString($_POST['cedula']) : '';
            $serie = isset($_POST['serie']) ? Sanitizer::sanitizeString($_POST['serie']) : '';

            if (empty($cedula) || empty($serie)) {
                $error_controller = new ErrorController();
                $error_controller->customError("Validation Error", "All fields are required.");
                exit();
            } else {
                try {
                    if (Assignment::create($cedula, $serie)) {
                        Weapon::updateLocation($serie, 'Asignada');

                        // Generate QR code
                        $qr_data = "Asignacion:\nCedula: $cedula\nSerie: $serie";
                        $qr_filename = 'assign_' . $serie . '_' . $cedula . '.png';
                        $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;

                        if (!is_dir(__DIR__ . '/../../public/qrcodes/')) {
                            mkdir(__DIR__ . '/../../public/qrcodes/', 0777, true);
                        }

                        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->data($qr_data)
                            ->build();

                        $result->saveToFile($qr_path);

                        header("Location: /success?message=Weapon+assigned+successfully&qr=$qr_filename&type=assignment");
                        exit();
                    } else {
                        throw new \Exception("Failed to create assignment.");
                    }
                } catch (\Exception $e) {
                    $error_message = $e->getMessage();
                    $error_controller = new ErrorController();
                    $error_controller->customError("Database Error", $error_message);
                    exit();
                }
            }

        } else {
            require_once __DIR__ . '/../Views/assign_weapon.php';
        }
    }
}
