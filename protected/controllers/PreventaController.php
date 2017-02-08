<?php

class PreventaController extends Controller {

    public $txtError;
    public $txtMensaje;
    private $dataReader;
    private $cargarPortafolio;
    private $portafolio;
    private $cargarAcuerdoComercialPrecio;
    private $acuerdoComercialPrecio;
    private $cargarCodigoGrupoPrecio;
    private $restriccionesProveedor;
    private $codigoGrupoPrecio;
    private $nombreCodigoGrupoPrecio;
    private $cargarSaldoPreventa;
    private $saldoPreventa;
    private $cargarSaldoAutoventa;
    private $saldoAutoventa;
    private $cargarUnidadesConversion;
    private $unidadesConversion;
    private $cargarOperacionesUnidades;
    private $operacionesUnidades;
    private $cargarKitPortafolio;
    private $listaMateriales;
    private $codigoArticulo;
    private $cargarAcuerdoLinea;
    private $acuerdoLinea;
    private $cargarAcuerdoMultiLinea;
    private $acuerdoMultiLinea;
    private $unidadDesde;
    private $unidadHasta;
    private $operacion;
    private $cantidadConvertida;
    private $cargarSaldoLimite;
    private $saldoLimite;
    private $zonaVentas;
    private $cuentaCliente;
    private $codigoSitio;
    private $codigoAlmacen;
    private $ubicacion;
    private $cargarVariantesInactivas;
    private $variantesInactivas;
    private $cargarRestriccionesProveedor;
    private $restriccionesproveedores;

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

            if ($session['componenteKitDinamicoActivity']) {
                $datosKit = $session['componenteKitDinamicoActivity'];
            } else {
                $datosKit = array();
            }

            /* echo  '<pre>';
              print_r($datosKit);
              die(); */

            $datosForm = $session['pedidoForm'];

            /*            echo '<pre>';
              print_r($datosForm);
              die(); */

            $Conjunto = '0';
            $CodAsesor = $datos['codigoAsesor'];
            $CodZonaVentas = $_POST['zonaVentas'];
            $CuentaCliente = $_POST['cuentaCliente'];
            $codigoGrupodeImpuestos = $_POST['codigoGrupodeImpuestos'];
            $codigoZonaLogistica = $_POST['codigoZonaLogistica'];

            $consulta = Consultas::model()->getGrupoPrecio($CodZonaVentas, $CuentaCliente);
            $consulta1 = Consultas::model()->getGrupoImpuesto($CodZonaVentas, $CuentaCliente);
            $grupoVentas = Preventa::model()->cargarGrupoVentas($CodZonaVentas);

            $CodGrupoVenta = $grupoVentas['CodigoGrupoVentas'];
            $CodGrupoImpuestos = $consulta1['CodigoGrupodeImpuestos'];

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
            $ActividadEspecial = $_POST['selactividadEspecial'];
            $Observacion = $_POST['Observaciones'];
            $NroFactura = '';

            $logitud = $_POST['longitud'];
            $latitud = $_POST['latitud'];

            // conjunto
            if ($TipoVenta == 'Preventa') {

                $conjunto = '001';
            } else if ($TipoVenta == 'VentaDirecta') {

                $conjunto = '003';
            } else if ($TipoVenta == 'Consignacion') {

                $conjunto = '004';
            } else if ($TipoVenta == 'Autoventa') {

                $conjunto = '002';
            }

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
            $ArchivoXml = '';
            $FechaTerminacion = date('Y-m-d');

            $HoraTerminacion = date('H:i:s');
            $EstadoPedido = '0';

            $AutorizaDescuentoEspecial = '0';

            $Web = '1';
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '1';
            $Canal = $session['canalEmpleado'];
            $Responsable = $session['Responsable'];
            if ($Responsable == "" || $Responsable == null) {
                $Responsable = "";
            }

            if ($FormaPago == 'contado')
                $FormaPago = 'Contado';
            else {
                $FormaPago = 'Credito';
            }

            if ($ActividadEspecial == 'si') {
                $ActividadEspecial = '1';
                $Estado = '1';
            } elseif ($ActividadEspecial == 'no') {
                $ActividadEspecial = '0';
                $Estado = '0';
            }

            $globalsaldo = 0;
            if ($FormaPago == 'Credito') {
                $SaldoActual = $saldoCupo - $ValorPedido;
                Consultas::model()->getActualizarsaldocupocliente($SaldoActual, $CuentaCliente, $CodZonaVentas);
                $globalsaldo = $SaldoActual;
            }

            if ($codigoGrupodeImpuestos == "") {
                $codigoGrupodeImpuestos = 0;
            }

            $arrayEncabezado = array(
                'Conjunto' => $conjunto,
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
                'FechaTerminacion' => '0000-00-00',
                'HoraTerminacion' => '00:00:00',
                'EstadoPedido' => $EstadoPedido,
                'AutorizaDescuentoEspecial' => $AutorizaDescuentoEspecial,
                'Web' => $Web,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'CodigoCanal' => $Canal,
                'Responsable' => $Responsable,
                'ExtraRuta' => $session['extraruta'],
                'Ruta' => $session['clienteSeleccionado']['diaRuta'],
                'CodigoGrupodeImpuestos' => $codigoGrupodeImpuestos,
                'CodigoZonaLogistica' => $codigoZonaLogistica,
                'Resolucion' => ''
            );

            /* echo '<pre>';
              print_r($arrayEncabezado); */


