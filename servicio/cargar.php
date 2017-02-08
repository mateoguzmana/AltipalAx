 
<?php

require_once('../../SM/lib/nusoap.php');

ini_set('default_socket_timeout', 600000);

$wsdl = "http://190.144.195.125:8082/MicrosoftDynamicsAXAif60/SRFALTIPALServicesPortafolio/xppservice.svc?wsdl";
       //http://190.144.195.125:8082/MicrosoftDynamicsAXAif60/SRFALTIPALServiceConPreSalesInvent/xppservice.svc

$client = new nusoap_client($wsdl, TRUE);


$client->setCredentials("ALTIPAL\\victor.rodriguez", "srf.2014", 'ntlm');



//$client->setUseCurl($useCURL); 
$client->soap_defencoding = 'UTF-8';



$err = $client->getError(); /* * *Captura de errores** */
if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
    exit();
}


curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
echo '<h1>Prueba de Conexion -- </h1>';
echo '<pre>';



$result = $client->call('ConPreSalesInvent'); 

print_r($result); 

echo '</pre>';
echo $err = $client->getError();


if ($client->fault) {
    echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
    //print_r($result);
    echo '</pre>';
} else {
    //print_r($result);
    /*     * ****** */
    $err = $client->getError();
    if ($err) {
        echo '<h2>Error</h2><pre>' . $err . '</pre>';
    } else {
        //echo '<h2>Result</h2><pre>'; 
        foreach ($result as $item) {
            /*   echo 'AgencyName: '.$item['AgencyName'].'<br/>';
              echo 'AltipalClientId: '.$item['AltipalClientId'].'<br/>';
              echo 'AltipalEstablishmentId: '.$item['AltipalEstablishmentId'].'<br/>';
              echo 'Status: '.$item['Status'].'<br/>';
              echo 'TempClientId: '.$item['TempClientId'].'<br/>';
              echo 'AltipalSellerId: '.$item['AltipalSellerId'].'<br/>';
              echo 'AltipalSellerBusinessUnit: '.$item['AltipalSellerBusinessUnit'].'<br/>';
              echo 'AltipalSellerCity: '.$item['AltipalSellerCity'].'<br/>';

              echo '-----------------------------';
              echo '<br/>'; */
        }
    }
}


/* * *Procesos  ejecutados por el servicio** */
//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
//echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';














/* $wsdl = "http://190.144.218.16:8101/DynamicsAx/Services/srf_altipalServicesGroup";
  $client = new SoapClient($wsdl);

  $param = array();
  $retval= $client->SalesZonesInformation($param);

  echo $retval;

  var_dump($retval); */

/*
  require_once('lib/nusoap.php');

  $wsdl="http://apps.altipal.com.co/Services/BusinessProcess/ClientsProcess.svc?wsdl";
  $client=new nusoap_client($wsdl, 'wsdl');

  //$param = array('TempId' => 52115, 'AgencyName' => 'BOGOTA');

  $datos= $client->call('TestService','Edward')->TestServiceResult;

  //$retval=$datos['TestServiceResult'];
  var_dump($datos); //Verificar si hay resultado
 */




/*
  $wsdl = "http://apps.altipal.com.co/Services/BusinessProcess/ClientsProcess.svc?wsdl";
  $client = new SoapClient($wsdl);
  $retval= $client->TestService("Edward")->TestServiceResult;

  if ($retval)
  {
  echo "si";
  }
  else
  {
  echo "no";
  }


  var_dump($retval); //Verificar si hay resultado

 */











/*

  $code = $retval->TestServiceResult->ReturnCode;

  if ($code == "OK") {

  echo "<h1>Proceso correcto</h1>";

  }

  else {

  echo "<h1>Se ha producido error</h1>";

  echo "<h2>" + $retval->TestServiceResult->Message + "<h2>";

  }
 */

//$documento = array('TempId' => '52115', 'AgencyName' => 'BOGOTA');	
//$retval = $soapClient->Test();
//echo $retval;


