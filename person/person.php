<?php
include '../db_conection.php';

$data = json_decode(file_get_contents("php://input"), true);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    try {
        $identificacion = $data['identificacion'];
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];
    
        $statement = $mbd->prepare("INSERT INTO persona (identificacion, nombres, apellidos) VALUES (?,?,?)");
    
        $statement->bindParam(1, $identificacion);
        $statement->bindParam(2, $nombres);
        $statement->bindParam(3, $apellidos);
    
        $statement->execute();
    
        header('Content-type:application/json;charset=utf-8');
        echo json_encode([
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
}
else if($_SERVER['REQUEST_METHOD'] == 'GET'){
    try {    
        $statement=$mbd->prepare("SELECT * from persona");
        $statement->execute();
    
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
    
        $mbd = null;
        
        header('Content-type:application/json;charset=utf-8');
        echo json_encode($results);
    
    } catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
