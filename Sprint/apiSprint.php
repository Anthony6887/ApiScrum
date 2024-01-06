<?php

include_once 'crudSprint.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        CrudSprint::listar($_GET['idProyecto']);
        break;
    case 'POST':
        CrudSprint::agregar($_POST['idProyecto']);
        break;
    case 'DELETE':
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        $id = $data['idProyecto'];
        CrudSprint::eliminar($id);
        break;
    default:
        echo "realice una petición válida";
        break;
}
