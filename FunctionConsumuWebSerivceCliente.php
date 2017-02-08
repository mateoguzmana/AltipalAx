<?php


        try {
            
            $tipoDocumento = '002';
            $documento = '70285918';
            
            //$tipoDocumento = trim($value['tipoDocumento']);
            //$documento = trim($value['documento']);

            $manejador = fopen('Log/CONSULTA _CLIENTE_NUEVO.txt', 'a+');
            fputs($manejador, "Tipo Documento: " . $tipoDocumento . "  DOCUMENTO: " . $documento . "\n");
            fclose($manejador);

            $client = new nusoap_client("http://altipal.datosmovil.info/SM/WebServiceLogin.php?wsdl");
            $client->soap_defencoding = 'UTF-8';
            $err = $client->getError(); /*               Captura de errores  */
            if ($err) {
                echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
                exit();
            }

            $args = array('value' => 'CLIENTE_NUEVO', 'CodigoTipoDocumento' => $tipoDocumento, 'Identificador' => $documento);
            $devolver = $client->call('clienteNuevo', array($args));

            $manejador = fopen('Log/JSON_NEW.txt', 'a+');
            fputs($manejador, $devolver . "\n");
            fclose($manejador);


            return $devolver;
        } catch (Exception $e) {
            $manejador = fopen('Log/Warning.txt', 'a+');
            fputs($manejador, $e->getMessage() . "\n");
            fclose($manejador);
        }

?>