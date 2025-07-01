<?php
$title = 'Ver Usuarios';
require_once __DIR__ . '/../partials/header.php';
?>

<div class="search-box">
    <input type="text" id="searchInput" placeholder="Buscar...">
</div>

<div class="table-container">
    <table id="userTable">
        <thead>
            <tr>
                <th onclick="sortTable(0)">Cedula</th>
                <th onclick="sortTable(1)">Nombre</th>
                <th onclick="sortTable(2)">Apellido</th>
                <th onclick="sortTable(3)">Grado</th>
                <th onclick="sortTable(4)">Unidad</th>
                <th onclick="sortTable(5)">Telefono</th>
                <th onclick="sortTable(6)">Email</th>
                <th onclick="sortTable(7)">Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($users) > 0) {
                foreach ($users as $user) {
                    echo "<tr>
                            <td>" . htmlspecialchars($user['cedula']) . "</td>
                            <td>" . htmlspecialchars($user['nombre']) . "</td>
                            <td>" . htmlspecialchars($user['apellido']) . "</td>
                            <td>" . htmlspecialchars($user['rango']) . "</td>
                            <td>" . htmlspecialchars($user['Unidad']) . "</td>
                            <td>" . htmlspecialchars($user['Telefono']) . "</td>
                            <td>" . htmlspecialchars($user['Correo_electronico']) . "</td>
                            <td>" . htmlspecialchars($user['role']) . "</td>
                            <td>
                                <a href='/admin/users/edit?cedula=" . htmlspecialchars($user['cedula']) . "' class='button'>Editar</a>
                                <a href='/admin/users/delete?cedula=" . htmlspecialchars($user['cedula']) . "' class='button delete' onclick='return confirm(\"¿Estás seguro de que quieres desactivar este usuario?\")'>Desactivar</a>
                            </td>
                        </tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No se encontraron usuarios</td></tr>";
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
        table = document.getElementById("userTable");
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
        table = document.getElementById("userTable");
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