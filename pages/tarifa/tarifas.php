

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
               


                









                <div class="box-body">
                
         

 
                        
            

          
      






      
 <!--end of modal-->




      

   <?php


$nro_cocheras=0;
   // $branch=$_SESSION['branch'];
    $query1=mysqli_query($con,"select * from espacios ")or die(mysqli_error());

    while($row1=mysqli_fetch_array($query1)){

$nro_cocheras=$row1['numero'];
    }
$nro_cocheras++;
?>

              




                <div class="box-body">

                       <div class="row">
                    <div class="col-md-6 btn-print">


                  <div class="box-header">
                  <h3 class="box-title">Registrar tarifa</h3>
                </div><!-- /.box-header -->


        <form class="form-horizontal" method="post" action="tarifa_add.php" enctype='multipart/form-data'>


            <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Tipo de vehiculo</label>
                 
                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">

            <input type="text" class="form-control" id="nombre_tipo" name="nombre_tipo"   required>
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">
                
                    </div>
                    </div>

       
  
                    <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Valor por hora</label>
                 
                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
              
                 <input type="text" class="form-control" id="valor_hora" name="valor_hora"   required >
                      </div>
                    </div>
                           <div class="col-md-4 btn-print">
                
                    </div>
                    </div>

            <div class="row">
                    <div class="col-md-3 btn-print">
                      <div class="form-group">
                        <label for="date" >Valor por noche</label>
                 
                      </div><!-- /.form group -->
                    </div>
                       <div class="col-md-4 btn-print">
                      <div class="form-group">
              
                 <input type="text" class="form-control" id="valor_noche" name="valor_noche"   required >
                      <input type="hidden" class="form-control" id="valor_mes" name="valor_mes" value="0"  required >
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




          
        </form>

                    </div>

                       <div class="col-md-5 btn-print">


                  <div class="box-header">
                 <h3 class="box-title">Lista tarifas</h3>
                </div><!-- /.box-header -->
                <form>
              

</form>      



                                       <table id="example2" class="table table-bordered table-striped">
                    <thead>
                      <tr>

                
                        
                        <th>Tipo vehiculo</th>
                        <th>Hora (S/.)</th>
                        <th>Noche (S/.)</th>
                

                 
 <th class="btn-print"> Accion </th>
                      </tr>
                    </thead>
                    <tbody>
<?php
   // $branch=$_SESSION['branch'];
    $query=mysqli_query($con,"select * from tarifa ")or die(mysqli_error());
    $i=0;
    while($row=mysqli_fetch_array($query)){
    $id_tarifa=$row['id_tarifa'];

?>
                      <tr >



              <td><?php echo $row['tipo_vehiculo'];?></td>
              <td><?php echo $row['valor_hora'];?></td>
<td><?php echo $row['valor_noche'];?></td>


                   

     
                          <td>
                                 <?php
                   
                    
                      ?>
 
<a class="btn btn-danger btn-print" href="<?php  echo "modificar_tarifas.php?id_tarifa=$id_tarifa";?>"  role="button">Modificar</a>
<a class="btn btn-success btn-print" href="<?php  echo "eliminar_tarifas.php?id_tarifa=$id_tarifa";?>"  role="button">Eliminar</a>
             <?php
            //          }
                      ?>

            </td>
                      </tr>

 <!--end of modal-->

<?php }?>
                    </tbody>

                  </table>
                             <script type="text/javascript">// < ![CDATA[
function Eliminar (i) {
    document.getElementsByTagName("table")[0].setAttribute("id","tableid");
    document.getElementById("tableid").deleteRow(i);
}
function Buscar() {
            var tabla = document.getElementById('example_cliente');
            var busqueda = document.getElementById('txtBusqueda_cliente').value.toLowerCase();
            var cellsOfRow="";
            var found=false;
            var compareWith="";
            for (var i = 1; i < tabla.rows.length; i++) {
                cellsOfRow = tabla.rows[i].getElementsByTagName('td');
                found = false;
                for (var j = 0; j < cellsOfRow.length && !found; j++) { compareWith = cellsOfRow[j].innerHTML.toLowerCase(); if (busqueda.length == 0 || (compareWith.indexOf(busqueda) > -1))
                    {
                        found = true;
                    }
                }
                if(found)
                {
                    tabla.rows[i].style.display = '';
                } else {
                    tabla.rows[i].style.display = 'none';
                }
            }
        }
// ]]></script>
                    </div>

                    </div>
                
 
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
           "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],


  "searching": true,
                }

              );
              } );
    </script>




    <!-- /gauge.js -->
  </body>
</html>
