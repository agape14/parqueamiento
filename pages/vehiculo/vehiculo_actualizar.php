<?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];
$placa = $_POST['placa'];
	$tipo = $_POST['tipo'];
	$id_vehiculo = $_POST['id_vehiculo'];
$modelo = $_POST['modelo'];
$marca = $_POST['marca'];

$color = $_POST['color'];
$estado = $_POST['estado'];


	/*    $query2=mysqli_query($con,"select * from clientes where dni ='$dni' ")or die(mysqli_error());
    $i=1;
    while($row2=mysqli_fetch_array($query2)){
    	$id_cliente=$row2['id_cliente'];
    }
*/

mysqli_query($con,"update vehiculo set placa=TRIM(UPPER( '$placa')),tipo='$tipo',modelo='$modelo',marca='$marca',color='$color',estado_vehiculo=TRIM('$estado')  where id_vehiculo='$id_vehiculo'")or die(mysqli_error());

			
			echo "<script>document.location='vehiculo.php'</script>";
	
	












		


?>