/*
  $retval = $soapClient->TestService();

  $code = $retval->TestServiceResult->ReturnCode;

  echo $retval->TestServiceResult->ReturnCode;

  if ($code == "OK") {

  echo "<h1>Proceso correcto</h1>";

  }

  else {

  echo "<h1>Se ha producido error</h1>";

  echo "<h2>" + $retval->TestServiceResult->Message + "<h2>";

  } */








/*

  require_once('lib/nusoap.php');

  $wsdl="http://apps.altipal.com.co/Services/BusinessProcess/ClientsProcess.svc?wsdl";
  $client=new nusoap_client($wsdl, 'wsdl');

  //$param = array('TempId' => 52115, 'AgencyName' => 'BOGOTA');

  $datos= $client->call('TestService');
  echo $datos['TestServiceResult'];

 */


/*
  require('lib/nusoap.php');

  $wsdl = "http://apps.altipal.com.co/Services/BusinessProcess/ClientsProcess.svc?wsdl";
  $client = new SoapClient($wsdl);

  $param = array('TempId' => '52115', 'AgencyName' => 'BOGOTA');

  $result = $client->GetApprovalClientInfoByTempId($param);
  $EscalaDocumentos = $result->GetApprovalClientInfoByTempIdResult;
  $count1 = count($EscalaDocumentos->ApprovalClient);
  print $count1;

  //echo var_dump($EscalaClientes);

  echo "ok";


  print "<table>";

  foreach($EscalaDocumentos->DOCUMENTOSCC as $Documentos)
  {
  print "<tr>";
  print "<td>".$Documentos->CLIENTE."</td>";
  print "<td>".$Documentos->DOCUMENTO."</td>";
  print "<td>".$Documentos->TIPO."</td>";
  print "<td>".$Documentos->FECHA_DOCUMENTO."</td>";
  print "<td>".$Documentos->SALDO."</td>";
  print "</tr>";

  $nit_ws=$Documentos->CLIENTE;
  $factura=$Documentos->DOCUMENTO;

  $tipo=$Documentos->TIPO;
  $fecha_factura=$Documentos->FECHA_DOCUMENTO;
  $fecha_factura=str_replace("T00:00:00","",$fecha_factura);		// 2009-12-28T00:00:00

  $saldo=$Documentos->SALDO;
  $saldo=round($saldo);


  }
  print "</table>";

 */



/*
  require_once('lib/nusoap.php');

  $wsdl="http://apps.altipal.com.co/Services/BusinessProcess/ClientsProcess.svc?wsdl";
  $client=new nusoap_client($wsdl, 'wsdl');

  $param = array('TempId' => 52115, 'AgencyName' => 'BOGOTA');

  $datos= $client->call('GetApprovalClientInfoByTempId', $param);
  $de=$datos['GetApprovalClientInfoByTempIdResult']['ApprovalClient'];

  echo $de['Status'];
 */

//$json = json_decode($datos);
//echo "2: ".$json;



/*

  echo '<pre>';
  print_r($datos);
  echo '</pre>';

  try{
  //$arrayDatos=$datos['GetApprovalClientInfoByTempIdResult']['diffgram']['NewDataSet']['Table'];
  $arrayDatos=$datos['GetApprovalClientInfoByTempIdResult']['ApprovalClient'];
  }
  catch (SoapFault $e)

  {
  echo "Error: {$e}"; exit;


  }catch (Exception $e)

  {
  echo "Error2:".$e; exit;


  }

 */


/* 	echo  $arrayDatos."<br>";

  foreach($arrayDatos as $itemArrayDatos){
  echo 'AgencyName: '.$itemArrayDatos['AgencyName'].'<br/>';
  echo 'AltipalClientId: '.$itemArrayDatos['AltipalClientId'].'<br/>';
  echo 'AltipalEstablishmentId: '.$itemArrayDatos['AltipalEstablishmentId'].'<br/>';
  echo 'Status: '.$itemArrayDatos['Status'].'<br/>';
  echo 'TempClientId: '.$itemArrayDatos['TempClientId'].'<br/>';
  echo '-----------------------------';
  echo '<br/>';
  }

 */
	
?>