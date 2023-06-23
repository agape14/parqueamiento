
<?php
session_start();
include '../layout/header.php';
date_default_timezone_set("America/Lima");
//$branch_id = $_GET['id'];
?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../layout/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../layout/plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">
  <body class="nav-md">
              <?php
//    if ($docentes=="si") {
# code...

?>
    <div class="container body">
      <div class="main_container">
     <?php include '../layout/main_sidebar.php';?>

        <!-- top navigation -->
       <?php include '../layout/top_nav.php';?>      <!-- /top navigation -->
       <style>
label{

color: black;
}
li {
  color: white;
}
ul {
  color: white;
}
#buscar{
  text-align: right;
}
       </style>

        <!-- page content -->
        <div class="right_col" role="main">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class = "x-panel">

            </div>

        </div><!--end of modal-dialog-->
 </div>


                 <div class="panel-heading">


        </div>

 <!--end of modal-->
  <?php
if (isset($_REQUEST['codigo'])) {
    $codigo = $_REQUEST['codigo'];
} else {
    $codigo = $_POST['codigo'];
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
    $tipo_cobro = "Por hora";
    $valor_por  = $valor_hora;

}
if ($dia_noche == "por_noche") {
    $tipo_cobro = "Por noche";
    $valor_por  = $valor_noche;
}

$horas_consumidas = 0;
$dias_consumidos  = 0;

//$dias_consumidos=number_format(date("d", $fecha_salida)-date("d", $fecha_ingreso));
// $dia_inicio = date("d", $fecha_ingreso);
//$dia_fin = date("d", $fecha_salida);

$fecha1           = new DateTime($fecha_ingreso);
$fecha2           = new DateTime($fecha_salida);
$diff             = $fecha1->diff($fecha2);
$dias_consumidos  = $diff->days;
$horas_consumidas = $time_salida - $time_entrada;
if ($dias_consumidos > 0) {
    $horas_consumidas = $dias_consumidos * 24;
}
?>

                  <div class="box-header">
                  <h3 class="box-title"> Prepago del vehiculo con placa <?php echo $placa; ?> cochera  <?php echo $numero; ?></h3>

                </div><!-- /.box-header -->











                <div class="box-body">













        <form class="form-horizontal"  enctype='multipart/form-data'>





             <div class="row">
                    <div class="col-md-4 btn-print">
                      <div class="form-group">
                        <label for="date" >Tipo cobro</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $tipo_cobro; ?>" readonly >
                      </div>
                    </div>
                       <div class="col-md-4 btn-print">


                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>






          <div class="row">
                    <div class="col-md-4 btn-print">
                      <div class="form-group">
                        <label for="date" >Tipo de pago</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $tipo_vehiculo; ?>" readonly >
                      </div>
                    </div>
                       <div class="col-md-4 btn-print">
                   <div class="form-group">
                        <label for="date" >Valor por <?php echo $tipo_cobro; ?></label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $valor_por; ?>" readonly >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>



          <div class="row">
                    <div class="col-md-4 btn-print">
                      <div class="form-group">
                        <label for="date" >Fecha de ingreso</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $fecha_ingreso; ?>" readonly >
                      </div>
                    </div>
                       <div class="col-md-4 btn-print">
                   <div class="form-group">
                        <label for="date" >Hora de ingreso</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $hora_ingreso; ?>" readonly >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>

     <div class="row">
                    <div class="col-md-4 btn-print">
                      <div class="form-group">
                        <label for="date" >Fecha de salida</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $fecha_salida; ?>" readonly >
                      </div>
                    </div>
                       <div class="col-md-4 btn-print">
                   <div class="form-group">
                        <label for="date" >Hora de salida</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $hora_salida; ?>" readonly >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>



     <div class="row">
                    <div class="col-md-4 btn-print">
                      <div class="form-group">
                        <label for="date" >Dias consumidos</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $dias_consumidos; ?>" readonly >
                      </div>
                    </div>
                       <div class="col-md-4 btn-print">
                   <div class="form-group">
                        <label for="date" >Horas consumidas</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $horas_consumidas; ?>" readonly >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


     <div class="row">
                    <div class="col-md-4 btn-print">


                    </div>
                       <div class="col-md-4 btn-print">
                   <div class="form-group">
                        <label for="date" >Total a Pagar S/</label>

                      </div><!-- /.form group -->
                                   <div class="form-group">

                          <input type="text" class="form-control pull-right" id="date" name="nombre" value="<?php echo $pago; ?>" readonly >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>



      <a class="btn btn-warning btn-print" href="estadia.php"    style="height:25%; width:15%; font-size: 12px " role="button">Marcar salida</a>




              <div class="modal-footer">


              </div>
        </form>





                </div><!-- /.box-body -->


            </div><!-- /.col -->


          </div><!-- /.row -->




                </div><!-- /.box-body -->

            </div>
        </div>
      </div>
        </div>

        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Sistema de Parqueo <a href="#"></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

  <?php include '../layout/datatable_script.php';?>



        <script>
        $(document).ready( function() {
                $('#example2').dataTable( {
                 "language": {
                   "paginate": {
                      "previous": "anterior",
                      "next": "posterior"
                    },
                    "search": "Buscar:",


                  },

                  "info": false,
                  "lengthChange": false,
                  "searching": false,


  "searching": true,
                }

              );
              } );
    </script>





    <!-- /gauge.js -->
  </body>
</html>
