<?php include '../layout/header.php';?>
<?php
$nro_doc_emp  = "";
$tip_doc_emp  = "";
$nom_com_emp  = "";
$raz_soc_emp  = "";
$dir_empresa  = "";
$telfono_emp  = "";
$correo_emp   = "";
$ubig_emp     = "";
$dpto_emp     = "";
$prov_emp     = "";
$dist_emp     = "";
$cod_pais_emp = "";
$pass_fir_emp = "";
$user_sec_fir = "";
$pass_sec_fir = "";
$moneda_emp   = "";
$tipoproceso  = 3;
$q_emp        = mysqli_query($con, "SELECT * FROM empresa WHERE id_empresa=1; ") or die(mysqli_error());
while ($r_emp = mysqli_fetch_array($q_emp)) {
    $nro_doc_emp  = $r_emp['ruc'];
    $tip_doc_emp  = $r_emp['tipo_doc'];
    $raz_soc_emp  = $r_emp['razon_social'];
    $nom_com_emp  = $r_emp['nombre_comercial'];
    $dir_empresa  = $r_emp['direccion'];
    $telfono_emp  = $r_emp['telefono'];
    $correo_emp   = $r_emp['correo'];
    $ubig_emp     = $r_emp['ubigeo'];
    $dpto_emp     = $r_emp['departamento'];
    $prov_emp     = $r_emp['provincia'];
    $dist_emp     = $r_emp['distrito'];
    $cod_pais_emp = $r_emp['cod_pais'];
    $pass_fir_emp = $r_emp['contrasenia_firma'];
    $user_sec_fir = $r_emp['user_sec_firma'];
    $pass_sec_fir = $r_emp['pass_sec_firma'];
    $moneda_emp   = $r_emp['simbolo_moneda'];
    $tipoproceso  = $r_emp['tipo_proceso'];
}
$id_entradas = 0;
if (isset($_REQUEST['id_entrada'])) {
    $id_entradas = $_REQUEST['id_entrada'];
}
$comp_tipo   = "";
$comp_serie  = "";
$comp_numero = "";
$comprobante = mysqli_query($con, "SELECT serieDoc,LPAD(correlativo+1,8,'0')  numero ,correlativo+1,codDoc FROM config_facturacion WHERE idConfig=1 ") or die(mysqli_error());
while ($row_com = mysqli_fetch_array($comprobante)) {
    $comp_tipo   = $row_com['codDoc'];
    $comp_serie  = $row_com['serieDoc'];
    $comp_numero = $row_com['numero'];
}

