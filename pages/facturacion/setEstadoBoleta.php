<?php
session_start();
include '../../dist/includes/dbcon.php';
date_default_timezone_set("America/Lima");
$idboleta = $_POST['idboleta'];
//$tipo == '01' FACTURAS
//$tipo == '03' BOLETAS

mysqli_query($con, "UPDATE facturacion_cab SET facturacion_estado=2 WHERE facturacion_id='$idboleta' ") or die(mysqli_error($con));

$return_arr[] = array(
    "success" => 1,
    "data"    => $idboleta,
    "msg"     => 'Se actualizo correctamente el estado');
echo json_encode($return_arr);
