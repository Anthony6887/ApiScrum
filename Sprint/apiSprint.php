<?php

include_once 'crudSprint.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
            CrudSprint::listar();
        break;
        case 'POST':
            CrudSprint::agregar();
            break;
            case 'PUT':
                CrudSprint::actualizar();
                break;
                case 'DELETE':
                    CrudSprint::eliminar();
                    break;
    default:
        echo "realice una petición válida";
        break;
}

?>