<?php

class LoadServiceController extends CController {

    public function actions() {
        return array(
            'action' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * 
     * @param string $codzona
     * @return string
     * @soap
     */
    public function getConsignacion($codzona) {
        $InfoXML = ConsignacionVendedor::model()->Cosignaciones($codzona);
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        foreach ($InfoXML as $itemInfo) {
            $valorefectivo = $itemInfo['ValorConsignadoEfectivo'];
            $valorcheque = $itemInfo['ValorConsignadoEfectivo'];
            $total = $valorefectivo + $valorcheque;
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodAsesor'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodZonaVentas'] . '</AdvisorCode>';
            $xml .= '<Description> Consignación Recaudo Ventas ' . $itemInfo['CodZonaVentas'] . '</Description>';
            $xml .= '<Date>' . $itemInfo['FechaConsignacion'] . '</Date>';
            $xml .= '</Header>';
            $xml .= '<detail>';
            $xml .= '<ConsignmentDate>' . $itemInfo['FechaConsignacionVendedor'] . '</ConsignmentDate>';
            $xml .= '<Value>' . $total . '</Value>';
            $xml .= '<CityAndOffice>' . $itemInfo['Ciudad'] . '--' . $itemInfo['Oficina'] . '</CityAndOffice>';
            $xml .= '</detail>';
        }

        $client = new SoapClient('http://190.144.195.125:8082/MicrosoftDynamicsAXAif60/SRFWebServicesConsignment/xppservice.svc', array(
            'soap_version' => SOAP_1_2, // or try SOAP_1_1
            'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
            'trace' => 1,
        ));
        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

}
