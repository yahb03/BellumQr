<?php

namespace YourNamespace\Controllers;

use YourNamespace\Core\DB;
use YourNamespace\Core\Auth;

class AdminController
{
    public function __construct()
    {
        Auth::checkRole(['admin', 'super_user']);
    }

    public function index()
    {
        require_once __DIR__ . '/../Views/admin/panel_admin.php';
    }

    public function viewUsers()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $result = $conn->query("SELECT * FROM usuarios");
        $users = $result->fetch_all(MYSQLI_ASSOC);
        require_once __DIR__ . '/../Views/admin/view_users.php';
    }

    public function viewWeapons()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $result = $conn->query("SELECT * FROM arma");
        $weapons = $result->fetch_all(MYSQLI_ASSOC);
        require_once __DIR__ . '/../Views/admin/view_weapons.php';
    }

    public function viewAssignedWeapons()
    {
        $db = DB::getInstance();
        $conn = $db->getConnection();
        $sql = "SELECT a.*, u.nombre, u.apellido FROM asignaciones a JOIN usuarios u ON a.cedula_usuario = u.cedula";
        $result = $conn->query($sql);
        $assignments = $result->fetch_all(MYSQLI_ASSOC);
        require_once __DIR__ . '/../Views/admin/view_assigned_weapons.php';
    }
}
