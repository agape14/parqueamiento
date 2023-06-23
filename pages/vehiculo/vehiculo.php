
<?php include '../layout/header.php';

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
               //       if ($tipo=="administrador") {
                    
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
      
          <a class = "btn btn-success btn-print" href = "" onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> IMPRESION</a>
          <a class="btn btn-warning btn-print" href="vehiculo_agregar.php"    style="height:25%; width:15%; font-size: 12px " role="button">REGISTRAR</a>
        </div>



 <!--end of modal-->


                  <div class="box-header">
                  <h3 class="box-title"> LISTA VEHICULO</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                
                  <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th> Tipo </th>
                        <th> Placa </th>
                        <th> Marca </th>
                        <th> Modelo </th>
                        <th> Estado </th>
                        <th> Cliente </th>
                        <th class="btn-print"> Accion </th>

                      </tr>
                    </thead>
                    <tbody>
<?php

    $query=mysqli_query($con,"select v.id_vehiculo,TRIM(v.placa) placa ,v.marca,v.modelo,CONCAT(UPPER(c.nombre),UPPER(c.apellido)) cliente,t.tipo_vehiculo,v.estado_vehiculo
from vehiculo AS v 
INNER JOIN clientes AS c ON v.id_cliente = c.id_cliente
INNER JOIN tarifa t ON v.tipo=t.id_tarifa")or die(mysqli_error());
    $i=1;
    while($row=mysqli_fetch_array($query)){
    $id_vehiculo=$row['id_vehiculo'];
 
?>
                      <tr >

                        <td><?php echo $row['tipo_vehiculo'];?></td>
                        <td><?php echo $row['placa'];?></td>
                        <td><?php echo $row['marca'];?></td>
                        <td><?php echo $row['modelo'];?></td>
                        <td><?php echo $row['estado_vehiculo'];?></td>
                        <td><?php echo $row['cliente'];?></td>
              
                        


    
      

                        <td>
<a class="btn btn-danger btn-print" href="<?php  echo "modificar_vehiculo.php?id_vehiculo=$id_vehiculo";?>"  role="button">Modificar</a>
<a class="btn btn-success btn-print" href="<?php  echo "eliminar_vehiculo.php?id_vehiculo=$id_vehiculo";?>"  role="button">Eliminar</a>




            </td>
                      </tr>
        <div id="updateordinance<?php echo $row['id_vehiculo'];?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

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
