<?php
include '../db_conection.php';

$data = json_decode(file_get_contents("php://input"), true);

try {

    $idPersona = $data["idPersona"];
    $tipoCuenta = $data["tipoCuenta"];
    $numeroCuenta = $data["numeroCuenta"];
    $ultimoMovimiento = $data["ultimoMovimiento"];
    $fechaRegistro = $data["fechaRegistro"];
    $codigoSeguridad = $data["codigoSeguridad"];
    $saldoDisponible = $data["saldoDisponible"];
    $email = $data["email"];
    $id = $data["id"];

    $statement = $mbd->prepare("UPDATE cuenta SET idPersona = ?, tipoCuenta = ?, numeroCuenta = ?, ultimoMovimiento = ?, fechaRegistro = ?, codigoSeguridad = ?, saldoDisponible = ?, email = ? WHERE id = ?");

    $statement->bindParam(1, $idPersona);
    $statement->bindParam(2, $tipoCuenta);
    $statement->bindParam(3, $numeroCuenta);
    $statement->bindParam(4, $ultimoMovimiento);
    $statement->bindParam(5, $fechaRegistro);
    $statement->bindParam(6, $codigoSeguridad);
    $statement->bindParam(7, $saldoDisponible);
    $statement->bindParam(8, $email);
    $statement->bindParam(9, $id);

    $statement->execute();

    $statement = $mbd->prepare("SELECT * from persona WHERE id = ?");
    $statement->bindParam(1, $idPersona);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $data['data_fk'] = $results;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        'mensaje' => "Registro actualizado correctamente",
        'cuenta' => $data
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