            $model = new Pedidos;
            $model->attributes = $arrayEncabezado;
            if ($model->validate()) {
                $model->save();
                foreach ($datosForm as $itemDatos) {

                    if (empty($itemDatos['descuentoEspecialAltipal'])) {
                        $itemDatos['descuentoEspecialAltipal'] = "0";
                    }

                    if (empty($itemDatos['descuentoEspecialProveedor'])) {
                        $itemDatos['descuentoEspecialProveedor'] = "0";
                    }

                    if (empty($itemDatos['txtIdAcuerdoLinea'])) {
                        $itemDatos['txtIdAcuerdoLinea'] = "0";
                    }

                    if (empty($itemDatos['txtIdAcuerdoMultilinea'])) {
                        $itemDatos['txtIdAcuerdoMultilinea'] = "0";
                    }

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
                    $txtIdAcuerdoLinea = $itemDatos['txtIdAcuerdoLinea'];
                    $txtIdAcuerdoMultilinea = $itemDatos['txtIdAcuerdoMultilinea'];

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

                    if ($CodigoUnidadMedida == '001') {
                        $NombreUnidadMedida = "Caja";
                    }

                    if ($CodigoUnidadMedida == '002') {
                        $NombreUnidadMedida = "Display";
                    }

                    if ($CodigoUnidadMedida == '003') {
                        $NombreUnidadMedida = "Unidad";
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
                        'Saldo' => (int) $Saldo,
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
                        'NombreUnidadMedida' => $NombreUnidadMedida,
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
                        'CodLote' => "0",
                        'IdAcuerdoPrecioVenta' => $idAcuerdo,
                        'IdAcuerdoLinea' => $txtIdAcuerdoLinea,
                        'IdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea
                    );

                    /* echo  '<pre>';
                      print_r($datosDetalle);
                      die(); */

                    $modelDetalle = new Descripcionpedido;
                    $modelDetalle->attributes = $datosDetalle;
                    if (!$modelDetalle->validate()) {

                        print_r($modelDetalle->getErrors());
                    } else {
                        $modelDetalle->save();
                        if ($CodigoTipo == 'KD') {
                            foreach ($datosKit as $itemKit) {

                                if ($CodigoArticulo == $itemKit->txtKitCodigoArticuloKit) {

                                    if ($itemKit->txtKitFijo != "" || $itemKit->txtKitOpcional != "") {

                                        if ($itemKit->cantidad != "") {
                                            $cantidadKit = $itemKit->cantidad;
                                        } else {
                                            $cantidadKit = '0';
                                        }

                                        $arrayDatosKit = array(
                                            'IdDescripcionPedido' => $modelDetalle->Id,
                                            'CodigoListaMateriales' => $itemKit->txtKitCodigoListaMateriales,
                                            'CodigoArticuloComponente' => $itemKit->txtKitCodigoVarianteComponente,
                                            'Nombre' => $itemKit->txtKitNombre,
                                            'CodigoUnidadMedida' => $itemKit->txtKitNombreUnidadMedida,
                                            'CodigoTipo' => $itemKit->txtKitCodigoTipo,
                                            'Fijo' => $itemKit->txtKitFijo,
                                            'Opcional' => $itemKit->txtKitOpcional,
                                            'Cantidad' => $cantidadKit,
                                            'PrecioVentaBaseVariante' => $itemKit->txtKitPrecioVentaBaseVariante
                                        );

                                        $modelDetalleKit = new Kitdescripcionpedido;
                                        $modelDetalleKit->attributes = $arrayDatosKit;

                                        if (!$modelDetalleKit->validate()) {

                                            print_r($modelDetalleKit->getErrors());
                                            exit();
                                        } else {
                                            $modelDetalleKit->save();
                                        }
                                    } else {

                                        if ($itemKit->cantidad != "") {
                                            $cantidadKit = $itemKit->cantidad;
                                        } else {
                                            $cantidadKit = '0';
                                        }

                                        $arrayDatosKit = array(
                                            'IdDescripcionPedido' => $modelDetalle->Id,
                                            'CodigoListaMateriales' => $itemKit->txtKitCodigoListaMateriales,
                                            'CodigoArticuloComponente' => $itemKit->txtKitCodigoVarianteComponente,
                                            'Nombre' => $itemKit->txtKitNombre,
                                            'CodigoUnidadMedida' => $itemKit->txtKitNombreUnidadMedida,
                                            'CodigoTipo' => $itemKit->txtKitCodigoTipo,
                                            'Fijo' => $itemKit->txtKitFijo,
                                            'Opcional' => $itemKit->txtKitOpcional,
                                            'Cantidad' => $cantidadKit,
                                            'PrecioVentaBaseVariante' => $itemKit->txtKitPrecioVentaBaseVariante
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
                        } else if ($CodigoTipo == 'KV') {

                            $datosKitVirtual = Preventa::model()->cargarListaMaterialesGuardar($CodVariante);

                            /* echo '<pre>';
                              print_r($datosKitVirtual);
                              die(); */
                            foreach ($datosKitVirtual as $itemKitVirtual) {

                                $arrayDatosKitVirtual = array(
                                    'IdDescripcionPedido' => $modelDetalle->Id,
                                    'CodigoListaMateriales' => $itemKitVirtual["LMCodigoListaMateriales"],
                                    'CodigoArticuloComponente' => $itemKitVirtual["LMDCodigoVarianteComponente"],
                                    'Nombre' => $itemKitVirtual["NombreComponente"],
                                    'CodigoUnidadMedida' => $itemKitVirtual["LMDNombreUnidadMedida"],
                                    'CodigoTipo' => $itemKitVirtual["CA"],
                                    'Fijo' => $itemKitVirtual["LMDFijo"],
                                    'Opcional' => $itemKitVirtual["LMDOpcional"],
                                    'Cantidad' => $itemKitVirtual["LMDCantidadComponente"],
                                    'PrecioVentaBaseVariante' => $itemKitVirtual["LMDPrecioVentaBaseVariante"],
                                );

                                $modelDetalleKit = new Kitdescripcionpedido;
                                $modelDetalleKit->attributes = $arrayDatosKitVirtual;

                                if (!$modelDetalleKit->validate()) {

                                    print_r($modelDetalleKit->getErrors());
                                    exit();
                                } else {
                                    $modelDetalleKit->save();
                                }
                            }
                            /* echo  '<pre>';
                              print_r($arrayDatosKitVirtual);
                              die(); */
                        }
                    }
                }

                $PedidoDescuento = Consultas::model()->getEstadoDescuento($IdPedido);
                $PedidosActividadDescuentos = Consultas::model()->getEstadoActividadDescuento($IdPedido);
                $pedidoClienteNuevo = Consultas::model()->getConteoClienteNuevoPedido($zonaVentas, $CuentaCliente);

                if ($PedidoDescuento['pedidosdescuentos'] > 0) {
                    Consultas::model()->getUpdateEstadoPedidoDescuento($IdPedido);
                }

                if ($PedidosActividadDescuentos['pedidosdescuentosactividad'] > 0) {
                    Consultas::model()->getUpdateEstadoPedidoDescuentoActividad($IdPedido);
                }

                $cordenadas = array(
                    'CuentaCliente' => $CuentaCliente,
                    'IdDocumento' => $model->IdPedido,
                    'Origen' => '1',
                    'Longitud' => $logitud,
                    'Latitud' => $latitud,
                    'Fecha' => $FechaPedido,
                    'Hora' => $HoraEnviado,
                    'CodZonaVentas' => $CodZonaVentas,
                    'CodAsesor' => $CodAsesor
                );

                $modeCordenadas = new Coordenadas;
                $modeCordenadas->attributes = $cordenadas;


                if (!$modeCordenadas->validate()) {

                    print_r($modeCordenadas->getErrors());
                } else {

                    $modeCordenadas->save();
                }

                // echo $DsctoEspecial


                if ($ActividadEspecial != '1' && $DsctoEspecial == '0') {

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
                }



                if ($DsctoEspecial > 0) {


                    Consultas::model()->getUpdateEstadoDescuento($model->IdPedido);
                    $Agencia = Consultas::model()->getAgencia($codagencia);

                    $nombreAgencia = $Agencia['Nombre'];

                    //Altipal
                    $PedidoAltipal = Consultas::model()->getPedidoAltipal($model->IdPedido);
                    $codGrupoVentas = $PedidoAltipal[0]['CodGrupoVenta'];
                    $this->correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, '', $codagencia, '');

                    //Proveedor
                    $PedidoProveedor = Consultas::model()->getPedidoProveedor($model->IdPedido);
                    $codGrupoVentas = $PedidoProveedor[0]['CodGrupoVenta'];


                    foreach ($PedidoProveedor as $itemproveedor) {

                        $proveedor = $itemproveedor['CuentaProveedor'];

                        $this->correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, $proveedor, $codagencia, $model->IdPedido);
                    }
                }

                if ($TipoVenta == 'VentaDirecta') {

                    $correosventadirecta = Consultas::model()->getCorreoVentaDirecta($CuentaProveedor);
                    $Agencia = Consultas::model()->getAgencia($codagencia);
                    $nombreAgencia = $Agencia['Nombre'];
                    $Proveedor = Consultas::model()->getNombreProveedor($CuentaProveedor);
                    $nombreProveedor = $Proveedor['NombreCuentaProveedor'];


                    foreach ($correosventadirecta as $itemCorreoVentasDirecta) {

                        //$this->correoVentaDirecta($itemCorreoVentasDirecta['Nombres'], $itemCorreoVentasDirecta['Apellidos'], $itemCorreoVentasDirecta['CorreoElectronico'], $itemCorreoVentasDirecta['NombreAgencia']);
                        $this->correoVentaDirecta($itemCorreoVentasDirecta['Nombres'], $itemCorreoVentasDirecta['Apellidos'], $itemCorreoVentasDirecta['CorreoElectronico'], $nombreProveedor, $nombreAgencia);
                    }
                }

                //  echo $pedidoClienteNuevo['ConteoCliente'];

                if ($pedidoClienteNuevo['ConteoCliente'] > 0) {

                    $Agencia = Consultas::model()->getAgencia($codagencia);

                    $nombreAgencia = $Agencia['Nombre'];

                    // echo $codagencia;
                    //  echo $nombreAgencia;
                    //  die();

                    $this->envioCorreoPedidoClienteNuevo($IdPedido, $codagencia, $nombreAgencia);
                }
            } else {
                print_r($model->getErrors());
            }

            //INSERT DE PEDIDO ALMACENADO
            if (isset($session['EncabezadoPedidoAlamcenado'])) {
                $pedidoAlmacenado = $session['EncabezadoPedidoAlamcenado'];
                $totalesAlamcenados = $session['TotalesAlmacenados'];
                $datosAlmacenados = $session['pedidoFromAlmacenado'];
                $datosKitAlmacenados = $session['componenteKitDinamicoAlmacenado'];

                $TipoVenta = $pedidoAlmacenado['TipoVenta'];
                $FormaPago = $pedidoAlmacenado['FormaPago'];
                $ActividadEspecialAlmacenado = $pedidoAlmacenado['ActividadEspecial'];
                $saldoCupoPedidoAlamcenado = $pedidoAlmacenado['SaldoCupo'];
                $CuentaCliente = $pedidoAlmacenado['CuentaCliente'];

                // conjunto
                if ($TipoVenta == 'Preventa') {

                    $conjunto = '001';
                } else if ($TipoVenta == 'VentaDirecta') {

                    $conjunto = '003';
                } else if ($TipoVenta == 'Consignacion') {

                    $conjunto = '004';
                } else if ($TipoVenta == 'Autoventa') {

                    $conjunto = '002';
                }


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
                foreach ($datosAlmacenados as $itemDatos) {
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
                $ArchivoXml = '';
                $FechaTerminacion = date('Y-m-d');

                $HoraTerminacion = date('H:i:s');
                $EstadoPedido = '0';

                $AutorizaDescuentoEspecial = '0';


                $Web = '1';
                $PedidoMaquina = '0';
                $IdentificadorEnvio = '1';
                $Canal = $session['canalEmpleado'];
                $Responsable = $session['Responsable'];
                if ($Responsable == "" || $Responsable == null) {
                    $Responsable = "";
                }

                if ($FormaPago == 'contado')
                    $FormaPago = 'Contado';
                else {
                    $FormaPago = 'Credito';
                }

                if ($ActividadEspecialAlmacenado == 'si') {
                    $ActividadEspecialAlmacenado = '1';
                    $Estado = '2';
                } elseif ($ActividadEspecialAlmacenado == 'no') {
                    $ActividadEspecialAlmacenado = '0';
                    $Estado = '0';
                }

                if ($FormaPago == 'Credito') {

                    $SaldoActualPedidoAlacenado = $globalsaldo - $ValorPedido;
                    Consultas::model()->getActualizarsaldocupocliente($SaldoActualPedidoAlacenado, $CuentaCliente, $CodZonaVentas);
                }




                $arrayEncabezado = array(
                    'Conjunto' => $conjunto,
                    'CodAsesor' => $pedidoAlmacenado['CodAsesor'],
                    'CodZonaVentas' => $pedidoAlmacenado['CodZonaVentas'],
                    'CuentaCliente' => $pedidoAlmacenado['CuentaCliente'],
                    'CodGrupoVenta' => $pedidoAlmacenado['CodGrupoVenta'],
                    'CodGrupoPrecios' => $pedidoAlmacenado['CodGrupoPrecios'],
                    'Ruta' => trim($pedidoAlmacenado['Ruta']),
                    'CodigoSitio' => $pedidoAlmacenado['CodigoSitio'],
                    'CodigoAlmacen' => $pedidoAlmacenado['CodigoAlmacen'],
                    'FechaPedido' => $pedidoAlmacenado['FechaPedido'],
                    'HoraDigitado' => $pedidoAlmacenado['HoraDigitado'],
                    'HoraEnviado' => $pedidoAlmacenado['HoraEnviado'],
                    'FechaEntrega' => $pedidoAlmacenado['FechaEntrega'],
                    'FormaPago' => $FormaPago,
                    'Plazo' => $pedidoAlmacenado['Plazo'],
                    'TipoVenta' => $TipoVenta,
                    'ActividadEspecial' => $ActividadEspecial,
                    'Observacion' => $pedidoAlmacenado['Observacion'],
                    'NroFactura' => $NroFactura,
                    'ValorPedido' => $ValorPedido,
                    'TotalPedido' => $TotalPedido,
                    'TotalValorIva' => $TotalValorIva,
                    'TotalSubtotalBaseIva' => $TotalSubtotalBaseIva,
                    'TotalValorImpoconsumo' => $TotalValorImpoconsumo,
                    'TotalValorDescuento' => $TotalValorDescuento,
                    'Estado' => $Estado,
                    'ArchivoXml' => $ArchivoXml,
                    'FechaTerminacion' => '0000-00-00',
                    'HoraTerminacion' => '00:00:00',
                    'EstadoPedido' => $EstadoPedido,
                    'AutorizaDescuentoEspecial' => $AutorizaDescuentoEspecial,
                    'Web' => $Web,
                    'PedidoMaquina' => $PedidoMaquina,
                    'IdentificadorEnvio' => $IdentificadorEnvio,
                    'CodigoCanal' => $Canal,
                    'Responsable' => $Responsable,
                    'ExtraRuta' => $session['extraruta'],
                    'Ruta' => $session['clienteSeleccionado']['diaRuta'],
                    'CodigoGrupodeImpuestos' => $pedidoAlmacenado['CodGrupoImpuestos'],
                    'CodigoZonaLogistica' => $pedidoAlmacenado['CodigoZonaLogistica'],
                    'Resolucion' => ''
                );


                $model = new Pedidos;
                $model->attributes = $arrayEncabezado;

                if ($model->validate()) {


                    $model->save();


                    foreach ($datosAlmacenados as $itemDatos) {

                        if (empty($itemDatos['descuentoEspecialAltipal'])) {
                            $itemDatos['descuentoEspecialAltipal'] = "0";
                        }

                        if (empty($itemDatos['descuentoEspecialProveedor'])) {
                            $itemDatos['descuentoEspecialProveedor'] = "0";
                        }

                        if (empty($itemDatos['txtIdAcuerdoLinea'])) {
                            $itemDatos['txtIdAcuerdoLinea'] = "0";
                        }

                        if (empty($itemDatos['txtIdAcuerdoMultilinea'])) {
                            $itemDatos['txtIdAcuerdoMultilinea'] = "0";
                        }

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
                        $txtIdAcuerdoLinea = $itemDatos['txtIdAcuerdoLinea'];
                        $txtIdAcuerdoMultilinea = $itemDatos['txtIdAcuerdoMultilinea'];

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

                        if ($CodigoUnidadMedida == '001') {
                            $NombreUnidadMedida = "Caja";
                        }

                        if ($CodigoUnidadMedida == '002') {
                            $NombreUnidadMedida = "Display";
                        }

                        if ($CodigoUnidadMedida == '003') {
                            $NombreUnidadMedida = "Unidad";
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
                            'Saldo' => (int) $Saldo,
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
                            'NombreUnidadMedida' => $NombreUnidadMedida,
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
                            'CodLote' => "0",
                            'IdAcuerdoPrecioVenta' => $idAcuerdo,
                            'IdAcuerdoLinea' => $txtIdAcuerdoLinea,
                            'IdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea
                        );

                        /* echo  '<pre>';
                          print_r($datosDetalle);
                          exit(); */

                        $modelDetalle = new Descripcionpedido;
                        $modelDetalle->attributes = $datosDetalle;

                        if (!$modelDetalle->validate()) {

                            print_r($modelDetalle->getErrors());
                        } else {

                            $modelDetalle->save();



                            foreach ($datosKitAlmacenados as $itemKit) {



                                if ($CodigoArticulo == $itemKit['txtCodigoArticuloKit']) {


                                    if ($itemKit['txtKitCantidad'] != "") {
                                        $cantidadKit = $itemKit['txtKitCantidad'];
                                    } else {
                                        $cantidadKit = '0';
                                    }


                                    if ($itemKit['txtCantidadItemFijo'] != "" || $itemKit['txtCantidadItemOpcional'] != "") {


                                        $arrayDatosKit = array(
                                            'IdDescripcionPedido' => $modelDetalle->Id,
                                            'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                            'CodigoArticuloComponente' => $itemKit['txtCodigoVarianteComponente'],
                                            'Nombre' => $itemKit['txtNombreKit'],
                                            'CodigoUnidadMedida' => $itemKit['txtNombreUnidad'],
                                            'CodigoTipo' => $itemKit['txtTipo'],
                                            'Fijo' => $itemKit['txtCantidadItemFijo'],
                                            'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                            'Cantidad' => $cantidadKit,
                                            'PrecioVentaBaseVariante' => $itemKit['txtKitPrecioVentaBaseVariante']
                                        );

                                        $modelDetalleKit = new Kitdescripcionpedido;
                                        $modelDetalleKit->attributes = $arrayDatosKit;

                                        if (!$modelDetalleKit->validate()) {

                                            print_r($modelDetalleKit->getErrors());

                                            exit();
                                        } else {
                                            $modelDetalleKit->save();
                                        }
                                    } else {

                                        if ($itemKit['txtKitCantidad'] != "") {
                                            $cantidadKit = $itemKit['txtKitCantidad'];
                                        } else {
                                            $cantidadKit = '0';
                                        }
                                        //$pieces = explode("-", $itemKit['txtCodigoArticulo']);
                                        $arrayDatosKit = array(
                                            'IdDescripcionPedido' => $modelDetalle->Id,
                                            'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                            'CodigoArticuloComponente' => $itemKit['txtCodigoVarianteComponente'],
                                            'Nombre' => $itemKit['txtNombreKit'],
                                            'CodigoUnidadMedida' => $itemKit['txtNombreUnidad'],
                                            'CodigoTipo' => $itemKit['txtTipo'],
                                            'Fijo' => $itemKit['txtCantidadItemFijo'],
                                            'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                            'Cantidad' => $cantidadKit,
                                            'PrecioVentaBaseVariante' => $itemKit['txtKitPrecioVentaBaseVariante']
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
                    }


                    $cordenadas = array(
                        'CuentaCliente' => $pedidoAlmacenado['CuentaCliente'],
                        'IdDocumento' => $model->IdPedido,
                        'Origen' => '1',
                        'Longitud' => $pedidoAlmacenado['longitud'],
                        'Latitud' => $pedidoAlmacenado['latitud'],
                        'Fecha' => $pedidoAlmacenado['FechaPedido'],
                        'Hora' => $pedidoAlmacenado['HoraEnviado'],
                        'CodZonaVentas' => $pedidoAlmacenado['CodZonaVentas'],
                        'CodAsesor' => $pedidoAlmacenado['CodAsesor']
                    );

                    $modeCordenadas = new Coordenadas;
                    $modeCordenadas->attributes = $cordenadas;


                    if (!$modeCordenadas->validate()) {

                        print_r($modeCordenadas->getErrors());
                    } else {

                        $modeCordenadas->save();
                    }


                    if ($ActividadEspecialAlmacenado != '1' && $DsctoEspecial == '0') {

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
                    }

                    if ($DsctoEspecial > 0) {

                        Consultas::model()->getUpdateEstadoDescuento($model->IdPedido);
                        $Agencia = Consultas::model()->getAgencia($codagencia);

                        $nombreAgencia = $Agencia['Nombre'];

                        //Altipal
                        $PedidoAltipal = Consultas::model()->getPedidoAltipal($model->IdPedido);
                        $codGrupoVentas = $PedidoAltipal[0]['CodGrupoVenta'];
                        $this->correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, '', $codagencia, '');

                        //Proveedor
                        $PedidoProveedor = Consultas::model()->getPedidoProveedor($model->IdPedido);
                        $codGrupoVentas = $PedidoProveedor[0]['CodGrupoVenta'];


                        foreach ($PedidoProveedor as $itemproveedor) {

                            $proveedor = $itemproveedor['CuentaProveedor'];

                            $this->correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, $proveedor, $codagencia, $model->IdPedido);
                        }
                    }

                    if ($TipoVenta == 'VentaDirecta') {

                        $correosventadirecta = Consultas::model()->getCorreoVentaDirecta($CuentaProveedor);
                        $Agencia = Consultas::model()->getAgencia($codagencia);

                        $nombreAgencia = $Agencia['Nombre'];

                        $Proveedor = Consultas::model()->getNombreProveedor($CuentaProveedor);
                        $nombreProveedor = $Proveedor['NombreCuentaProveedor'];

                        foreach ($correosventadirecta as $itemCorreoVentasDirecta) {

                            $this->correoVentaDirecta($itemCorreoVentasDirecta['Nombres'], $itemCorreoVentasDirecta['Apellidos'], $itemCorreoVentasDirecta['CorreoElectronico'], $nombreProveedor, $nombreAgencia);
                        }
                    }

                    $pedidoClienteNuevo = Consultas::model()->getConteoClienteNuevoPedido($zonaVentas, $CuentaCliente);
                    //  echo $pedidoClienteNuevo['ConteoCliente'];
                    if ($pedidoClienteNuevo['ConteoCliente'] > 0) {

                        $Agencia = Consultas::model()->getAgencia($codagencia);

                        $nombreAgencia = $Agencia['Nombre'];

                        //  echo $codagencia;
                        // echo $nombreAgencia;
                        //die();


                        $this->envioCorreoPedidoClienteNuevo($IdPedido, $codagencia, $nombreAgencia);
                    }
                }
            }

            unset($session['EncabezadoPedidoAlamcenado']);
            unset($session['pedidoFromAlmacenado']);
            unset($session['TotalesAlmacenados']);
            // $this->PedidoXML($CodZonaVentas);
            //Pedidos::model()->setTransaccionesax($model->IdPedido);


            Yii::app()->user->setFlash('success', "Pedido Guardado Correctamente!");

            $this->redirect('index.php?r=Clientes/ClientesRutas');

            //Restar el valor del pedido del saldo del cliente
            /* if ($FormaPago == 'credito') {

              $nuevoValor = $saldoCupo - $ValorPedido;
              Consultas::model()->actualizarSaldoCupo($CuentaCliente, $CodZonaVentas, $nuevoValor);
              } */
        } else {

            $session = new CHttpSession;
            $session->open();
            $codigoAlmacen = $session['Almacen'];

            $datos = $session['datosCompletarForm'];
            $datos['codigositio'] = $session['codigositio'];
            $datos['codigoAlmacen'] = $codigoAlmacen;
            $session['datosCompletarForm'] = $datos;
            $codigoSitio = $session['codigositio'];
            $ubicacion = $session['Ubicacion'];

            /* echo '<pre> Condincion: '.$codigoAlmacen;
              echo '<br /> Sitios: '.$codigoSitio;
              echo '<br /> ubicacion: '.$ubicacion;
              die(); */

            $condicionPago = Consultas::model()->getCondicionPagoCliente($cliente, $zonaVentas);
            $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas, $codagencia, $codigoSitio);
            //$ubicacion = Preventa::model()->cargarUbicacionZona($zonaVentas); /* Linea posible a eliminar (redundancia de dato)*/
            //$ubicacion = Preventa::model()->cargarUbicacionZonaAlmacen($zonaVentas, $codigoAlmacen, $codigoSitio);
            $formasPago = Preventa::model()->cargarFormasPago($condicionPago['Dias']);

            /* echo '<pre> Condincion:';
              print_r($condicionPago);
              echo '<br /> Sitios:';
              print_r($sitiosVentas);
              echo '<br />Ubicacion:';
              print_r($ubicacion);
              echo '<br />Formas:';
              print_r($formasPago);
              die(); */


            $this->zonaVentas = $zonaVentas;
            $this->cuentaCliente = $cliente;
            $this->codigoSitio = $session['codigositio'];
            $this->codigoAlmacen = $codigoAlmacen;
            $this->ubicacion = $ubicacion;


            if (!$this->cargarPotafolio()) {
                echo $this->txtError;
            } else {
//            if (!$this->cargarVariantesInactivas()) {
//                echo $this->txtError;
//            } else {
//                if (!$this->validarPortafolioVariantesInactivas()) {
//                    echo $this->txtError;
//                } else {
//                    if (!$this->restriccionesProveedor()) {
//                        echo $this->txtError;
//                    } else {
//                        if (!$this->cargarAcuerdoComercialPrecio()) {
//                            echo $this->txtError;
//                        } else {
                Preventa::model()->setCuentaCliente($this->cuentaCliente);

                $this->cargarCodigoGrupoPrecio = Preventa::model()->cargarCargarCodigoGrupoPrecio();

                if (!$this->cargarCodigoGrupoPrecio) {
                    $this->txtError = Preventa::model()->getTxtError;
                } else {
                    $this->codigoGrupoPrecio = Preventa::model()->getDataReader();
                }
                if (!$this->validarPortafolioAcuerdoComercialPrecio()) {
                    echo $this->txtError;
                } else {
                    $this->validarPortafolioImpoconsumo();

                    if (!$this->cargarSaldosPortafolio()) {
                        echo $this->txtError;
                    } else {

                        if (!$this->validarPortafolioSaldos()) {
                            echo $this->txtError;
                        } else {

                            if ($this->validarPortafolioSaldosAutoventa()) {

                                $this->cargarUnidadesConversion = Preventa::model()->cargarUnidadesConversion();


                                if (!$this->cargarUnidadesConversion) {
                                    $this->txtError = Preventa::model()->getTxtError;
                                } else {
                                    $this->unidadesConversion = Preventa::model()->getDataReader();

                                    if (!$this->validarUnidadesPortafolioSaldo()) {
                                        echo $this->txtError;
                                        //exit();
                                    } else {

                                        $this->validarUnidadesPortafolioSaldoAutoventa();

                                        if (!$this->cargarListaMateriales()) {
                                            echo $this->txtError;
                                        } else {
                                            $this->validarPortafolioListaMateriales();
                                            $this->cargarAcuerdosLinea();
                                            $this->cargarAcuerdosMultiLinea();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                //}
                //}
                //}
                //}
            }
            $portafolioPreventa = $this->portafolio;

            $saldoCupoCliente = Consultas::model()->getSaldoRecibosCupo($cliente, $zonaVentas);
            $CodigoGrupoVentas = Consultas::model()->getGrupVentas($zonaVentas);

            /* echo $saldoCupoCliente;
              exit(); */

            $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($zonaVentas);
            $valorMinimo = Consultas::model()->getValorMinimo($cliente);
            $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
            $sitiosConPreventa = Consultas::model()->getSitiosConPreventa($zonaVentas, $codigoSitio, $codagencia);
            $PedidosEnvidosCurdate = Consultas::model()->getPedidoRelizadoActual($cliente);
            $sitios = $sitiosConPreventa['sitios'];

            $session['portafolio'] = $portafolioPreventa;
            /* echo '<pre>';
              print_r($portafolioPreventa);
              die(); */

            $this->render('crearPedido', array('datosCliente' => $datosCliente,
                'zonaVentas' => $zonaVentas,
                'condicionPago' => $condicionPago,
                'sitiosVentas' => $sitiosVentas,
                'portafolioPreventa' => $portafolioPreventa,
                //'portafolioAutoventa' => $portafolioAutoventa,
                'permisosDescuentoEspecial' => $permisosDescuentoEspecial,
                'formasPago' => $formasPago,
                'valorMinimo' => $valorMinimo,
                'saldoCupoCliente' => $saldoCupoCliente,
                'sitios' => $sitios,
                'PedidoEnviados' => $PedidosEnvidosCurdate,
                'GrupoVentas' => $CodigoGrupoVentas['CodigoGrupoVentas']
            ));
        }
    }

    public function correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, $proveedor, $codagencia, $idPedido) {


        ///creo un randon para crear un token para el ingreso de la pagina sin formulario

        /*
         * Create a random string
         * @author Dayron Gaviria
         * @param $length the length of the string to create
         * @return $str the string
         */
        $length = 10;
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters);
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }


        if (empty($proveedor)) {

            //Altiapal  
            $administracionAltipal = Consultas::model()->getAdministradoresConfiguradosAltipal($codGrupoVentas, $codagencia);

            foreach ($administracionAltipal as $admin) {

                $id = $admin['Id'];
                $cedula = $admin['Cedula'];
                $usuario = $admin['Usuario'];
                $clave = $admin['Clave'];
                $nombres = $admin['Nombres'];
                $apellidos = $admin['Apellidos'];
                $email = $admin['Email'];

                if (!empty($email)) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> APROBACI&Oacute;N DE DOCUMENTOS </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Descuento Especial Pendiente Por Aprobaci&oacute;n</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(a) ' . $nombres . '   ' . $apellidos . '  se registro un descuento especial en la agencia de ' . $nombreAgencia . ', el cual se encuentra pendiente para su aprobaci&oacute;n.</i></h4>   
                                        </div>         
                                        <div>  
                                            <h4><i>Recuerde ingresar con su respectivo usuario y contrase&ntilde;a a la plataforma: <a href="http://altipal.datosmovil.info/altipalAx/" target="_blank">Altipal Ax 2015</a>
                                                                para la oportuna aprobaci&oacute;n del documento.</i></h4>
                                        </div>       
                                    </div>
                                    <br>
                                    <div >
                                        <div >
                                            <h5><i>Este correo electr&oacute;nico y cualquier anexo o respuesta relacionada puede contener datos e informaci&oacute;n confidenciales y estar legalmente protegido. En caso de que lo haya recibido por error, por favor hacer caso omiso a este e-mail. No lo lea, copie, imprima o reenv&iacute;e este mensaje o cualquier anexo, o divulgue su(s) contenido(s) a terceros, y b&oacute;rrelo inmediatamente de su sistema. Los mensajes electr&oacute;nicos no son seguros y, por lo tanto, no nos responsabilizaremos por cualquier consecuencia relacionada al uso de este mensaje (inclusive da&ntilde;os causados por cualquier virus). Gracias.</i></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        </div>
                        </div>';

                    $this->enviarCorreo($email, $body);
                }
            }
        } else {

            //Proveedor
            $administracionProveedor = Consultas::model()->getAdministradoresConfiguradosProveedor($codGrupoVentas, $codagencia, $proveedor, $idPedido);

            foreach ($administracionProveedor as $admin) {

                $id = $admin['Id'];
                $cedula = $admin['Cedula'];
                $usuario = $admin['Usuario'];
                $clave = $admin['Clave'];
                $nombres = $admin['Nombres'];
                $apellidos = $admin['Apellidos'];
                $email = $admin['Email'];

                ///voy y agrego el token al usuario

                Consultas::model()->getToken($id, $str);

                if (!empty($email)) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> APROBACI&Oacute;N DE DOCUMENTOS </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Descuento Especial Pendiente Por Aprobaci&oacute;n</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(a) ' . $nombres . '   ' . $apellidos . '  se registro un descuento especial en la agencia de ' . $nombreAgencia . ', el cual se encuentra pendiente para su aprobaci&oacute;n.</i></h4>   
                                        </div>         
                                        <div>  
                                            <h4><i>Recuerde ingresar a la plataforma de seguimiento para la oportuna aprobaci&oacute;n del documento: <a href="http://altipal.datosmovil.info/altipalAx/index.php?r=Site/DescuentosLink&agencia=' . $codagencia . '&grupoVentas=' . $codGrupoVentas . '&IdPedido=' . $idPedido . '&proveedor=' . $proveedor . '&id=' . $id . '&token=' . $str . '" target="_blank">Ver Pedido</a></i></h4>
                                        </div>       
                                    </div>
                                    <br>
                                    <div >
                                        <div >
                                            <h5><i>Este correo electr&oacute;nico y cualquier anexo o respuesta relacionada puede contener datos e informaci&oacute;n confidenciales y estar legalmente protegido. En caso de que lo haya recibido por error, por favor hacer caso omiso a este e-mail, no lea, copie, imprima o reenv&iacute;e este mensaje o cualquier anexo, o divulgue su(s) contenido(s) a terceros, y b&oacute;rrelo inmediatamente de su sistema. Los mensajes electr&oacute;nicos no son seguros y, por lo tanto, no nos responsabilizaremos por cualquier consecuencia relacionada al uso de este mensaje (inclusive da&ntilde;os causados por cualquier virus). Gracias.</i></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        </div>
                        </div>';

                    $this->enviarCorreo($email, $body);
                }
            }
        }
    }

    public function enviarCorreo($email, $body) {


        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->isSMTP();


        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "m1.redsegura.net";
        $mail->Port = 25;
        $mail->Username = 'soporte@activity.com.co';
        $mail->Password = 'tech0304junio';

        $mail->From = 'soporte@activity.com.co';
        $mail->FromName = 'Activity soporte';
        $mail->addAddress($email, 'ALTIPAL S.A');
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = 'Correo Administrativo';
        $mail->Body = utf8_decode($body);
        $mail->AltBody = 'Correo Administrativo';


        if (!$mail->Send()) {
            echo "Mailer Error: ";
        } else {
            echo "OK";
        }
    }

    public function correoVentaDirecta($nombres, $apellidos, $email, $nombreproveedor, $nombreAgencia) {

        if (!empty($email)) {
            $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> Venta Directa </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(a) ' . $nombres . '   ' . $apellidos . '  se registró un pedido de venta directa en la agencia ' . $nombreAgencia . ',  para  el proveedor ' . $nombreproveedor . ', se encuentra pendiente para su aprobación en el sistema  AX2012 </i></h4>   
                                        </div>         
                                        <div>  
                                        </div>       
                                    </div>
                                    <br>
                                    <div >
                                        <div >
                                            <h5><i>Este correo electr&oacute;nico y cualquier anexo o respuesta relacionada puede contener datos e informaci&oacute;n confidenciales y estar legalmente protegido. En caso de que lo haya recibido por error, por favor hacer caso omiso a este e-mail. No lo lea, copie, imprima o reenv&iacute;e este mensaje o cualquier anexo, o divulgue su(s) contenido(s) a terceros, y b&oacute;rrelo inmediatamente de su sistema. Los mensajes electr&oacute;nicos no son seguros y, por lo tanto, no nos responsabilizaremos por cualquier consecuencia relacionada al uso de este mensaje (inclusive da&ntilde;os causados por cualquier virus). Gracias.</i></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        </div>
                  </div>';

            $this->enviarCorreo($email, $body);
        }
    }

    private function cargarRestriccionesProveedor() {


        try {
            $this->cargarRestriccionesProveedor = Preventa::model()->cargarRestriccionesProveedores();

            if (!$this->cargarRestriccionesProveedor) {
                $this->txtError = "No se ha realizado la carga de las restricciones proveedores " . Preventa::model()->getTxtError();
                return false;
            } else {
                $this->restriccionesproveedores = Preventa::model()->getDataReader();
                return true;
            }
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function restriccionesProveedor() {


        try {

            $contRestriccionProveedor = 0;


            $zonaventas = $this->zonaVentas;
            $cuentaCliente = $this->cuentaCliente;

            foreach ($this->portafolio as $ItemPortafolio) {


                $codigoVariante = $ItemPortafolio['CodigoVariante'];
                $CodigoGrupoCategoria = $ItemPortafolio['CodigoGrupoCategoria'];
                $CuentaProveedor = $ItemPortafolio['CuentaProveedor'];
                $txtVarianteRestringida = '';

                $this->cargarRestriccionesProveedor();
                $busqueda = false;

                foreach ($this->restriccionesproveedores as $itemrestriccionesProveedores) {

                    $txtvIncCodVariante = $itemrestriccionesProveedores['CodigoVariante'];
                    $txtvlnCodigoArticuloGrupoCategoria = $itemrestriccionesProveedores['CodigoArticuloGrupoCategoria'];
                    $txtvlnCuentaProveedor = $itemrestriccionesProveedores['CuentaProveedor'];


                    if (!$busqueda) {

                        $restriccionesArticulo = Consultas::model()->getRestriccionesProveedorArticulo($cuentaCliente, $zonaventas, $codigoVariante);
                        $restriccionesArticulo = $restriccionesArticulo['Total'];

                        if ($restriccionesArticulo > '0') {

                            if ($codigoVariante == $txtvIncCodVariante) {

                                $txtVarianteRestringida = '1';
                                $busqueda = true;
                            }
                        }

                        $restriccionesGrupo = Consultas::model()->getRestriccionesProveedorGrupo($cuentaCliente, $zonaventas, $CodigoGrupoCategoria);
                        $restriccionesGrupo = $restriccionesGrupo['Total'];

                        if ($restriccionesGrupo > '0') {

                            if ($CodigoGrupoCategoria == $txtvlnCodigoArticuloGrupoCategoria) {

                                $txtVarianteRestringida = '2';
                                $busqueda = true;
                            }
                        }


                        $restriccionesProveedor = Consultas::model()->getRestriccionesProveedor($cuentaCliente, $zonaventas, $CuentaProveedor);
                        $restriccionesProveedor = $restriccionesProveedor['Total'];

                        if ($restriccionesProveedor > '0') {

                            if ($CuentaProveedor == $txtvlnCuentaProveedor) {

                                $txtVarianteRestringida = '3';
                                $busqueda = true;
                            }
                        }
                    }
                }

                $this->portafolio[$contRestriccionProveedor]['RestriccionProveedor'] = $txtVarianteRestringida;

                $contRestriccionProveedor++;
            }

            return true;
        } catch (Exception $exc) {

            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function actionAjaxGetTipoSaldo() {

        $session = new CHttpSession;
        $session->open();
        unset($session['tipoInventario']);
        $session['tipoInventario'] = $_POST['saldoInventario'];
        echo '1';
    }

    public function actionAjaxGetProveedor() {

        $session = new CHttpSession;
        $session->open();
        unset($session['proveedor']);
        $session['proveedor'] = $_POST['cuentaproveedor'];
        echo '1';
    }

    public function actionAjaxCalcularSaldoKitVirtual() {

        if ($_POST) {

            $codigoListaMateriales = $_POST['codigoListaMateriales'];
            $codigoArticuloKit = $_POST['codigoArticuloKit'];
            $cuentaCliente = $_POST['cuentaCliente'];
            $codigoUnidadMedida = $_POST['codigoUnidadMedida'];

            $componenteKid = Consultas::model()->getComponentesKit($codigoListaMateriales, $codigoArticuloKit);

            /* echo '<pre>';
              print_r($componenteKid);
              exit(); */


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
                    if ($desde != $hasta) {
                        $cantidadConvertida = $this->calcularUnidadesConversion($saldo, $codigoArticulo, $desde, $hasta);
                    } else {
                        $cantidadConvertida = $saldo;
                    }

                    $datos = array('encabezado' => $encabezadoKit);
                    $datos['detalle'] = $componenteKid;
                    $datos['saldo'] = $cantidadConvertida;


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

            echo $codigoVariante;
            echo $cuentaCliente;
            echo $zonaventas;

            $session = new CHttpSession;
            $session->open();
            $codigoSitio = $session['codigositio'];
            $codigoAlmacen = $session['Almacen'];

            echo $codigoSitio;
            echo $codigoAlmacen;

            $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProduto($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);

            /* echo '<pre>';
              print_r($productoAcuerdoComercialProducto); */


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

            //echo $session['codigositio'].'</br>';
            //echo $session['Almacen'];

            $codigoVariante = $_POST['txtCodigoVariante'];
            $cuentaCliente = $_POST['txtClienteDetalle'];
            $CodigoUnidadMedida = $_POST['txtUnidadMedida'];
            $articulo = $_POST['txtArticulo'];
            $zonaventas = $_POST['txtZonaVenta'];

            echo $codigoSitio . '<br/>';
            echo $codigoAlmacen . '</br>';
            echo $codigoVariante . '</br>';
            echo $cuentaCliente . '</br>';
            echo $CodigoUnidadMedida . '</br>';
            echo $articulo . '</br>';
            echo $zonaventas . '</br>';


            $ACDLClienteArticuloSaldo = Consultas::model()->getACDLClienteArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen);

            if ($ACDLClienteArticuloSaldo) {

                $resultado = array(
                    'IdAcuerdo' => $ACDLClienteArticuloSaldo['Id'],
                    'LimiteVentas' => $ACDLClienteArticuloSaldo['LimiteVentas'],
                    'Saldo' => $ACDLClienteArticuloSaldo['Saldo'],
                    'SaldoSinConversion' => $ACDLClienteArticuloSaldo['Saldo'],
                    'NombreUnidadMedidaSaldoLimite' => $ACDLClienteArticuloSaldo['NombreUnidadMedida'],
                    'CodigoUnidadMedida' => $ACDLClienteArticuloSaldo['CodigoUnidadMedida'],
                    'PorcentajeDescuentoLinea1' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLinea1'],
                    'PorcentajeDescuentoLinea2' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLinea2']
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
                        'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteArticuloSaldo['PorcentajeDescuentoLinea1'],
                        'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteArticuloSaldo['PorcentajeDescuentoLinea2']
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
                            'PorcentajeDescuentoLinea1' => $ACDLClienteGrupoArticuloSaldo['PorcentajeDescuentoLinea1'],
                            'PorcentajeDescuentoLinea2' => $ACDLClienteGrupoArticuloSaldo['PorcentajeDescuentoLinea2']
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
                                'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteGrupoArticuloSaldo['PorcentajeDescuentoLinea1'],
                                'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteGrupoArticuloSaldo['PorcentajeDescuentoLinea2']
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
                                    'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteArticuloSinSitioSaldo['PorcentajeDescuentoLinea1'],
                                    'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteArticuloSinSitioSaldo['PorcentajeDescuentoLinea2']
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
                                        'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['PorcentajeDescuentoLinea1'],
                                        'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['PorcentajeDescuentoLinea2']
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
        $nombreUnidadMedida = $_POST['nombreUnidadMedida'];
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
        $txtCodigoGrupoArticulosDescuentoMultilinea = $_POST['txtCodigoGrupoArticulosDescuentoMultilinea'];
        $txtIdAcuerdoLinea = $_POST['txtIdAcuerdoLinea'];
        $txtIdAcuerdoMultilinea = $_POST['txtIdAcuerdoMultilinea'];
        $txtlote = $_POST['txtlote'];
        $txtCuentaCliente = $_POST['txtClienteDetalle'];
        $txtCodigoGrupoClienteDescuentoMultilinea = $_POST['txtCodigoGrupoClienteDescuentoMultilinea'];
        $txtCodigoGrupoClienteDescuentoLinea = $_POST['txtCodigoGrupoArticulosDescuentoLinea'];
        $txtCodigoGrupoDescuentoLinea = $_POST['txtCodigoGrupoDescuentoLinea'];
        $txtValorConInpuesto = $_POST['txtValorConInpuesto'];

        if ($descuentoEspecialSelect == 'Proveedor') {
            $descuentoEspecialProveedor = $descuentoEspecial;
        } else {
            $descuentoEspecialProveedor = $_POST['descuentoEspecialProveedor'];
        }

        if ($descuentoEspecialSelect == 'Altipal') {
            $descuentoEspecialAltipal = $descuentoEspecial;
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
                'nombreUnidadMedida' => $nombreUnidadMedida,
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
                'aplicaImpoconsumo' => $aplicaImpoconsumo,
                'txtCodigoGrupoArticulosDescuentoMultilinea' => $txtCodigoGrupoArticulosDescuentoMultilinea,
                'txtIdAcuerdoLinea' => $txtIdAcuerdoLinea,
                'txtIdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea,
                'txtlote' => $txtlote,
                'txtCuentaCliente' => $txtCuentaCliente,
                'txtCodigoGrupoClienteDescuentoMultilinea' => $txtCodigoGrupoClienteDescuentoMultilinea,
                'txtCodigoGrupoDescuentoLinea' => $txtCodigoGrupoDescuentoLinea
            );


            $Cantidad = $cantidad - $saldoLimite;

            $DescuantoLinea = $this->ValidarAcuerdoLinea($variante, $txtCodigoGrupoClienteDescuentoLinea, $txtCuentaCliente, $txtCodigoGrupoDescuentoLinea, $Cantidad, $codigoArticulo, $codigoUnidadMedida);

            /* echo '<pre>';
              print_r($DescuantoLinea); */

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
                'nombreUnidadMedida' => $nombreUnidadMedida,
                'variante' => $variante,
                'valorUnitario' => $valorUnitario,
                'impoconsumo' => $impoconsumo,
                'cantidad' => ($cantidad - $saldoLimite),
                'descuentoProveedor' => $DescuantoLinea['descuentoLinea'],
                'descuentoAltipal' => $descuentoAltipal,
                'descuentoEspecial' => $descuentoEspecial,
                'iva' => $iva,
                'descuentoEspecialSelect' => $descuentoEspecialSelect,
                'descuentoEspecialProveedor' => $descuentoEspecialProveedor,
                'descuentoEspecialAltipal' => $descuentoEspecialAltipal,
                'cuentaProveedor' => $cuentaProveedor,
                'aplicaImpoconsumo' => $aplicaImpoconsumo,
                'txtCodigoGrupoArticulosDescuentoMultilinea' => $txtCodigoGrupoArticulosDescuentoMultilinea,
                'txtIdAcuerdoLinea' => $DescuantoLinea['acuerdoComercial'],
                'txtIdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea,
                'txtlote' => $txtlote,
                'txtCuentaCliente' => $txtCuentaCliente,
                'txtCodigoGrupoClienteDescuentoMultilinea' => $txtCodigoGrupoClienteDescuentoMultilinea,
                'txtCodigoGrupoDescuentoLinea' => $txtCodigoGrupoDescuentoLinea
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
                'nombreUnidadMedida' => $nombreUnidadMedida,
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
                'aplicaImpoconsumo' => $aplicaImpoconsumo,
                'txtCodigoGrupoArticulosDescuentoMultilinea' => $txtCodigoGrupoArticulosDescuentoMultilinea,
                'txtIdAcuerdoLinea' => $txtIdAcuerdoLinea,
                'txtIdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea,
                'txtlote' => $txtlote,
                'txtCuentaCliente' => $txtCuentaCliente,
                'txtCodigoGrupoClienteDescuentoMultilinea' => $txtCodigoGrupoClienteDescuentoMultilinea,
                'txtValorConInpuesto' => $txtValorConInpuesto
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

                //RECALCULAR DESCUENTO DE LINEA
                $gruposMultilinea = array();

                foreach ($datos as $itemDatos) {

                    $txtCodigoGrupoArticulosDescuentoMultilinea = $itemDatos['txtCodigoGrupoArticulosDescuentoMultilinea'];
                    $variante = $itemDatos['variante'];
                    $codigoUnidadMedida = $itemDatos['codigoUnidadMedida'];
                    $articulo = $itemDatos['articulo'];
                    $txtCuentaCliente = $itemDatos['txtCuentaCliente'];
                    $cantidad = $itemDatos['cantidad'];
                    $txtValorConInpuesto = $itemDatos['txtValorConInpuesto'];
                    $valorUnitario = $itemDatos['valorUnitario'];
                    $txtCodigoGrupoClienteDescuentoMultilinea = $itemDatos['txtCodigoGrupoClienteDescuentoMultilinea'];

                    $cont = 0;
                    $acomu = 0;
                    $busquedaDato = false;

                    if (isset($txtCodigoGrupoArticulosDescuentoMultilinea)) {
                        foreach ($datos as $itemDatosII) {

                            $txtCodigoGrupoArticulosDescuentoMultilineaII = $itemDatosII['txtCodigoGrupoArticulosDescuentoMultilinea'];
                            $cantidadII = $itemDatosII['cantidad'];

                            if ($txtCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoArticulosDescuentoMultilineaII) {

                                $acomu+=$cantidadII;
                                $busquedaDato = true;
                                $cont++;
                            }
                        }

                        if ($busquedaDato) {
                            $itemAgregar = array(
                                "variante" => $variante,
                                "txtCodigoGrupoArticulosDescuentoMultilinea" => $txtCodigoGrupoArticulosDescuentoMultilinea,
                                "cantidad" => $acomu,
                                "codigoUnidadMedida" => $codigoUnidadMedida,
                                "articulo" => $articulo,
                                "txtCuentaCliente" => $txtCuentaCliente,
                                "txtCodigoGrupoClienteDescuentoMultilinea" => $txtCodigoGrupoClienteDescuentoMultilinea,
                                "total" => $cont
                            );

                            array_push($gruposMultilinea, $itemAgregar);
                        }
                    }
                }


                foreach ($gruposMultilinea as $item) {

                    $itemTxtCodigoVariante = $item['variante'];
                    $itemTxtCodigoGrupoDescuentoMultiLinea = $item['txtCodigoGrupoArticulosDescuentoMultilinea'];
                    $itemTxtCantidad = $item['cantidad'];
                    $itemTxtUnidadMedida = $item['codigoUnidadMedida'];
                    $itemTxtCodigoArticulo = $item['articulo'];
                    $itemTxtCuantaCliente = $item['txtCuentaCliente'];
                    $itemTxtCodigoGrupoClienteDescuentoMultilinea = $item['txtCodigoGrupoClienteDescuentoMultilinea'];

                    $datosBusquedaArray = $this->validarAcuerdoMultiLinea($itemTxtCodigoVariante, $itemTxtCodigoGrupoDescuentoMultiLinea, $itemTxtCantidad, $itemTxtUnidadMedida, $itemTxtCodigoArticulo, $itemTxtCuantaCliente, $itemTxtCodigoGrupoClienteDescuentoMultilinea);

                    $cont = 0;
                    foreach ($datos as $itemDatos) {

                        $variante = $itemDatos['CodigoGrupoArticulosDescuentoMultilinea'];

                        if ($itemTxtCodigoVariante == $variante) {
                            $datos[$cont]['descuentoAltipal'] = $datosBusquedaArray['descuentoMultiLinea'];
                            $datos[$cont]['txtCodigoGrupoArticulosDescuentoMultilinea'] = $datosBusquedaArray['CodigoGrupoArticulosDescuentoMultilinea'];
                        }

                        $cont++;
                    }
                }

                $session['pedidoForm'] = $datos;
            }

            Yii::import('application.extensions.pedido.Pedido');
            $pedido = new Pedido();
            $pedido->getCalcularTotales();
//            print_r($session['pedidoForm']);
//            die();
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

        foreach ($datos as $itemDatos) {
            $variante = $itemDatos['variante'];
        }

        echo $variante;
    }

    public function actionAjaxComponentesKitDinamico() {

        $post_text = trim(file_get_contents('php://input'));
        $componenetesKid = CJSON::decode($post_text);

        echo $this->renderPartial('_componenetesKidDinamico', array('componenetesKid' => $componenetesKid), true);
    }

    public function actionAjaxGuardarKitDinamico() {

        $session = new CHttpSession;
        $session->open();

        $kitDinamico = json_decode($_POST['kitDinamico']);

        if (count($kitDinamico) > 0) {
            $session['componenteKitDinamicoActivity'] = $kitDinamico;
        } else if ($_POST['kd'] == 2) {

            $datosArray = array(
                'txtCodigoArticuloKit' => $txtCodigoArticuloKit,
                'txtCodigoLista' => $txtCodigoLista,
                'txtCodigoArticulo' => $txtCodigoArticulo,
                'txtNombreKit' => $txtNombreKit,
                'txtUnidadKit' => $txtUnidadKit,
                'txtTipo' => $txtTipo,
                'txtCantidadItemFijo' => $txtCantidadItemFijo,
                'txtCantidadItemOpcional' => $txtCantidadItemOpcional,
                'txtKitCantidad' => $textKitCantidad,
                'txtKitPrecioVentaBaseVariante' => $txtKitPrecioVentaBaseVariante,
                'txtCodigoVarianteComponente' => $txtKitCodigoVarianteComponente,
                'txtNombreUnidad' => $txtKitNombreUnidadMedida
            );

            $arrayBusqueda = FALSE;
            foreach ($datosKit as $clave => $item) {
                if (
                        $item['txtCodigoLista'] == $txtCodigoLista &&
                        $item['txtCodigoArticulo'] == $txtCodigoArticulo &&
                        $item['txtCantidadItemFijo'] == $txtCantidadItemFijo &&
                        $item['txtCantidadItemOpcional'] == $txtCantidadItemOpcional &&
                        $item['txtTipo'] == $txtTipo &&
                        $item['txtNombreKit'] == $txtNombreKit
                ) {
                    $datosKit[$clave] = $datosArray;
                    $arrayBusqueda = TRUE;
                }
            }

            if (!$arrayBusqueda) {
                array_push($datosKit, $datosArray);
            }

            $session['componenteKitDinamico'] = $datosKit;

            /* echo '<pre>';
              print_r($datosKit);
              echo '</pre>'; */
        }
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

        /* echo '<pre>';
          print_r($portafolioZonaVentas);
          echo '</pre>';
          die(); */

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

    /*
     * Cargar portafolio
     */

    private function cargarPotafolio() {

        try {

            $session = new CHttpSession;
            $session->open();

            $ubicacion = $session['Ubicacion'];

            Preventa::model()->setZonaVentas($this->zonaVentas);
            $this->cargarPortafolio = Preventa::model()->cargarPortafolio();

            if (!$this->cargarPortafolio) {
                $this->txtError = "No se ha realizado la carga del portafolio";
                return false;
            } else {
                $this->portafolio = Preventa::model()->getDataReader();

                /* echo '<pre>';
                  print_r($this->portafolio);
                  echo '</pre>';
                  exit(); */

                if (!$this->validarPortafolio()) {
                    return false;
                }
                return true;
            }
        } catch (Exception $exc) {
            echo $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarPortafolio() {

        try {

            $cont = 0;
            foreach ($this->portafolio as $itemPortafolio) {

                $txtCodigoCaracteristica1 = $itemPortafolio['CodigoCaracteristica1'];
                $txtCodigoCaracteristica2 = $itemPortafolio['CodigoCaracteristica2'];

                if ($txtCodigoCaracteristica1 == "N/A") {
                    $this->portafolio[$cont]['CodigoCaracteristica1'] = "";
                }

                if ($txtCodigoCaracteristica2 == "N/A") {
                    $this->portafolio[$cont]['CodigoCaracteristica2'] = "";
                }

                $cont++;
            }

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function cargarAcuerdoComercialPrecio($CodVariante) {

        try {
            $this->cargarAcuerdoComercialPrecio = Preventa::model()->cargarAcuerdosComerciales($CodVariante);

            if (!$this->cargarAcuerdoComercialPrecio) {
                $this->txtError = "No se ha realizado la carga de los acuerdos comerciales " . Preventa::model()->getTxtError();
                return false;
            } else {
                $this->acuerdoComercialPrecio = Preventa::model()->getDataReader();
                return true;
            }
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function cargarVariantesInactivas($Codvariante) {


        try {
            $this->cargarVariantesInactivas = Preventa::model()->cargarVariantesInactivas($Codvariante);

            if (!$this->cargarVariantesInactivas) {
                $this->txtError = "No se ha realizado la carga de la vrairntes inactvias " . Preventa::model()->getTxtError();
                return false;
            } else {
                $this->variantesInactivas = Preventa::model()->getDataReader();
                return true;
            }
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarPortafolioVariantesInactivas() {

        try {

            $contInactivas = 0;


            foreach ($this->portafolio as $ItemPortafolio) {


                $txtPortafolioVariante = $ItemPortafolio['CodigoVariante'];
                $txtVarianteIncativa = '';


                $busqueda = false;
                $this->cargarVariantesInactivas($txtPortafolioVariante);

                foreach ($this->variantesInactivas as $itemvarientesinactivas) {


                    $txtvIncCodigoSitio = $itemvarientesinactivas['CodigoSitio'];
                    $txtvInCodAlmacen = $itemvarientesinactivas['CodigoAlmacen'];
                    $txtvIncCodVariante = $itemvarientesinactivas['CodigoVariante'];

                    if (!$busqueda) {

                        if ($txtvIncCodigoSitio == $this->codigoSitio && $txtvInCodAlmacen == 'EMPTY') {

                            if ($txtPortafolioVariante == $txtvIncCodVariante) {

                                $txtVarianteIncativa = '1';
                                $busqueda = true;
                            }
                        }

                        if ($txtvIncCodigoSitio == 'EMPTY' && $txtvInCodAlmacen == 'EMPTY') {

                            if ($txtPortafolioVariante == $txtvIncCodVariante) {

                                $txtVarianteIncativa = '2';
                                $busqueda = true;
                            }
                        }

                        if ($txtvIncCodigoSitio == $this->codigoSitio && $txtvInCodAlmacen == $this->codigoAlmacen) {

                            if ($txtPortafolioVariante == $txtvIncCodVariante) {

                                $txtVarianteIncativa = '3';
                                $busqueda = true;
                            }
                        }
                    }
                }

                $this->portafolio[$contInactivas]['VarianteInactiva'] = $txtVarianteIncativa;

                $contInactivas++;
            }


            return true;
        } catch (Exception $exc) {

            $this->txtError = $exc->getTraceAsString();
            return false;
        }


        //exit(); 
    }

    private function validarPortafolioAcuerdoComercialPrecio() {

        try {

            $cont = 0;
            $fechaActual = date('Y-m-d');


            foreach ($this->portafolio as $itemPortafolio) {

                $txtPorCodigoVariante = $itemPortafolio['CodigoVariante'];

                $txtPorPrecioVariante = '';
                $txtPorIdAcuerdoComercial = '';
                $txtPorCodigoUnidadMedida = '';
                $txtPorNombreUnidadMedida = '';

                $busqueda = false;
                $fechaBusqueda = '0000-00-00';
                $ordenBusquda = 0;
                $this->cargarAcuerdoComercialPrecio($itemPortafolio['CodigoVariante']);

                //echo $txtPorCodigoVariante.'<br>';
                //echo '<pre>';
                //print_r($this->acuerdoComercialPrecio);


                foreach ($this->acuerdoComercialPrecio as $itemAcuerdo) {

                    $txtAcCodigoVariante = $itemAcuerdo['CodigoVariante'];
                    $txtAcTipoCuentaCliente = $itemAcuerdo['TipoCuentaCliente'];
                    $txtAcCuentaCliente = $itemAcuerdo['CuentaCliente'];
                    $txtAcCodigoGrupoPrecio = $itemAcuerdo['CodigoGrupoPrecio'];
                    $txtAcPrecioVenta = $itemAcuerdo['PrecioVenta'];
                    $txtAcIdAcuerdoComercial = $itemAcuerdo['IdAcuerdoComercial'];
                    $txtAcCodigoUnidadMedida = $itemAcuerdo['CodigoUnidadMedida'];
                    $txtAcNombreUnidadMedida = $itemAcuerdo['NombreUnidadMedida'];
                    $txtAcFechaInicio = $itemAcuerdo['FechaInicio'];
                    $txtAcFechaTermina = $itemAcuerdo['FechaTermina'];
                    $txtAcCodigoSitio = $itemAcuerdo['Sitio'];
                    $txtAcCodigoAlmacen = $itemAcuerdo['Almacen'];

                    if (!$busqueda) {

                        if ($txtAcFechaTermina == '0000-00-00') {

                            //CON SITIO Y CON ALMACEN  TIPO CLIENTE 1
                            if ($txtAcTipoCuentaCliente == "1" &&
                                    $txtAcCuentaCliente == $this->cuentaCliente &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $txtAcCodigoSitio == $this->codigoSitio &&
                                    $txtAcCodigoAlmacen == $this->codigoAlmacen
                            ) {

                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 1;
                            }

                            ///CON SITIO Y SIN ALMACEN  TIPO CLIENTE 1  
                            if ($txtAcTipoCuentaCliente == "1" &&
                                    $txtAcCuentaCliente == $this->cuentaCliente &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $txtAcCodigoSitio == $this->codigoSitio
                            ) {

                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 1;
                            }

                            ///SIN SITIO Y SIN ALMACEN  TIPO CLIENTE 1 
                            if ($txtAcTipoCuentaCliente == "1" &&
                                    $txtAcCuentaCliente == $this->cuentaCliente &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio
                            ) {

                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 1;
                            }

                            //CON SITIO Y CON ALMACEN  TIPO CLIENTE 2
                            if ($txtAcTipoCuentaCliente === "2" &&
                                    $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $txtAcCodigoSitio == $this->codigoSitio &&
                                    $txtAcCodigoAlmacen == $this->codigoAlmacen
                            ) {

                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 2;
                            }

                            //CON SITIO Y SIN ALMACEN  TIPO CLIENTE 2
                            if ($txtAcTipoCuentaCliente === "2" &&
                                    $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $txtAcCodigoSitio == $this->codigoSitio
                            ) {

                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 2;
                            }

                            //SIN SITIO Y SIN ALMACEN  TIPO CLIENTE 2
                            if ($txtAcTipoCuentaCliente === "2" &&
                                    $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio
                            ) {

                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 2;
                            }
                        } else {

                            ///CON FECHAS INICIO Y FIN 
                            //CON SITIO Y CON ALMACEN TIPO CLIENTE 1
                            if ($txtAcTipoCuentaCliente == "1" &&
                                    $txtAcCuentaCliente == $this->cuentaCliente &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $fechaActual <= $txtAcFechaTermina &&
                                    $txtAcCodigoSitio == $this->codigoSitio &&
                                    $txtAcCodigoAlmacen == $this->codigoAlmacen
                            ) {
                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 1;
                            }

                            //CON SITIO Y SIN ALMACEN TIPO CLIENTE 1
                            if ($txtAcTipoCuentaCliente == "1" &&
                                    $txtAcCuentaCliente == $this->cuentaCliente &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $fechaActual <= $txtAcFechaTermina &&
                                    $txtAcCodigoSitio == $this->codigoSitio
                            ) {
                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 1;
                            }

                            //SIN  SITIO Y SIN ALMACEN TIPO CLIENTE 1
                            if ($txtAcTipoCuentaCliente == "1" &&
                                    $txtAcCuentaCliente == $this->cuentaCliente &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $fechaActual <= $txtAcFechaTermina
                            ) {
                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 1;
                            }

                            //CON SITIO Y CON ALMACEN TIPO CLIENTE 2
                            if ($txtAcTipoCuentaCliente === "2" &&
                                    $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $fechaActual <= $txtAcFechaTermina &&
                                    $txtAcCodigoSitio == $this->codigoSitio &&
                                    $txtAcCodigoAlmacen == $this->codigoAlmacen
                            ) {
                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 2;
                            }


                            //CON SITIO Y SIN ALMACEN TIPO CLIENTE 2
                            if ($txtAcTipoCuentaCliente === "2" &&
                                    $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                    $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                    $fechaActual >= $txtAcFechaInicio &&
                                    $fechaActual <= $txtAcFechaTermina &&
                                    $txtAcCodigoSitio == $this->codigoSitio
                            ) {
                                $txtPorPrecioVariante = $txtAcPrecioVenta;
                                $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                $busqueda = true;
                                $fechaBusqueda = $txtAcFechaInicio;
                                $ordenBusquda = 2;
                            }
                        }
                    }
                }


                $this->portafolio[$cont]['ACPrecioVenta'] = $txtPorPrecioVariante;
                $this->portafolio[$cont]['ACIdAcuerdoComercial'] = $txtPorIdAcuerdoComercial;
                $this->portafolio[$cont]['ACCodigoUnidadMedida'] = $txtPorCodigoUnidadMedida;
                $this->portafolio[$cont]['ACNombreUnidadMedida'] = $txtPorNombreUnidadMedida;


                $cont++;
            }
            //exit();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarPortafolioImpoconsumo() {

        try {

            $cont = 0;
            foreach ($this->portafolio as $itemPortafolio) {

                $txtValorImpoconsumo = $itemPortafolio['ValorIMPOCONSUMO'];
                $itemPorACCodigoUnidadMedida = $itemPortafolio['ACCodigoUnidadMedida'];
                $CodigoArticulo = $itemPortafolio['CodigoArticulo'];



                if ($txtValorImpoconsumo > 0) {
                    if ($itemPorACCodigoUnidadMedida != '003' && $itemPorACCodigoUnidadMedida != "") {
                        $this->codigoArticulo = $CodigoArticulo;
                        $this->validateAcuerdo($itemPorACCodigoUnidadMedida, '003', $txtValorImpoconsumo);
                        if ($this->cantidadConvertida != "") {
                            $this->portafolio[$cont]['ValorIMPOCONSUMO'] = $this->cantidadConvertida;
                        } else {
                            $this->portafolio[$cont]['ValorIMPOCONSUMO'] = '0';
                        }
                    }
                }
                $cont++;
            }

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return true;
        }
    }

    private function cargarSaldosPortafolio() {


        try {
            Preventa::model()->setCodigoSitio($this->codigoSitio);
            Preventa::model()->setCodigoAlmacen($this->codigoAlmacen);
            //$this->ubicacion = Yii::app()->user->_cedula;
            Preventa::model()->setUbicacion($this->ubicacion);

            if (!Preventa::model()->cargarSaldoInventarioPreventa()) {
                $this->txtError = Preventa::model()->getTxtError;
                return false;
            } else {
                $this->saldoPreventa = Preventa::model()->getDataReader();
            }

            /* echo '<pre>';
              print_r($this->saldoPreventa);
              die(); */

            if (!Preventa::model()->cargarSaldoInventarioAutoventa()) {
                $this->txtError = Preventa::model()->getTxtError;
                return false;
            } else {
                $this->saldoAutoventa = Preventa::model()->getDataReader();
            }

            return true;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
            exit();
            return false;
        }
    }

    private function validarPortafolioSaldos() {

        try {

            $cont = 0;

            foreach ($this->portafolio as $item) {

                $codigoVariante = $item['CodigoVariante'];
                $codigoArticulo = $item['CodigoArticulo'];

                $codigoTipo = $item['CodigoTipo'];

                $saldoId = '';
                $saldoItemPortafolio = '';
                $saldoNombreUnidadMedida = '';
                $saldoCodigoUnidadMedida = '';

                $this->cargarListaMateriales($codigoVariante);

                if ($codigoTipo != "KV" && $codigoTipo != "KD") {

                    foreach ($this->saldoPreventa as $itemSaldos) {

                        $saldoPrevId = $itemSaldos['Id'];
                        $saldoPrevCodigoSitio = $itemSaldos['CodigoSitio'];
                        $saldoPrevNombreSitio = $itemSaldos['NombreSitio'];
                        $saldoPrevCodigoAlmacen = $itemSaldos['CodigoAlmacen'];
                        $saldoPrevCodigoVariante = $itemSaldos['CodigoVariante'];
                        $saldoPrevCodigoArticulo = $itemSaldos['CodigoArticulo'];
                        $saldoPrevCodigoCaracteristica1 = $itemSaldos['CodigoCaracteristica1'];
                        $saldoPrevCodigoCaracteristica2 = $itemSaldos['CodigoCaracteristica2'];
                        $saldoPrevCodigoTipo = $itemSaldos['CodigoTipo'];
                        $saldoPrevCodigoUnidadMedida = $itemSaldos['CodigoUnidadMedida'];
                        $saldoPrevNombreUnidadMedida = $itemSaldos['NombreUnidadMedida'];
                        $saldoPrevDisponible = $itemSaldos['Disponible'];

                        $busqueda = false;

                        if ($codigoVariante == $saldoPrevCodigoVariante) {

                            $saldoId = $saldoPrevId;
                            $saldoItemPortafolio = $saldoPrevDisponible;
                            $saldoNombreUnidadMedida = $saldoPrevNombreUnidadMedida;
                            $saldoCodigoUnidadMedida = $saldoPrevCodigoUnidadMedida;

                            $busqueda = true;
                            break;
                        }
                    }

                    $this->portafolio[$cont]['SPDisponible'] = $saldoId;
                    $this->portafolio[$cont]['SPDisponible'] = $saldoItemPortafolio;
                    $this->portafolio[$cont]['SPNombreUnidadMedida'] = $saldoNombreUnidadMedida;
                    $this->portafolio[$cont]['SPCodigoUnidadMedida'] = $saldoCodigoUnidadMedida;
                } else {

                    $saldoComponente = 99999999;
                    $saldoItemPortafolio = 0;

                    foreach ($this->listaMateriales as $itemLista) {

                        $saldoItemPortafolio = 0;
                        $codigoVarianteComponente = $itemLista['LMDCodigoVarianteComponente'];
                        $LMCodigoVarianteKit = $itemLista['LMCodigoVarianteKit'];
                        $LMTotalPrecioVentaListaMateriales = $itemLista['LMTotalPrecioVentaListaMateriales'];

                        if ($codigoVariante == $LMCodigoVarianteKit) {

                            foreach ($this->saldoPreventa as $itemSaldos) {

                                $saldoPrevId = $itemSaldos['Id'];
                                $saldoPrevCodigoSitio = $itemSaldos['CodigoSitio'];
                                $saldoPrevNombreSitio = $itemSaldos['NombreSitio'];
                                $saldoPrevCodigoAlmacen = $itemSaldos['CodigoAlmacen'];
                                $saldoPrevCodigoVariante = $itemSaldos['CodigoVariante'];
                                $saldoPrevCodigoArticulo = $itemSaldos['CodigoArticulo'];
                                $saldoPrevCodigoCaracteristica1 = $itemSaldos['CodigoCaracteristica1'];
                                $saldoPrevCodigoCaracteristica2 = $itemSaldos['CodigoCaracteristica2'];
                                $saldoPrevCodigoTipo = $itemSaldos['CodigoTipo'];
                                $saldoPrevCodigoUnidadMedida = $itemSaldos['CodigoUnidadMedida'];
                                $saldoPrevNombreUnidadMedida = $itemSaldos['NombreUnidadMedida'];
                                $saldoPrevDisponible = $itemSaldos['Disponible'];

                                $busqueda = false;

                                if ($codigoVarianteComponente == $saldoPrevCodigoVariante) {

                                    $saldoId = $saldoPrevId;
                                    $saldoItemPortafolio = $saldoPrevDisponible;
                                    $saldoNombreUnidadMedida = $saldoPrevNombreUnidadMedida;
                                    $saldoCodigoUnidadMedida = $saldoPrevCodigoUnidadMedida;
                                    //$kitActivo = '1';

                                    $busqueda = true;
                                    break;
                                }
                            }

                            if ($saldoItemPortafolio < $saldoComponente) {
                                $saldoComponente = $saldoItemPortafolio;

                                $this->portafolio[$cont]['SPDisponible'] = $saldoId;
                                $this->portafolio[$cont]['SPDisponible'] = $saldoComponente;
                                $this->portafolio[$cont]['SPNombreUnidadMedida'] = $saldoNombreUnidadMedida;
                                $this->portafolio[$cont]['SPCodigoUnidadMedida'] = $saldoCodigoUnidadMedida;
                                $this->portafolio[$cont]['kitActivo'] = '1';
                                $this->portafolio[$cont]['ACPrecioVenta'] = $LMTotalPrecioVentaListaMateriales;
                            }

                            if ($saldoComponente == 0) {
                                $this->portafolio[$cont]['kitActivo'] = '0';
                                $busqueda = true;
                                break;
                            }

                            $session = new CHttpSession;
                            $session->open();
                            $session['listaMateriales'] = $this->listaMateriales;
                        }
                    }
                }
                $cont++;
            }
            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarPortafolioSaldosAutoventa() {

        try {

            $cont = 0;


            foreach ($this->portafolio as $item) {



                $codigoVariante = $item['CodigoVariante'];
                $codigoArticulo = $item['CodigoArticulo'];


                $codigoTipo = $item['CodigoTipo'];

                $saldoId = '';
                $saldoItemPortafolio = '';
                $saldoNombreUnidadMedida = '';
                $saldoCodigoUnidadMedida = '';

                $this->cargarListaMateriales($codigoVariante);

                if ($codigoTipo != "KV" && $codigoTipo != "KD") {

                    /* echo '<pre>';
                      print_r($this->saldoAutoventa);
                      die(); */

                    foreach ($this->saldoAutoventa as $itemSaldos) {

                        $saldoAutId = $itemSaldos['Id'];
                        $saldoAutCodigoSitio = $itemSaldos['CodigoSitio'];
                        $saldoAutNombreSitio = $itemSaldos['NombreSitio'];
                        $saldoAutCodigoAlmacen = $itemSaldos['CodigoAlmacen'];
                        $saldoAutCodigoVariante = $itemSaldos['CodigoVariante'];
                        $saldoAutCodigoArticulo = $itemSaldos['CodigoArticulo'];
                        $saldoAutCodigoCaracteristica1 = $itemSaldos['CodigoCaracteristica1'];
                        $saldoAutCodigoCaracteristica2 = $itemSaldos['CodigoCaracteristica2'];
                        $saldoAutCodigoTipo = $itemSaldos['CodigoTipo'];
                        $saldoAutCodigoUnidadMedida = $itemSaldos['CodigoUnidadMedida'];
                        $saldoAutNombreUnidadMedida = $itemSaldos['NombreUnidadMedida'];
                        $saldoAutDisponible = $itemSaldos['Disponible'];

                        $busqueda = false;


                        if ($codigoVariante == $saldoAutCodigoVariante) {



                            $saldoId = $saldoAutId;
                            $saldoItemPortafolio = $saldoAutDisponible;
                            $saldoNombreUnidadMedida = $saldoAutNombreUnidadMedida;
                            $saldoCodigoUnidadMedida = $saldoAutCodigoUnidadMedida;

                            $busqueda = true;
                            break;
                        }
                    }

                    $this->portafolio[$cont]['SAId'] = $saldoId;
                    $this->portafolio[$cont]['SADisponible'] = $saldoItemPortafolio;
                    $this->portafolio[$cont]['SANombreUnidadMedida'] = $saldoNombreUnidadMedida;
                    $this->portafolio[$cont]['SACodigoUnidadMedida'] = $saldoCodigoUnidadMedida;
                } else {


                    $saldoComponente = 99999999;

                    foreach ($this->listaMateriales as $itemLista) {



                        $codigoVarianteComponente = $itemLista['LMDCodigoVarianteComponente'];
                        $LMCodigoVarianteKit = $itemLista['LMCodigoVarianteKit'];


                        if ($codigoVariante == $LMCodigoVarianteKit) {


                            foreach ($this->saldoAutoventa as $itemSaldos) {


                                $saldoAutId = $itemSaldos['Id'];
                                $saldoAutCodigoSitio = $itemSaldos['CodigoSitio'];
                                $saldoAutNombreSitio = $itemSaldos['NombreSitio'];
                                $saldoAutCodigoAlmacen = $itemSaldos['CodigoAlmacen'];
                                $saldoAutCodigoVariante = $itemSaldos['CodigoVariante'];
                                $saldoAutCodigoArticulo = $itemSaldos['CodigoArticulo'];
                                $saldoAutCodigoCaracteristica1 = $itemSaldos['CodigoCaracteristica1'];
                                $saldoAutCodigoCaracteristica2 = $itemSaldos['CodigoCaracteristica2'];
                                $saldoAutCodigoTipo = $itemSaldos['CodigoTipo'];
                                $saldoAutCodigoUnidadMedida = $itemSaldos['CodigoUnidadMedida'];
                                $saldoAutNombreUnidadMedida = $itemSaldos['NombreUnidadMedida'];
                                $saldoAutDisponible = $itemSaldos['Disponible'];


                                $busqueda = false;

                                if ($codigoVarianteComponente == $saldoAutCodigoVariante) {


                                    $saldoId = $saldoAutId;
                                    $saldoItemPortafolio = $saldoAutDisponible;
                                    $saldoNombreUnidadMedida = $saldoAutNombreUnidadMedida;
                                    $saldoCodigoUnidadMedida = $saldoAutCodigoUnidadMedida;

                                    $busqueda = true;
                                }
                            }

                            if ($saldoItemPortafolio < $saldoComponente) {
                                $saldoComponente = $saldoItemPortafolio;

                                $this->portafolio[$cont]['SAId'] = $saldoId;
                                $this->portafolio[$cont]['SADisponible'] = $saldoComponente;
                                $this->portafolio[$cont]['SANombreUnidadMedida'] = $saldoNombreUnidadMedida;
                                $this->portafolio[$cont]['SACodigoUnidadMedida'] = $saldoCodigoUnidadMedida;
                            }
                        }
                    }
                }
                $cont++;
            }

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarUnidadesPortafolioSaldo() {


        try {

            $cont = 0;
            foreach ($this->portafolio as $item) {

                $codigoVariante = $item['CodigoVariante'];
                $codigoArticulo = $item['CodigoArticulo'];
                $ACCodigoUnidadMedida = $item['ACCodigoUnidadMedida'];
                $SPCodigoUnidadMedida = $item['SPCodigoUnidadMedida'];
                $SPDisponible = $item['SPDisponible'];

                $saldoDisponibleVenta = '';

                if ($SPCodigoUnidadMedida != $ACCodigoUnidadMedida && $ACCodigoUnidadMedida != "" && $SPCodigoUnidadMedida != "") {

                    $this->portafolio[$cont]['SaldoDisponibleVenta'] = '';

                    foreach ($this->unidadesConversion as $itemUnidades) {

                        $codigoArticuloUnidad = $itemUnidades['CodigoArticulo'];
                        $unidadArticuloDesdeUnidad = $itemUnidades['CodigoDesdeUnidad'];
                        $unidadArticuloHastaUnidad = $itemUnidades['CodigoHastaUnidad'];
                        $unidadFactorConversion = $itemUnidades['Factor'];

                        if ($codigoArticulo == $codigoArticuloUnidad) {

                            if ($unidadArticuloDesdeUnidad == $SPCodigoUnidadMedida && $unidadArticuloHastaUnidad == $ACCodigoUnidadMedida) {
                                $this->unidadDesde = $unidadArticuloDesdeUnidad;
                                $this->unidadHasta = $unidadArticuloHastaUnidad;

                                if (!$this->calcularDigitoOperacion()) {
                                    echo $this->txtError = "No se han podido calcular los digitos";
                                } else {
                                    if ($this->operacion == "Division") {
                                        $this->portafolio[$cont]['SaldoDisponibleVenta'] = floor($SPDisponible / $unidadFactorConversion);
                                    } else {
                                        $this->portafolio[$cont]['SaldoDisponibleVenta'] = floor($SPDisponible * $unidadFactorConversion);
                                    }
                                }
                            }
                        }
                    }
                } else if ($SPCodigoUnidadMedida == $ACCodigoUnidadMedida && $ACCodigoUnidadMedida != "" && $SPCodigoUnidadMedida != "") {
                    $this->portafolio[$cont]['SaldoDisponibleVenta'] = $SPDisponible;
                } else {
                    $this->portafolio[$cont]['SaldoDisponibleVenta'] = '';
                }
                $cont++;
            }
            /* echo '<pre>';
              print_r($this->portafolio);
              die(); */

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarUnidadesPortafolioSaldoAutoventa() {

        try {

            $cont = 0;
            foreach ($this->portafolio as $item) {

                $codigoVariante = $item['CodigoVariante'];
                $codigoArticulo = $item['CodigoArticulo'];
                $ACCodigoUnidadMedida = $item['ACCodigoUnidadMedida'];

                $SACodigoUnidadMedida = $item['SACodigoUnidadMedida'];
                $SADisponible = $item['SADisponible'];

                $saldoDisponibleVenta = '';

                if ($SACodigoUnidadMedida != $ACCodigoUnidadMedida && $ACCodigoUnidadMedida != "" && $SACodigoUnidadMedida != "") {

                    $this->portafolio[$cont]['SaldoDisponibleVentaAutoventa'] = '';

                    foreach ($this->unidadesConversion as $itemUnidades) {

                        $codigoArticuloUnidad = $itemUnidades['CodigoArticulo'];
                        $unidadArticuloDesdeUnidad = $itemUnidades['CodigoDesdeUnidad'];
                        $unidadArticuloHastaUnidad = $itemUnidades['CodigoHastaUnidad'];
                        $unidadFactorConversion = $itemUnidades['Factor'];

                        if ($codigoArticulo == $codigoArticuloUnidad) {

                            if ($unidadArticuloDesdeUnidad == $SACodigoUnidadMedida && $unidadArticuloHastaUnidad == $ACCodigoUnidadMedida) {
                                $this->unidadDesde = $unidadArticuloDesdeUnidad;
                                $this->unidadHasta = $unidadArticuloHastaUnidad;

                                if (!$this->calcularDigitoOperacion()) {
                                    echo $this->txtError = "No se han podido calcular los digitos";
                                } else {
                                    if ($this->operacion == "Division") {
                                        $this->portafolio[$cont]['SaldoDisponibleVentaAutoventa'] = floor($SADisponible / $unidadFactorConversion);
                                    } else {
                                        $this->portafolio[$cont]['SaldoDisponibleVentaAutoventa'] = floor($SADisponible * $unidadFactorConversion);
                                    }
                                }
                            }
                        }
                    }
                } else if ($SACodigoUnidadMedida == $ACCodigoUnidadMedida && $ACCodigoUnidadMedida != "" && $SACodigoUnidadMedida != "") {
                    $this->portafolio[$cont]['SaldoDisponibleVentaAutoventa'] = $SADisponible;
                } else {
                    $this->portafolio[$cont]['SaldoDisponibleVentaAutoventa'] = '';
                }
                $cont++;
            }


            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function calcularDigitoOperacion() {

        try {

            $this->cargarOperacionesUnidades = Preventa::model()->cargarOperacionesUniadades();

            if (!$this->cargarOperacionesUnidades) {
                $this->txtError = "No se ha podido cargar las operaciones";
                return false;
            } else {
                $this->operacionesUnidades = Preventa::model()->getDataReader();

                foreach ($this->operacionesUnidades as $itemOperaciones) {

                    $operacionCodigoDesde = $itemOperaciones['CodigoDesde'];
                    $operacionCodigoHasta = $itemOperaciones['CodigoHasta'];
                    $operacionOperacion = $itemOperaciones['Operacion'];

                    if ($operacionCodigoDesde == $this->unidadDesde && $operacionCodigoHasta == $this->unidadHasta) {

                        $this->operacion = $operacionOperacion;
                    }
                }

                return true;
            }
        } catch (Exception $exc) {

            echo $exc->getTraceAsString();
            return false;
        }
    }

    private function cargarListaMateriales($CodVariante) {
        try {

            $this->cargarKitPortafolio = Preventa::model()->cargarListaMateriales($CodVariante);

            if (!$this->cargarKitPortafolio) {
                $this->txtError = Preventa::model()->getTxtError();
                return false;
            } else {
                $this->listaMateriales = Preventa::model()->getDataReader();
                return true;
            }
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarPortafolioListaMateriales() {


        /* echo '<pre>';
          echo 'antes';
          print_r($this->listaMateriales);
          exit(); */

        try {

            //exit(); 

            $array = array();
            foreach ($this->portafolio as $itemPortafolio) {


                //exit();
                $porCodigoArticulo = $itemPortafolio['CodigoArticulo'];
                $porCodigoVariante = $itemPortafolio['CodigoVariante'];
                $porCodigoTipo = $itemPortafolio['CodigoTipo'];
                $porACPrecioVenta = $itemPortafolio['ACPrecioVenta'];

                $this->cargarListaMateriales($porCodigoVariante);


                $contLista = 0;
                foreach ($this->listaMateriales as $itemListaMateriales) {

                    $this->listaMateriales[$contLista]['SPId'] = "";
                    $this->listaMateriales[$contLista]['SPDisponible'] = "";
                    $this->listaMateriales[$contLista]['SPNombreUnidadMedida'] = "";
                    $this->listaMateriales[$contLista]['SPCodigoUnidadMedida'] = "";

                    $this->listaMateriales[$contLista]['SAId'] = "";
                    $this->listaMateriales[$contLista]['SADisponible'] = "";
                    $this->listaMateriales[$contLista]['SANombreUnidadMedida'] = "";
                    $this->listaMateriales[$contLista]['SACodigoUnidadMedida'] = "";

                    $contLista++;
                }




                if ($porCodigoTipo == "KV" || $porCodigoTipo == "KD") {

                    $contLista = 0;
                    $contListaAuto = 0;

                    foreach ($this->listaMateriales as $itemListaMateriales) {

                        //echo '<pre>';
                        //print_r($itemListaMateriales);

                        $LMCodigoVarianteKit = $itemListaMateriales['LMCodigoVarianteKit'];
                        $LMDCodigoVarianteComponente = $itemListaMateriales['LMDCodigoVarianteComponente'];



                        if ($LMCodigoVarianteKit == $porCodigoVariante) {


                            $saldoId = '';
                            $saldoItemLista = '';
                            $saldoNombreUnidadMedida = '';
                            $saldoCodigoUnidadMedida = '';

                            $saldoAuId = '';
                            $saldoAuItemLista = '';
                            $saldoAuNombreUnidadMedida = '';
                            $saldoAuCodigoUnidadMedida = '';

                            if ($porACPrecioVenta != "") {


                                $busquedaPrve = false;
                                $busquedaAuto = false;


                                foreach ($this->saldoPreventa as $itemSaldos) {

                                    //echo '<pre>';
                                    //print_r($itemSaldos);

                                    $saldoPrevId = $itemSaldos['Id'];
                                    $saldoPrevCodigoSitio = $itemSaldos['CodigoSitio'];
                                    $saldoPrevNombreSitio = $itemSaldos['NombreSitio'];
                                    $saldoPrevCodigoAlmacen = $itemSaldos['CodigoAlmacen'];
                                    $saldoPrevCodigoVariante = $itemSaldos['CodigoVariante'];
                                    $saldoPrevCodigoArticulo = $itemSaldos['CodigoArticulo'];
                                    $saldoPrevCodigoCaracteristica1 = $itemSaldos['CodigoCaracteristica1'];
                                    $saldoPrevCodigoCaracteristica2 = $itemSaldos['CodigoCaracteristica2'];
                                    $saldoPrevCodigoTipo = $itemSaldos['CodigoTipo'];
                                    $saldoPrevCodigoUnidadMedida = $itemSaldos['CodigoUnidadMedida'];
                                    $saldoPrevNombreUnidadMedida = $itemSaldos['NombreUnidadMedida'];
                                    $saldoPrevDisponible = $itemSaldos['Disponible'];

                                    //echo $saldoPrevCodigoVariante .'=='. $LMDCodigoVarianteComponente.'<br>';
                                    if ($saldoPrevCodigoVariante == $LMDCodigoVarianteComponente) {

                                        $saldoId = $saldoPrevId;
                                        $saldoItemLista = $saldoPrevDisponible;
                                        $saldoNombreUnidadMedida = $saldoPrevNombreUnidadMedida;
                                        $saldoCodigoUnidadMedida = $saldoPrevCodigoUnidadMedida;

                                        $busquedaPrve = true;
                                    }
                                }



                                foreach ($this->saldoAutoventa as $itemSaldosAuto) {

                                    $saldoAutoId = $itemSaldosAuto['Id'];
                                    $saldoAutoCodigoSitio = $itemSaldosAuto['CodigoSitio'];
                                    $saldoAutoNombreSitio = $itemSaldosAuto['NombreSitio'];
                                    $saldoAutoCodigoAlmacen = $itemSaldosAuto['CodigoAlmacen'];
                                    $saldoAutoCodigoVariante = $itemSaldosAuto['CodigoVariante'];
                                    $saldoAutoCodigoArticulo = $itemSaldosAuto['CodigoArticulo'];
                                    $saldoAutoCodigoCaracteristica1 = $itemSaldosAuto['CodigoCaracteristica1'];
                                    $saldoAutoCodigoCaracteristica2 = $itemSaldosAuto['CodigoCaracteristica2'];
                                    $saldoAutoCodigoTipo = $itemSaldosAuto['CodigoTipo'];
                                    $saldoAutoCodigoUnidadMedida = $itemSaldosAuto['CodigoUnidadMedida'];
                                    $saldoAutoNombreUnidadMedida = $itemSaldosAuto['NombreUnidadMedida'];
                                    $saldoAutoDisponible = $itemSaldosAuto['Disponible'];


                                    if ($saldoAutoCodigoVariante == $LMDCodigoVarianteComponente) {

                                        $saldoAuId = $saldoAutoId;
                                        $saldoAuItemLista = $saldoAutoDisponible;
                                        $saldoAuNombreUnidadMedida = $saldoAutoNombreUnidadMedida;
                                        $saldoAuCodigoUnidadMedida = $saldoAutoCodigoUnidadMedida;

                                        $busquedaAuto = true;
                                    }
                                }



                                if (!$busquedaPrve) {

                                    $this->listaMateriales[$contLista]['SPId'] = "";
                                    $this->listaMateriales[$contLista]['SPDisponible'] = "";
                                    $this->listaMateriales[$contLista]['SPNombreUnidadMedida'] = "";
                                    $this->listaMateriales[$contLista]['SPCodigoUnidadMedida'] = "";
                                } else {

                                    //echo 'entre'.'<br>';
                                    $this->listaMateriales[$contLista]['SPId'] = $saldoId;
                                    $this->listaMateriales[$contLista]['SPDisponible'] = $saldoItemLista;
                                    $this->listaMateriales[$contLista]['SPNombreUnidadMedida'] = $saldoNombreUnidadMedida;
                                    $this->listaMateriales[$contLista]['SPCodigoUnidadMedida'] = $saldoCodigoUnidadMedida;
                                }

                                if (!$busquedaAuto) {

                                    $this->listaMateriales[$contLista]['SAId'] = "";
                                    $this->listaMateriales[$contLista]['SADisponible'] = "";
                                    $this->listaMateriales[$contLista]['SANombreUnidadMedida'] = "";
                                    $this->listaMateriales[$contLista]['SACodigoUnidadMedida'] = "";
                                } else {

                                    $this->listaMateriales[$contLista]['SAId'] = $saldoAuId;
                                    $this->listaMateriales[$contLista]['SADisponible'] = $saldoAuItemLista;
                                    $this->listaMateriales[$contLista]['SANombreUnidadMedida'] = $saldoAuNombreUnidadMedida;
                                    $this->listaMateriales[$contLista]['SACodigoUnidadMedida'] = $saldoAuCodigoUnidadMedida;
                                }
                            } else {

                                $this->listaMateriales[$contLista]['SPId'] = "";
                                $this->listaMateriales[$contLista]['SPDisponible'] = "";
                                $this->listaMateriales[$contLista]['SPNombreUnidadMedida'] = "";
                                $this->listaMateriales[$contLista]['SPCodigoUnidadMedida'] = "";

                                $this->listaMateriales[$contLista]['SAId'] = "";
                                $this->listaMateriales[$contLista]['SADisponible'] = "";
                                $this->listaMateriales[$contLista]['SANombreUnidadMedida'] = "";
                                $this->listaMateriales[$contLista]['SACodigoUnidadMedida'] = "";
                            }
                        }
                        $contLista++;
                    }

                    array_push($array, $this->listaMateriales);
                }
            }

            $arrayLis = array();
            foreach ($array as $ArrayPadreListaMateriales) {
                foreach ($ArrayPadreListaMateriales as $itemListaMateriales) {
                    array_push($arrayLis, $itemListaMateriales);
                }
            }

            Yii::app()->session['Listamateriales'] = $arrayLis;

            $session = new CHttpSession;
            $session->open();
            $session['listaMateriales'] = Yii::app()->session['Listamateriales'];



            $this->validarListaMateriales();

            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function validarListaMateriales() {

        /* echo '<pre>';
          print_r($this->listaMateriales);
          exit(); */

        foreach ($this->portafolio as $itemPortafolio) {


            $porCodigoArticulo = $itemPortafolio['CodigoArticulo'];
            $porCodigoVariante = $itemPortafolio['CodigoVariante'];
            $porCodigoTipo = $itemPortafolio['CodigoTipo'];
            $porACPrecioVenta = $itemPortafolio['ACPrecioVenta'];

            //$this->cargarListaMateriales($porCodigoVariante);
            $this->listaMateriales = Yii::app()->session['Listamateriales'];

            /* echo '<pre>';
              print_r($this->listaMateriales); */

            if ($porCodigoTipo == "KD" || $porCodigoTipo == "KV") {
                $contdisponible = 0;
                foreach ($this->listaMateriales as $itemListaMateriales) {

                    /* echo '<pre>';
                      print_r($itemListaMateriales); */

                    $LMCodigoVarianteKit = $itemListaMateriales['LMCodigoVarianteKit'];
                    $LMDCodigoVarianteComponente = $itemListaMateriales['LMDCodigoVarianteComponente'];
                    $LMTotalPrecioVentaListaMateriales = $itemListaMateriales['LMTotalPrecioVentaListaMateriales'];


                    $LMSPDisponible = $itemListaMateriales['SPDisponible'];
                    $LMSAuDisponible = $itemListaMateriales['SADisponible'];


                    if ($LMCodigoVarianteKit == $porCodigoVariante) {
                        $busqueda = true;
                        foreach ($this->listaMateriales as $itemListaMaterialesI) {

                            $LMCodigoVarianteKitI = $itemListaMaterialesI['LMCodigoVarianteKit'];
                            $LMSPDisponible = $itemListaMaterialesI['SPDisponible'];
                            $LMSAuDisponible = $itemListaMaterialesI['SADisponible'];


                            if ($LMCodigoVarianteKit == $LMCodigoVarianteKitI) {

                                if ($busqueda) {

                                    if ($LMSPDisponible > 0) {
                                        $busqueda = true;
                                    } else {
                                        $busqueda = false;
                                    }



                                    /* if($LMSAuDisponible > 0){

                                      $busqueda=true;
                                      }else{

                                      $busqueda=false;
                                      } */
                                }
                            }
                        }


                        if ($busqueda) {
                            $this->portafolio[$cont]['kitActivo'] = '1';
                            $this->portafolio[$cont]['ACPrecioVenta'] = $LMTotalPrecioVentaListaMateriales;
                        } else {
                            $this->portafolio[$cont]['SPDisponible'] = "";
                            $this->portafolio[$cont]['SADisponible'] = "";
                        }
                    }
                }
            }
            $cont++;
        }



        $cont = 0;
        foreach ($this->portafolio as $itemPortafolio) {

            $porCodigoArticulo = $itemPortafolio['CodigoArticulo'];
            $porCodigoVariante = $itemPortafolio['CodigoVariante'];
            $porCodigoTipo = $itemPortafolio['CodigoTipo'];
            $porACPrecioVenta = $itemPortafolio['ACPrecioVenta'];


            if ($porCodigoTipo == "KV" || $porCodigoTipo == "KD") {

                $contLista = 0;
                foreach ($this->listaMateriales as $itemListaMateriales) {



                    $LMCodigoArticuloKit = $itemListaMateriales['LMCodigoArticuloKit'];
                    $LMDCodigoArticuloComponente = $itemListaMateriales['LMDCodigoArticuloComponente'];
                    $LMSPDisponible = $itemListaMateriales['SPDisponible'];

                    if ($LMCodigoArticuloKit == $porCodigoArticulo && $LMSPDisponible == "") {
                        $this->portafolio[$cont]['kitActivo'] = '0';
                    }
                }
            }

            $cont++;
        }


        $session = new CHttpSession;
        $session->open();
        $session['portafolio'] = $this->portafolio;


        /* echo '<pre>';
          print_r($this->portafolio);
          exit(); */
    }

    public function actionAjaxGetKitVirtual() {

        try {

            $txtCodigoVariante = $_POST['txtCodigoVariante'];
            $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
            $txtNombreArticulo = $_POST['txtNombreArticulo'];
            $txtCodigoCaracteristica1 = $_POST['txtCodigoCaracteristica1'];
            $txtCodigoCaracteristica2 = $_POST['txtCodigoCaracteristica2'];
            $txtCodigoTipo = $_POST['txtCodigoTipo'];
            $txtZonaVentas = $_POST['txtZonaVentas'];
            $txtCliente = $_POST['txtCliente'];
            $txtNombreUnidadMedidaPrecioVenta = $_POST['txtNombreUnidadMedidaPrecioVenta'];

            if ($txtCodigoCaracteristica1 == "N/A") {
                $txtCodigoCaracteristica1 = "";
            }

            if ($txtCodigoCaracteristica2 == "N/A") {
                $txtCodigoCaracteristica2 = "";
            }

            echo $this->renderPartial('_componenetesKitVirtual', array(
                'txtCodigoVariante' => $txtCodigoVariante,
                'txtCodigoArticulo' => $txtCodigoArticulo,
                'txtNombreArticulo' => $txtNombreArticulo,
                'txtCodigoCaracteristica1' => $txtCodigoCaracteristica1,
                'txtCodigoCaracteristica2' => $txtCodigoCaracteristica2,
                'txtCodigoTipo' => $txtCodigoTipo,
                'txtCliente' => $txtCliente,
                'txtNombreUnidadMedidaPrecioVenta' => $txtNombreUnidadMedidaPrecioVenta
                    ), true);
        } catch (Exception $exc) {
            echo '0';
            echo $exc->getMessage();
        }
    }

    public function actionAjaxGetKitComponente() {

        try {

            $txtCodigoVariante = $_POST['txtCodigoVariante'];
            $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
            $txtNombreArticulo = $_POST['txtNombreArticulo'];
            $txtCodigoCaracteristica1 = $_POST['txtCodigoCaracteristica1'];
            $txtCodigoCaracteristica2 = $_POST['txtCodigoCaracteristica2'];
            $txtCodigoTipo = $_POST['txtCodigoTipo'];
            $txtCliente = $_POST['txtCliente'];

            if ($txtCodigoCaracteristica1 == "N/A") {
                $txtCodigoCaracteristica1 = "";
            }

            if ($txtCodigoCaracteristica2 == "N/A") {
                $txtCodigoCaracteristica2 = "";
            }

            echo $this->renderPartial('_componenetesKidDinamico', array(
                'txtCodigoVariante' => $txtCodigoVariante,
                'txtCodigoArticulo' => $txtCodigoArticulo,
                'txtNombreArticulo' => $txtNombreArticulo,
                'txtCodigoCaracteristica1' => $txtCodigoCaracteristica1,
                'txtCodigoCaracteristica2' => $txtCodigoCaracteristica2,
                'txtCodigoTipo' => $txtCodigoTipo,
                'txtCliente' => $txtCliente
                    ), true);
        } catch (Exception $exc) {
            echo '0';
            echo $exc->getMessage();
        }
    }

    public function actionAjaxGetDetalleArticulo() {
        $session = new CHttpSession;
        $session->open();

        $ubicacion = $session['Ubicacion'];
        try {

            $txtCodigoVariante = $_POST['txtCodigoVariante'];
            $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
            $txtCliente = $_POST['txtCliente'];
            $txtCodigoAcuerdoPrecioVenta = $_POST['txtCodigoAcuerdoPrecioVenta'];
            $txtNombreUnidadMedidaPrecioVenta = $_POST['txtNombreUnidadMedidaPrecioVenta'];
            $txtTipoVenta = $_POST['tipoVenta'];
            $txtLote = $_POST['txtLote'];
            $txtSaldo = $_POST['txtSaldo'];
            //$ubicacion = Yii::app()->user->_cedula;

            $txttipokit = $_POST['tipokit'];

            $this->acuerdoComercialPrecio = $txtCodigoAcuerdoPrecioVenta;
            $this->codigoArticulo = $txtCodigoArticulo;
            $this->nombreCodigoGrupoPrecio = $txtNombreUnidadMedidaPrecioVenta;
            //echo 'esta es la infoo del txt ' . $txtCodigoAcuerdoPrecioVenta;
            //die();
            if ($this->cargarSaldoLimite()) {

                if ($_POST['txtZonaVentas']) {
                    $txtZonaVentas = $_POST['txtZonaVentas'];
                    $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($txtZonaVentas);
                }

                //print_r($this->saldoLimite);
                //die();

                echo $this->renderPartial('_articuloDetalle', array(
                    'txtCodigoVariante' => $txtCodigoVariante,
                    'txtCodigoArticulo' => $txtCodigoArticulo,
                    'permisosDescuentoEspecial' => $permisosDescuentoEspecial,
                    'txtCliente' => $txtCliente,
                    'saldoLimite' => $this->saldoLimite,
                    'txtTipoVenta' => $txtTipoVenta,
                    'txtLote' => $txtLote,
                    'txtSaldo' => $txtSaldo,
                    'txtZonaVentas' => $txtZonaVentas,
                    'ubicacion' => $ubicacion,
                    'txttipokit' => $txttipokit
                        ), true);
            } else {
                $this->txtError = "No se ha podido calcular el saldo limite";
                return false;
            }
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
        }
    }

    private function cargarSaldoLimite() {

        try {
            $session = new CHttpSession;
            $session->open();
            $codigoSitio = $session['codigositio'];
            $codigoAlmacen = $session['Almacen'];
            $this->codigoSitio = $codigoSitio;
            $this->codigoAlmacen = $codigoAlmacen;

            if ($session['acuerdoLinea']) {
                $descuentoLinea = $session['acuerdoLinea'];
            } else {
                $descuentoLinea = array();
            }

            $txtCodigoVariante = $_POST['txtCodigoVariante'];
            $txtCodigoGrupoDescuentoLinea = $_POST['txtCodigoGrupoDescuentoLinea'];
            $txtCantidad = $_POST['txtCantidad'];


            $descuentoLineaConsulta = array();
            $busqueda = false;

            foreach ($descuentoLinea as $itemDL) {

                $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                $itemDLSitio = $itemDL['Sitio'];
                $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                $itemDLSaldo = $itemDL['Saldo'];

                if ($itemDlTipoCuentaCliente == "1" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                    array_push($descuentoLineaConsulta, $itemDL);
                    $busqueda = true;
                }
            }

            if (!$busqueda) {

                foreach ($descuentoLinea as $itemDL) {

                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "1" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {

                foreach ($descuentoLinea as $itemDL) {

                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "1" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }

            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "1" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }

            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "1" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }



            if (!$busqueda) {

                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "1" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }

            ///GRUPO

            if (!$busqueda) {


                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];


                    if ($itemDlTipoCuentaCliente == "2" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {


                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];


                    if ($itemDlTipoCuentaCliente == "2" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }



            if (!$busqueda) {

                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "2" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }

            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "2" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "2" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }

            if (!$busqueda) {

                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "2" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            ////TODO

            if (!$busqueda) {


                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];


                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {


                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];


                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {


                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];


                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "1" && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }



            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "2" && $itemDLCodigoArticuloGrupoDescuentoLinea = $txtCodigoGrupoDescuentoLinea && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "3" && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }



            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "3" && $itemDLSitio == $codigoSitio && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }


            if (!$busqueda) {
                foreach ($descuentoLinea as $itemDL) {
                    $itemDLCuentaCliente = $itemDL['CuentaCliente'];
                    $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
                    $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
                    $itemDLCantidadDesde = $itemDL['CantidadDesde'];
                    $itemDLCantidadHasta = $itemDL['CantidadHasta'];
                    $itemDLCodigoVariante = $itemDL['CodigoVariante'];
                    $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
                    $itemDLSitio = $itemDL['Sitio'];
                    $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
                    $itemDLSaldo = $itemDL['Saldo'];

                    if ($itemDlTipoCuentaCliente == "3" && $itemDLTipoCuentaArticulos == "3" && $itemDLSaldo > 0) {
                        array_push($descuentoLineaConsulta, $itemDL);
                        $busqueda = true;
                    }
                }
            }



            //            echo '<pre>';
            //           print_r($descuentoLineaConsulta); 

            $descuentosLineaConsultaCantidad = array();
            $descuentosLineaSinCantidad = array();
            $busquedaConsulta = false;
            foreach ($descuentoLineaConsulta as $itemConsulta) {

                $cantidadDesde = $itemConsulta['CantidadDesde'];
                $CantidadHasta = $itemConsulta['CantidadHasta'];

                if ($cantidadDesde <= $txtCantidad && $CantidadHasta >= $txtCantidad) {
                    array_push($descuentosLineaConsultaCantidad, $itemConsulta);
                }

                if ($cantidadDesde == 0 && $CantidadHasta == 0) {
                    array_push($descuentosLineaSinCantidad, $itemConsulta);
                }
            }

            if (count($descuentosLineaConsultaCantidad) <= 0) {
                $descuentosLineaConsultaCantidad = $descuentosLineaSinCantidad;
            }

            if (count($descuentosLineaConsultaCantidad) > 0) {

                /// echo '<pre>';
                // print_r($descuentosLineaConsultaCantidad);

                $fechaMayor = '0000-00-00';
                foreach ($descuentosLineaConsultaCantidad as $itemConsulta) {

                    $fechaInicio = $itemConsulta['FechaInicio'];

                    if ($fechaInicio >= $fechaMayor) {
                        $descuento1 = $itemConsulta['PorcentajeDescuentoLinea1'];
                        $descuento2 = $itemConsulta['PorcentajeDescuentoLinea2'];
                        $IdAcuerdoComercial = $itemConsulta['IdAcuerdoComercial'];
                        $NombreUnidadMedida = $itemConsulta['NombreUnidadMedida'];
                        $CodigoUnidadMedida = $itemConsulta['CodigoUnidadMedida'];
                        $saldo = $itemConsulta['Saldo'];

                        $fechaMayor = $fechaInicio;
                    }
                }

                $total = $descuento1 + $descuento2;
                $this->saldoLimite = array(
                    'Total' => $total,
                    'Saldo' => $saldo,
                    'NombreUnidadMedida' => $NombreUnidadMedida,
                    'IdAcuerdoComercial' => $IdAcuerdoComercial,
                    'CodigoUnidadMedida' => $CodigoUnidadMedida
                );

                // echo 'imprimeeee'.$this->acuerdoComercialPrecio;
                // die();

                if ($CodigoUnidadMedida != $this->acuerdoComercialPrecio) {

                    $this->validateAcuerdo($CodigoUnidadMedida, $this->acuerdoComercialPrecio, $saldo);
                    if ($this->cantidadConvertida != "") {
                        $this->saldoLimite = array(
                            'Total' => $total,
                            'Saldo' => $this->cantidadConvertida,
                            'NombreUnidadMedida' => $this->nombreCodigoGrupoPrecio,
                            'IdAcuerdoComercial' => $IdAcuerdoComercial,
                            'CodigoUnidadMedida' => $this->acuerdoComercialPrecio
                        );
                    } else {
                        $this->saldoLimite = array(
                            'Total' => '0',
                            'Saldo' => '',
                            'NombreUnidadMedida' => '',
                            'IdAcuerdoComercial' => '',
                            'CodigoUnidadMedida' => ''
                        );
                    }
                }
            } else {
                $this->saldoLimite = array(
                    'Total' => '0',
                    'Saldo' => '',
                    'NombreUnidadMedida' => '',
                    'IdAcuerdoComercial' => '',
                    'CodigoUnidadMedida' => ''
                );
            }



            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function cargarAcuerdosLinea() {

        try {

            Preventa::model()->setCuentaCliente($this->cuentaCliente);
            Preventa::model()->setZonaVentas($this->zonaVentas);

            $this->cargarAcuerdoLinea = Preventa::model()->cargarAcuerdoLinea();

            if (!$this->cargarAcuerdoLinea) {
                $this->txtError = Preventa::model()->getTxtError;
                return false;
            } else {
                $this->acuerdoLinea = Preventa::model()->getDataReader();

                $session = new CHttpSession;
                $session->open();
                $session['acuerdoLinea'] = $this->acuerdoLinea;


                return true;
            }
        } catch (Exception $exc) {
            //Preventa::model()->getTxtError();
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    private function cargarAcuerdosMultiLinea() {

        try {

            Preventa::model()->setCuentaCliente($this->cuentaCliente);
            Preventa::model()->setZonaVentas($this->zonaVentas);

            $this->cargarAcuerdoMultiLinea = Preventa::model()->cargarAcuerdoMultiLinea();

            if (!$this->cargarAcuerdoMultiLinea) {
                $this->txtError = Preventa::model()->getTxtError;
                return false;
            } else {
                $this->acuerdoMultiLinea = Preventa::model()->getDataReader();

                $session = new CHttpSession;
                $session->open();
                $session['acuerdoMultiLinea'] = $this->acuerdoMultiLinea;


                return true;
            }
        } catch (Exception $exc) {
            //Preventa::model()->getTxtError();
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    public function actionAjaxConsultarDescuentos() {

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];


        if ($session['acuerdoLinea']) {
            $descuentoLinea = $session['acuerdoLinea'];
        } else {
            $descuentoLinea = array();
        }

        if ($session['acuerdoMultiLinea']) {
            $descuentoMultiLinea = $session['acuerdoMultiLinea'];
        } else {
            $descuentoMultiLinea = array();
        }

        $txtCodigoVariante = $_POST['txtCodigoVariante'];
        $txtCodigoGrupoDescuentoLinea = $_POST['txtCodigoGrupoDescuentoLinea'];
        $txtCodigoArticulo = $_POST['txtArticulo'];
        $txtClienteDetalle = $_POST['txtClienteDetalle'];
        $txtZonaVentas = $_POST['txtZonaVentas'];
        $txtCodigoGrupoDescuentoMultiLinea = $_POST['txtCodigoGrupoDescuentoMultiLinea'];
        $txtNombreArticulo = $_POST['txtNombreArticulo'];


        $CodArticuloCliente = Consultas::model()->getCodArtiDesLinaCliente($txtClienteDetalle, $txtZonaVentas);

        $txtCodigoGrupoClienteDescuentoLinea = $CodArticuloCliente[0]['CodigoGrupoDescuentoLinea'];
        $txtCodigoGrupoClienteDescuentoMultilinea = $CodArticuloCliente[0]['CodigoGrupoDescuentoMultiLinea'];

        //print_r($CodArticuloCliente);
        //die();

        $descuentoLineaConsulta = array();
        $descuentoLineaConsultaCantiadades = array();
        $descuentoLineaConsultaSL = array();

        $busquedaLinea = false;
        $busquedaLineaSL = false;
        $busquedaMultilinea = false;

        foreach ($descuentoLinea as $itemDL) {

            $itemDLCuentaCliente = $itemDL['CuentaCliente'];
            $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
            $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
            $itemDLCantidadDesde = $itemDL['CantidadDesde'];
            $itemDLCantidadHasta = $itemDL['CantidadHasta'];
            $itemDLCodigoVariante = $itemDL['CodigoVariante'];
            $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
            $itemDLCodigoClienteGrupoDescuentoLinea = $itemDL['CodigoClienteGrupoDescuentoLinea'];
            $itemDLSitio = $itemDL['Sitio'];
            $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
            $itemDLSaldoLimite = $itemDL['Saldo'];

            if (!$busquedaLinea) {
                if ($itemDLCantidadDesde > 0 && $itemDLCantidadHasta > 0) {
                    array_push($descuentoLineaConsultaCantiadades, $itemDL);
                }
            }
            if ($itemDLCantidadDesde > 0 && $itemDLCantidadHasta > 0) {
                foreach ($descuentoLineaConsultaCantiadades as $itmCanti) {


                    if ($itemDlTipoCuentaCliente == '1') {

                        if (!$busquedaLinea) {

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante)
                            ) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }
                        }
                    } else if ($itemDlTipoCuentaCliente == '2') {

                        if (!$busqueda) {

                            /* echo $CantidadConvertida.'centidad convertida';    
                              echo $itemDLTipoCuentaArticulos . '==' . '1' . '<br/>';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea . '==' . $txtCodigoGrupoClienteDescuentoLinea . '<br/>';
                              echo $itemDLCodigoVariante . '==' . $txtCodigoVariante . '<br/>';
                              echo $txtCantidad . '>=' . $itemDLCantidadDesde . '<br/>';
                              echo $txtCantidad . '<=' . $itemDLCantidadHasta . '<br/>';
                              echo $itemDLSitio . '==' . $codigoSitio . '<br/>';
                              echo $itemDLCodigoAlmacen . '==' . $codigoAlmacen . '<br/>'; */


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }
                        }
                    } else if ($itemDlTipoCuentaCliente == '3') {

                        if (!$busquedaLinea) {

                            //echo $CantidadConvertida.'centidad convertida'.'<br>';    
                            /* echo $itemDLTipoCuentaArticulos . '==' . '1' . '<br/>';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea . '==' . $txtCodigoGrupoClienteDescuentoLinea . '<br/>';
                              echo $itemDLCodigoVariante . '==' . $txtCodigoVariante . '<br/>';
                              echo $CantidadConvertida . '>=' . $itemDLCantidadDesde . '<br/>';
                              echo $CantidadConvertida . '<=' . $itemDLCantidadHasta . '<br/>';
                              echo $itemDLSitio . '==' . $codigoSitio . '<br/>';
                              echo $itemDLCodigoAlmacen . '==' . $codigoAlmacen . '<br/>'; */

                            //echo 'entre';
                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoVariante) == trim($txtCodigoVariante)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '3' && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '3' && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '3') {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busquedaLinea = true;
                                break;
                            }
                        }
                    }
                }
                //break;
            } else {

                if ($itemDlTipoCuentaCliente == '1') {

                    if (!$busquedaLineaSL) {


                        //// VALIDACION CON SALDO LIMITE
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        //////////////////////////////////////////////fin de validacion con saldo limite///////////////////////////////////////////////////////////

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                            array_push($descuentoLineaConsultaSL, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }
                    }
                } else if ($itemDlTipoCuentaCliente == '2') {


                    if (!$busquedaLineaSL) {

                        /* echo $itemDLTipoCuentaArticulos .'=='.'1'.'<br/>';
                          echo $itemDLCodigoClienteGrupoDescuentoLinea.'=='.$txtCodigoGrupoClienteDescuentoLinea.'<br/>';
                          echo $itemDLCodigoVariante.'=='.$txtCodigoVariante.'<br/>';
                          echo $itemDLSitio.'=='.$codigoSitio.'<br/>';
                          echo $itemDLCodigoAlmacen.'=='.$codigoAlmacen.'<br/>'; */
                        /* $cont++;
                          echo $cont; */

                        //////// validacion saldo limite tipo cuenta cliente 2////////////
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        /////////////////////////////////////////fin de la validacion de saldo limite //////////////////////////////////////////////////
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }
                    }
                } else if ($itemDlTipoCuentaCliente == '3') {

                    if (!$busquedaLineaSL) {

                        ///VALIDACION  SALDO LIMITE
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSaldoLimite > 0 && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSaldoLimite > 0)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        //////TERMINA LA VALIDACION DE SALDO LIMITE
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
//                            'entre 2';
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3')) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busquedaLineaSL = true;
                            break;
                        }
                    }
                }
            }
        }

        $descuentoMultiLineaConsulta = array();
        $descuentoMultilineaConsultaCantiadades = array();

        foreach ($descuentoMultiLinea as $itemDML) {

            $itemDMLCuentaCliente = $itemDML['CuentaCliente'];
            $itemDMlTipoCuentaCliente = $itemDML['TipoCuentaCliente'];
            $itemDMLCantidadDesde = $itemDML['CantidadDesde'];
            $itemDMLCantidadHasta = $itemDML['CantidadHasta'];
            $itemDMLCodigoGrupoArticulosDescuentoMultilinea = $itemDML['CodigoGrupoArticulosDescuentoMultilinea'];
            $itemDMLCodigoGrupoClienteDescuentoMultilinea = $itemDML['CodigoGrupoClienteDescuentoMultilinea'];
            $itemMDLSitio = $itemDML['Sitio'];
            $itemDMLCodigoAlmacen = $itemDML['Almacen'];

            //CON CANTIDADES   
            if (!$busqueda) {
                if ($itemDMLCantidadDesde > 0 && $itemDMLCantidadHasta > 0) {
                    array_push($descuentoMultilineaConsultaCantiadades, $itemDML);
                }
            }
            if ($itemDMLCantidadDesde > 0 && $itemDMLCantidadHasta > 0) {

                foreach ($descuentoMultilineaConsultaCantiadades as $itmMDLCanti) {

                    if ($itemDMlTipoCuentaCliente == "1") {

                        if (!$busqueda) {


                            if ((trim($itemDMLCuentaCliente) == trim($txtCuentaCliente)) && (trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) && (trim(($itemMDLSitio) == trim($codigoSitio)) && (trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && trim($itemMDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && trim($itemMDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "2") {

                        if (!$busqueda) {

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }


                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && trim($itemMDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && trim($itemMDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }


                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "3") {

                        if (!$busquedaMultilinea) {
                            if (trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ((trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) && (trim($itemMDLSitio) == trim($codigoSitio))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }


                            if ((trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }
                        }
                    }
                }
            } else {
                //SIN CANTIDADES
                if ($itemDMLCantidadDesde == '0' && $itemDMLCantidadHasta == '0') {

                    if ($itemDMlTipoCuentaCliente == "1") {

                        if (!$busquedaMultilinea) {

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == "EMPTY" && $itemDMLCodigoAlmacen == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "2") {

                        if (!$busquedaMultilinea) {

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == "EMPTY" && $itemDMLCodigoAlmacen == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "3") {

                        if (!$busquedaMultilinea) {
                            if ($itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }


                            if ($itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busquedaMultilinea = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        echo $this->renderPartial('_tableDescuentos', array(
            'txtCodigoVariante' => $txtCodigoVariante,
            'txtCodigoArticulo' => $txtCodigoArticulo,
            'txtDescripcion' => $txtNombreArticulo,
            'descuentoMultiLineaConsulta' => $descuentoMultiLineaConsulta,
            'descuentoLineaConsultaCantiadades' => $descuentoLineaConsultaCantiadades,
            'descuentoLineaConsulta' => $descuentoLineaConsulta
        ));
    }

    public function actionAjaxValidarAcuerdoLinea() {

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];


        if ($session['acuerdoLinea']) {
            $descuentoLinea = $session['acuerdoLinea'];
        } else {
            $descuentoLinea = array();
        }

        $txtCodigoVariante = $_POST['txtCodigoVariante'];
        $txtCodigoGrupoDescuentoLinea = $_POST['txtCodigoGrupoDescuentoLinea'];
        $txtCantidad = $_POST['txtCantidad'];
        $txtCodigoAcuerdoPrecioVenta = $_POST['txtUnidadMedida'];
        $txtCodigoArticulo = $_POST['txtArticulo'];
        $txtClienteDetalle = $_POST['txtClienteDetalle'];
        $txtCodigoGrupoClienteDescuentoLinea = $_POST['txtCodigoGrupoClienteDescuentoLinea'];
        $txtSaldoLimite = $_POST['txtSaldoLimite'];

        $descuentoLineaConsulta = array();
        $descuentoLineaConsultaCantiadades = array();
        $busqueda = false;


        /* echo '<pre>';
          print_r($descuentoLinea);
          exit(); */


        //$cont=0;
        foreach ($descuentoLinea as $itemDL) {


            $itemDLCuentaCliente = $itemDL['CuentaCliente'];
            $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
            $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
            $itemDLCantidadDesde = $itemDL['CantidadDesde'];
            $itemDLCantidadHasta = $itemDL['CantidadHasta'];
            $itemDLCodigoVariante = $itemDL['CodigoVariante'];
            $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
            $itemDLCodigoClienteGrupoDescuentoLinea = $itemDL['CodigoClienteGrupoDescuentoLinea'];
            $itemDLSitio = $itemDL['Sitio'];
            $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
            $itemDLCodigoUnidadMedida = $itemDL['CodigoUnidadMedida'];
            $itemDLSaldoLimite = $itemDL['Saldo'];


            if (!$busqueda) {
                if ($itemDLCantidadDesde > 0 && $itemDLCantidadHasta > 0) {
                    array_push($descuentoLineaConsultaCantiadades, $itemDL);
                }
            }




            if ($itemDLCantidadDesde > 0 && $itemDLCantidadHasta > 0) {
                foreach ($descuentoLineaConsultaCantiadades as $itmCanti) {

                    $itemDLCantidadDesde = $itmCanti['CantidadDesde'];
                    $itemDLCantidadHasta = $itmCanti['CantidadHasta'];


                    $CantidadConvertida = 0;
                    //echo $txtCodigoAcuerdoPrecioVenta .'!='. $itemDLCodigoUnidadMedida;
                    if ($txtCodigoAcuerdoPrecioVenta != $itemDLCodigoUnidadMedida) {
                        $this->codigoArticulo = $txtCodigoArticulo;
                        $this->validateAcuerdo($itemDLCodigoUnidadMedida, $txtCodigoAcuerdoPrecioVenta, $txtCantidad);
                        //echo 'entre';
                        //echo $txtCantidad .'>='. $itemDLCantidadDesde .'&&'. $itemDLCantidadHasta .'<='. $txtCantidad;
                        // if ($txtCantidad >= $itemDLCantidadDesde && $itemDLCantidadHasta <= $txtCantidad || $txtCantidad >= $itemDLCantidadDesde && $txtCantidad <= $itemDLCantidadHasta) {  
                        if ($txtCantidad >= $itemDLCantidadDesde && $txtCantidad <= $itemDLCantidadHasta) {
                            //echo 'entre'.'<br>';
                            //echo $this->cantidadConvertida;
                            ///echo $this->cantidadConvertida . '>=' .$itemDLCantidadDesde .'&&'. $itemDLCantidadHasta .'<='. $this->cantidadConvertida;
                            //if ($this->cantidadConvertida >= $itemDLCantidadDesde  && $itemDLCantidadHasta <= $this->cantidadConvertida){
                            if ($this->cantidadConvertida != "") {
                                if ($this->cantidadConvertida >= $itemDLCantidadDesde && $itemDLCantidadHasta <= $this->cantidadConvertida) {
                                    $CantidadConvertida = $this->cantidadConvertida;
                                }
                            } else {
                                $CantidadConvertida = $txtCantidad;
                            }
                        }
                    }

                    $CantidadConvertida = $txtCantidad;


                    if ($itemDlTipoCuentaCliente == '1') {

                        if (!$busqueda) {


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && trim($itemDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida)) <= trim($itemDLCantidadHasta) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDlTipoCuentaCliente == '2') {

                        if (!$busqueda) {

                            /* echo $CantidadConvertida.'centidad convertida';    
                              echo $itemDLTipoCuentaArticulos . '==' . '1' . '<br/>';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea . '==' . $txtCodigoGrupoClienteDescuentoLinea . '<br/>';
                              echo $itemDLCodigoVariante . '==' . $txtCodigoVariante . '<br/>';
                              echo $txtCantidad . '>=' . $itemDLCantidadDesde . '<br/>';
                              echo $txtCantidad . '<=' . $itemDLCantidadHasta . '<br/>';
                              echo $itemDLSitio . '==' . $codigoSitio . '<br/>';
                              echo $itemDLCodigoAlmacen . '==' . $codigoAlmacen . '<br/>'; */


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($itemDLCantidadHasta) <= trim($CantidadConvertida)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDlTipoCuentaCliente == '3') {

                        if (!$busqueda) {

                            //echo $CantidadConvertida.'centidad convertida'.'<br>';    
                            /* echo $itemDLTipoCuentaArticulos . '==' . '1' . '<br/>';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea . '==' . $txtCodigoGrupoClienteDescuentoLinea . '<br/>';
                              echo $itemDLCodigoVariante . '==' . $txtCodigoVariante . '<br/>';
                              echo $CantidadConvertida . '>=' . $itemDLCantidadDesde . '<br/>';
                              echo $CantidadConvertida . '<=' . $itemDLCantidadHasta . '<br/>';
                              echo $itemDLSitio . '==' . $codigoSitio . '<br/>';
                              echo $itemDLCodigoAlmacen . '==' . $codigoAlmacen . '<br/>'; */

                            //echo 'entre';
                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && trim($itemDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida)) <= trim($itemDLCantidadHasta) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '3' && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDLTipoCuentaArticulos) == '3' && trim($itemDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '3' && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
                //break;
            } else {

                if ($itemDlTipoCuentaCliente == '1') {

                    if (!$busqueda) {


                        //// VALIDACION CON SALDO LIMITE
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        //////////////////////////////////////////////fin de validacion con saldo limite///////////////////////////////////////////////////////////

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }
                    }
                } elseif ($itemDlTipoCuentaCliente == '2') {


                    if (!$busqueda) {

                        /* echo $itemDLTipoCuentaArticulos .'=='.'1'.'<br/>';
                          echo $itemDLCodigoClienteGrupoDescuentoLinea.'=='.$txtCodigoGrupoClienteDescuentoLinea.'<br/>';
                          echo $itemDLCodigoVariante.'=='.$txtCodigoVariante.'<br/>';
                          echo $itemDLSitio.'=='.$codigoSitio.'<br/>';
                          echo $itemDLCodigoAlmacen.'=='.$codigoAlmacen.'<br/>'; */
                        /* $cont++;
                          echo $cont; */

                        //////// validacion saldo limite tipo cuenta cliente 2////////////
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        /////////////////////////////////////////fin de la validacion de saldo limite //////////////////////////////////////////////////
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }
                    }
                } elseif ($itemDlTipoCuentaCliente == '3') {

                    if (!$busqueda) {

                        ///VALIDACION  SALDO LIMITE
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSaldoLimite == $txtSaldoLimite && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSaldoLimite == $txtSaldoLimite)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        //////TERMINA LA VALIDACION DE SALDO LIMITE
                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
//                            'entre 2';
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoVariante == $txtCodigoVariante)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }


                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3' && $itemDLSitio == $codigoSitio)) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }

                        if (($itemDLTipoCuentaArticulos == '3')) {
                            array_push($descuentoLineaConsulta, $itemDL);
                            $busqueda = true;
                            break;
                        }
                    }
                }
            }
        }
        // 
        /* echo '<pre>';
          print_r($descuentoLineaConsulta);
          exit(); */

        $fechaMayor = '0000-00-00';

        foreach ($descuentoLineaConsulta as $itemConsulta) {

            $fechaInicio = $itemConsulta['FechaInicio'];


            if ($fechaInicio >= $fechaMayor) {

                $descuento1 = $itemConsulta['PorcentajeDescuentoLinea1'];
                $descuento2 = $itemConsulta['PorcentajeDescuentoLinea2'];
                $IdAcuerdoComercial = $itemConsulta['IdAcuerdoComercial'];
                $CodigoUnidadMedida = $itemConsulta['CodigoUnidadMedida'];
                $fechaMayor = $fechaInicio;
                //break;
            }
        }


        $arrayRespuesta = array();

        $totalDescuento = $descuento1 + $descuento2;


        $arrayRespuesta = array(
            "descuentoLinea" => $totalDescuento,
            "acuerdoComercial" => $IdAcuerdoComercial,
            "unidadMedidaAcuerdo" => $CodigoUnidadMedida,
        );

        /* echo '<pre>';
          print_r($arrayRespuesta);
          exit(); */

        echo json_encode($arrayRespuesta);
    }

    public function actionAjaxValidarAcuerdoMultiLinea() {

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];

        if ($session['acuerdoMultiLinea']) {
            $descuentoMultiLinea = $session['acuerdoMultiLinea'];
        } else {
            $descuentoMultiLinea = array();
        }

        $txtCodigoVariante = $_POST['txtCodigoVariante'];
        $txtCodigoGrupoDescuentoMultiLinea = $_POST['txtCodigoGrupoDescuentoMultiLinea'];
        $txtCuentaCliente = $_POST['txtClienteDetalle'];
        $txtCantidad = $_POST['txtCantidad'];
        $txtUnidadMedida = $_POST['txtUnidadMedida'];
        $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
        $txtCodigoGrupoClienteDescuentoMultilinea = $_POST['txtCodigoGrupoClienteDescuentoMultilinea'];

        $descuentoMultiLineaConsulta = array();
        $descuentoMultilineaConsultaCantiadades = array();
        $busqueda = false;

        /* echo '<pre>';
          print_r($descuentoMultiLinea); */

        foreach ($descuentoMultiLinea as $itemDML) {

            $itemDMLCuentaCliente = $itemDML['CuentaCliente'];
            $itemDMlTipoCuentaCliente = $itemDML['TipoCuentaCliente'];
            $itemDMLCantidadDesde = $itemDML['CantidadDesde'];
            $itemDMLCantidadHasta = $itemDML['CantidadHasta'];
            $itemDMLCodigoGrupoArticulosDescuentoMultilinea = $itemDML['CodigoGrupoArticulosDescuentoMultilinea'];
            $itemDMLCodigoGrupoClienteDescuentoMultilinea = $itemDML['CodigoGrupoClienteDescuentoMultilinea'];
            $itemMDLSitio = $itemDML['Sitio'];
            $itemDMLCodigoAlmacen = $itemDML['Almacen'];
            $itemDMLCodigoUnidadMedida = $itemDML['CodigoUnidadMedida'];

            //CON CANTIDADES   
            if (!$busqueda) {
                if ($itemDMLCantidadDesde > 0 && $itemDMLCantidadHasta > 0) {
                    array_push($descuentoMultilineaConsultaCantiadades, $itemDML);
                }
            }

            if ($itemDMLCantidadDesde > 0 && $itemDMLCantidadHasta > 0) {

                foreach ($descuentoMultilineaConsultaCantiadades as $itmMDLCanti) {


                    $itemDMLCantidadDesde = $itmMDLCanti['CantidadDesde'];
                    $itemDMLCantidadHasta = $itmMDLCanti['CantidadHasta'];

                    /* echo $itemDMLCantidadDesde.'<br/>';
                      echo $itemDMLCantidadHasta.'<br/>';
                      echo $txtUnidadMedida.'<br/>';
                      echo $txtUnidadMedida .'!='. $itemDMLCodigoUnidadMedida.'<br/>'; */
                    //echo 'entre'.'<br/>';

                    $CantidadConvertida = 0;
                    if ($txtUnidadMedida != $itemDMLCodigoUnidadMedida) {
                        $this->codigoArticulo = $txtCodigoArticulo;
                        $this->validateAcuerdo($itemDMLCodigoUnidadMedida, $txtUnidadMedida, $txtCantidad);
                        if ($txtCantidad >= $itemDMLCantidadDesde && $txtCantidad <= $itemDMLCantidadHasta) {
                            //echo $this->cantidadConvertida . '>=' . $itemDMLCantidadDesde . '&&' . $itemDMLCantidadHasta . '<=' . $this->cantidadConvertida;
                            //if ($this->cantidadConvertida >= $itemDLCantidadDesde  && $itemDLCantidadHasta <= $this->cantidadConvertida){
                            if ($this->cantidadConvertida != "") {
                                if ($this->cantidadConvertida >= $itemDMLCantidadDesde && $itemDMLCantidadHasta <= $this->cantidadConvertida) {
                                    $CantidadConvertida = $this->cantidadConvertida;
                                }
                            } else {
                                $CantidadConvertida = $txtCantidad;
                            }
                        }
                    } else {

                        $CantidadConvertida = $txtCantidad;
                    }

                    $CantidadConvertida = $txtCantidad;
                    if ($itemDMlTipoCuentaCliente == "1") {

                        if (!$busqueda) {


                            if ((trim($itemDMLCuentaCliente) == trim($txtCuentaCliente)) && (trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) && (trim(($itemMDLSitio) == trim($codigoSitio)) && (trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen))) && ((trim($CantidadConvertida) >= trim($itemDMLCantidadDesde)) && (trim($CantidadConvertida) <= trim($itemDMLCantidadHasta)))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "2") {

                        if (!$busqueda) {

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "3") {

                        if (!$busqueda) {
                            if (trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ((trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) && (trim($itemMDLSitio) == trim($codigoSitio)) && ((trim($CantidadConvertida) >= trim($itemDMLCantidadDesde)) && (trim($CantidadConvertida) <= trim($itemDMLCantidadHasta)))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }


                            if ((trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea)) && ((trim($CantidadConvertida) >= trim($itemDMLCantidadDesde)) && (trim($CantidadConvertida) <= trim($itemDMLCantidadHasta)))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
            } else {

                //SIN CANTIDADES
                if ($itemDMLCantidadDesde == '0' && $itemDMLCantidadHasta == '0') {

                    if ($itemDMlTipoCuentaCliente == "1") {

                        if (!$busqueda) {

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == "EMPTY" && $itemDMLCodigoAlmacen == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "2") {

                        if (!$busqueda) {

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == "EMPTY" && $itemDMLCodigoAlmacen == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "3") {

                        if (!$busqueda) {
                            if ($itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }


                            if ($itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        $fechaMayor = '0000-00-00';
        foreach ($descuentoMultiLineaConsulta as $itemConsulta) {

            $fechaInicio = $itemConsulta['FechaInicio'];

            if ($fechaInicio >= $fechaMayor) {
                $descuento1 = $itemConsulta['PorcentajeDescuentoMultilinea1'];
                $descuento2 = $itemConsulta['PorcentajeDescuentoMultilinea2'];
                $IdAcuerdoComercial = $itemConsulta['IdAcuerdoComercial'];
                $CodigoUnidadMedida = $itemConsulta['CodigoUnidadMedida'];
                $CodigoGrupoArticulosDescuentoMultilinea = $itemConsulta['CodigoGrupoArticulosDescuentoMultilinea'];
                $DMLCantidadDesde2 = $itemConsulta['CantidadDesde'];
                $DMLCantidadHasta2 = $itemConsulta['CantidadHasta'];

                $fechaMayor = $fechaInicio;
                //break;
            }
        }

        $arrayRespuesta = array();


        $totalDescuento = $descuento1 + $descuento2;

        if ($IdAcuerdoComercial == null) {

            $IdAcuerdoComercial = 0;
        }

        if ($CodigoUnidadMedida == null) {

            $CodigoUnidadMedida = 0;
        }

        if ($CodigoGrupoArticulosDescuentoMultilinea == null) {

            $CodigoGrupoArticulosDescuentoMultilinea = 0;
        }

        $arrayRespuesta = array(
            'descuentoMultiLinea' => $totalDescuento,
            'acuerdoComercialMulti' => $IdAcuerdoComercial,
            'nidadMedidaAcuerdoMulti' => $CodigoUnidadMedida,
            'CodigoGrupoArticulosDescuentoMultilinea' => $CodigoGrupoArticulosDescuentoMultilinea,
            'DMLCantidadDesde2' => $DMLCantidadDesde2,
            'DMLCantidadHasta2' => $DMLCantidadHasta2
        );

        echo json_encode($arrayRespuesta);
    }

    private function validarAcuerdoMultiLinea($txtCodigoVariante, $txtCodigoGrupoDescuentoMultiLinea, $txtCantidad, $txtUnidadMedida, $txtCodigoArticulo, $txtCuentaCliente, $txtCodigoGrupoClienteDescuentoMultilinea) {

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];

        if ($session['acuerdoMultiLinea']) {
            $descuentoMultiLinea = $session['acuerdoMultiLinea'];
        } else {
            $descuentoMultiLinea = array();
        }

        $txtCodigoVariante = $txtCodigoVariante;
        $txtCodigoGrupoDescuentoMultiLinea = $txtCodigoGrupoDescuentoMultiLinea;
        $txtCantidad = $txtCantidad;
        $txtUnidadMedida = $txtUnidadMedida;
        $txtCodigoArticulo = $txtCodigoArticulo;
        $txtCuentaCliente = $txtCuentaCliente;
        $txtCodigoGrupoClienteDescuentoMultilinea = $txtCodigoGrupoClienteDescuentoMultilinea;

        $descuentoMultiLineaConsulta = array();
        $descuentoMultilineaConsultaCantiadades = array();
        $busqueda = false;


        foreach ($descuentoMultiLinea as $itemDML) {

            $itemDMLCuentaCliente = $itemDML['CuentaCliente'];
            $itemDMlTipoCuentaCliente = $itemDML['TipoCuentaCliente'];
            $itemDMLCantidadDesde = $itemDML['CantidadDesde'];
            $itemDMLCantidadHasta = $itemDML['CantidadHasta'];
            $itemDMLCodigoGrupoArticulosDescuentoMultilinea = $itemDML['CodigoGrupoArticulosDescuentoMultilinea'];
            $itemDMLCodigoGrupoClienteDescuentoMultilinea = $itemDML['CodigoGrupoClienteDescuentoMultilinea'];
            $itemMDLSitio = $itemDML['Sitio'];
            $itemDMLCodigoAlmacen = $itemDML['Almacen'];
            $itemDMLCodigoUnidadMedida = $itemDML['CodigoUnidadMedida'];

            //CON CANTIDADES   
            if (!$busqueda) {
                if ($itemDMLCantidadDesde > 0 && $itemDMLCantidadHasta > 0) {
                    array_push($descuentoMultilineaConsultaCantiadades, $itemDML);
                }
            }

            if ($itemDMLCantidadDesde > 0 && $itemDMLCantidadHasta > 0) {

                foreach ($descuentoMultilineaConsultaCantiadades as $itmMDLCanti) {


                    $itemDMLCantidadDesde = $itmMDLCanti['CantidadDesde'];
                    $itemDMLCantidadHasta = $itmMDLCanti['CantidadHasta'];



                    $CantidadConvertida = 0;
                    if ($txtUnidadMedida != $itemDMLCodigoUnidadMedida) {
                        echo 'entre a validar cantidades';
                        $this->codigoArticulo = $txtCodigoArticulo;
                        $this->validateAcuerdo($itemDMLCodigoUnidadMedida, $txtUnidadMedida, $txtCantidad);
                        if ($txtCantidad >= $itemDMLCantidadDesde && $txtCantidad <= $itemDMLCantidadHasta) {
                            echo $this->cantidadConvertida . '>=' . $itemDMLCantidadDesde . '&&' . $itemDMLCantidadHasta . '<=' . $this->cantidadConvertida;
                            //if ($this->cantidadConvertida >= $itemDLCantidadDesde  && $itemDLCantidadHasta <= $this->cantidadConvertida){
                            if ($this->cantidadConvertida != "") {
                                if ($this->cantidadConvertida >= $itemDMLCantidadDesde && $itemDMLCantidadHasta <= $this->cantidadConvertida) {
                                    $CantidadConvertida = $this->cantidadConvertida;
                                }
                            } else {
                                $CantidadConvertida = $txtCantidad;
                            }
                        }
                    } else {

                        $CantidadConvertida = $txtCantidad;
                    }
                    $CantidadConvertida = $txtCantidad;

                    if ($itemDMlTipoCuentaCliente == "1") {

                        if (!$busqueda) {

                            //trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCuentaCliente) == trim($txtCuentaCliente) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "2") {

                        if (!$busqueda) {

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == trim($txtCodigoGrupoDescuentoMultiLinea) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($itemMDLSitio) == trim($codigoSitio) && trim($itemDMLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && trim($itemMDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }


                            if (trim($itemDMLCodigoGrupoClienteDescuentoMultilinea) == trim($txtCodigoGrupoClienteDescuentoMultilinea) && trim($itemDMLCodigoGrupoArticulosDescuentoMultilinea) == "EMPTY" && (trim($CantidadConvertida) >= trim($itemDMLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDMLCantidadHasta))) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
            } else {

                //SIN CANTIDADES
                if ($itemDMLCantidadDesde == '0' && $itemDMLCantidadHasta == '0') {

                    if ($itemDMlTipoCuentaCliente == "1") {

                        if (!$busqueda) {

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCuentaCliente == $txtCuentaCliente && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDMlTipoCuentaCliente == "2") {

                        if (!$busqueda) {

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == $txtCodigoGrupoDescuentoMultiLinea) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio && $itemDMLCodigoAlmacen == $codigoAlmacen) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == $codigoSitio) {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }

                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY") {
                                array_push($descuentoMultiLineaConsulta, $itemDML);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
            }
        }

        $fechaMayor = '0000-00-00';
        foreach ($descuentoMultiLineaConsulta as $itemConsulta) {

            $fechaInicio = $itemConsulta['FechaInicio'];

            if ($fechaInicio >= $fechaMayor) {
                $descuento1 = $itemConsulta['PorcentajeDescuentoMultilinea1'];
                $descuento2 = $itemConsulta['PorcentajeDescuentoMultilinea2'];
                $IdAcuerdoComercial = $itemConsulta['IdAcuerdoComercial'];
                $CodigoUnidadMedida = $itemConsulta['CodigoUnidadMedida'];
                $CodigoGrupoArticulosDescuentoMultilinea = $itemConsulta['CodigoGrupoArticulosDescuentoMultilinea'];

                $fechaMayor = $fechaInicio;
                //break;
            }
        }

        $arrayRespuesta = array();


        $totalDescuento = $descuento1 + $descuento2;

        if ($IdAcuerdoComercial == null) {

            $IdAcuerdoComercial = 0;
        }

        if ($CodigoUnidadMedida == null) {

            $CodigoUnidadMedida = 0;
        }

        if ($CodigoGrupoArticulosDescuentoMultilinea == null) {

            $CodigoGrupoArticulosDescuentoMultilinea = 0;
        }

        $arrayRespuesta = array(
            'descuentoMultiLinea' => $totalDescuento,
            'acuerdoComercialMulti' => $IdAcuerdoComercial,
            'nidadMedidaAcuerdoMulti' => $CodigoUnidadMedida,
            'CodigoGrupoArticulosDescuentoMultilinea' => $CodigoGrupoArticulosDescuentoMultilinea
        );


        return $arrayRespuesta;
    }

    private function validateAcuerdo($unidadDesde, $unidadHasta, $cantidadConvertir) {



        $this->cargarUnidadesConversion = Preventa::model()->cargarUnidadesConversion();
        $this->unidadesConversion = Preventa::model()->getDataReader();

        $this->cantidadConvertida = "";
        foreach ($this->unidadesConversion as $itemUnidades) {

            $codigoArticuloUnidad = $itemUnidades['CodigoArticulo'];
            $unidadArticuloDesdeUnidad = $itemUnidades['CodigoDesdeUnidad'];
            $unidadArticuloHastaUnidad = $itemUnidades['CodigoHastaUnidad'];
            $unidadFactorConversion = $itemUnidades['Factor'];
            if ($this->codigoArticulo == $codigoArticuloUnidad) {

                if ($unidadArticuloDesdeUnidad == $unidadDesde && $unidadArticuloHastaUnidad == $unidadHasta) {
                    $this->unidadDesde = $unidadArticuloDesdeUnidad;
                    $this->unidadHasta = $unidadArticuloHastaUnidad;

                    if (!$this->calcularDigitoOperacion()) {
                        echo $this->txtError = "No se han podido calcular los digitos";
                    } else {
                        if ($this->operacion == "Division") {
                            $this->cantidadConvertida = $cantidadConvertir / $unidadFactorConversion;
                        } else {
                            $this->cantidadConvertida = $cantidadConvertir * $unidadFactorConversion;
                        }
                    }
                }
            }
        }
    }

    public function actionAjaxValidarConsignacion() {

        if ($_POST) {

            $cedulasesor = $_POST['cedulaasesor'];

            $saldodisponibleasesor = Consultas::model()->getAsesorVetaConsignacion($cedulasesor);

            $Disponible = $saldodisponibleasesor[0]['saldodisponible'];

            if ($Disponible > 0) {

                echo '1';
            } else {

                echo '0';
            }
        }
    }

    public function actionAjaxCargarSaldoLote() {

        if ($_POST) {

            $lote = $_POST['lote'];
            $ubicacion = $_POST['ubicacion'];
            $variante = $_POST['variante'];

            $LoteDisponible = Consultas::model()->getSaltoLote($lote, $ubicacion, $variante);

            $Disponible = $LoteDisponible[0]['Disponible'];

            echo $Disponible;
        }
    }

    public function ValidarAcuerdoLinea($CodigoVariante, $CodigoGrupoClienteDescuentoLinea, $CuentaCliente, $CodigoGrupoDescuentoLinea, $Cantidad, $Articulo, $CodigoUnidadMedida) {

        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];


        if ($session['acuerdoLinea']) {
            $descuentoLinea = $session['acuerdoLinea'];
        } else {
            $descuentoLinea = array();
        }

        $txtCodigoVariante = $CodigoVariante;
        $txtCodigoGrupoClienteDescuentoLinea = $CodigoGrupoClienteDescuentoLinea;
        $txtClienteDetalle = $CuentaCliente;
        $txtCodigoGrupoDescuentoLinea = $CodigoGrupoDescuentoLinea;
        $txtCantidad = $Cantidad;
        $txtCodigoArticulo = $Articulo;
        $txtCodigoAcuerdoPrecioVenta = $CodigoUnidadMedida;
        /* echo $txtCodigoVariante.'<br/>';
          echo $txtCodigoGrupoClienteDescuentoLinea.'<br/>';
          echo $txtClienteDetalle.'<br>';
          echo $codigoSitio.'<br>';
          echo $codigoAlmacen.'<br>';
          echo $txtCodigoGrupoDescuentoLinea.'<br/>';
          echo $txtCantidad.'<br/>';
          echo $txtCodigoArticulo.'<br/>';
          echo $txtCodigoAcuerdoPrecioVenta.'<br/>';
          exit(); */


        /* $txtCantidad = $_POST['txtCantidad'];
          $txtCodigoAcuerdoPrecioVenta = $_POST['txtUnidadMedida'];
          $txtCodigoArticulo = $_POST['txtArticulo'];
          $txtClienteDetalle = $_POST['txtClienteDetalle'];
          $txtCodigoGrupoClienteDescuentoLinea = $_POST['txtCodigoGrupoClienteDescuentoLinea'];
          $txtSaldoLimite = $_POST['txtSaldoLimite']; */

        $descuentoLineaConsulta = array();
        $descuentoLineaConsultaCantiadades = array();
        $busqueda = false;


        foreach ($descuentoLinea as $itemDL) {


            $itemDLCuentaCliente = $itemDL['CuentaCliente'];
            $itemDlTipoCuentaCliente = $itemDL['TipoCuentaCliente'];
            $itemDLTipoCuentaArticulos = $itemDL['TipoCuentaArticulos'];
            $itemDLCodigoVariante = $itemDL['CodigoVariante'];
            $itemDLCodigoArticuloGrupoDescuentoLinea = $itemDL['CodigoArticuloGrupoDescuentoLinea'];
            $itemDLCodigoClienteGrupoDescuentoLinea = $itemDL['CodigoClienteGrupoDescuentoLinea'];
            $itemDLSitio = $itemDL['Sitio'];
            $itemDLCodigoAlmacen = $itemDL['CodigoAlmacen'];
            $itemDLCantidadDesde = $itemDL['CantidadDesde'];
            $itemDLCantidadHasta = $itemDL['CantidadHasta'];
            $itemDLCodigoUnidadMedida = $itemDL['CodigoUnidadMedida'];
            $itemDLSaldo = $itemDL['Saldo'];



            if (!$busqueda) {
                if ($itemDLCantidadDesde > 0 && $itemDLCantidadHasta > 0 && $itemDLSaldo == 0) {
                    array_push($descuentoLineaConsultaCantiadades, $itemDL);
                }
            }


            if ($itemDLCantidadDesde > 0 && $itemDLCantidadHasta > 0 && $itemDLSaldo == 0) {
                foreach ($descuentoLineaConsultaCantiadades as $itmCanti) {

                    $itemDLCantidadDesde = $itmCanti['CantidadDesde'];
                    $itemDLCantidadHasta = $itmCanti['CantidadHasta'];


                    $CantidadConvertida = 0;
                    if ($txtCodigoAcuerdoPrecioVenta != $itemDLCodigoUnidadMedida) {
                        $this->codigoArticulo = $txtCodigoArticulo;
                        $this->validateAcuerdo($itemDLCodigoUnidadMedida, $txtCodigoAcuerdoPrecioVenta, $txtCantidad);
                        if ($txtCantidad >= $itemDLCantidadDesde && $txtCantidad <= $itemDLCantidadHasta) {
                            if ($this->cantidadConvertida != "") {
                                if ($this->cantidadConvertida >= $itemDLCantidadDesde && $this->cantidadConvertida <= $itemDLCantidadHasta) {
                                    $CantidadConvertida = $this->cantidadConvertida;
                                    //echo $CantidadConvertida;
                                }
                            } else {
                                $CantidadConvertida = $txtCantidad;
                            }
                        }
                    }



                    if ($itemDlTipoCuentaCliente == '1') {

                        if (!$busqueda) {


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen)) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && trim($itemDLSitio) == trim($codigoSitio) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida)) <= trim($itemDLCantidadHasta) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCuentaCliente) == trim($txtClienteDetalle) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDlTipoCuentaCliente == '2') {

                        if (!$busqueda) {

                            /* echo $CantidadConvertida.'centidad convertida';    
                              echo $itemDLTipoCuentaArticulos . '==' . '1' . '<br/>';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea . '==' . $txtCodigoGrupoClienteDescuentoLinea . '<br/>';
                              echo $itemDLCodigoVariante . '==' . $txtCodigoVariante . '<br/>';
                              echo $txtCantidad . '>=' . $itemDLCantidadDesde . '<br/>';
                              echo $txtCantidad . '<=' . $itemDLCantidadHasta . '<br/>';
                              echo $itemDLSitio . '==' . $codigoSitio . '<br/>';
                              echo $itemDLCodigoAlmacen . '==' . $codigoAlmacen . '<br/>'; */


                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($itemDLCantidadHasta) <= trim($CantidadConvertida)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '1' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoVariante) == trim($txtCodigoVariante) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && (trim($itemDLSitio) == trim($codigoSitio) && trim($itemDLCodigoAlmacen) == trim($codigoAlmacen))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta)) && trim($itemDLSitio) == trim($codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (trim($itemDLTipoCuentaArticulos) == '2' && trim($itemDLCodigoClienteGrupoDescuentoLinea) == trim($txtCodigoGrupoClienteDescuentoLinea) && trim($itemDLCodigoArticuloGrupoDescuentoLinea) == trim($txtCodigoGrupoDescuentoLinea) && (trim($CantidadConvertida) >= trim($itemDLCantidadDesde) && trim($CantidadConvertida) <= trim($itemDLCantidadHasta))) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
                //break;
            } else {

                if ($itemDLCantidadDesde == 0 && $itemDLCantidadHasta == 0 && $itemDLSaldo == 0) {


                    if ($itemDlTipoCuentaCliente == '1') {

                        if (!$busqueda) {


                            if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '1' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoVariante == $txtCodigoVariante)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '2' && $itemDLCuentaCliente == $txtClienteDetalle && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    } elseif ($itemDlTipoCuentaCliente == '2') {


                        if (!$busqueda) {



                            if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }


                            if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante && $itemDLSitio == $codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            /* echo 'ppp';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea .'=='. $txtCodigoGrupoClienteDescuentoLinea.'<br/>';
                              echo $itemDLCodigoVariante .'=='. $txtCodigoVariante.'<br/>';
                              echo $itemDLTipoCuentaArticulos .'=='. '1'.'<br/>'; */
                            if (($itemDLTipoCuentaArticulos == '1' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoVariante == $txtCodigoVariante)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio && $itemDLCodigoAlmacen == $codigoAlmacen)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea && $itemDLSitio == $codigoSitio)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }

                            if (($itemDLTipoCuentaArticulos == '2' && $itemDLCodigoClienteGrupoDescuentoLinea == $txtCodigoGrupoClienteDescuentoLinea && $itemDLCodigoArticuloGrupoDescuentoLinea == $txtCodigoGrupoDescuentoLinea)) {
                                array_push($descuentoLineaConsulta, $itemDL);
                                $busqueda = true;
                                break;
                            }
                        }
                    }
                }
            }
        }


        $fechaMayor = '0000-00-00';

        foreach ($descuentoLineaConsulta as $itemConsulta) {

            $fechaInicio = $itemConsulta['FechaInicio'];


            if ($fechaInicio >= $fechaMayor) {

                $descuento1 = $itemConsulta['PorcentajeDescuentoLinea1'];
                $descuento2 = $itemConsulta['PorcentajeDescuentoLinea2'];
                $IdAcuerdoComercial = $itemConsulta['IdAcuerdoComercial'];
                $CodigoUnidadMedida = $itemConsulta['CodigoUnidadMedida'];
                $fechaMayor = $fechaInicio;
                //break;
            }
        }



        $arrayRespuesta = array();

        $totalDescuento = $descuento1 + $descuento2;


        $arrayRespuesta = array(
            "descuentoLinea" => $totalDescuento,
            "acuerdoComercial" => $IdAcuerdoComercial,
            "unidadMedidaAcuerdo" => $CodigoUnidadMedida,
        );

        /* echo '<pre>';
          print_r($arrayRespuesta);
          exit(); */

        return $arrayRespuesta;
    }

    public function actionAjaxPedidoMinimo() {


        if ($_POST) {


            $session = new CHttpSession;
            $session->open();
            $datos = $session['datosCompletarForm'];
            $datoPedido = $session['pedidoForm'];
            $datosKit = $session['componenteKitDinamico'];

            $session['pedidoFromAlmacenado'] = $datoPedido;
            $session['componenteKitDinamicoAlmacenado'] = $datosKit;


            $CodAsesor = $_POST['codAasesor'];
            $CodZonaVentas = $_POST['zona'];
            $CuentaCliente = $_POST['cuentaCliente'];
            $codigoGrupodeImpuestos = $_POST['codGrupoImpuesto'];
            $codigoZonaLogistica = $_POST['codZonaLogistica'];


            $consulta = Consultas::model()->getGrupoPrecio($CodZonaVentas, $CuentaCliente);
            $consulta1 = Consultas::model()->getGrupoImpuesto($CodZonaVentas, $CuentaCliente);
            $grupoVentas = Preventa::model()->cargarGrupoVentas($CodZonaVentas);

            $CodGrupoVenta = $grupoVentas['CodigoGrupoVentas'];
            $CodGrupoImpuestos = $consulta1['CodigoGrupodeImpuestos'];


            $CodGrupoPrecios = $consulta['CodigoGrupoPrecio'];
            $Ruta = $datos['diaRuta'];
            $CodigoSitio = $_POST['codigositio'];
            $CodigoAlmacen = $_POST['codigoAlmacen'];
            $FechaPedido = date('Y-m-d');
            $HoraDigitado = $_POST['hora'];
            $HoraEnviado = date('H:i:s');
            $FechaEntrega = $_POST['fechaentrega'];
            $FormaPago = $_POST['formaPago'];
            $Plazo = $_POST['plazo'];
            $TipoVenta = $_POST['tipoVenta'];
            $ActividadEspecial = $_POST['selactividadEspecial'];
            $Observacion = $_POST['Observaciones'];
            $SaldoCupo = $_POST['SaldoCupo'];
            $latitud = $_POST['latitud'];
            $longitud = $_POST['longitud'];


            $PrecioNeto = $_POST['precioneto'];
            $DescProveedor = $_POST['descuentopro'];
            $DescAltipal = $_POST['descuentoalti'];
            $DescEspecial = $_POST['descuentoespecial'];
            $ValorTotalDescuento = $_POST['valortotaldescuento'];
            $Impoconsumo = $_POST['impoconsumo'];
            $BaseIva = $_POST['baseiva'];
            $Iva = $_POST['iva'];
            $TotalPedido = $_POST['totalpedido'];


            $totalesAlmacenados = array(
                'PrecioNeto' => $PrecioNeto,
                'DescProveedor' => $DescProveedor,
                'DescAltipal' => $DescAltipal,
                'DescEspecial' => $DescEspecial,
                'ValorTotalDescuento' => $ValorTotalDescuento,
                'Impoconsumo' => $Impoconsumo,
                'BaseIva' => $BaseIva,
                'Iva' => $Iva,
                'TotalPedido' => $TotalPedido,
            );


            $pedidoAlamcenado = array(
                'CodAsesor' => $CodAsesor,
                'CodZonaVentas' => $CodZonaVentas,
                'CuentaCliente' => $CuentaCliente,
                'CodigoGrupodeImpuestos' => $codigoGrupodeImpuestos,
                'CodigoZonaLogistica' => $codigoZonaLogistica,
                'CodGrupoVenta' => $CodGrupoVenta,
                'CodGrupoImpuestos' => $CodGrupoImpuestos,
                'CodGrupoPrecios' => $CodGrupoPrecios,
                'Ruta' => $Ruta,
                'CodigoSitio' => $CodigoSitio,
                'CodigoAlmacen' => $CodigoAlmacen,
                'FechaPedido' => $FechaPedido,
                'HoraDigitado' => $HoraDigitado,
                'HoraEnviado' => $HoraEnviado,
                'FechaEntrega' => $FechaEntrega,
                'FormaPago' => $FormaPago,
                'Plazo' => $Plazo,
                'TipoVenta' => $TipoVenta,
                'ActividadEspecial' => $ActividadEspecial,
                'Observacion' => $Observacion,
                'SaldoCupo' => $SaldoCupo,
                'TotalPedido' => $TotalPedido,
                'latitud' => $latitud,
                'longitud' => $longitud
            );


            $session['EncabezadoPedidoAlamcenado'] = $pedidoAlamcenado;
            $session['TotalesAlmacenados'] = $totalesAlmacenados;
        }
    }

    public function actionAjaxProveedoresGrupoVentas() {

        $session = new CHttpSession;
        $session->open();
        $portafolioPreventa = $session['portafolio'];
        $CodZonaVentas = $_POST['CodeZonaVentas'];
        $Agencia = Consultas::model()->getAllAgencia($CodZonaVentas);
        foreach ($Agencia as $itemAgencia) {
            $CodigoAgencia = $itemAgencia['Agencia'];
        }
        $arrayProveedoresVentaDirecta = Consultas::model()->getProveedoresVentadirecta($CodigoAgencia);

        $select.='<select class="form-control prove" id="Proveedores">';

        $arrayProvedores = array();
        foreach ($arrayProveedoresVentaDirecta as $itemProve) {



            $PortafolioProveedor = Consultas::model()->getNombreProveedor($itemProve['CodProveedor']);

            if ($itemProve['CodProveedor'] > '0') {

                if (!in_array($itemProve['CodProveedor'] . "~" . $PortafolioProveedor['NombreCuentaProveedor'], $arrayProvedores)) {



                    array_push($arrayProvedores, $itemProve['CodProveedor'] . "~" . $PortafolioProveedor['NombreCuentaProveedor']);
                }
            }
        }
//        foreach ($portafolioPreventa as $itemProve) {
//
//
//
//            $PortafolioProveedor = Consultas::model()->getNombreProveedor($itemProve['CuentaProveedor']);
//
//            if ($itemProve['CuentaProveedor'] > '0') {
//
//                if (!in_array($itemProve['CuentaProveedor'] . "~" . $PortafolioProveedor['NombreCuentaProveedor'], $arrayProvedores)) {
//
//
//
//                    array_push($arrayProvedores, $itemProve['CuentaProveedor'] . "~" . $PortafolioProveedor['NombreCuentaProveedor']);
//                }
//            }
//        }

        foreach ($arrayProvedores as $prove) {


            $datos = explode("~", $prove);
            $select.='
                
                      <option value="' . $datos[0] . '" >' . $datos[1] . '</option>  
                        
                        ';
        }

        $select.='</select>';

        echo $select;
    }

    public function actionAjaxCargarVentaDirecta() {

        $cuentaproveedor = $_POST["cuentaproveedor"];

        echo $this->renderPartial('TablaVentaDirecta', array("cuentaproveedor" => $cuentaproveedor));
    }

    public function actionAjaxObtenerCodigoVentas($NombreZona) {

        $CodigoZonaVentas = Consultas::model()->getNombreProveedor($NombreZona);
        $CZV = $CodigoZonaVentas["CodigoZonaVentas"];

        return $CZV;
    }

    public function actionValorConInpuestoKid($txtCodigoVariante, $iva, $codgrupoVentas, $Inpuesto) {
        //return 'hola';

        try {
            if ($txtCodigoVariante != "") {
                $arrayProveedoresVentaDirecta = Consultas::model()->getListaMaterialesDetalles($txtCodigoVariante, $codgrupoVentas);
                $ValorSinImpuestoKit = 0;
                $ValorTodoConImpuestosKit = 0;


                foreach ($arrayProveedoresVentaDirecta as $item) {
                    $ValorComponetesKit = $item['PrecioVentaBaseVariante'] * $item['CantidadComponente'];
                    $ValorSinImpuestoKit = $ValorSinImpuestoKit + $ValorComponetesKit;
                    $ValorivaComponenteskit = $item['PrecioVentaBaseVariante'] * $item['PorcentajedeIVA'] / 100;
                    $TotalTodoComponentesKit = $item['PrecioVentaBaseVariante'] + $ValorivaComponenteskit + $item['ValorIMPOCONSUMO'];
                    $ValorConImpuestosKit = $TotalTodoComponentesKit * $item['CantidadComponente'];
                    $ValorTodoConImpuestosKit = $ValorTodoConImpuestosKit + $ValorConImpuestosKit;
                }
                $itemPorACPrecioVenta = $ValorSinImpuestoKit;
                $TotalValorConImpuesto = $ValorTodoConImpuestosKit;

                if ($Inpuesto == 0) {
                    return $ValorSinImpuestoKit;
                } else {
                    return $TotalValorConImpuesto;
                }
            }
        } catch (Exception $exc) {
            echo '0';
            echo $exc->getMessage();
        }
    }

    public function envioCorreoPedidoClienteNuevo($idPedido, $codagencia, $nombreAgencia) {
        $infoPedidoClienteNuevo = Consultas::Model()->getClienteNuevoPedido($idPedido);
        $volorPedidoMaximoResul = Consultas::Model()->getValorPedidoMaximo();
        $correosClienteNuevo = Consultas::Model()->getCorreosPedidoClienteNuevo($codagencia);

        $ValorPedidoMinimo = $volorPedidoMaximoResul['Valor'];
        $valorPedidoClientenuevo = $infoPedidoClienteNuevo['ValorPedido'];
        $cuentaCliente = $infoPedidoClienteNuevo['CuentaCliente'];
        $zonaventas = $infoPedidoClienteNuevo['CodZonaVentas'];
        $nombreZonaVentas = $infoPedidoClienteNuevo['NombreEmpleado'];

        if ($valorPedidoClientenuevo >= $ValorPedidoMinimo) {

            foreach ($correosClienteNuevo as $itemCorreoClienteNuevo) {

                $id = $itemCorreoClienteNuevo['Id'];
                $nombres = $itemCorreoClienteNuevo['Nombre'];
                $apellidos = $itemCorreoClienteNuevo['Apellidos'];
                $email = $itemCorreoClienteNuevo['CorreoElectronico'];

                if (!empty($email)) {
                    $body = '<div align="center">
                        <div>
                                <div>
                                    <h3 style="alignment-adjust: central"><b> PEDIDO MINIMO CLIENTE NUEVO </b></h4>
                                </div>
                        </div>
                        <div>
                            <div>
                                <h3><i>Actividad correo pedido minimo cliente nuevo</i></h4>
                            </div>
                            <div>
                                <div >
                                    <div >
                                        <div >  
                                            <h4><i>Sr(a) ' . $nombres . '   ' . $apellidos . '  se registro un pedido para cliente nuevo mayor a ' . $ValorPedidoMinimo . ' de la agencia ' . $nombreAgencia . ', cuenta de ' . $cuentaCliente . ' valor total pedido de venta ' . $valorPedidoClientenuevo . ' zona venta ' . $zonaventas . ' - ' . $nombreZonaVentas . '.</i></h4>   
                                        </div>              
                                    </div>
                                    <br>
                                    <div >
                                        <div >
                                            <h5><i>Este correo electr&oacute;nico y cualquier anexo o respuesta relacionada puede contener datos e informaci&oacute;n confidenciales y estar legalmente protegido. En caso de que lo haya recibido por error, por favor hacer caso omiso a este e-mail. No lo lea, copie, imprima o reenv&iacute;e este mensaje o cualquier anexo, o divulgue su(s) contenido(s) a terceros, y b&oacute;rrelo inmediatamente de su sistema. Los mensajes electr&oacute;nicos no son seguros y, por lo tanto, no nos responsabilizaremos por cualquier consecuencia relacionada al uso de este mensaje (inclusive da&ntilde;os causados por cualquier virus). Gracias.</i></h5>
                                        </div>
                                    </div>
                            </div>
                        </div>

                        </div>
                        </div>';

                    $this->enviarCorreo($email, $body);
                }
            }
        }
    }

}
