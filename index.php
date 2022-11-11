<?php
require_once 'controller/accountController.php';
require_once 'controller/personController.php';

$ruta = explode("/", $_SERVER['REQUEST_URI']);

//Si la ruta es muy corta y no especifica ningun endpoint
if (sizeof($ruta) <= 2) {
    echo sizeof($ruta);
} else {
    //Si la subruta es person
    if (hash_equals("person", $ruta[2])) {
        $person = new PersonController();
        //Se asegura que la ruta contenga un endpoint
        if (sizeof($ruta) > 2) {
            //endpoint para listar todas las personas registradas en la base de datos
            if (hash_equals("getAll", $ruta[3]) || hash_equals("", $ruta[3])) {
                echo ($person->list());
            } 
            //endpoint para registrar una nueva persona (Recibe datos por POST)
            else if (hash_equals("store", $ruta[3])) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo ($person->store($data));
            } 
             //endpoint para actualizar los datos de una persona (Recibe datos por POST)
             else if (hash_equals("update", $ruta[3])) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo ($person->update($data));
            } 
             //endpoint para eliminar una persona (Recibe el id por POST)
             else if (hash_equals("delete", $ruta[3])) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo ($person->delete($data));
            } 
             //endpoint para buscar una persona por su id (Recibe el id por GET)
             else if (isset($_GET['id'])) {//si se recibe el id
                if (hash_equals("getPerson?id=" . $_GET['id'], $ruta[3])) {
                    //captura de errores por si el campo id trae un valor no valido
                    try {
                        echo ($person->getPerson($_GET['id']));
                    } catch (\Throwable $th) {
                        echo "Ocurrió un error con el id";
                    }
                }
            } else {
                echo "Enpoint no valido";
            }
        }
    } else if (hash_equals("account", $ruta[2])) {
        $account = new AccountController();
        //Se asegura que la ruta contenga un endpoint
        if (sizeof($ruta) > 2) {
            //endpoint para listar todas las cuentas registradas en la base de datos
            if (hash_equals("getAll", $ruta[3]) || hash_equals("", $ruta[3])) {
                echo ($account->list());
            } 
            //endpoint para registrar una nueva cuenta (Recibe datos por POST)
            else if (hash_equals("store", $ruta[3])) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo ($account->store($data));
            } 
             //endpoint para actualizar los datos de una cuenta (Recibe datos por POST)
             else if (hash_equals("update", $ruta[3])) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo ($account->update($data));
            } 
             //endpoint para eliminar una cuenta (Recibe el id por POST)
             else if (hash_equals("delete", $ruta[3])) {
                $data = json_decode(file_get_contents("php://input"), true);
                echo ($account->delete($data));
            } 
             //endpoint para buscar una cuenta por su id (Recibe el id por GET)
             else if (isset($_GET['id'])) {//si se recibe el id
                if (hash_equals("getAccount?id=" . $_GET['id'], $ruta[3])) {
                    //captura de errores por si el campo id trae un valor no valido
                    try {
                        echo ($account->getAccount($_GET['id']));
                    } catch (\Throwable $th) {
                        echo "Ocurrió un error con el id";
                    }
                }
            } else {
                echo "Enpoint no valido";
            }
        }
    }
}
