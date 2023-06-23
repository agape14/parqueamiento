<?php

//require_once('decode_64.php');
function cpeEnvio($ruc, $usuario_sol, $pass_sol, $ruta_archivo, $ruta_archivo_cdr, $archivo, $ruta_ws) {
    try {
        //=================ZIPEAR ================
        $zip = new ZipArchive();
        $filenameXMLCPE = $ruta_archivo . '.ZIP';

        if ($zip->open($filenameXMLCPE, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile($ruta_archivo . '.XML', $archivo . '.XML'); //ORIGEN, DESTINO
            $zip->close();
        }

        //===================ENVIO FACTURACION=====================
        $soapUrl = $ruta_ws; //"https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService"; // asmx URL of WSDL
        $soapUser = "";  //  username
        $soapPassword = ""; // password
        // xml post structure
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
    xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    <soapenv:Header>
        <wsse:Security>
            <wsse:UsernameToken>
                <wsse:Username>' . $ruc . $usuario_sol . '</wsse:Username>
                <wsse:Password>' . $pass_sol . '</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        <ser:sendBill>
            <fileName>' . $archivo . '.ZIP</fileName>
            <contentFile>' . base64_encode(file_get_contents($ruta_archivo . '.ZIP')) . '</contentFile>
        </ser:sendBill>
    </soapenv:Body>
    </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($xml_post_string),
        ); //SOAPAction: your op URL

        $url = $soapUrl;

        //echo $xml_post_string;
        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        //========
        //https://stackoverflow.com/questions/28858351/php-ssl-certificate-error-unable-to-get-local-issuer-certificate
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //=========
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        $err = curl_error($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //echo "rta: " . $err;
        //echo $httpcode;
        //echo "RTA SUNAT: " . $response;

        if ($response == "") {
            $mensaje['cod_sunat'] = "0000";
            $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO NO ESTA RETORNANDO CDR";
            $mensaje['hash_cdr'] = "";
            //echo 'fuera servicio';
            return $mensaje;
        }

        //if ($httpcode == 200) {//======LA PAGINA SI RESPONDE
        //echo $httpcode.'----'.$response;
        //convertimos de base 64 a archivo fisico
        $doc = new DOMDocument();
        $doc->loadXML($response);



        //===================VERIFICAMOS SI HA ENVIADO CORRECTAMENTE EL COMPROBANTE=====================
        if (isset($doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) {
            $xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
            file_put_contents($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP', base64_decode($xmlCDR));

            //extraemos archivo zip a xml
            $zip = new ZipArchive;
            if ($zip->open($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP') === TRUE) {
                try {
                    $zip->extractTo($ruta_archivo_cdr, 'R-' . $archivo . '.XML');
                    $zip->extractTo($ruta_archivo_cdr, 'R-' . $archivo . '.xml');
                } catch (Exception $ex) {
                    $zip->extractTo($ruta_archivo_cdr, 'R-' . $archivo . '.xml');
                }
                $zip->close();
            }

            //eliminamos los archivos Zipeados
            unlink($ruta_archivo . '.ZIP');
            unlink($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP');

            //=============hash CDR=================
            $doc_cdr = new DOMDocument();
            $doc_cdr->load(dirname(__FILE__) . '/' . $ruta_archivo_cdr . 'R-' . $archivo . '.XML');

            $mensaje['cod_sunat'] = $doc_cdr->getElementsByTagName('ResponseCode')->item(0)->nodeValue;
            $mensaje['msj_sunat'] = $doc_cdr->getElementsByTagName('Description')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = $doc_cdr->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        } else {
            //PARA SUNAT
            $mensaje['cod_sunat'] = str_replace("soap-env:Client.", "", $doc->getElementsByTagName('faultcode')->item(0)->nodeValue);
            $mensaje['msj_sunat'] = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = "";
            //para OSE
            //$mensaje['cod_sunat'] = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
            //$mensaje['msj_sunat'] = $doc->getElementsByTagName('message')->item(0)->nodeValue;
            //$mensaje['hash_cdr'] = "";
        }
    } catch (Exception $e) {
        $mensaje['cod_sunat'] = "0000";
        $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO: " . $e->getMessage();
        $mensaje['hash_cdr'] = "";
    }
    //print_r($mensaje); 
    return $mensaje;
    //$xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
}

function cpeEnvioBaja($ruc, $usuario_sol, $pass_sol, $ruta_archivo, $ruta_archivo_cdr, $archivo, $ruta_ws) {
    try {
        //=================ZIPEAR ================
        $zip = new ZipArchive();
        $filenameXMLCPE = $ruta_archivo . '.ZIP';

        if ($zip->open($filenameXMLCPE, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile($ruta_archivo . '.XML', $archivo . '.XML'); //ORIGEN, DESTINO
            $zip->close();
        }

        //===================ENVIO FACTURACION=====================
        $soapUrl = $ruta_ws;
        $soapUser = "";
        $soapPassword = "";
        // xml post structure
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
    xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    <soapenv:Header>
        <wsse:Security>
            <wsse:UsernameToken>
                <wsse:Username>' . $ruc . $usuario_sol . '</wsse:Username>
                <wsse:Password>' . $pass_sol . '</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        <ser:sendSummary>
            <fileName>' . $archivo . '.ZIP</fileName>
            <contentFile>' . base64_encode(file_get_contents($ruta_archivo . '.ZIP')) . '</contentFile>
        </ser:sendSummary>
    </soapenv:Body>
    </soapenv:Envelope>';

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($xml_post_string),
        ); //SOAPAction: your op URL

        $url = $soapUrl;

        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //if ($httpcode == 200) {//======LA PAGINA SI RESPONDE
        //echo $httpcode.'----'.$response;
        //convertimos de base 64 a archivo fisico
        $doc = new DOMDocument();
        $doc->loadXML($response);

        //===================VERIFICAMOS SI HA ENVIADO CORRECTAMENTE EL COMPROBANTE=====================
        if (isset($doc->getElementsByTagName('ticket')->item(0)->nodeValue)) {
            $ticket = $doc->getElementsByTagName('ticket')->item(0)->nodeValue;

            unlink($ruta_archivo . '.ZIP');

            $mensaje['cod_sunat'] = "0";
            $mensaje['msj_sunat'] = $ticket;
            $mensaje['hash_cdr'] = "";
        } else {
            $mensaje['cod_sunat'] = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
            $mensaje['msj_sunat'] = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = "";
        }
//    } else {
//        //echo "no responde web";
//        $mensaje['cod_sunat']="0000";
//        $mensaje['msj_sunat']="SUNAT ESTA FUERA SERVICIO";
//        $mensaje['hash_cdr'] = "";
//    }
    } catch (Exception $e) {
        $mensaje['cod_sunat'] = "0000";
        $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO: " . $e->getMessage();
        $mensaje['hash_cdr'] = "";
    }
    return $mensaje;
    //echo $xml_post_string;//$mensaje;
    //$xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
}

function cpeEnvioResumenBoleta($ruc, $usuario_sol, $pass_sol, $ruta_archivo, $ruta_archivo_cdr, $archivo, $ruta_ws) {
    //=================ZIPEAR ================
    $zip = new ZipArchive();
    $filenameXMLCPE = $ruta_archivo . '.ZIP';

    if ($zip->open($filenameXMLCPE, ZIPARCHIVE::CREATE) === true) {
        $zip->addFile($ruta_archivo . '.XML', $archivo . '.XML'); //ORIGEN, DESTINO
        $zip->close();
    }

    //===================ENVIO FACTURACION=====================
    $soapUrl = $ruta_ws;
    $soapUser = "";
    $soapPassword = "";
    // xml post structure
    $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" 
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" 
    xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
    <soapenv:Header>
        <wsse:Security>
            <wsse:UsernameToken>
                <wsse:Username>' . $ruc . $usuario_sol . '</wsse:Username>
                <wsse:Password>' . $pass_sol . '</wsse:Password>
            </wsse:UsernameToken>
        </wsse:Security>
    </soapenv:Header>
    <soapenv:Body>
        <ser:sendSummary>
            <fileName>' . $archivo . '.ZIP</fileName>
            <contentFile>' . base64_encode(file_get_contents($ruta_archivo . '.ZIP')) . '</contentFile>
        </ser:sendSummary>
    </soapenv:Body>
    </soapenv:Envelope>';

    $headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: ",
        "Content-length: " . strlen($xml_post_string),
    ); //SOAPAction: your op URL

    $url = $soapUrl;

    // PHP cURL  for https connection with auth
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // converting
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode == 200) {//======LA PAGINA SI RESPONDE
        //echo $httpcode.'----'.$response;
        //convertimos de base 64 a archivo fisico
        $doc = new DOMDocument();
        $doc->loadXML($response);

        //===================VERIFICAMOS SI HA ENVIADO CORRECTAMENTE EL COMPROBANTE=====================
        if (isset($doc->getElementsByTagName('ticket')->item(0)->nodeValue)) {
            $ticket = $doc->getElementsByTagName('ticket')->item(0)->nodeValue;

            unlink($ruta_archivo . '.ZIP');

            $mensaje['cod_sunat'] = "0";
            $mensaje['msj_sunat'] = $ticket;
            $mensaje['hash_cdr'] = "";
        } else {
            $mensaje['cod_sunat'] = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
            $mensaje['msj_sunat'] = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = "";
        }
    } else {
        //echo "no responde web";
        $mensaje['cod_sunat'] = "0000";
        $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO";
        $mensaje['hash_cdr'] = "";
    }
    return $mensaje;
    //echo $xml_post_string;//$mensaje;
    //$xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
}

function consultaEnvioTicket($ruc, $usuario_sol, $pass_sol, $ticket, $archivo, $ruta_archivo_cdr, $ruta_ws) {
    $ruta_ws;
    $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
<soapenv:Header>
<wsse:Security>
<wsse:UsernameToken>
<wsse:Username>' . $ruc . $usuario_sol . '</wsse:Username>
<wsse:Password>' . $pass_sol . '</wsse:Password>
</wsse:UsernameToken>
</wsse:Security>
</soapenv:Header>
<soapenv:Body>
<ser:getStatus>
<ticket>' . $ticket . '</ticket>
</ser:getStatus>
</soapenv:Body>
</soapenv:Envelope>';

    $headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: ",
        "Content-length: " . strlen($xml_post_string),
    ); //SOAPAction: your op URL

    $ruta_ws;

    // PHP cURL  for https connection with auth
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $ruta_ws);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // converting
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode == 200) {//======LA PAGINA SI RESPONDE
        //echo $httpcode.'----'.$response;
        //convertimos de base 64 a archivo fisico
        $doc = new DOMDocument();
        $doc->loadXML($response);



        //===================VERIFICAMOS SI HA ENVIADO CORRECTAMENTE EL COMPROBANTE=====================
        if (isset($doc->getElementsByTagName('content')->item(0)->nodeValue)) {
            $xmlCDR = $doc->getElementsByTagName('content')->item(0)->nodeValue;
            file_put_contents($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP', base64_decode($xmlCDR));

            //extraemos archivo zip a xml
            $zip = new ZipArchive;
            if ($zip->open($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP') === TRUE) {
                $zip->extractTo($ruta_archivo_cdr, 'R-' . $archivo . '.XML');
                $zip->close();
            }

            //eliminamos los archivos Zipeados
            //unlink($ruta_archivo . '.ZIP');
            unlink($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP');

            //=============hash CDR=================
            $doc_cdr = new DOMDocument();
            $doc_cdr->load(dirname(__FILE__) . '/' . $ruta_archivo_cdr . 'R-' . $archivo . '.XML');

            $mensaje['cod_sunat'] = $doc_cdr->getElementsByTagName('ResponseCode')->item(0)->nodeValue;
            $mensaje['msj_sunat'] = $doc_cdr->getElementsByTagName('Description')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = $doc_cdr->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        } else {
            $mensaje['cod_sunat'] = $doc->getElementsByTagName('faultcode')->item(0)->nodeValue;
            $mensaje['msj_sunat'] = $doc->getElementsByTagName('faultstring')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = "";
        }
    } else {
        //echo "no responde web";
        $mensaje['cod_sunat'] = "0000";
        $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO";
        $mensaje['hash_cdr'] = "";
    }
    return $mensaje;
}

function cpeEnvioGuiaRemision($ruc, $usuario_sol, $pass_sol, $ruta_archivo, $ruta_archivo_cdr, $archivo, $ruta_ws) {
    try {
        //=================ZIPEAR ================
        $zip = new ZipArchive();
        $filenameXMLCPE = $ruta_archivo . '.ZIP';

        if ($zip->open($filenameXMLCPE, ZIPARCHIVE::CREATE) === true) {
            $zip->addFile($ruta_archivo . '.XML', $archivo . '.XML'); //ORIGEN, DESTINO
            $zip->close();
        }

        //===================ENVIO FACTURACION=====================
        $soapUrl = $ruta_ws; //"https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService"; // asmx URL of WSDL
        $soapUser = "";  //  username
        $soapPassword = ""; // password
        // xml post structure
        $xml_post_string = "<soapenv:Envelope xmlns:soapenv='http://schemas.xmlsoap.org/soap/envelope/' 
                        xmlns:ser='http://service.sunat.gob.pe' 
                        xmlns:wsse='http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd'> 
                        <soapenv:Header> 
                        <wsse:Security> 
                        <wsse:UsernameToken> 
                        <wsse:Username>" . $usuario_sol . "</wsse:Username> 
                        <wsse:Password>" . $pass_sol . "</wsse:Password> 
                        </wsse:UsernameToken> 
                        </wsse:Security> 
                        </soapenv:Header> 
                        <soapenv:Body> 
                        <ser:sendBill> 
                        <fileName>" . $archivo . ".ZIP</fileName> 
                        <contentFile>" . base64_encode(file_get_contents($ruta_archivo . '.ZIP')) . "</contentFile> 
                        </ser:sendBill> 
                        </soapenv:Body> 
                        </soapenv:Envelope>";

        $headers = array(
            "Content-type: text/xml;charset=\"utf-8\"",
            "Accept: text/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "SOAPAction: ",
            "Content-length: " . strlen($xml_post_string),
        ); //SOAPAction: your op URL

        $url = $soapUrl;

        //echo $xml_post_string;
        // PHP cURL  for https connection with auth
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, true);
        //========
        //https://stackoverflow.com/questions/28858351/php-ssl-certificate-error-unable-to-get-local-issuer-certificate
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //=========
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // converting
        $response = curl_exec($ch);
        $err = curl_error($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        //echo "rta: " . $err;
        //echo $httpcode;
        //echo "RTA SUNAT: " . $response;

        if ($response == "") {
            $mensaje['cod_sunat'] = "0000";
            $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO NO ESTA RETORNANDO CDR";
            $mensaje['hash_cdr'] = "";
            //echo 'fuera servicio';
            return $mensaje;
        }

        //if ($httpcode == 200) {//======LA PAGINA SI RESPONDE
        //echo $httpcode.'----'.$response;
        //convertimos de base 64 a archivo fisico
        $doc = new DOMDocument();
        $doc->loadXML($response);

        //===================VERIFICAMOS SI HA ENVIADO CORRECTAMENTE EL COMPROBANTE=====================
        if (isset($doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) {
            $xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
            file_put_contents($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP', base64_decode($xmlCDR));

            //extraemos archivo zip a xml
            $zip = new ZipArchive;
            if ($zip->open($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP') === TRUE) {
                $zip->extractTo($ruta_archivo_cdr, 'R-' . $archivo . '.XML');
                $zip->close();
            }

            //eliminamos los archivos Zipeados
            unlink($ruta_archivo . '.ZIP');
            unlink($ruta_archivo_cdr . 'R-' . $archivo . '.ZIP');

            //=============hash CDR=================
            $doc_cdr = new DOMDocument();
            $doc_cdr->load(dirname(__FILE__) . '/' . $ruta_archivo_cdr . 'R-' . $archivo . '.XML');

            $mensaje['cod_sunat'] = $doc_cdr->getElementsByTagName('ResponseCode')->item(0)->nodeValue;
            $mensaje['msj_sunat'] = $doc_cdr->getElementsByTagName('Description')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = $doc_cdr->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        } else {
            //PARA SUNAT
            $mensaje['cod_sunat'] = str_replace("soap-env:Client.", "", $doc->getElementsByTagName('faultstring')->item(0)->nodeValue);
            $mensaje['msj_sunat'] = $doc->getElementsByTagName('message')->item(0)->nodeValue;
            $mensaje['hash_cdr'] = "";
        }
    } catch (Exception $e) {
        $mensaje['cod_sunat'] = "0000";
        $mensaje['msj_sunat'] = "SUNAT ESTA FUERA SERVICIO: " . $e->getMessage();
        $mensaje['hash_cdr'] = "";
    }
    //print_r($mensaje); 
    return $mensaje;
    //$xmlCDR = $doc->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
}

function getStatusFacturaIntegrada($Jsondata) {
    /* iniciamos variables data */
    $data = json_decode($Jsondata, true);
    $cliente_id = $data['cliente_id'];
    $client_secret = $data['client_secret'];
    $rucContribuyente = $data['rucContribuyente'];
    $rucEmpresaEmisora = $data['rucEmpresaEmisora'];
    $codComp = $data['codComp'];
    $numeroSerie = $data['numeroSerie'];
    $numero = $data['numero'];
    $fecha = $data['fecha'];
    $monto = $data['monto'];
    /* fin data */
    $curl = curl_init();
    /* PARA HACER PARAMETROS DE TIPO: x-www-form-urlencoded */
    //https://www.pushsafer.com/en/pushapi
    $dataToken = array(
        'grant_type' => 'client_credentials',
        'scope' => urldecode("https://api.sunat.gob.pe/v1/contribuyente/contribuyentes"),
        'client_id' => urldecode($cliente_id),
        'client_secret' => $client_secret
    );

    $postString = http_build_query($dataToken, '', '&');

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api-seguridad.sunat.gob.pe/v1/clientesextranet/" . $cliente_id . "/oauth2/token/",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $postString,
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded"
        )
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        $mensaje['flg_rta'] = "0";
        $mensaje['mensaje'] = "ERROR TOKEN: " . $err;
        $mensaje['est_comprobante'] = "";
        $mensaje['est_ruc'] = "";
        $mensaje['con_domicilio'] = "";
    } else {
        $token = json_decode($response, true);
        /* DATA COMPROBANTE */
        $dataComprobante['numRuc'] = $data['rucEmpresaEmisora'];
        $dataComprobante['codComp'] = $data['codComp'];
        $dataComprobante['numeroSerie'] = $data['numeroSerie'];
        $dataComprobante['numero'] = $data['numero'];
        $dataComprobante['fechaEmision'] = $data['fecha'];
        $dataComprobante['monto'] = $data['monto'];
        /* ================= */
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.sunat.gob.pe/v1/contribuyente/contribuyentes/" . $rucContribuyente . "/validarcomprobante",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($dataComprobante, JSON_PRETTY_PRINT),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . $token['access_token'],
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $mensaje['flg_rta'] = "0";
            $mensaje['mensaje'] = "ERROR CONSULTAR COMPROBANTE: " . $err;
            $mensaje['est_comprobante'] = "";
            $mensaje['est_ruc'] = "";
            $mensaje['con_domicilio'] = "";
        } else {
            //echo $response;
            $rtaComprobante = json_decode($response, true);
            $mensaje['flg_rta'] = "1";
            $mensaje['mensaje'] = "CONSULTA EXITOSA";
            $mensaje['est_comprobante'] = $rtaComprobante['data']['estadoCp'];
            $mensaje['est_ruc'] = $rtaComprobante['data']['estadoRuc'];
            $mensaje['con_domicilio'] = $rtaComprobante['data']['condDomiRuc'];
            //echo $response;
        }
    }

    return $mensaje;
    //var_dump($mensaje);
}

/*
  $data['cliente_id'] = "5903d2fa-1906-4b7f-84ca-6bc34f73eca8";
  $data['client_secret'] = "Wu8dXf8gjh0oTgqyx27+XQ==";
  $data['rucContribuyente'] = "10447915125";
  $data['rucEmpresaEmisora'] = "20600695771";
  $data['codComp'] = "01";
  $data['numeroSerie'] = "FFF1";
  $data['numero'] = "065022";
  $data['fecha'] = "20/04/2021";
  $data['monto'] = "190.32";

  getStatusFacturaIntegrada(json_encode($data, JSON_PRETTY_PRINT));
 */

//cpeEnvio('10447915125', 'MODDATOS', 'moddatos', 'BETA/10447915125/10447915125-01-F001-0000003', 'BETA/10447915125/', '10447915125-01-F001-0000003', 'https://e-beta.sunat.gob.pe:443/ol-ti-itcpfegem-beta/billService');
//<wsse:Username>10447915125MODDATOS</wsse:Username>
//<wsse:Password>moddatos</wsse:Password>
//envio guia
//cpeEnvio('10447915125', 'MODDATOS', 'moddatos', 'BETA/10447915125/10447915125-01-F001-0000003', 'BETA/10447915125/', '10447915125-01-F001-0000003', 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService');
?>