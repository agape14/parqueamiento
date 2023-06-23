<?php
session_start();
include '../../dist/includes/dbcon.php';
//$branch=$_SESSION['branch'];
date_default_timezone_set("America/Lima");
$placa = $_POST['placa'];
$tipo  = $_POST['tipo'];
$marca = $_POST['marca'];

$modelo     = $_POST['modelo'];
$color      = $_POST['color'];
$id_cliente = $_POST['id_cliente'];

$id_espacios = $_POST['id_espacios'];

$q_espaciolibre = mysqli_query($con, "SELECT * FROM espacios WHERE id_espacios='$id_espacios' AND estado = 'disponible' ORDER BY id_espacios ASC LIMIT 1") or die(mysqli_error($con));
$count_disponible         = mysqli_num_rows($q_espaciolibre);
if ($count_disponible==0) {
    $q_espaciolibre = mysqli_query($con, "SELECT * FROM espacios WHERE estado = 'disponible' ORDER BY id_espacios ASC LIMIT 1") or die(mysqli_error($con));
    $r_espaciolibre    = mysqli_fetch_array($q_espaciolibre);
    $id_espacios = $r_espaciolibre['id_espacios'];
}



$query2        = mysqli_query($con, "SELECT * from vehiculo where TRIM(placa)=TRIM('$placa')  ORDER BY id_vehiculo ASC LIMIT 1 ") or die(mysqli_error($con));
$count         = mysqli_num_rows($query2);
$r_vehiculo    = mysqli_fetch_array($query2);
$r_id_vehiculo = $r_vehiculo['id_vehiculo'];
$estado_vehiculo = $r_vehiculo['estado_vehiculo'];

if ($count > 0) {
    
    if ($estado_vehiculo =='disponible') {
         mysqli_query($con, "update vehiculo set tipo='$tipo'  where id_vehiculo='$r_id_vehiculo'  ") or die(mysqli_error());
        echo "<script>document.location='entradas_add.php?id_espacios=$id_espacios&id_vehiculo=$r_id_vehiculo'</script>";
        
    }else{
        $querycochera        = mysqli_query($con, "SELECT * from espacios where TRIM(UPPER(placa))=TRIM(UPPER( '$placa'))  ORDER BY id_espacios ASC LIMIT 1 ") or die(mysqli_error($con));
        $r_cochera     = mysqli_fetch_array($querycochera);
        $numero = $r_cochera['numero'];
        echo "<script type='text/javascript'>alert('Verifique la placa: ".$placa." porque esta ocupado en la cochera: #".$numero."');</script>";
        echo "<script>document.location='estadia_nuevo_vehiculo.php?id_espacios=$id_espacios'</script>";
    }
    
} else {

    if ($id_cliente == 0) {
        echo "<script type='text/javascript'>alert('dni de cliente no esta registrado! tiene que registrar cliente primero!');</script>";
        echo "<script>document.location='estadia_nuevo_vehiculo.php?id_espacios=$id_espacios'</script>";
    }
    if ($id_cliente > 0) {
        mysqli_query($con, "INSERT INTO vehiculo(placa,tipo,marca,modelo,color,id_cliente,estado_vehiculo)
                VALUES(TRIM(UPPER( '$placa')),'$tipo','$marca','$modelo','$color','$id_cliente','disponible') ") or die(mysqli_error($con));

        $query4 = mysqli_query($con, "select * from vehiculo where TRIM(UPPER(placa))=TRIM(UPPER( '$placa')) ") or die(mysqli_error());
        $i      = 1;
        while ($row4 = mysqli_fetch_array($query4)) {
            $id_vehiculo = $row4['id_vehiculo'];
        }

        echo "<script>document.location='entradas_add.php?id_espacios=$id_espacios&id_vehiculo=$id_vehiculo'</script>";
    }

}
