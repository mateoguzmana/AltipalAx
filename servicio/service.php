 
<?php



require_once('../../SM/lib/nusoap.php');

//@curl_setopt($ch, CURLOPT_TIMEOUT, 9999999999999);

$wsdl = "http://190.144.195.125:8082/MicrosoftDynamicsAXAif60/SRFALTIPALServicesPreSalesBalances/xppservice.svc?wsdl";
       //http://190.144.195.125:8082/MicrosoftDynamicsAXAif60/SRFALTIPALServiceConPreSalesInvent/xppservice.svc?wsdl"
$client = new nusoap_client($wsdl, TRUE);
$client->setCredentials("ALTIPAL\\victor.rodriguez", "srf.2014", 'ntlm');
$client->soap_defencoding = 'UTF-8';

$err = $client->getError(); /* * *Captura de errores** */
if ($err) {
    echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
    echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
    exit();
}


 @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 

$client->useHTTPPersistentConnection();
$client->use_curl=true;
$client->setCurlOption(CURLOPT_TIMEOUT,560);


ini_set('memory_limit','42048M');

$result = @$client->call('PreSalesBalances');


$xmlstr= utf8_encode($result['response']);
//$sxe = simplexml_load_string($xmlstr);

echo '<pre>';
print_r($xmlstr);
echo '</pre>';

//$xml = simplexml_load_string($xmlstr); 
//print_r($xml);
//exit();
//echo $xml->asXml();
/*echo '<pre>';
print_r($xml->asXml());
echo '</pre>';*/


/*foreach ($xml as $item  ){    
    foreach ($item->InventSite as $subItem){        
        echo  $subItem->InventSiteId.'<br/><br/>';    
    }
}*/
//echo 'final'; 
//exit();
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

echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';

?>