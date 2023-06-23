<?php
session_start();
include '../../dist/includes/dbcon.php';
date_default_timezone_set("America/Lima");
$tipo = $_POST['tipo'];
//$tipo == '01' FACTURAS
//$tipo == '03' BOLETAS

$query2         = mysqli_query($con, "SELECT * FROM config_facturacion WHERE codDoc='$tipo' ") or die(mysqli_error($con));
$count          = mysqli_num_rows($query2);
$row32          = mysqli_fetch_array($query2);
$serieDoc       = $row32['serieDoc'];
$correlativo    = $row32['correlativo'];
$numeroConCeros = str_pad($correlativo + 1, 8, "0", STR_PAD_LEFT);
$return_arr[]   = array(
    "serieDoc"    => $serieDoc,
    "correlativo" => $numeroConCeros,
    "total"       => $count);
echo json_encode($return_arr);
