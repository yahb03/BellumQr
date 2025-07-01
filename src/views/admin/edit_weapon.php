<?php
$title = 'Editar Arma';
require_once __DIR__ . '/../partials/header.php';
?>

<form action="/admin/weapons/update" method="post">
    <input type="hidden" name="serie" value="<?php echo htmlspecialchars($weapon['Serie']); ?>">
    <div class="input-group">
        <label for="tipo_arma">Tipo de Arma:</label>
        <select id="tipo_arma" name="tipo_arma" required>
            <option value="FUSIL" <?php if ($weapon['Tipo_arma'] == 'FUSIL') echo 'selected'; ?>>FUSIL</option>
            <option value="PISTOLA" <?php if ($weapon['Tipo_arma'] == 'PISTOLA') echo 'selected'; ?>>PISTOLA</option>
            <option value="AMETRALLADORA" <?php if ($weapon['Tipo_arma'] == 'AMETRALLADORA') echo 'selected'; ?>>AMETRALLADORA</option>
            <option value="LANZAGRANADAS" <?php if ($weapon['Tipo_arma'] == 'LANZAGRANADAS') echo 'selected'; ?>>LANZAGRANADAS</option>
            <option value="MORTERO" <?php if ($weapon['Tipo_arma'] == 'MORTERO') echo 'selected'; ?>>MORTERO</option>
        </select>
    </div>
    <div class="input-group">
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($weapon['Modelo']); ?>" required>
    </div>
    <div class="input-group">
        <label for="ubicacion_actual">Armerillo Actual:</label>
        <input type="text" id="ubicacion_actual" name="ubicacion_actual" value="<?php echo htmlspecialchars($weapon['Ubicacion_actual']); ?>" required>
    </div>
    <div class="input-group">
        <label for="estado_arma">Condicion:</label>
        <select id="estado_arma" name="estado_arma" required>
            <option value="BUEN ESTADO" <?php if ($weapon['Estado_arma'] == 'BUEN ESTADO') echo 'selected'; ?>>BUEN ESTADO</option>
            <option value="REGULAR ESTADO" <?php if ($weapon['Estado_arma'] == 'REGULAR ESTADO') echo 'selected'; ?>>REGULAR ESTADO</option>
            <option value="FUERA DE SERVICIO" <?php if ($weapon['Estado_arma'] == 'FUERA DE SERVICIO') echo 'selected'; ?>>FUERA DE SERVICIO</option>
        </select>
    </div>
    <button type="submit" class="button">Actualizar</button>
    <a href="/admin/weapons" class="button">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
