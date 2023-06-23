<?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];

	$nombre_tipo = $_POST['nombre_tipo'];
	$valor_hora = $_POST['valor_hora'];
		$valor_noche = $_POST['valor_noche'];

$valor_mes = $_POST['valor_mes'];



			mysqli_query($con,"INSERT INTO tarifa(valor_hora,valor_noche,valor_mes,tipo_vehiculo)
				VALUES('$valor_hora','$valor_noche','$valor_mes','$nombre_tipo')")or die(mysqli_error($con));

			
			echo "<script>document.location='tarifas.php'</script>";


	

	
?>	
