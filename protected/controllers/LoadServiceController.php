<?php

class LoadServiceController extends CController {
    /*   public function actions() {
      return array(
      'action' => array(
      'class' => 'CWebServiceAction',
      ),
      );
      } */

    /**
     * 
     * @param string $codzona
     * @return string
     * @soap
     */
    public function actionConsignacion($codzona) {


        $InfoXML = ConsignacionVendedor::model()->Cosignaciones($codzona);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';
   
        foreach ($InfoXML as $itemInfo) {

            $valorefectivo = $itemInfo['ValorConsignadoEfectivo'];
            $valorcheque = $itemInfo['ValorConsignadoEfectivo'];

            $total = $valorefectivo + $valorcheque;

            $xml .= '<Panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodAsesor'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodZonaVentas'] . '</AdvisorCode>';
            $xml .= '<Description> Consignación Recaudo Ventas ' . $itemInfo['CodZonaVentas'] . '</Description>';
            $xml .= '<Date>' . $itemInfo['FechaConsignacion'] . '</Date>';


            $xml .= '<detail>';
            $xml .= '<ConsignmentDate>' . $itemInfo['FechaConsignacionVendedor'] . '</ConsignmentDate>';
            $xml .= '<Value>' . $total . '</Value>';
            $xml .= '<CityAndOffice>' . $itemInfo['Ciudad'] . '--' . $itemInfo['Oficina'] . '</CityAndOffice>';
            $xml .= '</detail>';
            $xml .= '</Header>';
        }
        $xml .= '</Panel>';

        try {

            $client = new SoapClient('http://190.144.195.125:8082/MicrosoftDynamicsAXAif60/SRFWebServicesConsignment/xppservice.svc?wsdl', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'ALTIPAL\\victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            Yii::app()->end();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    /**
     * 
     * @param string $codzona
     * @return string
     * @soap
     */
    public function actionNotasCredito($codzona) {

        $InfoXMl = Notascredito::model()->getNotasCreditos($codzona);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {

            $xml .= '<panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<Date>' . $itemInfo['Fecha'] . '</Date>';
            $xml .= '</Header>';

            $xml .= '<Detail>';
            $xml .= '<NoteDate>' . $itemInfo['Fecha'] . '</NoteDate>';
            $xml .= '<ConceptCode>' . $itemInfo['Concepto'] . '</ConceptCode>';
            $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
            $xml .= '<InvoiceId>' . $itemInfo['Factura'] . '</InvoiceId>';
            $xml .= '<Description>Descuentos Condicionados ' . $itemInfo['Factura'] . '</Description>';
            $xml .= '<NoteValue>' . $itemInfo['Valor'] . '</NoteValue>';
            $xml .= '</Detail>';
        }
        $xml .= '</panel>';



        try {

            $client = new SoapClient('Servicio', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            exit();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    /**
     * 
     * @param string $CodZonaVentas
     * @return string
     * @soap
     */
    public function actionTransConsignacion($CodZonaVentas) {

        $InfoXML = Transferenciaconsignacion::model()->getTransferenciaConsignacion($CodZonaVentas);


        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {


            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<DailyCode>011</DailyCode>';
            $xml .= '</Header>';

            $InfoXMLDetail = Transferenciaconsignacion::model()->getTransferenciaConsignacionDescripcion($itemInfo['IdTransferencia']);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<Date>' . $itemInfo['FechaTransferencia'] . '</Date>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<DestinyUbication>11200</DestinyUbication>';
                $xml .= '<MeasureUnit>nose</MeasureUnit>';
                $xml .= '<UMQuantity>' . $Itemdetail['Cantidad'] . '</UMQuantity>';
                $xml .= '</Detail>';
            }
        }

        try {

            $client = new SoapClient('Servicio', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            exit();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    /**
     * 
     * @param string $codzona
     * @return string
     * @soap
     */
    public function actionTransferenciaAutoventa($codzona) {

        $InfoXMl = Transferenciaautoventa::model()->getTransferenciaAutoventa($codzona);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {


            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<DailyCode>012</DailyCode>';
            $xml .= '<MeasureUnit>' . $itemInfo['CodigoUnidadMedida'] . '</MeasureUnit>';
            $xml .= '</Header>';

            $InfoXMLDetail = Transferenciaautoventa::model()->getDescripcionTrnasAtoventa($itemInfo['IdTransferenciaAutoventa']);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<UMQuantity>' . $Itemdetail['Cantidad'] . '</UMQuantity>';
                $xml .= '<Date>' . $itemInfo['FechaTransferenciaAutoventa'] . '</Date>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<OriginUbication>' . $itemInfo['CodigoUbicacionOrigen'] . '</OriginUbication>';
                $xml .= '<DestinyUbication>' . $itemInfo['CodigoUbicacionDestino'] . '</DestinyUbication>';
                $xml .= '<FromBatch>' . $Itemdetail['Lote'] . '</FromBatch>';
                $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                $xml .= '<Quantity>' . $Itemdetail[''] . '</Quantity>';
                $xml .= '</Detail>';
            }
        }

        try {

            $client = new SoapClient('Servicio', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            exit();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    /**
     * 
     * @param string $CodZonaVentas
     * @return string
     * @soap
     */
    public function actionDevoluciones($CodZonaVentas) {

        $InfoXMl = DevolucionesModel::model()->getDevoluciones($CodZonaVentas);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {


            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<ReasonCode>' . $itemInfo['CodigoMotivoDevolucion'] . '</ReasonCode>';
            $xml .= '<Date>' . $itemInfo['CodigoUnidadMedida'] . '</Date>';
            $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
            $xml .= '</Header>';

            $InfoXMLDetail = DevolucionesModel::model()->getDescripcionDevoluciones($itemInfo['IdDevolucion']);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<VariantCode>' . $Itemdetail['CodigoVariante'] . '</VariantCode>';
                $xml .= '<MeasureUnit>' . $Itemdetail['CodigoUnidadMedida'] . '</MeasureUnit>';
                $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                $xml .= '</Detail>';
            }
        }

        try {

            $client = new SoapClient('Servicio', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            exit();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    /**
     * 
     * @param string $CodZonaVentas
     * @return string
     * @soap
     */
    public function actionPedido($CodZonaVentas) {

        $InfoXMl = Pedidos::model()->getPedidoPreventa($CodZonaVentas);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {

            $xml .= '<panel>';
            $xml .= '<Header>';

            $xml .= '<OrderType>' . $itemInfo[''] . '</OrderType>';
            $xml .= '<CustAccount>' . $itemInfo[''] . '</CustAccount>';
            $xml .= '<SalesOrder>' . $itemInfo[''] . '</SalesOrder>';
            $xml .= '<Route>' . $itemInfo['Ruta'] . '</Route>';
            $xml .= '<TaxGroup>' . $itemInfo[''] . '</TaxGroup>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<SalesArea>' . $itemInfo['CodZonaVentas'] . '</SalesArea>';


            $xml .= '<LogisticsAreaCode>' . $itemInfo[''] . '</LogisticsAreaCode>';
            $xml .= '<SalesGroup>' . $itemInfo['CodGrupoVenta'] . '</SalesGroup>';
            $xml .= '<SalesOrigin>' . $itemInfo[''] . '</SalesOrigin>';
            $xml .= '<SalesType>' . $itemInfo['TipoVenta'] . '</SalesType>';
            $xml .= '<Observations>' . $itemInfo['Observacion'] . '</Observations>';
            $xml .= '<DeliveryDate>' . $itemInfo['FechaEntrega'] . '</DeliveryDate>';
            $xml .= '<PaymentCondition>' . $itemInfo['FormaPago'] . '</PaymentCondition>';

            $xml .= '</Header>';



            $InfoXMLDetail = Pedidos::model()->getDetallePedidoPreventa($itemInfo['IdPedido']);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<MeasureUnit>' . $Itemdetail[''] . '</MeasureUnit>';
                $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                $xml .= '<SalesPrice>' . $Itemdetail[''] . '</SalesPrice>';
                $xml .= '<LineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</LineDiscount>';
                $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                $xml .= '<KitQuantity>' . $Itemdetail[''] . '</KitQuantity>';


                $xml .= '</Detail>';
            }
            $xml .= '</panel>';
        }


        try {

            $client = new SoapClient('Servicio', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            exit();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

    /**
     * 
     * @param string $zonaAsesor
     * @return string
     * @soap
     */
    public function actionClientesNuevos($zonaAsesor) {
        $InfoXML = Clientenuevo::model()->getClientesNuevos($zonaAsesor);
        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<RoutedVisit>' . $itemInfo['NumeroVisita'] . '</RoutedVisit>';
            $xml .= '<DocumentType>' . $itemInfo['CodTipoDocumento'] . '</DocumentType>';
            //$xml .= '<RecordType>'.$itemInfo[''].'</RecordType>';
            //$xml .= '<TaxpayerType>'.$itemInfo[''].'</TaxpayerType>';
            $xml .= '<CiiuCode>' . $itemInfo['CodigoCiuu'] . '</CiiuCode>';
            $xml .= '<CompanyName>' . $itemInfo['RazonSocial'] . '</CompanyName>';
            $xml .= '<FirstName>' . $itemInfo['PrimerNombre'] . '</FirstName>';
            $xml .= '<SecondName>' . $itemInfo['SegundoNombre'] . '</SecondName>';
            $xml .= '<FirstLastName>' . $itemInfo['PrimerApellido'] . '</FirstLastName>';
            $xml .= '<SecondLastName>' . $itemInfo['SegundoApellido'] . '</SecondLastName>';
            $xml .= '<Establishment>' . $itemInfo['Establecimiento'] . '</Establishment>';
            $xml .= '<IdentificationNum>' . $itemInfo['Identificacion'] . '</IdentificationNum>';
            $xml .= '<CheckDigit>' . $itemInfo['DigitoVerificacion'] . '</CheckDigit>';
            $xml .= '<BusinessType>' . $itemInfo['CodCadenadeEmpresa'] . '</BusinessType>';
            $xml .= '<Neighborhood>' . $itemInfo['CodBarrio'] . '</Neighborhood>';
            $xml .= '<Street>' . $itemInfo['Direccion'] . '</Street>';
            $xml .= '<Latitude>' . $itemInfo['Latitud'] . '</Latitude>';
            $xml .= '<Length>' . $itemInfo['Longitud'] . '</Length>';
            $xml .= '<PhoneNumber>' . $itemInfo['Telefono'] . '</PhoneNumber>';
            $xml .= '<MobilePhoneNumber>' . $itemInfo['TelefonoMovil'] . '</MobilePhoneNumber>';
            $xml .= '<Phonenumber2>' . $itemInfo['Telefono1'] . '</Phonenumber2>';
            $xml .= '<Email>' . $itemInfo['Email'] . '</Email>';
            $xml .= '</Header>';
        }

        try {

            $client = new SoapClient('Servicio', array(
                'soap_version' => SOAP_1_1, // or try SOAP_1_1
                'cache_wsdl' => WSDL_CACHE_NONE, // WSDL_CACHE_BOTH in production
                'trace' => 1,
                'login' => 'victor.rodriguez',
                'password' => 'srf.2014'
            ));
        } catch (SoapFault $ex) {

            echo '<pre>';
            print_r($ex);
            exit();
        }


        echo $client->CreateConsignment($xml);
        echo $client->__getLastRequest();
        echo $client->__getLastResponse();
    }

}
