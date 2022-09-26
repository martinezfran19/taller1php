<?php
include '../db_conection.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $idPersona = $data["idPersona"];
        $tipoCuenta = $data["tipoCuenta"];
        $numeroCuenta = $data["numeroCuenta"];
        $ultimoMovimiento = $data["ultimoMovimiento"];
        $fechaRegistro = $data["fechaRegistro"];
        $codigoSeguridad = $data["codigoSeguridad"];
        $saldoDisponible = $data["saldoDisponible"];
        $email = $data["email"];

        $statement = $mbd->prepare("INSERT INTO cuenta (idPersona, tipoCuenta, numeroCuenta, ultimoMovimiento, fechaRegistro, codigoSeguridad, saldoDisponible, email) VALUES (?,?,?,?,?,?,?,?)");

        $statement->bindParam(1, $idPersona);
        $statement->bindParam(2, $tipoCuenta);
        $statement->bindParam(3, $numeroCuenta);
        $statement->bindParam(4, $ultimoMovimiento);
        $statement->bindParam(5, $fechaRegistro);
        $statement->bindParam(6, $codigoSeguridad);
        $statement->bindParam(7, $saldoDisponible);
        $statement->bindParam(8, $email);

        $statement->execute();

        $statement = $mbd->prepare("SELECT * from persona WHERE id = ?");
        $statement->bindParam(1, $idPersona);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $data['data_fk'] = $results;

        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
             $data
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
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $statement = $mbd->prepare("SELECT * from cuenta");
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $statement = $mbd->prepare("SELECT * from persona WHERE id = ?");
        for ($i = 0; $i < count($results); $i++) {
            $idPersona = $results[$i]['idPersona'];
            $statement->bindParam(1, $idPersona);
            $statement->execute();

            $results2 = $statement->fetchAll(PDO::FETCH_ASSOC);
            $results[$i]['data_fk'] = $results2;
        }

        $mbd = null;

        header('Content-type:application/json;charset=utf-8');
        echo json_encode($results);
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
