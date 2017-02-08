<?php

class PreventaController extends Controller {

    public $txtError;
    public $txtMensaje;

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

    public function actionCrearPedido($cliente, $zonaVentas) {



        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/preventa/crearPedido.js', CClientScript::POS_END
        );

        $codagencia = Yii::app()->user->_Agencia;

        if ($_POST) {
            $session = new CHttpSession;
            $session->open();
            $datos = $session['datosCompletarForm'];

            if ($session['componenteKitDinamico']) {
                $datosKit = $session['componenteKitDinamico'];
            } else {
                $datosKit = array();
            }


            $datosForm = $session['pedidoForm'];
            $Conjunto = '0';
            $CodAsesor = $datos['codigoAsesor'];
            $CodZonaVentas = $_POST['zonaVentas'];
            $CuentaCliente = $_POST['cuentaCliente'];
            $CodGrupoVenta = $datos['grupoVentas'];

            $consulta = Consultas::model()->getGrupoPrecio($CodZonaVentas, $CuentaCliente);

            $CodGrupoPrecios = $consulta['CodigoGrupoPrecio'];
            $Ruta = $datos['diaRuta'];
            $CodigoSitio = $datos['codigositio'];
            $CodigoAlmacen = $datos['codigoAlmacen'];
            $FechaPedido = date('Y-m-d');
            $HoraDigitado = date('H:i:s');
            $HoraEnviado = date('H:i:s');
            $FechaEntrega = $_POST['fechaEntrega'];
            $FormaPago = $_POST['formaPago'];
            $Plazo = $_POST['plazo'];
            $TipoVenta = $_POST['tipoVenta'];
            $ActividadEspecial = $_POST['actividadEspecial'];
            $Observacion = $_POST['Observaciones'];
            $NroFactura = '';

            $saldoCupo = $_POST['saldoCupo'];

            $precioNeto = 0;
            $valorProveedor = 0;
            $valorAltipal = 0;
            $valorEspecial = 0;
            $valorDescuentos = 0;
            $baseIva = 0;
            $cantidad = 0;
            $iva = 0;
            $impoconsumo = 0;
            $totalPedido = 0;

            $cont = 0;
            foreach ($datosForm as $itemDatos) {
                $precioNeto+=$itemDatos['totalValorPrecioNeto'];
                $valorProveedor+=$itemDatos['totalValorDescuentoProveedor'];
                $cantidad+=$itemDatos['cantidad'];
                $valorAltipal+=$itemDatos['totalValorDescuentoAltipal'];
                $valorEspecial+=$itemDatos['totalValorDescuentoEspecial'];
                $valorDescuentos+=$itemDatos['totalValorDescuentos'];
                $baseIva+=$itemDatos['totalValorbaseIva'];
                $iva+=$itemDatos['totalValorIva'];
                $impoconsumo+=$itemDatos['valorImpoconsumo'];
                $totalPedido+=$itemDatos['valorNeto'];
                $cont++;
            }


            $ValorPedido = $totalPedido;
            $TotalPedido = $cantidad;
            $TotalValorIva = $iva;
            $TotalSubtotalBaseIva = $baseIva;
            $TotalValorImpoconsumo = $impoconsumo;
            $TotalValorDescuento = $valorDescuentos;
            $Estado = '0';
            $ArchivoXml = '';
            $FechaTerminacion = date('Y-m-d');
            ;
            $HoraTerminacion = date('H:i:s');
            $EstadoPedido = '0';
            $AutorizaDescuentoEspecial = '0';
            $Web = '1';
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '0';
            $Canal = $session['canalEmpleado'];
            $Responsable = $session['Responsable'];

            if ($FormaPago == 'contado')
                $FormaPago = 'Contado';
            else {
                $FormaPago = 'Credito';
            }

            if ($ActividadEspecial == 'no') {
                $ActividadEspecial = '0';
            } else {
                $ActividadEspecial = '1';
            }

            $arrayEncabezado = array(
                'Conjunto' => $Conjunto,
                'CodAsesor' => $CodAsesor,
                'CodZonaVentas' => $CodZonaVentas,
                'CuentaCliente' => $CuentaCliente,
                'CodGrupoVenta' => $CodGrupoVenta,
                'CodGrupoPrecios' => $CodGrupoPrecios,
                'Ruta' => $Ruta,
                'CodigoSitio' => $CodigoSitio,
                'CodigoAlmacen' => $CodigoAlmacen,
                'FechaPedido' => $FechaPedido,
                'HoraDigitado' => $_POST['horaDigitada'],
                'HoraEnviado' => $HoraEnviado,
                'FechaEntrega' => $FechaEntrega,
                'FormaPago' => $FormaPago,
                'Plazo' => $Plazo,
                'TipoVenta' => $TipoVenta,
                'ActividadEspecial' => $ActividadEspecial,
                'Observacion' => $Observacion,
                'NroFactura' => $NroFactura,
                'ValorPedido' => $ValorPedido,
                'TotalPedido' => $TotalPedido,
                'TotalValorIva' => $TotalValorIva,
                'TotalSubtotalBaseIva' => $TotalSubtotalBaseIva,
                'TotalValorImpoconsumo' => $TotalValorImpoconsumo,
                'TotalValorDescuento' => $TotalValorDescuento,
                'Estado' => $Estado,
                'ArchivoXml' => $ArchivoXml,
                'FechaTerminacion' => '',
                'HoraTerminacion' => '',
                'EstadoPedido' => $EstadoPedido,
                'AutorizaDescuentoEspecial' => $AutorizaDescuentoEspecial,
                'Web' => $Web,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'CodigoCanal' => $Canal,
                'Responsable' => $Responsable,
                'ExtraRuta' => $session['extraruta'],
                'Ruta' => $session['clienteSeleccionado']['diaRuta'],
            );



            $model = new Pedidos;
            $model->attributes = $arrayEncabezado;

            if ($model->validate()) {

                $model->save();



                foreach ($datosForm as $itemDatos) {
                    $IdPedido = $model->IdPedido;
                    $CodVariante = $itemDatos['variante'];
                    $CodigoArticulo = $itemDatos['articulo'];
                    $CodigoTipo = $itemDatos['codigoTipo'];
                    $NombreArticulo = $itemDatos['nombreProducto'];
                    $Cantidad = $itemDatos['cantidad'];
                    $ValorUnitario = $itemDatos['valorUnitario'];
                    $Iva = $itemDatos['iva'];
                    $Impoconsumo = $itemDatos['impoconsumo'];
                    $CodigoUnidadMedida = $itemDatos['codigoUnidadMedida'];
                    $Saldo = $itemDatos['saldo'];
                    $CuentaProveedor = $itemDatos['cuentaProveedor'];
                    $DsctoLinea = $itemDatos['descuentoProveedor'];
                    $DsctoMultiLinea = $itemDatos['descuentoAltipal'];
                    $DsctoEspecial = $itemDatos['descuentoEspecial'];
                    $DsctoEspecialAltipal = $itemDatos['descuentoEspecialAltipal'];
                    $DsctoEspecialProveedor = $itemDatos['descuentoEspecialProveedor'];
                    $ValorBruto = $itemDatos['totalValorPrecioNeto'];
                    $ValorDsctoLinea = $itemDatos['totalValorDescuentoProveedor'];
                    $ValorDsctoMultiLinea = $itemDatos['totalValorDescuentoAltipal'];
                    $ValorDsctoEspecial = $itemDatos['totalValorDescuentoEspecial'];
                    $BaseIva = $itemDatos['totalValorbaseIva'];
                    $ValorIva = $itemDatos['totalValorIva'];
                    $ValorImpoconsumo = $itemDatos['valorImpoconsumo'];
                    $TotalPrecioNeto = $itemDatos['valorNeto'];
                    $PedidoMaquina = '0';
                    $IdentificadorEnvio = '0';
                    $EstadoTerminacion = '0';

                    $codigoUnidadMedida = $itemDatos['codigoUnidadMedida'];
                    $codigoUnidadMedidaACDL = $itemDatos['codigoUnidadMedidaACDL'];
                    $saldoACDLSinConversion = $itemDatos['saldoACDLSinConversion'];
                    $idAcuerdo = $itemDatos['idAcuerdo'];

                    $idSaldoInventario = $itemDatos['idSaldoInventario'];
                    $idAcuerdo = $itemDatos['idAcuerdo'];
                    $codigoUnidadSaldoInventario = $itemDatos['codigoUnidadSaldoInventario'];

                    $codigoUnidadSaldo = $itemDatos['codigoUnidadMedida'];

                    if ($TipoVenta == 'Consignacion') {

                        // echo $codigoUnidadMedida.'!='.$codigoUnidadSaldoInventario;
                        if ($codigoUnidadMedida != $codigoUnidadSaldo) {
                            $cantidadRestar = $this->buscaUnidadesConversion($CodigoArticulo, $codigoUnidadSaldoInventario, $codigoUnidadMedida, $Cantidad);
                            Consultas::model()->actualizarSaldoInventarioAutoventa($idAcuerdo, $cantidadRestar);
                        } else {
                            Consultas::model()->actualizarSaldoInventarioAutoventa($idAcuerdo, $Cantidad);
                        }
                    } else {
                        if ($codigoUnidadMedida != $codigoUnidadSaldoInventario) {
                            $cantidadRestar = $this->buscaUnidadesConversion($CodigoArticulo, $codigoUnidadSaldoInventario, $codigoUnidadMedida, $Cantidad);
                            Consultas::model()->actualizarSaldoInventarioPreventa($idSaldoInventario, $cantidadRestar);
                        } else {
                            Consultas::model()->actualizarSaldoInventarioPreventa($idSaldoInventario, $Cantidad);
                        }
                    }

                    if ($codigoUnidadMedidaACDL != 0 && $codigoUnidadMedidaACDL != "") {

                        if ($codigoUnidadMedida != $codigoUnidadMedidaACDL) {


                            $cantidad = $this->buscaUnidadesConversion($CodigoArticulo, $codigoUnidadMedidaACDL, $codigoUnidadMedida, $Cantidad);
                            $nuevaCantidad = $saldoACDLSinConversion - $cantidad;
                            Consultas::model()->actualizarSaldoLimite($nuevaCantidad, $idAcuerdo);
                        } else {
                            $nuevaCantidad = $saldoACDLSinConversion - $Cantidad;
                            Consultas::model()->actualizarSaldoLimite($nuevaCantidad, $idAcuerdo);
                        }
                    }



                    $datosDetalle = array(
                        'IdPedido' => $IdPedido,
                        'CodVariante' => $CodVariante,
                        'CodigoArticulo' => $CodigoArticulo,
                        'NombreArticulo' => $NombreArticulo,
                        'CodigoTipo' => $CodigoTipo,
                        'Cantidad' => $Cantidad,
                        'ValorUnitario' => $ValorUnitario,
                        'Iva' => $Iva,
                        'Impoconsumo' => $Impoconsumo,
                        'CodigoUnidadMedida' => $CodigoUnidadMedida,
                        'CuentaProveedor' => $CuentaProveedor,
                        'Saldo' => (int)$Saldo,
                        'DsctoLinea' => $DsctoLinea,
                        'DsctoMultiLinea' => $DsctoMultiLinea,
                        'DsctoEspecial' => $DsctoEspecial,
                        'DsctoEspecialAltipal' => $DsctoEspecialAltipal,
                        'DsctoEspecialProveedor' => $DsctoEspecialProveedor,
                        'ValorBruto' => $ValorBruto,
                        'ValorDsctoLinea' => $ValorDsctoLinea,
                        'ValorDsctoMultiLinea' => $ValorDsctoMultiLinea,
                        'ValorDsctoEspecial' => $ValorDsctoEspecial,
                        'BaseIva' => $BaseIva,
                        'ValorIva' => $ValorIva,
                        'ValorImpoconsumo' => $ValorImpoconsumo,
                        'TotalPrecioNeto' => $TotalPrecioNeto,
                        'AutorizaDscto' => $AutorizaDscto,
                        'FechaAutorizacionDscto' => $FechaAutorizacionDscto,
                        'HoraAutorizacionDscto' => $HoraAutorizacionDscto,
                        'QuienAutorizaDscto' => $QuienAutorizaDscto,
                        'EstadoRevisadoAltipal' => $EstadoRevisadoAltipal,
                        'EstadoRevisadoProveedor' => $EstadoRevisadoProveedor,
                        'MotivoRechazo' => $MotivoRechazo,
                        'EstadoRechazoAltipal' => $EstadoRechazoAltipal,
                        'EstadoRechazoProveedor' => $EstadoRechazoProveedor,
                        'UsuarioAutorizoDscto' => $UsuarioAutorizoDscto,
                        'NombreAutorizoDscto' => $NombreAutorizoDscto,
                        'PedidoMaquina' => $PedidoMaquina,
                        'IdentificadorEnvio' => $IdentificadorEnvio,
                        'EstadoTerminacion' => $EstadoTerminacion,
                    );



                    $modelDetalle = new Descripcionpedido;
                    $modelDetalle->attributes = $datosDetalle;

                    if (!$modelDetalle->validate()) {

                        print_r($modelDetalle->getErrors());
                    } else {
                        $modelDetalle->save();


                        foreach ($datosKit as $itemKit) {

                            if ($CodigoArticulo == $itemKit['txtCodigoArticuloKit']) {


                                $arrayDatosKit = array(
                                    'IdDescripcionPedido' => $modelDetalle->Id,
                                    'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                    'CodigoArticuloComponente' => $itemKit['txtCodigoArticulo'],
                                    'Nombre' => $itemKit['txtNombreKit'],
                                    'CodigoUnidadMedida' => $itemKit['txtUnidadKit'],
                                    'CodigoTipo' => $itemKit['txtTipo'],
                                    'Fijo' => $itemKit['txtCantidadItemFijo'],
                                    'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                    'CantidadFijo' => $itemKit['txtMinimoKitFijo'],
                                    'CantidadOpcional' => $itemKit['txtMinimoKitOpcional']
                                );

                                $modelDetalleKit = new Kitdescripcionpedido;
                                $modelDetalleKit->attributes = $arrayDatosKit;

                                if (!$modelDetalleKit->validate()) {
                                    print_r($modelDetalleKit->getErrors());
                                    exit();
                                } else {
                                    $modelDetalleKit->save();
                                }
                            }
                        }
                    }
 
                }
                
                $codtipodoc = '1';
                $estado = '0';

                $TransaxConsiga = array(
                        'CodTipoDocumentoActivity' => $codtipodoc,
                        'IdDocumento' => $model->IdPedido,
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
                    
            } else {
                print_r($model->getErrors());
            }
            //$this->PedidoXML($CodZonaVentas);
            //Pedidos::model()->setTransaccionesax($model->IdPedido);


            Yii::app()->user->setFlash('success', "Se ha registrado pedido correctamente!");

            //Restar el valor del pedido del saldo del cliente
            if ($FormaPago == 'credito') {

                $nuevoValor = $saldoCupo - $ValorPedido;
                Consultas::model()->actualizarSaldoCupo($CuentaCliente, $CodZonaVentas, $nuevoValor);
            }
        }

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];

