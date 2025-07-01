<?php
$title = 'Success';
require_once __DIR__ . '/partials/header.php';

$message = $_GET['message'] ?? 'Operation completed successfully.';
$qr_filename = $_GET['qr'] ?? null;
?>

<div class="text-center">
    <h2><?php echo htmlspecialchars($message); ?></h2>

    <?php if ($qr_filename): ?>
        <div class="my-4">
            <img src="/qrcodes/<?php echo htmlspecialchars($qr_filename); ?>" alt="QR Code">
        </div>
    <?php endif; ?>

    <a href="/" class="button">Volver al Inicio</a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
