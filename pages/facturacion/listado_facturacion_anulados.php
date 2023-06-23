<?php
session_start();
include '../layout/header.php';?>
<?php if (isset($_POST['buscar_fechasfac'])) {
    $fecha    = $_POST['fecha'];
    $fechafin = $_POST['fechafin'];
} else {
    $fecha    = date('Y-m-d');
    $fechafin = date('Y-m-d');
}

?>
    <link rel="stylesheet" href="../layout/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../layout/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../layout/plugins/select2/select2.min.css">
    <link rel="stylesheet" href="../layout/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../layout/dist/css/navboots.css">
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <?php include '../layout/main_sidebar.php';?>
       <?php include '../layout/top_nav.php';?>
<div class="right_col" role="main">
      <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class = "x-panel"></div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel with-nav-tabs panel-primary">
                        <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab1primary" data-toggle="tab">Listado de Boletas</a></li>
                                </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="tab1primary">
                                    <form method="post" action="listado_facturacion_anulados.php" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="form-inline col-md-12">
                                              <div class="form-group">
                                                <div class="input-group col-sm-5">
                                                  <input type="date" class="form-control " id="fecha" name="fecha"  value="<?php echo $fecha; ?>" required >
                                                </div>
                                              </div><!-- /.form group -->
                                              <label  class="col-sm-2 control-label">Fechas: </label>
                                                <div class="input-group col-sm-3">
                                                  <input type="date" class="form-control " id="fechafin" name="fechafin"  value="<?php echo $fechafin; ?>" required >
                                                </div>
                                              <button class="btn btn-lg btn-danger " id="daterange-btn"  name="buscar_fechasfac">BUSCAR POR FECHAS</button>
                                            </div>
                                    </form>
                                    <table id="tblListadoBoletas" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:11%">Boleta</th>
                                            <th style="width:8%">Fecha</th>
                                            <th style="width:15%">Cliente</th>
                                            <th style="width:8%">Tipo</th>
                                            <th style="width:6%">Subtotal</th>
                                            <th style="width:6%">IGV</th>
                                            <th style="width:6%">Total </th>
                        <?php
if ($tipo == "administrador") {
    ?>
                                            <th style="width:10%">Registro </th>
                        <?php
}
?>
                                            <th style="width:8%">Estado </th>
                                            <th style="width:5%">Usuario </th>
                                            <th style="width:25%" class="btn-print">Acciones </th>
                                        </tr>
                                    </thead>
                                <tbody>
        <?php if (isset($_POST['buscar_fechasfac'])) {
    $fecha    = $_POST['fecha'];
    $fechafin = $_POST['fechafin'];
    $query    = mysqli_query($con, "SELECT  f.facturacion_id, f.tipo,CONCAT( f.serie,'-',f.numero) serienro, f.serie,f.numero, date_format(f.fecha, '%d/%m/%Y') fecha, f.cliente_nom, f.facturacion_subtotal,f.facturacion_igv, f.facturacion_total, f.facturacion_estado,CASE WHEN f.facturacion_estado='0' THEN 'Aceptado' WHEN f.facturacion_estado='0' THEN f.facturacion_estado_descripcion ELSE '' END fact_estado,CASE WHEN f.facturacion_emitido=0 THEN 'NO' WHEN f.facturacion_emitido=1 THEN 'SI' ELSE '' END emitido,f.facturacion_emitido,g.usuario, DATE_FORMAT(f.fec_registro, '%d/%m/%Y %H:%i') fec_registro,t.tipo_vehiculo
        FROM facturacion_cab f
        LEFT JOIN entradas AS e ON e.facturacion_id=f.facturacion_id
        INNER JOIN vehiculo AS v ON e.vehiculo = v.id_vehiculo
        INNER JOIN tarifa t ON v.tipo=t.id_tarifa
        LEFT JOIN usuario g ON f.usuario_id=g.id
        WHERE date_format(f.fecha, '%Y-%m-%d') >='$fecha' AND date_format(f.fecha, '%Y-%m-%d')<='$fechafin' AND facturacion_estado=2 ") or die(mysqli_error());
    $i = 1;
    while ($row = mysqli_fetch_array($query)) {
        $id_entrada     = $row['id_entrada'];
        $facturacion_id = $row['facturacion_id'];
        //$tipo           = $row['tipo'];
        $serie  = $row['serie'];
        $numero = $row['numero'];
        ?>

            <tr >
            <td><?php echo $row['serienro']; ?></td>
            <td><?php echo $row['fecha']; ?></td>
            <td><?php echo $row['cliente_nom']; ?></td>
            <td><?php echo $row['tipo_vehiculo']; ?></td>
            <td><?php echo $row['facturacion_subtotal']; ?></td>
            <td><?php echo $row['facturacion_igv']; ?></td>
            <td><?php echo $row['facturacion_total']; ?></td>
<?php if ($tipo == "administrador") {?>
            <td><?php echo $row['fec_registro']; ?></td>
<?php }?>
            <td><?php echo $row['fact_estado']; ?></td>
            <td><?php echo $row['usuario']; ?></td>
            <td>...</td>
            </tr>

            <?php
}
}
?>
        </tbody>
                                        <?php
if ($tipo == "administrador") {
    ?>
                <tfoot>
                    <tr>
                        <th colspan="6" style="text-align:right">Totales:</th>
                        <th></th>
                    </tr>
                </tfoot>
<?php
}
?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
  <?php include '../layout/datatable_script.php';?>
<script>
    $(document).ready( function() {

    $('#tblListadoBoletas').dataTable({
            "language":{
                "paginate":{
                    "previous":"anterior",
                    "next":"posterior"
                },
                "search":"Buscar:",
            },dom: 'Bfrtip',
            "buttons": [
                'copy', 'excel', 'csv', 'pdf', 'print'
            ],
            "info":false,
            "lengthChange":false,
            "searching":true,
            "pageLength": 1000,
            "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api();
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal = api
                .column( 6, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            $( api.column( 6 ).footer() ).html(
                'S/. '+pageTotal +' ( S/. '+ total +' total)'
            );
        }
        });
        $(".dataTables_empty").text("No existen registros...");
    });
    $(".dataTables_empty").text("No existen registros...");
    function ImprimirBoleta(tip_docum,serie,nro_doc)
    {
      window.open('../../api_cpe/BETA/10755005211/10755005211-'+tip_docum+'-'+serie+'-'+nro_doc+'.PDF', '_blank');
    }
    function ReenviarBoleta(idboleta){
        alert('En Desarrollo');
    }
    function AnularBoleta(idboleta){
        var opcion = confirm("¿Está seguro de anular la boleta?");
        if (opcion == true) {
            $.ajax({
                url: "setEstadoBoleta.php",
                type: "post",
                dataType: 'json',
                data: {idboleta:idboleta},
                success: function (response) {
                    if (response[0].success==1) {
                        alert(response[0].msg);
                        location.href='listado_facturacion.php?facturacion_id='+facturacion_id;
                    } else {
                        alert(response[0].msg);
                    }

                },
                error: function (data) {
                    console.log('DAtos  Tip Doc');
                    console.log(data);
                    alert('Error al anular la boleta');
                }
            });
        }

    }
    </script>
    </body>
    </html>
