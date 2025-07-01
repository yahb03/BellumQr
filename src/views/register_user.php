<?php 
$title = 'Registrar Usuario';
require_once __DIR__ . '/partials/header.php'; 
?>

<form action="/register_user" method="post">
    <div class="input-group">
        <label for="cedula">Cedula:</label>
        <input type="text" id="cedula" name="cedula" required>
    </div>
    <div class="input-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
    </div>
    <div class="input-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
    </div>
    <div class="input-group">
        <label for="rango">Grado:</label>
        <input type="text" id="rango" name="rango" required>
    </div>
    <div class="input-group">
        <label for="password">Clave:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit" class="button">Registrar</button>
    <a href="/" class="button">Volver</a>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
