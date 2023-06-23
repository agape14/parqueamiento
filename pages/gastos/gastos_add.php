<?php
session_start();
include '../../dist/includes/dbcon.php'; //$branch=$_SESSION['branch'];
//$branch=$_SESSION['branch'
$cantidad    = $_POST['cantidad'];
$descripcion = $_POST['descripcion'];

$fecha = date('Y-m-d');

/*

$caja_cont=0;

$caja_query=mysqli_query($con,"select * from caja where estado='abierto' ")or die(mysqli_error());
$i=0;
while($row_caja=mysqli_fetch_array($caja_query)){
$caja_cont=$row_caja['monto'];

}

$caja_cont=$cantidad+$caja_cont;
mysqli_query($con,"update caja set monto='$caja_cont'  where estado='abierto'")or die(mysqli_error());
 */

mysqli_query($con, "INSERT INTO gastos(descripcion,cantidad,fecha)
				VALUES('$descripcion','$cantidad','$fecha')") or die(mysqli_error($con));
echo "<script>document.location='gastos.php'</script>";
