 <?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'];
date_default_timezone_set("America/Lima");

$fechaactual = date('Y-m-d');
$dia_noche   = $_POST['dia_noche'];
$id_espacios = $_POST['id_espacios'];
$diferencia  = 0;
mysqli_query($con, "update espacios set salida='si'  where id_espacios='$id_espacios'  ") or die(mysqli_error());

$query6 = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios' ") or die(mysqli_error());

while ($row6 = mysqli_fetch_array($query6)) {

    $codigo = $row6['codigo_entrada'];
    $placa  = $row6['placa'];
}
$query7 = mysqli_query($con, "select * from vehiculo where placa='$placa' ") or die(mysqli_error());

while ($row7 = mysqli_fetch_array($query7)) {

    $tipo = $row7['tipo'];
}

$query32      = mysqli_query($con, "select * from entradas where codigo='$codigo' ") or die(mysqli_error($con));
$time_entrada = $row32['time_entrada'];

$hora_salida   = date("H:i:s");
$time_salida_f = 0;
if ($time_entrada != date("H")) {
    if (date("i") >= 1) {
        $time_salida_f = date("H") + 1;
    } else {
        $time_salida_f = date("H");
    }
} else { $time_salida_f = 1;}

mysqli_query($con, "update entradas set hora_salida='$hora_salida',time_salida='$time_salida_f',dia_noche='$dia_noche',fecha_salida='$fechaactual'  where codigo='$codigo'  ") or die(mysqli_error());

$query6 = mysqli_query($con, "select * from entradas where codigo='$codigo' ") or die(mysqli_error());
$i      = 1;
while ($row6 = mysqli_fetch_array($query6)) {
    $fecha_ingreso = $row6['fecha'];
    $fecha_salida  = $row6['fecha_salida'];

}

$fecha1     = new DateTime($fecha_ingreso);
$fecha2     = new DateTime($fecha_salida);
$diff       = $fecha1->diff($fecha2);
$diferencia = $diff->days;
if ($diff->days > 0 and $dia_noche == "por_hora") {
    $dia_noche = "por_noche";
    mysqli_query($con, "update entradas set dia_noche='$dia_noche'  where codigo='$codigo'  ") or die(mysqli_error());
    echo "<script type='text/javascript'>alert('El vehiculo paso mas de 1 dias asi que se cobrara por noche !');</script>";
}

$caja_cont = 0;

$caja_query = mysqli_query($con, "select * from caja where estado='abierto' ") or die(mysqli_error());
$i          = 0;
while ($row_caja = mysqli_fetch_array($caja_query)) {
    $caja_cont = $row_caja['monto'];

}

$query31 = mysqli_query($con, "select * from tarifa where id_tarifa='$tipo'") or die(mysqli_error());

while ($row31 = mysqli_fetch_array($query31)) {
    $valor_hora  = $row31['valor_hora'];
    $valor_noche = $row31['valor_noche'];
    $valor_mes   = $row31['valor_mes'];

}

$row32 = mysqli_fetch_array($query32);

$hora_ingreso = $row32['hora_ingreso'];
$hora_salida  = $row32['hora_salida'];
$vehiculo     = $row32['vehiculo'];
$time_salida  = $row32['time_salida'];
$lugar        = $row32['lugar'];

//$query33=mysqli_query($con,"select * from vehiculo where id_vehiculo='$vehiculo' ")or die(mysqli_error());

//while($row33=mysqli_fetch_array($query33)){
//$placa=$row33['placa'];
//$tipo=$row33['tipo'];

//}

$cant_horas = 0;
$cant_horas = $time_salida_f - $time_entrada;
$price      = 0;
$precio     = 0;

if ($dia_noche == "por_hora") {
    $price  = $valor_hora;
    $precio = $price * $cant_horas;
    if ($precio == 0) {
        $precio = $valor_hora;
    }
}
if ($dia_noche == "por_noche") {
    $price  = $valor_noche;
    $precio = $price * $diferencia;

    if ($precio == 0) {
        $precio = $valor_noche;
    }
}
$caja_cont = $precio + $caja_cont;

mysqli_query($con, "update entradas set pago='$precio'  where codigo='$codigo'  ") or die(mysqli_error());
mysqli_query($con, "update caja set monto='$caja_cont'  where estado='abierto'") or die(mysqli_error());
mysqli_query($con, "update vehiculo set estado_vehiculo='disponible'  where placa='$placa'") or die(mysqli_error());

echo "<script type='text/javascript'>alert('salio de Espacio !');</script>";
echo "<script>document.location='salida_prepago_datos.php?codigo=$codigo'</script>";

?>
