<?php
session_start();
include '../../dist/includes/dbcon.php';
date_default_timezone_set("America/Lima");

//$array = explode("/", $_SERVER['REQUEST_URI']);
$bodyRequest = file_get_contents("php://input");

// Decodifica el cuerpo de la solicitud y lo guarda en un array de PHP
$cab               = json_decode($bodyRequest, true);
$detallecab        = $cab[0]['detalle'];
$time              = time();
$tipdoc            = $cab[0]['txtCOD_TIPO_DOCUMENTO'];
$serie             = substr($cab[0]['txtNRO_COMPROBANTE'], 0, 4);
$numero            = substr($cab[0]['txtNRO_COMPROBANTE'], 5, 13);
$moneda            = $cab[0]['txtCOD_MONEDA'];
$fecdoc            = $cab[0]['txtFECHA_DOCUMENTO'];
$timestampa        = strtotime($fecdoc);
$new_fecdoc        = date('Y-m-d', $fecdoc);
$tipdoccli         = $cab[0]['txtTIPO_DOCUMENTO_CLIENTE'];
$numdoccli         = $cab[0]['txtNRO_DOCUMENTO_CLIENTE'];
$razsoccli         = $cab[0]['txtRAZON_SOCIAL_CLIENTE'];
$direccli          = $cab[0]['txtDIRECCION_CLIENTE'];
$ciudadcli         = $cab[0]['txtCIUDAD_CLIENTE'];
$paiscli           = $cab[0]['txtCOD_PAIS_CLIENTE'];
$subtotal          = $cab[0]['txtSUB_TOTAL'];
$igv               = $cab[0]['txtTOTAL_IGV'];
$total             = $cab[0]['txtTOTAL'];
$strtotal          = $cab[0]['txtTOTAL_LETRAS'];
$estadocomp        = $cab[0]['txtESTADO_COMP'];
$descestadocomp    = $cab[0]['txtDESC_ESTADO_COMP'];
$hashcomprobante   = $cab[0]['txtHASH_COMP'];
$total_descripcion = $cab[0]['txtTOTAL_LETRAS'];
$id_entrada        = $cab[0]['txtIdEntrada'];
$hora_comprobante  = date("H:i:s", $time);
$session_id        = $_SESSION['id'];

//print_r($fecdoc);return;
$q_insertfact = "INSERT INTO  facturacion_cab (
usuario_id ,  tipo ,  serie ,  numero ,  moneda ,  fecha ,  empresa_emisor_id ,
cliente_tipo_doc ,  cliente_nro_doc ,cliente_nom ,  cliente_dir ,  cliente_ciudad ,
cliente_pais ,facturacion_subtotal ,  facturacion_igv ,  facturacion_total ,
facturacion_total_desc, facturacion_estado ,facturacion_emitido,
facturacion_estado_descripcion,facturacion_hash,total_descripcion,hora_comprobante )
VALUES ('$session_id', '$tipdoc', '$serie', '$numero', '$moneda', '$fecdoc', '1',
'$tipdoccli', '$numdoccli','$razsoccli', '$direccli', '$ciudadcli',
'$paiscli', '$subtotal', '$igv', '$total',
'$strtotal', '$estadocomp', '1',
'$descestadocomp','$hashcomprobante','$total_descripcion','$hora_comprobante') ";
mysqli_query($con, $q_insertfact) or die(mysqli_error($con));
$cod_comprob = mysqli_insert_id($con);

for ($i = 0; $i < count($detallecab); $i++) {
    $item        = $detallecab[$i]["txtITEM"];
    $unmed       = $detallecab[$i]["txtUNIDAD_MEDIDA_DET"];
    $descripcion = $detallecab[$i]["txtDESCRIPCION_DET"];
    $cantidad    = $detallecab[$i]["txtCANTIDAD_DET"];
    $precio      = $detallecab[$i]["txtPRECIO_DET"];
    $subtotaldet = $detallecab[$i]["txtSUB_TOTAL_DET"];
    $igvdet      = $detallecab[$i]["txtIGV"];

    $q_insertfact_det = "INSERT INTO facturacion_det( facturacion_id ,  item_contador ,  item_unidad_med ,
item_nombre ,  item_cantidad ,  item_precio ,  item_importe ,  item_igv )
VALUES ( '$cod_comprob', '$item', '$unmed', '$descripcion', '$cantidad', '$precio', '$subtotaldet', '$igvdet')";
    mysqli_query($con, $q_insertfact_det) or die(mysqli_error($con));
}

$correlativo    = (int) $numero;
$nrocorrelativo = strval($correlativo);
mysqli_query($con, "UPDATE  config_facturacion SET correlativo ='$correlativo' WHERE codDoc ='$tipdoc'") or die(mysqli_error());

mysqli_query($con, "UPDATE  entradas SET facturacion_id ='$cod_comprob' WHERE id_entrada ='$id_entrada'") or die(mysqli_error());
echo ($cod_comprob);
