 <?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'];
date_default_timezone_set("America/Lima");

$fechaactual = date('Y-m-d');
$id_espacios = $_GET['id_espacios'];

$query6 = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios' ") or die(mysqli_error());

while ($row6 = mysqli_fetch_array($query6)) {
    $codigo = $row6['codigo_entrada'];
    $placa  = $row6['placa'];
    $id_vehiculo  = $row6['id_vehiculo'];
}

$query32              = mysqli_query($con, "select * from entradas where vehiculo='$id_vehiculo' and date_format(fecha, '%Y-%m-%d') ='$fechaactual' ") or die(mysqli_error($con));

$contador         = mysqli_num_rows($query32);
if ($contador >0) {
	
$row32                = mysqli_fetch_array($query32);
$id_entrada           = $row32['id_entrada'];
$codigo               = $row32['codigo'];
$fecha                = $row32['fecha'];
$fecha_salida         = is_null($row32['fecha_salida']) ? date('Y-m-d', strtotime('14/10/1988')) : $row32['fecha_salida'];
$hora_ingreso         = $row32['hora_ingreso'];
$hora_salida          = $row32['hora_salida'];
$vehiculo             = $row32['vehiculo'];
$id_vehiculo          = $row32['vehiculo'];
$lugar                = $row32['lugar'];
$dia_noche            = $row32['dia_noche'];
$time_entrada         = $row32['time_entrada'];
$time_salida          = $row32['time_salida'];
$pago                 = $row32['pago'];
$facturacion_id       = is_null($row32['facturacion_id']) ? 0 : $row32['facturacion_id'];
$usuario_id           = $row32['usuario_id'];
$estado               = $row32['estado'];
$fec_registro         = is_null($row32['fec_registro']) ? date('Y-m-d', strtotime('14/10/1988')) : $row32['fec_registro'];
$usuario_id_anulacion = $_SESSION['id'];
$fec_anulacion        = date('Y-m-d H:i:s');

mysqli_query($con, "INSERT INTO  entradas_anulacion  (
	 id_entrada ,	 codigo ,	 fecha ,	 fecha_salida ,	 hora_ingreso ,
	 hora_salida ,	 vehiculo ,	 lugar ,	 dia_noche ,	 time_entrada ,
	 time_salida ,	 pago ,	 facturacion_id ,	 usuario_id ,	 estado ,
	 fec_registro ,	 usuario_id_anulacion ,	 fec_anulacion
)
VALUES
	(
		'$id_entrada',		'$codigo',		'$fecha',		'$fecha_salida',		'$hora_ingreso',
		'$hora_salida',		'$vehiculo',		'$lugar',		'$dia_noche',		'$time_entrada',
		'$time_salida',		'$pago',		'$facturacion_id',		'$usuario_id',		'$estado',
		'$fec_registro',		'$usuario_id_anulacion',		'$fec_anulacion'
	) ") or die(mysqli_error($con));
}
mysqli_query($con, "update vehiculo set estado_vehiculo='disponible'  where id_vehiculo='$id_vehiculo' ") or die(mysqli_error());

mysqli_query($con, "update espacios set estado='disponible',codigo_entrada=NULL,placa=NULL,fecha_ingreso=NULL,hora_ingreso=NULL,salida='no',id_vehiculo=NULL  where id_espacios='$id_espacios'") or die(mysqli_error());

mysqli_query($con, "DELETE FROM entradas where id_entrada='$id_entrada'  ") or die(mysqli_error($con));
//===========================================================================
echo "<script type='text/javascript'>alert('Se retorno correctamente, verificar');</script>";
echo "<script>document.location='estadia.php'</script>";

?>
