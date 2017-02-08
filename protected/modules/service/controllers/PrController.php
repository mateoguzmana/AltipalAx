<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PrController extends Controller {

    public function actioninsertglobal() {
        $zonas = Consultas::model()->getTodaslasZonas();
        foreach ($zonas as $item) {
            Consultas::model()->insertTodaslasZonas($item['CodZonaVentas'], $item['CodAgencia']);
        }
    }

    public function actionsetGenerarXMLPedido($idPedido, $idTipoDoc, $CodAgencia) {
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
                    $cont = 0;
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
                            /* echo '<pre>';
                              print_r($infoaprobacion); */
                            $QuienAutorizaDscto = 0;
                            $EstadoRevisadoAltipal = 0;
                            $EstadoRevisadoProveedor = 0;
                            $EstadoRechazoAltipal = 0;
                            $EstadoRechazoProveedor = 0;
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
                                        $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
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
                                        $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
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
                                        $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                                        $xml .= '</Detail>';
                                    }
                                    $cont++;
                                }
                            endforeach;
                            if ($cont == 0) {
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
                                $xml .='<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
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
                            $xml .= '<agreementid>' . $Itemdetail['IdAcuerdoLinea'] . '</agreementid>';
                            $xml .= '</Detail>';
                        }
                    }
                    if ($Itemdetail['CodigoTipo'] == "KD" || $Itemdetail['CodigoTipo'] == "KV") {
                        $InfoXMLDetailKD = ServiceAltipal::model()->getPedidoDetalleKidService($Itemdetail['Id'], $CodAgencia);
                        foreach ($InfoXMLDetailKD as $itemKit) {
                            // $totalkit = $Itemdetail['Cantidad'] * $itemKit['Cantidad'];
// $totalPrecioVentaBaseVariante = $itemKit['PrecioVentaBaseVariante'] * $Itemdetail['Cantidad'];
                            $totalkit = $Itemdetail['Cantidad'];
                            $totalPrecioVentaBaseVariante = $itemKit['PrecioVentaBaseVariante'];
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
                            $xml .= '<KitQuantity>' . $totalkit . '</KitQuantity>';
                            $xml .= '<KitItemId>' . $Itemdetail['CodigoArticulo'] . '</KitItemId>';
                            $xml .= '<ComponentQty>' . $itemKit['Cantidad'] . '</ComponentQty>';
                            $xml .='<agreementid>0</agreementid>';
                            $xml .= '</Detail>';
                        }
                    }
                }
                $xml .= '</Header>';
                $xml .= '</panel>';
            }
            echo $xml;
        } else {
            return "";
        }
    }

    public function actionsetGenerarReciboCajaCheuqePosfechado($idRecibo, $idTipoDoc, $CodAgencia) {
        echo $idRecibo;
        echo $idTipoDoc;
        echo $CodAgencia;
        $InfoXMl = ServiceAltipal::model()->getReciboCajaChequePostService($idRecibo, $idTipoDoc, $CodAgencia);
        foreach ($InfoXMl as $itemReciCajaCheuquePosfe) {
            if ($itemReciCajaCheuquePosfe['Responsable'] == "") {
                $respoCod = $itemReciCajaCheuquePosfe['CodAsesor'];
            } else {
                $respoCod = $itemReciCajaCheuquePosfe['Responsable'];
            }
            echo $itemReciCajaCheuquePosfe['Id'];
            $InforChequePosEncabe = ServiceAltipal::model()->getInfoChequePosEncabezado($itemReciCajaCheuquePosfe['Id'], $CodAgencia);
            foreach ($InforChequePosEncabe as $itemChequePosFechado) {
                if ($itemChequePosFechado['Posfechado'] == 1) {
                    $xml .= '<?xml version="1.0" encoding="utf-8"?>';
                    $xml .= '<Panel>';
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
                    $xml .= '</Panel>';
                }
            }
        }
        echo $xml;
    }

    public function actionsetGenerarXMLCobro($idCobro, $idTipoDoc, $CodAgencia) {

        echo $idCobro;
        echo $idTipoDoc;
        echo $CodAgencia;

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
        echo $xml;
    }

    public function actionZonaVentasGlobales() {

        $zonaVentasGloables = ServiceAltipal::model()->getZonaVentasGlo();

        $cadena = '<?xml version="1.0" encoding="UTF-8"?>';
        $cadena.='<Zona>';
        foreach ($zonaVentasGloables as $item) {
            $cadena.='<ZonaVentasItem>';
            $cadena.='<zonaventas>';
            $cadena.=$item['CodZonaVentas'];
            $cadena.='</zonaventas>';
            $cadena.='</ZonaVentasItem>';
        }
        $cadena.='</Zona>';


        echo $cadena;
    }

    public function actionsetGenrarXMLReciboCaja($idRecibo, $idTipoDoc, $CodAgencia) {


        echo $idRecibo;
        echo $idTipoDoc;
        echo $CodAgencia;

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

            echo '<pre>';
            //print_r($InfoXMlDetalle);

            foreach ($InfoXMlDetalle as $itemDetalle) {

                $detalleRecibocheque = ServiceAltipal::model()->getReciboCheque($itemDetalle['Id'], $CodAgencia);

                //print_r($detalleRecibocheque);
                //echo '-----Termine cheque';

                $detalleReciboChequeConsign = ServiceAltipal::model()->getReciboChequeConsig($itemDetalle['Id'], $CodAgencia);

                //print_r($detalleReciboChequeConsign);
                //echo '-----Termine chequeConsignmacion';

                $detalleReciboEfectivo = ServiceAltipal::model()->getReciboEfectivo($itemDetalle['Id'], $CodAgencia);

                //print_r($detalleReciboEfectivo);
                //echo '-----Termine DetalleEfectivo';

                $detalleReciboEfectivoConsig = ServiceAltipal::model()->getReciboEfectivoConsig($itemDetalle['Id'], $CodAgencia);

                //print_r($detalleReciboEfectivoConsig);
                //echo '-----Termine Efectivo Consignacion';
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

                    echo 'entre' . '<br>';

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
                        $xml .= '<Notes>Responsable: ' . $responsable . ' ' . $NombreResponsable . ' -- Girado a : ' . $NombreGirado . ' </Notes>';
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
                            $xml .= '<Notes>Responsable: ' . $responsable . ' ' . $NombreResponsable . '</Notes>';
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
                    $xml .= '<Notes>Responsable: ' . $responsable . ' ' . $NombreResponsable . '</Notes>';
                    $xml .= '<TermDays>' . $DiasVigencia . '</TermDays>';
                    $xml .= '<DateDays>' . $diasVencidos . '</DateDays>';
                    $xml .= '<ExpiredDays>' . $resultadoDias . '</ExpiredDays>';
                    $xml .= '<BalanceReason>' . $itemDetalle['CodMotivoSaldo'] . '</BalanceReason>';
                    $xml .= '<InvoiceValue>' . $itemDetalle['ValorFactura'] . '</InvoiceValue>';
                    $xml .= '<ValuePaymForm>' . trim($itemEfectivo['ValorTotal']) . '</ValuePaymForm>';
                    $xml .='</Detail>';
                }
                $detalleReciboEfectivo = "";
            }
            $xml .= '</Header>';
            $xml .= '</panel>';
        }

        echo $xml;
    }

    public function actionsetGenerarXMLTransfeConsig($idTransferecnaiConsignacion, $idTipoDoc, $CodAgencia) {

        $InfoXML = ServiceAltipal::model()->getTransferenciaConsignacionService($idTransferecnaiConsignacion, $idTipoDoc, $CodAgencia);

        echo $idTransferecnaiConsignacion;
        echo $idTipoDoc;
        echo $CodAgencia;

        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {

            $xml .= '<panel>';
            $xml .= '<Header>';
            $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
            $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
            $xml .= '<DailyCode>011</DailyCode>';


            $InfoXMLDetail = ServiceAltipal::model()->getTransferenciaConsignacionDescripcion($itemInfo['IdTransferencia'], $CodAgencia);
            $Nit = ServiceAltipal::model()->getTransferenciaConsignacionNit($itemInfo['CuentaCliente'], $CodAgencia);

            foreach ($InfoXMLDetail as $Itemdetail) {

                $xml .= '<Detail>';
                $xml .= '<Date>' . $itemInfo['FechaTransferencia'] . '</Date>';
                $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
                $xml .= '<DestinyUbication>' . $Nit['Identificacion'] . '</DestinyUbication>';
                $xml .= '<MeasureUnit>' . $Itemdetail['UnidadMedida'] . '</MeasureUnit>';
                $xml .= '<UMQuantity>' . $Itemdetail['Cantidad'] . '</UMQuantity>';
                $xml .= '</Detail>';
            }
            $xml .= '</Header>';
            $xml .= '</panel>';
        }


        echo $xml;
    }

    public function actionAgregar() {

        $zona = '11200';
        $codzonatransferencia = '13063';
        $fechamnesaje = date('Y-m-d');
        $nombreasesor = 'Pablo';
        $asesor = '852369';
        $horamensaje = date('H:m:s');
        $mensaje = 'Se realizo a su zona ventas una transferencia de autoventa enviada por la zona de ventas "' . $zona . '" correspondiente al asesor "' . $asesor . '" - "' . $nombreasesor . '"';
        $mensajeestado = '0';


        echo $asesor . '<br>';
        echo $zona . '<br>';
        echo $codzonatransferencia . '<br>';
        echo $fechamnesaje . '<br>';

        $mensaje = array(
            'IdDestinatario' => $codzonatransferencia,
            'IdRemitente' => $zona,
            'FechaMensaje' => $fechamnesaje,
            'HoraMensaje' => $horamensaje,
            'Mensaje' => $mensaje,
            'Estado' => $mensajeestado,
            'CodAsesor' => $asesor
        );


        $modelMensaje = new Mensajes;
        $modelMensaje->attributes = $mensaje;

        if (!$modelMensaje->validate()) {

            print_r($modelMensaje->getErrors());
        } else {
            $modelMensaje->save();
        }
    }

    public function actionsetGenerarXMLConsignacionVendedor($idConsignacion, $idTipoDoc, $CodAgencia) {


        $InfoXML = ServiceAltipal::model()->getConsignacionVendedor($idConsignacion, $idTipoDoc, $CodAgencia);


        $xml = '<?xml version="1.0" encoding="utf-8"?>';

        foreach ($InfoXML as $itemInfo) {

            $valorefectivo = $itemInfo['ValorConsignadoEfectivo'];
            $valorcheque = $itemInfo['ValorConsignadoCheque'];

            $total = $valorefectivo + $valorcheque;

            $xsetGenerarXMLPedidoml .= '<Panel>';
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

        echo $xml;
    }

}
