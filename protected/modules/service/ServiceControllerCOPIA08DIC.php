<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServiceController extends Controller {

    public function actions() {
        return array(
            'Service' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string $cadena  extructura   
     * @return string  El mensaje del servicio
     * @return string
     * @soap
     */
    public function setQueryTransaccionesAx() {


        $Transaccionesax = ServiceAltipal::model()->ConsultaDatosGlobal();


        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';

        $cadena.='<transaccionesax>';
        foreach ($Transaccionesax as $item) {
            $cadena.='<transaccionesaxItem>';
            $cadena.='<CodTipoDocumentoActivityItem>';
            $cadena.=$item["CodTipoDocumentoActivity"];
            $cadena.='</CodTipoDocumentoActivityItem>';

            $cadena.='<IdDocumentoItem>';
            $cadena.=$item["IdDocumento"];
            $cadena.='</IdDocumentoItem>';

            $cadena.='<CodigoAgenciaItem>';
            $cadena.=$item["CodigoAgencia"];
            $cadena.='</CodigoAgenciaItem>';

            $cadena.='</transaccionesaxItem>';
        }
        $cadena.='</transaccionesax>';

        return $cadena;
    }

    /**
     * 
     * @param string $idCliente
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @param string $xml  extructura 
     * @return string
     * @soap
     */
    public function setEstructuraxml($idCliente, $idTipoDoc, $CodAgencia) {


        $InfoXML = ServiceAltipal::model()->getClientesNuevos($idCliente, $idTipoDoc, $CodAgencia);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {

            $homologaciontipdoc = ServiceAltipal::model()->getCodHomologacion($itemInfo['CodTipoDocumento']);

            foreach ($homologaciontipdoc as $itemHemologcion) {
                
            }

            $xml .= '<Panel>';
            $xml .= '<Pane1>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<RoutedVisit>' . $itemInfo['NumeroVisita'] . '</RoutedVisit>';
            $xml .= '<DocumentType>' . $itemInfo['CodTipoDocumento'] . '</DocumentType>';
            $xml .= '<RecordType>' . $itemHemologcion['CodigoTipoRegistro'] . '</RecordType>';
            $xml .= '<TaxpayerType>' . $itemHemologcion['CodigoTipoContribuyente'] . '</TaxpayerType>';
            $xml .= '<CiiuCode>' . $itemInfo['CodigoCiuu'] . '</CiiuCode>';
            $xml .= '<CompanyName>' . mb_strtoupper($itemInfo['RazonSocial']) . '</CompanyName>';
            $xml .= '<FirstName>' . mb_strtoupper($itemInfo['PrimerNombre']) . '</FirstName>';
            $xml .= '<SecondName>' . mb_strtoupper($itemInfo['SegundoNombre']) . '</SecondName>';
            $xml .= '<FirstLastName>' . mb_strtoupper($itemInfo['PrimerApellido']) . '</FirstLastName>';
            $xml .= '<SecondLastName>' . mb_strtoupper($itemInfo['SegundoApellido']) . '</SecondLastName>';
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
            $xml .= '<LogisticZone></LogisticZone>';
            $xml .= '</Pane1>';
            $xml .= '</Panel>';
        }
        return $xml;
    }

    /**
     * 
     * @param string $idDoc
     * @param string $tipDoc
     * @param string $agencia
     * @param string $repuestaAx
     * @return string
     * @soap
     */
    public function setUpdateEstadoClientes($idDoc, $tipDoc, $agencia, $repuestaAx) {


        switch ($tipDoc) {

            case 1:
                $update = ServiceAltipal::model()->getUpdateEstadopPedido($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 2:
                $update = ServiceAltipal::model()->getUpdateEstadopPedido($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 3:
                $update = ServiceAltipal::model()->getUpdateEstadoTransfeAutoventa($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 4:
                $update = ServiceAltipal::model()->getUpdateEstadoCobro($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 5:
                $update = ServiceAltipal::model()->getUpdateEstadoConsignacionVendedor($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 6:
                $update = ServiceAltipal::model()->getUpdateEstadoDevoluciones($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 7:
                $update = ServiceAltipal::model()->getUpdateEstadoNotasCredito($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 8:
                $update = ServiceAltipal::model()->getUpdateEstadoTransfeConsignacion($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 9:
                $update = ServiceAltipal::model()->getUpdateEstado($idDoc, $tipDoc, $agencia, $repuestaAx);
                $this->createClienteNuevo($repuestaAx, $agencia);
                return $update;
                break;
            /* case 10:
              $update = ServiceAltipal::model()->getUpdateEstado($idDoc, $tipDoc, $agencia, $repuestaAx);
              return $update;
              break; */
            case 11:
                $update = ServiceAltipal::model()->getUpdateEstadoRecibos($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
            case 12:
                $update = ServiceAltipal::model()->getUpdateEstadoChquesPosfechados($idDoc, $tipDoc, $agencia, $repuestaAx);
                return $update;
                break;
        }
    }

    /**
     * 
     * @param string $idDevolucion
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenrarXmlDevoluciones($idDevolucion, $idTipoDoc, $CodAgencia) {


        $CountDetalleDevoluciones = ServiceAltipal::getCountDevoluciones($idDevolucion, $CodAgencia);

        if ($CountDetalleDevoluciones[0]['devolucionesdetalle'] > 0) {

            $InfoXMl = ServiceAltipal::model()->getDevolucionesService($idDevolucion, $idTipoDoc, $CodAgencia);

            $xml = '<?xml version="1.0" encoding="utf-8"?>';

            foreach ($InfoXMl as $itemInfo) {

                $xml .= '<panel>';
                $xml .= '<Header>';
                $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
                $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
                $xml .= '<ReasonCode>' . $itemInfo['CodigoMotivoDevolucion'] . '</ReasonCode>';
                $xml .= '<Date>' . $itemInfo['FechaDevolucion'] . '</Date>';
                $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';


                $InfoXMLDetail = ServiceAltipal::model()->getDescripcionDevolucionesService($itemInfo['IdDevolucion'], $CodAgencia);

                foreach ($InfoXMLDetail as $Itemdetail) {

                    $xml .= '<Detail>';
                    $xml .= '<VariantCode>' . $Itemdetail['CodigoVariante'] . '</VariantCode>';
                    $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                    $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                    $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                    $xml .= '</Detail>';
                }
                $xml .= '</Header>';
                $xml .= '</panel>';
            }

            return $xml;
        } else {

            return "";
        }
    }

    /**
     * 
     * @param string $idNotasCredito
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenrarXmlNotasCredito($idNotasCredito, $idTipoDoc, $CodAgencia) {


        $InfoXMl = ServiceAltipal::model()->getNotasCreditos($idNotasCredito, $idTipoDoc, $CodAgencia);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {

            if ($itemInfo['Fabricante'] == "") {

                $VendId = '800186960';
            } else {

                $VendId = $itemInfo['Fabricante'];
            }

            $xml .= '<Panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<Date>' . $itemInfo['Fecha'] . '</Date>';

            $xml .= '<Detail>';
            $xml .= '<NoteDate>' . $itemInfo['Fecha'] . '</NoteDate>';
            $xml .= '<ConceptCode>' . $itemInfo['Concepto'] . '</ConceptCode>';
            $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
            $xml .= '<InvoiceId>' . $itemInfo['Factura'] . '</InvoiceId>';
            $xml .= '<Description>Descuentos Condicionados ' . $itemInfo['Factura'] . '</Description>';
            $xml .= '<NoteValue>' . $itemInfo['Valor'] . '</NoteValue>';
            $xml .= '<VendId>' . $VendId . '</VendId>';
            $xml .= '<ResponsableIn>' . $itemInfo['CodigoDimension'] . '</ResponsableIn>';
            $xml .= '</Detail>';
            $xml .= '</Header>';
            $xml .= '</Panel>';
        }

        return $xml;
    }

    /**
     * 
     * @param string $idConsignacion
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenerarXMLConsignacionVendedor($idConsignacion, $idTipoDoc, $CodAgencia) {


        $InfoXML = ServiceAltipal::model()->getConsignacionVendedor($idConsignacion, $idTipoDoc, $CodAgencia);


        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {

            $valorefectivo = $itemInfo['ValorConsignadoEfectivo'];
            $valorcheque = $itemInfo['ValorConsignadoCheque'];

            $total = $valorefectivo + $valorcheque;

            $xml .= '<Panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<Description> Consignación Recaudo Ventas ' . $itemInfo['CodZonaVentas'] . '</Description>';
            $xml .= '<Date>' . $itemInfo['FechaConsignacion'] . '</Date>';
            $xml .='<ConsignmentNum>' . $itemInfo['NroConsignacion'] . '</ConsignmentNum>';

            $xml .= '<detail>';
            $xml .= '<ConsignmentDate>' . $itemInfo['FechaConsignacionVendedor'] . '</ConsignmentDate>';
            $xml .= '<Value>' . $total . '</Value>';
            $xml .= '<CityAndOffice>' . $itemInfo['Ciudad'] . '--' . $itemInfo['Oficina'] . '</CityAndOffice>';
            $xml .= '<BanckAccountId>' . $itemInfo['CuentaConsignacion'] . '</BanckAccountId>';
            $xml .= '</detail>';
            $xml .= '</Header>';
            $xml .= '</Panel>';
        }

        return $xml;
    }

    /**
     * 
     * @param string $idCobro
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenerarXMLCobro($idCobro, $idTipoDoc, $CodAgencia) {

        $InfoXML = ServiceAltipal::model()->getCobros($idCobro, $idTipoDoc, $CodAgencia);


        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {

            $xml .= '<Panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<Date>' . $itemInfo['Fecha'] . '</Date>';

            $detalleCobro = ServiceAltipal::model()->getCobrosDetalle($itemInfo['Id'], $CodAgencia);

            foreach ($detalleCobro as $itemDetalleCobro) {

                $xml .= '<Detail>';
                $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
                $xml .= '<InvoiceId>' . $itemDetalleCobro['Factura'] . '</InvoiceId>';
                $xml .= '<ActionType>' . $itemInfo['CodMotivoGestion'] . '</ActionType>';
                $xml .= '<NextVisitDate>' . $itemInfo['FechaProximaVisita'] . '</NextVisitDate>';
                $xml .= '<Purpose>' . $itemInfo['Observacion'] . '</Purpose>';
                $xml .= '<InitialDate>' . $itemInfo['Fecha'] . '</InitialDate>';
                $xml .= '<EndDate>' . $itemInfo['FechaProximaVisita'] . '</EndDate>';
                $xml .= '</Detail>';
            }
            $xml .= '</Header>';
            $xml .= '</Panel>';
        }
        return $xml;
    }

    /**
     * 
     * @param string $idTransferecnaiConsignacion
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenerarXMLTransfeConsig($idTransferecnaiConsignacion, $idTipoDoc, $CodAgencia) {

        $InfoXML = ServiceAltipal::model()->getTransferenciaConsignacionService($idTransferecnaiConsignacion, $idTipoDoc, $CodAgencia);


        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {

            $xml .= '<panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<DailyCode>011</DailyCode>';


            $InfoXMLDetail = ServiceAltipal::model()->getTransferenciaConsignacionDescripcion($itemInfo['IdTransferencia']);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<Date>' . $itemInfo['FechaTransferencia'] . '</Date>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<DestinyUbication>' . $itemInfo['CuentaCliente'] . '</DestinyUbication>';
                $xml .= '<MeasureUnit>' . $Itemdetail['UnidadMedida'] . '</MeasureUnit>';
                $xml .= '<UMQuantity>' . $Itemdetail['Cantidad'] . '</UMQuantity>';
                $xml .= '</Detail>';
            }
            $xml .= '</Header>';
            $xml .= '</panel>';
        }


        return $xml;
    }

    /**
     * 
     * @param string $idTransferecnaiAutoventa
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenerarTransferenciaAutoventa($idTransferecnaiAutoventa, $idTipoDoc, $CodAgencia) {

        $InfoXMl = ServiceAltipal::model()->getTransferenciaAutoventaService($idTransferecnaiAutoventa, $idTipoDoc, $CodAgencia);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemInfo) {

            $xml .= '<panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<DailyCode>012</DailyCode>';


            $InfoXMLDetail = ServiceAltipal::model()->getDescripcionTrnasAtoventaService($itemInfo['IdTransferenciaAutoventa'], $CodAgencia);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<Date>' . $itemInfo['FechaTransferenciaAutoventa'] . '</Date>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<OriginUbication>' . $itemInfo['CodigoUbicacionOrigen'] . '</OriginUbication>';
                $xml .= '<DestinyUbication>' . $itemInfo['CodigoUbicacionDestino'] . '</DestinyUbication>';
                $xml .= '<FromBatch>' . $Itemdetail['Lote'] . '</FromBatch>';
                $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                $xml .= '</Detail>';
            }
            $xml .= '</Header>';
            $xml .= '</panel>';
        }
        return $xml;
    }

    /**
     * 
     * @param string $idPedido
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
      public function setGenerarXMLPedido($idPedido, $idTipoDoc, $CodAgencia) {


        $coundetalles = ServiceAltipal::model()->getCountDetallePedidos($idPedido, $CodAgencia);

        if ($coundetalles[0]['detallepedido'] > 0) {

            $InfoXMl = ServiceAltipal::model()->getPedidoPreventaService($idPedido, $idTipoDoc, $CodAgencia);

            $xml = '<?xml version="1.0" encoding="utf-8"?>';

            foreach ($InfoXMl as $itemInfo) {

                if ($itemInfo['Web'] == 1) {

                    $salesOrigin = '002';
                } else {

                    $salesOrigin = '001';
                }


                if ($itemInfo['Responsable'] == "") {

                    $codAdvaisor = $itemInfo['CodAsesor'];
                } else {

                    $codAdvaisor = $itemInfo['Responsable'];
                }

                $xml .= '<panel>';
                $xml .= '<Header>';

                $xml .= '<OrderType>pedido de venta</OrderType>';
                $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
                if ($itemInfo['Conjunto'] == '002' || $itemInfo['Conjunto'] == '005') {
                    $xml .= '<SalesOrder>' . $itemInfo['NroFactura'] . '</SalesOrder>';
                } else {
                    $xml .= '<SalesOrder>' . $CodAgencia . '-' . $itemInfo['IdPedido'] . '</SalesOrder>';
                }
                $xml .= '<Route>' . trim($itemInfo['Ruta']) . '</Route>';
                $xml .= '<TaxGroup>' . $itemInfo['CodigoGrupodeImpuestos'] . '</TaxGroup>';
                $xml .= '<AdvisorCode>' . $codAdvaisor . '</AdvisorCode>';
                $xml .= '<SalesArea>' . $itemInfo['CodZonaVentas'] . '</SalesArea>';


                $xml .= '<LogisticsAreaCode>' . $itemInfo['CodigoZonaLogistica'] . '</LogisticsAreaCode>';
                $xml .= '<SalesGroup>' . $itemInfo['CodGrupoVenta'] . '</SalesGroup>';
                $xml .= '<SalesOrigin>' . $salesOrigin . '</SalesOrigin>';
                $xml .= '<SalesType>' . $itemInfo['Conjunto'] . '</SalesType>';
                $xml .= '<Observations>' . $itemInfo['Observacion'] . '</Observations>';
                $xml .= '<DeliveryDate>' . $itemInfo['FechaEntrega'] . '</DeliveryDate>';
                $xml .= '<PaymentCondition>' . $itemInfo['Plazo'] . '</PaymentCondition>';



                $InfoXMLDetail = ServiceAltipal::model()->getDetallePedidoPreventaService($itemInfo['IdPedido'], $CodAgencia);


                foreach ($InfoXMLDetail as $Itemdetail) {
                    $cont=0;
                    //$contActividaEspecial=0;
                    if ($Itemdetail['IdAcuerdoLinea'] == 0) {
                        $Itemdetail['IdAcuerdoLinea'] = '';
                    }

                     

                    if ($Itemdetail['CodigoTipo'] == "KD" || $Itemdetail['CodigoTipo'] == "KV") {


                        $xml .= '<Detail>';
                        $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                        $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                        $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                        $xml .= '<Quantity>0</Quantity>';
                        $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                        $xml .= '<SalesPrice>0</SalesPrice>';
                        $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                        $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                        $xml .= '<SpecialAltipalDiscount>0</SpecialAltipalDiscount>';
                        $xml .= '<SpecialVendDiscount>0</SpecialVendDiscount>';
                        $xml .= '<KitQuantity>' . $Itemdetail['Cantidad'] . '</KitQuantity>';
                        $xml .= '<KitItemId>0</KitItemId>';
                        $xml .= '<ComponentQty>0</ComponentQty>';
                        $xml .='<agreementid>0</agreementid>';
                        $xml .= '</Detail>';
                    } else {

                        if ($itemInfo['AutorizaDescuentoEspecial'] == 1 || $itemInfo['ActividadEspecial'] == 1) {


                            $infoaprobacion = ServiceAltipal::model()->getPedidoDescuentoAprovado($Itemdetail['Id'], $CodAgencia);
                            
                            /*echo '<pre>';
                            print_r($infoaprobacion);*/
                            $QuienAutorizaDscto=0;
                            $EstadoRevisadoAltipal=0;
                            $EstadoRevisadoProveedor=0;
                            $EstadoRechazoAltipal=0;
                            $EstadoRechazoProveedor=0;
                            foreach ($infoaprobacion as $ItemAproba):
                                
                                //$cont=0;
                                $QuienAutorizaDscto = $ItemAproba['QuienAutorizaDscto'];
                                $EstadoRevisadoAltipal = $ItemAproba['EstadoRevisadoAltipal'];
                                $EstadoRevisadoProveedor = $ItemAproba['EstadoRevisadoProveedor'];
                                $EstadoRechazoAltipal = $ItemAproba['EstadoRechazoAltipal'];
                                $EstadoRechazoProveedor = $ItemAproba['EstadoRechazoProveedor'];


                                if ($QuienAutorizaDscto == 3) {

                                    if ($EstadoRevisadoAltipal > 0 && $EstadoRevisadoProveedor > 0) {
                                       
                                        $xml .= '<Detail>';
                                        $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                        $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                        $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                        $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                        $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                        $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                        $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                        $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                        $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                        $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                        $xml .= '<KitQuantity>0</KitQuantity>';
                                        $xml .= '<KitItemId>0</KitItemId>';
                                        $xml .= '<ComponentQty>0</ComponentQty>';
                                        $xml .='<agreementid>'.$Itemdetail['IdAcuerdoLinea'].'</agreementid>';
                                        $xml .= '</Detail>';
                                    }
                                     $cont++;
                                }

                                if ($QuienAutorizaDscto == 2) {

                                    if ($EstadoRevisadoProveedor > 0 && $EstadoRechazoProveedor == 0) {
                                         $xml .= '<Detail>';
                                        $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                        $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                        $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                        $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                        $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                        $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                        $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                        $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                        $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                        $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                        $xml .= '<KitQuantity>0</KitQuantity>';
                                        $xml .= '<KitItemId>0</KitItemId>';
                                        $xml .= '<ComponentQty>0</ComponentQty>';
                                        $xml .='<agreementid>'.$Itemdetail['IdAcuerdoLinea'].'</agreementid>';
                                        $xml .= '</Detail>';
                                    }
                                    $cont++;
                                }

                                if ($QuienAutorizaDscto == 1) {
                                    
                                  

                                    if ($EstadoRevisadoAltipal > 0 && $EstadoRechazoAltipal == 0) {
                                        $xml .= '<Detail>';
                                        $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                        $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                        $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                        $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                        $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                        $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                        $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                        $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                        $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                        $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                        $xml .= '<KitQuantity>0</KitQuantity>';
                                        $xml .= '<KitItemId>0</KitItemId>';
                                        $xml .= '<ComponentQty>0</ComponentQty>';
                                        $xml .='<agreementid>'.$Itemdetail['IdAcuerdoLinea'].'</agreementid>';
                                        $xml .= '</Detail>';
                                    }
                                     $cont++;
                                }
                                
                                
                               endforeach;
                               
                                if($cont == 0){
                                    
                                     $xml .= '<Detail>';
                                     $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                                     $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                                     $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                                     $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                                     $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                                     $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                                     $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                                     $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                                     $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                                     $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                                     $xml .= '<KitQuantity>0</KitQuantity>';
                                     $xml .= '<KitItemId>0</KitItemId>';
                                     $xml .= '<ComponentQty>0</ComponentQty>';
                                     $xml .='<agreementid>'.$Itemdetail['IdAcuerdoLinea'].'</agreementid>';
                                     $xml .= '</Detail>';  
                                 }
                              
                               
                        } else {

                            $xml .= '<Detail>';
                            $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                            $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                            $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                            $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
                            $xml .= '<LineDiscount>' . $Itemdetail['DsctoLinea'] . '</LineDiscount>';
                            $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
                            $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
                            $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
                            $xml .= '<KitQuantity>0</KitQuantity>';
                            $xml .= '<KitItemId>0</KitItemId>';
                            $xml .= '<ComponentQty>0</ComponentQty>';
                            $xml .= '<agreementid>'.$Itemdetail['IdAcuerdoLinea'].'</agreementid>';
                            $xml .= '</Detail>';
                        }
                    }


                    if ($Itemdetail['CodigoTipo'] == "KD" || $Itemdetail['CodigoTipo'] == "KV") {

                        $InfoXMLDetailKD = ServiceAltipal::model()->getPedidoDetalleKidService($Itemdetail['Id'], $CodAgencia);

                        foreach ($InfoXMLDetailKD as $itemKit) {

                            $totalkit = $Itemdetail['Cantidad'] * $itemKit['Cantidad'];
                            $totalPrecioVentaBaseVariante = $itemKit['PrecioVentaBaseVariante'] * $Itemdetail['Cantidad'];

                            $xml .= '<Detail>';
                            $xml .= '<VariantCode>' . $itemKit['CodigoArticuloComponente'] . '</VariantCode>';
                            $xml .= '<MeasureUnit>' . $itemKit['CodigoUnidadMedida'] . '</MeasureUnit>';
                            $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
                            $xml .= '<Quantity>0</Quantity>';
                            $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
                            $xml .= '<SalesPrice>' . $totalPrecioVentaBaseVariante . '</SalesPrice>';
                            $xml .= '<LineDiscount>0</LineDiscount>';
                            $xml .= '<MultiLineDiscount>0</MultiLineDiscount>';
                            $xml .= '<SpecialAltipalDiscount>0</SpecialAltipalDiscount>';
                            $xml .= '<SpecialVendDiscount>0</SpecialVendDiscount>';
                            $xml .= '<KitQuantity>'.$totalkit.'</KitQuantity>';
                            $xml .= '<KitItemId>'.$Itemdetail['CodigoArticulo'].'</KitItemId>';
                            $xml .= '<ComponentQty>'.$itemKit['Cantidad'].'</ComponentQty>';
                            $xml .='<agreementid>0</agreementid>';
                            $xml .= '</Detail>';
                        }
                    }
                }

                $xml .= '</Header>';
                $xml .= '</panel>';
            }

            return $xml;
        } else {


            return "";
        }
    }        

    /**
     * 
     * @param string $idRecibo
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenrarXMLReciboCaja($idRecibo, $idTipoDoc, $CodAgencia) {

        $InfoXMl = ServiceAltipal::model()->getReciboCajaService($idRecibo, $idTipoDoc, $CodAgencia);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemReciCaja) {

            if ($itemReciCaja['Responsable'] == "") {

                $respoCod = $itemReciCaja['CodAsesor'];
            } else {

                $respoCod = $itemReciCaja['Responsable'];
            }


            $xml .= '<panel>';
            $xml .= '<Header>';

            $xml .= '<SalesAreaCode>' . $itemReciCaja['ZonaVenta'] . '</SalesAreaCode>';
            $xml .= '<ResponsibleCode>' . $respoCod . '</ResponsibleCode>';
            $xml .= '<DailyCode>010</DailyCode>';
            $xml .= '<Description>Recibo de Caja ' . $itemReciCaja['Provisional'] . '</Description>';

            $InfoXMlDetalle = ServiceAltipal::model()->getDetallereciboCaja($itemReciCaja['Id'], $CodAgencia);

            foreach ($InfoXMlDetalle as $itemDetalle) {

                $detalleRecibocheque = ServiceAltipal::model()->getReciboCheque($itemDetalle['Id'], $CodAgencia);

                $detalleReciboChequeConsign = ServiceAltipal::model()->getReciboChequeConsig($itemDetalle['Id'], $CodAgencia);

                $detalleReciboEfectivo = ServiceAltipal::model()->getReciboEfectivo($itemDetalle['Id'], $CodAgencia);

                $detalleReciboEfectivoConsig = ServiceAltipal::model()->getReciboEfectivoConsig($itemDetalle['Id'], $CodAgencia);


                //consignacion efectivo
                $contConsiEfectivo = 0;
                foreach ($detalleReciboEfectivoConsig as $itemREFC) {

                    $FechaEfectiConsignacion[$contConsiEfectivo] = $itemREFC['Fecha'];
                    $NumeroConsignacionEfectivo[$contConsiEfectivo] = $itemREFC['NroConsignacionEfectivo'];
                    $CodCuentaBancaraEfectivoConsignacion[$contConsiEfectivo] = $itemREFC['CodCuentaBancaria'];
                    $valorEfecConsig[$contConsiEfectivo] = $itemREFC['Valor'];
                    $NroFacturaEfectivoConsignacion[$contConsiEfectivo] = $itemREFC['NumeroFactura'];
                    $ValorTotalConsignacionEfectivo[$contConsiEfectivo] = $itemREFC['ValorTotal'];
                    $contConsiEfectivo++;
                };



                //cheque   
                $contCehque = 0;
                foreach ($detalleRecibocheque as $itemRCHE) {

                    $NroCheque[$contCehque] = $itemRCHE['NroCheque'];
                    $cuantabancariaCheque[$contCehque] = $itemRCHE['CuentaCheque'];
                    $codbancoCheque[$contCehque] = $itemRCHE['CodBanco'];
                    $posfechado[$contCehque] = $itemRCHE['Posfechado'];
                    $valorchque[$contCehque] = $itemRCHE['Valor'];
                    $NroFacturaCheque[$contCehque] = $itemRCHE['NumeroFactura'];
                    $valorTotal[$contCehque] = $itemRCHE['ValorTotal'];
                    $Girado[$contCehque] = $itemRCHE['Girado'];
                    $otro[$contCehque] = $itemRCHE['Otro'];
                    $contCehque++;
                };

                //cheque consignacion
                $DetalleReciboChequeConsignacionDetalle = array();
                $CodCuentaBancariaChequeConsignacion = array();

                $contChequeConsignacion = 0;
                foreach ($detalleReciboChequeConsign as $itemRCHECONSIG) {

                    //$nroConsignacionCheque[$contChequeConsignacion] = $itemRCHECONSIG['NroConsignacionCheque'];
                    $CodCuentaBancariaChequeConsignacion[$contChequeConsignacion] = $itemRCHECONSIG['CodCuentaBancaria'];
                    $idChequeConsignacion[$contChequeConsignacion] = $itemRCHECONSIG['IdConsignacion'];
                    $DetalleReciboChequeConsignacionDetalle[$contChequeConsignacion] = ServiceAltipal::model()->getChequeConsignacionDetalle($idChequeConsignacion[$contChequeConsignacion], $CodAgencia);
                    $contChequeConsignacion++;
                };


                ///Recibo cheuqe consignacion detalle 


                foreach ($DetalleReciboChequeConsignacionDetalle as $itemRCHECONSIGDETALLE) {
                    $cont = 0;
                    foreach ($itemRCHECONSIGDETALLE as $item) {
                        $consulta = ServiceAltipal::model()->getPaymentReference($item['IdRecibosChequeConsignacion'], $CodAgencia);
                        $nroConsignacionCheque[$cont] = $consulta[0]['NroConsignacionCheque'];
                        $NroChequeConsignacionDetalle[$cont] = $item['NroChequeConsignacion'];
                        $CuentaBancariaChequeConsignacionDetalle[$cont] = $item['CuentaBancaria'];
                        $CodBancoChequeConsignacionDetalle[$cont] = $item['CodBanco'];
                        $FechaChequeCosignacionDetalle[$cont] = $item['Fecha'];
                        $chequeValorDetalle[$cont] = $item['Valor'];
                        $ValorTotalChequeconsignacion[$cont] = $item['ValorTotal'];
                        $NroFacturaChequeConsignacion[$cont] = $item['NumeroFactura'];
                        $cont++;
                    }
                };


                //$numeroConsignacion = $itemReciCaja['Provisional'];


                if ($itemReciCaja['Responsable'] == "") {

                    $responsable = $itemReciCaja['CodAsesor'];
                    $consultarResponsableAsesor = ServiceAltipal::model()->consultarResponsableAsesor($responsable, $CodAgencia);
                    foreach ($consultarResponsableAsesor as $itemNombreAsesor) {
                        
                    }
                    $NombreResponsable = $itemNombreAsesor['Nombre'];
                } else {

                    $responsable = $itemReciCaja['Responsable'];
                    $consultarResponsable = ServiceAltipal::model()->consultarResponsable($responsable, $CodAgencia);
                    foreach ($consultarResponsable as $itemNombreResponsable) {
                        
                    }
                    $NombreResponsable = $itemNombreResponsable['NombreEmpleado'];
                }


                $fechas = ServiceAltipal::model()->getFechas($itemDetalle['Id'], $CodAgencia);

                foreach ($fechas as $itemFecha) {
                    
                }


                $DiasVigencia = (strtotime($itemFecha['FechaVencimientoFactura']) - strtotime($itemFecha['FechaFactura'])) / 86400;

                $diasVencidos = (strtotime($itemFecha['Fecha']) - strtotime($itemFecha['FechaFactura'])) / 86400;

                $resultadoDias = $DiasVigencia - $diasVencidos;

                $ContDetalleCehque = 0;


                foreach ($detalleRecibocheque as $itemRCHE) {

                    if ($Girado[$ContDetalleCehque] == 1) {

                        $NombreGirado = 'ALTIPAL';
                    } else {

                        $NombreGirado = $otro[$ContDetalleCehque];
                    }

                    if ($posfechado[$ContDetalleCehque] == 0) {

                        $xml .='<Detail>';
                        $xml .= '<Date>' . $itemReciCaja['Fecha'] . '</Date>';
                        $xml .= '<CustAccount>' . $itemDetalle['CuentaCliente'] . '</CustAccount>';
                        $xml .= '<InvoiceId>' . $NroFacturaCheque[$ContDetalleCehque] . '</InvoiceId>';
                        $xml .= '<DetailDescription>ABONO/PAGO FAC ' . $NroFacturaCheque[$ContDetalleCehque] . ' - Cheque al dia</DetailDescription>';
                        $xml .= '<Value>' . $valorchque[$ContDetalleCehque] . '</Value>';
                        $xml .= '<AppropriationCode></AppropriationCode>';
                        $xml .= '<Document>RC ' . $itemReciCaja['Provisional'] . '</Document>';
                        $xml .= '<PaymentCode>002</PaymentCode>';
                        $xml .= '<DateConsigment></DateConsigment>';
                        $xml .= '<CheckNumber>' . $NroCheque[$ContDetalleCehque] . '</CheckNumber>';
                        $xml .= '<CheckAccountNumber>' . $cuantabancariaCheque[$ContDetalleCehque] . '</CheckAccountNumber>';
                        $xml .= '<CheckBankCode>' . $codbancoCheque[$ContDetalleCehque] . '</CheckBankCode>';
                        $xml .= '<PaymentReference>' . $itemReciCaja['Provisional'] . '</PaymentReference>';
                        $xml .= '<CounterpartAccount></CounterpartAccount>';
                        $xml .= '<Notes>Responsable: ' . $responsable . ' ' . $NombreResponsable . '  --  Girado a :  ' . $NombreGirado . ' </Notes>';
                        $xml .= '<TermDays>' . $DiasVigencia . '</TermDays>';
                        $xml .= '<DateDays>' . $diasVencidos . '</DateDays>';
                        $xml .= '<ExpiredDays>' . $resultadoDias . '</ExpiredDays>';
                        $xml .= '<BalanceReason>' . $itemDetalle['CodMotivoSaldo'] . '</BalanceReason>';
                        $xml .= '<InvoiceValue>' . $itemDetalle['ValorFactura'] . '</InvoiceValue>';
                        $xml .= '<ValuePaymForm>' . trim($valorTotal[$ContDetalleCehque]) . '</ValuePaymForm>';
                        $xml .='</Detail>';
                    };
                    $ContDetalleCehque++;
                }
                $detalleRecibocheque = "";



                foreach ($CodCuentaBancariaChequeConsignacion as $codigoCuentaBancaria) {
                    foreach ($DetalleReciboChequeConsignacionDetalle as $itemRCHECONSIGDETALLE) {
                        $ContDetalle = 0;
                        foreach ($itemRCHECONSIGDETALLE as $item) {
                            $xml .='<Detail>';
                            //$xml .= '<id>' . count($DetalleReciboChequeConsignacionDetalle) . '</id>';
                            $xml .= '<Date>' . $itemReciCaja['Fecha'] . '</Date>';
                            $xml .= '<CustAccount>' . $itemDetalle['CuentaCliente'] . '</CustAccount>';
                            $xml .= '<InvoiceId>' . $NroFacturaChequeConsignacion[$ContDetalle] . '</InvoiceId>';
                            $xml .= '<DetailDescription>ABONO/PAGO FAC ' . $NroFacturaChequeConsignacion[$ContDetalle] . ' - Cheque Consignado</DetailDescription>';
                            $xml .= '<Value>' . $chequeValorDetalle[$ContDetalle] . '</Value>';
                            $xml .= '<AppropriationCode></AppropriationCode>';
                            $xml .= '<Document>RC ' . $itemReciCaja['Provisional'] . '</Document>';
                            $xml .= '<PaymentCode>001</PaymentCode>';
                            $xml .= '<DateConsigment>' . $FechaChequeCosignacionDetalle[$ContDetalle] . '</DateConsigment>';
                            $xml .= '<CheckNumber>' . $NroChequeConsignacionDetalle[$ContDetalle] . '</CheckNumber>';
                            $xml .= '<CheckAccountNumber>' . $CuentaBancariaChequeConsignacionDetalle[$ContDetalle] . '</CheckAccountNumber>';
                            $xml .= '<CheckBankCode>' . $CodBancoChequeConsignacionDetalle[$ContDetalle] . '</CheckBankCode>';
                            $xml .= '<PaymentReference>' . $nroConsignacionCheque[$ContDetalle] . '</PaymentReference>';
                            $xml .= '<CounterpartAccount>' . $codigoCuentaBancaria . '</CounterpartAccount>';
                            $xml .= '<Notes>Responsable: ' . $responsable . '  ' . $NombreResponsable . '</Notes>';
                            $xml .= '<TermDays>' . $DiasVigencia . '</TermDays>';
                            $xml .= '<DateDays>' . $diasVencidos . '</DateDays>';
                            $xml .= '<ExpiredDays>' . $resultadoDias . '</ExpiredDays>';
                            $xml .= '<BalanceReason>' . $itemDetalle['CodMotivoSaldo'] . '</BalanceReason>';
                            $xml .= '<InvoiceValue>' . $itemDetalle['ValorFactura'] . '</InvoiceValue>';
                            $xml .= '<ValuePaymForm>' . trim($ValorTotalChequeconsignacion[$ContDetalle]) . '</ValuePaymForm>';
                            $xml .='</Detail>';
                            $ContDetalle++;
                        }
                    }
                };


                $contDetalleConsignacionEfectivo = 0;
                foreach ($detalleReciboEfectivoConsig as $itemREFC) {

                    $xml .='<Detail>';
                    $xml .= '<Date>' . $itemReciCaja['Fecha'] . '</Date>';
                    $xml .= '<CustAccount>' . $itemDetalle['CuentaCliente'] . '</CustAccount>';
                    $xml .= '<InvoiceId>' . $NroFacturaEfectivoConsignacion[$contDetalleConsignacionEfectivo] . '</InvoiceId>';
                    $xml .= '<DetailDescription>ABONO/PAGO FAC ' . $NroFacturaEfectivoConsignacion[$contDetalleConsignacionEfectivo] . ' - Consignacion</DetailDescription>';
                    $xml .= '<Value>' . $valorEfecConsig[$contDetalleConsignacionEfectivo] . '</Value>';
                    $xml .= '<AppropriationCode></AppropriationCode>';
                    $xml .= '<Document>RC ' . $itemReciCaja['Provisional'] . '</Document>';
                    $xml .= '<PaymentCode>004</PaymentCode>';
                    $xml .= '<DateConsigment>' . $FechaEfectiConsignacion[$contDetalleConsignacionEfectivo] . '</DateConsigment>';
                    $xml .= '<CheckNumber> </CheckNumber>';
                    $xml .= '<CheckAccountNumber></CheckAccountNumber>';
                    $xml .= '<CheckBankCode></CheckBankCode>';
                    $xml .= '<PaymentReference>' . $NumeroConsignacionEfectivo[$contDetalleConsignacionEfectivo] . '</PaymentReference>';
                    $xml .= '<CounterpartAccount>' . $CodCuentaBancaraEfectivoConsignacion[$contDetalleConsignacionEfectivo] . '</CounterpartAccount>';
                    $xml .= '<Notes>Responsable: ' . $responsable . ' ' . $NombreResponsable . '</Notes>';
                    $xml .= '<TermDays>' . $DiasVigencia . '</TermDays>';
                    $xml .= '<DateDays>' . $diasVencidos . '</DateDays>';
                    $xml .= '<ExpiredDays>' . $resultadoDias . '</ExpiredDays>';
                    $xml .= '<BalanceReason>' . $itemDetalle['CodMotivoSaldo'] . '</BalanceReason>';
                    $xml .= '<InvoiceValue>' . $itemDetalle['ValorFactura'] . '</InvoiceValue>';
                    $xml .= '<ValuePaymForm>' . trim($ValorTotalConsignacionEfectivo[$contDetalleConsignacionEfectivo]) . '</ValuePaymForm>';
                    $xml .='</Detail>';
                    $contDetalleConsignacionEfectivo++;
                }

                $contDetalleConsignacionEfectivo = "";
                $detalleReciboEfectivoConsig = "";

                foreach ($detalleReciboEfectivo as $itemEfectivo) {

                    $xml .='<Detail>';
                    $xml .= '<Date>' . $itemReciCaja['Fecha'] . '</Date>';
                    $xml .= '<CustAccount>' . $itemDetalle['CuentaCliente'] . '</CustAccount>';
                    $xml .= '<InvoiceId>' . $detalleReciboEfectivo[0]['NumeroFactura'] . '</InvoiceId>';
                    $xml .= '<DetailDescription>ABONO/PAGO FAC ' . $detalleReciboEfectivo[0]['NumeroFactura'] . ' - Pago en Efectivo</DetailDescription>';
                    $xml .= '<Value>' . $itemEfectivo['Valor'] . '</Value>';
                    $xml .= '<AppropriationCode> </AppropriationCode>';
                    $xml .= '<Document>RC ' . $itemReciCaja['Provisional'] . '</Document>';
                    $xml .= '<PaymentCode>005</PaymentCode>';
                    $xml .= '<DateConsigment></DateConsigment>';
                    $xml .= '<CheckNumber> </CheckNumber>';
                    $xml .= '<CheckAccountNumber></CheckAccountNumber>';
                    $xml .= '<CheckBankCode></CheckBankCode>';
                    $xml .= '<PaymentReference>' . $itemReciCaja['Provisional'] . '</PaymentReference>';
                    $xml .= '<CounterpartAccount></CounterpartAccount>';
                    $xml .= '<Notes>Responsable: ' . $responsable . '  ' . $NombreResponsable . '</Notes>';
                    $xml .= '<TermDays>' . $DiasVigencia . '</TermDays>';
                    $xml .= '<DateDays>' . $diasVencidos . '</DateDays>';
                    $xml .= '<ExpiredDays>' . $resultadoDias . '</ExpiredDays>';
                    $xml .= '<BalanceReason>' . $itemDetalle['CodMotivoSaldo'] . '</BalanceReason>';
                    $xml .= '<InvoiceValue>' . $itemDetalle['ValorFactura'] . '</InvoiceValue>';
                    $xml .= '<ValuePaymForm>' . trim($itemEfectivo['Valor']) . '</ValuePaymForm>';
                    $xml .='</Detail>';
                }
                $detalleReciboEfectivo = "";
            }
            $xml .= '</Header>';
            $xml .= '</panel>';
        }

        return $xml;
    }

    /**
     * 
     * @param string $idRecibo
     * @param string $idTipoDoc
     * @param string $CodAgencia
     * @return string
     * @soap
     */
    public function setGenerarReciboCajaCheuqePosfechado($idRecibo, $idTipoDoc, $CodAgencia) {

        $InfoXMl = ServiceAltipal::model()->getReciboCajaChequePostService($idRecibo, $idTipoDoc, $CodAgencia);

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXMl as $itemReciCajaCheuquePosfe) {

            if ($itemReciCajaCheuquePosfe['Responsable'] == "") {

                $respoCod = $itemReciCajaCheuquePosfe['CodAsesor'];
            } else {

                $respoCod = $itemReciCajaCheuquePosfe['Responsable'];
            }

            $InforChequePosEncabe = ServiceAltipal::model()->getInfoChequePosEncabezado($itemReciCajaCheuquePosfe['Id'], $CodAgencia);

            $xml .= '<Panel>';
            foreach ($InforChequePosEncabe as $itemChequePosFechado) {



                if ($itemChequePosFechado['Posfechado'] == 1) {


                    $xml .= '<Header>';
                    $xml .= '<SalesAreaCode>' . trim($itemReciCajaCheuquePosfe['ZonaVenta']) . '</SalesAreaCode>';
                    $xml .= '<ResponsibleCode>' . $respoCod . '</ResponsibleCode>';
                    $xml .= '<DocumentPostf>RC ' . $itemReciCajaCheuquePosfe['Provisional'] . '</DocumentPostf>';
                    $xml .= '<CheckNumPostf>' . trim($itemChequePosFechado['NroCheque']) . '</CheckNumPostf>';
                    $xml .= '<CheckBankCode>' . trim($itemChequePosFechado['CodBanco']) . '</CheckBankCode>';

                    $xml .= '<DatePostf>' . $itemReciCajaCheuquePosfe['Fecha'] . '</DatePostf>';
                    $xml .= '<DueDatePostf>' . trim($itemChequePosFechado['Fecha']) . '</DueDatePostf>';
                    $xml .= '<BankAccountNumPostf>' . $itemChequePosFechado['CuentaCheque'] . '</BankAccountNumPostf>';

                    $InfoChquePosfechadoDetalle = ServiceAltipal::model()->getInfoChequeDetalle($itemReciCajaCheuquePosfe['Id'], $itemChequePosFechado['NroCheque'], $CodAgencia);


                    foreach ($InfoChquePosfechadoDetalle as $itemDetalle) {


                        $xml .= '<Detail>';
                        $xml .= '<AccountNumPostf>' . $itemReciCajaCheuquePosfe['CuentaCliente'] . '</AccountNumPostf>';
                        $xml .= '<InvoicePostf>' . $itemDetalle['NumeroFactura'] . '</InvoicePostf>';
                        $xml .= '<ValuePostf>' . $itemDetalle['ValorTotal'] . '</ValuePostf>';
                        $xml .= '<AmountPostf>' . $itemDetalle['Valor'] . '</AmountPostf>';
                        $xml .= '</Detail>';
                    }

                    $xml .= '</Header>';
                }
            }
            $xml .= '</Panel>';
        }
        return $xml;
    }

    /**
     * @param string $cadena  extructura    
     * @return string  El mensaje del servicio
     * @soap
     */
    public function setErroresInsert($cadena) {
        ServiceAltipal::model()->insertErroresInser($cadena);
        return "1";
    }

    /**
     * @param string $tipoDocumento 
     * @return string  El mensaje del servicio
     * @return string
     * @soap
     */
    public function setTransaccionesAx($tipoDocumento) {


        $Transaccionesax = ServiceAltipal::model()->ConsultaDatosGlobalDocumento($tipoDocumento);


        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';

        $cadena.='<transaccionesax>';
        foreach ($Transaccionesax as $item) {
            $cadena.='<transaccionesaxItem>';
            $cadena.='<CodTipoDocumentoActivityItem>';
            $cadena.=$item["CodTipoDocumentoActivity"];
            $cadena.='</CodTipoDocumentoActivityItem>';

            $cadena.='<IdDocumentoItem>';
            $cadena.=$item["IdDocumento"];
            $cadena.='</IdDocumentoItem>';

            $cadena.='<CodigoAgenciaItem>';
            $cadena.=$item["CodigoAgencia"];
            $cadena.='</CodigoAgenciaItem>';

            $cadena.='</transaccionesaxItem>';
        }
        $cadena.='</transaccionesax>';

        return $cadena;
    }

    /**
     * @param string $tipoDocumento 
     * @return string  El mensaje del servicio
     * @return string
     * @soap
     */
    public function setHabilitarEnvio($tipoDocumento) {


        $Transaccionesax = ServiceAltipal::model()->ConsultaHabilitarEnvios();
        
    }

    public function createClienteNuevo($cuentaCliente, $agencia) {
        $datos = ServiceAltipal::model()->getDatosClienteNuevo($cuentaCliente, $agencia);
        foreach ($datos as $item) {
            ServiceAltipal::model()->InsertClienteNuevo($item['ArchivoXml'], $item['Identificacion'], $item['Identificacion'], $item['RazonSocial'], $item['Direccion'], $item['Telefono'], $item['TelefonoMovil'], $item['Email'], 'No', $item['CodCadenadeEmpresa'], $item['CodBarrio'], $item['CodigoPostal'], $item['Latitud'], $item['Longitud']);

            $CodigoGrupoPrecioVenta = "";
            $CodigoGrupoDescuentoLineaVenta = "";
            $CodigoGrupoDescuentoMultilineaVenta = "";
            $datosCadenaEmpresa = ServiceAltipal::model()->getCadenaEmpresa($item['CodCadenadeEmpresa'], $agencia);
            foreach ($datosCadenaEmpresa as $it) {
                $CodigoGrupoPrecioVenta = $it['CodigoGrupoPrecioVenta'];
                $CodigoGrupoDescuentoLineaVenta = $it['CodigoGrupoDescuentoLineaVenta'];
                $CodigoGrupoDescuentoMultilineaVenta = $it['CodigoGrupoDescuentoMultilineaVenta'];
            }

            ServiceAltipal::model()->InsertClienteNuevoRuta($item['CodZonaVentas'], $item['ArchivoXml'], $item['NumeroVisita'], $item['Posicion'], $item['ZonaLogistica'], '0', '0', '0', '022', '0', '0', '005', $CodigoGrupoDescuentoLineaVenta, $CodigoGrupoDescuentoMultilineaVenta, '', $CodigoGrupoPrecioVenta);
        }
    }

    /**
     * @param string $tipoDocumento
     * @param string $agencia 
     * @return string  El mensaje del servicio
     * @return string
     * @soap
     */
    public function setTransaccionesAxAgencia($tipoDocumento, $agencia) {

        $Transaccionesax = ServiceAltipal::model()->consultaDatosGlobalDocumentoAgencia($tipoDocumento, $agencia);


        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';

        $cadena.='<transaccionesax>';
        $contador = 0;
        $numeroRegistros = count($Transaccionesax);
        $numeroIngreso = 0;
        foreach ($Transaccionesax as $item) {
            if ($contador == 0) {
                $cadena.='<transaccionesaxItem>';
            }

            $cadena.='<CodTipoDocumentoActivityItem' . $contador . '>' . $item["CodTipoDocumentoActivity"] . '</CodTipoDocumentoActivityItem' . $contador . '>';
            $cadena.='<IdDocumentoItem' . $contador . '>' . $item["IdDocumento"] . '</IdDocumentoItem' . $contador . '>';
            $cadena.='<CodigoAgenciaItem' . $contador . '>' . $item["CodigoAgencia"] . '</CodigoAgenciaItem' . $contador . '>';

            $numeroIngreso++;
            if (($contador == 4) || ($numeroIngreso == $numeroRegistros)) {
                $cadena.='</transaccionesaxItem>';
                $contador = 0;
            } else {
                $contador++;
            }
        }
        $cadena.='</transaccionesax>';

        return $cadena;
    }

  /**
     * @param string $cadena  extructura   
     * @return string  El mensaje del servicio
     * @return string
     * @soap
     */
    public function setClienteNuevo() {

      /*  $Transaccionesax = ServiceAltipal::model()->consultaDatosGlobalDocumentoAgencia($tipoDocumento, $agencia);


        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';

        $cadena.='<transaccionesax>';
        $contador = 0;
        $numeroRegistros = count($Transaccionesax);
        $numeroIngreso = 0;
        foreach ($Transaccionesax as $item) {
            if ($contador == 0) {
                $cadena.='<transaccionesaxItem>';
            }

            $cadena.='<CodTipoDocumentoActivityItem' . $contador . '>' . $item["CodTipoDocumentoActivity"] . '</CodTipoDocumentoActivityItem' . $contador . '>';
            $cadena.='<IdDocumentoItem' . $contador . '>' . $item["IdDocumento"] . '</IdDocumentoItem' . $contador . '>';
            $cadena.='<CodigoAgenciaItem' . $contador . '>' . $item["CodigoAgencia"] . '</CodigoAgenciaItem' . $contador . '>';

            $numeroIngreso++;
            if (($contador == 4) || ($numeroIngreso == $numeroRegistros)) {
                $cadena.='</transaccionesaxItem>';
                $contador = 0;
            } else {
                $contador++;
            }
        }
        $cadena.='</transaccionesax>';*/

        return "OK";
    }

}
