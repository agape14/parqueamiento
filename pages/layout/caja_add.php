<?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'
	$monto = $_POST['monto'];



         $idempleado=$_SESSION['id']; 


     $fecha_apertura = date('Y-m-d');











		mysqli_query($con,"INSERT INTO caja(estado,monto,fecha_apertura,fecha_cierre)
				VALUES('abierto','$monto','$fecha_apertura',null)")or die(mysqli_error($con));
	echo "<script>document.location='caja.php'</script>";	










	
?>
