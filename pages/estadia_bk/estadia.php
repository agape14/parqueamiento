
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
            <?php
if (isset($_REQUEST['msg'])) {
    $msg_salida = $_REQUEST['msg'];
    ?>
<div id="divMensaje" class="alert alert-success alert-dismissible show" ><strong>Mensaje:</strong> Salio de Espacio !</div>
     <?php
}
?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class = "x-panel">

            </div>

        </div><!--end of modal-dialog-->
 </div>

                <?php
//     if ($guardar=="si") {
$q_espaciolibre = mysqli_query($con, "select * from espacios WHERE estado = 'disponible' ORDER BY id_espacios ASC LIMIT 1") or die(mysqli_error($con));
while ($r_espaciolibre = mysqli_fetch_array($q_espaciolibre)) {
//$r_espaciolibre  = mysqli_fetch_array($q_espaciolibre);
    $id_espaciolibre = $r_espaciolibre['id_espacios'];
    ?>


                  <div class="box-header">
                  <h3 class="box-title"> ESTADIAS</h3>


                  <a class="btn btn-lg btn-success btn-print" href="<?php echo "estadia_nuevo_vehiculo.php?id_espacios=$id_espaciolibre"; ?>"  role="button">REGISTRAR ESTADIA</a>

                </div><!-- /.box-header -->
                <?php
}
?>
                <!-- <div class="box-body">-->

                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>





                          <th> Nro</th>
                          <th> Cochera</th>
                           <th> Estado </th>
                            <th> Placa de vehiculo </th>
                             <th> Fecha de ingreso </th>
                              <th> Hora de ingreso </th>
                       <th class="btn-print"> Accion </th>

                      </tr>
                    </thead>
                    <tbody>
<?php
// $branch=$_SESSION['branch'];
$query         = mysqli_query($con, "select id_espacios,numero,CONCAT('CO',numero) AS cochera,estado,codigo_entrada,medida,placa,fecha_ingreso,hora_ingreso,salida,tipo_espacio from espacios  ") or die(mysqli_error());
$i             = 1;
$fecha_ingreso = "";
while ($row = mysqli_fetch_array($query)) {
    $id_espacios   = $row['id_espacios'];
    $cochera       = $row['cochera'];
    $estado        = $row['estado'];
    $salida        = $row['salida'];
    $codigo        = $row['codigo_entrada'];
    $fecha_ingreso = $row['fecha_ingreso'];

    if ($fecha_ingreso == "0000-00-00") {
        $fecha_ingreso = "";
    }

    ?>
                      <tr >
              <td><?php echo $row['numero']; ?></td>
              <td><?php echo $row['cochera']; ?></td>
                                 <?php
if ($estado == "disponible") {

        ?>
        <td  >
<label style="color:black; background-color: green; font-size: 12px;"><?php echo $row['estado']; ?></label>
          </td>
           <?php
}
    if ($estado == "ocupado") {

        ?>

       <td  ><label style="color:black; background-color: orange; font-size: 12px;"><?php echo $row['estado']; ?></label></td>
          <?php
}
    ?>

              <td><?php echo $row['placa']; ?></td>
      <td><?php echo $fecha_ingreso; ?></td>
       <td><?php echo $row['hora_ingreso']; ?></td>

                        <td>
                                   <?php
if ($estado == "disponible") {

        ?>
<a class="btn btn-success btn-print" href="#updateordinance<?php echo $row['id_espacios']; ?>"  data-target="#updateordinance<?php echo $row['id_espacios']; ?>" data-toggle="modal" style="color:#fff;"  style="height:12%; width:12%; font-size: 12px " role="button">Ingreso</a>

   <?php
}
    if ($estado == "ocupado") {

        ?>
<a class="btn btn-success btn-print"  disabled="true" data-target="#updateordinance<?php echo $row['id_espacios']; ?>" style="color:black; background-color:white;"  style="height:12%; width:12%; font-size: 12px " role="button">Ingreso</a>

   <?php
}
    ?>

        <?php
if ($estado == "disponible") {

        ?>

<a class="btn btn-success btn-print"  disabled="true" data-target="#updateordinance<?php echo $row['id_espacios']; ?>" style="color:black; background-color:white;"  style="height:12%; width:12%; font-size: 12px " role="button">Salida</a>


   <?php
}
    if ($estado == "ocupado" and $salida == "no") {

        ?>

<a class="btn btn-success btn-print" href="<?php echo "salida_prepago.php?id_espacios=$id_espacios"; ?>" style="color:black; background-color:white;"  style="height:12%; width:12%; font-size: 12px " role="button">Salida</a>

 <?php
}

    ?>
                         <?php
if ($salida == "si") {

        ?>

<a class="btn btn-success btn-print" href="<?php echo "generar_ticket.php?codigo=$codigo"; ?>" style="color:black; background-color:yellow;"  style="height:12%; width:12%; font-size: 12px " role="button">Generar tickets</a>
<a class="btn btn-success btn-print" href="<?php echo "liberar_cochera.php?id_espacios=$id_espacios"; ?>" style="color:white; background-color:orange;"  style="height:12%; width:12%; font-size: 12px " role="button">Liberar cochera</a>
   <?php
}
    if ($salida == "no") {

        ?>



<a class="btn btn-success btn-print"  disabled="true" data-target="#updateordinance<?php echo $row['id_espacios']; ?>" style="color:black; background-color:white;"  style="height:12%; width:12%; font-size: 12px " role="button">Generar ticket</a>

   <?php
}
    ?>


                               <?php
//   if ($editar=="si") {

    ?>


            <?php
//    }
    ?>

            </td>
                      </tr>
        <div id="updateordinance<?php echo $row['id_espacios']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content" style="height:auto">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span></button>
                  <center>
                <h4 class="modal-title">REGISTRAR NUEVO INGRESO</h4>
                </center>
              </div>
              <div class="modal-body">
<center>
    <a class="btn btn-success btn-print" href="<?php echo "estadia_registrado.php?id_espacios=$id_espacios"; ?>" style="color:black; background-color:white;"  style="height:12%; width:12%; font-size: 12px " role="button">Registrado</a>


       <a class="btn btn-success btn-print" href="<?php echo "estadia_nuevo_vehiculo.php?id_espacios=$id_espacios"; ?>" style="color:black; background-color:white;"  style="height:12%; width:12%; font-size: 12px " role="button">Nuevo</a>
</center>
        <form class="form-horizontal" method="post" action="bloque_actualizar.php" enctype='multipart/form-data'>




              <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
              </div>
        </form>
            </div>

        </div><!--end of modal-dialog-->
 </div>
 <!--end of modal-->

<?php $i++;}?>
                    </tbody>

                  </table>
               <!--  </div>/.box-body -->

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
             <a href="#"></a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>


  <?php include '../layout/datatable_script.php';?>



        <script>
        $(document).ready( function() {
            $('#example2').dataTable({
                "language": {
                  "paginate": {
                    "previous": "anterior",
                    "next": "posterior"
                    },
                  "search": "Buscar:",
                },

                "info": false,
                "lengthChange": false,
                "searching": true,/**/

            });
        });

        $("#divMensaje").fadeTo(2000, 300).slideUp(300, function(){
            $("#divMensaje").alert("close");
            window.location.href = 'estadia.php';
        });
    </script>

              <?php
// }
# code...

?>
    <!-- /gauge.js -->
  </body>
</html>
