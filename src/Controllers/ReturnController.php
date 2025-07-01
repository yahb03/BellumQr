<?php

namespace YourNamespace\Controllers;

use YourNamespace\Models\Assignment;
use YourNamespace\Models\Weapon;
use YourNamespace\Core\Sanitizer;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ReturnController
{
    public function return()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $serie = isset($_POST['serie']) ? Sanitizer::sanitizeString($_POST['serie']) : '';

            if (empty($serie)) {
                $error_controller = new ErrorController();
                $error_controller->customError("Validation Error", "All fields are required.");
                exit();
            } else {
                try {
                    if (Weapon::updateLocation($serie, 'Armerillo')) {
                        Assignment::delete($serie);

                        // Generate QR code
                        $qr_data = "Devolucion:\nSerie: $serie";
                        $qr_filename = 'return_' . $serie . '.png';
                        $qr_path = __DIR__ . '/../../public/qrcodes/' . $qr_filename;

                        if (!is_dir(__DIR__ . '/../../public/qrcodes/')) {
                            mkdir(__DIR__ . '/../../public/qrcodes/', 0777, true);
                        }

                        $result = Builder::create()
                            ->writer(new PngWriter())
                            ->data($qr_data)
                            ->build();

                        $result->saveToFile($qr_path);

                        header("Location: /success?message=Weapon+returned+successfully&qr=$qr_filename&type=return");
                        exit();
                    } else {
                        throw new \Exception("Failed to update weapon location.");
                    }
                } catch (\Exception $e) {
                    $error_message = $e->getMessage();
                    $error_controller = new ErrorController();
                    $error_controller->customError("Database Error", $error_message);
                    exit();
                }
            }

        } else {
            require_once __DIR__ . '/../Views/return_weapon.php';
        }
    }
}
