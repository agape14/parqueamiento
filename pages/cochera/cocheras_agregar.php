<?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'
//$nro_cochera = $_POST['nro_cochera'];

$medida       = mysqli_real_escape_string($con, '10x10');
$tipo_espacio = mysqli_real_escape_string($con, 'horizontal');
$nro_cocheras = 0;
$tot_cocheras = 501;
// $branch=$_SESSION['branch'];
$query1 = mysqli_query($con, "select * from espacios ") or die(mysqli_error());

while ($row1 = mysqli_fetch_array($query1)) {

    $nro_cocheras = $row1['numero'];
}
$nro_cocheras++;

for ($i = $nro_cocheras; $i < $tot_cocheras; $i++) {
    mysqli_query($con, "INSERT INTO espacios(numero,estado,codigo_entrada,medida,salida,tipo_espacio)
				VALUES('$i','disponible','','$medida','no','$tipo_espacio')") or die(mysqli_error($con));
    print_r('Nro Cochera: ' . $i);
}

//echo "<script>document.location='cocheras.php'</script>";
