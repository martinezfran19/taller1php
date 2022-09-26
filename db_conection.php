<?php

try {
    $mbd = new PDO('mysql:host=localhost;dbname=banco', 'taller1', 'taller');
} catch (PDOException $e) {
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}

?>