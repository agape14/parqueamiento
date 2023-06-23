<?php session_start();
if (empty($_SESSION['id'])):
    header('Location:../index.php');
endif;
$codigo                               = $_GET['codigo'];
$ticket                               = '0';
if (isset($_GET['boletas'])): $ticket = $_GET['boletas'];endif;
date_default_timezone_set("America/Lima");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />


  <link rel='stylesheet' type='text/css' href='css/style.css' />
  <link rel='stylesheet' type='text/css' href='css/print.css' media="print" />
  <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
  <script type='text/javascript' src='js/example.js'></script>


<style>

.left{
    float: left;

}
.right{
    float: right;

}
.center{

   display:inline-block
}
@media print {
    .btn-print {
      display:none !important;
    size:30px;
    }

}
hr {
  height: 3px;
  width: 100%;
  background-color: black;
}
#abajo{
    height: 3px;
  width: 30%;
  background-color: black;
}
tr, h3{
  font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
  border:none; font-size: 16px;

}
#negrita{
  font-size: 18px;
}
#terminos{
    border:none; font-size: 8px;
}
</style>
</style>
</head>

<body>

  <?php
include '../../dist/includes/dbcon.php';

?>

  <?php
$query31 = mysqli_query($con, "select * from empresa ") or die(mysqli_error());

while ($row31 = mysqli_fetch_array($query31)) {
    $nombre_empresa    = $row31['empresa'];
    $ruc_empresa       = $row31['ruc'];
    $direccion_empresa = $row31['direccion'];

}

