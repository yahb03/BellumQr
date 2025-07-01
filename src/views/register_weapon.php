<?php 
$title = 'Registrar Arma';
require_once __DIR__ . '/partials/header.php'; 
?>

<form action="/register_weapon" method="post">
    <div class="input-group">
        <label for="tipo_arma">Tipo de Arma:</label>
        <select id="tipo_arma" name="tipo_arma" required>
            <option value="">Selecionar</option>
            <option value="FUSIL">FUSIL</option>
            <option value="PISTOLA">PISTOLA</option>
            <option value="AMETRALLADORA">AMETRALLADORA</option>
            <option value="LANZAGRANADAS">LANZAGRANADAS</option>
            <option value="MORTERO">MORTERO</option>
        </select>
    </div>
    <div class="input-group">
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required>
    </div>
    <div class="input-group">
        <label for="serie">Serial:</label>
        <input type="text" id="serie" name="serie" required>
    </div>
    <div class="input-group">
        <label for="ubicacion_actual">Armerillo Actual:</label>
        <input type="text" id="ubicacion_actual" name="ubicacion_actual" required>
    </div>
    <div class="input-group">
        <label for="estado_arma">Condicion:</label>
        <select id="estado_arma" name="estado_arma" required>
            <option value="">Selecionar</option>
            <option value="BUEN ESTADO">BUEN ESTADO</option>
            <option value="REGULAR ESTADO">REGULAR ESTADO</option>
            <option value="FUERA DE SERVICIO">FUERA DE SERVICIO</option>
        </select>
    </div>
    <button type="submit" class="button">Registrar</button>
    <a href="/" class="button">Volver</a>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
