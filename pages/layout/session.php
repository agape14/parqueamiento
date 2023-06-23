<?php include ('dbcon.php');
 @session_start();
//Check whether the session variable SESS_MEMBER_ID is present or not
if (!isset($_SESSION['id']) || (trim($_SESSION['id']) == '')) { ?>
<script>
window.location = "index.php";
</script>
<?php 
}
$session_id=$_SESSION['id'];

$user_query = mysqli_query($con,"select * from usuario where id = '$session_id'")or die(mysql_error());
$user_row = mysqli_fetch_array($user_query);
$user_username = $user_row['usuario'];
$nombre_user = $user_row['usuario'];
$imagen = $user_row['imagen'];
$id_usuario = $user_row['id'];

$tipo = $user_row['tipo'];
    $empresa_query = mysqli_query($con,"select * from empresa ")or die(mysql_error());
$empresa_row = mysqli_fetch_array($empresa_query);
$empresa = $empresa_row['empresa'];



$imagen_empresa = $empresa_row['imagen'];


$id=$_SESSION['id'];


date_default_timezone_set("America/Lima"); 



?>