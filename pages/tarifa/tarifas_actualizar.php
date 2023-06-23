 <?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];

	$tipo_vehiculo = $_POST['tipo_vehiculo'];
	$valor_hora = $_POST['valor_hora'];
	$valor_noche = $_POST['valor_noche'];


	$id_tarifa = $_POST['id_tarifa'];

$valor_mes = $_POST['valor_mes'];

		///finzalizo encriptacion


	mysqli_query($con,"update tarifa set tipo_vehiculo='$tipo_vehiculo',valor_hora='$valor_hora',valor_noche='$valor_noche',valor_mes='$valor_mes'  where id_tarifa='$id_tarifa'")or die(mysqli_error());

			

	echo "<script type='text/javascript'>alert(' actualizado correctamente!');</script>";
	echo "<script>document.location='tarifas.php'</script>";	

	




   







?>
