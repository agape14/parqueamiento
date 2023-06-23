 <?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'];

$numero      = mysqli_real_escape_string($con, $_POST['nro_cochera']);
$medida      = mysqli_real_escape_string($con, $_POST['medida']);
$id_espacios = mysqli_real_escape_string($con, $_POST['id_espacios']);

$tipo_espacio = $_POST['tipo_espacio'];

///finzalizo encriptacion

mysqli_query($con, "update espacios set numero='$numero',medida='$medida',tipo_espacio='$tipo_espacio'  where id_espacios='$id_espacios'") or die(mysqli_error());

echo "<script type='text/javascript'>alert(' actualizado correctamente!');</script>";
echo "<script>document.location='cocheras.php'</script>";

?>
