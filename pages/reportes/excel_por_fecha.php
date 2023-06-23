<?php
include '../../dist/includes/dbcon.php'; //$branch=$_SESSION['branch'];

$fecha_inicio = $_POST['rfecha_inicio'];
$fecha_final  = $_POST['rfecha_final'];
$vehiculo     = $_POST['rvehiculo'];

$consulta = "select * from entradas AS e INNER JOIN vehiculo AS v
    ON e.vehiculo = v.id_vehiculo INNER JOIN clientes AS c
    ON c.id_cliente = v.id_cliente  where  fecha >='$fecha_inicio' and fecha <='$fecha_final' ";
if ($vehiculo != "") {
    $consulta .= " and v.tipo='$vehiculo' ";
}

$subtotal = 0;
$total    = 0;
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=excel_por_fecha.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
 <table border=1 cellspacing=0 cellpadding=2 bordercolor="black">
                    <center><p>REPORTE POR FECHAS </p></center>

  <P>COMENTARIOS:_______________________________________________________________________________</P>
                    <thead>



                      <tr>
                        <th>Codigo</th>
                        <th>Fecha entrada</th>
                        <th>Dia/noche</th>
                        <th>Cliente</th>
                        <th>Placa</th>
                        <th>Pago</th>
                        <th>Comprobante</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$consulta = "select * from entradas AS e INNER JOIN vehiculo AS v
    ON e.vehiculo = v.id_vehiculo INNER JOIN clientes AS c
    ON c.id_cliente = v.id_cliente  where  fecha >='$fecha_inicio' and fecha <='$fecha_final' ";
if ($vehiculo != "") {
    $consulta .= " and v.tipo='$vehiculo' ";
}
$query = mysqli_query($con, $consulta) or die(mysqli_error());
$i     = 1;
while ($row = mysqli_fetch_array($query)) {
    if ($row['pago'] != "" || $row['pago'] != null) {
        $subtotal = $subtotal + $row['pago'];
    }

}
?>


<?php
$consulta = "select * from entradas AS e INNER JOIN vehiculo AS v
    ON e.vehiculo = v.id_vehiculo INNER JOIN clientes AS c
    ON c.id_cliente = v.id_cliente  where  fecha >='$fecha_inicio' and fecha <='$fecha_final' ";
if ($vehiculo != "") {
    $consulta .= " and v.tipo='$vehiculo' ";
}
echo "<script>console.log("+$consulta+")</script>";

$query = mysqli_query($con, $consulta) or die(mysqli_error());
$i     = 1;
while ($row = mysqli_fetch_array($query)) {
    if ($row['pago'] != "" || $row['pago'] != null) {
        $subtotal = $subtotal + $row['pago'];
    }

    ?>

                      <tr >
                        <td><?php echo $row['codigo']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['dia_noche']; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['placa']; ?></td>
                        <td><?php echo number_format($row['pago'], 2); ?></td>
                        <td>Ticket</td>
                      </tr>


 <!--end of modal-->

<?php
}?>

                <tr >
                        <td colspan="5">TOTAL</td>
                        <td><?php echo number_format($subtotal / 2, 2); ?></td>
                        <td></td>
                      </tr>

                    </tbody>

                  </table>


