<?php
require_once 'controller/accountController.php';

$data = json_decode(file_get_contents("php://input"), true);

$person = new AccountController();

echo($person->store($data));
