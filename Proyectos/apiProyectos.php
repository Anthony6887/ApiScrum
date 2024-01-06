<?php

include_once 'crudProyectos.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        CrudProyecto::listar();
        break;
    case 'POST':
        CrudProyecto::agregar();
        break;
    case 'PUT':
        CrudProyecto::actualizar();
        break;
    case 'DELETE':
        CrudProyecto::eliminar();
        break;
    default:
        echo "realice una petición válida";
        break;
}
