<?php 
$title = 'Asignar Armamento';
require_once __DIR__ . '/partials/header.php'; 
?>

<form action="/assign_weapon" method="post" id="assignForm">
    <div class="input-group">
        <label for="serie">Serial del Arma:</label>
        <input type="text" id="serie" name="serie" required>
        <button type="button" id="searchWeapon" class="button">Buscar</button>
        <div id="weaponInfo"></div>
    </div>

    <div class="input-group">
        <label for="cedula">Cedula/ ID:</label>
        <input type="text" id="cedula" name="cedula" required>
        <button type="button" id="searchUser" class="button">Buscar</button>
        <div id="userInfo"></div>
    </div>

    <button type="submit" id="assignButton" class="button" disabled>Asignar</button>
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
                checkAssignButton();
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
                checkAssignButton();
            }
        });
    });

    function checkAssignButton() {
        if ($('#weaponInfo').text().includes("Available") && $('#userInfo').text().includes("found")) {
            $('#assignButton').prop('disabled', false);
        } else {
            $('#assignButton').prop('disabled', true);
        }
    }
});
</script>

<?php require_once __DIR__ . '/partials/footer.php'; ?>
