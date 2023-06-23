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
		                            <li class="active"><a href="#tab1primary" data-toggle="tab">Listado de Tickets Revertidos</a></li>
		                        </ul>
		                </div>
		                <div class="panel-body">
		                    <div class="tab-content">
		                        <div role="tabpanel" class="tab-pane active" id="tab1primary">
		                        	<form method="post" action="listado_tickets_revertidos.php" enctype="multipart/form-data" class="form-horizontal">
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
									<table id="tblListTicketsRev" class="table table-bordered table-striped">
											<thead>
												<tr>
													<th style="width:10%">Codigo</th>
													<th style="width:10%">Registro</th>
													<th style="width:12%">Placa</th>
													<th style="width:20%">Tipo</th>
													<th style="width:25%">Cochera</th>
													<th style="width:12%">Usuario </th>
													<th style="width:12%">Anulacion </th>
												</tr>
											</thead>
										<tbody>
										<?php if (isset($_POST['buscar_fechastik'])) {
    $fecha    = $_POST['fecha'];
    $fechafin = $_POST['fechafin'];
    $query    = mysqli_query($con, "SELECT a.id_entrada,a.codigo ,
					CONCAT(a.fecha,' ',a.hora_ingreso) registro,
					v.placa,t.tipo_vehiculo ,CONCAT('Cochera ',e.numero) cochera,
					b.usuario ,DATE_FORMAT(a.fec_anulacion, '%d/%m/%Y %H:%i:%s') anulacion
					FROM entradas_anulacion a
					INNER JOIN usuario b ON a.usuario_id_anulacion=b.id
					INNER JOIN vehiculo v ON a.vehiculo=v.id_vehiculo
					LEFT JOIN tarifa t ON v.tipo=t.id_tarifa
					INNER JOIN espacios e ON e.id_espacios=a.lugar
					WHERE DATE_FORMAT(a.fec_anulacion, '%Y-%m-%d')  >='$fecha' AND DATE_FORMAT(a.fec_anulacion, '%Y-%m-%d')<='$fechafin' ") or die(mysqli_error());
    $i = 1;
    while ($row = mysqli_fetch_array($query)) {
        $id_entrada = $row['id_entrada'];
        $codigo     = $row['codigo'];
        ?>

											<tr >
											<td><?php echo $row['codigo']; ?></td>
											<td><?php echo $row['registro']; ?></td>
											<td><?php echo $row['placa']; ?></td>
											<td><?php echo $row['tipo_vehiculo']; ?></td>
											<td><?php echo $row['cochera']; ?></td>
											<td><?php echo $row['usuario']; ?></td>
											<td><?php echo $row['anulacion']; ?></td>
											</tr>

											<?php
}
}
?>
										</tbody>

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

	$('#tblListTicketsRev').dataTable( {
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
		"pageLength": 1000
	});

	var table = $('#tblListTicketsRev').DataTable();

  $(".dataTables_empty").text("No existen registros...");

	});
</script>
</body>
</html>
