<?php

error_reporting(E_ALL ^ E_NOTICE);
// Permite la conexion desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permite la ejecucion de los metodos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// Se incluye el archivo que contiene la clase generica
require_once('config_cpe.php');
require_once('../funcionesGlobales/validaciones.php');

//$array = explode("/", $_SERVER['REQUEST_URI']);
$bodyRequest = file_get_contents("php://input");

$jsonData = $bodyRequest;
$resultado = StatusFacturaIntegrada($jsonData);

print_json($resultado);

function print_json($data) {
    header("HTTP/1.1");
    header("Content-Type: application/json; charset=UTF-8");
    echo json_encode($data, JSON_PRETTY_PRINT);
}

?>