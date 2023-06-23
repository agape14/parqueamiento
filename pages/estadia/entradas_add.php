 <?php
session_start();
include '../../dist/includes/dbcon.php';
date_default_timezone_set("America/Lima");
//$branch=$_SESSION['branch'];
if (isset($_REQUEST['id_espacios'])) {
    $id_espacios = mysqli_real_escape_string($con, $_REQUEST['id_espacios']);
} else {
    $id_espacios = mysqli_real_escape_string($con, $_POST['id_espacios']);
}
if (isset($_REQUEST['id_vehiculo'])) {
    $id_vehiculo = mysqli_real_escape_string($con, $_REQUEST['id_vehiculo']);
} else {
    $id_vehiculo = mysqli_real_escape_string($con, $_POST['id_vehiculo']);
}

$query1 = mysqli_query($con, "select * from vehiculo where id_vehiculo='$id_vehiculo' ") or die(mysqli_error());
$contve = mysqli_num_rows($query1);
$row1   = mysqli_fetch_array($query1);
$placa  = mysqli_real_escape_string($con, $row1['placa']);

$fechaactual = date('Y-m-d');
$year        = date("Y");
$cont        = 0;
$id_entrada  = 0;
$query3      = mysqli_query($con, "select max(id_entrada) id_entrada from entradas ") or die(mysqli_error());
$rowentrada  = mysqli_fetch_array($query3);
$id_entrada  = mysqli_real_escape_string($con, $rowentrada['id_entrada']);

$mes    = date("m");
$dia    = date("d");
$cont   = $id_entrada + 1;
$codigo = $year . $mes . $dia . $cont;

$hora_entrada = date("H:i:s");
$time_entrada = date("H");
$session_id   = $_SESSION['id'];
///finzalizo encriptacion
if (!empty($placa)) {
    if ($contve > 0) {
        mysqli_query($con, "update vehiculo set estado_vehiculo='ocupado'  where id_vehiculo='$id_vehiculo'") or die(mysqli_error());

        mysqli_query($con, "update espacios set estado='ocupado',codigo_entrada='$codigo',placa='$placa',fecha_ingreso='$fechaactual',hora_ingreso='$hora_entrada',salida='no',id_vehiculo='$id_vehiculo'  where id_espacios='$id_espacios' ") or die(mysqli_error());

        mysqli_query($con, "INSERT INTO entradas(codigo,fecha,hora_ingreso,hora_salida,vehiculo,lugar,dia_noche,time_entrada,time_salida,usuario_id)
        VALUES('$codigo','$fechaactual','$hora_entrada','','$id_vehiculo','$id_espacios','','$time_entrada','','$session_id')") or die(mysqli_error($con));
    }
}
//echo "<script type='text/javascript'>alert(' Espacio registrado!');</script>";
echo "<script>document.location='generar_ticket_entrada.php?codigo=$codigo'</script>";

?>
