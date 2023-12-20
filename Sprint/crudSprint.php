<?php

include_once 'conexion.php';

class CrudPersona{
    public static function listar(){
        $idProyecto = $_GET['idProyecto'];

        $consulta = "SELECT * FROM sprints Where id_pro_per=?";

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

    public static function agregar(){
        $numeroSprint= $_POST['numeroSprint'];
        $fechaLimite = $_POST['fechaLimite'];
        $idProyecto = $_POST['idProyecto'];

        $consulta = "INSERT INTO sprints VALUES(0,?,?,?)";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($numeroSprint,$fechaLimite,$idProyecto));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function actualizar(){
        $idSprint = $_GET['idSprint'];
        $numeroSprint= $_GET['numeroSprint'];
        $fechaLimite = $_GET['fechaLimite'];

        $consulta = "UPDATE sprints SET numero_sprint=?,fecha_limite=? WHERE id_sprint=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($numeroSprint,$fechaLimite,$idSprint));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function eliminar(){
        $id= $_GET['idSprint'];

        $consulta = "DELETE FROM sprints WHERE id_sprint=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($id));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }
}

?>