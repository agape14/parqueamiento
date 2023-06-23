<?php

error_reporting(E_ALL ^ E_NOTICE);
// Permite la conexion desde cualquier origen
header("Access-Control-Allow-Origin: *");
// Permite la ejecucion de los metodos
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");

header("HTTP/1.1");
header("Content-Type: application/json; charset=UTF-8");

require_once "../api_cpe/status_cdr.php";
$revisar = new Revisar();

$bodyRequest = file_get_contents("php://input");
$variables = json_decode($bodyRequest, true);

$tipo_comprobante = isset($variables["tipo_comprobante"]) ? $variables["tipo_comprobante"] : "";
$serie = isset($variables["serie"]) ? $variables["serie"] : "";
$numero = isset($variables["numero"]) ? $variables["numero"] : "";
$ruc = isset($variables["ruc"]) ? $variables["ruc"] : "";
$usuario_sol = isset($variables["usuario_sol"]) ? $variables["usuario_sol"] : "";
$pass_sol = isset($variables["pass_sol"]) ? $variables["pass_sol"] : "";
$ruta_cdr = isset($variables["ruta_cdr"]) ? $variables["ruta_cdr"] : "";
//$archivo = isset($variables["archivo"]) ? $variables["archivo"] : "";

switch ($variables["op"]) {
    case 'revisardoc':  
        $revisar->statusCdrFactura($tipo_comprobante, $serie, $numero, $ruc, $usuario_sol, $pass_sol, $ruta_cdr);
        break;
}
?>