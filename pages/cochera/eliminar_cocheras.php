 <?php
session_start();
include('../../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];






         if(isset($_REQUEST['id_espacios']))
            {
              $id_espacios=$_REQUEST['id_espacios'];
            }
            else
            {
            $id_espacios=$_POST['id_espacios'];
          }


		///finzalizo encriptacion
  mysqli_query($con,"delete from espacios where id_espacios='$id_espacios'")or die(mysqli_error());



			

	echo "<script type='text/javascript'>alert(' eliminado correctamente!');</script>";
	echo "<script>document.location='cocheras.php'</script>";	

	




   







?>
