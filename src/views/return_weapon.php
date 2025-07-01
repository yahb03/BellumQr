<?php 
$title = 'Entregar Armamento';
require_once __DIR__ . '/partials/header.php'; 
?>

<form action="/return_weapon" method="post" id="returnForm">
    <div class="input-group">
        <label for="serie">Serial del Arma:</label>
        <input type="text" id="serie" name="serie" required>
        <button type="button" id="searchWeapon" class="button">Buscar</button>
        <div id="weaponInfo"></div>
    </div>
    
    <div class="input-group">
        <label for="cedula">Cedula / ID:</label>
        <input type="text" id="cedula" name="cedula" required>
        <button type="button" id="searchUser" class="button">Buscar</button>
        <div id="userInfo"></div>
    </div>
    
    <div class="input-group">
        <label for="nuevo_estado">Condicion de Entrega:</label>
        <select name="nuevo_estado" id="nuevo_estado" required>
            <option value="">Seleciona</option>
            <option value="BUEN ESTADO">BUEN ESTADO</option>
            <option value="REGULAR ESTADO">REGULAR ESTADO</option>
            <option value="FUERA SERVICIO">FUERA SERVICIO</option>
        </select>
    </div>
    
    <button type="submit" id="returnButton" class="button" disabled>Entregar</button>
    <a href="/" class="button">Volver</a>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#searchWeapon').click(function() {
        var serie = $('#serie').val();
        $.ajax({
            url: '/search_weapon',
            type: 'POST',
            data: {serie: serie},
            success: function(response) {
                $('#weaponInfo').html(response);
                checkReturnButton();
            }
        });
    });

    $('#searchUser').click(function() {
        var cedula = $('#cedula').val();
        $.ajax({
            url: '/search_user',
            type: 'POST',
            data: {cedula: cedula},
            success: function(response) {
                $('#userInfo').html(response);
                checkReturnButton();
            }
        });
    });

    function checkReturnButton() {
        if ($('#weaponInfo').text().includes("found") && $('#userInfo').text().includes("found")) {
            $('#returnButton').prop('disabled', false);
        } else {
            $('#returnButton').prop('disabled', true);
        }
    }
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
