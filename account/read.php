<?php
include '../db_conection.php';

try {  
    $id = $_GET["id"];

    $statement=$mbd->prepare("SELECT * from cuenta WHERE id = ?");
    $statement->bindParam(1, $id);
    $statement->execute();

    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $idPersona = $results[0]['idPersona'];
    $statement=$mbd->prepare("SELECT * from persona WHERE id = ?");
    $statement->bindParam(1, $idPersona);
    $statement->execute();

    $results2 = $statement->fetchAll(PDO::FETCH_ASSOC);
    $results [0]['data_fk'] = $results2;
    
    $mbd = null;

    header('Content-type:application/json;charset=utf-8');
    echo json_encode([
        $results[0]
    ]);

} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
