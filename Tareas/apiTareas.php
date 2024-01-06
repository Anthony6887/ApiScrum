<?php

include_once 'crudTareas.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        crudTareas::listar();
        break;
    case 'POST':
        crudTareas::agregar();
        break;
    case 'PUT':
        if (isset($_GET['progreso'])) {
            crudTareas::actualizarProgreso();
        } else {
            crudTareas::actualizarFinalizar();
        }
        break;
    case 'DELETE':
        crudTareas::eliminar();
        break;
    default:
        echo "realice una petición válida";
        break;
}
