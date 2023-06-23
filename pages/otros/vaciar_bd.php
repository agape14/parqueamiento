<?php session_start();
if (empty($_SESSION['id'])):
    header('Location:../index.php');
endif;

include '../../dist/includes/dbcon.php';
/*
mysqli_query($con, "delete from caja ") or die(mysqli_error());
mysqli_query($con, "delete from clientes  ") or die(mysqli_error());
mysqli_query($con, "delete from entradas  ") or die(mysqli_error());
mysqli_query($con, "delete from espacios    ") or die(mysqli_error());
mysqli_query($con, "delete from gastos   ") or die(mysqli_error());
mysqli_query($con, "delete from reserva     ") or die(mysqli_error());
mysqli_query($con, "delete from tarifa   ") or die(mysqli_error());
mysqli_query($con, "delete from tipo_vehiculo   ") or die(mysqli_error());
mysqli_query($con, "delete from vehiculo  ") or die(mysqli_error());

mysqli_query($con, "delete from facturacion_det ") or die(mysqli_error());
mysqli_query($con, "delete from facturacion_cab  ") or die(mysqli_error());
 */
echo "<script>document.location='../layout/inicio.php'</script>";
