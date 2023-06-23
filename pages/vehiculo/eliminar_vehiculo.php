<?php session_start();
if(empty($_SESSION['id'])):
header('Location:../index.php');
endif;

include('../../dist/includes/dbcon.php');


          if(isset($_REQUEST['id_vehiculo']))
            {
              $id_vehiculo=$_REQUEST['id_vehiculo'];
            }
            else
            {
            $id_vehiculo=$_POST['id_vehiculo'];
          }



  mysqli_query($con,"delete from vehiculo where id_vehiculo='$id_vehiculo'")or die(mysqli_error());
  
  echo "<script type='text/javascript'>alert('Eliminado correctamente!');</script>";
  echo "<script>document.location='vehiculo.php'</script>";  
  
?>