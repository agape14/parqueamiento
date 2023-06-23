<?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];

	$placa = $_POST['placa'];
	$tipo = $_POST['tipo'];
		$marca = $_POST['marca'];

$modelo = $_POST['modelo'];
$color = $_POST['color'];
$id_cliente = $_POST['id_cliente'];

		
	
	$query2=mysqli_query($con,"select * from vehiculo where TRIM(UPPER(placa))=TRIM(UPPER( '$placa')) ")or die(mysqli_error($con));
	$count=mysqli_num_rows($query2);

	if ($count>0)
	{
			echo "<script type='text/javascript'>alert('placa ya existe!');</script>";
			echo "<script>document.location='vehiculo.php'</script>";
	}
	else
	{




		mysqli_query($con,"INSERT INTO vehiculo(placa,tipo,marca,modelo,color,id_cliente,estado_vehiculo)
		VALUES(TRIM(UPPER( '$placa')),'$tipo','$marca','$modelo','$color','$id_cliente','disponible')")or die(mysqli_error($con));

		echo "<script>document.location='vehiculo.php'</script>";
	}





?>
