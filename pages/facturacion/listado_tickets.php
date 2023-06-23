<?php
session_start();
include '../layout/header.php';?>
<?php if (isset($_POST['buscar_fechastik'])) {
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
		                            <li class="active"><a href="#tab1primary" data-toggle="tab">Listado de Tickets</a></li>
		                        </ul>
		                </div>
		                <div class="panel-body">
		                    <div class="tab-content">
		                        <div role="tabpanel" class="tab-pane active" id="tab1primary">
		                        	<form method="post" action="listado_tickets.php" enctype="multipart/form-data" class="form-horizontal">
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
					                      <button class="btn btn-lg btn-danger " id="daterange-btn"  name="buscar_fechastik">BUSCAR POR FECHAS</button>
					                    </div>
							        </form>
									<table id="tblListadoTickets" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th style="width:6%">Codigo</th>
													<th style="width:8%">Ingreso</th>
													<th style="width:22%">Cliente</th>
													<th style="width:10%">Tipo</th>
													<th style="width:6%">Placa</th>
													<th style="width:8%">Pago </th>
<?php
if ($tipo == "administrador") {
    ?>
													<th style="width:10%">Registro </th>
<?php
}
?>
													<th style="width:10%">Usuario </th>
													<th style="width:20%" class="btn-print">Acciones </th>
												</tr>
											</thead>
										<tbody>
										<?php if (isset($_POST['buscar_fechastik'])) {
    $fecha    = $_POST['fecha'];
    $fechafin = $_POST['fechafin'];
    $query    = mysqli_query($con, "select e.id_entrada,e.codigo,date_format(e.fecha, '%d/%m/%Y') fecha,SUBSTR(e.hora_ingreso,1,5) horaingreso,e.dia_noche,
										v.id_vehiculo,v.placa,IFNULL(CAST(e.pago AS DECIMAL(18,2)) ,0) total,
										IFNULL(CONCAT(c.nombre,c.apellido)	,'') cliente,
										IFNULL(CONCAT(f.serie,'-',f.numero),'Ticket') comprobante,
										IFNULL(f.facturacion_estado,'') estado,
										IFNULL(f.facturacion_emitido,'') emitido,t.tipo_vehiculo,g.usuario,
										DATE_FORMAT(e.fec_registro, '%d/%m/%Y %H:%i') fec_registro
										from entradas AS e
										INNER JOIN vehiculo AS v ON e.vehiculo = v.id_vehiculo
										INNER JOIN tarifa t ON v.tipo=t.id_tarifa
										INNER JOIN clientes AS c ON c.id_cliente = v.id_cliente
										LEFT JOIN facturacion_cab f ON e.facturacion_id=f.facturacion_id
										LEFT JOIN usuario g ON e.usuario_id=g.id
										WHERE e.fecha_salida IS NOT NULL AND f.numero IS NULL AND e.estado=1 AND  e.fecha_salida >='$fecha' AND e.fecha_salida<='$fechafin' ") or die(mysqli_error());
    $i = 1;
    while ($row = mysqli_fetch_array($query)) {
        $id_entrada = $row['id_entrada'];
        $codigo     = $row['codigo'];
        ?>

											<tr >
											<td><?php echo $row['codigo']; ?></td>
											<td><?php echo $row['fecha'] . ' ' . $row['horaingreso']; ?></td>
											<td><?php echo $row['cliente']; ?></td>
											<td><?php echo $row['tipo_vehiculo']; ?></td>
											<td><?php echo $row['placa']; ?></td>
											<td><?php echo $row['total']; ?></td>
											<?php
if ($tipo == "administrador") {
            ?>
													<td><?php echo $row['fec_registro']; ?></td>
<?php
}
        ?>

											<td><?php echo $row['usuario']; ?></td>
											<td >
												<?php if ($row['emitido'] == '' || $row['emitido'] == '0') {?>
												<!--<a class="btn btn-success btn-print fa fa-file" href="<?php echo "ver_datos_facturacion.php?id_entrada=$id_entrada"; ?>"  role="button" data-toggle="tooltip" data-placement="top" title="Emitir ticket a Boleta">&nbsp;Boleta</a>-->
												<?php }?>
												<a class="btn btn-dark fa fa-print" href="<?php echo "../estadia/generar_ticket.php?codigo=$codigo&boletas=1"; ?>"  role="button" data-toggle="tooltip" data-placement="top" title="Imprimir Ticket"></a>
<?php if ($tipo == "administrador") {?>
												<a class="btn btn-danger fa fa-trash" href="<?php echo "eliminar_ticket.php?id_entrada=$id_entrada"; ?>"  role="button" data-toggle="tooltip" data-placement="top" title="Anular Ticket"></a>
<?php }?>
											</td>
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
								                <th colspan="5" style="text-align:right">Totales:</th>
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

	$('#tblListadoTickets').dataTable( {
		"language": {
			"paginate": {
				"previous": "anterior",
				"next": "posterior"
			},
			"search": "Buscar:",
		},dom: 'Bfrtip',
		"buttons": [
            'copy', 'excel', 'csv', 'pdf', 'print'
        ],
		"info": false,
		"lengthChange": false,
		"searching": true,
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            $( api.column( 5 ).footer() ).html(
                'S/. '+pageTotal +' ( S/. '+ total +' total)'
            );
        }
	});

	var table = $('#tblListadoTickets').DataTable();

  $(".dataTables_empty").text("No existen registros...");

	});
</script>
</body>
</html>
