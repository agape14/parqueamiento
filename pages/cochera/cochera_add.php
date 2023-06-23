<?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'
$nro_cochera  = mysqli_real_escape_string($con, $_POST['nro_cochera']);
$medida       = mysqli_real_escape_string($con, $_POST['medida']);
$tipo_espacio = mysqli_real_escape_string($con, $_POST['tipo_espacio']);

mysqli_query($con, "INSERT INTO espacios(numero,estado,codigo_entrada,medida,salida,tipo_espacio)
				VALUES('$nro_cochera','disponible','','$medida','no','$tipo_espacio')") or die(mysqli_error($con));

echo "<script>document.location='cocheras.php'</script>";
