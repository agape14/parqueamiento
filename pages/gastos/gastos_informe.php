<?php include '../layout/header.php';?>
<link rel="stylesheet" href="../layout/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="../layout/plugins/select2/select2.min.css">
<link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">
<body class="nav-md">
   <div class="container body">
      <div class="main_container">
         <?php include '../layout/main_sidebar.php';?>
         <?php include '../layout/top_nav.php';?>
         <style>
            label{ color: black;}
            li {color: white;}
            ul { color: white;}
            #buscar{text-align: right;}
            th, td {font-size: 15px;text-align: center;}
         </style>
         <!-- page content -->
         <div class="right_col" role="main">
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class = "x-panel">
                  </div>
               </div>
               <!--end of modal-dialog-->
            </div>
            <?php
$fechaactual = date('Y-m-d');
$Fecha       = "2022-01-01 08:15:00";
$nuevafecha  = date("Y-m-d", strtotime($Fecha));
?>
            <!-- Date range -->
            <form method="post" action="exportar_gastos.php" enctype="multipart/form-data" class="form-horizontal">
               <button class="btn btn-lg btn-success btn-print" id="daterange-btn"  name="">EXPORTAR EXCEL</button>
               <div class="col-md-12 btn-print">
                  <div class="form-group">
                     <label for="date" class="col-sm-3 control-label">Fecha inicio</label>
                     <div class="input-group col-sm-8">
                        <input type="date" class="form-control pull-right" id="date" name="fecha_inicio" value="<?php echo $nuevafecha; ?>" required >
                     </div>
                     <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
               </div>
               <div class="col-md-12 btn-print">
                  <div class="form-group">
                     <label for="date" class="col-sm-3 control-label">Fecha final</label>
                     <div class="input-group col-sm-8">
                        <input type="date" class="form-control pull-right" id="date" name="fecha_final" value="<?php echo $fechaactual; ?>" required >
                     </div>
                     <!-- /.input group -->
                  </div>
                  <!-- /.form group -->
               </div>
               <div class="col-md-12">
                  <div class="col-md-12">
                  </div>
               </div>
            </form>
            <div class="box-header">
               <h3 class="box-title"> LISTA GASTOS </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
               <table id="example2" border=1 cellspacing=0 cellpadding=2 bordercolor="black">
                  <thead>
                     <tr>
                        <th style="width:30%">Fecha</th>
                        <th style="width:30%">Descripcion</th>
                        <th style="width:10%"> Valor S/. </th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
$year  = date("Y");
$query = mysqli_query($con, "select * from gastos where YEAR(fecha) = '$year' ") or die(mysqli_error());

while ($row = mysqli_fetch_array($query)) {
    $id_gastos = $row['id_gastos'];

    ?>
                     <tr >
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['cantidad']; ?></td>
                        </td>
                     </tr>
                     <div id="updateordinance<?php echo $row['id_gastos']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                           <div class="modal-content" style="height:auto">
                              <div class="modal-header">
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">×</span></button>
                                 <h4 class="modal-title">ACCION DETALLES GASTOS </h4>
                              </div>
                              <div class="modal-body">
                                 <form class="form-horizontal" method="post" action="gastos_actualizar.php" enctype='multipart/form-data'>
                                    <div class="form-group">
                                       <label class="control-label col-lg-3" for="price">Descripcion</label><br>
                                       <div class="col-lg-9">
                                          <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $row['descripcion']; ?>"   required>
                                          <input type="hidden" class="form-control" id="id_gastos" name="id_gastos" value="<?php echo $row['id_gastos']; ?>" required>
                                       </div>
                                    </div>
                                    <br>
                                    <br>
                                    <label style="" >Cantidad </label>
                                    <div class="form-group">
                                       <div class="col-lg-9">
                                          <input type="text" class="form-control" id="cantidad" name="cantidad" value="<?php echo $row['cantidad']; ?>"  required>
                                       </div>
                                    </div>
                                    <br>
                                    <br>
                              </div>
                              <br><br><br><hr>
                              <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">GUARDAR</button>
                              <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                              </div>
                              </form>
                           </div>
                        </div>
                        <!--end of modal-dialog-->
                     </div>
                     <!--end of modal-->
                     <?php }?>
                  </tbody>
               </table>
            </div>
            <!-- /.box-body -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.box-body -->
   </div>
   </div>
   </div>
   </div>
   <!-- /page content -->
   <!-- footer content -->
   <footer>
      <div class="pull-right">
         SISTEMA DE PARQUEO <a href="#"></a>
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
//}

?>
   <!-- /gauge.js -->
</body>
</html>