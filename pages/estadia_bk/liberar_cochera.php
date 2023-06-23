<?php session_start();
if (empty($_SESSION['id'])):
    header('Location:../index.php');
endif;
date_default_timezone_set("America/Lima");
include '../../dist/includes/dbcon.php';

if (isset($_REQUEST['id_espacios'])) {
    $id_espacios = $_REQUEST['id_espacios'];
} else {
    $id_espacios = $_POST['id_espacios'];
}
$id_entrada = 0;
if (isset($_REQUEST['id_entrada'])) {
    $id_entrada = $_REQUEST['id_entrada'];
} else {
    $id_entrada = $_POST['id_entrada'];
}
//print_r($id_espacios);return;
if (intval($id_entrada) == 0) {
    mysqli_query($con, "update espacios set
	estado='disponible',
	salida='no',
	placa=null,
	hora_ingreso=null,
	fecha_ingreso=null,
	codigo_entrada=null
	where id_espacios='$id_espacios' ") or die(mysqli_error($con));

    echo "<script type='text/javascript'>alert('se libero correctamente!');</script>";
    echo "<script>document.location='estadia.php'</script>";
} else {
    mysqli_query($con, "update espacios set
	estado='disponible',
	salida='no',
	placa=null,
	hora_ingreso=null,
	fecha_ingreso=null,
	codigo_entrada=null
	where id_espacios='$id_espacios' ") or die(mysqli_error($con));
    echo "<script>document.location='../facturacion/ver_datos_facturacion.php?id_entrada=$id_entrada'</script>";
}
