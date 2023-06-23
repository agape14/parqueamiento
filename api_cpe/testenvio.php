<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" \r\n    xmlns:SOAP-ENV=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:ser=\"http://service.sunat.gob.pe\" \r\n    xmlns:wsse=\"http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd\">\r\n    <soapenv:Header>\r\n        <wsse:Security>\r\n            <wsse:UsernameToken>\r\n                <wsse:Username>20603823231FACUSU01</wsse:Username>\r\n                <wsse:Password>USUfac@a01</wsse:Password>\r\n            </wsse:UsernameToken>\r\n        </wsse:Security>\r\n    </soapenv:Header>\r\n    <soapenv:Body>\r\n        <ser:sendBill>\r\n            <fileName>20603823231-03-BP01-387462.ZIP</fileName>\r\n            <contentFile>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</contentFile>\r\n        </ser:sendBill>\r\n    </soapenv:Body>\r\n    </soapenv:Envelope>",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: text/xml",
    "postman-token: 63379646-4aad-2962-6878-05b9c7ede01d"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}