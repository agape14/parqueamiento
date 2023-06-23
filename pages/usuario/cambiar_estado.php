 <?php
session_start();
include('../dist/includes/dbcon.php');
	//$branch=$_SESSION['branch'];





          if(isset($_REQUEST['estado']))
            {
              $estado=$_REQUEST['estado'];
            }
            else
            {
            $estado=$_POST['estado'];
          }

          if(isset($_REQUEST['id']))
            {
              $id=$_REQUEST['id'];
            }
            else
            {
            $id=$_POST['id'];
          }
          $estate="";
if ($estado=="activo") {
    $estate="desactivado";
}
if ($estado=="desactivado") {
    $estate="activo";
}
		///finzalizo encriptacion

  mysqli_query($con,"update usuario set estado='$estate' where id='$id'")or die(mysqli_error());

  echo "<script type='text/javascript'>alert(' se cambiar de estado correctamente a $estate !');</script>";
  echo "<script>document.location='usuario.php'</script>";  

	




   







?>
