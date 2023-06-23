<?php session_start();
if (empty($_SESSION['id'])):
    header('Location:../index.php');
endif;
$facturacion_id = $_GET['facturacion_id'];
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
#izquierda{text-align: left;}
#letrapeq{font-size: 11px; }
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
    $id_empresa        = $row31['id_empresa'];
    $empresa           = $row31['empresa'];
    $telefono          = $row31['telefono'];
    $descripcion       = $row31['descripcion'];
    $imagen            = $row31['imagen'];
    $correo            = $row31['correo'];
    $simbolo_moneda    = $row31['simbolo_moneda'];
    $tipo_doc          = $row31['tipo_doc'];
    $nombre_comercial  = $row31['nombre_comercial'];
    $ubigeo            = $row31['ubigeo'];
    $departamento      = $row31['departamento'];
    $provincia         = $row31['provincia'];
    $distrito          = $row31['distrito'];
    $cod_pais          = $row31['cod_pais'];
    $razon_social      = $row31['razon_social'];
}

$query6 = mysqli_query($con, "SELECT  facturacion_id, tipo,CONCAT( serie,'-',numero) serienro,serie,numero, date_format(fecha, '%d/%m/%Y') fecha, cliente_nom, facturacion_subtotal,
 facturacion_igv, facturacion_total, facturacion_estado,
CASE WHEN facturacion_estado='0' THEN 'Aceptado' WHEN facturacion_estado='0'
THEN facturacion_estado_descripcion ELSE '' END fact_estado,
CASE WHEN facturacion_emitido=0 THEN 'NO' WHEN facturacion_emitido=1
THEN 'SI' ELSE '' END emitido,facturacion_emitido,cliente_nro_doc,cliente_nom,cliente_dir,facturacion_hash,total_descripcion
FROM facturacion_cab where facturacion_id='$facturacion_id' ") or die(mysqli_error());
$i = 1;
while ($row6 = mysqli_fetch_array($query6)) {
    $facturacion_id       = $row6['facturacion_id'];
    $tipo                 = $row6['tipo'];
    $serienro             = $row6['serienro'];
    $serie                = $row6['serie'];
    $numero               = $row6['numero'];
    $fecha                = $row6['fecha'];
    $cliente_nom          = $row6['cliente_nom'];
    $facturacion_subtotal = $row6['facturacion_subtotal'];
    $facturacion_igv      = $row6['facturacion_igv'];
    $facturacion_total    = $row6['facturacion_total'];
    $facturacion_estado   = $row6['facturacion_estado'];
    $cliente_nro_doc      = $row6['cliente_nro_doc'];
    $cliente_nom          = $row6['cliente_nom'];
    $cliente_dir          = $row6['cliente_dir'];
    $facturacion_hash     = $row6['facturacion_hash'];
    $total_descripcion    = $row6['total_descripcion'];
}

$query66 = mysqli_query($con, "select * from entradas AS e INNER JOIN vehiculo AS v
      ON e.vehiculo = v.id_vehiculo where facturacion_id='$facturacion_id' ") or die(mysqli_error());

while ($row66 = mysqli_fetch_array($query66)) {
    $placa         = $row66['placa'];
    $id_vehiculo   = $row66['id_vehiculo'];
    $tipo_auto     = $row66['tipo'];
    $fecha_ingreso = $row66['fecha'];
    $hora_ingreso  = $row66['hora_ingreso'];
    $fecha_salida  = $row66['fecha_salida'];
    $hora_salida   = $row66['hora_salida'];
    $time_entrada  = $row66['time_entrada'];
    $id_espacios   = $row66['lugar'];
    $codigo        = $row66['codigo'];
}

$query88 = mysqli_query($con, "SELECT * FROM facturacion_det WHERE facturacion_id='$facturacion_id' ") or die(mysqli_error());
while ($row88 = mysqli_fetch_array($query88)) {
    $item     = $row88['item_cantidad'];
    $producto = $row88['item_nombre'];
    $precio   = $row88['item_precio'];
    $importe  = $row88['item_importe'];
    $igv      = $row88['item_igv'];
}

$query7 = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios' ") or die(mysqli_error());

while ($row7 = mysqli_fetch_array($query7)) {

    $numero = $row7['numero'];
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

$horas_consumidas = "";
$dias_consumidos  = 0;

//$dias_consumidos=number_format(date("d", $fecha_salida)-date("d", $fecha_ingreso));
// $dia_inicio = date("d", $fecha_ingreso);
//$dia_fin = date("d", $fecha_salida);

$fecha1           = new DateTime($fecha_ingreso);
$fecha2           = new DateTime($fecha_salida);
$diff             = $fecha1->diff($fecha2);
$horas_consumidas = $time_salida - $time_entrada;
//$dias_consumidos=$dia_fin-$dia_inicio;
$session_id    = $_SESSION['id'];
$user_query    = mysqli_query($con, "select * from usuario where id = '$session_id'") or die(mysql_error());
$user_row      = mysqli_fetch_array($user_query);
$user_username = $user_row['usuario'];
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
    border: 2px solid #0016b0; " href = "" onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> Impresión ticket</a>



 <a class = "btn btn-success btn-print" style="    text-decoration: none;
    padding: 10px;
    font-weight: 600;
    font-size: 20px;
    color: #ffffff;
    background-color: #1883ba;
    border-radius: 6px;
    border: 2px solid #0016b0; " href = "<?php echo '../estadia/estadia.php'; ?> " ><i class ="glyphicon glyphicon-print"></i>Regresar</a>

</div>
<br>

    <center>
      <table class="table table-bordered table-striped"  style="border:none;">
                    <thead>
                   <tr>


                        <th >

  <?php echo $nombre_comercial; ?><br>
  De: <?php echo $razon_social; ?><br>
  RUC: <?php echo $ruc_empresa; ?><br>
  <div id="letrapeq"><?php echo $direccion_empresa; ?></div>
  ----------------------------<br>
  <?php echo 'BOLETA DE VENTA'; ?><br>
  <?php echo 'ELECTRONICA ' . $serienro; ?><br>
  ----------------------------<br>
  <div id="izquierda">Fecha: <?php echo $fecha; ?> </div>
  <div id="izquierda">Moneda: <?php echo 'SOL Placa:' . strtoupper($placa); ?>  </div>
  <div id="izquierda">Nro. Ticket: <?php echo $codigo; ?></div>
  <?php $fec_ingreso = date_create($fecha_ingreso . ' ' . $hora_ingreso);
$fec_salida          = date_create($fecha_salida . ' ' . $hora_salida);
?>
  <div id="izquierda">Entrada: <?php echo date_format($fec_ingreso, "d/m/Y H:i"); ?></div>
  <div id="izquierda">Salida: <?php echo date_format($fec_salida, "d/m/Y H:i"); ?></div>
  ----------------------------<br>
  <div id="izquierda">Nro. Documento: <?php echo $cliente_nro_doc; ?> </div>
  <div id="izquierda">Cliente: <?php echo $cliente_nom; ?> </div>
  <div id="izquierda">Direccion: <?php echo $cliente_dir; ?> </div>
  <div id="izquierda">_________________________</div>
  <table rules="rows" width="80">
    <tr>
      <td>CANT</td>
      <td>PRODUCTO</td>
      <td>TOTAL</td>
    </tr>
    <tr>
      <td><?php echo $item; ?></td>
      <td><?php echo '001 -' . strtoupper($producto); ?></td>
      <td><?php echo $importe; ?></td>
    </tr>
  </table>
  ----------------------------<br>
  <table width="250" id="izquierda">
    <tr>
      <td >SUB. TOTAL: <?php echo $facturacion_subtotal; ?></td>
    </tr>
    <tr>
      <td>IGV(18%): <?php echo $facturacion_igv; ?></td>
    </tr>
    <tr>
      <td>TOTAL: <?php echo $facturacion_total; ?></td>
    </tr>
    <tr>
      <td><?php echo $total_descripcion; ?></td>
    </tr>
    <tr>
      <td>Representación impresa de la BOLETA DE VENTA ELECTRONICA</td>
    </tr>
    <tr>
      <td><?php echo $facturacion_hash; ?></td>
    </tr>
    <tr>
      <?php
$ruta        = "../../api_cpe/BETA/";
$ruta_imagen = $ruta . '/' . $ruc_empresa . '/' . $ruc_empresa . '-' . $tipo . '-' . $serienro . '.PNG'
?>
      <td align="center"><img src="<?php echo $ruta_imagen; ?>"  width="200" height="200"></td>
    </tr>

  </table>

  <br>

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