

<?php include '../layout/header.php';

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

 <!--end of modal-->


                  <div class="box-header">
                  <h3 class="box-title"> </h3>

                </div><!-- /.box-header -->

  <?php
if (isset($_REQUEST['id_cliente'])) {
    $id_cliente = $_REQUEST['id_cliente'];
} else {
    $id_cliente = $_POST['id_cliente'];
}

?>






                <div class="box-body">
















 <!--end of modal-->






   <?php

$nro_cocheras = 0;
// $branch=$_SESSION['branch'];
$query1 = mysqli_query($con, "select * from clientes where id_cliente='$id_cliente' ") or die(mysqli_error());

while ($row1 = mysqli_fetch_array($query1)) {

    $nombre   = $row1['nombre'];
    $apellido = $row1['apellido'];

    $ruc       = $row1['ruc'];
    $telefono  = $row1['telefono'];
    $dni       = $row1['dni'];
    $direccion = $row1['direccion'];

}

$cont_cliente = 0;

$query3 = mysqli_query($con, "select * from clientes where id_cliente='$id_cliente'") or die(mysqli_error());

while ($row3 = mysqli_fetch_array($query3)) {
    $cont_cliente++;
}
?>






                <div class="box-body">
       <a class="btn btn-warning btn-print" href="cliente.php"    style="height:25%; width:15%; font-size: 12px " role="button">Regresar</a>
                       <div class="row">
                    <div class="col-md-6 btn-print">


                  <div class="box-header">
                  <h3 class="box-title">Modificar cliente</h3>
                </div><!-- /.box-header -->


        <form class="form-horizontal" method="post" action="cliente_actualizar.php" enctype='multipart/form-data'>

        <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Nombres</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>"  required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>
                                                       <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Apellidos </label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

                          <input type="text" class="form-control pull-right" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>

            <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >RUC</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo $ruc; ?>" minlength="11"  maxlength="11" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>
  <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >DNI</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $dni; ?>" minlength="8"  maxlength="8" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


                    <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Telefono</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

                 <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono; ?>"  required >
                    <input type="hidden" class="form-control" id="id_cliente" name="id_cliente" value="<?php echo $id_cliente; ?>"  required >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>



 <div class="row">

                <div class="col-md-3 btn-print">
                  <div class="form-group">
                    <label for="date" >Direccion</label>

                  </div><!-- /.form group -->
                </div>
                <div class="col-md-4 btn-print">
                  <div class="form-group">
                    <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" placeholder="Direccion" >
                  </div>
                </div>
                <div class="col-md-4 btn-print">

                </div>
              </div>


               <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">


                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
       <button type="submit" class="btn btn-primary">Modificar</button>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>





        </form>

                    </div>

                       <div class="col-md-5 btn-print">


                  <div class="box-header">
                 <h3 class="box-title">Registrar vehiculo cliente</h3>
                </div><!-- /.box-header -->
       <form class="form-horizontal" method="post" action="cliente_vehiculo_add.php" enctype='multipart/form-data'>

                <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Tipo vehiculo</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
              <select class="form-control select2" name="tipo" required>

                <?php

$queryc = mysqli_query($con, "select * from tarifa") or die(mysqli_error());
while ($rowc = mysqli_fetch_array($queryc)) {
    ?>
                  <option value="<?php echo $rowc['id_tarifa']; ?>"><?php echo $rowc['tipo_vehiculo']; ?></option>
                <?php }?>
              </select>
              <br>
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

            <input type="text" class="form-control" id="placa" name="placa"   required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>
  <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Marca</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="text" class="form-control" id="marca" name="marca"  required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


                    <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Modelo</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

                 <input type="text" class="form-control" id="modelo" name="modelo"  required >

                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>

               <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Color</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

                 <input type="text" class="form-control" id="color" name="color"  required >
                <input type="hidden" class="form-control" id="id_cliente" name="id_cliente" value="<?php echo $id_cliente; ?>"  required >

                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>


               <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" > ACTUALIZAR</label>

                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
       <button type="submit" class="btn btn-primary">Registrar</button>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">

                    </div>
                    </div>





        </form>



                    </div>

                    </div>


                </div><!-- /.box-body -->


<?php echo "$cont_cliente"; ?> vehiculos registrados


                                       <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>



                        <th>tipo</th>
                        <th>placa</th>
                        <th>marca</th>
                         <th>modelo</th>
                       <th> color</th>

 <th class="btn-print"> Accion </th>
                      </tr>
                    </thead>
                    <tbody>
<?php
// $branch=$_SESSION['branch'];
$query = mysqli_query($con, "select * from vehiculo AS v INNER JOIN tarifa AS t
      ON v.tipo = t.  id_tarifa where id_cliente='$id_cliente'") or die(mysqli_error());
$i = 0;
while ($row = mysqli_fetch_array($query)) {
    $id_vehiculo = $row['id_vehiculo'];
    ?>
                      <tr >



              <td><?php echo $row['tipo_vehiculo']; ?></td>
              <td><?php echo $row['placa']; ?></td>
<td><?php echo $row['marca']; ?></td>
<td><?php echo $row['modelo']; ?></td>
<td><?php echo $row['color']; ?></td>



                          <td>
                                 <?php

    ?>
 <a class="btn btn-danger btn-print" href="<?php echo "modificar_vehiculo_cliente.php?id_cliente=$id_cliente&id_vehiculo=$id_vehiculo"; ?>"  role="button">Modificar</a>
<a class="btn btn-success btn-print" href="<?php echo "eliminar_vehiculo_cliente.php?id_cliente=$id_cliente&id_vehiculo=$id_vehiculo"; ?>"  role="button">Eliminar</a>
             <?php
//          }
    ?>

            </td>
                      </tr>

 <!--end of modal-->

<?php }?>
                    </tbody>

                  </table>

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
