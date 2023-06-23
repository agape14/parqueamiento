
<?php include '../layout/header.php';
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


                  <div class="box-header">
                  <h3 class="box-title"> </h3>

                </div><!-- /.box-header -->






<a class="btn btn-success btn-print" href="<?php echo "salir_espacio.php"; ?>"  role="button">SALIR DE GARAJE</a>







                <div class="box-body">
















 <!--end of modal-->





   <?php

$query5 = mysqli_query($con, "select * from temporal where id_temporal='1' ") or die(mysqli_error());

while ($row5 = mysqli_fetch_array($query5)) {

    $id_espacios = $row5['id_espacios'];
}

$query6 = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios' ") or die(mysqli_error());

while ($row6 = mysqli_fetch_array($query6)) {

    $codigo_entrada = $row6['codigo_entrada'];
}

$placa  = '';
$nombre = '';
$ruc    = '';

$query7 = mysqli_query($con, "select * from entradas  where codigo='$codigo_entrada' ") or die(mysqli_error());

while ($row7 = mysqli_fetch_array($query7)) {

    $id_vehiculo = $row7['vehiculo'];
    $id_cliente  = $row7['cliente'];

    $fecha        = $row7['fecha'];
    $hora_ingreso = $row7['hora_ingreso'];

    $espacio = $row7['lugar'];
}

$query8 = mysqli_query($con, "select * from clientes where id_cliente='$id_cliente' ") or die(mysqli_error());

while ($row8 = mysqli_fetch_array($query8)) {

    $nombre_cliente = $row8['nombre'];
    $ruc_cliente    = $row8['ruc'];
}

$query9 = mysqli_query($con, "select * from vehiculo where id_vehiculo='$id_vehiculo' ") or die(mysqli_error());

while ($row9 = mysqli_fetch_array($query9)) {

    $placa = $row9['placa'];

}

?>
            <table class="table table-bordered table-striped">
                    <thead>
                      <tr>



                        <th>PLACA</th>
                        <th> NOMVRE CLIENTE </th>
                          <th> RUC CLIENTE </th>


                      </tr>
                    </thead>
                    <tbody>
             <tr >


                        <td><?php echo $placa; ?></td>
                        <td><?php echo $nombre; ?></td>
                        <td><?php echo $ruc; ?></td>
              </tr>
                   </tbody>

                  </table>



                          <table class="table table-bordered table-striped">
                    <thead>
                      <tr>



                        <th>FECHA</th>
                        <th>HORA INGRESO </th>
                          <th> ESPACIO </th>


                      </tr>
                    </thead>
                    <tbody>
             <tr >


                        <td><?php echo $fecha; ?></td>
                        <td><?php echo $hora_ingreso; ?></td>
                        <td><?php echo $espacio; ?></td>
              </tr>
                   </tbody>

                  </table>

   <?php

?>












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
           Parqueamiento Sys <a href="#"></a>
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
           "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],


  "searching": true,
                }

              );
              } );
    </script>




    <!-- /gauge.js -->
  </body>
</html>
