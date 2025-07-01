<?php

namespace YourNamespace\Models;

use YourNamespace\Core\DB;

class Assignment
{
    public static function create($cedula_usuario, $serie_arma)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "INSERT INTO asignaciones (cedula_usuario, serie_arma) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $cedula_usuario, $serie_arma);
        return $stmt->execute();
    }

    public static function delete($serie_arma)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "DELETE FROM asignaciones WHERE serie_arma = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $serie_arma);
        return $stmt->execute();
    }

    public static function all()
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT a.*, u.nombre, u.apellido FROM asignaciones a JOIN usuarios u ON a.cedula_usuario = u.cedula";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
