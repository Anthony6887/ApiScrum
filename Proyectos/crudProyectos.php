<?php

include_once '../conexion.php';
include_once '../Sprint/crudSprint.php';

class CrudProyecto
{
    public static function listar()
    {

        $participante = $_GET['participante'];

        $consulta = "SELECT p.*,pp.rol FROM proyectos p, participantes_proyectos pp WHERE p.id=pp.proyecto AND pp.participante=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($participante));
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($datos);
        } catch (\Throwable $th) {
            echo null;
        }
    }

    public static function buscar($nombre, $descripcion)
    {

        $consulta = "SELECT id FROM proyectos Where nombre=? and descripcion=?";

        $conexion = Conexion::Conectar();
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(array($nombre, $descripcion));

        $fila = $resultado->fetch(PDO::FETCH_ASSOC);

        return $fila['id'];
    }

    public static function agregar()
    {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $participante = $_POST['participante'];

        $consulta = "INSERT INTO proyectos VALUES(0,?,?,?,?,'pendiente','disponible')";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($nombre, $descripcion, $fechaInicio, $fechaFin));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }

        $id = CrudProyecto::buscar($nombre, $descripcion);
        $consulta = "INSERT INTO participantes_proyectos VALUES(0,?,?,'SCRUM MASTER')";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($id, $participante));
        } catch (\Throwable $th) {
        }

        CrudSprint::agregar($id);
    }

    public static function actualizar()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = $data["id"];
        $nombre = $data['nombre'];
        $descripcion = $data['descripcion'];
        $fechaInicio = $data['fechaInicio'];
        $fechaFin = $data['fechaFin'];
        $estado = $data['estado'];

        $consulta = "UPDATE proyectos SET nombre=?,descripcion=?,fechaInicio=?,fechaFin=?,estado=? WHERE id=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($nombre, $descripcion, $fechaInicio, $fechaFin, $estado, $id));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function eliminar()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = $data['id'];

        $consulta = "UPDATE proyectos set disponibilidad = 'no disponible' WHERE id=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($id));
            if ($resultado->rowCount() == 0) {
                echo "false";
            } else {
                echo "true";
            }
        } catch (\Throwable $th) {
            echo "false";
        }
    }
}
