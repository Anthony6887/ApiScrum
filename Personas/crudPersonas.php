<?php

include_once '../conexion.php';

class CrudPersona
{
    public static function listar()
    {

        $idProyecto = $_GET['idProyecto'];

        $consulta = "SELECT p.* FROM participantes_proyectos pp, personas p, proyectos pr WHERE proyecto = ? and pp.participante=p.cedula and pr.id=pp.proyecto";

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

    public static function obtenerRolProyecto()
    {
        $participante = $_GET['participante'];
        $idProyecto = $_GET['idProyecto'];

        $consulta = "SELECT rol FROM participantes_proyectos WHERE proyecto=? AND participante=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($idProyecto, $participante));
            $datos = $resultado->fetchColumn();
            echo json_encode($datos);
        } catch (\Throwable $th) {
            echo null;
        }
    }

    public static function buscar()
    {
        $cedula = $_GET['cedula'];
        $clave = $_GET['clave'];

        $consulta = "SELECT * FROM personas Where cedula=? and clave=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($cedula, $clave));
            $datos = $resultado->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($datos);
        } catch (\Throwable $th) {
            echo null;
        }
    }

    public static function buscarCedula($cedula)
    {
        $consulta = "SELECT Count(*) FROM personas WHERE cedula = ?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($cedula));

            $count = $resultado->fetchColumn();
            return $count !== 0;
        } catch (\Throwable $th) {
            error_log("Error in buscarCedula: " . $th->getMessage());
            return false;
        }
    }

    public static function insertar()
    {


        $cedula = $_POST['cedula'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $clave = $_POST['clave'];


        $existe = CrudPersona::buscarCedula($cedula);

        if ($existe) {
            echo "false";
            return;
        }

        $consulta = "INSERT INTO personas VALUES(?,?,?,?,?)";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($cedula, $nombre, $apellido, $fechaNacimiento, $clave));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }
    public static function agregar()
    {


        $cedula = $_POST['cedula'];
        $idProyecto = $_POST['idProyecto'];

        $existe = CrudPersona::buscarCedula($cedula);

        if (!$existe) {
            echo "false";
            return;
        }

        $consulta = "INSERT INTO participantes_proyectos VALUES(0,?,?,'DESARROLLADOR')";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($idProyecto, $cedula));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function actualizar()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $cedula = $data['cedula'];
        $nombre = $data['nombre'];
        $apellido = $data['apellido'];
        $fechaNacimiento = $data['fechaNacimiento'];
        $clave = $data['clave'];


        $consulta = "UPDATE personas SET nombre=?,apellido=?,clave=? WHERE cedula=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($nombre, $apellido, $clave, $cedula));
            echo "true";
        } catch (\Throwable $th) {
            echo "false";
        }
    }

    public static function eliminar()
    {
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);

        $cedula = $data['cedula'];

        $consulta = "DELETE FROM participantes_proyectos WHERE participante=?";

        try {
            $conexion = Conexion::Conectar();
            $resultado = $conexion->prepare($consulta);
            $resultado->execute(array($cedula));
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
