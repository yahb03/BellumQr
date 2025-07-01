<?php
$title = 'Ver Armamento';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="search-box" style="margin-bottom: 20px;">
    <form action="/admin/weapons/search" method="get" style="display: flex; gap: 10px;">
        <input type="text" name="q" placeholder="Buscar por serie, tipo o modelo..." style="flex-grow: 1;">
        <button type="submit" class="button">Buscar</button>
    </form>
</div>

<div class="table-container">
    <table id="weaponTable">
        <thead>
            <tr>
                <th>Serial</th>
                <th>Tipo</th>
                <th>Modelo</th>
                <th>Ubicación</th>
                <th>Condición</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($weapons)): ?>
                <?php foreach ($weapons as $weapon): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($weapon['Serie']); ?></td>
                        <td><?php echo htmlspecialchars($weapon['Tipo_arma']); ?></td>
                        <td><?php echo htmlspecialchars($weapon['Modelo']); ?></td>
                        <td><?php echo htmlspecialchars($weapon['Ubicacion_actual']); ?></td>
                        <td><?php echo htmlspecialchars($weapon['Estado_arma']); ?></td>
                        <td>
                            <a href="/admin/weapons/edit?serie=<?php echo htmlspecialchars($weapon['Serie']); ?>" class="button">Editar</a>
                            <a href="/admin/weapons/delete?serie=<?php echo htmlspecialchars($weapon['Serie']); ?>" class="button delete" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron armas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<a href="/admin" class="button">Volver al Panel</a>
<a href="/admin/weapons" class="button">Mostrar Todas</a>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
