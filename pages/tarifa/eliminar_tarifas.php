 <?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];





          if(isset($_REQUEST['id_tarifa']))
            {
              $id_tarifa=$_REQUEST['id_tarifa'];
            }
            else
            {
            $id_tarifa=$_POST['id_tarifa'];
          }




		///finzalizo encriptacion
  mysqli_query($con,"delete from tarifa where id_tarifa='$id_tarifa'")or die(mysqli_error());



			

	echo "<script type='text/javascript'>alert(' eliminado correctamente!');</script>";
	echo "<script>document.location='tarifas.php'</script>";	

	




   







?>
