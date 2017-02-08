<?php

class RecibosController extends Controller {

    public $valorFacturas;
    public $valorDigitado;
    public $efectivo;

    /*
      public function filters()
      {
      return array( 'accessControl' );
      }
      public function accessRules()
      {
      return array(
      array('allow',
      'users'=>array('@'),
      ),
      array('deny'),
      );
      }
     */

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //  'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function accessRules() {
        if (!Yii::app()->getUser()->hasState('_cedula')) {
            $this->redirect('index.php');
        }
        $cedula = Yii::app()->user->_cedula;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "Cedula = $cedula";
        $idPerfil = Yii::app()->user->_idPerfil;
        $controlador = Yii::app()->controller->getId();
        $PerfilAcciones = Consultas::model()->getPerfilAcciones($idPerfil, $controlador);
        Yii::import('application.extensions.function.Action');
        $estedAction = new Action();
        try {
            $actionAjax = $estedAction->getActions(ucfirst($controlador) . 'Controller', '');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        $acciones = array();
        foreach ($PerfilAcciones as $itemAccion) {
            array_push($acciones, $itemAccion['Descripcion']);
        }
        foreach ($actionAjax as $item) {
            $dato = strtolower('ajax' . $item);
            array_push($acciones, $dato);
        }
        /* validacion para no mostrar botones */
        $arrayAction = Listalink::model()->findPerfil(ucfirst($controlador), $idPerfil);
        $arrayDiferentes = $estedAction->diffActions(ucfirst($controlador) . 'Controller', '', $arrayAction);
        $session = new CHttpSession;
        $session->open();
        $session['diferencia'] = $arrayDiferentes;
        if (count($acciones) <= 0) {
            return array(
                array('deny',
                    'users' => array('*'),
                ),
            );
        } else {
            return array(
                array('allow',
                    'actions' => $acciones,
                    'users' => array('@'),
                ),
                array('deny',
                    'users' => array('*'),
                ),
            );
        }
    }