        $datos = $session['datosCompletarForm'];
        $datos['codigositio'] = $codigoSitio;
        $datos['codigoAlmacen'] = $codigoAlmacen;
        $session['datosCompletarForm'] = $datos;

        $condicionPago = Consultas::model()->getCondicionPagoCliente($cliente, $zonaVentas);
        $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas);


        $portafolioPreventa = $this->getPortafolioInventarioTipoVenta($codigoSitio, $codigoAlmacen, $zonaVentas, $cliente, "Preventa");

        $portafolioAutoventa = $this->getPortafolioInventarioTipoVenta($codigoSitio, $codigoAlmacen, $zonaVentas, $cliente, "Autoventa");

        $saldoCupoCliente = Consultas::model()->getSaldoRecibosCupo($cliente, $zonaVentas);

        $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($zonaVentas);
        $valorMinimo = Consultas::model()->getValorMinimo($cliente);
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);

        $this->render('crearPedido', array('datosCliente' => $datosCliente,
            'zonaVentas' => $zonaVentas,
            'condicionPago' => $condicionPago,
            'sitiosVentas' => $sitiosVentas,
            'portafolioPreventa' => $portafolioPreventa,
            'portafolioAutoventa' => $portafolioAutoventa,
            'permisosDescuentoEspecial' => $permisosDescuentoEspecial,
            'valorMinimo' => $valorMinimo,
            'saldoCupoCliente' => $saldoCupoCliente,
        ));
    }

    /* private function PedidoXML($CodZonaVentas) {

      $InfoXMl = Pedidos::model()->getPedidoPreventa($CodZonaVentas);
      $codagencia = Yii::app()->user->_Agencia;

      $xml = '<?xml version="1.0" encoding="utf-8"?>';

      foreach ($InfoXMl as $itemInfo) {

      if ($itemInfo['Web'] == 1) {

      $salesOrigin = 'Web';
      } else {

      $salesOrigin = 'Movil';
      }


      if ($itemInfo['Responsable'] == "") {

      $codAdvaisor = $itemInfo['CodAsesor'];
      } else {

      $codAdvaisor = $itemInfo['Responsable'];
      }

      $xml .= '<panel>';
      $xml .= '<Header>';

      $xml .= '<OrderType> pedido de venta  </OrderType>';
      $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';
      $xml .= '<SalesOrder>'.$codagencia.'-'.$itemInfo['IdPedido'].'</SalesOrder>';
      $xml .= '<Route>' . $itemInfo['Ruta'] . '</Route>';
      $xml .= '<TaxGroup>' . $itemInfo['CodigoGrupodeImpuestos'] . '</TaxGroup>';
      $xml .= '<AdvisorCode>' . $codAdvaisor . '</AdvisorCode>';
      $xml .= '<SalesArea>' . $itemInfo['CodZonaVentas'] . '</SalesArea>';


      $xml .= '<LogisticsAreaCode>' . $itemInfo['CodigoZonaLogistica'] . '</LogisticsAreaCode>';
      $xml .= '<SalesGroup>' . $itemInfo['CodGrupoVenta'] . '</SalesGroup>';
      $xml .= '<SalesOrigin>' . $salesOrigin . '</SalesOrigin>';
      $xml .= '<SalesType>' . $itemInfo['TipoVenta'] . '</SalesType>';
      $xml .= '<Observations>' . $itemInfo['Observacion'] . '</Observations>';
      $xml .= '<DeliveryDate>' . $itemInfo['FechaEntrega'] . '</DeliveryDate>';
      $xml .= '<PaymentCondition>' . $itemInfo['FormaPago'] . '</PaymentCondition>';





      $InfoXMLDetail = Pedidos::model()->getDetallePedidoPreventa($itemInfo['IdPedido']);

      foreach ($InfoXMLDetail as $Itemdetail) {

      $xml .= '<Detail>';
      $xml .= '<VariantCode>' . $Itemdetail['CodVariante'] . '</VariantCode>';
      $xml .= '<MeasureUnit>' . $Itemdetail['CodigoUnidadMedida'] . '</MeasureUnit>';
      $xml .= '<LotArticle>' . $Itemdetail['CodLote'] . '</LotArticle>';
      $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
      $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
      $xml .= '<SalesPrice>' . $Itemdetail['ValorUnitario'] . '</SalesPrice>';
      $xml .= '<LineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</LineDiscount>';
      $xml .= '<MultiLineDiscount>' . $Itemdetail['DsctoMultiLinea'] . '</MultiLineDiscount>';
      $xml .= '<SpecialAltipalDiscount>' . $Itemdetail['DsctoEspecialAltipal'] . '</SpecialAltipalDiscount>';
      $xml .= '<SpecialVendDiscount>' . $Itemdetail['DsctoEspecialProveedor'] . '</SpecialVendDiscount>';
      $xml .= '<KitQuantity>' . $Itemdetail[''] . '</KitQuantity>';


      $xml .= '</Detail>';
      }
      $xml .= '</Header>';
      $xml .= '</panel>';
      }

      echo $xml;
      exit();
      } */

    private function getRestriccionesProveedor($zonaventas, $cuentaCliente, $codigoVariante) {


        $restriccionesArticulo = Consultas::model()->getRestriccionesProveedorArticulo($cuentaCliente, $zonaventas, $codigoVariante);
        $restriccionesArticulo = $restriccionesArticulo['Total'];

        if ($restriccionesArticulo > 0) {
            return false;
        } else {

            $restriccionesGrupo = Consultas::model()->getRestriccionesProveedorGrupo($cuentaCliente, $zonaventas, $codigoVariante);
            $restriccionesGrupo = $restriccionesGrupo['Total'];

            if ($restriccionesGrupo > 0) {
                return false;
            } else {

                $restriccionesProveedor = Consultas::model()->getRestriccionesProveedor($cuentaCliente, $zonaventas, $codigoVariante);
                $restriccionesProveedor = $restriccionesProveedor['Total'];

                if ($restriccionesProveedor > 0) {
                    //echo 'No pasa';
                    return false;
                } else {
                    //echo 'No tiene'; 
                    return true;
                }
            }
        }
    }

    public function actionAjaxGetTipoSaldo() {

        $session = new CHttpSession;
        $session->open();
        unset($session['tipoInventario']);
        $session['tipoInventario'] = $_POST['saldoInventario'];
        echo '1';
    }

    public function actionAjaxCalcularSaldoKitVirtual() {

        if ($_POST) {

            $codigoListaMateriales = $_POST['codigoListaMateriales'];
            $codigoArticuloKit = $_POST['codigoArticuloKit'];
            $cuentaCliente = $_POST['cuentaCliente'];
            $codigoUnidadMedida = $_POST['codigoUnidadMedida'];

            $componenteKid = Consultas::model()->getComponentesKit($codigoListaMateriales, $codigoArticuloKit);



            if (!$componenteKid) {
                $this->txtError = Consultas::model()->txtError;
                Registroexcepciones::model()->setRegistroexcepciones($this->txtError);
            } else {
                if (count($componenteKid) > 0) {

                    $menor = 999999999;
                    $itemDatosMenor = array();

                    foreach ($componenteKid as $item) {
                        $codigoArticuloKit = $item['CodigoArticuloKit'];
                        $codigoArticuloComponente = $item['CodigoArticuloComponente'];

                        $session = new CHttpSession;
                        $session->open();
                        $codigoSitio = $session['codigositio'];
                        $codigoAlmacen = $session['Almacen'];
                        $tipoInventario = $session['tipoInventario'];

                        if ($tipoInventario != 'Autoventa') {
                            $saldo = Consultas::model()->getSaldoInventarioPreventa($codigoArticuloComponente, $codigoSitio, $codigoAlmacen);
                        } else {

                            $saldo = Consultas::model()->getSaldoInventarioAutoventa($codigoArticuloComponente, $codigoSitio, $codigoAlmacen, $ubicacion, $cuentaCliente);
                            //$saldo=  Consultas::model()->getSaldoInventarioPreventa($codigoArticuloComponente, $codigoSitio, $codigoAlmacen);
                        }


                        if ($saldo) {
                            if ($saldo['Disponible'] < $menor) {
                                $menor = $saldo['Disponible'];
                                $itemDatosMenor = $item;
                                $itemDatosMenor['Id'] = $saldo['Id'];
                                $itemDatosMenor['Disponible'] = $saldo['Disponible'];
                                $itemDatosMenor['CodigoUnidadMedida'] = $saldo['CodigoUnidadMedida'];
                            }
                        }
                    }


                    $saldo = $itemDatosMenor['Disponible'];
                    $codigoArticulo = $itemDatosMenor['CodigoArticuloKit'];
                    $desde = $itemDatosMenor['CodigoUnidadMedida'];
                    $hasta = $codigoUnidadMedida;

                    if ($desde != $hasta) {
                        $cantidadConvertida = $this->calcularUnidadesConversion($saldo, $codigoArticulo, $desde, $hasta);
                    } else {
                        $cantidadConvertida = $saldo;
                    }


                    $this->txtMensaje = array('saldo' => $cantidadConvertida);
                    echo json_encode($this->txtMensaje);
                } else {
                    $this->txtMensaje = array('Mensaje' => 'No existe detalle para los componentes del Kid');
                    echo json_encode($this->txtMensaje);
                }
            }
        }
    }

    public function actionAjaxCalcularSaldoKitDinamico() {

        if ($_POST) {

            $codigoListaMateriales = $_POST['codigoListaMateriales'];
            $codigoArticuloKit = $_POST['codigoArticuloKit'];
            $codigoUnidadMedida = $_POST['codigoUnidadMedida'];
            $cuentaCliente = $_POST['cuentaCliente'];

            $encabezadoKit = Consultas::model()->getEncabezadoKit($codigoListaMateriales);
            $componenteKid = Consultas::model()->getComponentesKitDinamico($codigoListaMateriales, $codigoArticuloKit);

            if (!$componenteKid) {
                $this->txtError = Consultas::model()->txtError;
                Registroexcepciones::model()->setRegistroexcepciones($this->txtError);
            } else {
                if (count($componenteKid) > 0) {

                    $menor = 999999999;
                    $itemDatosMenor = array();

                    foreach ($componenteKid as $item) {
                        $codigoArticuloKit = $item['CodigoArticuloKit'];
                        $codigoArticuloComponente = $item['CodigoArticuloComponente'];

                        $session = new CHttpSession;
                        $session->open();
                        $codigoSitio = $session['codigositio'];
                        $codigoAlmacen = $session['Almacen'];

                        if ($tipoInventario != 'Autoventa') {
                            $saldo = Consultas::model()->getSaldoInventarioPreventa($codigoArticuloComponente, $codigoSitio, $codigoAlmacen);
                        } else {
                            $saldo = Consultas::model()->getSaldoInventarioAutoventa($codigoArticuloComponente, $codigoSitio, $codigoAlmacen, $ubicacion, $cuentaCliente);
                        }


                        $desde = $codigoUnidadMedida;
                        $hasta = $saldo['CodigoUnidadMedida'];
                        $saldo = $saldo['Disponible'];
                        $codigoArticulo = $codigoArticuloKit;

                        if ($desde != $hasta) {
                            $saldo['Disponible'] = $this->calcularUnidadesConversion($saldo, $codigoArticulo, $desde, $hasta);
                        } else {
                            $saldo['Disponible'] = $saldo['Disponible'];
                        }

                        if ($saldo) {

                            if ($saldo['Disponible'] < $menor) {
                                $menor = $saldo['Disponible'];
                                $itemDatosMenor = $item;
                                $itemDatosMenor['Id'] = $saldo['Id'];
                                $itemDatosMenor['Disponible'] = $saldo['Disponible'];
                                $itemDatosMenor['CodigoUnidadMedida'] = $saldo['CodigoUnidadMedida'];
                            }
                        }
                    }



                    $saldo = $itemDatosMenor['Disponible'];
                    $codigoArticulo = $itemDatosMenor['CodigoArticuloKit'];
                    $desde = $itemDatosMenor['CodigoUnidadMedida'];
                    $hasta = $codigoUnidadMedida;
                    /* if($desde!=$hasta){
                      $cantidadConvertida=$this->calcularUnidadesConversion($saldo,$codigoArticulo,$desde, $hasta);
                      }else{
                      $cantidadConvertida=$saldo;
                      } */

                    $datos = array('encabezado' => $encabezadoKit);
                    $datos['detalle'] = $componenteKid;
                    $datos['saldo'] = $menor;


                    $this->txtMensaje = $datos;

                    echo json_encode($this->txtMensaje);
                } else {
                    $this->txtMensaje = array('Mensaje' => 'No existe detalle para los componentes del Kid');
                    echo json_encode($this->txtMensaje);
                }
            }
        }
    }

    private function calcularUnidadesConversion($saldo, $codigoArticulo, $desde, $hasta) {

        $unidadesConversion = Consultas::model()->getUnidadesConversion($codigoArticulo, $desde, $hasta);
        $factor = $unidadesConversion['Factor'];
        $operacion = $unidadesConversion['Operacion'];

        if ($operacion == "Division") {
            $unidades = floor(($saldo / $factor));
        }

        if ($operacion == "Multiplicacion") {
            $unidades = floor(($saldo * $factor));
        }
        return $unidades;
    }

    public function actionAjaxAcuerdoComercialVenta() {

        if ($_POST) {
            $codigoVariante = $_POST['codigoVariante'];
            $cuentaCliente = $_POST['cliente'];
            $zonaventas = $_POST['zonaventas'];

            $session = new CHttpSession;
            $session->open();
            $codigoSitio = $session['codigositio'];
            $codigoAlmacen = $session['Almacen'];

            $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProduto($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);
            if ($productoAcuerdoComercialProducto) {

                $acuerdoComercial = array(
                    'CodigoUnidadMedida' => $productoAcuerdoComercialProducto['CodigoUnidadMedida'],
                    'NombreUnidadMedida' => $productoAcuerdoComercialProducto['NombreUnidadMedida'],
                    'PrecioVenta' => $productoAcuerdoComercialProducto['PrecioVenta']
                );

                echo json_encode($acuerdoComercial);
            } else {

                $productoAcuerdoComercialGrupo = Consultas::model()->getAcuerdoComercialGrupo($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);

                if ($productoAcuerdoComercialGrupo) {

                    $acuerdoComercial = array(
                        'CodigoUnidadMedida' => $productoAcuerdoComercialGrupo['CodigoUnidadMedida'],
                        'NombreUnidadMedida' => $productoAcuerdoComercialGrupo['NombreUnidadMedida'],
                        'PrecioVenta' => $productoAcuerdoComercialGrupo['PrecioVenta']
                    );

                    echo json_encode($acuerdoComercial);
                } else {
                    echo '0';
                }
            }
        }
    }

    public function actionAjaxACDL() {


        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $codigoSitio = $session['codigositio'];
            $codigoAlmacen = $session['Almacen'];

            $codigoVariante = $_POST['codigoVariante'];
            $cuentaCliente = $_POST['cliente'];
            $CodigoUnidadMedida = $_POST['CodigoUnidadMedida'];
            $articulo = $_POST['articulo'];
            $zonaventas = $_POST['zonaventas'];


            $ACDLClienteArticuloSaldo = Consultas::model()->getACDLClienteArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen);

            if ($ACDLClienteArticuloSaldo) {

                $resultado = array(
                    'IdAcuerdo' => $ACDLClienteArticuloSaldo['Id'],
                    'LimiteVentas' => $ACDLClienteArticuloSaldo['LimiteVentas'],
                    'Saldo' => $ACDLClienteArticuloSaldo['Saldo'],
                    'SaldoSinConversion' => $ACDLClienteArticuloSaldo['Saldo'],
                    'NombreUnidadMedidaSaldoLimite' => $ACDLClienteArticuloSaldo['NombreUnidadMedida'],
                    'CodigoUnidadMedida' => $ACDLClienteArticuloSaldo['CodigoUnidadMedida'],
                    'PorcentajeDescuentoLinea1' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLínea1'],
                    'PorcentajeDescuentoLinea2' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLínea2']
                );

                if ($CodigoUnidadMedida != $ACDLClienteArticuloSaldo['CodigoUnidadMedida']) {
                    $resultado['Saldo'] = $this->buscaUnidadesConversion(
                            $articulo, $CodigoUnidadMedida, $ACDLClienteArticuloSaldo['CodigoUnidadMedida'], $ACDLClienteArticuloSaldo['Saldo']
                    );
                }

                echo json_encode($resultado);
            } else {

                $ACDLGrupoClienteArticuloSaldo = Consultas::model()->getACDLGrupoClienteArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $zonaventas);

                if ($ACDLGrupoClienteArticuloSaldo) {

                    $resultado = array(
                        'IdAcuerdo' => $ACDLGrupoClienteArticuloSaldo['Id'],
                        'LimiteVentas' => $ACDLGrupoClienteArticuloSaldo['LimiteVentas'],
                        'Saldo' => $ACDLGrupoClienteArticuloSaldo['Saldo'],
                        'SaldoSinConversion' => $ACDLGrupoClienteArticuloSaldo['Saldo'],
                        'CodigoUnidadMedida' => $ACDLGrupoClienteArticuloSaldo['CodigoUnidadMedida'],
                        'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteArticuloSaldo['PorcentajeDescuentoLínea1'],
                        'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteArticuloSaldo['PorcentajeDescuentoLínea2']
                    );
                    if ($CodigoUnidadMedida != $ACDLGrupoClienteArticuloSaldo['CodigoUnidadMedida']) {
                        if ($CodigoUnidadMedida != $ACDLGrupoClienteArticuloSaldo['CodigoUnidadMedida']) {
                            $resultado['Saldo'] = $this->buscaUnidadesConversion(
                                    $articulo, $CodigoUnidadMedida, $ACDLGrupoClienteArticuloSaldo['CodigoUnidadMedida'], $ACDLGrupoClienteArticuloSaldo['Saldo']
                            );
                        }
                    }
                    echo json_encode($resultado);
                } else {

                    $ACDLClienteGrupoArticuloSaldo = Consultas::model()->getACDLClienteGrupoArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen);

                    if ($ACDLClienteGrupoArticuloSaldo) {

                        $resultado = array(
                            'IdAcuerdo' => $ACDLClienteGrupoArticuloSaldo['Id'],
                            'LimiteVentas' => $ACDLClienteGrupoArticuloSaldo['LimiteVentas'],
                            'Saldo' => $ACDLClienteGrupoArticuloSaldo['Saldo'],
                            'SaldoSinConversion' => $ACDLClienteGrupoArticuloSaldo['Saldo'],
                            'CodigoUnidadMedida' => $ACDLClienteGrupoArticuloSaldo['CodigoUnidadMedida'],
                            'PorcentajeDescuentoLinea1' => $ACDLClienteGrupoArticuloSaldo['PorcentajeDescuentoLínea1'],
                            'PorcentajeDescuentoLinea2' => $ACDLClienteGrupoArticuloSaldo['PorcentajeDescuentoLínea2']
                        );

                        if ($CodigoUnidadMedida != $ACDLClienteGrupoArticuloSaldo['CodigoUnidadMedida']) {
                            $resultado['Saldo'] = $this->buscaUnidadesConversion(
                                    $articulo, $CodigoUnidadMedida, $ACDLClienteGrupoArticuloSaldo['CodigoUnidadMedida'], $ACDLClienteGrupoArticuloSaldo['Saldo']
                            );
                        }

                        echo json_encode($resultado);
                    } else {

                        $ACDLGrupoClienteGrupoArticuloSaldo = Consultas::model()->getACDLGrupoClienteGrupoArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $zonaventas);

                        if ($ACDLGrupoClienteGrupoArticuloSaldo) {

                            $resultado = array(
                                'IdAcuerdo' => $ACDLGrupoClienteGrupoArticuloSaldo['Id'],
                                'LimiteVentas' => $ACDLGrupoClienteGrupoArticuloSaldo['LimiteVentas'],
                                'Saldo' => $ACDLGrupoClienteGrupoArticuloSaldo['Saldo'],
                                'SaldoSinConversion' => $ACDLGrupoClienteGrupoArticuloSaldo['Saldo'],
                                'CodigoUnidadMedida' => $ACDLGrupoClienteGrupoArticuloSaldo['CodigoUnidadMedida'],
                                'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteGrupoArticuloSaldo['PorcentajeDescuentoLínea1'],
                                'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteGrupoArticuloSaldo['PorcentajeDescuentoLínea2']
                            );

                            if ($CodigoUnidadMedida != $ACDLGrupoClienteGrupoArticuloSaldo['CodigoUnidadMedida']) {
                                $resultado['Saldo'] = $this->buscaUnidadesConversion(
                                        $articulo, $CodigoUnidadMedida, $ACDLGrupoClienteGrupoArticuloSaldo['CodigoUnidadMedida'], $ACDLGrupoClienteGrupoArticuloSaldo['Saldo']
                                );
                            }

                            echo json_encode($resultado);
                        } else {

                            $ACDLGrupoClienteArticuloSinSitioSaldo = Consultas::model()->getACDLGrupoClienteArticuloSinSitioSaldo($codigoVariante, $cuentaCliente, $zonaVentas);

                            if ($ACDLGrupoClienteArticuloSinSitioSaldo) {

                                $resultado = array(
                                    'IdAcuerdo' => $ACDLGrupoClienteArticuloSinSitioSaldo['Id'],
                                    'LimiteVentas' => $ACDLGrupoClienteArticuloSinSitioSaldo['LimiteVentas'],
                                    'Saldo' => $ACDLGrupoClienteArticuloSinSitioSaldo['Saldo'],
                                    'SaldoSinConversion' => $ACDLGrupoClienteArticuloSinSitioSaldo['Saldo'],
                                    'CodigoUnidadMedida' => $ACDLGrupoClienteArticuloSinSitioSaldo['CodigoUnidadMedida'],
                                    'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteArticuloSinSitioSaldo['PorcentajeDescuentoLínea1'],
                                    'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteArticuloSinSitioSaldo['PorcentajeDescuentoLínea2']
                                );

                                if ($CodigoUnidadMedida != $ACDLGrupoClienteArticuloSinSitioSaldo['CodigoUnidadMedida']) {
                                    $resultado['Saldo'] = $this->buscaUnidadesConversion(
                                            $articulo, $CodigoUnidadMedida, $ACDLGrupoClienteArticuloSinSitioSaldo['CodigoUnidadMedida'], $ACDLGrupoClienteArticuloSinSitioSaldo['Saldo']
                                    );
                                }

                                echo json_encode($resultado);
                            } else {
                                $ACDLGrupoClienteGrupoArticuloSinSitioSaldo = Consultas::model()->getACDLGrupoClienteGrupoArticuloSinSitioSaldo($codigoVariante, $cuentaCliente, $zonaVentas);

                                if ($ACDLGrupoClienteGrupoArticuloSinSitioSaldo) {

                                    $resultado = array(
                                        'IdAcuerdo' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['Id'],
                                        'LimiteVentas' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['LimiteVentas'],
                                        'Saldo' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['Saldo'],
                                        'SaldoSinConversion' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['Saldo'],
                                        'CodigoUnidadMedida' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['CodigoUnidadMedida'],
                                        'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['PorcentajeDescuentoLínea1'],
                                        'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['PorcentajeDescuentoLínea2']
                                    );

                                    if ($CodigoUnidadMedida != $ACDLClienteArticuloSaldo['CodigoUnidadMedida']) {
                                        $resultado['Saldo'] = $this->buscaUnidadesConversion(
                                                $articulo, $CodigoUnidadMedida, $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['CodigoUnidadMedida'], $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['Saldo']
                                        );
                                    }

                                    echo json_encode($resultado);
                                } else {
                                    echo '0';
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function actionAjaxDetalleArticulo() {
        $session = new CHttpSession;
        $session->open();
        $tipoInventario = $session['tipoInventario'];

        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $codigoSitio = $session['codigositio'];
            $codigoAlmacen = $session['Almacen'];

            $grupoVentas = $_POST['grupoVentas'];
            $codigoVariante = $_POST['codigoVariante'];
            $articulo = $_POST['articulo'];
            $cliente = $_POST['cliente'];
            $CodigoUnidadMedida = $_POST['CodigoUnidadMedida'];

            $datos = $session['datosCompletarForm'];
            $datos['grupoVentas'] = $grupoVentas;
            $session['datosCompletarForm'] = $datos;


            $detalleProducto = Consultas::model()->getDetalleProductoPedido($grupoVentas, $codigoVariante, $codigoSitio, $codigoAlmacen);

            //echo $tipoInventario;


            if ($tipoInventario == "Autoventa") {

                $ubicacion = $session['Ubicacion'];
                $saldoInventario = Consultas::model()->getSaldoInventarioAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion, $cliente);
            } else {
                $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
            }

            if ($CodigoUnidadMedida != $saldoInventario['CodigoUnidadMedida']) {

                $saldoInventario['Disponible'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $saldoInventario['CodigoUnidadMedida'], $CodigoUnidadMedida, $saldoInventario['Disponible']);
            }

            if ($CodigoUnidadMedida != 003) {
                //Para el impoconsumo se invierte la funcion de de una mayor a una menor
                $detalleProducto['ValorIMPOCONSUMO'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $CodigoUnidadMedida, '003', $detalleProducto['ValorIMPOCONSUMO']);
                if ($detalleProducto['ValorIMPOCONSUMO'] == null) {
                    $detalleProducto['ValorIMPOCONSUMO'] = 0;
                }
            }

            if ($detalleProducto) {

                $detalle = array(
                    'CodigoVariante' => $detalleProducto['CodigoVariante'],
                    'NombreArticulo' => $detalleProducto['NombreArticulo'],
                    'CodigoCaracteristica1' => $detalleProducto['CodigoCaracteristica1'],
                    'CodigoCaracteristica2' => $detalleProducto['CodigoCaracteristica2'],
                    'CodigoTipo' => $detalleProducto['CodigoTipo'],
                    'SaldoInventarioPreventa' => $saldoInventario['Disponible'],
                    'CodigoUnidadMedidaSaldo' => $saldoInventario['CodigoUnidadMedida'],
                    'NombreUnidadMedidaSaldo' => $saldoInventario['NombreUnidadMedida'],
                    'PorcentajedeIVA' => $detalleProducto['PorcentajedeIVA'],
                    'CuentaProveedor' => $detalleProducto['CuentaProveedor'],
                    'ValorIMPOCONSUMO' => $detalleProducto['ValorIMPOCONSUMO'],
                    'CodigoTipoKit' => $detalleProducto['CodigoTipoKit'],
                    'TotalPrecioVentaListaMateriales' => $detalleProducto['TotalPrecioVentaListaMateriales'],
                    'CodigoListaMateriales' => $detalleProducto['CodigoListaMateriales'],
                    'CodigoArticuloKit' => $detalleProducto['CodigoArticuloKit'],
                    'Sitio' => $detalleProducto['Sitio'],
                    'Almacen' => $detalleProducto['Almacen']
                );

                echo json_encode($detalle);
            }
        }
    }

    public function actionAjaxValidarItemPedido() {

        if ($_POST) {
            $variante = $_POST['variante'];

            $session = new CHttpSession;
            $session->open();
            $datos = $session['pedidoForm'];

            $cantidades = 0;
            foreach ($datos as $itemDatos) {

                if ($itemDatos['variante'] == $variante) {
                    $cantidades+=$itemDatos['cantidad'];
                }
            }

            $descuentoProveedor = 0;
            $descuentoAltipal = 0;
            $descuentoEspecial = 0;

            $busqueda = FALSE;
            foreach ($datos as $itemDatos) {

                if ($itemDatos['variante'] == $variante) {
                    $busqueda = TRUE;
                    $descuentoProveedor = $itemDatos['descuentoProveedor'];
                    $descuentoAltipal = $itemDatos['descuentoAltipal'];
                    $descuentoEspecial = $itemDatos['descuentoEspecial'];
                    $descuentoEspecialSelect = $itemDatos['descuentoEspecialSelect'];
                    $descuentoEspecialProveedor = $itemDatos['descuentoEspecialProveedor'];
                    $descuentoEspecialAltipal = $itemDatos['descuentoEspecialAltipal'];
                    break;
                }
            }


            if ($busqueda) {

                $respuesta = array(
                    'cantidad' => $cantidades,
                    'descuentoProveedor' => $descuentoProveedor,
                    'descuentoAltipal' => $descuentoAltipal,
                    'descuentoEspecial' => $descuentoEspecial,
                    'descuentoEspecialSelect' => $descuentoEspecialSelect,
                    'descuentoEspecialProveedor' => $descuentoEspecialProveedor,
                    'descuentoEspecialAltipal' => $descuentoEspecialAltipal
                );

                echo json_encode($respuesta);
            }
        }
    }

    private function buscaUnidadesConversion($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo, $saldo) {

        $conversion = Consultas::model()->getUnidadesConversionArticulo($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo);


        $factor = $conversion['Factor'];
        $operacion = $conversion['Operacion'];

        if ($operacion == "Division") {
            $unidades = floor(($saldo / $factor));
        }

        if ($operacion == "Multiplicacion") {
            $unidades = floor(($saldo * $factor));
        }
        return $unidades;
    }

    private function buscaUnidadesConversionACDM($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo, $saldo) {

        $conversion = Consultas::model()->getUnidadesConversionArticuloACDM($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo);


        $factor = $conversion['Factor'];
        $operacion = $conversion['Operacion'];

        if ($operacion == "Division") {
            $unidades = floor(($saldo / $factor));
        }

        if ($operacion == "Multiplicacion") {
            $unidades = floor(($saldo * $factor));
        }
        return $unidades;
    }

    public function actionAjaxAgregarItemPedido() {


        $session = new CHttpSession;
        $session->open();
        if ($session['pedidoForm']) {
            $datos = $session['pedidoForm'];
        } else {
            $datos = array();
        }


        $nombreProducto = $_POST['nombreProducto'];
        $codigoArticulo = $_POST['codigoArticulo'];
        $codigoTipo = $_POST['codigoTipo'];
        $variante = $_POST['variante'];
        $codigoUnidadMedida = $_POST['codigoUnidadMedida'];
        $valorUnitario = $_POST['valorUnitario'];
        $impoconsumo = $_POST['impoconsumo'];
        $cantidad = $_POST['cantidad'];
        $saldo = $_POST['saldo'];
        $saldoLimite = $_POST['saldoLimite'];
        $descuentoProveedor = $_POST['descuentoProveedor'];
        $descuentoAltipal = $_POST['descuentoAltipal'];
        $descuentoEspecial = $_POST['descuentoEspecial'];
        $iva = $_POST['iva'];
        $descuentoEspecialSelect = $_POST['descuentoEspecialSelect'];
        $cuentaProveedor = $_POST['cuentaProveedor'];

        if ($descuentoEspecialSelect == 'Proveedor') {
            $descuentoEspecialProveedor = '100';
        } else {
            $descuentoEspecialProveedor = $_POST['descuentoEspecialProveedor'];
        }

        if ($descuentoEspecialSelect == 'Altipal') {
            $descuentoEspecialAltipal = '100';
        } else {
            $descuentoEspecialAltipal = $_POST['descuentoEspecialAltipal'];
        }

        $aplicaImpoconsumo = $_POST['aplicaImpoconsumo'];
        $codigoUnidadMedidaACDL = $_POST['codigoUnidadMedidaACDL'];
        $saldoACDLSinConversion = $_POST['saldoACDLSinConversion'];
        $idAcuerdo = $_POST['idAcuerdo'];
        $idSaldoInventario = $_POST['idSaldoInventario'];
        $codigoUnidadSaldoInventario = $_POST['codigoUnidadSaldoInventario'];



        if (count($datos) > 0) {
            $arrayDatos = array();
            foreach ($datos as $itemDatos) {
                if ($itemDatos['variante'] != $variante) {
                    array_push($arrayDatos, $itemDatos);
                }
            }
            $session['pedidoForm'] = $arrayDatos;
            $datos = $session['pedidoForm'];
        }


        if ($cantidad > $saldoLimite && $saldoLimite != 0) {


            $itemAgregarPedido = array(
                'nombreProducto' => $nombreProducto,
                'codigoTipo' => $codigoTipo,
                'saldo' => $saldo,
                'codigoUnidadMedidaACDL' => $codigoUnidadMedidaACDL,
                'saldoACDLSinConversion' => $saldoACDLSinConversion,
                'idAcuerdo' => $idAcuerdo,
                'idSaldoInventario' => $idSaldoInventario,
                'codigoUnidadSaldoInventario' => $codigoUnidadSaldoInventario,
                'articulo' => $codigoArticulo,
                'codigoUnidadMedida' => $codigoUnidadMedida,
                'variante' => $variante,
                'valorUnitario' => $valorUnitario,
                'impoconsumo' => $impoconsumo,
                'cantidad' => $saldoLimite,
                'descuentoProveedor' => $descuentoProveedor,
                'descuentoAltipal' => $descuentoAltipal,
                'descuentoEspecial' => $descuentoEspecial,
                'iva' => $iva,
                'descuentoEspecialSelect' => $descuentoEspecialSelect,
                'descuentoEspecialProveedor' => $descuentoEspecialProveedor,
                'descuentoEspecialAltipal' => $descuentoEspecialAltipal,
                'cuentaProveedor' => $cuentaProveedor,
                'aplicaImpoconsumo' => $aplicaImpoconsumo
            );

            $itemAgregarPedido2 = array(
                'nombreProducto' => $nombreProducto,
                'codigoTipo' => $codigoTipo,
                'saldo' => $saldo,
                'codigoUnidadMedidaACDL' => $codigoUnidadMedidaACDL,
                'saldoACDLSinConversion' => $saldoACDLSinConversion,
                'idAcuerdo' => $idAcuerdo,
                'idSaldoInventario' => $idSaldoInventario,
                'codigoUnidadSaldoInventario' => $codigoUnidadSaldoInventario,
                'articulo' => $codigoArticulo,
                'codigoUnidadMedida' => $codigoUnidadMedida,
                'variante' => $variante,
                'valorUnitario' => $valorUnitario,
                'impoconsumo' => $impoconsumo,
                'cantidad' => ($cantidad - $saldoLimite),
                'descuentoProveedor' => '0',
                'descuentoAltipal' => $descuentoAltipal,
                'descuentoEspecial' => $descuentoEspecial,
                'iva' => $iva,
                'descuentoEspecialSelect' => $descuentoEspecialSelect,
                'descuentoEspecialProveedor' => $descuentoEspecialProveedor,
                'descuentoEspecialAltipal' => $descuentoEspecialAltipal,
                'cuentaProveedor' => $cuentaProveedor,
                'aplicaImpoconsumo' => $aplicaImpoconsumo
            );

            $busqueda = FALSE;
            foreach ($datos as $itemDatos) {

                if ($itemDatos['variante'] == $variante) {
                    $busqueda = TRUE;
                }
            }

            if (!$busqueda) {
                array_push($datos, $itemAgregarPedido);
                array_push($datos, $itemAgregarPedido2);
                $session['pedidoForm'] = $datos;
            }

            Yii::import('application.extensions.pedido.Pedido');
            $pedido = new Pedido();
            $pedido->getCalcularTotales();
            echo $this->renderPartial('_tablaDetalle', true);
        } else {

            $itemAgregarPedido = array(
                'nombreProducto' => $nombreProducto,
                'codigoTipo' => $codigoTipo,
                'saldo' => $saldo,
                'codigoUnidadMedidaACDL' => $codigoUnidadMedidaACDL,
                'saldoACDLSinConversion' => $saldoACDLSinConversion,
                'idAcuerdo' => $idAcuerdo,
                'idSaldoInventario' => $idSaldoInventario,
                'codigoUnidadSaldoInventario' => $codigoUnidadSaldoInventario,
                'articulo' => $codigoArticulo,
                'codigoUnidadMedida' => $codigoUnidadMedida,
                'variante' => $variante,
                'valorUnitario' => $valorUnitario,
                'impoconsumo' => $impoconsumo,
                'cantidad' => $cantidad,
                'descuentoProveedor' => $descuentoProveedor,
                'descuentoAltipal' => $descuentoAltipal,
                'descuentoEspecial' => $descuentoEspecial,
                'iva' => $iva,
                'descuentoEspecialSelect' => $descuentoEspecialSelect,
                'descuentoEspecialProveedor' => $descuentoEspecialProveedor,
                'descuentoEspecialAltipal' => $descuentoEspecialAltipal,
                'cuentaProveedor' => $cuentaProveedor,
                'aplicaImpoconsumo' => $aplicaImpoconsumo
            );

            $busqueda = FALSE;
            $campoBusqueda = 0;
            $cont = 0;
            foreach ($datos as $itemDatos) {

                if ($itemDatos['variante'] == $variante) {
                    $busqueda = TRUE;
                    $campoBusqueda = $cont;
                }

                $cont++;
            }

            if (!$busqueda) {
                array_push($datos, $itemAgregarPedido);
                $session['pedidoForm'] = $datos;
            }

            Yii::import('application.extensions.pedido.Pedido');
            $pedido = new Pedido();
            $pedido->getCalcularTotales();
            echo $this->renderPartial('_tablaDetalle', true);
        }
    }

    public function actionAjaxEliminarItemPedido() {
        $session = new CHttpSession;
        $session->open();
        $datos = $session['pedidoForm'];

        if ($_POST) {

            $variante = $_POST['variante'];

            $arrayDatos = array();
            foreach ($datos as $itemDatos) {
                if ($itemDatos['variante'] != $variante) {
                    array_push($arrayDatos, $itemDatos);
                }
            }

            $session['pedidoForm'] = $arrayDatos;

            Yii::import('application.extensions.pedido.Pedido');
            $pedido = new Pedido();
            $pedido->getCalcularTotales();
            echo $this->renderPartial('_tablaDetalle', true);
        }
    }

    public function actionAjaxTotalesPedido() {
        Yii::import('application.extensions.pedido.Pedido');
        $pedido = new Pedido();
        $saldoCupo = $_POST['saldoCupo'];
        $pedido->getCalcularTotales();
        echo $this->renderPartial('_tablaTotales', array('saldoCupo' => $saldoCupo), true);
    }

    public function actionAjaxActualizaPortafolioAgregar() {

        $session = new CHttpSession;
        $session->open();
        $datos = $session['pedidoForm'];

        $articulosAgregados = array();

        foreach ($datos as $itemDatos) {
            array_push($articulosAgregados, $itemDatos['variante']);
        }
        echo json_encode($articulosAgregados);
    }

    public function actionAjaxComponentesKitDinamico() {

        $post_text = trim(file_get_contents('php://input'));
        $componenetesKid = CJSON::decode($post_text);

        echo $this->renderPartial('_componenetesKidDinamico', array('componenetesKid' => $componenetesKid), true);
    }

    public function actionAjaxGuardarKitDinamico() {

        $session = new CHttpSession;
        $session->open();

        $txtCodigoArticuloKit = $_POST['txtCodigoArticuloKit'];
        $txtCodigoLista = $_POST['txtCodigoLista'];
        $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
        $txtNombreKit = $_POST['txtNombreKit'];
        $txtUnidadKit = $_POST['txtUnidadKit'];
        $txtTipo = $_POST['txtTipo'];
        $txtCantidadItemFijo = $_POST['txtCantidadItemFijo'];
        $txtCantidadItemOpcional = $_POST['txtCantidadItemOpcional'];

        $txtMinimoKitFijo = $_POST['txtMinimoKitFijo'];
        $txtMinimoKitOpcional = $_POST['txtMinimoKitOpcional'];

        if ($session['componenteKitDinamico']) {
            $datosKit = $session['componenteKitDinamico'];
        } else {
            $datosKit = array();
        }

        $datosArray = array(
            'txtCodigoArticuloKit' => $txtCodigoArticuloKit,
            'txtCodigoLista' => $txtCodigoLista,
            'txtCodigoArticulo' => $txtCodigoArticulo,
            'txtNombreKit' => $txtNombreKit,
            'txtUnidadKit' => $txtUnidadKit,
            'txtTipo' => $txtTipo,
            'txtCantidadItemFijo' => $txtCantidadItemFijo,
            'txtCantidadItemOpcional' => $txtCantidadItemOpcional,
            'txtMinimoKitFijo' => $txtMinimoKitFijo,
            'txtMinimoKitOpcional' => $txtMinimoKitOpcional
        );

        $arrayBusqueda = FALSE;
        foreach ($datosKit as $clave => $item) {
            if (
                    $item['txtCodigoLista'] == $txtCodigoLista &&
                    $item['txtCodigoArticulo'] == $txtCodigoArticulo &&
                    $item['txtMinimoKitFijo'] == $txtMinimoKitFijo &&
                    $item['txtMinimoKitOpcional'] == $txtMinimoKitOpcional
            ) {
                $datosKit[$clave] = $datosArray;
                $arrayBusqueda = TRUE;
            }
        }

        if (!$arrayBusqueda) {
            array_push($datosKit, $datosArray);
        }

        $session['componenteKitDinamico'] = $datosKit;

        echo '<pre>';
        print_r($datosKit);
        echo '</pre>';
    }

    public function actionAjaxCargarPortafolio() {


        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];
        $zonaVentas = $_POST['zonaVentas'];
        $cuentaCliente = $_POST['cuentaCliente'];
        $tipoInventario = $session['tipoInventario'];



        $portafolioZonaVentas = Consultas::model()->getPortafolio($zonaVentas, $codigoSitio, $codigoAlmacen);


        $portafolioSinRestriccion = array();

        foreach ($portafolioZonaVentas as $itemPortafolio) {
            $zonaventas = $zonaVentas;
            $codigoVariante = $itemPortafolio['CodigoVariante'];
            if ($this->getRestriccionesProveedor($zonaventas, $cuentaCliente, $codigoVariante)) {
                $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProduto($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);

                if ($productoAcuerdoComercialProducto) {
                    $itemPortafolio['AcuerdoComercial'] = '1';
                    $CodigoUnidadMedida = $productoAcuerdoComercialProducto['CodigoUnidadMedida'];
                } else {

                    $productoAcuerdoComercialGrupo = Consultas::model()->getAcuerdoComercialGrupo($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);

                    if ($productoAcuerdoComercialGrupo) {
                        $itemPortafolio['AcuerdoComercial'] = '1';
                        $CodigoUnidadMedida = $productoAcuerdoComercialGrupo['CodigoUnidadMedida'];
                    } else {
                        $itemPortafolio['AcuerdoComercial'] = '0';
                    }
                }


                if ($tipoInventario == "Autoventa") {
                    $ubicacion = $session['Ubicacion'];
                    $saldoInventario = Consultas::model()->getSaldoInventarioAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion, $cuentaCliente);
                } else {
                    $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
                }

                if ($CodigoUnidadMedida != $saldoInventario['CodigoUnidadMedida']) {
                    $saldoInventario['Disponible'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $saldoInventario['CodigoUnidadMedida'], $CodigoUnidadMedida, $saldoInventario['Disponible']);
                }


                if (count($saldoInventario) > 0) {
                    $itemPortafolio['SaldoInventario'] = $saldoInventario['Disponible'];
                    $itemPortafolio['CodigoUnidadMedida'] = $saldoInventario['CodigoUnidadMedida'];
                    $itemPortafolio['IdSaldoInventario'] = $saldoInventario['Id'];
                } else {
                    $itemPortafolio['SaldoInventario'] = '0';
                }


                array_push($portafolioSinRestriccion, $itemPortafolio);
            }
        }

        $portafolioZonaVentas = $portafolioSinRestriccion;
        $this->renderPartial('_portafolio', array(
            'portafolioZonaVentas' => $portafolioZonaVentas,
            'zonaVentas' => $zonaVentas,
            'cuentaCliente' => $cuentaCliente
        ));
    }

    public function actionAjaxResetPedido() {

        $session = new CHttpSession;
        $session->open();
        if ($session['pedidoForm']) {
            $datos = $session['pedidoForm'];
        } else {
            $datos = array();
        }
        $session['pedidoForm'] = array();
        echo $this->renderPartial('_tablaDetalle', true);
    }

    private function getPortafolioInventarioTipoVenta($codigoSitio, $codigoAlmacen, $zonaVentas, $cuentaCliente, $tipoInventario) {

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $codigoSitio;
        $codigoAlmacen = $codigoAlmacen;
        $zonaVentas = $zonaVentas;
        $cuentaCliente = $cuentaCliente;
        $tipoInventario = $tipoInventario;


        $portafolioZonaVentas = Consultas::model()->getPortafolio($zonaVentas, $codigoSitio, $codigoAlmacen);







        $portafolioSinRestriccion = array();

        foreach ($portafolioZonaVentas as $itemPortafolio) {
            $zonaventas = $zonaVentas;
            $codigoVariante = $itemPortafolio['CodigoVariante'];
            $grupoVentas = $itemPortafolio['CodigoGrupoVentas'];

            $detalleProducto = Consultas::model()->getDetalleProductoPedido($grupoVentas, $codigoVariante, $codigoSitio, $codigoAlmacen);

            if ($this->getRestriccionesProveedor($zonaventas, $cuentaCliente, $codigoVariante)) {
                $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProduto($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);

                /* echo '<pre>';
                  print_r($productoAcuerdoComercialProducto);
                  echo '</pre>'; */


                if ($productoAcuerdoComercialProducto) {
                    $itemPortafolio['AcuerdoComercial'] = '1';
                    $CodigoUnidadMedida = $productoAcuerdoComercialProducto['CodigoUnidadMedida'];
                } else {

                    $productoAcuerdoComercialGrupo = Consultas::model()->getAcuerdoComercialGrupo($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);

                    /* echo '<pre>';
                      print_r($productoAcuerdoComercialGrupo."------");
                      echo '</pre>'; */

                    if ($productoAcuerdoComercialGrupo) {
                        $itemPortafolio['AcuerdoComercial'] = '1';
                        $CodigoUnidadMedida = $productoAcuerdoComercialGrupo['CodigoUnidadMedida'];
                    } else {
                        $itemPortafolio['AcuerdoComercial'] = '0';
                    }
                }


                if ($tipoInventario == "Autoventa") {
                    $ubicacion = $session['Ubicacion'];
                    $saldoInventario = Consultas::model()->getSaldoInventarioAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion, $cuentaCliente);
                } else {
                    $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
                    /* echo '<pre>';
                      echo $codigoVariante.'</br>';
                      echo $CodigoUnidadMedida.'!='.$saldoInventario['CodigoUnidadMedida'].'</br>';
                      print_r($saldoInventario);
                      echo '</pre>'; */
                }

                if ($CodigoUnidadMedida != $saldoInventario['CodigoUnidadMedida']) {
                    $detalleProducto['CodigoArticulo'] . '--';
                    $saldoInventario['Disponible'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $saldoInventario['CodigoUnidadMedida'], $CodigoUnidadMedida, $saldoInventario['Disponible']);
                    $saldoInventario['Disponible'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $saldoInventario['CodigoUnidadMedida'], $CodigoUnidadMedida, $saldoInventario['Disponible']);
                }


                if (count($saldoInventario) > 0) {
                    $itemPortafolio['SaldoInventario'] = $saldoInventario['Disponible'];
                    $itemPortafolio['CodigoUnidadMedida'] = $saldoInventario['CodigoUnidadMedida'];
                    $itemPortafolio['IdSaldoInventario'] = $saldoInventario['Id'];
                } else {
                    $itemPortafolio['SaldoInventario'] = '0';
                }


                array_push($portafolioSinRestriccion, $itemPortafolio);
            }
        }


        //exit();
        $portafolioZonaVentas = $portafolioSinRestriccion;

        return $portafolioZonaVentas;
    }

}