$query6 = mysqli_query($con, "select * from entradas AS e INNER JOIN vehiculo AS v
      ON e.vehiculo = v.id_vehiculo where codigo='$codigo' ") or die(mysqli_error());
$i = 1;
while ($row6 = mysqli_fetch_array($query6)) {
    $placa         = $row6['placa'];
    $id_vehiculo   = $row6['id_vehiculo'];
    $dia_noche     = $row6['dia_noche'];
    $tipo_auto     = $row6['tipo'];
    $fecha_ingreso = $row6['fecha'];
    $fecha_salida  = $row6['fecha_salida'];

    $hora_ingreso = $row6['hora_ingreso']; //hora incial
    $hora_salida  = $row6['hora_salida']; //hora final

    $time_entrada = $row6['time_entrada']; //hora incial
    $time_salida  = $row6['time_salida']; //hora final

    $id_espacios = $row6['lugar'];
    $dia_noche   = $row6['dia_noche'];
    $pago        = $row6['pago'];
    $id_entrada  = $row6['id_entrada'];
    $usuario_id  = $row6['usuario_id'];
}
$query7 = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios' ") or die(mysqli_error());

while ($row7 = mysqli_fetch_array($query7)) {

    $numero = $row7['numero'];
}
$query9 = mysqli_query($con, "select  * from vehiculo AS v INNER JOIN tarifa AS t
      ON v.tipo = t.id_tarifa where id_vehiculo='$id_vehiculo' ") or die(mysqli_error());

while ($row9 = mysqli_fetch_array($query9)) {

    $tipo_vehiculo = $row9['tipo_vehiculo'];
    $valor_hora    = $row9['valor_hora'];
    $valor_noche   = $row9['valor_noche'];
    $valor_mes     = $row9['valor_mes'];

}

$tipo_cobro = "";
$valor_por  = 0;

if ($dia_noche == "por_hora") {
    $tipo_cobro = "hora";
    $valor_por  = $valor_hora;

}
if ($dia_noche == "por_noche") {
    $tipo_cobro = "noche";
    $valor_por  = $valor_noche;
}

$horas_consumidas = 0;

//$hora_salida = date("H:i:s");
$fec_ing_uni = $fecha_ingreso . " " . $hora_ingreso;
$fec_sal_uni = $fecha_salida . " " . $hora_salida;

$date1_ingreso = new DateTime($fec_ing_uni);
$date2_salida  = new DateTime($fec_sal_uni);

$difffec_ing_sal = (array) date_diff($date1_ingreso, $date2_salida);
//print_r($difffec_ing_sal);
$dias_transcurridos     = $difffec_ing_sal["d"];
$horas_transcurridos    = $difffec_ing_sal["h"] == 0 ? 1 : $difffec_ing_sal["h"];
$minutos_transcurridos  = $difffec_ing_sal["i"];
$segundos_transcurridos = $difffec_ing_sal["s"];

$time_salida = date("H");
if ($minutos_transcurridos >= 10) {
    $horas_transcurridos = $horas_transcurridos + 1;
    $time_salida      = $time_salida + 1;
}

$dias_consumidos = 0;

//$dias_consumidos=number_format(date("d", $fecha_salida)-date("d", $fecha_ingreso));
// $dia_inicio = date("d", $fecha_ingreso);
//$dia_fin = date("d", $fecha_salida);
/*
$fecha1           = new DateTime($fecha_ingreso);
$fecha2           = new DateTime($fecha_salida);
$diff             = $fecha1->diff($fecha2);
$horas_consumidas = $time_salida - $time_entrada;
 */
//$dias_consumidos=$dia_fin-$dia_inicio;
$session_id    = $usuario_id; //$_SESSION['id'];
$user_query    = mysqli_query($con, "select * from usuario where id = '$session_id' ") or die(mysql_error());
$user_row      = mysqli_fetch_array($user_query);
$user_username = $user_row['usuario'];

mysqli_query($con, "update espacios set
  estado='disponible',
  salida='no',
  placa=null,
  hora_ingreso=null,
  fecha_ingreso=null,
  codigo_entrada=null,
  id_vehiculo=null
  where id_espacios='$id_espacios' ") or die(mysqli_error($con));
?>


  <div id="page-wrap">

    <div class="container">

<div class="btn-group" style=" padding-top: 10px;">

   <a class = "btn btn-success btn-print" autofocus style="    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #5CB85C;
    border-radius: 6px;
    border: 2px solid #0016b0; " href = "" onclick = "impresionticket(<?php echo $id_espacios; ?>)"><i class ="glyphicon glyphicon-print"></i> Impresión ticket</a>

<?php if ($ticket == '0'): ?>
  <!--<a class = "btn btn-success btn-print" style="    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #F0AD4E;
    border-radius: 6px;
    border: 2px solid #0016b0; " href = "<?php echo "liberar_cochera.php?id_espacios=$id_espacios"; ?>" ><i class ="glyphicon glyphicon-print"></i> Liberar Nro cochera</a>-->
<?php endif?>

<!--<a class = "btn btn-success btn-print" style="    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #C83935;
    border-radius: 6px;
    border: 2px solid #0016b0; " href = "<?php echo "liberar_cochera.php?id_espacios=$id_espacios&id_entrada=$id_entrada"; ?>" ><i class ="glyphicon glyphicon-print"></i>Boleta Electronica</a> -->

 <a class = "btn btn-success btn-print" style="    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 2px solid #0016b0; " href = "<?php if ($ticket == '0') {echo 'estadia.php';} else {echo '../facturacion/listado_tickets.php';}?> " ><i class ="glyphicon glyphicon-print"></i>Regresar</a>

</div>
<br>

                  <center>
                  <h3>TICKET PAGO</h3>
                  </center>


<center>            <table class="table table-bordered table-striped"  style="border:none;">
                    <thead>
                   <tr>


                        <th style="border:none;">

  <?php echo $nombre_empresa; ?>
  <br><br>
    <div style="width: 250px;">
      <?php echo $direccion_empresa; ?>
    </div>
  <br>
  <!--RUC: <?php echo $ruc_empresa; ?>
  <br> -->
  ----------------------------
   <br>
   PARQUEO VEHICULAR
     <br>
  ----------------------------
   <br>
   ticket codigo: <?php echo $codigo; ?>

   <br>

  <div id="negrita">Placa: <?php echo $placa; ?></div>
  <div id="negrita"> Ingreso: <?php echo $hora_ingreso; ?></div>
  <div id="negrita">Salida: <?php echo $hora_salida; ?></div>
  Fecha ingreso: <?php echo $fecha_ingreso; ?>
    <br>
      Fecha salida: <?php echo $fecha_salida; ?>
    <br>
  Horas trans: <?php echo strval($horas_transcurridos); ?>
        <br>
  <div id="negrita">Nro. cochera: <?php echo $numero; ?></div>
  Cobro por: <?php echo $tipo_cobro; ?>

            <br>
  A pagar: S/. <?php echo $pago; ?>

         <br>
  Usuario :  <?php echo $user_username; ?>
    <br>
  ----------------------------
    <br>
    Gracias por su preferencia
      <br>
    Regrese pronto
                        </th>



                      </tr>
                    </thead>
                    <tbody>

                   </tbody>

                  </table>

</center>




  </div>





</body>

</html>
<script type="text/javascript">

  function impresionticket(codespacio) { //alert(codespacio);return;
    window.print();
  }
</script>