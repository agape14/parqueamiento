<?php session_start();
if (empty($_SESSION['id'])):
    header('Location:../index.php');
endif;
date_default_timezone_set("America/Lima");
include '../../dist/includes/dbcon.php';

if (isset($_REQUEST['id_entrada'])) {
    $id_entrada = $_REQUEST['id_entrada'];
} else {
    $id_entrada = $_POST['id_entrada'];
}

mysqli_query($con, "update entradas set estado=0 where id_entrada='$id_entrada' ") or die(mysqli_error($con));
echo "<script>document.location='listado_tickets.php'</script>";
