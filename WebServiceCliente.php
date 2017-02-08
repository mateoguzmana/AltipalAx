

<?php
include("lib/nusoap.php");
try {

    $tipoDocumento = '002';
    $documento = '70285918';
    echo '<br>';
    echo $tipoDocumento;
    echo '<br>';
    echo $documento;
    echo '<br>';
    echo '12';

    $client = new nusoap_client("http://altipal.datosmovil.info/SM/WebServiceLogin.php?wsdl");
    echo '<br>';
    echo '0';
    $client->soap_defencoding = 'UTF-8';
    echo '<br>';
    echo '1';
    $err = $client->getError(); /*               Captura de errores  */
    if ($err) {
        echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
        echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
        exit();
    }
    echo '<br>';

    echo 'voy amandar los prametros';

    $args = array('value' => 'CLIENTE_NUEVO', 'CodigoTipoDocumento' => $tipoDocumento, 'Identificador' => $documento);
    echo 'voy a devolver';
    echo '<br>';
    $devolver = $client->call('clienteNuevo', array($args));
    
    echo '<pre>';
    print_r($devolver);

    echo 'consumi';

    return $devolver;
} catch (Exception $exc) {
    echo $exc->getMessage('Error');
}
?>            