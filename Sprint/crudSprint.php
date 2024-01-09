<?php

include_once '../conexion.php';

class CrudSprint
{
    public static function obtenerCantidad($idProyecto)
    {

        $consulta = "SELECT Count(*) FROM sprint WHERE idProyecto = ?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($idProyecto));
            $count = $resultado->fetchColumn();
            return $count;
        } catch (\Throwable $th) {
            echo null;
        }
    }

    public static function listar($idProyecto)
    {

        $consulta = "SELECT * FROM sprint WHERE idProyecto = ?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($idProyecto));
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($datos);
        } catch (\Throwable $th) {
            echo null;
        }
    }

    public static function agregar($idProyecto)
    {
        $consulta = "INSERT INTO sprint VALUES(?,?)";
        $cantidad = CrudSprint::obtenerCantidad($idProyecto)    +   1;
        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($idProyecto, $cantidad));
        } catch (\Throwable $th) {
        }
    }

    public static function eliminar($idProyecto)
    {

        $consulta = "DELETE FROM sprint WHERE idProyecto=? AND numeroSprint=?";

        $cantidad = CrudSprint::obtenerCantidad($idProyecto);

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($idProyecto, $cantidad));
            echo true;
        } catch (\Throwable $th) {
            echo "false";
        }
    }
}
