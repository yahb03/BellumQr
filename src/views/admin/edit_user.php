<?php
$title = 'Editar Usuario';
require_once __DIR__ . '/../partials/header.php';
?>

<form action="/admin/users/update" method="post">
    <input type="hidden" name="cedula" value="<?php echo htmlspecialchars($user['cedula']); ?>">
    <div class="input-group">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>" required>
    </div>
    <div class="input-group">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?php echo htmlspecialchars($user['apellido']); ?>" required>
    </div>
    <div class="input-group">
        <label for="rango">Grado:</label>
        <input type="text" id="rango" name="rango" value="<?php echo htmlspecialchars($user['rango']); ?>" required>
    </div>
    <div class="input-group">
        <label for="role">Rol:</label>
        <select id="role" name="role" required>
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>User</option>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
            <option value="super_user" <?php if ($user['role'] == 'super_user') echo 'selected'; ?>>Super User</option>
        </select>
    </div>
    <button type="submit" class="button">Actualizar</button>
    <a href="/admin/users" class="button">Cancelar</a>
</form>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>
