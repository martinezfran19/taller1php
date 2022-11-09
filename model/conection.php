<?php

class Conection
{
    public static function conect()
    {
        $host = "localhost";
        $dbName = "banco";
        $user = "root";
        $password = "";
        
        try {
            return new PDO("mysql:host={$host};dbname={$dbName}", "{$user}", "{$password}");
        } catch (PDOException $e) {
            print "¡Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