$fecha_ent     = "";
$tip_doc_cli   = "";
$nro_doc_cli   = "";
$nom_cli       = "";
$ape_cli       = "";
$dir_cli       = "";
$telefono_cli  = "";
$correo_cli    = "";
$subtotal      = 0;
$igv           = 0;
$total         = 0;
$igvfn         = 0;
$subtotfn      = 0;
$totfn         = 0;
$id_fact       = 0;
$codigoticket  = "";
$fecha_ingreso = "";
$fecha_salida  = "";
$hora_ingreso  = "";
$hora_salida   = "";
$placaticket   = "";
$entradas      = mysqli_query($con, "select * from entradas AS e
                            INNER JOIN vehiculo AS v ON e.vehiculo = v.id_vehiculo
                            INNER JOIN clientes AS c ON c.id_cliente = v.id_cliente
                            WHERE e.id_entrada='$id_entradas' ") or die(mysqli_error());
while ($row_ent = mysqli_fetch_array($entradas)) {
    $fecha_ent    = $row_ent['fecha'];
    $tip_doc_cli  = 1;
    $nro_doc_cli  = $row_ent['dni'];
    $nom_cli      = $row_ent['nombre'];
    $ape_cli      = $row_ent['apellido'];
    $dir_cli      = $row_ent['direccion'];
    $telefono_cli = $row_ent['telefono'];
    $correo_cli   = $row_ent['correo'];
    $total        = $row_ent['pago'];
    $igv          = $total * 0.18;
    $subtotal     = $total - $igv;
    $totfn        = $totfn + $total;
    $igvfn        = $igvfn + $igv;
    $subtotfn     = $subtotfn + $subtotal;
    if (!is_null($row_ent['facturacion_id'])) {
        $id_fact = $row_ent['facturacion_id'];
    }
    $codigoticket  = $row_ent['codigo'];
    $fecha_ingreso = $row_ent['fecha'];
    $fecha_salida  = $row_ent['fecha_salida'];
    $hora_ingreso  = $row_ent['hora_ingreso'];
    $hora_salida   = $row_ent['hora_salida'];
    $placaticket   = $row_ent['placa'];
}
if ($id_fact > 0) {
    echo "<script>document.location='listado_tickets.php'</script>";
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
                      <!-- FORM -->
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-laptop"></i>Facturacion Electronica</h3>
            </div>
            <div class="panel-body">
                <div class="offset-xl-2 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12 padding">
                <div class="card">
                <div class="card-header p-4">
                 <div class="float-right">
                    <div class="col-sm-3 padno">
                        <span>...</span>
                        <select name ="txtID_TIPO_DOCUMENTO" id="txtID_TIPO_DOCUMENTO" class="form-control"  >
                        <option value=''>SELECCIONE</option>
                        <option value='01'>FACTURA</option>
                        <option value='03' selected="true">BOLETA</option>
                        <option value='07'>NOTA CREDITO</option>
                        <option value='08'>NOTA DEBITO</option>
                        </select>
                    </div>
                    <div class="col-sm-3 padno">
                        <span>Serie</span>
                        <input type="text" id="txtSERIE" onChange="generar_num_docu()" name="txtSERIE" class="form-control" placeholder="Serie" value="<?php echo $comp_serie; ?>" />
                    </div>
                    <div class="col-sm-3 padno2">
                        <span>Numero</span>
                        <input type="text" id="txtNUMERO" name="txtNUMERO" placeholder="Numero" class="form-control" value="<?php echo $comp_numero ?>" />
                    </div>
                    <div class="col-sm-3 padno">
                        <span>Fecha</span>
                        <input type="text" id="txtFECHA_DOCUMENTO" onChange="cargar_tc()" class="form-control" name="txtFECHA_DOCUMENTO" placeholder="Fecha" value="<?php echo $fecha_ent; ?>" />
                    </div>
                 </div>
                </div>
                <div class="card-body ">
                 <div class="row mb-4" >
                     <div class="col-sm-6 " style="background-color: #EAF2F8;border-radius: 5px;margin-top: 1em;">
                        <h2 class="mb-3">Emisor:</h2>
                        <div class="form-group row">
                            <div class="col col-sm-4">
                                <label>Tipo Documento:</label>
                                    <select id="txtTIPO_DOCUMENTO_EMPRESA" onchange="info_cliente()" name="txtTIPO_DOCUMENTO_EMPRESA" class="form-control" />
                                    <option value='0'>NO DOMICILIADO(OTROS)</option>
                                    <option value='6' selected="true">RUC</option>
                                    <option value='1' >DNI</option>
                                    <option value='4'>CARNET EXTRANJERIA</option>
                                    <option value='7'>PASAPORTE</option>
                                    <option value='A'>CED. DIPLOMATICA DE IDENTIDAD</option>
                                    </select>
                            </div>
                            <div class="col col-sm-8">
                                <label>Nro. Documento:</label>
                                <input type="text" id="txtNRO_DOCUMENTO_EMPRESA" onkeyup="BuscarCliente()" name="txtNRO_DOCUMENTO_EMPRESA" value="<?php echo $nro_doc_emp; ?>" size="17" class="form-control" />
                            </div>
                        </div>
                         <label>Razon Social:</label>
                         <input type="text" id="txtNOMBRE_COMERCIAL_EMPRESA" name="txtNOMBRE_COMERCIAL_EMPRESA" class="form-control" value="<?php echo $nom_com_emp; ?>" size="30"  placeholder="RAZON SOCIAL" />
                         <input type="hidden" id="txtRAZON_SOCIAL_EMPRESA" name="txtRAZON_SOCIAL_EMPRESA" value="<?php echo $raz_soc_emp; ?>">
                         <input type="hidden" id="txtCODIGO_UBIGEO_EMPRESA" name="txtCODIGO_UBIGEO_EMPRESA" value="<?php echo $ubig_emp; ?>" >
                         <input type="hidden" id="txtDEPARTAMENTO_EMPRESA" name="txtDEPARTAMENTO_EMPRESA" value="<?php echo $dpto_emp; ?>">
                         <input type="hidden" id="txtPROVINCIA_EMPRESA" name="txtPROVINCIA_EMPRESA" value="<?php echo $prov_emp; ?>">
                         <input type="hidden" id="txtDISTRITO_EMPRESA" name="txtDISTRITO_EMPRESA" value="<?php echo $dist_emp; ?>">
                         <input type="hidden" id="txtCODIGO_PAIS_EMPRESA" name="txtCODIGO_PAIS_EMPRESA" value="<?php echo $cod_pais_emp; ?>">
                         <input type="hidden" id="txtCONTRA" name="txtCONTRA" value="<?php echo $pass_fir_emp; ?>">
                         <input type="hidden" id="txtUSERSECFIRM" name="txtUSERSECFIRM" value="<?php echo $user_sec_fir; ?>">
                         <input type="hidden" id="txtPASSSECFIRM" name="txtPASSSECFIRM" value="<?php echo $pass_sec_fir; ?>">
                         <input type="hidden" id="txtTIPO_PROCESO" name="txtTIPO_PROCESO" value="<?php echo $tipoproceso; ?>">
                         <input type="hidden" id="txtID_MONEDA" name="txtID_MONEDA" value="PEN">
                         <input name="txtSUB_TOTAL" type="hidden" id="txtSUB_TOTAL" value="<?php echo $subtotfn; ?>" class="form-control" />
                         <input name="txtIGV" type="hidden" id="txtIGV" value="<?php echo $igvfn; ?>" class="form-control" />
                         <input name="txtTOTAL" type="hidden" id="txtTOTAL" value="<?php echo number_format($totfn, 2, '.', ','); ?>" class="form-control" />
                         <label>Direccion:</label>
                         <input type="text" id="txtDIRECCION_EMPRESA" name="txtDIRECCION_EMPRESA" class="form-control" value="<?php echo $dir_empresa; ?>"  size="30" />
                        <input type="hidden" id="txtIdEntrada" name="txtIdEntrada" class="form-control" value="<?php echo $id_entradas; ?>"/>

                        <input type="hidden" id="txtCodigoTicket" name="txtCodigoTicket" class="form-control" value="<?php echo $codigoticket; ?>"/>
                        <input type="hidden" id="txtFechaIngreso" name="txtFechaIngreso" class="form-control" value="<?php echo $fecha_ingreso; ?>"/>
                        <input type="hidden" id="txtFechaSalida" name="txtFechaSalida" class="form-control" value="<?php echo $fecha_salida; ?>"/>
                        <input type="hidden" id="txtHoraIngreso" name="txtHoraIngreso" class="form-control" value="<?php echo $hora_ingreso; ?>"/>
                        <input type="hidden" id="txtHoraSalida" name="txtHoraSalida" class="form-control" value="<?php echo $hora_salida; ?>"/>
                        <input type="hidden" id="txtPlacaTicket" name="txtPlacaTicket" class="form-control" value="<?php echo $placaticket; ?>"/>
                        <div><label>Correo:</label> <?php if ($correo_emp != "") {echo $correo_emp;} else {echo "";}?></div>
                         <div><label>Telefono:</label> <?php if ($telfono_emp != "") {echo $telfono_emp;} else {echo "";}?></div>
                         <div>...</div>
                     </div>
                     <div class="col-sm-6 " style="background-color:#F4ECF7;border-radius: 5px;margin-top: 1em;">
                         <h2 class="mb-3">Cliente:</h2>
                         <div class="form-group row">
                            <div class="col col-sm-4">
                                <label>Tipo Documento:</label>
                                    <select id="txtTIPO_DOCUMENTO_CLIENTE" onchange="info_cliente()" name="txtTIPO_DOCUMENTO_CLIENTE" class="form-control"/>
                                    <option value='0'>NO DOMICILIADO(OTROS)</option>
                                    <option value='6' >RUC</option>
                                    <option value='1' selected="true">DNI</option>
                                    <option value='4'>CARNET EXTRANJERIA</option>
                                    <option value='7'>PASAPORTE</option>
                                    <option value='A'>CED. DIPLOMATICA DE IDENTIDAD</option>
                                    </select>
                            </div>
                            <div class="col col-sm-8">
                                <label>Nro. Documento:</label>
                                <input type="text" id="txtRUC" onkeyup="BuscarCliente()" name="txtRUC" value="<?php echo $nro_doc_cli; ?>" size="17" class="form-control" />
                            </div>
                        </div>
                         <label>Razon Social:</label>
                         <input type="text" id="txtRAZON_SOCIAL" name="txtRAZON_SOCIAL" class="form-control" value="<?php echo $nom_cli . ' ' . $ape_cli; ?>" size="30"  placeholder="RAZON SOCIAL" />
                         <label>Direccion:</label>
                         <input type="text" id="txtDIRECCION" name="txtDIRECCION" class="form-control" value="<?php echo $dir_cli; ?>"  size="30" />
                         <div><label>Correo:</label> <?php if ($correo_cli != "") {echo $correo_cli;} else {echo "";}?></div>
                         <div><label>Telefono:</label> <?php if ($telefono_cli != "") {echo $telefono_cli;} else {echo "";}?></div>
                         <div>...</div>
                     </div>
                 </div>
                 <div class="table-responsive-sm">
                    <h3>Detalle:</h3>
                     <table class="table table-striped table-bordered" id="tblDetalleComp">
                         <thead style="background-color: #337AB7; color: white;">
                             <tr>
                                 <th scope="col">#</th>
                                 <th scope="col">Descripcion</th>
                                 <th scope="col">Und/Med</th>
                                 <th scope="col">Precio</th>
                                 <th scope="col">Cantidad</th>
                                 <th scope="col ">Total</th>
                             </tr>
                         </thead>
                         <tbody>
                            <?php
$entr_det = mysqli_query($con, "select * from entradas AS e
                            INNER JOIN vehiculo AS v ON e.vehiculo = v.id_vehiculo
                            INNER JOIN clientes AS c ON c.id_cliente = v.id_cliente
                            WHERE e.id_entrada='$id_entradas' ") or die(mysqli_error());
while ($r_entd = mysqli_fetch_array($entr_det)) {?>
                             <tr>
                                 <td scope="row">1</td>
                                 <td >SERVICIO DE ESTACIONAMIENTO <?php echo $r_entd['placa']; ?></td>
                                 <td >NIU</td>
                                 <td ><?php echo number_format($r_entd['pago'], 2, '.', ',') ?></td>
                                 <td >1</td>
                                 <td align="right"><?php echo number_format($r_entd['pago'], 2, '.', ','); ?></td>
                             </tr>
                             <?php }?>
                         </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" align="right" style="font-weight: bold;">Subtotal</td>
                                <td align="right" style="font-weight: bold;"><?php echo number_format($subtotal, 2, '.', ','); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right" style="font-weight: bold;">IGV (18%)</td>
                                <td align="right" style="font-weight: bold;"><?php echo number_format($igv, 2, '.', ','); ?></td>
                            </tr>
                            <tr>
                                <td colspan="5" align="right" style="font-weight: bold;">Total</td>
                                <td align="right" style="font-weight: bold; font-size: 1.2em;"><?php echo number_format($total, 2, '.', ','); ?></td>
                            </tr>
                        </tfoot>
                     </table>
                 </div>
                </div>
                <div class="card-footer bg-white">
                    <button onClick="GuardarBoleta()" id="btnGuardar" class="btn btn-success"><i class="fa fa-save"></i> Guardar</button>
                    <button type="button" class="btn btn-default" id="btnImprimir" onClick="ImprimirBoleta()" disabled="true"><i class="fa fa-print"></i> Imprimir</button>
                    <button type="button" class="btn btn-default" onClick="nuevo()" disabled="true"><i class="fa fa-file-o"></i> Nuevo</button>
                    <button type="button" class="btn btn-danger" onClick="Retornar()"><i class="fa fa-rotate-left"></i> Retornar</button>
                </div>
                </div>
                </div>
            </div>
        </div>
      </div>

   </div>

   <?php include '../layout/datatable_script.php';?>
   <script src="../../css_js/numero_letras.js" type="text/javascript"></script>
   <script>
      $(document).ready( function() {

      $('#tblDetalle').dataTable( {
          "language": {
              "paginate": {
                  "previous": "anterior",
                  "next": "posterior"
              },
              "search": "Buscar:",
          },
          "info": false,
          "lengthChange": false,
          "searching": false,
      });

      });

      function GuardarBoleta(){
        var table = $('#tblDetalleComp').DataTable();
        var lista = table.rows().data();
        //var rows = table.rows( 0 ).data();
        //alert( JSON.stringify(data.toArray()));return;

        var tipo_doc = $('#txtTIPO_DOCUMENTO_CLIENTE').val();

        if (tipo_doc == "6") {
            var valRUC = ValidarRUC(document.getElementById("txtRUC").value);
            if (valRUC == '0') {
                return;
            }
        } else if (tipo_doc == "1" && $('#txtRUC').val().length != 8) {
            alert('El nro DNI debe tener 8 Digitos');
            return;
        }
        if (lista.length == 0) {
            alert('Agregue un Articulo como Minimo');
            return;
        }

        var i = 0;
        var rowData;
        var DATA = [];
        for (i = 0; i < lista.length; i++) {
            detalle = {};

            detalle["txtITEM"] = i + 1;
            detalle["txtUNIDAD_MEDIDA_DET"] = lista[i][2];
            detalle["txtCANTIDAD_DET"] = lista[i][4];
            detalle["txtPRECIO_DET"] = lista[i][3];
            detalle["txtSUB_TOTAL_DET"] = lista[i][5]; //PRECIO * CANTIDAD
            detalle["txtPRECIO_TIPO_CODIGO"] = "01";
            detalle["txtIGV"] = lista[i][5]*0.18;
            detalle["txtISC"] = "0";
            detalle["txtIMPORTE_DET"] = lista[i][5];//rowData.IMPORTE; //SUB_TOTAL + IGV
            detalle["txtCOD_TIPO_OPERACION"] = "10";
            detalle["txtCODIGO_DET"] = "00"+lista[i][0];
            detalle["txtDESCRIPCION_DET"] = lista[i][1];
            detalle["txtPRECIO_SIN_IGV_DET"] = redondeo(parseFloat(lista[i][5]) / parseFloat(1.18),2);
            DATA.push(detalle);
        }

        var total_letras = NumeroALetras($("#txtTOTAL").val());

        var motivo = ''
        if (typeof $('#txtID_MOTIVO').val() !== 'undefined') {
            motivo = '';
        } else {
            motivo = $("#txtID_MOTIVO :selected").text();
        }
        var parametros={
                "txtTIPO_OPERACION": "0101",
                "txtTOTAL_GRAVADAS": $("#txtSUB_TOTAL").val(),
                "txtSUB_TOTAL": $("#txtSUB_TOTAL").val(),
                "txtPOR_IGV": "18.00",
                "txtTOTAL_IGV": $("#txtIGV").val(),
                "txtTOTAL": $("#txtTOTAL").val(),
                "txtTOTAL_LETRAS": total_letras, //"SETECIENTOS TREINTA Y SIETE CON 50/100 SOLES",
                "txtNRO_COMPROBANTE": $('#txtSERIE').val() + '-' + $('#txtNUMERO').val(),
                "txtFECHA_DOCUMENTO": $('#txtFECHA_DOCUMENTO').val(), //$("#txtTOTAL").val(),
                "txtFECHA_VTO": $('#txtFECHA_DOCUMENTO').val(),//campo nuevo
                "txtCOD_TIPO_DOCUMENTO": $('#txtID_TIPO_DOCUMENTO').val(), //01=factura,03=boleta
                "txtCOD_MONEDA": $('#txtID_MONEDA').val(),
                //==========documentos de referencia(nota credito, debito)=============
                "txtTIPO_COMPROBANTE_MODIFICA": $('#txtID_TIPO_DOCUMENTO_MODIFICA').val(),
                "txtNRO_DOCUMENTO_MODIFICA": $('#txtNRO_DOC_MODIFICA').val(),
                "txtCOD_TIPO_MOTIVO": $('#txtID_MOTIVO').val(),
                "txtDESCRIPCION_MOTIVO": motivo, //$("[name='txtID_MOTIVO'] option:selected").text(),
                //=================datos del cliente=================
                "txtNRO_DOCUMENTO_CLIENTE": $('#txtRUC').val(),
                "txtRAZON_SOCIAL_CLIENTE": $('#txtRAZON_SOCIAL').val(),
                "txtTIPO_DOCUMENTO_CLIENTE": $('#txtTIPO_DOCUMENTO_CLIENTE').val(), //DNI
                "txtDIRECCION_CLIENTE": $('#txtDIRECCION').val(),
                "txtCIUDAD_CLIENTE": "LIMA",
                "txtCOD_PAIS_CLIENTE": "PE",
                //===================datos de la empresa===================
                "txtNRO_DOCUMENTO_EMPRESA": $('#txtNRO_DOCUMENTO_EMPRESA').val(),
                "txtTIPO_DOCUMENTO_EMPRESA": $('#txtTIPO_DOCUMENTO_EMPRESA').val(),
                "txtNOMBRE_COMERCIAL_EMPRESA": $('#txtNOMBRE_COMERCIAL_EMPRESA').val(),
                "txtCODIGO_UBIGEO_EMPRESA": $('#txtCODIGO_UBIGEO_EMPRESA').val(),
                "txtDIRECCION_EMPRESA": $('#txtDIRECCION_EMPRESA').val(),
                "txtDEPARTAMENTO_EMPRESA": $('#txtDEPARTAMENTO_EMPRESA').val(),
                "txtPROVINCIA_EMPRESA": $('#txtPROVINCIA_EMPRESA').val(),
                "txtDISTRITO_EMPRESA": $('#txtDISTRITO_EMPRESA').val(),
                "txtCODIGO_PAIS_EMPRESA": $('#txtCODIGO_PAIS_EMPRESA').val(),
                "txtRAZON_SOCIAL_EMPRESA": $('#txtRAZON_SOCIAL_EMPRESA').val(),
                //"txtTELEFONO_EMPRESA": "353-1099",
                "txtFORMATO_IMPRESION": "1",//1=A4, 2=TICKET
                //==================datos sunat====================
                "txtUSUARIO_SOL_EMPRESA": $('#txtUSERSECFIRM').val(), //"MODDATOS",
                "txtPASS_SOL_EMPRESA": $('#txtPASSSECFIRM').val(), //"moddatos",
                "txtTIPO_PROCESO": $('#txtTIPO_PROCESO').val(), //3=beta,2=homologacion,1=produccion
                "txtPAS_FIRMA":$('#txtCONTRA').val(),
                "txtESTADO_COMP": "",
                "txtDESC_ESTADO_COMP": "",
                "txtHASH_COMP":"",
                //====================datos del ticket===================
                "txtCodigoTicket":$('#txtCodigoTicket').val(),
                "txtFechaIngreso":$('#txtFechaIngreso').val(),
                "txtFechaSalida":$('#txtFechaSalida').val(),
                "txtHoraIngreso":$('#txtHoraIngreso').val(),
                "txtHoraSalida":$('#txtHoraSalida').val(),
                "txtPlacaTicket":$('#txtPlacaTicket').val(),
                //====================detalle del comprobante===================
                "detalle": DATA
            };
            var params=JSON.stringify(parametros);
        $.ajax({
            url: "../../controller/controller_cpe.php",
            type: "post",
            dataType: 'json',
            data: params,
            success: function (response) {
                alert(response.msj_sunat);
                if (response.cod_sunat == "0") {
                    var nwepar=[parametros];
                    nwepar[0]["txtESTADO_COMP"]=response.cod_sunat;
                    nwepar[0]["txtDESC_ESTADO_COMP"]=response.msj_sunat;
                    nwepar[0]["txtHASH_COMP"]=response.hash_cpe;
                    nwepar[0]["txtIdEntrada"]=$('#txtIdEntrada').val();
                    var parabd=JSON.stringify(nwepar);
                    $.ajax({
                        url: "guardarComprobante.php",
                        type: "post",
                        dataType: 'json',
                        data: parabd,
                        success: function (response) {
                            console.log(response);
                            $("#btnGuardar").prop('disabled', true);
                            $("#btnImprimir").prop('disabled', false);
                        },
                        error: function (data) {
                            console.log(data);
                            alert('Error Al conectar la Base Datos');
                        }
                    });
                }
                console.log(response);
            },
            error: function (data) {
                console.log(data);
                alert('Error al enviar el archivo a Sunat');
            }
        });

      }
      function Retornar(){
        location.href = "listado_tickets.php";
      }
      function ImprimirBoleta(){
        var ruc_empresa=$('#txtNRO_DOCUMENTO_EMPRESA').val();
        var tip_docum=$('#txtID_TIPO_DOCUMENTO').val();
        var serie_doc=$('#txtSERIE').val();
        var nro_doc=$('#txtNUMERO').val();
        window.open('../../api_cpe/BETA/'+ruc_empresa+'/'+ruc_empresa+'-'+tip_docum+'-'+serie_doc+'-'+nro_doc+'.PDF', '_blank');
      }
      deshabilitarComprobante();
      deshabilitarEmisor();
      deshabilitarCliente();
      function deshabilitarComprobante(){
        $("#txtID_TIPO_DOCUMENTO").prop('disabled', true);
        $("#txtSERIE").prop('disabled', true);
        $("#txtNUMERO").prop('disabled', true);
        $("#txtFECHA_DOCUMENTO").prop('disabled', true);
      }
      function deshabilitarEmisor(){
        $("#txtTIPO_DOCUMENTO_EMPRESA").prop('disabled', true);
        $("#txtNRO_DOCUMENTO_EMPRESA").prop('disabled', true);
        $("#txtNOMBRE_COMERCIAL_EMPRESA").prop('disabled', true);
        $("#txtDIRECCION_EMPRESA").prop('disabled', true);
      }
      function deshabilitarCliente(){
        $("#txtTIPO_DOCUMENTO_CLIENTE").prop('disabled', true);
        $("#txtRUC").prop('disabled', true);
        $("#txtRAZON_SOCIAL").prop('disabled', true);
        $("#txtDIRECCION").prop('disabled', true);
      }
      function ValidarRUC(rucVal) {
            var regEx = /\d{11}/;
            var ruc = new String(rucVal);

            if (ruc.length != 11) {
                alert("¡ALERTA: El RUC " + ruc + " NO es valido!. SI NO TIENE UNO SELECCIONE BOLETA");
                return 0;
            }

            if (regEx.test(ruc)) {
                var factores = new String("5432765432");
                var ultimoIndex = ruc.length - 1;
                var sumaTotal = 0, residuo = 0;
                var ultimoDigitoRUC = 0, ultimoDigitoCalc = 0;

                for (var i = 0; i < ultimoIndex; i++) {
                    sumaTotal += (parseInt(ruc.charAt(i)) * parseInt(factores.charAt(i)));
                }
                residuo = sumaTotal % 11;

                ultimoDigitoCalc = (residuo == 10) ? 0 : ((residuo == 11) ? 1 : (11 - residuo) % 10);
                ultimoDigitoRUC = parseInt(ruc.charAt(ultimoIndex));

                if (ultimoDigitoRUC == ultimoDigitoCalc) {
                    return 1;
                } else {
                    alert("¡ALERTA: El RUC " + ruc + " NO es valido!. SI NO TIENE UNO SELECCIONE BOLETA");
                    return 0;
                }
            } else {
                alert("ALERTA : El RUC no es valido, debe constar de 11 caracteres numericos. SI NO TIENE UNO SELECCIONE BOLETA");
                document.getElementById("txtRUC").focus();
                return 0;
            }
        }
        function redondeo(numero, decimales) {
            var flotante = parseFloat(numero);
            var resultado = Math.round(flotante * Math.pow(10, decimales)) / Math.pow(10, decimales);
            return resultado;
        }
   </script>
</body>
</html>