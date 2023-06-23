

<?php include '../layout/header.php';

date_default_timezone_set("America/Lima");
?>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="../layout/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../layout/plugins/select2/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">
  <body class="nav-md">
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

  <?php
if (isset($_REQUEST['id_espacios'])) {
    $id_espacios = $_REQUEST['id_espacios'];
} else {
    $id_espacios = $_POST['id_espacios'];
}

?>

 <!--end of modal-->


                  <div class="box-header">
                  <h3 class="box-title"> SELECCIONE VEHICULO</h3>
                </div><!-- /.box-header -->
                <div class="box-body">

                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>



                        <th> Placa </th>
                            <th> Marca </th>
                  <th> Modelo </th>
                       <th> DNI cliente </th>
                       <th class="btn-print"> Accion </th>

                      </tr>
                    </thead>
                    <tbody>
<?php

$query = mysqli_query($con, "select * from vehiculo AS v INNER JOIN clientes AS c
      ON v.id_cliente = c.id_cliente where estado_vehiculo='disponible'") or die(mysqli_error());
$i = 1;
while ($row = mysqli_fetch_array($query)) {
    $id_vehiculo = $row['id_vehiculo'];

    ?>
                      <tr >


                        <td><?php echo $row['placa']; ?></td>
                          <td><?php echo $row['marca']; ?></td>
                      <td><?php echo $row['modelo']; ?></td>
                        <td><?php echo $row['dni']; ?></td>







                        <td>
<a class="btn btn-danger btn-print" href="<?php echo "entradas_add.php?id_espacios=$id_espacios&id_vehiculo=$id_vehiculo"; ?>"  role="button">Seleccionar</a>





            </td>
                      </tr>
        <div id="updateordinance<?php echo $row['id_vehiculo']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

 <!--end of modal-->

<?php $i++;}?>
                    </tbody>

                  </table>
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
            Parqueamiento Sys<a href="#"></a>
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

               <?php
//        }
?>
    <!-- /gauge.js -->
  </body>
</html>
