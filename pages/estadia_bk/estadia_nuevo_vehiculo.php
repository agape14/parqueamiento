

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



                  <div class="box-header">
                  <h3 class="box-title"> REGISTRAR VEHICULO </h3>

                </div><!-- /.box-header -->
                <a class="btn btn-warning btn-print" href="estadia.php"    style="height:25%; width:15%; font-size: 12px " role="button">Regresar</a>










                <div class="box-body">













        <form class="form-horizontal" method="post" action="estadia_vehiculo_add.php" enctype='multipart/form-data'>


               <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Tipo vehiculo</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
                   <select class="form-control select2" name="tipo" autofocus required>

                <?php

$queryc = mysqli_query($con, "select * from tarifa") or die(mysqli_error());
while ($rowc = mysqli_fetch_array($queryc)) {
    ?>
                  <option value="<?php echo $rowc['id_tarifa']; ?>"><?php echo $rowc['tipo_vehiculo']; ?></option>
                <?php }?>
              </select>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


 <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Placa</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="text" class="form-control" id="placa" name="placa" style="text-transform:uppercase;" value=""  onkeyup="javascript:this.value=this.value.toUpperCase();" maxlength="7"  required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>
  <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <!--<label for="date" >Marca</label>-->

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="hidden" class="form-control" id="marca" name="marca"  >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


                    <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <!--<label for="date" >Modelo</label>-->

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

                 <input type="hidden" class="form-control" id="modelo" name="modelo"   >

                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>

               <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <!--<label for="date" >Color</label>-->

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

                 <input type="hidden" class="form-control" id="color" name="color"   >


                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


       <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >clienten</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">


                        <select class="form-control select2" name="id_cliente" required>

                            <?php

$queryc = mysqli_query($con, "select * from clientes ") or die(mysqli_error());
while ($rowc = mysqli_fetch_array($queryc)) {
    ?>
                                        <option value="<?php echo $rowc['id_cliente']; ?>"><?php echo $rowc['nombre'] . '  ' . $rowc['apellido']; ?></option>
                            <?php }?>
                          </select>

          <input type="hidden" class="form-control" id="id_espacios" name="id_espacios" value="<?php echo $id_espacios; ?>" required >

                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>






    <button type="submit" class="btn btn-primary">Registrar</button>











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
