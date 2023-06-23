
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
  <?php
if (isset($_REQUEST['id_espacios'])) {
    $id_espacios = $_REQUEST['id_espacios'];
} else {
    $id_espacios = $_POST['id_espacios'];
}

$query = mysqli_query($con, "select * from espacios where id_espacios='$id_espacios' ") or die(mysqli_error());
$i     = 1;
while ($row = mysqli_fetch_array($query)) {
    $placa  = $row['placa'];
    $numero = $row['numero'];
}
?>

                  <div class="box-header">
                  <h3 class="box-title"> Prepago del vehiculo con placa <?php echo $placa; ?> cochera  <?php echo $numero; ?></h3>

                </div><!-- /.box-header -->
                <a class="btn btn-warning btn-print" href="estadia.php"    style="height:25%; width:15%; font-size: 12px " role="button">Regresar</a>










                <div class="box-body">













        <form class="form-horizontal" method="post" action="salir_add.php" enctype='multipart/form-data'>






                    <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Selecciona una opcion</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
              <select class="form-control select2" name="dia_noche" required>

                  <option value="por_hora">Por hora</option>
                       <option value="por_noche">Por noche</option>

              </select>
                  <button type="submit" class="btn btn-primary">Enviar</button>
                      </div>
       <input type="hidden" class="form-control" id="id_espacios" name="id_espacios" value="<?php echo $id_espacios; ?>"  required >
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>



























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
