<?php
header("Access-Control-Allow-Origin: *");

include_once 'crudPersonas.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        if(isset($_GET['cedula'])){
            CrudPersona::buscar();
        }else{
            CrudPersona::listar();
        }
        break;
        case 'POST':
            if(isset($_POST['insertar'])){
                CrudPersona::insertar();
            }else{
                CrudPersona::agregar();
            }
            break;
            case 'PUT':
                CrudPersona::actualizar();
                break;
                case 'DELETE':
                    CrudPersona::eliminar();
                    break;
    default:
        echo "realice una petición válida";
        break;
}

?>