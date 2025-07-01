<?php
$title = 'Bellum Tech System';
require_once __DIR__ . '/partials/header.php';
?>

<div class="search-panel">
    <div class="search-box">
        <h2>Buscar Arma</h2>
        <form id="search-weapon-form" action="/search_weapon" method="post">
            <input type="text" name="serie" placeholder="Número de Serie">
            <button type="submit">Buscar</button>
        </form>
    </div>
    <div class="search-box">
        <h2>Buscar Usuario</h2>
        <form id="search-user-form" action="/search_user" method="post">
            <input type="text" name="cedula" placeholder="Cédula">
            <button type="submit">Buscar</button>
        </form>
    </div>
</div>

<div id="search-results"></div>

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

<script>
document.getElementById('search-weapon-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('/search_weapon', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('search-results').innerHTML = data;
    });
});

document.getElementById('search-user-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('/search_user', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('search-results').innerHTML = data;
    });
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
