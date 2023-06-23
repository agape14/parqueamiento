 <?php
session_start();
include('../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];

	$id_gastos = $_POST['id_gastos'];
		$cantidad = $_POST['cantidad'];
	$descripcion = $_POST['descripcion'];





		///finzalizo encriptacion


	mysqli_query($con,"update gastos set cantidad='$cantidad',descripcion='$descripcion'  where id_gastos='$id_gastos'")or die(mysqli_error());

			

	echo "<script type='text/javascript'>alert(' actualizado correctamente!');</script>";
	echo "<script>document.location='gastos_informe.php'</script>";	

	




   







?>
