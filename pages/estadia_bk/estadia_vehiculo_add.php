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

$query2 = mysqli_query($con, "select * from vehiculo where placa='$placa'") or die(mysqli_error($con));
$count  = mysqli_num_rows($query2);

if ($count > 0) {
    echo "<script type='text/javascript'>alert('placa ya existe escriba otra placa!');</script>";
    echo "<script>document.location='estadia_nuevo_vehiculo.php?id_espacios=$id_espacio'</script>";
} else {

    if ($id_cliente == 0) {
        echo "<script type='text/javascript'>alert('dni de cliente no esta registrado! tiene que registrar cliente primero!');</script>";
        echo "<script>document.location='estadia_nuevo_vehiculo.php?id_espacios=$id_espacios'</script>";
    }
    if ($id_cliente > 0) {
        mysqli_query($con, "INSERT INTO vehiculo(placa,tipo,marca,modelo,color,id_cliente)
				VALUES('$placa','$tipo','$marca','$modelo','$color','$id_cliente')") or die(mysqli_error($con));

        $query4 = mysqli_query($con, "select * from vehiculo where placa ='$placa' ") or die(mysqli_error());
        $i      = 1;
        while ($row4 = mysqli_fetch_array($query4)) {
            $id_vehiculo = $row4['id_vehiculo'];
        }

        echo "<script>document.location='entradas_add.php?id_espacios=$id_espacios&id_vehiculo=$id_vehiculo'</script>";
    }

}
