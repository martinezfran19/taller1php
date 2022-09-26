<?php
include '../db_conection.php';

$data = json_decode(file_get_contents("php://input"), true);
try {
    $id = $data['id'];

    $statement = $mbd->prepare("SELECT * from cuenta WHERE id = ?");
    $statement -> bindParam(1, $id);
    $statement -> execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $idPersona = $result[0]['idPersona'];
    $statement = $mbd->prepare("SELECT * from persona WHERE id = ?");
    $statement -> bindParam(1, $id);
    $statement -> execute();
    $result2 = $statement->fetchAll(PDO::FETCH_ASSOC);

    $result[0]['data_fk'] = $result2[0];

    $statement = $mbd->prepare("DELETE FROM cuenta WHERE id = ?");
    $statement->bindParam(1, $id);
    $statement->execute();

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro eliminado correctamente",
        'persona' => $result
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