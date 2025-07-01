<?php

namespace YourNamespace\Controllers;

use YourNamespace\Models\User;
use YourNamespace\Models\Weapon;
use YourNamespace\Models\Assignment;
use YourNamespace\Core\Auth;
use YourNamespace\Core\Sanitizer;

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
        $users = User::all();
        require_once __DIR__ . '/../Views/admin/view_users.php';
    }

    public function viewWeapons()
    {
        $weapons = Weapon::all();
        require_once __DIR__ . '/../Views/admin/view_weapons.php';
    }

    public function viewAssignedWeapons()
    {
        $assignments = Assignment::all();
        require_once __DIR__ . '/../Views/admin/view_assigned_weapons.php';
    }

    public function searchUsers()
    {
        $q = Sanitizer::sanitizeString($_GET['q']);
        $users = User::search($q);
        require_once __DIR__ . '/../Views/admin/view_users.php';
    }

    public function searchWeapons()
    {
        $q = Sanitizer::sanitizeString($_GET['q']);
        $weapons = Weapon::search($q);
        require_once __DIR__ . '/../Views/admin/view_weapons.php';
    }
}
