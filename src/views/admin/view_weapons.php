<?php
$title = 'Ver Armamento';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="search-box">
    <input type="text" id="searchInput" placeholder="Buscar...">
</div>

<div class="table-container">
    <table id="weaponTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Serial</th>
                <th onclick="sortTable(1)">Tipo</th>
                <th onclick="sortTable(2)">Modelo</th>
                <th onclick="sortTable(3)">Ubicación</th>
                <th onclick="sortTable(4)">Condición</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($weapons) > 0) {
                foreach ($weapons as $weapon) {
                    echo "<tr>
                            <td>" . htmlspecialchars($weapon['Serie']) . "</td>
                            <td>" . htmlspecialchars($weapon['Tipo_arma']) . "</td>
                            <td>" . htmlspecialchars($weapon['Modelo']) . "</td>
                            <td>" . htmlspecialchars($weapon['Ubicacion_actual']) . "</td>
                            <td>" . htmlspecialchars($weapon['Estado_arma']) . "</td>
                            <td>
                                <a href='/admin/weapons/edit?serie=" . htmlspecialchars($weapon['Serie']) . "' class='button'>Editar</a>
                                <a href='/admin/weapons/delete?serie=" . htmlspecialchars($weapon['Serie']) . "' class='button delete' onclick='return confirm("¿Estás seguro de que quieres desactivar esta arma?")'>Desactivar</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No se encontraron armas</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<a href="/admin" class="button">Volver</a>

<script>
    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("weaponTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    });

    // Sorting functionality
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("weaponTable");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>