<?php

class TareasSprint{
    function asignarTareaSprint($idTarea,$idSprint){

        if(buscarTareaSprint($idTarea) == 0){
            $consulta = "INSERT INTO tareas_sprint VALUES(0,?,?)";
            try {
                $conexion = Conexion::Conectar();
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array($idTarea,$idSprint));
                echo "true";
            } catch (\Throwable $th) {
                echo "false";
            }
        }else{
            $consulta = "UPDATE tareas_sprint set id_sprint=? WHERE id_tarea=?";
            try {
                $conexion = Conexion::Conectar();
                $resultado = $conexion->prepare($consulta);
                $resultado->execute(array($idSprint,$idTarea));
                echo "true";
            } catch (\Throwable $th) {
                echo "false";
            }
        }


    }

    function buscarTareaSprint($idTarea){
        $consulta = "SELECT Count(*) cantidad From tareas_sprint";
        $conexion = Conexion::Conectar();
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(array($idTarea));
        return $resultado['cantidad'];
    }
}

?>