    public function actionIndex($cliente, $zonaVentas) {
        $codagencia = Yii::app()->user->_Agencia;
        if ($_POST) {
            $session = new CHttpSession;
            $session->open();
            if ($session['Efectivo']) {
                $datosE = $session['Efectivo'];
            } else {
                $datosE = array();
            }
            if ($session['ConsignacionEfec']) {
                $datosCe = $session['ConsignacionEfec'];
            } else {
                $datosCe = array();
            }
            if ($session['Cheque']) {
                $datosC = $session['Cheque'];
            } else {
                $datosC = array();
            }
            if ($session['ConsignacionCheque']) {
                $datosCc = $session['ConsignacionCheque'];
            } else {
                $datosCc = array();
            }
            $datosRecibos = array(
                'Provisional' => $_POST['txtProvisional'],
                'Fecha' => date('Y-m-d'),
                'Hora' => date('H:i:s'),
                'CodAsesor' => Yii::app()->user->_cedula,
                'ZonaVenta' => $_POST['txtZonaVentas'],
                'CuentaCliente' => $_POST['txtCuentaCliente'],
                'Estado' => '0',
                'ArchivoXml' => '',
                'IdentificadorEnvio' => '1',
                'Web' => '1',
                'CodigoCanal' => $session['canalEmpleado'],
                'Responsable' => $session['Responsable'],
                'ExtraRuta' => $session['extraruta'],
                'Ruta' => trim($session['rutaSeleccionada']),
            );
            $recibos = new Reciboscaja;
            $recibos->attributes = $datosRecibos;
            if ($recibos->validate()) {
                $recibos->save();
                //$recibos->Id='2';
                $conPos = 0;
                foreach ($_POST['txtFactura'] as $facturas) {
                    $SaldosFacturas = ModelRecibos::model()->getFactuSaldo($facturas);
                    $valorAbono = $_POST['txtSaldo'][$conPos] + $_POST['txtDescuentoPPValor'][$conPos];
                    $Abono = explode('.', $valorAbono);
                    if ($_POST['txtFactura'][$conPos] != "") {
                        $datosRecibosDetalle = array(
                            'IdReciboCaja' => $recibos->Id,
                            'ZonaVentaFactura' => $_POST['txtZonaVentasFactura'][$conPos],
                            'NumeroFactura' => $_POST['txtFactura'][$conPos],
                            'ValorAbono' => $Abono[0],
                            'DtoProntoPago' => $_POST['txtDescuentoPPValor'][$conPos],
                            'CodMotivoSaldo' => $_POST['txtMotivoSaldo'][$conPos],
                            'ValorFactura' => $SaldosFacturas['ValorNetoFactura'],
                            'SaldoFactura' => $SaldosFacturas['SaldoFactura'],
                            'CuentaCliente' => $_POST['txtCuentaCliente'],
                        );
                        $reciboscajafacturas = new Reciboscajafacturas;
                        $reciboscajafacturas->attributes = $datosRecibosDetalle;
                        if ($reciboscajafacturas->validate()) {
                            $reciboscajafacturas->save();
                            $facturas = $_POST['txtFactura'][$conPos];
                            $saldofac = Consultas::model()->getSaldoFact($facturas);
                            $Agencia = Consultas::model()->getZonaFactura($_POST['txtZonaVentasFactura'][$conPos]);
                            $CodAgencia = $Agencia[0]['CodAgencia'];
                            foreach ($saldofac as $saldos) {
                                $saldocondecimal = $saldos['SaldoFactura'];
                                $saldo = explode('.', $saldocondecimal);
                                $valorAbonoNuevo = $saldo[0] - $Abono[0];
                                Consultas::model()->getActualizarSaldoFacturasAgencia($CodAgencia, $valorAbonoNuevo, $facturas);
                            }
                            //Efectivo
                            foreach ($datosE as $item) {
                                if (trim($item['facturaRecibo']) == trim($_POST['txtFactura'][$conPos])) {
                                    $valorTotalEfectivo = explode('-', $item['totalEfectivo']);
                                    $datosRecibosEfectivo = array(
                                        'IdReciboCajaFacturas' => $reciboscajafacturas->Id,
                                        'Valor' => $item['valorEfectivo'],
                                        'ValorTotal' => $valorTotalEfectivo[0],
                                    );
                                    $recibosefectivo = new Recibosefectivo;
                                    $recibosefectivo->attributes = $datosRecibosEfectivo;
                                    if ($recibosefectivo->validate()) {
                                        $recibosefectivo->save();
                                        ////AQUI SE ACTUALIZA SOLO EL SALDO DE LA FACTURA MAS NO SE LIBERA CUPO
                                        $FormaPagoCliente = Consultas::model()->getFormasdePago($_POST['txtCuentaCliente']);
                                        /////AQUI SE ACTUALIZA EL CUPO Y AL FACTURA DEL CLIENTE SI LA FACTURA QUE SE RECAUDA PERTENECIA A LA MISMA ZONA DE VENTAS
                                        if ($_POST['txtZonaVentasFactura'][$conPos] == $_POST['txtZonaVentas'] && $FormaPagoCliente['CodigoCondicionPago'] != '022') {
                                            $SaldoCupo = Consultas::model()->getSaldoDisponible($_POST['txtCuentaCliente']);
                                            $SaldoDisponible = $SaldoCupo['SaldoCupo'];
                                            $SaldoActualDisponible = $SaldoDisponible + $item['valorEfectivo'];
                                            Consultas::model()->getActualizarsaldocupocliente($SaldoActualDisponible, $_POST['txtCuentaCliente'], $_POST['txtZonaVentas']);
                                        }
                                    } else {
                                        print_r($recibosefectivo->getErrors());
                                    }
                                }
                            }
                            //consignacion efectivo
                            foreach ($datosCe as $item) {
                                $NumConsignacion = explode('-', $item['txtNumeroEc']);
                                if (trim($item['facturaRecibo']) == trim($_POST['txtFactura'][$conPos])) {
                                    $datosRecibosConsignacionEfectivo = array(
                                        'IdReciboCajaFacturas' => $reciboscajafacturas->Id,
                                        'NroConsignacionEfectivo' => $NumConsignacion[0],
                                        'CodBanco' => $item['txtBancoEc'],
                                        'CodCuentaBancaria' => $item['txtCuenta'],
                                        'Fecha' => $item['txtFechaEc'],
                                        'Valor' => $item['txtValorEc'],
                                        'ValorTotal' => $item['txtValorEcConsignacion'],
                                        'TipoConsignacion' => $item['txtFormaPag']
                                    );
                                    $recibosefectivoconsignacion = new Recibosefectivoconsignacion;
                                    $recibosefectivoconsignacion->attributes = $datosRecibosConsignacionEfectivo;
                                    if ($recibosefectivoconsignacion->validate()) {
                                        $recibosefectivoconsignacion->save();
                                        if ($_POST['txtZonaVentasFactura'][$conPos] == $_POST['txtZonaVentas']) {
                                            $SaldoCupo = Consultas::model()->getSaldoDisponible($_POST['txtCuentaCliente']);
                                            $SaldoDisponible = $SaldoCupo['SaldoCupo'];
                                            $SaldoActualDisponible = $SaldoDisponible + $item['txtValorEc'];
                                            Consultas::model()->getActualizarsaldocupocliente($SaldoActualDisponible, $_POST['txtCuentaCliente'], $_POST['txtZonaVentas']);
                                        }
                                    } else {
                                        print_r($recibosefectivoconsignacion->getErrors());
                                    }
                                }
                            }
                            //cheque
                            foreach ($datosC as $item) {
                                if (trim($item['facturaRecibo']) == trim($_POST['txtFactura'][$conPos])) {
                                    $posfecha = 0;
                                    $fecha = date('Y-m-d');
                                    if ($item['txtFechaCheque'] > $fecha) {
                                        $posfecha = 1;
                                        $id = $recibos->Id;
                                        Consultas::model()->UpdateEstadoPosFcha($id);
                                    }
                                    $NumeroCheque = explode('-', $item['txtNumeroCheque']);
                                    $datosRecibosCheque = array(
                                        'IdReciboCajaFacturas' => $reciboscajafacturas->Id,
                                        'NroCheque' => $NumeroCheque[0],
                                        'CodBanco' => $item['txtBancoCheque'],
                                        'CuentaCheque' => $item['txtCuentaCheque'],
                                        'Fecha' => $item['txtFechaCheque'],
                                        'Girado' => $item['txtGirado'],
                                        'Otro' => $item['txtOtro'],
                                        'Valor' => $item['txtValorCheque'],
                                        'Posfechado' => $posfecha,
                                        'ValorTotal' => $item['txtvalorch']
                                    );
                                    $reciboscheque = new Reciboscheque;
                                    $reciboscheque->attributes = $datosRecibosCheque;
                                    //print_r($reciboscheque->attributes);
                                    if ($reciboscheque->validate()) {
                                        $reciboscheque->save();
                                        if ($item['txtFechaCheque'] <= $fecha) {
                                            if ($_POST['txtZonaVentasFactura'][$conPos] == $_POST['txtZonaVentas']) {
                                                $SaldoCupo = Consultas::model()->getSaldoDisponible($_POST['txtCuentaCliente']);
                                                $SaldoDisponible = $SaldoCupo['SaldoCupo'];
                                                $SaldoActualDisponible = $SaldoDisponible + $item['txtValorCheque'];
                                                Consultas::model()->getActualizarsaldocupocliente($SaldoActualDisponible, $_POST['txtCuentaCliente'], $_POST['txtZonaVentas']);
                                            }
                                        }
                                    } else {
                                        print_r($reciboscheque->getErrors());
                                        exit();
                                    }
                                }
                            }
                            foreach ($datosCc as $item) {
                                $txtNumeroECc = explode('-', $item['txtNumeroECc']);
                                if (trim($item['facturaRecibo']) == trim($_POST['txtFactura'][$conPos])) {
                                    $datosRecibosChequeConsignacion = array(
                                        'IdReciboCajaFacturas' => $reciboscajafacturas->Id,
                                        'NroConsignacionCheque' => $txtNumeroECc[0],
                                        'CodBanco' => $item['txtBancoECc'],
                                        'CodCuentaBancaria' => $item['txtCuentaECc'],
                                        'Fecha' => $item['txtFechaECc']
                                    );
                                    $recibosChequeConsignacion = new Reciboschequeconsignacion;
                                    $recibosChequeConsignacion->attributes = $datosRecibosChequeConsignacion;
                                    if ($recibosChequeConsignacion->validate()) {
                                        $recibosChequeConsignacion->save();
                                        foreach ($item['detalle'] as $subItem) {
                                            $txtNumeroDCc = explode('-', $subItem['txtNumeroDCc']);
                                            $datosRecibosChequeConsignacionDetalle = array(
                                                'IdRecibosChequeConsignacion' => $recibosChequeConsignacion->Id,
                                                'NroChequeConsignacion' => $txtNumeroDCc[0],
                                                'CodBanco' => $subItem['txtBancoDCc'],
                                                'CuentaBancaria' => $subItem['txtCuentaDCc'],
                                                'Fecha' => $subItem['txtFechaDCc'],
                                                'Valor' => $subItem['txtValorDCc'],
                                                'ValorTotal' => $subItem['txtValorDCcTotalCheque']
                                            );
                                            $recibosChequeConsignacionDetalle = new Reciboschequeconsignaciondetalle;
                                            $recibosChequeConsignacionDetalle->attributes = $datosRecibosChequeConsignacionDetalle;
                                            if ($recibosChequeConsignacionDetalle->validate()) {
                                                $recibosChequeConsignacionDetalle->save();
                                                if ($_POST['txtZonaVentasFactura'][$conPos] == $_POST['txtZonaVentas']) {
                                                    $SaldoCupo = Consultas::model()->getSaldoDisponible($_POST['txtCuentaCliente']);
                                                    $SaldoDisponible = $SaldoCupo['SaldoCupo'];
                                                    $SaldoActualDisponible = $SaldoDisponible + $subItem['txtValorDCc'];
                                                    Consultas::model()->getActualizarsaldocupocliente($SaldoActualDisponible, $_POST['txtCuentaCliente'], $_POST['txtZonaVentas']);
                                                }
                                            } else {
                                                print_r($recibosChequeConsignacionDetalle->getErrors());
                                                exit();
                                            }
                                        }
                                    } else {
                                        print_r($recibosChequeConsignacion->getErrors());
                                        exit();
                                    }
                                }
                            }
                        } else {
                            print_r($reciboscajafacturas->getErrors());
                            exit();
                        }
                    }
                    $conPos++;
                }
                $emailCliente = Consultas::model()->getEmailCliente($cliente);
                Yii::app()->user->setFlash('msjRecibos', "El  recibo de caja ha sido guardado correctamente!");
                Yii::app()->user->setFlash('infoZonaVentas', $zonaVentas);
                Yii::app()->user->setFlash('infoCuentaCliente', $cliente);
                Yii::app()->user->setFlash('infoProvisional', $_POST['txtProvisional']);
                Yii::app()->user->setFlash('infoEmailCliente', $emailCliente['CorreoElectronico']);
            } else {
                print_r($recibos->getErrors());
                exit();
            }
            if ($item['txtFechaCheque'] > $fecha) {
                $codtipodocchpos = '12';
                $estadochpos = '0';
                $TransaxChPosfechado = array(
                    'CodTipoDocumentoActivity' => $codtipodocchpos,
                    'IdDocumento' => $recibos->Id,
                    'CodigoAgencia' => $codagencia,
                    'EstadoTransaccion' => $estadochpos
                );
                $modeltransaxChpos = new Transaccionesax;
                $modeltransaxChpos->attributes = $TransaxChPosfechado;
                if (!$modeltransaxChpos->validate()) {
                    print_r($modeltransaxChpos->getErrors());
                } else {
                    $modeltransaxChpos->save();
                }
            }
            $codtipodoc = '11';
            $estado = '0';
            $TransaxConsiga = array(
                'CodTipoDocumentoActivity' => $codtipodoc,
                'IdDocumento' => $recibos->Id,
                'CodigoAgencia' => $codagencia,
                'EstadoTransaccion' => $estado
            );
            $modeltransax = new Transaccionesax;
            $modeltransax->attributes = $TransaxConsiga;
            if (!$modeltransax->validate()) {
                print_r($modeltransax->getErrors());
            } else {
                $modeltransax->save();
            }
            if ($session['lista'] == 1) {
                $this->redirect(array('Gestionnoventas/index', 'zonaVentas' => $zonaVentas));
            } else {
                $this->redirect(array('Clientes/MenuClientes', 'cliente' => $cliente, 'zonaVentas' => $zonaVentas));
            }
        }
        $noRecaudos = Consultas::model()->getNoRecaudos($zonaVentas, Yii::app()->user->getState('_cedula'), $cliente);
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas);
        $motivosgestiondecobros = Motivosgestiondecobros::model()->findAll();
        $Formaspago = Formaspago::model()->findAll();
        $recibosvsfacturas = Consultas::model()->getRecibosVsFacturas($cliente);
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/recibos/recibosIndex.js', CClientScript::POS_END
        );
        $datos = Motivossaldo::model()->findAll();
        $this->render('index', array(
            'datosCliente' => $datosCliente,
            'zonaVentas' => $zonaVentas,
            'sitiosVentas' => $sitiosVentas,
            'motivosgestiondecobros' => $motivosgestiondecobros,
            'noRecaudos' => $noRecaudos,
            'Formaspago' => $Formaspago,
            'datos' => $datos));
    }
    /* private function actionGenrarXMLReciboCaja($idRecibo, $idTipoDoc, $CodAgencia) {
      $InfoXMl = ServiceAltipal::model()->getReciboCajaService($idRecibo, $idTipoDoc, $CodAgencia);
      $xml = '<?xml version="1.0" encoding="utf-8"?>';
      foreach ($InfoXMl as $itemReciCaja) {
      if ($itemReciCaja['Responsable'] == "") {
      $respoCod = $itemReciCaja['ZonaVenta'];
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
      //$FormaPago = ServiceAltipal::model()->getFormasPagoService();
      $detalleRecibocheque = ServiceAltipal::model()->getReciboCheque($InfoXMlDetalle['Id'],$CodAgencia);
      $detalleReciboChequeConsign = ServiceAltipal::model()->getReciboChequeConsig($InfoXMlDetalle['Id'],$CodAgencia);
      $detalleReciboEfectivo = ServiceAltipal::model()->getReciboEfectivo($InfoXMlDetalle['Id'],$CodAgencia);
      $detalleReciboEfectivoConsig = ServiceAltipal::model()->getReciboEfectivoConsig($InfoXMlDetalle['Id'],$CodAgencia);
      //SELECT *,'005' as efectivo FROM `recibosefectivo` ;
      //SELECT *,'004' as efectivoconsig FROM `recibosefectivoconsignacion`
      //SELECT *,'002' as cheque FROM `reciboscheque`
      //SELECT *,'001' as chequeconsig FROM `reciboschequeconsignacion`
      if ($detalleReciboEfectivoConsig['efectivoconsig'] == 004) {
      $FechaEfectiConsignacion = $detalleReciboEfectivoConsig['Fecha'];
      $numeroConsignacion = $detalleReciboEfectivoConsig['NroConsignacionEfectivo'];
      }
      if ($detalleRecibocheque['cheque'] == 002) {
      $nroConsignacion = $detalleRecibocheque['NroCheque'];
      $cuantabancara = $detalleRecibocheque['CuentaCheque'];
      $codbanco = $detalleRecibocheque['CodBanco'];
      //
      }
      if ($detalleReciboChequeConsign['chequeconsig'] == 001) {
      $nroConsignacion = $detalleReciboChequeConsign['NroConsignacionCheque'];
      $cuantabancara = $detalleReciboChequeConsign['CodCuentaBancaria'];
      $codbanco = $detalleReciboChequeConsign['CodBanco'];
      //
      $numeroConsignacion = $detalleReciboChequeConsign['NroConsignacionCheque'];
      }
      $numeroConsignacion = $itemReciCaja['Provisional'];
      if ($detalleReciboEfectivo['efectivo'] <> '005' && $detalleRecibocheque['cheque'] <> '002') {
      $cuentaBan = $detalleReciboEfectivoConsig['CodCuentaBancaria'];
      } else {
      $cuentaBan = '';
      }
      if($itemReciCaja['Responsable'] ==""){
      $responsable = $itemReciCaja['CodAsesor'];
      $consultarResponsableAsesor = ServiceAltipal::model()->consultarResponsableAsesor($itemReciCaja['Responsable'],$CodAgencia);
      foreach ($consultarResponsableAsesor as $itemNombreAsesor){}
      $NombreResponsable = $itemNombreAsesor[''];
      }else{
      $responsable = $itemReciCaja['Responsable'];
      $consultarResponsable = ServiceAltipal::model()->consultarResponsable($itemReciCaja['Responsable'],$CodAgencia);
      foreach ($consultarResponsable as $itemNombreResponsable){}
      $NombreResponsable = $itemNombre[''];
      }
      if($detalleReciboChequeConsign[''] == '001' || $detalleRecibocheque[''] == '002'){
      $Girado = 'Girado a:';
      }
      if($detalleRecibocheque['Girado'] == 1){
      $NombreGirado = 'ALTIPAL';
      }else{
      $NombreGirado = 'OTRO';
      }
      $fechas = ServiceAltipal::model()->getFechas($InfoXMlDetalle['Id'],$CodAgencia);
      foreach ($fechas as $itemFecha){}
      $fechaFacturada = $itemFecha['FechaFactura'];
      $fechaVecimiento = $itemFecha['FechaVencimientoFactura'];
      $datetime1 = date_create($fechaFacturada);
      $datetime2 = date_create($fechaVecimiento);
      $Diasvigencia = date_diff($datetime1, $datetime2);
      echo $Diasvigencia;
      ////
      $FechaReciboCaja = $itemReciCaja['Fecha'];
      $FechaFacturaSaldo = $itemFecha['FechaFactura'];
      $datetimeReciCaja = date_create($FechaReciboCaja);
      $datetimeFacturaSaldo = date_create($FechaFacturaSaldo);
      $DiasTranscurridos = date_diff($datetimeReciCaja, $datetimeFacturaSaldo);
      echo $DiasTranscurridos;
      $ResultadoDias = $Diasvigencia - $DiasTranscurridos;
      echo $ResultadoDias;
      foreach ($InfoXMlDetalle as $itemDetalle) {
      $xml .= '<Date>' . $itemReciCaja['Fecha'] . '</Date>';
      $xml .= '<CustAccount>' . $itemReciCaja['CuentaCliente'] . '</CustAccount>';
      $xml .= '<InvoiceId>' . $itemDetalle['NumeroFactura'] . '</InvoiceId>';
      $xml .= '<DetailDescription> ABONO/PAGO FAC ' . $itemDetalle['NumeroFactura'] . ' - ' . 001 . '</DetailDescription>';
      $xml .= '<Value>' . $itemDetalle['ValorAbono'] . '</Value>';
      $xml .= '<AppropriationCode>' . $itemDetalle['CodigoFormadePago'] . '</AppropriationCode>';
      $xml .= '<Document>' . $itemReciCaja['Provisional'] . '</Document>';
      $xml .= '<PaymentCode >' . $FechaEfectiConsignacion . '</PaymentCode>';
      $xml .= '<CheckNumber>' . $nroConsignacion . '</CheckNumber>';
      $xml .= '<CheckAccountNumber>' . $cuantabancara . '</CheckAccountNumber>';
      $xml .= '<CheckBankCode>' . $codbanco . '</CheckBankCode>';
      $xml .= '<PaymentReference>' . $numeroConsignacion . '</PaymentReference>';
      $xml .= '<CounterpartAccount>' . $cuentaBan . '</CounterpartAccount>';
      $xml .= '<Notes>Responsable: ' . $responsable . ' Nombre Responsable: ' . $NombreResponsable . '   ' . $Girado . ':  ' . $NombreGirado . ' </Notes>';
      $xml .= '<TermDays>' . $Diasvigencia . '</TermDays>';
      $xml .= '<DateDays>'. $DiasTranscurridos.'</DateDays>';
      $xml .= '<ExpiredDays>'.$ResultadoDias.'</ExpiredDays>';
      $xml .= '<BalanceReason>' . $itemDetalle['CodMotivoSaldo'] . ' </BalanceReason>';
      $xml .= '<InvoiceValue>' . $itemDetalle['ValorFactura'] . ' </InvoiceValue>';
      }
      $xml .= '</Header>';
      $xml .= '</panel>';
      }
      return $xml;
      } */

    public function actionAjaxCuentasBancarias() {
        $codCuenta = $_POST['CodBanco'];
        $data = Cuentasbancarias::model()->findAll(array("condition" => "CodBanco = '$codCuenta' "));
        $data = CHtml::listData($data, 'CodCuentaBancaria', 'NumeroCuentaBancaria');
        echo "<option value=''>Selecione una cuenta</option>";
        foreach ($data as $value => $city_name)
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($city_name), true);
    }

    public function actionAjaxSetConsignacionEfectivo() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionEfec']) {
            $datosFacturasConsignacionEfectivo = $session['ConsignacionEfec'];
        } else {
            $datosFacturasConsignacionEfectivo = array();
        }
        if ($session['ConsignacionEfecDetalle']) {
            $datosConsignacion = $session['ConsignacionEfecDetalle'];
        } else {
            $datosConsignacion = array();
        }
        $facturaRecibo = $_POST['facturaRecibo'];
        $txtFormaPag = $_POST['txtformaPago'];
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $txtSaldoFacturaSeleccionada = $_POST['txtSaldoFacturaSeleccionada'];
        $txtNumeroEc = $_POST['txtNumeroEc'];
        $txtBancoEc = $_POST['txtBancoEc'];
        $textoBancoEc = $_POST['textoBancoEc'];
        $txtCuenta = $_POST['txtCuenta'];
        $textoCuenta = $_POST['textoCuenta'];
        $txtFechaEc = $_POST['txtFechaEc'];
        $txtValorEc = $_POST['txtValorEc'];
        $txtFacturaEc = $_POST['txtFacturaEc'];
        $txtvalorFacturas = $_POST['txtvalorFacturas'];
        $txtValorEcConsignacion = $_POST['txtValorEcConsignacion'];
        $this->valorFacturas = $txtvalorFacturas;
        $this->valorDigitado = $txtValorEc;
        $this->efectivo = $txtFacturaEc;
        $datosItemFactura = array(
            'facturaRecibo' => $facturaRecibo,
            'txtNumeroEc' => $txtNumeroEc,
            'txtBancoEc' => $txtBancoEc,
            'textoBancoEc' => $textoBancoEc,
            'txtCuenta' => $txtCuenta,
            'textoCuenta' => $textoCuenta,
            'txtFechaEc' => $txtFechaEc,
            'txtValorEc' => $txtValorEc,
            'txtValorEcConsignacion' => $txtValorEcConsignacion,
            'txtFormaPag' => $txtFormaPag
        );
        foreach ($datosFacturasConsignacionEfectivo as $item) {
            if ($item['facturaRecibo'] == $facturaRecibo && $item['txtNumeroEc'] == $txtNumeroEc) {
                echo '0';
                Yii::app()->end();
            }
        }
        if (!$this->calcularValorRecibo($txtFacturaSeleccionada, $txtSaldoFacturaSeleccionada, $txtValorEc)) {
            echo '1';
            Yii::app()->end();
        }
        array_push($datosFacturasConsignacionEfectivo, $datosItemFactura);
        $session['ConsignacionEfec'] = $datosFacturasConsignacionEfectivo;
        $ValorSaldoConsigEfec = 0;
        foreach ($datosFacturasConsignacionEfectivo as $itemFacturasConsignacionEfectivo) {
            if ($itemFacturasConsignacionEfectivo['facturaRecibo'] == $facturaRecibo && $itemFacturasConsignacionEfectivo['txtNumeroEc'] == $txtNumeroEc) {
                $ValorSaldoConsigEfec = $itemFacturasConsignacionEfectivo['txtValorEc'];
            }
        }
        $contPositionConsignacion = 0;
        foreach ($datosConsignacion as $itemDetalleConsignaion) {
            $numerodetalle = $itemDetalleConsignaion['txtNumeroEc'] . '-' . $itemDetalleConsignaion['txtCodBancoEc'];
            if ($numerodetalle == $txtNumeroEc) {
                $datosConsignacion[$contPositionConsignacion]['txtValorEcSaldo'] = $itemDetalleConsignaion['txtValorEcSaldo'] - $ValorSaldoConsigEfec;
            }
            $contPositionConsignacion++;
        }
        $session['ConsignacionEfecDetalle'] = $datosConsignacion;
        echo $this->renderPartial('_consignacionEfectivo', true);
    }

    public function actionAjaxDeleteConsignacionEfectivo() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionEfecDetalle']) {
            $datosConsignacion = $session['ConsignacionEfecDetalle'];
        } else {
            $datosConsignacion = array();
        }
        $txtNumeroEc = $_POST['txtNumeroEc'];
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $SumaSaldoConsigEfectivo = 0;
        $arrayAux = array();
        if ($session['ConsignacionEfec']) {
            $datos = $session['ConsignacionEfec'];
        }
        foreach ($datos as $item) {
            //$numeroConEfecti = $item['txtNumeroEc'].'-'.$item['txtCodBancoEc'];
            $datosFactura = $item['facturaRecibo'];
            if (($item['txtNumeroEc'] == $txtNumeroEc) && trim($txtFacturaSeleccionada) == trim($datosFactura)) {
                $SumaSaldoConsigEfectivo = $item['txtValorEc'];
            } else {
                array_push($arrayAux, $item);
            }
        }
        $session['ConsignacionEfec'] = $arrayAux;
        $cont = 0;
        foreach ($datosConsignacion as $itemDetalle) {
            $numerodetalle = $itemDetalle['txtNumeroEc'] . '-' . $itemDetalle['txtCodBancoEc'];
            if ($numerodetalle == $txtNumeroEc) {
                $datosConsignacion[$cont]['txtValorEcSaldo'] = $itemDetalle['txtValorEcSaldo'] + $SumaSaldoConsigEfectivo;
            }
            $cont++;
        }
        $session['ConsignacionEfecDetalle'] = $datosConsignacion;
        echo $this->renderPartial('_consignacionEfectivo', true);
    }

    public function actionAjaxDeleteCheque() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Cheque']) {
            $datos = $session['Cheque'];
        }
        if ($session['ChequeDetalle']) {
            $datosDetalle = $session['ChequeDetalle'];
        } else {
            $datosDetalle = array();
        }
        $txtNumeroCheque = $_POST['txtNumeroCheque'];
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $SumaSaldoCheque = 0;
        $arrayAux = array();
        foreach ($datos as $item) {
            if (trim($item['facturaRecibo']) == trim($txtFacturaSeleccionada) && $item['txtNumeroCheque'] == $txtNumeroCheque) {
                $SumaSaldoCheque = $item['txtValorCheque'];
            } else {
                array_push($arrayAux, $item);
            }
        }
        $session['Cheque'] = $arrayAux;
        $cont = 0;
        foreach ($datosDetalle as $itemDetalle) {
            $numerochdetalle = $itemDetalle['txtNumeroCheque'] . '-' . $itemDetalle['txtBancoCheque'];
            if ($numerochdetalle == $txtNumeroCheque) {
                $datosDetalle[$cont]['txtValorChequeSaldo'] = $itemDetalle['txtValorChequeSaldo'] + $SumaSaldoCheque;
            }
            $cont++;
        }
        $session['ChequeDetalle'] = $datosDetalle;
        echo $this->renderPartial('_cheque', true);
    }

    public function actionAjaxSetCheque() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Cheque']) {
            $datosFacturaCheque = $session['Cheque'];
        } else {
            $datosFacturaCheque = array();
        }
        if ($session['ChequeDetalle']) {
            $datosDetalleCheque = $session['ChequeDetalle'];
        } else {
            $datosDetalleCheque = array();
        }
        $facturaRecibo = $_POST['facturaRecibo'];
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $txtSaldoFacturaSeleccionada = $_POST['txtSaldoFacturaSeleccionada'];
        $txtNumeroCheque = $_POST['txtNumeroCheque'];
        $txtBancoCheque = $_POST['txtBancoCheque'];
        $textoBancoCheque = $_POST['textoBancoCheque'];
        $txtCuentaCheque = $_POST['txtCuentaCheque'];
        $textoCuentaCheque = $_POST['textoCuentaCheque'];
        $txtFechaCheque = $_POST['txtFechaCheque'];
        $txtValorCheque = $_POST['txtValorCheque'];
        $txtFacturaEc = $_POST['txtFacturaEc'];
        $txtvalorFacturas = $_POST['txtvalorFacturas'];
        $txtGirado = $_POST['txtGirado'];
        $txtOtro = $_POST['txtOtro'];
        $txtvalorch = $_POST['txtvalorch'];
        $this->valorFacturas = $txtvalorFacturas;
        $this->valorDigitado = $txtValorCheque;
        $this->efectivo = $txtFacturaEc;
        if (!$this->calcularValorRecibo($txtFacturaSeleccionada, $txtSaldoFacturaSeleccionada, $txtValorCheque)) {
            echo $txtSaldoFacturaSeleccionada;
            echo $txtFacturaSeleccionada;
            echo $txtValorCheque;
            echo '1';
            Yii::app()->end();
        }
        $datosItemFacturaCheque = array(
            'facturaRecibo' => $facturaRecibo,
            'txtNumeroCheque' => $txtNumeroCheque,
            'txtBancoCheque' => $txtBancoCheque,
            'textoBancoCheque' => $textoBancoCheque,
            'txtCuentaCheque' => $txtCuentaCheque,
            'textoCuentaCheque' => $textoCuentaCheque,
            'txtFechaCheque' => $txtFechaCheque,
            'txtValorCheque' => $txtValorCheque,
            'txtGirado' => $txtGirado,
            'txtOtro' => $txtOtro,
            'txtvalorch' => $txtvalorch
        );
        foreach ($datosFacturaCheque as $itemFacturaCheque) {
            if ($itemFacturaCheque['facturaRecibo'] == $facturaRecibo && $itemFacturaCheque['txtNumeroCheque'] == $txtNumeroCheque) {
                echo '0';
                Yii::app()->end();
            }
        }
        array_push($datosFacturaCheque, $datosItemFacturaCheque);
        $session['Cheque'] = $datosFacturaCheque;
        /* $ValorSaldoCheque = 0;
          foreach ($datosFacturaCheque as $item) {
          if ($item['facturaRecibo'] == $facturaRecibo && $item['txtNumeroCheque'] == $txtNumeroCheque) {
          $ValorSaldoCheque = $item['txtValorCheque'];
          }
          } */
        $contPositionCheque = 0;
        foreach ($datosDetalleCheque as $itemDetalleCheque) {
            $facturadetalle = $itemDetalleCheque['txtNumeroCheque'] . '-' . $itemDetalleCheque['txtBancoCheque'];
            if ($facturadetalle == $txtNumeroCheque) {
                $datosDetalleCheque[$contPositionCheque]['txtValorChequeSaldo'] = $itemDetalleCheque['txtValorChequeSaldo'] - $txtValorCheque;
            }
            $contPositionCheque++;
        }
        $session['ChequeDetalle'] = $datosDetalleCheque;
        echo $this->renderPartial('_cheque', true);
    }

    public function actionAjaxSetEfectivo() {
        $facturaRecibo = $_POST['facturaRecibo'];
        $valorEfectivo = $_POST['valorEfectivo'];
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $txtSaldoFacturaSeleccionada = $_POST['txtSaldoFacturaSeleccionada'];
        $totalEfectivo = $_POST['txtTotalEFec'];
        $SaldoEfectivo = $_POST['txtSaldoEfec'];
        $session = new CHttpSession;
        $session->open();
        if ($session['Efectivo']) {
            $datosFacturasEfectivo = $session['Efectivo'];
        } else {
            $datosFacturasEfectivo = array();
        }
        if ($session['EfectivoDetalle']) {
            $datosDetalleEfectivo = $session['EfectivoDetalle'];
        } else {
            $datosDetalleEfectivo = array();
        }
        $arrayEfectivoFactura = array(
            'facturaRecibo' => $facturaRecibo,
            'valorEfectivo' => $valorEfectivo,
            'totalEfectivo' => $totalEfectivo,
        );
        
        if (!$this->calcularValorRecibo($txtFacturaSeleccionada, $txtSaldoFacturaSeleccionada, $valorEfectivo)) {
            echo '1';
            Yii::app()->end();
        }
        $existeFactura = false;
        foreach ($datosFacturasEfectivo as $temFacturasEfectivo) {
            if ($temFacturasEfectivo['facturaRecibo'] == $facturaRecibo) {
                $existeFactura = true;
                echo '0';
                Yii::app()->end();
                break;
            }
        }
        array_push($datosFacturasEfectivo, $arrayEfectivoFactura);
        $session['Efectivo'] = $datosFacturasEfectivo;
        $contPositionEfectivo = 0;
        $EfectivoTotal = explode('-', $totalEfectivo);
        foreach ($datosDetalleEfectivo as $itemDetalleEfectivo) {
            if ($EfectivoTotal[0] == $itemDetalleEfectivo['ValorEfectivo']) {
                $datosDetalleEfectivo[$contPositionEfectivo]['SaldoEfectivo'] = $itemDetalleEfectivo['SaldoEfectivo'] - $valorEfectivo;
            }
            $contPositionEfectivo++;
        }
        $session['EfectivoDetalle'] = $datosDetalleEfectivo;
        echo $this->renderPartial('_efectivo', array(), true);
    }

    public function actionAjaxDeleteValorEfectivo() {
        $facturaRecibo = $_POST['facturaRecibo'];
        $txtValotTotal = $_POST['txtValotTotal'];
        $valorEfectivoSumar = $_POST['valorEf'];
        $session = new CHttpSession;
        $session->open();
        if ($session['Efectivo']) {
            $datosFacturaEfectivo = $session['Efectivo'];
        } else {
            $datosFacturaEfectivo = array();
        }
        if ($session['EfectivoDetalle']) {
            $datosDetalleEfectivo = $session['EfectivoDetalle'];
        } else {
            $datosDetalleEfectivo = array();
        }
        $arrayAux = array();
        foreach ($datosFacturaEfectivo as $itemFacturaEfectivo) {
            if ($itemFacturaEfectivo['facturaRecibo'] != $facturaRecibo) {
                array_push($arrayAux, $itemFacturaEfectivo);
            }
        }
        $arrayAuxiDtl = array();
        foreach ($datosDetalleEfectivo as $keydetalle => $ItemDetalle) {
            $valorEfectivoDta = $ItemDetalle['ValorEfectivo'] . '-' . $keydetalle;
            if ($valorEfectivoDta == $txtValotTotal) {
                $ItemDetalle['SaldoEfectivo'] = $ItemDetalle['SaldoEfectivo'] + $valorEfectivoSumar;
            }
            array_push($arrayAuxiDtl, $ItemDetalle);
        }
        $session['EfectivoDetalle'] = $arrayAuxiDtl;
        $session['Efectivo'] = $arrayAux;
        echo $this->renderPartial('_efectivo', array(), true);
    }

    public function actionAjaxSetConsignacionCheque() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionCheque']) {
            $datosFacturaConsigCheque = $session['ConsignacionCheque'];
        } else {
            $datosFacturaConsigCheque = array();
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosCconsignacion = $session['ConsignacionChequeDetalle'];
        } else {
            $datosCconsignacion = array();
        }
        $facturaRecibo = $_POST['facturaRecibo'];
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $txtSaldoFacturaSeleccionada = $_POST['txtSaldoFacturaSeleccionada'];
        $txtNumeroECc = $_POST['txtNumeroECc'];
        $txtBancoECc = $_POST['txtBancoECc'];
        $textoBancoECc = $_POST['textoBancoECc'];
        $txtCuentaECc = $_POST['txtCuentaECc'];
        $textoCuentaECc = $_POST['textoCuentaECc'];
        $txtFechaECc = $_POST['txtFechaECc'];
        $txtCodBancoECc = $_POST['txtCodBancoECc'];
        $txtNumeroDCc = $_POST['txtNumeroDCc'];
        $txtBancoDCc = $_POST['txtBancoDCc'];
        $textoBancoDCc = $_POST['textoBancoDCc'];
        $txtCuentaDCc = $_POST['txtCuentaDCc'];
        $textoCuentaDCc = $_POST['textoCuentaDCc'];
        $txtFechaDCc = $_POST['txtFechaDCc'];
        $txtValorDCc = $_POST['txtValorDCc'];
        $txtFacturaEc = $_POST['txtFacturaEc'];
        $txtvalorFacturas = $_POST['txtvalorFacturas'];
        $txtValorDCcSaldoCheque = $_POST['txtValorDCcSaldoCheque'];
        $txtValorDCcTotalCheque = $_POST['txtValorDCcTotalCheque'];
        $this->valorFacturas = $txtvalorFacturas;
        $this->valorDigitado = $txtValorDCc;
        $this->efectivo = $txtFacturaEc;
        if (!$this->calcularValorRecibo($txtFacturaSeleccionada, $txtSaldoFacturaSeleccionada, $txtValorDCc)) {
            echo '1';
            Yii::app()->end();
        }
        $arrayEncabezado = array(
            'facturaRecibo' => $facturaRecibo,
            'txtNumeroECc' => $txtNumeroECc,
            'txtBancoECc' => $txtBancoECc,
            'textoBancoECc' => $textoBancoECc,
            'txtCuentaECc' => $txtCuentaECc,
            'textoCuentaECc' => $textoCuentaECc,
            'txtFechaECc' => $txtFechaECc,
            'txtCodBancoECc' => $txtCodBancoECc
        );
        $arrayDetalle = array(
            'txtNumeroDCc' => $txtNumeroDCc,
            'txtBancoDCc' => $txtBancoDCc,
            'textoBancoDCc' => $textoBancoDCc,
            'txtCuentaDCc' => $txtCuentaDCc,
            'textoCuentaDCc' => $textoCuentaDCc,
            'txtFechaDCc' => $txtFechaDCc,
            'txtValorDCc' => $txtValorDCc,
            'txtValorDCcSaldoCheque' => $txtValorDCcSaldoCheque,
            'txtValorDCcTotalCheque' => $txtValorDCcTotalCheque
        );
        foreach ($datosFacturaConsigCheque as $itemFacturaConsigCheque) {
            foreach ($itemFacturaConsigCheque['detalle'] as $itemDetalleFacturaConsigCheque) {
                if ($itemFacturaConsigCheque['facturaRecibo'] == $facturaRecibo && $itemDetalleFacturaConsigCheque['txtNumeroDCc'] == $txtNumeroDCc) {
                    echo '0';
                    Yii::app()->end();
                }
            }
        }
        $cont1 = 0;
        /* echo '<pre>';
          print_r($datosCconsignacion); */
        $existHeaderConsig = false;
        $contPositionChqueConsig = 0;
        foreach ($datosFacturaConsigCheque as $itemFacturaConsigCheque) {
            if (($itemFacturaConsigCheque['txtNumeroECc'] == $txtNumeroECc) && ($itemFacturaConsigCheque['facturaRecibo'] == $facturaRecibo)) {
                foreach ($itemFacturaConsigCheque['detalle'] as $itemDetalleFacturaConsigCheque) {
                    if ($itemDetalleFacturaConsigCheque['txtNumeroDCc'] == $txtNumeroDCc) {
                        array_push($datosFacturaConsigCheque['detalle'], $arrayDetalle);
                        $existHeaderConsig = true;
                        break;
                    }
                }
            }
            $contPositionChqueConsig++;
        }
        if (!$existHeaderConsig) {
            $arrayEncabezado['detalle'][0] = $arrayDetalle;
            array_push($datosFacturaConsigCheque, $arrayEncabezado);
        }
        foreach ($datosCconsignacion as $itemCconsignacion) {
            $cont2 = 0;
            foreach ($itemCconsignacion['detalle'] as $itemDetailCconsignacion) {
                $NumChc = $itemDetailCconsignacion['txtNumeroDCc'] . '-' . $itemDetailCconsignacion['txtCodBancoDCc'];
                if ($NumChc == $txtNumeroDCc) {
                    $itemDetailCconsignacion['txtValorDCcSaldo'] = $itemDetailCconsignacion['txtValorDCcSaldo'] - $txtValorDCc;
                    $resdult = $itemDetailCconsignacion['txtValorDCcSaldo'];
                    $datosCconsignacion[$cont1]['detalle'][$cont2]['txtValorDCcSaldo'] = $resdult;
                }
                $cont2++;
            }
            $cont1++;
        }
        $session['ConsignacionCheque'] = $datosFacturaConsigCheque;
        $session['ConsignacionChequeDetalle'] = $datosCconsignacion;
        echo $this->renderPartial('_consignacionCheque', true);
    }

    public function actionAjaxDeleteChequeSubItem() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionCheque']) {
            $datos = $session['ConsignacionCheque'];
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        }
        $txtNumeroECc = $_POST['txtNumeroECc'];
        $txtNumeroDCc = $_POST['txtNumeroDCc'];
        $txtValorDcc = $_POST['txtValorDcc'];
        $contItem = 0;
        $contSubItem = 0;
        /* echo '<pre>';
          print_r($datos); */
        foreach ($datos as $item) {
            if ($item['txtNumeroECc'] == $txtNumeroECc) {
                foreach ($item['detalle'] as $subItem) {
                    //$NumeroCh = 
                    if ($subItem['txtNumeroDCc'] == $txtNumeroDCc) {

                        unset($datos[$contItem]['detalle'][$contSubItem]);
                        $datos[$contItem]['detalle'] = array_values($datos[$contItem]['detalle']);
                    }
                    $contSubItem++;
                }
            }
            $contItem++;
        }
        $session['ConsignacionCheque'] = $datos;
        /* echo 'datosdetalle';
          echo '<pre>';
          print_r($datosConsignacionChequeDta); */
        $cont1 = 0;
        foreach ($datosConsignacionChequeDta as $item) {
            $cont2 = 0;
            foreach ($item['detalle'] as $itemDetail) {
                $NumeroDCc = $itemDetail['txtNumeroDCc'] . '-' . $itemDetail['txtCodBancoDCc'];
                if (trim($NumeroDCc) == $txtNumeroDCc) {
                    $datosConsignacionChequeDta[$cont1]['detalle'][$cont2]['txtValorDCcSaldo'] = $itemDetail['txtValorDCcSaldo'] + $txtValorDcc;
                }
                $cont2++;
            }
            $cont1++;
        }
        $session['ConsignacionChequeDetalle'] = $datosConsignacionChequeDta;
        echo $this->renderPartial('_consignacionCheque', true);
    }

    public function actionAjaxDeleteChequeItem() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionCheque']) {
            $datosChequeConsigFactura = $session['ConsignacionCheque'];
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        }
        $txtNumeroECc = $_POST['txtNumeroECc'];
        $txtFactura = $_POST['txtfactura'];
        $json = json_encode($_POST['JsonString']);
        $jsonArray = json_decode($json, true);
        $contItem = 0;
        foreach ($datosChequeConsigFactura as $itemChequeConsigFactura) {
            if ($itemChequeConsigFactura['txtNumeroECc'] == $txtNumeroECc && $itemChequeConsigFactura['facturaRecibo'] == $txtFactura) {
                foreach ($itemChequeConsigFactura['detalle'] as $itemChequeConsigFacturaDetalle) {
                    $NumeroDCcFacurra = $itemChequeConsigFacturaDetalle['txtNumeroDCc'];
                    foreach ($jsonArray as $itemJsonFactura) {
                        if (trim($NumeroDCcFacurra) == $itemJsonFactura['txtNumero']) {
                            unset($datosChequeConsigFactura[$contItem]);
                        }
                    }
                }
            }
            $contItem++;
        }
        $datosChequeConsigFactura = array_values($datosChequeConsigFactura);
        $session['ConsignacionCheque'] = $datosChequeConsigFactura;
        /* echo '<pre>';
          print_r($datos);
          exit(); */
        /* echo '<pre>';
          print_r($datosConsignacionChequeDta); */
        $cont1 = 0;
        foreach ($datosConsignacionChequeDta as $item) {
            $cont2 = 0;
            foreach ($item['detalle'] as $itemDetail) {
                $NumeroDCc = $itemDetail['txtNumeroDCc'] . '-' . $itemDetail['txtCodBancoDCc'];
                foreach ($jsonArray as $itemJson) {
                    if (trim($NumeroDCc) == $itemJson['txtNumero']) {
                        $datosConsignacionChequeDta[$cont1]['detalle'][$cont2]['txtValorDCcSaldo'] = $itemDetail['txtValorDCcSaldo'] + $itemJson['txtValorDcc'];
                    }
                }
                $cont2++;
            }
            $cont1++;
        }
        /* $cont1 = 0;
          foreach ($datosConsignacionChequeDta as $item) {
          $cont2 = 0;
          foreach ($item['detalle'] as $itemDetail) {
          $NumeroDCc = $itemDetail['txtNumeroDCc'] . '-' . $itemDetail['txtCodBancoDCc'];
          if (trim($NumeroDCc) == $txtNumeroDCc) {
          $datosConsignacionChequeDta[$cont1]['detalle'][$cont2]['txtValorDCcSaldo'] = $itemDetail['txtValorDCcSaldo'] + $txtValorDcc;
          }
          $cont2++;
          }
          $cont1++;
          } */
        $session['ConsignacionChequeDetalle'] = $datosConsignacionChequeDta;
        echo $this->renderPartial('_consignacionCheque', true);
    }

    public function actionAjaxValidarRecibosCaja() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCe = $session['ConsignacionEfec'];
        } else {
            $datosCe = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        $txtvalorFacturas = $_POST['txtvalorFacturas'];
        $txtFacturaEc = $_POST['txtFacturaEc'];
        $valorCe = 0;
        foreach ($datosCe as $item) {
            $valorCe+=$item['txtValorEc'];
        }
        $valorC = 0;
        foreach ($datosC as $item) {
            $valorC+=$item['txtValorCheque'];
        }
        $valorCc = 0;
        foreach ($datosCc as $item) {
            foreach ($item['detalle'] as $subItem) {
                $valorCc+=$subItem['txtValorDCc'];
            }
        }
        $totalSaldos = $valorCe + $valorC + $valorCc + $txtFacturaEc;
        if ($txtvalorFacturas == $totalSaldos) {
            echo '0';
        } else {
            echo $txtvalorFacturas - $totalSaldos;
        }
    }

    public function diff_dte($date1, $date2) {
        if (!is_integer($date1))
            $date1 = strtotime($date1);
        if (!is_integer($date2))
            $date2 = strtotime($date2);
        return floor(abs($date1 - $date2) / 60 / 60 / 24);
    }

    public function actionAjaxValidarSaldo() {
        $txtFacturaEc = $_POST['txtFacturaEc'];
        $txtvalorFacturas = $_POST['txtvalorFacturas'];
        $this->valorFacturas = $txtvalorFacturas;
        $this->valorDigitado = 0;
        $this->efectivo = $txtFacturaEc;
        if (!$this->calcularValorRecibo()) {
            echo '1';
            Yii::app()->end();
        }
    }

    private function calcularValorRecibo($txtFacturaSeleccionada, $txtSaldoFacturaSeleccionada, $valorDigitado) {
        $session = new CHttpSession;
        $session->open();
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCe = $session['ConsignacionEfec'];
        } else {
            $datosCe = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        //echo '<pre>';
        //print_r($datosC);
        $valorE = 0;
        foreach ($datosE as $item) {
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                $valorE+=$item['valorEfectivo'];
            }
        }
        $valorCe = 0;
        foreach ($datosCe as $item) {
            //echo $txtFacturaSeleccionada.'=='.$item['facturaRecibo'].'</br>';
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                $valorCe+=$item['txtValorEc'];
            }
        }
        $valorC = 0;
        foreach ($datosC as $item) {
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                $valorC+=$item['txtValorCheque'];
            }
        }
        $valorCc = 0;
        foreach ($datosCc as $item) {
            // echo trim($txtFacturaSeleccionada).'=='.trim($item['facturaRecibo']).'</br>';
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                foreach ($item['detalle'] as $subItem) {
                    $valorCc+=$subItem['txtValorDCc'];
                }
            }
        }
        /* echo '<pre>';
          print_r($datosCc);
          echo '</pre>'; */
        $totalDigitado = $valorE + $valorCe + $valorC + $valorCc + $valorDigitado;
        // echo $valorCc.'Total cheque';
        //echo  $totalDigitado.' El valor sumado  </br>';
        //echo $txtSaldoFacturaSeleccionada.' Total </br>';
        //echo $valorDigitado.' Digitado </br>';        
        //echo $totalDigitado .'>'. $txtSaldoFacturaSeleccionada;
        return $totalDigitado <= $txtSaldoFacturaSeleccionada;
    }

    public function actionAjaxGetTotal() {
        $session = new CHttpSession;
        $session->open();
        $txtFacturaSeleccionada = $_POST['txtFacturaSeleccionada'];
        $abonoSeleccionado = $_POST['abonoSeleccionado'];
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCe = $session['ConsignacionEfec'];
        } else {
            $datosCe = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        /* echo '<pre>';
          print_r($datosE);
          exit(); */
        $valorE = 0;
        foreach ($datosE as $item) {
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                $valorE+=$item['valorEfectivo'];
            }
        }
        $valorCe = 0;
        foreach ($datosCe as $item) {
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                $valorCe+=$item['txtValorEc'];
            }
        }
        $valorC = 0;
        foreach ($datosC as $item) {
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                $valorC+=$item['txtValorCheque'];
            }
        }
        $valorCc = 0;
        foreach ($datosCc as $item) {
            if (trim($txtFacturaSeleccionada) == trim($item['facturaRecibo'])) {
                foreach ($item['detalle'] as $subItem) {
                    $valorCc+=$subItem['txtValorDCc'];
                }
            }
        }
        $totalDigitado = $valorE + $valorCe + $valorC + $valorCc;
        echo $abonoSeleccionado - $totalDigitado;
    }

    public function actionAjaxValidarFacturasAbonos() {
        $facturas = $_POST['facturas'];
        $valorAbono = $_POST['valorAbono'];
        //$session = new CHttpSession;
        //$session->open();
        $respAcomuladoRecibo = $this->getAcomuladoRecibos($facturas, $valorAbono);
        if (!$respAcomuladoRecibo) {
            echo 'false';
        } else {
            echo 'true';
        }
    }

    public function actionAjaxValidarProvisional() {
        $txtProvisional = $_POST['txtProvisional'];
        $txtZonaVentas = $_POST['txtZonaVentas'];
        $txtCodAsesor = $_POST['txtCodAsesor'];
        $provisional = Consultas::model()->getProvisional($txtProvisional, $txtCodAsesor);
        if ($provisional['Total'] > 0) {
            echo '1';
        } else {
            echo '0';
        }
    }

    private function getAcomuladoRecibos($facturas, $valorAbono) {
        $session = new CHttpSession;
        $session->open();
        $totalDigitadoFactura = 0;
        if ($session['Efectivo']) {
            $datosEfectivo = $session['Efectivo'];
        } else {
            $datosEfectivo = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosConsignacionEfectivo = $session['ConsignacionEfec'];
        } else {
            $datosConsignacionEfectivo = array();
        }
        if ($session['Cheque']) {
            $datosCheque = $session['Cheque'];
        } else {
            $datosCheque = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosConsignacionCheque = $session['ConsignacionCheque'];
        } else {
            $datosConsignacionCheque = array();
        }
        foreach ($datosEfectivo as $itemEfectivo) {
            if (trim($facturas) == trim($itemEfectivo['facturaRecibo'])) {
                $totalDigitadoFactura += $itemEfectivo['valorEfectivo'];
            }
        }
        foreach ($datosConsignacionEfectivo as $itemConsignacionEfectivo) {
            if (trim($facturas) == trim($itemConsignacionEfectivo ['facturaRecibo'])) {
                $totalDigitadoFactura += $itemConsignacionEfectivo ['txtValorEc'];
            }
        }
        foreach ($datosCheque as $itemCheque) {
            if (trim($facturas) == trim($itemCheque['facturaRecibo'])) {
                $totalDigitadoFactura += $itemCheque['txtValorCheque'];
            }
        }
        foreach ($datosConsignacionCheque as $itemConsignacionCheque) {
            if (trim($facturas) == trim($itemConsignacionCheque['facturaRecibo'])) {
                foreach ($itemConsignacionCheque['detalle'] as $subItemConsignacionCheque) {
                    $totalDigitadoFactura += $subItemConsignacionCheque['txtValorDCc'];
                }
            }
        }
        return $totalDigitadoFactura == $valorAbono;
    }

    public function actionAjaxValidarCodBanco() {
        if ($_POST) {
            $txtCodBanco = $_POST['txtCodBanco'];
            $txtBanco = $_POST['txtBanco'];
            $Criteria = new CDbCriteria();
            $Criteria->condition = "IdentificadorBanco='$txtCodBanco' AND CodBanco='$txtBanco'";
            $bancos = Bancos::model()->findAll($Criteria);
            if ($bancos) {
                foreach ($bancos as $item) {
                    $datos = array(
                        'IdentificadorBanco' => $item['IdentificadorBanco'],
                        'nombreBanco' => $item['Nombre'],
                    );
                }
                echo json_encode($datos);
            } else {
                echo 0;
            }
        }
    }

    public function actionAjaxDeleteAbonos() {
        $session = new CHttpSession;
        $session->open();
        $facturaAbono = $_POST['facturaAbono'];
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCe = $session['ConsignacionEfec'];
        } else {
            $datosCe = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        //foreach ($chd);
        $valorE = 0;
        foreach ($datosE as $clave => $item) {
            if (trim($facturaAbono) == trim($item['facturaRecibo'])) {
                $valorE+=$item['valorEfectivo'];
                $item['totalEfectivo']+=$item['valorEfectivo'];
                unset($datosE[$clave]);
            }
        }
        $valorCe = 0;
        foreach ($datosCe as $clave => $item) {
            if (trim($facturaAbono) == trim($item['facturaRecibo'])) {
                $valorCe+=$item['txtValorEc'];
                unset($datosCe[$clave]);
            }
        }
        $valorC = 0;
        foreach ($datosC as $clave => $item) {
            if (trim($facturaAbono) == trim($item['facturaRecibo'])) {
                $valorC+=$item['txtValorCheque'];
                unset($datosC[$clave]);
            }
            $posicionItem++;
        }
        $valorCc = 0;
        $posicionItem = 0;
        foreach ($datosCc as $clave => $item) {
            if (trim($facturaAbono) == trim($item['facturaRecibo'])) {
                foreach ($item['detalle'] as $subItem) {
                    $valorCc+=$subItem['txtValorDCc'];
                }
                unset($datosCc[$clave]);
            }
            $posicionItem++;
        }
        $session['Efectivo'] = $datosE;
        $session['ConsignacionEfec'] = $datosCe;
        $session['Cheque'] = $datosC;
        $session['ConsignacionCheque'] = $datosCc;
    }

    public function actionAjaxTablaEfectivo() {
        echo $this->renderPartial('_efectivo', array(), true);
    }

    public function actionAjaxTablaEfectivoConsignacion() {
        echo $this->renderPartial('_consignacionEfectivo', true);
    }

    public function actionAjaxTablaCheque() {
        echo $this->renderPartial('_cheque', true);
    }

    public function actionAjaxTablaChequeConsignacion() {
        echo $this->renderPartial('_consignacionCheque', true);
    }

    public function actionReciboCaja($zonaVentas = '', $cuentaCliente = '', $provisional = '') {
        $zonaVentas = trim($zonaVentas);
        $cuentaCliente = trim($cuentaCliente);
        $provisional = trim($provisional);
        $datosZonaVentas = ModelRecibos::model()->getDatosZonaVentas($zonaVentas);
        $datosCliente = ModelRecibos::model()->getDatosCliente($cuentaCliente);
        $facturasProvicional = ModelRecibos::getFacturasProvicional($zonaVentas, $cuentaCliente, $provisional);
        /* echo '<pre>';
          print_r($facturasProvicional);
          echo '<pre>';
          exit(); */
        $mPDF1 = Yii::app()->ePdf->mpdf();
        $mPDF1 = Yii::app()->ePdf->mpdf('utf-8', array(80, 130));
        $mPDF1->WriteHTML($this->renderPartial('_generarPdf', array(
                    'datosZonaVentas' => $datosZonaVentas,
                    'datosCliente' => $datosCliente,
                    'facturasProvicional' => $facturasProvicional,
                    'zonaVentas' => $zonaVentas,
                    'cuentaCliente' => $cuentaCliente,
                    'provisional' => $provisional
                        ), true));
        $mPDF1->Output();
    }

    public function actionAjaxValidarBanco() {
        if ($_POST) {
            $codBanco = $_POST['codbanco'];
            $verificarCodban = ModelRecibos::model()->getverificarBanco($codBanco);
            $verdadero = $verificarCodban['Bancos'];
            if ($verdadero == 1) {
                $Bancos = ModelRecibos::model()->getNombreBanaco($codBanco);
                $NombreBanco = $Bancos['Descripcion'];
                echo $NombreBanco;
            } else {
                echo $verdadero;
            }
        }
    }

    public function actionAjaxSetChequeDetalle() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ChequeDetalle']) {
            $datosDetalle = $session['ChequeDetalle'];
        } else {
            $datosDetalle = array();
        }
        //$facturaRecibo = $_POST['facturaRecibo'];
        $txtNumeroCheque = $_POST['txtNumeroCheque'];
        $txtBancoCheque = $_POST['txtBancoCheque'];
        $textoBancoCheque = $_POST['textoBancoCheque'];
        $txtCuentaCheque = $_POST['txtCuentaCheque'];
        $txtFechaCheque = $_POST['txtFechaCheque'];
        $txtValorCheque = $_POST['txtValorChequeSaldo'];
        $txtvalorFacturas = $_POST['txtvalorFacturas'];
        $txtGirado = $_POST['txtGirado'];
        $txtOtro = $_POST['txtOtro'];
        $vali = $this->validarExistenciaNumeroCheque($datosDetalle, $txtNumeroCheque, $txtBancoCheque);
        $verificarCodban = ModelRecibos::model()->getverificarBanco($txtBancoCheque);
        $verdadero = $verificarCodban['Bancos'];
        if ($verdadero == 0) {
            echo '2';
        } else if ($vali >= 1) {
            echo '1';
        } else {
            $datosItem = array(
                //'facturaRecibo' => $facturaRecibo,
                'txtNumeroCheque' => $txtNumeroCheque,
                'txtBancoCheque' => $txtBancoCheque,
                'textoBancoCheque' => $textoBancoCheque,
                'txtCuentaCheque' => $txtCuentaCheque,
                //'textoCuentaCheque' => $textoCuentaCheque,
                'txtFechaCheque' => $txtFechaCheque,
                'txtValorChequeSaldo' => $txtValorCheque,
                'txtValorTotalChequeSaldo' => $txtValorCheque,
                'txtGirado' => $txtGirado,
                'txtOtro' => $txtOtro
            );
            array_push($datosDetalle, $datosItem);
            $session['ChequeDetalle'] = $datosDetalle;
            //$option = "<option>Seleccione un numero cheque</option>";
            foreach ($datosDetalle as $numChe) {
                $option .='<option value="' . $numChe['txtNumeroCheque'] . '-' . $numChe['txtBancoCheque'] . '">' . $numChe['txtNumeroCheque'] . '</option>';
            }
            echo $option;
            //echo $this->renderPartial('_chequeDetail',true);
        }
    }

    public function actionAjaxSetChequeDetalleTabla() {
        echo $this->renderPartial('_chequeDetail');
    }

    /*
     * se setea el valor del efectivo
     * @return 1 ya hay un ragistro 
     */
    public function actionAjaxSetEfectivoDetallle() {
        $session = new CHttpSession;
        $session->open();
        try {
            if ($session['EfectivoDetalle']) {
                $datosDetalleEfectivo = $session['EfectivoDetalle'];
            } else {
                $datosDetalleEfectivo = array();
            }
            $facturaRecibo = $_POST['facturaRecibo'];
            $txtValorfectivo = str_replace(",", "", $_POST['txtValorEfectivo']);
            $datosEfectivo = array(
                //'facturarecibo' => $facturaRecibo,
                'ValorEfectivo' => $txtValorfectivo,
                'SaldoEfectivo' => $txtValorfectivo,
            );
            array_push($datosDetalleEfectivo, $datosEfectivo);
            $session['EfectivoDetalle'] = $datosDetalleEfectivo;
            /* echo '<pre>';
              print_r($datosDetalleEfectivo); */
            foreach ($datosDetalleEfectivo as $key => $ValEfectivo) {
                $valorEfectivo = str_replace(",", "", $ValEfectivo['ValorEfectivo']);
                $option .='<option value="' . $valorEfectivo . '-' . $key . '">' . $valorEfectivo . '</option>';
            }
            echo $option;
        } catch (Exeption $e) {
            echo "";
        }
    }

    /*
     * se carga el valor en el input de saldo
     * @return JSON
     */
    public function actionAjaxCargarDatosDelArrayEfectivo() {
        $session = new CHttpSession;
        $session->open();
        if ($session['EfectivoDetalle']) {
            $datosDetalleEfectivo = $session['EfectivoDetalle'];
        } else {
            $datosDetalleEfectivo = array();
        }
        if ($_POST) {
            $valoresEfectivo = explode('-', $_POST['valorefectivo']);
            foreach ($datosDetalleEfectivo as $itemDetalleEfectivo) {
                $valorEfectivo = str_replace(",", "", $itemDetalleEfectivo['ValorEfectivo']);
                if ($valorEfectivo == $valoresEfectivo[0]) {
                    echo json_encode($itemDetalleEfectivo);
                    break;
                }
            }
        }
    }

    public function actionAjaxSetEfectivoDetalleTabla() {
        echo $this->renderPartial('_EfectivoDetail');
    }

    public function validarExistenciaNumeroCheque($array, $numero, $banco) {
        $respuesta = 0;
        foreach ($array as $item) {
            if (($item['txtNumeroCheque'] == $numero) && ($item['txtBancoCheque'] == $banco)) {
                $respuesta = 1;
            }
        }
        return $respuesta;
    }

    public function actionAjaxCargarDatosDelArray() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ChequeDetalle']) {
            $datosDetalle = $session['ChequeDetalle'];
        } else {
            $datosDetalle = array();
        }
        if ($_POST) {
            $numeros = explode('-', $_POST['numeros']);
            foreach ($datosDetalle as $item) {
                if ($item['txtNumeroCheque'] == $numeros[0] && $item['txtBancoCheque'] == $numeros[1]) {
                    echo json_encode($item);
                    break;
                }
            }
        }
    }

    public function actionAjaxSetConsignacionEfectivoDetalle() {
        $codagencia = Yii::app()->user->_Agencia;
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionEfecDetalle']) {
            $datosConsignacion = $session['ConsignacionEfecDetalle'];
        } else {
            $datosConsignacion = array();
        }
        if ($_POST) {
            $txtFormaPag = $_POST['txtFormaPag'];
            $txtNumeroEc = $_POST['txtNumeroEc'];
            $txtBancoEc = $_POST['txtBancoEc'];
            $txtBanco = $_POST['txtBanco'];
            $txtCuenta = $_POST['txtCuenta'];
            $txtFechaEc = $_POST['txtFechaEc'];
            $txtValorEcSaldo = $_POST['txtValorEcSaldo'];
            $txtCodBancoEc = $_POST['txtCodBancoEc'];
            $vali = $this->validarExistenciaNumeroEfectivoConsignacion($datosConsignacion, $txtNumeroEc, $txtBancoEc);
            if ($vali >= 1) {
                echo '1';
            } else {
                $datosItem = array(
                    'txtFormaPag' => $txtFormaPag,
                    'txtNumeroEc' => $txtNumeroEc,
                    'txtBancoEc' => $txtBancoEc,
                    'txtBanco' => $txtBanco,
                    'txtCuenta' => $txtCuenta,
                    'txtFechaEc' => $txtFechaEc,
                    'txtValorEcSaldo' => $txtValorEcSaldo,
                    'txtCodBancoEc' => $txtCodBancoEc,
                    'txtValorTotalEcSaldo' => $txtValorEcSaldo
                );
                array_push($datosConsignacion, $datosItem);
                $session['ConsignacionEfecDetalle'] = $datosConsignacion;
                //$option = "<option>Seleccione un numero de consignacion</option>";
                foreach ($datosConsignacion as $numConsig) {
                    $formasPagoEfectivoConsig = Consultas::model()->getFormasPagoDescription($codagencia, $numConsig['txtFormaPag']);
                    $option .='<option value="' . $numConsig['txtNumeroEc'] . '-' . $numConsig['txtCodBancoEc'] . '">' . $numConsig['txtNumeroEc'] . '-' . $formasPagoEfectivoConsig['Descripcion'] . '</option>';
                }
                echo $option;
            }
        }
    }

    public function actionAjaxSetConsignacionEfectivoDetalleTabla() {
        echo $this->renderPartial('_consignacionefectivoDetail');
    }

    public function validarExistenciaNumeroEfectivoConsignacion($arrayEf, $numeroEf, $bancoEf) {
        $respuesta = 0;
        foreach ($arrayEf as $item) {
            if (($item['txtNumeroEc'] == $numeroEf) && ($item['txtBancoEc'] == $bancoEf)) {
                $respuesta = 1;
            }
        }
        return $respuesta;
    }

    public function actionAjaxCargarDatosDelArrayConsignacion() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionEfecDetalle']) {
            $datosConsignacion = $session['ConsignacionEfecDetalle'];
        } else {
            $datosConsignacion = array();
        }
        if ($_POST) {
            $numeroconsignacion = explode('-', $_POST['numeroconsignacion']);
            // $factura = $_POST['factura'];
            foreach ($datosConsignacion as $item) {
                if ($item['txtNumeroEc'] == $numeroconsignacion[0] && $item['txtCodBancoEc'] == $numeroconsignacion[1]) {

                    echo json_encode($item);
                    break;
                }
            }
        }
    }

    public function actionAjaxSetConsignacionChequeDetalle() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        } else {
            $datosConsignacionChequeDta = array();
        }
        $txtNumeroECc = $_POST['txtNumeroECc'];
        $txtBancoECc = $_POST['txtBancoECc'];
        $txtNombreBancoECc = $_POST['txtNombreBancoECc'];
        $txtCuentaECc = $_POST['txtCuentaECc'];
        $txtCodBancoECc = $_POST['txtCodBancoECc'];
        $txtFechaECc = $_POST['txtFechaECc'];
        //$txtFacturaChc = $_POST['txtFacturaChc'];
        $txtNumeroDCc = $_POST['txtNumeroDCc'];
        $txtCodBancoDCc = $_POST['txtCodBancoDCc'];
        $MsgBancoCc = $_POST['MsgBancoCc'];
        $txtCuentaDCc = $_POST['txtCuentaDCc'];
        $txtValorDCcSaldo = $_POST['txtValorDCcSaldo'];
        $txtFechaDCc = $_POST['txtFechaDCc'];
        $vali = $this->validarExistenciaNumeroChequeConsig($datosConsignacionChequeDta, $txtNumeroDCc, $txtCodBancoDCc, $txtCodBancoECc);
        if ($vali >= 1) {
            echo '1';
        } else {
            $arrayEncabezado = array(
                'txtNumeroECc' => $txtNumeroECc,
                'txtBancoECc' => $txtBancoECc,
                'txtNombreBancoECc' => $txtNombreBancoECc,
                'txtCuentaECc' => $txtCuentaECc,
                'txtCodBancoECc' => $txtCodBancoECc,
                'txtFechaECc' => $txtFechaECc,
                    //'txtFacturaChc' => $txtFacturaChc,
            );
            $arrayDetalle = array(
                'txtNumeroDCc' => $txtNumeroDCc,
                'txtCodBancoDCc' => $txtCodBancoDCc,
                'MsgBancoCc' => $MsgBancoCc,
                'txtCuentaDCc' => $txtCuentaDCc,
                'txtValorDCcSaldo' => $txtValorDCcSaldo,
                'txtValorTotalDCcSaldo' => $txtValorDCcSaldo,
                'txtFechaDCc' => $txtFechaDCc,
                    //'txtFacturaChc' => $txtFacturaChc,
            );
            $existHeader = false;
            $contHeader = 0;
            foreach ($datosConsignacionChequeDta as $itemDetalle) {
                if ($itemDetalle['txtNumeroECc'] == $txtNumeroECc && $itemDetalle['txtCodBancoECc'] == $txtCodBancoECc) {
                    $existHeader = true;
                    array_push($datosConsignacionChequeDta[$contHeader]['detalle'], $arrayDetalle);
                    break;
                }
                $contHeader++;
            }
            /* echo '<pre>';
              print_r($datosConsignacionChequeDta); */
            if (!$existHeader) {
                $arrayEncabezado['detalle'][0] = $arrayDetalle;
                array_push($datosConsignacionChequeDta, $arrayEncabezado);
            }
            $session['ConsignacionChequeDetalle'] = $datosConsignacionChequeDta;
            foreach ($datosConsignacionChequeDta as $numCheConsig) {
                $option .='<option value="' . $numCheConsig['txtNumeroECc'] . '-' . $numCheConsig['txtCodBancoECc'] . '">' . $numCheConsig['txtNumeroECc'] . '</option>';
            }
            echo $option;
        }
    }

    public function actionAjaxSetConsignacionChequeDetalleTabla() {
        echo $this->renderPartial('_consignacionchequeDetail');
    }

    public function validarExistenciaNumeroChequeConsig($array, $txtNumeroDCc, $txtCodBancoDCc, $txtCodBancoECc) {
        $respuesta = 0;
        foreach ($array as $item) {
            foreach ($item['detalle'] as $itemdetalle)
                if (($itemdetalle['txtNumeroDCc'] == $txtNumeroDCc) && ($itemdetalle['txtCodBancoDCc'] == $txtCodBancoDCc) && ($item['txtCodBancoECc'] == $txtCodBancoECc)) {
                    $respuesta = 1;
                }
        }
        return $respuesta;
    }

    public function actionAjaxCargarDatosDelArrayCheConsignacion() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        } else {
            $datosConsignacionChequeDta = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosChc = $session['ConsignacionCheque'];
        } else {
            $datosChc = array();
        }
        if ($_POST) {
            $numerosChCosignacion = explode('-', $_POST['numerosChCosignacion']);
            //$factura = $_POST['factura'];
            $ValorSaldoConsigChc = 0;
            foreach ($datosChc as $itemchc) {
                if (/* $itemchc['facturaRecibo'] == $factura && */ $itemchc['txtNumeroECc'] == $numerosChCosignacion[0]) {
                    $ValorSaldoConsigChc = $itemchc['txtValorDCc'];
                }
            }
            foreach ($datosConsignacionChequeDta as $item) {
                if ($item['txtNumeroECc'] == $numerosChCosignacion[0] && $item['txtCodBancoECc'] == $numerosChCosignacion[1]) {
                    $item['txtValorDCcSaldo'] = $item['txtValorDCcSaldo'] - $ValorSaldoConsigChc;
                    echo json_encode($item);
                    break;
                }
            }
        }
    }

    public function actionAjaxCargarDatosDelArrayDetailCheConsignacion() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        } else {
            $datosConsignacionChequeDta = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosChc = $session['ConsignacionCheque'];
        } else {
            $datosChc = array();
        }
        if ($_POST) {
            $numeroDetalle = explode('-', $_POST['numeroDetalle']);
            $factura = $_POST['factura'];
            /* if (empty($item['txtFacturaChc'])) {
              $datosConsignacionChequeDta[0]['txtFacturaChc'] = $factura;
              } */
            /* echo '<pre>';
              print_r($datosChc); */
            foreach ($datosChc as $item) {
                foreach ($item['detalle'] as $itemDetalles) {
                    if ($itemDetalles['txtNumeroDCc'] == $numeroDetalle[0] /* && $item['txtFacturaChc'] == $factura */) {
                        $ValorSaldoCheque = $itemDetalles['txtValorDCcSaldoCheque'];
                    }
                }
            }
            /* echo '<pre>';
              print_r($datosConsignacionChequeDta); */
            foreach ($datosConsignacionChequeDta as $item) {
                foreach ($item['detalle'] as $itemDetail) {
                    if ($itemDetail['txtNumeroDCc'] == $numeroDetalle[0] && $itemDetail['txtCodBancoDCc'] == $numeroDetalle[1] && $item['txtFacturaChc'] == $factura) {
                        $itemDetail['txtValorDCcSaldo']-=$ValorSaldoCheque;
                        echo json_encode($itemDetail);
                        break;
                    }
                }
            }
        }
    }

    public function actionAjaxDeleteChModal() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Cheque']) {
            $datosFacturaCheque = $session['Cheque'];
        } else {
            $datosFacturaCheque = array();
        }
        if ($session['ChequeDetalle']) {
            $datosDetalleCheque = $session['ChequeDetalle'];
        } else {
            $datosDetalleCheque = array();
        }
        if ($_POST) {
            $numero = $_POST['numero'];
            $codbanco = $_POST['codbanco'];
            foreach ($datosFacturaCheque as $itemFacturaCheque) {
                $txtNumCh = explode('-', $itemFacturaCheque['txtNumeroCheque']);
                if ($txtNumCh[0] == $numero && $itemFacturaCheque['txtBancoCheque'] == $codbanco) {
                    echo '1';
                    return;
                }
            }
            $arrayAux = array();
            foreach ($datosDetalleCheque as $itemDetalleCheque) {
                if ($itemDetalleCheque['txtNumeroCheque'] != $numero && $itemDetalleCheque['txtBancoCheque'] != $codbanco) {
                    array_push($arrayAux, $itemDetalleCheque);
                }
            }
            $session['ChequeDetalle'] = $arrayAux;
            //$option = "<option>Seleccione un numero cheque</option>";
            foreach ($arrayAux as $numChe) {
                $option .='<option value="' . $numChe['txtNumeroCheque'] . '-' . $numChe['txtBancoCheque'] . '">' . $numChe['txtNumeroCheque'] . '</option>';
            }
            echo $option;
            //echo $this->renderPartial('_chequeDetail');
        }
    }

    public function actionAjaxDeleteEfecModal() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Efectivo']) {
            $datosFacturasEfectivo = $session['Efectivo'];
        } else {
            $datosFacturasEfectivo = array();
        }
        if ($session['EfectivoDetalle']) {
            $datosDetalleFacturas = $session['EfectivoDetalle'];
        } else {
            $datosDetalleFacturas = array();
        }
        $valorEfectivo = $_POST['txtValorEfectivo'];
        $EfectivoExiste = count($datosFacturasEfectivo);
        if ($EfectivoExiste > 0) {
            echo '1';
            die();
        }
        $arrayAux = array();
        foreach ($datosDetalleFacturas as $key => $itemDetalleFacturas) {
            $ValEfect = $itemDetalleFacturas['ValorEfectivo'] . '-' . $key;
            if ($ValEfect != $valorEfectivo) {
                array_push($arrayAux, $itemDetalleFacturas);
            }
        }
        //echo '<pre>';
        //print_r($arrayAux);
        $session['EfectivoDetalle'] = $arrayAux;
        //$option = "<option>Seleccione un valor efectivo</option>";
        foreach ($arrayAux as $key => $ValEfectivo) {
            $Nuevovalor = str_replace(",", "", $ValEfectivo['ValorEfectivo']);
            $option .='<option value="' . $Nuevovalor . '-' . $key . '">' . $Nuevovalor . '</option>';
        }
        echo $option;
    }

    public function actionAjaxDeleteConsigEfectivoModal() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionEfec']) {
            $datosFacturaConsigEfectivo = $session['ConsignacionEfec'];
        } else {
            $datosFacturaConsigEfectivo = array();
        }
        if ($session['ConsignacionEfecDetalle']) {
            $datosConsignacionEfectDetalle = $session['ConsignacionEfecDetalle'];
        } else {
            $datosConsignacionEfectDetalle = array();
        }
        if ($_POST) {
            $numero = $_POST['numero'];
            $codbanco = $_POST['codbanco'];
            foreach ($datosFacturaConsigEfectivo as $itemFacturaConsigEfectivo) {
                $txtNumCh = explode('-', $itemFacturaConsigEfectivo['txtNumeroEc']);
                if ($txtNumCh[0] == $numero && $txtNumCh[1] == $codbanco) {
                    echo '1';
                    return;
                }
            }
            $arrayAux = array();
            foreach ($datosConsignacionEfectDetalle as $itemConsignacionEfectDetalle) {
                if ($itemConsignacionEfectDetalle['txtNumeroEc'] != $numero && $itemConsignacionEfectDetalle['txtCodBancoEc'] != $codbanco) {
                    array_push($arrayAux, $itemConsignacionEfectDetalle);
                }
            }
            $session['ConsignacionEfecDetalle'] = $arrayAux;
            echo $this->renderPartial('_consignacionefectivoDetail');
        }
    }

    public function actionAjaxDeleteChequeConsigModal() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionCheque']) {
            $datos = $session['ConsignacionCheque'];
        } else {
            $datos = array();
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        } else {
            $datosConsignacionChequeDta = array();
        }
        if ($_POST) {
            $numero = $_POST['numero'];
            $codbanco = $_POST['codbanco'];
            $consiagnacion = $_POST['consignacion'];
            foreach ($datos as $item) {
                foreach ($item['detalle'] as $subitem) {
                    $txtNumCh = explode('-', $subitem['txtNumeroDCc']);
                    if ($txtNumCh[0] == $numero && $txtNumCh[1] == $codbanco && $item['txtNumeroECc'] == $consiagnacion) {
                        echo '1';
                        return;
                    }
                }
            }
            $arrayAux = array();
//            $arrayAuxSub = array();
            foreach ($datosConsignacionChequeDta as $item) {
                if ($item['txtNumeroECc'] == $consiagnacion) {
                    $arrayAuxSub = $item['detalle'];
                    $item['detalle'] = array();
                    foreach ($arrayAuxSub as $subitem) {
                        if ($subitem['txtNumeroDCc'] != $numero && $subitem['txtCodBancoDCc'] != $codbanco) {
                            array_push($item['detalle'], $subitem);
                        }
                    }
                    array_push($arrayAux, $item);
                } else {
                    array_push($arrayAux, $item);
                }
            }
            $session['ConsignacionChequeDetalle'] = $arrayAux;
            echo $this->renderPartial('_consignacionchequeDetail');
        }
    }

    public function actionAjaxDeleteConsignacion() {
        $session = new CHttpSession;
        $session->open();
        if ($session['ConsignacionCheque']) {
            $datosChequeConsig = $session['ConsignacionCheque'];
        } else {
            $datosChequeConsig = array();
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        } else {
            $datosConsignacionChequeDta = array();
        }
        if ($_POST) {
            $numero = $_POST['numeroconsignacion'];
            $codbanco = $_POST['codbancoconsignacion'];
            foreach ($datosChequeConsig as $itemChequeConsig) {
                $txtNumeroECc = explode('-', $itemChequeConsig['txtNumeroECc']);
                if ($txtNumeroECc[0] == $numero && $itemChequeConsig['txtCodBancoECc'] == $codbanco) {
                    echo '1';
                    return;
                }
            }
            $arrayAux = array();
            foreach ($datosConsignacionChequeDta as $itemConsignacionChequeDta) {
                if ($itemConsignacionChequeDta['txtNumeroECc'] != $numero && $itemConsignacionChequeDta['txtCodBancoECc'] != $codbanco) {
                    array_push($arrayAux, $itemConsignacionChequeDta);
                }
            }
            $session['ConsignacionChequeDetalle'] = $arrayAux;
            echo $this->renderPartial('_consignacionefectivoDetail');
        }
    }

    public function actionAjaxCalcularEfectivoAbonoEliminado() {
        $session = new CHttpSession;
        $session->open();
        try {
            $facturaAbono = $_POST['facturaAbono'];
            if ($session['Efectivo']) {
                $datosEfectivo = $session['Efectivo'];
            } else {
                $datosEfectivo = array();
            }
            if ($session['EfectivoDetalle']) {
                $datosDetalleEfectivo = $session['EfectivoDetalle'];
            } else {
                $datosDetalleEfectivo = array();
            }
            // print_r($datos);
            //print_r($datosDetalleEfectivo);
            $arrayAuxiEfectivo = array();
            foreach ($datosEfectivo as $itemEfectivo) {
                if (trim($facturaAbono) === trim($itemEfectivo['facturaRecibo'])) {
                    $totalEfectivo = explode('-', $itemEfectivo['totalEfectivo']);
                    $key = $totalEfectivo[1];
                    $saldoEfectivo = $datosDetalleEfectivo[$key]['SaldoEfectivo'] + $itemEfectivo['valorEfectivo'];
                    $datosDetalleEfectivo[$key]['SaldoEfectivo'] = $saldoEfectivo;
                    /* foreach ($datosDetalleEfectivo as $key => $itemEfecdt) {
                      echo $key;
                      $saldoEfectivo = $itemEfecdt['SaldoEfectivo'] + $item['valorEfectivo'];
                      $datosDetalleEfectivo[$i]['SaldoEfectivo'] = $saldoEfectivo;
                      } */
                    //array_push($arrayAuxiDtl, $itemEfecdt);   
                } else {
                    array_push($arrayAuxiEfectivo, $itemEfectivo);
                }
            }
            //print_r($datosDetalleEfectivo);
            $session['EfectivoDetalle'] = $datosDetalleEfectivo;
            $session['Efectivo'] = $arrayAuxiEfectivo;
            echo $this->renderPartial('_efectivo', array(), true);
        } catch (Exeption $e) {
            echo "Error: " . $e;
        }
    }

    public function actionAjaxCalcularChAbonoEliminado($numberDeletedBill) {
        $session = new CHttpSession;
        $session->open();
        try {
            if ($session['Cheque']) {
                $datosCheque = $session['Cheque'];
            } else {
                $datosCheque = array();
            }
            if ($session['ChequeDetalle']) {
                $datosChequesDetalle = $session['ChequeDetalle'];
            } else {
                $datosChequesDetalle = array();
            }
            $arryaAuxiliarCheques = array();
            $cont = 0;
            foreach ($datosCheque as $itemCheque) {
                if (trim($itemCheque['facturaRecibo']) == trim($numberDeletedBill)) {
                    foreach ($datosChequesDetalle as $itemChequesDetalle) {
                        $numeroChequeDetalle = $itemChequesDetalle['txtNumeroCheque'] . '-' . $itemChequesDetalle['txtBancoCheque'];
                        if ($numeroChequeDetalle == $itemCheque['txtNumeroCheque']) {
                            $valorChequeSaldo = $itemChequesDetalle['txtValorChequeSaldo'] + $itemCheque['txtValorCheque'];
                            $datosChequesDetalle[$cont]['txtValorChequeSaldo'] = $valorChequeSaldo;
                            $cont++;
                        }
                    }
                } else {
                    array_push($arryaAuxiliarCheques, $itemCheque);
                }
            }
            $session['ChequeDetalle'] = $datosChequesDetalle;
            $session['Cheque'] = $arryaAuxiliarCheques;
            echo $this->renderPartial('_cheque', true);
        } catch (Exeption $e) {
            echo "Error: " . $e;
        }
    }

    public function actionAjaxCalcularEfecConsignaAbonoEliminado($numberDeletedBill) {
        $session = new CHttpSession;
        $session->open();
        try {
            if ($session['ConsignacionEfec']) {
                $datosEfectivoConsig = $session['ConsignacionEfec'];
            } else {
                $datosEfectivoConsig = array();
            }
            if ($session['ConsignacionEfecDetalle']) {
                $datosEfectivoConsigDetalle = $session['ConsignacionEfecDetalle'];
            } else {
                $datosEfectivoConsigDetalle = array();
            }
            $arrayEfecConsigancion = array();
            $cont = 0;
            foreach ($datosEfectivoConsig as $itemEfectivoConsig) {
                if (trim($itemEfectivoConsig['facturaRecibo']) == trim($numberDeletedBill)) {
                    foreach ($datosEfectivoConsigDetalle as $itemEfectivoConsigDetalle) {
                        $numerodetalle = $itemEfectivoConsigDetalle['txtNumeroEc'] . '-' . $itemEfectivoConsigDetalle['txtCodBancoEc'];
                        if ($numerodetalle == $itemEfectivoConsig['txtNumeroEc']) {
                            $saldoEfecConsignacion = $itemEfectivoConsigDetalle['txtValorEcSaldo'] + $itemEfectivoConsig['txtValorEc'];
                            $datosEfectivoConsigDetalle[$cont]['txtValorEcSaldo'] = $saldoEfecConsignacion;
                            $cont++;
                        }
                    }
                } else {
                    array_push($arrayEfecConsigancion, $itemEfectivoConsig);
                }
            }
            $session['ConsignacionEfecDetalle'] = $datosEfectivoConsigDetalle;
            $session['ConsignacionEfec'] = $arrayEfecConsigancion;
            /* echo '<pre>';
              print_r($session['ConsignacionEfecDetalle']); */
            echo $saldoEfecConsignacion;
        } catch (Exeption $e) {
            
        }
    }

    public function actionAjaxCalcularChequeConsignacionAbonoEliminado($numberDeletedBill) {
        $session = new CHttpSession;
        $session->open();
        try {
            if ($session['ConsignacionCheque']) {
                $datosChequeConsignacion = $session['ConsignacionCheque'];
            } else {
                $datosChequeConsignacion = array();
            }
            if ($session['ConsignacionChequeDetalle']) {
                $datosChequeConsignacionDetalle = $session['ConsignacionChequeDetalle'];
            } else {
                $datosChequeConsignacionDetalle = array();
            }
            $arrayChequeConsigancion = array();
            $contChConsig = 0;
            foreach ($datosChequeConsignacion as $itemChequeConsignacion) {
                if (trim($itemChequeConsignacion['facturaRecibo']) == trim($numberDeletedBill)) {
                    foreach ($datosChequeConsignacionDetalle as $itemChequeConsignacionDetalle) {
                        $numerodetalle = $itemChequeConsignacionDetalle['txtNumeroEc'] . '-' . $itemChequeConsignacionDetalle['txtCodBancoEc'];
                        $saldoChequeConsignacion = $itemChequeConsignacionDetalle['detalle'][0]['txtValorDCcSaldo'] = $itemChequeConsignacion['detalle'][0]['txtValorDCc'];
                        $itemCosigCheque['detalle'][0][$cont]['txtValorDCcSaldo'] = $saldoChequeConsignacion;
                        $contChConsig++;
                    }
                } else {
                    array_push($arrayChequeConsigancion, $itemChequeConsignacion);
                }
            }
            $session['ConsignacionChequeDetalle'] = $arrayChequeConsigancion;
            /* echo '<pre>';
              print_r($session['ConsignacionChequeDetalle']); */
            echo $saldoChequeConsignacion;
        } catch (Exeption $e) {
            
        }
    }

    public function actionAjaxSumarFormasPago() {
        $session = new CHttpSession;
        $session->open();
        if ($session['EfectivoDetalle']) {
            $datosE = $session['EfectivoDetalle'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfecDetalle']) {
            $datosCe = $session['ConsignacionEfecDetalle'];
        } else {
            $datosCe = array();
        }
        if ($session['ChequeDetalle']) {
            $datosC = $session['ChequeDetalle'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosCc = $session['ConsignacionChequeDetalle'];
        } else {
            $datosCc = array();
        }
        if ($session['SaldoFormasPago']) {
            $SaldoFormasPago = $session['SaldoFormasPago'];
        } else {
            $SaldoFormasPago = array();
        }
        /* echo '<pre>';
          print_r($datosCc);
          die(); */
        $valorE = 0;
        $saldoE = 0;
        foreach ($datosE as $item) {
            $valorE+=$item['ValorEfectivo'];
            $saldoE+=$item['SaldoEfectivo'];
        }
        $valorCe = 0;
        $saldoCe = 0;
        foreach ($datosCe as $item) {
            $valorCe+=$item['txtValorTotalEcSaldo'];
            $saldoCe+=$item['txtValorEcSaldo'];
        }
        $valorC = 0;
        $saldoC = 0;
        foreach ($datosC as $item) {
            $valorC+=$item['txtValorTotalChequeSaldo'];
            $saldoC+=$item['txtValorChequeSaldo'];
        }
        $valorCc = 0;
        $saldoCc = 0;
        foreach ($datosCc as $item) {
            foreach ($item['detalle'] as $subItem) {
                $valorCc+=$subItem['txtValorTotalDCcSaldo'];
                $saldoCc+=$subItem['txtValorDCcSaldo'];
            }
        }
        $totalDigitado = $valorE + $valorCe + $valorC + $valorCc;
        $saldoFormasPago = $saldoE + $saldoC + $saldoCe + $saldoCc;
        $totalDigitadoFormateado = number_format($totalDigitado, '2', ',', '.');
        $saldoFormasPagoFormat = number_format($saldoFormasPago, '2', ',', '.');
        $session['SaldoFormasPago'] = $totalDigitado;
        $arrayvalor = array(
            'totalDigitadoFormateado' => $totalDigitadoFormateado,
            'totalDigitado' => $totalDigitado,
            'saldoFormasPago' => $saldoFormasPago,
            'saldoFormasPagoFormat' => $saldoFormasPagoFormat
        );
        echo json_encode($arrayvalor);
    }

    public function actionAjaxTotalFormasPago() {
        $session = new CHttpSession;
        $session->open();
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCE = $session['ConsignacionEfec'];
        } else {
            $datosCE = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        if ($session['TotalFormasPago']) {
            $TotalFomasPago = $session['TotalFormasPago'];
        } else {
            $TotalFomasPago = array();
        }
        $ArrayUnica = array();
        foreach ($datosE as $itemEfectivo) {
            $json = array(
                'FormaPago' => 'Efectivo',
                'Valor' => $itemEfectivo['valorEfectivo'],
                'Factura' => $itemEfectivo['facturaRecibo']
            );
            array_push($ArrayUnica, $json);
        }
        foreach ($datosCE as $itemEfectivoConsignacion) {
            $json = array(
                'FormaPago' => 'EfectivoConsignacion',
                'Valor' => $itemEfectivoConsignacion['txtValorEc'],
                'Factura' => $itemEfectivoConsignacion['facturaRecibo']
            );
            array_push($ArrayUnica, $json);
        }
        foreach ($datosC as $itemCheque) {
            $json = array(
                'FormaPago' => 'Cheque',
                'Valor' => $itemCheque['txtValorCheque'],
                'Factura' => $itemCheque['facturaRecibo']
            );
            array_push($ArrayUnica, $json);
        }
        foreach ($datosCc as $itemChequeConsignacion) {
            foreach ($itemChequeConsignacion['detalle'] as $ItemDetalleConsignacion) {
                $json = array(
                    'FormaPago' => 'ChequeConsignacion',
                    'Valor' => $ItemDetalleConsignacion['txtValorDCc'],
                    'Factura' => $itemChequeConsignacion['facturaRecibo']
                );
                array_push($ArrayUnica, $json);
            }
        }
        $session['TotalFormasPago'] = $ArrayUnica;
        $TotalFomasPago = $session['TotalFormasPago'];
        $this->renderPartial('_totalformasdepago', array('datos' => $TotalFomasPago));
    }

    public function actionAjaxSetSaldoFormasPagoResta() {
        $session = new CHttpSession;
        $session->open();
        $facturarecibo = $_POST['facturaRecibo'];
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCE = $session['ConsignacionEfec'];
        } else {
            $datosCE = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        $SaldoaRestar = $session['SaldoFormasPago'];
        $SaldoActual = 0;
        foreach ($datosE as $itemEfectivo) {
            if ($itemEfectivo['facturaRecibo'] == $facturarecibo) {
                $SaldoActual = $SaldoaRestar -= $itemEfectivo['valorEfectivo'];
            }
        }
        foreach ($datosCE as $itemEfectivoConsignacion) {
            if ($itemEfectivoConsignacion['facturaRecibo'] == $facturarecibo) {
                $SaldoActual = $SaldoaRestar -= $itemEfectivoConsignacion['txtValorEc'];
            }
        }
        foreach ($datosC as $itemCheque) {
            if ($itemCheque['facturaRecibo'] == $facturarecibo) {
                $SaldoActual = $SaldoaRestar -= $itemCheque['txtValorCheque'];
            }
        }
        foreach ($datosCc as $itemChequeConsignacion) {
            foreach ($itemChequeConsignacion['detalle'] as $itemDetalleCc) {
                if ($itemChequeConsignacion['facturaRecibo'] == $facturarecibo) {
                    $SaldoActual = $SaldoaRestar -= $itemDetalleCc['txtValorDCc'];
                }
            }
        }
        $session['SaldoFormasPago'] = $SaldoActual;
        echo number_format($SaldoActual, '2', '.', ',');
    }

    public function actionAjaxSetSaldoFormasPagoRestaNew() {
        $session = new CHttpSession;
        $session->open();
        $facturarecibo = $_POST['facturaRecibo'];
        $numeroFormaPago = $_POST['numeroFormaPago'];
        if ($session['Efectivo']) {
            $datosE = $session['Efectivo'];
        } else {
            $datosE = array();
        }
        if ($session['ConsignacionEfec']) {
            $datosCE = $session['ConsignacionEfec'];
        } else {
            $datosCE = array();
        }
        if ($session['Cheque']) {
            $datosC = $session['Cheque'];
        } else {
            $datosC = array();
        }
        if ($session['ConsignacionCheque']) {
            $datosCc = $session['ConsignacionCheque'];
        } else {
            $datosCc = array();
        }
        $SaldoaRestar = $session['SaldoFormasPago'];
        $SaldoActual = 0;
        foreach ($datosE as $itemEfectivo) {
            if ($itemEfectivo['facturaRecibo'] == $facturarecibo && $numeroFormaPago == "Efectivo") {
                $SaldoActual = $SaldoaRestar -= $itemEfectivo['valorEfectivo'];
            }
        }
        foreach ($datosCE as $itemEfectivoConsignacion) {
            if ($itemEfectivoConsignacion['facturaRecibo'] == $facturarecibo && $numeroFormaPago == $itemEfectivoConsignacion['txtNumeroEc']) {
                $SaldoActual = $SaldoaRestar -= $itemEfectivoConsignacion['txtValorEc'];
            }
        }
        foreach ($datosC as $itemCheque) {
            if ($itemCheque['facturaRecibo'] == $facturarecibo && $numeroFormaPago == $itemCheque['txtNumeroCheque']) {
                $SaldoActual = $SaldoaRestar -= $itemCheque['txtValorCheque'];
            }
        }
        foreach ($datosCc as $itemChequeConsignacion) {
            foreach ($itemChequeConsignacion['detalle'] as $itemDetalleCc) {
                if ($itemChequeConsignacion['facturaRecibo'] == $facturarecibo && $numeroFormaPago == $itemDetalleCc['txtNumeroDCc']) {
                    $SaldoActual = $SaldoaRestar -= $itemDetalleCc['txtValorDCc'];
                }
            }
        }
        $session['SaldoFormasPago'] = $SaldoActual;
        echo number_format($SaldoActual, '2', '.', ',');
    }

    public function actionAjaxSetSaldoFormasPagoSumaEfectivo() {
        $session = new CHttpSession;
        $session->open();
        $facturaAbono = $_POST['facturaAbono'];
        if ($session['Efectivo']) {
            $datos = $session['Efectivo'];
        } else {
            $datos = array();
        }
        if ($session['EfectivoDetalle']) {
            $datosDetalleEfectivo = $session['EfectivoDetalle'];
        } else {
            $datosDetalleEfectivo = array();
        }
        /* echo 'Efectivo<br />';
          print_r($session['EfectivoDetalle']);
          echo '<p>Datos</p><br />';
         */
        $SaldoaSumar = $session['SaldoFormasPago'];
        $SaldoActual = 0;
        $arrayAuxiDtl = array();
        foreach ($datos as $item) {
            if (trim($facturaAbono) == trim($item['facturaRecibo'])) {
                //foreach ($datosDetalleEfectivo as $key => $itemEfecdt) {
                $SaldoActual = $SaldoaSumar += $item['valorEfectivo'];
                //}
            }
        }
        /* echo '<p>Saldo Actual</p><br />';
          print_r($SaldoActual); */
        if ($SaldoActual > 0) {
            $session['SaldoFormasPago'] = $SaldoActual;
            echo number_format($SaldoActual, '2', '.', ',');
        }
    }

    public function actionAjaxSetSaldoFormasPagoSumaCheque() {
        $session = new CHttpSession;
        $session->open();
        $facturaAbono = $_POST['facturaAbono'];
        if ($session['Cheque']) {
            $datosCheque = $session['Cheque'];
        } else {
            $datosCheque = array();
        }
        if ($session['ChequeDetalle']) {
            $chd = $session['ChequeDetalle'];
        } else {
            $chd = array();
        }
        $SaldoaSumar = $session['SaldoFormasPago'];
        $SaldoActual = 0;
        foreach ($datosCheque as $itemDc) {
            if (trim($itemDc['facturaRecibo']) == trim($facturaAbono)) {
                $SaldoActual = $SaldoaSumar += $itemDc['txtValorCheque'];
            }
        }
        if ($SaldoActual > 0) {
            $session['SaldoFormasPago'] = $SaldoActual;
            echo number_format($SaldoActual, '2', '.', ',');
        }
    }

    public function actionAjaxSetSaldoFormasPagoSumaEfectivoConsignacion() {
        $session = new CHttpSession;
        $session->open();
        $facturaAbono = $_POST['facturaAbono'];
        if ($session['ConsignacionEfec']) {
            $datosEfectivoConsig = $session['ConsignacionEfec'];
        } else {
            $datosEfectivoConsig = array();
        }
        if ($session['ConsignacionEfecDetalle']) {
            $EfecConsignacion = $session['ConsignacionEfecDetalle'];
        } else {
            $EfecConsignacion = array();
        }
        $SaldoaSumar = $session['SaldoFormasPago'];
        $SaldoActual = 0;
        foreach ($datosEfectivoConsig as $itemDc) {
            if (trim($itemDc['facturaRecibo']) == trim($facturaAbono)) {
                $SaldoActual = $SaldoaSumar += $itemDc['txtValorEc'];
            }
        }
        if ($SaldoActual > 0) {
            $session['SaldoFormasPago'] = $SaldoActual;
            echo number_format($SaldoActual, '2', '.', ',');
        }
    }

    public function actionAjaxSetSaldoFormasPagoSumaChequeConsignacion() {
        $session = new CHttpSession;
        $session->open();
        $facturaAbono = $_POST['facturaAbono'];
        if ($session['ConsignacionCheque']) {
            $datosChequeConsignacion = $session['ConsignacionCheque'];
        } else {
            $datosChequeConsignacion = array();
        }
        if ($session['ConsignacionChequeDetalle']) {
            $ChdConsignacionDetalle = $session['ConsignacionChequeDetalle'];
        } else {
            $ChdConsignacionDetalle = array();
        }
        $SaldoaSumar = $session['SaldoFormasPago'];
        $SaldoActual = 0;
        foreach ($datosChequeConsignacion as $itemDc) {
            foreach ($itemDc['detalle'] as $itemCosigChequeDcc) {
                if (trim($itemDc['facturaRecibo']) == trim($facturaAbono)) {
                    $SaldoActual = $SaldoaSumar+=$itemCosigChequeDcc['txtValorDCc'];
                }
            }
        }
        if ($SaldoActual > 0) {
            $session['SaldoFormasPago'] = $SaldoActual;
            echo number_format($SaldoActual, '2', '.', ',');
        }
    }

// Metodo que elimina la factura 
    public function actionAjaxDeleteBillAll() {
        $session = new CHttpSession;
        $session->open();
        // variable que trae el numero de la factura eliminada
        $numberDeletedBill = trim($_POST['numberDeletedBill']);
        // Campuramos los efectivos agregados 
        if ($session['Efectivo']) {
            $datosFacturaEfectivo = $session['Efectivo'];
        } else {
            $datosFacturaEfectivo = array();
        }
        if ($session['EfectivoDetalle']) {
            $datosDetalleEfectivo = $session['EfectivoDetalle'];
        } else {
            $datosDetalleEfectivo = array();
        }
        $arrayAuxEfectivo = array();
        foreach ($datosFacturaEfectivo as $itemFacturaEfectivo) {
            if ($itemFacturaEfectivo['facturaRecibo'] != trim($numberDeletedBill)) {
                array_push($arrayAuxEfectivo, $itemFacturaEfectivo);
            } else {
                $contadorEfectivo = 0;
                foreach ($datosDetalleEfectivo as $keydetalle => $ItemDetalle) {
                    if ($itemFacturaEfectivo['totalEfectivo'] == $ItemDetalle['ValorEfectivo'] . "-" . $keydetalle) {
                        $datosDetalleEfectivo[$contadorEfectivo]['SaldoEfectivo'] = $ItemDetalle['SaldoEfectivo'] + $itemFacturaEfectivo['valorEfectivo'];
                    }
                    $contadorEfectivo++;
                }
            }
        }
        $session['EfectivoDetalle'] = $datosDetalleEfectivo;
        $session['Efectivo'] = $arrayAuxEfectivo;
        if ($session['ConsignacionEfec']) {
            $datosConsigEfectFactura = $session['ConsignacionEfec'];
        } else {
            $datosConsigEfectFactura = array();
        }
        if ($session['ConsignacionEfecDetalle']) {
            $datosConsignacion = $session['ConsignacionEfecDetalle'];
        } else {
            $datosConsignacion = array();
        }
        $SumaSaldoConsigEfectivo = 0;
        $arrayAuxConsig = array();
        foreach ($datosConsigEfectFactura as $itemConsigEfectFactura) {
            $txtNumeroEc = $itemConsigEfectFactura['txtNumeroEc'];
            $datosFactura = $itemConsigEfectFactura['facturaRecibo'];
            if (trim($numberDeletedBill) == trim($datosFactura)) {
                $SumaSaldoConsigEfectivo = $itemConsigEfectFactura['txtValorEc'];
                $cont = 0;
                foreach ($datosConsignacion as $itemDetalle) {
                    $numerodetalle = $itemDetalle['txtNumeroEc'] . '-' . $itemDetalle['txtCodBancoEc'];
                    if ($numerodetalle == $txtNumeroEc) {
                        $datosConsignacion[$cont]['txtValorEcSaldo'] = $itemDetalle['txtValorEcSaldo'] + $SumaSaldoConsigEfectivo;
                    }
                    $cont++;
                }
            } else {
                array_push($arrayAuxConsig, $itemConsigEfectFactura);
            }
        }
        $session['ConsignacionEfec'] = $arrayAuxConsig;
        $session['ConsignacionEfecDetalle'] = $datosConsignacion;
        if ($session['Cheque']) {
            $datosFacturaCheques = $session['Cheque'];
        }
        if ($session['ChequeDetalle']) {
            $datosDetalleCheque = $session['ChequeDetalle'];
        } else {
            $datosDetalleCheque = array();
        }
        $SumaSaldoCheque = 0;
        $arrayAuxCheque = array();
        foreach ($datosFacturaCheques as $itemFacturaCheques) {
            if (trim($itemFacturaCheques['facturaRecibo']) != trim($numberDeletedBill)) {
                array_push($arrayAuxCheque, $itemFacturaCheques);
            } else {
                $SumaSaldoCheque = $itemFacturaCheques['txtValorCheque'];
                $txtNumeroCheque = $itemFacturaCheques['txtNumeroCheque'];
                $contCheque = 0;
                foreach ($datosDetalleCheque as $itemDetalleCheque) {
                    $numerochdetalle = $itemDetalleCheque['txtNumeroCheque'] . '-' . $itemDetalleCheque['txtBancoCheque'];
                    if ($numerochdetalle == $txtNumeroCheque) {
                        $datosDetalleCheque[$contCheque]['txtValorChequeSaldo'] = $itemDetalleCheque['txtValorChequeSaldo'] + $SumaSaldoCheque;
                    }
                    $contCheque++;
                }
            }
        }
        $session['ChequeDetalle'] = $datosDetalleCheque;
        $session['Cheque'] = $arrayAuxCheque;
        if ($session['ConsignacionCheque']) {
            $datosConsigEfectFactura = $session['ConsignacionCheque'];
        } else {
            $datosConsigEfectFactura = array();
        }
        if ($session['ConsignacionChequeDetalle']) {
            $datosConsignacionChequeDta = $session['ConsignacionChequeDetalle'];
        } else {
            $datosConsignacionChequeDta = array();
        }
        /* echo '<pre>';
          print_r($datos); */
        $arrayAuxConsigCheque = array();
        $contDetalleChequeConsig = 0;
        $contEncabezadoChequeConsig = 0;
        foreach ($datosConsigEfectFactura as $itemConsigEfectFactura) {
            if ($itemConsigEfectFactura['facturaRecibo'] == trim($numberDeletedBill)) {
                foreach ($itemConsigEfectFactura['detalle'] as $subItem) {
                    $NumeroDCc = $subItem['txtNumeroDCc'];
                    $txtValorDcc = $subItem['txtValorDCc'];
                    $contEncabezadoChequeConsig = 0;
                    foreach ($datosConsignacionChequeDta as $itemConsigCheque) {
                        $contDetalleChequeConsig = 0;
                        foreach ($itemConsigCheque['detalle'] as $itemConsigChequeDetails) {
                            $txtNumeroDCc = $itemConsigChequeDetails['txtNumeroDCc'] . '-' . $itemConsigChequeDetails['txtCodBancoDCc'];
                            if (trim($NumeroDCc) == $txtNumeroDCc) {
                                $datosConsignacionChequeDta[$contEncabezadoChequeConsig]['detalle'][$contDetalleChequeConsig]['txtValorDCcSaldo'] = $itemConsigChequeDetails['txtValorDCcSaldo'] + $txtValorDcc;
                            }
                            $contDetalleChequeConsig++;
                        }
                        $contEncabezadoChequeConsig++;
                    }
                }
            } else {
                array_push($arrayAuxConsigCheque, $itemConsigEfectFactura);
            }
        }
        $session['ConsignacionCheque'] = $arrayAuxConsigCheque;
        $session['ConsignacionChequeDetalle'] = $datosConsignacionChequeDta;
        echo 'OK';
    }

}
