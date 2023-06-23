<?php 
session_start();
include '../layout/header.php';

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
           //           if ($tipo=="administrador") {
                    
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
                  <h3 class="box-title"> MODIFICAR VEHICULO </h3>

                </div><!-- /.box-header -->
                <a class="btn btn-warning btn-print" href="vehiculo.php"    style="height:25%; width:15%; font-size: 12px " role="button">Regresar</a>
                


  <?php
     if(isset($_REQUEST['id_vehiculo']))
            {
              $id_vehiculo=$_REQUEST['id_vehiculo'];
            }
            else
            {
            $id_vehiculo=$_POST['id_vehiculo'];
          }

    


$nro_cocheras=0;
   // $branch=$_SESSION['branch'];
    $query1=mysqli_query($con,"select * from vehiculo where id_vehiculo='$id_vehiculo' ")or die(mysqli_error());

    while($row1=mysqli_fetch_array($query1)){

$placa=$row1['placa'];
$tipo=$row1['tipo'];
$marca=$row1['marca'];
$modelo=$row1['modelo'];
$color=$row1['color'];
$estado_vehiculo=$row1['estado_vehiculo'];
$id_cliente=$row1['id_cliente'];

    }

    $query2=mysqli_query($con,"select * from clientes where id_cliente='$id_cliente' ")or die(mysqli_error());

    while($row2=mysqli_fetch_array($query2)){

$dni=$row2['dni'];


    }

?>






                <div class="box-body">
                
         

 
                        
            

          
      




        <form class="form-horizontal" method="post" action="vehiculo_actualizar.php" enctype='multipart/form-data'>


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

                          $queryc=mysqli_query($con,"select * from tarifa")or die(mysqli_error());
                          while($rowc=mysqli_fetch_array($queryc)){
                          ?>
                          <option value="<?php echo $rowc['id_tarifa'];?>" <?php
                          if ($tipo==$rowc['id_tarifa']) {
                          echo "selected";
                          }
                          ?> ><?php echo $rowc['tipo_vehiculo'];?></option>
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

            <input type="text" class="form-control" id="placa" name="placa"  value="<?php echo $placa;?>" style="text-transform:uppercase;" onkeyup="javascript:this.value=this.value.toUpperCase();" oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/,'')" maxlength="6"  required >
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

            <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $marca;?>" >
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
              
                 <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $modelo;?>"  >

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
              
                 <input type="text" class="form-control" id="color" name="color" value="<?php echo $color;?>"   >
 
    <input type="hidden" class="form-control" id="id_vehiculo" name="id_vehiculo" value="<?php echo $id_vehiculo;?>" required >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">
                
                    </div>
                    </div>

<div class="row">
    <div class="col-md-3 btn-print">
      <div class="form-group">
        <label for="date" >Estado</label>

      </div><!-- /.form group -->
    </div>
    <div class="col-md-4 btn-print">
      <div class="form-group">
          <select class="form-control select2" id="estado"  name="estado" >
              <option value="disponible" <?php if($estado_vehiculo=='disponible'){echo 'selected';} ?> >DISPONIBLE</option>
              <option value="ocupado" <?php if($estado_vehiculo=='ocupado'){echo 'selected';} ?> >OCUPADO</option>
          </select>
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
              
    <button type="submit" class="btn btn-primary">Registrar</button>
                      </div>
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
