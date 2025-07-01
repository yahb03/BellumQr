<?php

namespace YourNamespace\Models;

use YourNamespace\Core\DB;

class Weapon
{
    public static function create($serie, $tipo_arma, $modelo, $ubicacion_actual, $estado_arma)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "INSERT INTO arma (Serie, Tipo_arma, Modelo, Ubicacion_actual, Estado_arma) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $serie, $tipo_arma, $modelo, $ubicacion_actual, $estado_arma);
        return $stmt->execute();
    }

    public static function find($serie)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT * FROM arma WHERE Serie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $serie);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function all()
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT * FROM arma";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function update($serie, $tipo_arma, $modelo, $ubicacion_actual, $estado_arma)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "UPDATE arma SET Tipo_arma = ?, Modelo = ?, Ubicacion_actual = ?, Estado_arma = ? WHERE Serie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $tipo_arma, $modelo, $ubicacion_actual, $estado_arma, $serie);
        return $stmt->execute();
    }

    public static function delete($serie)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "DELETE FROM arma WHERE Serie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $serie);
        return $stmt->execute();
    }

    public static function search($term)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "SELECT * FROM arma WHERE Serie LIKE ? OR Tipo_arma LIKE ? OR Modelo LIKE ?";
        $stmt = $conn->prepare($sql);
        $searchTerm = "%{$term}%";
        $stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function updateLocation($serie, $location)
    {
        $conn = DB::getInstance()->getConnection();
        $sql = "UPDATE arma SET Ubicacion_actual = ? WHERE Serie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $location, $serie);
        return $stmt->execute();
    }
}
