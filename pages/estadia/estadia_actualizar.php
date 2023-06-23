<?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'];
date_default_timezone_set("America/Lima");
$id_espacios_nuevo   = $_POST['espacio'];
$placa               = $_POST['placa'];
$id_espacios_antiguo = $_POST['id_espacios'];
$codigo_entrada      = $_POST['codigo_entrada'];

$query1 = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios_nuevo' ") or die(mysqli_error());

while ($row1 = mysqli_fetch_array($query1)) {

    $estado = $row1['estado'];

}

if ($estado == 'ocupado') {
    echo "<script type='text/javascript'>alert('El espacio ya esta ocupado seleccione otro!');</script>";
    echo "<script>document.location='modificar_estadia.php?id_espacios=$id_espacios_antiguo'</script>";
}
if ($estado == 'disponible') {

    mysqli_query($con, "update espacios set placa='',estado='disponible',salida='no',hora_ingreso='',fecha_ingreso='',codigo_entrada='' where  id_espacios='$id_espacios_antiguo' ") or die(mysqli_error());

    $query1 = mysqli_query($con, "select * from entradas where codigo='$codigo_entrada' ") or die(mysqli_error());

    while ($row1 = mysqli_fetch_array($query1)) {
        $fecha_ingreso = $row1['fecha'];
        $hora_ingreso  = $row1['hora_ingreso'];

    }

    mysqli_query($con, "update espacios set placa='$placa',estado='ocupado',hora_ingreso='$hora_ingreso',fecha_ingreso='$fecha_ingreso',codigo_entrada='$codigo_entrada' where  id_espacios='$id_espacios_nuevo' ") or die(mysqli_error());

    echo "<script type='text/javascript'>alert('Se cambio correctamente!');</script>";
    echo "<script>document.location='estadia.php'</script>";
}
