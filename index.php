<?php
require_once 'controller/AccountController.php';

$data = json_decode(file_get_contents("php://input"), true);
