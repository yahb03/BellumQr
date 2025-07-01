<?php
$title = 'Ver Usuarios';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="search-box" style="margin-bottom: 20px;">
    <form action="/admin/users/search" method="get" style="display: flex; gap: 10px;">
        <input type="text" name="q" placeholder="Buscar por cédula, nombre o apellido..." style="flex-grow: 1;">
        <button type="submit" class="button">Buscar</button>
    </form>
</div>

<div class="table-container">
    <table id="userTable">
        <thead>
            <tr>
                <th>Cedula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Grado</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['cedula']); ?></td>
                        <td><?php echo htmlspecialchars($user['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($user['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($user['rango']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="/admin/users/edit?cedula=<?php echo htmlspecialchars($user['cedula']); ?>" class="button">Editar</a>
                            <a href="/admin/users/delete?cedula=<?php echo htmlspecialchars($user['cedula']); ?>" class="button delete" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<a href="/admin" class="button">Volver al Panel</a>
<a href="/admin/users" class="button">Mostrar Todos</a>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
