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

$id_cliente = $_POST['id_cliente'];



mysqli_query($con,"update vehiculo set placa='$placa',tipo='$tipo',modelo='$modelo',marca='$marca',color='$color',id_cliente='$id_cliente' where id_vehiculo='$id_vehiculo'")or die(mysqli_error());

			
			echo "<script>document.location='cliente.php'</script>";
	
	












		


?>
