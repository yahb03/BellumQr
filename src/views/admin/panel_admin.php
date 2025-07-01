<?php
$title = 'Panel de Administración';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="button-grid">
    <a href="/admin/users" class="button">Ver Usuarios</a>
    <a href="/admin/weapons" class="button">Ver Armas</a>
    <a href="/admin/assigned" class="button">Ver Armas Asignadas</a>
    <a href="/" class="button">Volver</a>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
