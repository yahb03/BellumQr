<?php 
$title = 'Login';
require_once __DIR__ . '/partials/header.php'; 
?>

<?php if (isset($_GET['error'])) echo "<p class='error-message'>Credenciales inválidas!</p>"; ?>
<form action="/login" method="post">
    <div class="input-group">
        <label for="cedula">Cedula:</label>
        <input type="text" id="cedula" name="cedula" class="input-field" required>
    </div>
    <div class="input-group">
        <label for="password">Clave:</label>
        <input type="password" id="password" name="password" class="input-field" required>
    </div>
    <button type="submit" name="login" class="button">Entrar</button>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
