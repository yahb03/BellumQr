<?php

namespace YourNamespace\Models;

use YourNamespace\Core\DB;

class User
{
    public static function create($cedula, $nombre, $apellido, $rango, $password, $role)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "INSERT INTO usuarios (cedula, nombre, apellido, rango, password, role) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $cedula, $nombre, $apellido, $rango, $password, $role);
        return $stmt->execute();
    }

    public static function find($cedula)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT * FROM usuarios WHERE cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function all()
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function update($cedula, $nombre, $apellido, $rango, $role)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, rango = ?, role = ? WHERE cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $nombre, $apellido, $rango, $role, $cedula);
        return $stmt->execute();
    }

    public static function delete($cedula)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "DELETE FROM usuarios WHERE cedula = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $cedula);
        return $stmt->execute();
    }

    public static function search($term)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT * FROM usuarios WHERE cedula LIKE ? OR nombre LIKE ? OR apellido LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%{$term}%";
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
