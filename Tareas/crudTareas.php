<?php

include_once '../conexion.php';

class crudTareas{
    public static function listar(){
        $consulta = "SELECT * FROM tareas Where proyecto=?";
        $proyecto= $_GET['proyecto'];
        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($proyecto));
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($datos);
        } catch (\Throwable $th) {
            echo null;
        }

    }

    public static function agregar(){
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $idProyecto = $_POST['proyecto'];

        $consulta = "INSERT INTO tareas VALUES(0,?,?,'','PENDIENTE',?)";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($nombre,$descripcion,$idProyecto));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function actualizarProgreso(){
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $idTarea = $data["idTarea"];
        $encargado = $data['encargado'];
        $estado = 'EN PROGRESO';

        $consulta = "UPDATE tareas SET encargado=?,estado=? WHERE id=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($encargado,$estado,$idTarea));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function actualizarFinalizar(){
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $idTarea = $data["idTarea"];
        $estado = 'FINALIZADO';

        $consulta = "UPDATE tareas SET estado=? WHERE id=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($estado,$idTarea));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function eliminar(){
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $id = $data['idTarea'];

        $consulta = "DELETE FROM tareas WHERE id=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($id));
            if ($resultado->rowCount() == 0){
                echo "false";
            }else{
                echo "true";
            }
        } catch (\Throwable $th) {
            echo "false";
        }
    }
}

?>