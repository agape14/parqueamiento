 <?php
session_start();
include('../../dist/includes/dbcon.php'); //$branch=$_SESSION['branch'];
	//$branch=$_SESSION['branch'];





          if(isset($_REQUEST['id_gastos']))
            {
              $id_gastos=$_REQUEST['id_gastos'];
            }
            else
            {
            $id_gastos=$_POST['id_gastos'];
          }




		///finzalizo encriptacion
  mysqli_query($con,"delete from gastos where id_gastos='$id_gastos'")or die(mysqli_error());



			

	echo "<script type='text/javascript'>alert(' eliminado correctamente!');</script>";
	echo "<script>document.location='gastos.php'</script>";	

	




   







?>
