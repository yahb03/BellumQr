<?php
$title = 'Bellum Tech System';
require_once __DIR__ . '/partials/header.php';
?>

<div class="button-grid">
    <a href="/register_user" class="button">Registrar Usuario</a>
    <a href="/register_weapon" class="button">Registrar Arma</a>
    <a href="/assign_weapon" class="button">Asignar Arma</a>
    <a href="/return_weapon" class="button">Devolver Arma</a>
    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] == 'super_user' || $_SESSION['role'] == 'admin')): ?>
        <a href="/admin" class="button">Administración</a>
    <?php endif; ?>
    <a href="/logout" class="button">Salir</a>
</div>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
