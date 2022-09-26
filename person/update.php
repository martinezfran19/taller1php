<?php
include '../db_conection.php';

$data = json_decode(file_get_contents("php://input"), true);
try {
    $identificacion = $data['identificacion'];
    $nombres = $data['nombres'];
    $apellidos = $data['apellidos'];
    $id = $data['id'];

    $statement = $mbd->prepare("UPDATE persona SET identificacion = ?, nombres = ?, apellidos = ? WHERE id = ?");

    $statement->bindParam(1, $identificacion);
    $statement->bindParam(2, $nombres);
    $statement->bindParam(3, $apellidos);
    $statement->bindParam(4, $id);

    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro actualizado correctamente",
        'persona' => $data
    ]);
} catch (PDOException $e) {
    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'error' => [
            'codigo' => $e->getCode(),
            'mensaje' => $e->getMessage()
        ]
    ]);
}
