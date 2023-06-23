

<?php include '../layout/header.php';

?>
<?php

if (isset($_POST['buscar_fechas'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final  = $_POST['fecha_final'];
    $vehiculo     = $_POST['vehiculo'];
}
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

        <!-- page content -->
        <div class="right_col" role="main">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class = "x-panel">

            </div>

        </div>
 </div>

 <div class="container">
           <div class="col-md-3">

           </div>
           <div class="col-md-3">
  <form id="frmExcelPorFecha" action="excel_por_fecha.php" enctype="multipart/form-data" method="post">
        <input type="hidden" id="rfecha_inicio" name="rfecha_inicio" />
        <input type="hidden" id="rfecha_final"  name="rfecha_final" />
        <input type="hidden" id="rvehiculo" name="rvehiculo" />
    </form>
             <form method="post" action="reportes_por_fecha.php" enctype="multipart/form-data" class="form-horizontal">
                    <div class="col-md-12 btn-print">
                      <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Fecha inicio</label>
                        <div class="input-group col-sm-8">
                          <input type="date" class="form-control pull-right" id="fecha_inicio" name="fecha_inicio" value="<?php echo ($fecha_inicio); ?>" required >
                        </div><!-- /.input group -->
                      </div><!-- /.form group -->
                    </div>
                    <div class="col-md-12 btn-print">
                      <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Fecha final</label>
                        <div class="input-group col-sm-8">
                          <input type="date" class="form-control pull-right" id="fecha_final" name="fecha_final" value="<?php echo ($fecha_inicio); ?>" required >
                        </div><!-- /.input group -->
                      </div><!-- /.form group -->
                    </div>
                    <div class="col-md-12 btn-print">
                      <div class="form-group">
                        <label for="vehiculo" class="col-sm-4 control-label">Vehiculo</label>
                        <div class="input-group col-sm-8">
                            <select class="form-control  select2" id="vehiculo" name="vehiculo" >
                              <option value="" <?php echo ($vehiculo == "") ? 'selected = "selected"' : ''; ?> >Seleccionar</option>
                              <?php $queryc = mysqli_query($con, "select * from tarifa") or die(mysqli_error());
while ($rowc = mysqli_fetch_array($queryc)) {
    ?>
                                <option value="<?php echo $rowc['id_tarifa']; ?>" <?php echo ($rowc['id_tarifa'] == $vehiculo) ? 'selected = "selected"' : ''; ?> ><?php echo $rowc['tipo_vehiculo']; ?></option>
                              <?php }?>
                            </select>
                        </div><!-- /.input group -->
                      </div><!-- /.form group -->
                    </div>
                    <button class="btn btn-lg btn-danger btn-print" id="daterange-btn"  name="buscar_fechas">BUSCAR ENTRE FECHAS</button>

                  <div class="col-md-12">
                  <div class="col-md-12"></div>
                  </div>

          </form>
           </div>
           <div class="col-md-3">

           </div>
       </div>
 <!--end of modal-->

                        <div class="box-body">
                  <!-- Date range -->  <section class="content-header">

          </section>

 <a class = "btn btn-success btn-print" href = "" onclick = "window.print()"><i class ="glyphicon glyphicon-print"></i> Impresión</a>
<button class="btn btn-success btn-print" onclick = "exportarExcel();" id="btnExportarExcel"  name="btnExportarExcel">Exportar Excel</button>
                  <div class="box-header">
                  <h3 class="box-title"> Lista datos</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                   <thead>
                      <tr>
                        <th style="width:10%">Codigo</th>
                        <th style="width:10%">Fecha entrada</th>
                        <th style="width:10%">Dia/noche</th>
                        <th style="width:30%">Cliente</th>
                        <th style="width:10%">Placa</th>
                        <th style="width:10%"> Pago </th>
                        <th style="width:20%"> Comprobante </th>
                      </tr>
                    </thead>
                    <tbody>







  <div class = "row">
        <div class = "col-md-4 col-lg-12 hide-section">
  <a class="btn btn-danger btn-print"    disabled="true" style="height:25%; width:50%; font-size: 25px " role="button">Nro ELEMENTOS= <label style='color:black;  font-size: 25px '><?php echo $contador; ?></label></a>



</div>


</div>
<?php

if (isset($_POST['buscar_fechas'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final  = $_POST['fecha_final'];
    $vehiculo     = $_POST['vehiculo'];

    $consulta = "select * from entradas AS e INNER JOIN vehiculo AS v
    ON e.vehiculo = v.id_vehiculo INNER JOIN clientes AS c
    ON c.id_cliente = v.id_cliente  where  fecha >='$fecha_inicio' and fecha <='$fecha_final' ";
    if ($vehiculo != "") {
        $consulta .= " and v.tipo='$vehiculo' ";
    }

    $query    = mysqli_query($con, $consulta) or die(mysqli_error());
    $contador = 0;
    while ($row = mysqli_fetch_array($query)) {
        $contador++;
    }

    ?>
 <?php

    $query = mysqli_query($con, $consulta) or die(mysqli_error());
    $i     = 1;
    while ($row = mysqli_fetch_array($query)) {
        $codigo = $row['codigo'];
        ?>

                      <tr >
          <td><?php echo $row['codigo']; ?></td>
            <td><?php echo $row['fecha']; ?></td>

                        <td><?php echo $row['dia_noche']; ?></td>
                         <td><?php echo $row['nombre']; ?></td>
                              <td><?php echo $row['placa']; ?></td>
                        <td><?php echo $row['pago']; ?></td>
                        <td>Ticket</td>
                      </tr>

                                          <?php
}
}
?>


 <!--end of modal-->

                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" style="text-align:right">Totales:</th>
                            <th></th>
                        </tr>
                    </tfoot>








        <footer>

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
            "searching": true,
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Total over this page
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( 5 ).footer() ).html(
                'S/. '+pageTotal +' ( S/. '+ total +' total)'
            );
        }
                }

              );


              } );

       function exportarExcel(){
        //console.log('Exportando'); return;
        var p_fechainicio=$('#fecha_inicio').val();
        var p_fechafinal=$('#fecha_final').val();
        var p_vehiculo=$('#vehiculo').val();

        $('#rfecha_inicio').val(p_fechainicio);
        $('#rfecha_final').val(p_fechafinal);
        $('#rvehiculo').val(p_vehiculo);
        //window.location.href="excel_por_fecha.php?fecha_inicio="+p_fechainicio+"&fecha_final="+p_fechafinal+"&vehiculo="+p_vehiculo;
        //$.post("excel_por_fecha.php", {fecha_inicio: p_fechainicio, fecha_final: p_fechafinal, vehiculo: p_vehiculo});
          let form = document.getElementById("frmExcelPorFecha");
            form.submit()

       }
    </script>
  </body>
</html>
