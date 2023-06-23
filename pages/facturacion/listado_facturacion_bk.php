<?php include '../layout/header.php';?>
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
           <div class="col-md-12">
             <form method="post" action="listado_facturacion.php" enctype="multipart/form-data"
						class="form-horizontal">

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
           </div>
       </div>
<div class="box-body">
<section class="content-header"></section>


	<div class="box-header">
		<h3 class="box-title"> Listado de Boletas</h3>
	</div><!-- /.box-header -->
	<div class="box-body">

		<table id="tblListadoBoletas" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th style="width:12%">Boleta</th>
					<th style="width:8%">Fecha</th>
					<th style="width:25%">Cliente</th>
					<th style="width:6%">Subtotal</th>
					<th style="width:6%">IGV</th>
					<th style="width:6%">Total </th>
					<th style="width:9%">Estado </th>
					<th style="width:5%">Emitido </th>
					<th style="width:20%" class="btn-print">Acciones </th>
				</tr>
			</thead>
		<tbody>
		<?php if (isset($_POST['buscar_fechasfac'])) {
    $fecha    = $_POST['fecha'];
    $fechafin = $_POST['fechafin'];
    $query    = mysqli_query($con, "SELECT  facturacion_id, tipo,CONCAT( serie,'-',numero) serienro,serie,numero, date_format(fecha, '%d/%m/%Y') fecha, cliente_nom, facturacion_subtotal,
 facturacion_igv, facturacion_total, facturacion_estado,
CASE WHEN facturacion_estado='0' THEN 'Aceptado' WHEN facturacion_estado='0' THEN facturacion_estado_descripcion ELSE '' END fact_estado,
CASE WHEN facturacion_emitido=0 THEN 'NO' WHEN facturacion_emitido=1 THEN 'SI' ELSE '' END emitido,facturacion_emitido FROM facturacion_cab
		WHERE date_format(fecha, '%Y-%m-%d') >='$fecha' AND date_format(fecha, '%Y-%m-%d')<='$fechafin' ") or die(mysqli_error());
    $i = 1;
    while ($row = mysqli_fetch_array($query)) {
        $id_entrada     = $row['id_entrada'];
        $facturacion_id = $row['facturacion_id'];
        $tipo           = $row['tipo'];
        $serie          = $row['serie'];
        $numero         = $row['numero'];
        ?>

			<tr >
			<td><?php echo $row['serienro']; ?></td>
			<td><?php echo $row['fecha']; ?></td>
			<td><?php echo $row['cliente_nom']; ?></td>
			<td><?php echo $row['facturacion_subtotal']; ?></td>
			<td><?php echo $row['facturacion_igv']; ?></td>
			<td><?php echo $row['facturacion_total']; ?></td>
			<td><?php echo $row['fact_estado']; ?></td>
			<td><?php echo $row['emitido']; ?></td>
			<td>
				<?php if ($row['facturacion_emitido'] == '1') {
            ?>
            <button type="button" class="btn btn-success" id="btnImprimir" onClick="ImprimirBoleta('<?php echo $tipo; ?>','<?php echo $serie; ?>','<?php echo $numero; ?>')" ><i class="fa fa-print"></i> Print</button>
				<?php }?>
				<?php if ($row['facturacion_emitido'] == '1' && $row['fact_estado'] != 'Aceptada') {
            ?>
				<button type="button" class="btn btn-danger" id="btnImprimir" onClick="ReenviarBoleta('<?php echo $facturacion_id; ?>')" ></i> Reenviar</button>
            <?php }?>
			</td>
			</tr>

			<?php
}
}
?>
		</tbody>
	<footer>

		<div class="clearfix"></div>
		</footer>
        <!-- /footer content -->
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
            },
            "info":false,
            "lengthChange":false,
            "searching":true,
        });

    });

    function ImprimirBoleta(tip_docum,serie,nro_doc)
    {
      window.open('../../api_cpe/BETA/10755005211/10755005211-'+tip_docum+'-'+serie+'-'+nro_doc+'.PDF', '_blank');
    }
    function ReenviarBoleta(idboleta){
    	alert('En Desarrollo');
    }
    </script>
    </body>
    </html>
