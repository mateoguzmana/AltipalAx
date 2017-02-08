<?php

class AutoventaController extends Controller {

    public $txtError;
    public $txtMensaje;
    private $dataReader;
    private $cargarPortafolio;
    private $portafolio;
    private $cargarAcuerdoComercialPrecio;
    private $acuerdoComercialPrecio;
    private $cargarCodigoGrupoPrecio;
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
    private $asesor;
    private $cargarVariantesInactivas;
    private $variantesInactivas;

    public function filters() {
        return array(
            'accessControl',
        );
    }

    public function accessRules() {
        //validamos el logueo;
        if (!Yii::app()->getUser()->hasState('_cedula')) {
            $this->redirect('index.php');
        }
        //
        //perfil
        $cedula = Yii::app()->user->_cedula;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "Cedula = $cedula";
        $idPerfil = Yii::app()->user->_idPerfil;
        //Nombre del controlador
        $controlador = Yii::app()->controller->getId();
        //configuracion del perfil
        $PerfilAcciones = Consultas::model()->getPerfilAcciones($idPerfil, $controlador);
        //importamos la extension 
        Yii::import('application.extensions.function.Action');
        $estedAction = new Action();
        try {
            //obetener los metodos ajax
            $actionAjax = $estedAction->getActions(ucfirst($controlador) . 'Controller', '');
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        //acciones por usuario
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
        if ($_POST) {
            $session = new CHttpSession;
            $session->open();
            $datos = $session['datosCompletarForm'];
            $datosForm = $session['pedidoForm'];
            if ($session['componenteKitDinamico']) {
                $datosKit = $session['componenteKitDinamico'];
            } else {
                $datosKit = array();
            }
            $CodAsesor = $datos['codigoAsesor'];
            $CodZonaVentas = $_POST['zonaVentas'];
            $CuentaCliente = $_POST['cuentaCliente'];
            $codigoGrupodeImpuestos = $_POST['codigoGrupodeImpuestos'];
            $codigoZonaLogistica = $_POST['codigoZonaLogistica'];
            $consulta = Consultas::model()->getGrupoPrecio($CodZonaVentas, $CuentaCliente);
            $consultaGrupoVentas = Consultas::model()->getGrupoVentas($CodAsesor);
            $CodGrupoVenta = "";
            $resolcuion = "";
            $cedula = Yii::app()->user->_cedula;
            $consultaAsesorExistente = Consultas::model()->getAsesorExistente($cedula);
            $codagencia = Yii::app()->user->_Agencia;
            if ($consultaAsesorExistente['asesorexiste'] > 0) {
                $resolcuion = '310000078637';
                $CodGrupoVenta = $consultaGrupoVentas['CodigoGrupoVentas'];
                $Conjunto = '002';
            } else {
                $asesor = Consultas::model()->getAsesorZona($CodZonaVentas, $codagencia);
                $consultaGrupoVentas = Consultas::model()->getGrupoVentas($asesor['CodAsesor']);
                $CodGrupoVenta = $consultaGrupoVentas['CodigoGrupoVentas'];
                $CodAsesor = $asesor['CodAsesor'];
                $resolcuion = $_POST['resolucion'];
                $Conjunto = '005';
            }
            $CodGrupoPrecios = $consulta['CodigoGrupoPrecio'];
            $Ruta = trim($datos['diaRuta']);
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
            $NroFactura = $_POST['factura'];
            $logitud = $_POST['longitud'];
            $latitud = $_POST['latitud'];
            $saldoCupo = $_POST['saldoCupo'];
            if ($Plazo == "") {
                $Plazo = "022";
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
            $FormaPago = $FormaPago == 'contado' ? $FormaPago = 'Contado' : $FormaPago = 'Credito';
            if ($ActividadEspecial == 'si') {
                $ActividadEspecial = '1';
            } else if ($ActividadEspecial == 'no') {
                $ActividadEspecial = '0';
            }
            $arrayEncabezado = array(
                'Conjunto' => $Conjunto,
                'CodAsesor' => $CodAsesor,
                'CodZonaVentas' => $CodZonaVentas,
                'CuentaCliente' => $CuentaCliente,
                'CodGrupoVenta' => $CodGrupoVenta,
                'CodGrupoPrecios' => $CodGrupoPrecios,
                'Ruta' => trim($Ruta),
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
                'CodigoGrupodeImpuestos' => $codigoGrupodeImpuestos,
                'CodigoZonaLogistica' => $codigoZonaLogistica,
                'Resolucion' => $resolcuion,
                'Prefijo' => '',
                'CedulaUsuario' => $cedula
            );
            /* echo  '<pre>';
              echo 'Encabezado';
              print_r($arrayEncabezado);
              exit(); */
            $model = new Pedidos;
            $model->attributes = $arrayEncabezado;
            if ($model->validate()) {
                $model->save();
                foreach ($datosForm as $itemDatos) {
                    if (empty($itemDatos['txtIdAcuerdoLinea'])) {
                        $itemDatos['txtIdAcuerdoLinea'] = "0";
                    }
                    if (empty($itemDatos['txtIdAcuerdoMultilinea'])) {
                        $itemDatos['txtIdAcuerdoMultilinea'] = "0";
                    }
                    $IdPedido = $model->IdPedido;
                    $CodVariante = $itemDatos['variante'];
                    $CodigoArticulo = $itemDatos['articulo'];
                    $NombreArticulo = $itemDatos['nombreProducto'];
                    $CodigoTipo = trim($itemDatos['codigoTipo']);
                    $Cantidad = $itemDatos['cantidad'];
                    $ValorUnitario = $itemDatos['valorUnitario'];
                    $Iva = $itemDatos['iva'];
                    $Impoconsumo = $itemDatos['impoconsumo'];
                    $CodigoUnidadMedida = $itemDatos['codigoUnidadMedida'];
                    $Saldo = $itemDatos['saldo'];
                    $CuentaProveedor = $itemDatos['cuentaProveedor'];
                    $CodLote = $itemDatos['txtlote'];
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
                    $idSaldoAutoeventa = $itemDatos['IdSaldoAutoventa'];
                    $idSaldoInventario = $itemDatos['idSaldoInventario'];
                    $codigoUnidadSaldoInventario = $itemDatos['codigoUnidadSaldoInventario'];
                    $codigoUnidadSaldo = $itemDatos['codigoUnidadMedida'];
                    ////FUNCION DODNE SE RESTAN LAS SLADOS DE AUTOVENTA
                    /* if ($TipoVenta == 'Autoventa') {
                      if ($codigoUnidadMedida != $codigoUnidadSaldo) {
                      $cantidadRestar = $this->buscaUnidadesConversion($CodigoArticulo, $codigoUnidadSaldoInventario, $codigoUnidadMedida, $Cantidad);
                      Consultas::model()->actualizarSaldoInventarioAutoventa($idSaldoAutoeventa, $cantidadRestar);
                      } else {
                      Consultas::model()->actualizarSaldoInventarioAutoventa($idSaldoAutoeventa, $Cantidad);
                      }
                      } else {
                      if ($codigoUnidadMedida != $codigoUnidadSaldoInventario) {
                      $cantidadRestar = $this->buscaUnidadesConversion($CodigoArticulo, $codigoUnidadSaldoInventario, $codigoUnidadMedida, $Cantidad);
                      Consultas::model()->actualizarSaldoInventarioPreventa($idSaldoAutoeventa, $cantidadRestar);
                      } else {
                      Consultas::model()->actualizarSaldoInventarioPreventa($idSaldoAutoeventa, $Cantidad);
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
                      } */
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
                        'Saldo' => $Saldo,
                        'CuentaProveedor' => $CuentaProveedor,
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
                        'PedidoMaquina' => $PedidoMaquina,
                        'IdentificadorEnvio' => $IdentificadorEnvio,
                        'EstadoTerminacion' => $EstadoTerminacion,
                        'CodLote' => $CodLote,
                        'IdAcuerdoPrecioVenta' => $idAcuerdo,
                        'IdAcuerdoLinea' => $txtIdAcuerdoLinea,
                        'IdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea
                    );
                    $modelDetalle = new Descripcionpedido;
                    $modelDetalle->attributes = $datosDetalle;
                    if (!$modelDetalle->validate()) {
                        print_r($modelDetalle->getErrors());
                        exit();
                    } else {
                        $modelDetalle->save();
                        foreach ($datosKit as $itemKit) {
                            if ($CodigoArticulo == $itemKit['txtCodigoArticuloKit']) {
                                if ($itemKit['txtCantidadItemFijo'] != "" || $itemKit['txtCantidadItemOpcional'] != "") {
                                    $arrayDatosKit = array(
                                        'IdDescripcionPedido' => $modelDetalle->Id,
                                        'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                        'CodigoArticuloComponente' => $itemKit['txtCodigoVarianteComponente'],
                                        'Nombre' => $itemKit['txtNombreKit'],
                                        'CodigoUnidadMedida' => $itemKit['txtUnidadKit'],
                                        'CodigoTipo' => $itemKit['txtTipo'],
                                        'Fijo' => $itemKit['txtCantidadItemFijo'],
                                        'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                        'Cantidad' => $itemKit['txtKitCantidad'],
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
                                    //$pieces = explode("-", $itemKit['txtCodigoArticulo']);
                                    $arrayDatosKit = array(
                                        'IdDescripcionPedido' => $modelDetalle->Id,
                                        'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                        'CodigoArticuloComponente' => $itemKit['txtCodigoVarianteComponente'],
                                        'Nombre' => $itemKit['txtNombreKit'],
                                        'CodigoUnidadMedida' => $itemKit['txtUnidadKit'],
                                        'CodigoTipo' => $itemKit['txtTipo'],
                                        'Fijo' => $itemKit['txtCantidadItemFijo'],
                                        'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                        'Cantidad' => $itemKit['txtKitCantidad'],
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
                $codtipodoc = '2';
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
            $globalsaldo = 0;
            if ($FormaPago == 'Credito') {
                $nuevoValor = $saldoCupo - $ValorPedido;
                Consultas::model()->actualizarSaldoCupo($CuentaCliente, $CodZonaVentas, $nuevoValor);
                $globalsaldo = $nuevoValor;
            }
            if (isset($session['EncabezadoPedidoAlamcenadoAutoventa'])) {
                $pedidoAlmacenado = $session['EncabezadoPedidoAlamcenadoAutoventa'];
                $totalesAlamcenados = $session['TotalesAlmacenadosAutoventa'];
                $datosAlmacenados = $session['pedidoFromAlmacenadoAutoventa'];
                $datosKitAlmacenados = $session['componenteKitDinamicoAlmacenadoAutoventa'];
                $TipoVenta = $pedidoAlmacenado['TipoVenta'];
                $FormaPago = $pedidoAlmacenado['FormaPago'];
                $ActividadEspecial = $pedidoAlmacenado['ActividadEspecial'];
                $saldoCupoPedidoAlamcenado = $pedidoAlmacenado['SaldoCupo'];
                $CuentaCliente = $pedidoAlmacenado['CuentaCliente'];
                $NroFactura = $pedidoAlmacenado['factura'];
                // conjunto
                if ($TipoVenta == 'Autoventa') {
                    $Conjunto = '002';
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
                $FormaPago = $FormaPago == 'contado' ? 'Contado' : 'Credito';
                if ($ActividadEspecial == 'si') {
                    $ActividadEspecial = '1';
                    $Estado = '2';
                } elseif ($ActividadEspecial == 'no') {
                    $ActividadEspecial = '0';
                    $Estado = '0';
                }
                if ($FormaPago == 'Credito') {
                    $SaldoActualPedidoAlacenado = $globalsaldo - $ValorPedido;
                    Consultas::model()->getActualizarsaldocupocliente($SaldoActualPedidoAlacenado, $CuentaCliente, $CodZonaVentas);
                }
                $arrayEncabezado = array(
                    'Conjunto' => $Conjunto,
                    'CodAsesor' => $pedidoAlmacenado['CodAsesor'],
                    'CodZonaVentas' => $pedidoAlmacenado['CodZonaVentas'],
                    'CuentaCliente' => $pedidoAlmacenado['CuentaCliente'],
                    'CodGrupoVenta' => $pedidoAlmacenado['CodGrupoVenta'],
                    'CodGrupoPrecios' => $pedidoAlmacenado['CodGrupoPrecios'],
                    'Ruta' => $pedidoAlmacenado['Ruta'],
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
                    'CodigoZonaLogistica' => $pedidoAlmacenado['CodigoZonaLogistica']
                );
                $model = new Pedidos;
                $model->attributes = $arrayEncabezado;
                if ($model->validate()) {
                    $model->save();
                    foreach ($datosAlmacenados as $itemDatos) {
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
                        $CodLote = $itemDatos['txtlote'];
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
                            'CodLote' => $CodLote,
                            'IdAcuerdoPrecioVenta' => $idAcuerdo,
                            'IdAcuerdoLinea' => $txtIdAcuerdoLinea,
                            'IdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea
                        );
                        $modelDetalle = new Descripcionpedido;
                        $modelDetalle->attributes = $datosDetalle;
                        if (!$modelDetalle->validate()) {
                            print_r($modelDetalle->getErrors());
                        } else {
                            $modelDetalle->save();
                            foreach ($datosKitAlmacenados as $itemKit) {
                                if ($CodigoArticulo == $itemKit['txtCodigoArticuloKit']) {
                                    if ($itemKit['txtCantidadItemFijo'] != "" || $itemKit['txtCantidadItemOpcional'] != "") {
                                        $arrayDatosKit = array(
                                            'IdDescripcionPedido' => $modelDetalle->Id,
                                            'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                            'CodigoArticuloComponente' => $itemKit['txtCodigoVarianteComponente'],
                                            'Nombre' => $itemKit['txtNombreKit'],
                                            'CodigoUnidadMedida' => $itemKit['txtUnidadKit'],
                                            'CodigoTipo' => $itemKit['txtTipo'],
                                            'Fijo' => $itemKit['txtCantidadItemFijo'],
                                            'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                            'Cantidad' => $itemKit['txtKitCantidad'],
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
                                        //$pieces = explode("-", $itemKit['txtCodigoArticulo']);
                                        $arrayDatosKit = array(
                                            'IdDescripcionPedido' => $modelDetalle->Id,
                                            'CodigoListaMateriales' => $itemKit['txtCodigoLista'],
                                            'CodigoArticuloComponente' => $itemKit['txtCodigoVarianteComponente'],
                                            'Nombre' => $itemKit['txtNombreKit'],
                                            'CodigoUnidadMedida' => $itemKit['txtUnidadKit'],
                                            'CodigoTipo' => $itemKit['txtTipo'],
                                            'Fijo' => $itemKit['txtCantidadItemFijo'],
                                            'Opcional' => $itemKit['txtCantidadItemOpcional'],
                                            'Cantidad' => $itemKit['txtKitCantidad'],
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
                        'IdDocumento' => 'web',
                        'Origen' => '2',
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
                    $codtipodoc = '2';
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
                    if ($DsctoEspecial > 0) {
                        Consultas::model()->getUpdateEstadoDescuento($model->IdPedido);
                        $Agencia = Consultas::model()->getAgencia($codagencia);
                        $nombreAgencia = $Agencia['Nombre'];
                        //Altipal
                        $PedidoAltipal = Consultas::model()->getPedidoAltipal($model->IdPedido);
                        $codGrupoVentas = $PedidoAltipal[0]['CodGrupoVenta'];
                        $this->correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, '', $codagencia);
                        //Proveedor
                        $PedidoProveedor = Consultas::model()->getPedidoProveedor($model->IdPedido);
                        foreach ($PedidoProveedor as $itemproveedor) {
                            $proveedor = $itemproveedor['CuentaProveedor'];
                            $this->correoDescuentoEspecial($nombreAgencia, $codGrupoVentas, $proveedor, $codagencia);
                        }
                    }
                }
            }
            unset($session['EncabezadoPedidoAlamcenadoAutoventa']);
            unset($session['pedidoFromAlmacenadoAutoventa']);
            unset($session['TotalesAlmacenadosAutoventa']);
            Yii::app()->user->setFlash('success', "Factura Enviada Exitosamente!");
            //$this->redirect("index.php?r=Clientes/menuClientes&cliente=$CuentaCliente&zonaVentas=$CodZonaVentas");
            //$this->redirect("index.php?r=Autoventa/CrearPedido&cliente=$CuentaCliente&zonaVentas=$CodZonaVentas");
            //$this->render('index.php?r=Clientes/menuClientes', array('CuentaCliente' => $CuentaCliente,));
            //Restar el valor del pedido del saldo del cliente
        }
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/autoventa/crearPedidoAutoventa.js', CClientScript::POS_END
        );
        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];
        $datos = $session['datosCompletarForm'];
        $datos['codigositio'] = $codigoSitio;
        $datos['codigoAlmacen'] = $codigoAlmacen;
        $session['datosCompletarForm'] = $datos;
        $condicionPago = Consultas::model()->getCondicionPagoCliente($cliente, $zonaVentas);
        $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas, $codagencia);
        $ubicacion = Preventa::model()->cargarUbicacionZona($zonaVentas);
        //$session['Ubicacion'] = $ubicacion['CodigoUbicacion'];
        $formasPago = Preventa::model()->cargarFormasPago($condicionPago['Dias']);
        $sitios = count($sitiosVentas);
        $asesor = Consultas::model()->getAsesorZona($zonaVentas, $codagencia);
        $this->zonaVentas = $zonaVentas;
        $this->cuentaCliente = $cliente;
        $this->codigoSitio = $codigoSitio;
        $this->codigoAlmacen = $codigoAlmacen;
        $this->ubicacion = $ubicacion['CodigoUbicacion'];
        $this->asesor = $asesor['CodAsesor'];
        //CARGAR PORTAFOLIO 
        if (!$this->cargarPotafolio()) {
            echo $this->txtError;
        } else {
            if (!$this->cargarVariantesInactivas()) {
                echo $this->txtError;
            } else {
                if (!$this->validarPortafolioVariantesInactivas()) {
                    echo $this->txtError;
                } else {
                    if (!$this->cargarAcuerdoComercialPrecio()) {
                        echo $this->txtError;
                    } else {
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
                                if ($this->validarPortafolioSaldosAutoventa()) {
                                    $this->cargarUnidadesConversion = Preventa::model()->cargarUnidadesConversion();
                                    if (!$this->cargarUnidadesConversion) {
                                        $this->txtError = Preventa::model()->getTxtError;
                                    } else {
                                        $this->unidadesConversion = Preventa::model()->getDataReader();
                                        if (!$this->validarUnidadesPortafolioSaldoAutoventa()) {
                                            echo $this->txtError;
                                            exit();
                                        } else {
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
                }
            }
        }
        $portafolioAutoventa = $this->portafolio;
        /* echo '<pre>';
          print_r($portafolioAutoventa);
          exit(); */
        $saldoCupoCliente = Consultas::model()->getSaldoRecibosCupo($cliente, $zonaVentas);
        $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($zonaVentas);
        $valorMinimo = Consultas::model()->getValorMinimo($cliente);
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $PedidosEnvidosCurdate = Consultas::model()->getPedidoRelizadoActual($cliente);
        $this->render('crearPedido', array('datosCliente' => $datosCliente,
            'zonaVentas' => $zonaVentas,
            'condicionPago' => $condicionPago,
            'sitiosVentas' => $sitiosVentas,
            'portafolioAutoventa' => $portafolioAutoventa,
            'permisosDescuentoEspecial' => $permisosDescuentoEspecial,
            'valorMinimo' => $valorMinimo,
            'saldoCupoCliente' => $saldoCupoCliente,
            'NroFactura' => $NroFactura,
            'agencia' => $codagencia,
            'sitios' => $sitios,
            'PedidoEnviados' => $PedidosEnvidosCurdate,
            'formasPago' => $formasPago
        ));
    }

    /*
     * AQUI SE CARGA LOS ACUERDOS DE PRECIO VENTA
     * Si no retorna false
     * @param String $CodVariante Codigo de la Variante
     * @return Boolean true Se ejecuto exitosamente
     */

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

    ///SE VALIDAN LAS VARIANTES INACTIVAS DE AUTOVENTA/////
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
    }

    //AQUI ESTA LA FUNCION DONDE SE CARGA EL PORTAFOLIO AUTOVENTA
    private function cargarPotafolio() {
        try {
            $session = new CHttpSession;
            $session->open();
            $ubicacion = $session['Ubicacion'];
            Preventa::model()->setZonaVentas($this->zonaVentas);
            // $this->cargarPortafolio = Preventa::model()->cargarPortafolio();
            $this->cargarPortafolio = Preventa::model()->cargarPortafolioAutoventa($ubicacion);
            if (!$this->cargarPortafolio) {
                $this->txtError = "No se ha realizado la carga del portafolio";
                return false;
            } else {
                $this->portafolio = Preventa::model()->getDataReader();
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

    //AQUI SE VALIDA EL PORTFOLIO 
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

    //AQUI SE VALIDA EL ACUERDO DE PRECIO 
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
                foreach ($this->acuerdoComercialPrecio as $itemAcuerdo) {
                    /* echo '<pre>';
                      print_r($this->acuerdoComercialPrecio);
                      exit(); */
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
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen == 'EMPTY') {
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
                            } else {
                                if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen == 'EMPTY') {
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
                                }
                            }
                            ////FIN VALIDACION
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen != 'EMPTY') {
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
                            } else {
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
                            }
                        } else {
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen != 'EMPTY') {
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
                            } else {
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
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
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
                                    $ordenBusquda = 2;
                                }
                            }
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen == 'EMPTY') {
                                if ($txtAcTipoCuentaCliente == 1 &&
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
                            } else {
                                if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen == 'EMPTY') {
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
                                }
                            }
                            ////FIN VALIDACION
                        }
                    } else {
                        if ($txtAcFechaTermina == '0000-00-00') {
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen == 'EMPTY') {
                                if ($txtAcTipoCuentaCliente == "1" &&
                                        $txtAcCuentaCliente == $this->cuentaCliente &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda &&
                                        $ordenBusquda == 2
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                            } else {
                                if ($txtAcTipoCuentaCliente == "1" &&
                                        $txtAcCuentaCliente == $this->cuentaCliente &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda &&
                                        $ordenBusquda == 2
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                            }
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen != 'EMPTY') {
                                if ($txtAcTipoCuentaCliente == "1" &&
                                        $txtAcCuentaCliente == $this->cuentaCliente &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda &&
                                        $ordenBusquda == 2
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                            } else {
                                if ($txtAcTipoCuentaCliente == "1" &&
                                        $txtAcCuentaCliente == $this->cuentaCliente &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcFechaInicio >= $fechaBusqueda
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $txtAcFechaInicio > $fechaBusqueda &&
                                        $ordenBusquda == 2
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                            }
                        } else {
                            if ($txtAcCodigoSitio != 'EMPTY' && $txtAcCodigoAlmacen != 'EMPTY') {
                                if ($txtAcTipoCuentaCliente == "1" &&
                                        $txtAcCuentaCliente == $this->cuentaCliente &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $fechaActual <= $txtAcFechaTermina &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio >= $fechaBusqueda
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $fechaActual <= $txtAcFechaTermina &&
                                        $txtAcCodigoSitio == $this->codigoSitio &&
                                        $txtAcCodigoAlmacen == $this->codigoAlmacen &&
                                        $txtAcFechaInicio > $fechaBusqueda &&
                                        $ordenBusquda == 2
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                            } else {
                                if ($txtAcTipoCuentaCliente == "1" &&
                                        $txtAcCuentaCliente == $this->cuentaCliente &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $fechaActual <= $txtAcFechaTermina &&
                                        $txtAcFechaInicio >= $fechaBusqueda
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
                                if ($txtAcTipoCuentaCliente === "2" &&
                                        $txtAcCodigoGrupoPrecio == $this->codigoGrupoPrecio['CodigoGrupoPrecio'] &&
                                        $txtAcCodigoVariante == $txtPorCodigoVariante &&
                                        $fechaActual >= $txtAcFechaInicio &&
                                        $fechaActual <= $txtAcFechaTermina &&
                                        $txtAcFechaInicio > $fechaBusqueda &&
                                        $ordenBusquda == 2
                                ) {
                                    $txtPorPrecioVariante = $txtAcPrecioVenta;
                                    $txtPorIdAcuerdoComercial = $txtAcIdAcuerdoComercial;
                                    $txtPorCodigoUnidadMedida = $txtAcCodigoUnidadMedida;
                                    $txtPorNombreUnidadMedida = $txtAcNombreUnidadMedida;
                                    $busqueda = true;
                                    $fechaBusqueda = $txtAcFechaInicio;
                                }
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
            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    //AQUI SE VALIDA EL IPOCONSUMO DEL PORTAFOLIO
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

    //AQUI SE CARGAN LOS SALDOS DE AUTOVENTA PARA EL PORTAFOLIO
    private function cargarSaldosPortafolio() {
        try {
            Preventa::model()->setCodigoSitio($this->codigoSitio);
            Preventa::model()->setCodigoAlmacen($this->codigoAlmacen);
            // Se comenta pero no se sabe para que se hacia
           // $this->ubicacion = $this->asesor;
            Preventa::model()->setUbicacion($this->ubicacion);
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

    //AQUI SE VALIDAN LOS SALDOS DE AUTOVENTA PARA EL PORTAFOLIO
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
                $this->cargarListaMateriales($codigoArticulo);
                if ($codigoTipo != "KV" && $codigoTipo != "KD") {
                     /*echo '<pre>';
                      print_r($this->saldoAutoventa);*/ 
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
                        $codigoArticuloComponente = $itemLista['LMDCodigoArticuloComponente'];
                        $lMCodigoArticuloKit = $itemLista['LMCodigoArticuloKit'];
                        if ($codigoArticulo == $lMCodigoArticuloKit) {
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
                                if ($codigoArticuloComponente == $saldoAutCodigoVariante) {
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

    /////AQUI SE CARGAN LA LISTA DE MATERIALES 
    private function cargarListaMateriales($codigoArticulo) {
        try {
            $this->cargarKitPortafolio = Preventa::model()->cargarListaMateriales($codigoArticulo);
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

    ///AQUI VALIDACION UNIDADES DE CONVERSION DE PORTAFOLIO SALDO AUTOVENTA
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

    ///AQUI SE VALIDA LA LISTA DE MATERIALES 
    private function validarPortafolioListaMateriales() {
        /* echo '<entre>';
          echo '<pre>';
          print_r($this->portafolio);
          exit(); */
        try {
            $contLista = 0;
            foreach ($this->listaMateriales as $itemListaMateriales) {
                $this->listaMateriales[$contLista]['SAId'] = "";
                $this->listaMateriales[$contLista]['SADisponible'] = "";
                $this->listaMateriales[$contLista]['SANombreUnidadMedida'] = "";
                $this->listaMateriales[$contLista]['SACodigoUnidadMedida'] = "";
                $contLista++;
            }
            /* echo '<pre>';
              print_r($this->portafolio);
              exit(); */
            foreach ($this->portafolio as $itemPortafolio) {
                /* echo  '<pre>';
                  echo 'portafolio';
                  print_r($this->portafolio);
                  exit(); */
                $porCodigoArticulo = $itemPortafolio['CodigoArticulo'];
                $porCodigoVariante = $itemPortafolio['CodigoVariante'];
                $porCodigoTipo = $itemPortafolio['CodigoTipo'];
                $porACPrecioVenta = $itemPortafolio['ACPrecioVenta'];
                if ($porCodigoTipo == "KV" || $porCodigoTipo == "KD") {
                    $contLista = 0;
                    $contListaAuto = 0;
                    foreach ($this->listaMateriales as $itemListaMateriales) {
                        /* echo '<pre>';
                          print_r($itemListaMateriales); */
                        $LMCodigoArticuloKit = $itemListaMateriales['LMCodigoArticuloKit'];
                        $LMDCodigoArticuloComponente = $itemListaMateriales['LMDCodigoArticuloComponente'];
                        if ($LMCodigoArticuloKit == $porCodigoArticulo) {
                            $saldoAuId = '';
                            $saldoAuItemLista = '';
                            $saldoAuNombreUnidadMedida = '';
                            $saldoAuCodigoUnidadMedida = '';
                            if ($porACPrecioVenta != "") {
                                $busquedaAuto = false;
                                foreach ($this->saldoAutoventa as $itemSaldosAuto) {
                                    /* echo '<pre>';
                                      print_r($itemSaldosAuto); */
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
                                    if ($saldoAutoCodigoVariante == $LMDCodigoArticuloComponente) {
                                        /* echo 'id '.$saldoAuId = $saldoAutoId. '<br/>';
                                          echo 'saldo  '.$saldoAuItemLista = $saldoAutoDisponible.'<br/>';
                                          echo 'nombre unidad  '.$saldoAuNombreUnidadMedida = $saldoAutoNombreUnidadMedida.'<br/>';
                                          echo 'codigo unidad  '.$saldoAuCodigoUnidadMedida = $saldoAutoCodigoUnidadMedida.'<br/>';
                                          echo '----------------------------------------------------------------------------------'.'<br/>'; */
                                        $saldoAuId = $saldoAutoId;
                                        $saldoAuItemLista = $saldoAutoDisponible;
                                        $saldoAuNombreUnidadMedida = $saldoAutoNombreUnidadMedida;
                                        $saldoAuCodigoUnidadMedida = $saldoAutoCodigoUnidadMedida;
                                        $busquedaAuto = true;
                                    }
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
                                $this->listaMateriales[$contLista]['SAId'] = "";
                                $this->listaMateriales[$contLista]['SADisponible'] = "";
                                $this->listaMateriales[$contLista]['SANombreUnidadMedida'] = "";
                                $this->listaMateriales[$contLista]['SACodigoUnidadMedida'] = "";
                            }
                        }
                        $contLista++;
                        //$contListaAuto++;
                    }
                }
            }
            $session = new CHttpSession;
            $session->open();
            $session['listaMateriales'] = $this->listaMateriales;
            $this->validarListaMateriales();
            return true;
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
            return false;
        }
    }

    ////AQUI SE VALIDA LA LISTA MATERIALES 
    private function validarListaMateriales() {
        /* echo '<pre>';
          print_r($this->portafolio);
          exit(); */
        foreach ($this->portafolio as $itemPortafolio) {
            $porCodigoArticulo = $itemPortafolio['CodigoArticulo'];
            $porCodigoVariante = $itemPortafolio['CodigoVariante'];
            $porCodigoTipo = $itemPortafolio['CodigoTipo'];
            $porACPrecioVenta = $itemPortafolio['ACPrecioVenta'];
            if ($porCodigoTipo == "KD" || $porCodigoTipo == "KV") {
                $contdisponible = 0;
                foreach ($this->listaMateriales as $itemListaMateriales) {
                    $LMCodigoArticuloKit = $itemListaMateriales['LMCodigoArticuloKit'];
                    $LMDCodigoArticuloComponente = $itemListaMateriales['LMDCodigoArticuloComponente'];
                    $LMTotalPrecioVentaListaMateriales = $itemListaMateriales['LMTotalPrecioVentaListaMateriales'];
                    $LMSAuDisponible = $itemListaMateriales['SADisponible'];
                    if ($LMCodigoArticuloKit == $porCodigoArticulo) {
                        $busqueda = true;
                        foreach ($this->listaMateriales as $itemListaMaterialesI) {
                            $LMCodigoArticuloKitI = $itemListaMaterialesI['LMCodigoArticuloKit'];
                            $LMSAuDisponible = $itemListaMaterialesI['SADisponible'];
                            /* echo '<pre>';
                              print_r($itemListaMaterialesI); */
                            // echo $LMCodigoArticuloKit .'=='. $LMCodigoArticuloKitI.'<br/>';
                            if ($LMCodigoArticuloKit == $LMCodigoArticuloKitI) {
                                if ($busqueda) {
                                    if ($LMSAuDisponible > 0) {
                                        $busqueda = true;
                                    } else {
                                        $busqueda = false;
                                    }
                                }
                            }
                        }
                        if ($busqueda) {
                            $this->portafolio[$cont]['kitActivo'] = '1';
                            $this->portafolio[$cont]['ACPrecioVenta'] = $LMTotalPrecioVentaListaMateriales;
                        } else {
                            $this->portafolio[$cont]['SADisponible'] = "";
                        }
                    }
                }
            }
            $cont++;
        }
        $session = new CHttpSession;
        $session->open();
        $session['portafolio'] = $this->portafolio;
    }

    ///////AQUI EMPIESA EL CODIGO AJAX DEL PEDIDO DE AUTOVENTA
    public function actionAjaxGetDetalleArticulo() {
        try {
            /* print_r($this->portafolio);
              exit(); */
            $session = new CHttpSession;
            $session->open();
            $txtCodigoVariante = $_POST['txtCodigoVariante'];
            $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
            $txtCliente = $_POST['txtCliente'];
            $txtCodigoAcuerdoPrecioVenta = $_POST['txtCodigoAcuerdoPrecioVenta'];
            $txtNombreUnidadMedidaPrecioVenta = $_POST['txtNombreUnidadMedidaPrecioVenta'];
            $txtTipoVenta = $_POST['tipoVenta'];
            $txtLote = $_POST['txtLote'];
            $txtSaldo = $_POST['txtSaldo'];
            $kit = $_POST['kd'];
            $ubicacion = $session['Ubicacion'];
            $this->acuerdoComercialPrecio = $txtCodigoAcuerdoPrecioVenta;
            $this->codigoArticulo = $txtCodigoArticulo;
            $this->nombreCodigoGrupoPrecio = $txtNombreUnidadMedidaPrecioVenta;
            if ($this->cargarSaldoLimite()) {
                if ($_POST['txtZonaVentas']) {
                    $txtZonaVentas = $_POST['txtZonaVentas'];
                    $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($txtZonaVentas);
                }
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
                    'kit' => $kit,
                    'ubicacion' => $ubicacion
                        ), true);
            } else {
                $this->txtError = "No se ha podido calcular el saldo limite";
                return false;
            }
        } catch (Exception $exc) {
            $this->txtError = $exc->getTraceAsString();
        }
    }

    //////AQUI SE CARGAN LOS SALDOS LIMITES
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
            /* echo '<pre>';
              print_r($descuentoLineaConsulta); */
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

    ////////AQUI SE CARGAN LOS DESCUENTO LIENA
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

    //////AQUI SE CARGAN LOS DESCUENTOS MULTILINEA
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

    //////AQUI SE VALIDAN LOS ACUERDOS DE LINEA
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
        $descuentoLineaConsulta = array();
        $descuentoLineaConsultaCantiadades = array();
        $busqueda = false;
        /* echo '<pre>';
          print_r($descuentoLinea); */
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
                    if ($txtCodigoAcuerdoPrecioVenta != $itemDLCodigoUnidadMedida) {
                        $this->codigoArticulo = $txtCodigoArticulo;
                        $this->validateAcuerdo($itemDLCodigoUnidadMedida, $txtCodigoAcuerdoPrecioVenta, $txtCantidad);
                        if ($txtCantidad >= $itemDLCantidadDesde && $itemDLCantidadHasta <= $txtCantidad) {
                            //  echo $this->cantidadConvertida . '>=' .$itemDLCantidadDesde .'&&'. $itemDLCantidadHasta .'<='. $this->cantidadConvertida;
                            //if ($this->cantidadConvertida >= $itemDLCantidadDesde  && $itemDLCantidadHasta <= $this->cantidadConvertida){
                            if ($this->cantidadConvertida != "") {
                                if ($this->cantidadConvertida >= $itemDLCantidadDesde && $itemDLCantidadHasta <= $this->cantidadConvertida) {
                                    $CantidadConvertida = $this->cantidadConvertida;
                                }
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
                    }
                }
            } else {
                if ($itemDLCantidadDesde == '0' && $itemDLCantidadHasta == '0') {
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
                            /* echo $itemDLTipoCuentaArticulos .'=='.'1'.'<br/>';
                              echo $itemDLCodigoClienteGrupoDescuentoLinea.'=='.$txtCodigoGrupoClienteDescuentoLinea.'<br/>';
                              echo $itemDLCodigoVariante.'=='.$txtCodigoVariante.'<br/>';
                              echo $itemDLSitio.'=='.$codigoSitio.'<br/>';
                              echo $itemDLCodigoAlmacen.'=='.$codigoAlmacen.'<br/>';
                              $cont++;
                              echo $cont; */
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
        echo json_encode($arrayRespuesta);
    }

    ////AQUI SE VALIDAN LOS ACUERDOS DE MULTILINEA
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
                        if ($txtCantidad >= $itemDMLCantidadDesde && $itemDMLCantidadHasta <= $txtCantidad) {
                            echo $this->cantidadConvertida . '>=' . $itemDMLCantidadDesde . '&&' . $itemDMLCantidadHasta . '<=' . $this->cantidadConvertida;
                            //if ($this->cantidadConvertida >= $itemDLCantidadDesde  && $itemDLCantidadHasta <= $this->cantidadConvertida){
                            if ($this->cantidadConvertida != "") {
                                if ($this->cantidadConvertida >= $itemDMLCantidadDesde && $itemDMLCantidadHasta <= $this->cantidadConvertida) {
                                    $CantidadConvertida = $this->cantidadConvertida;
                                }
                            }
                        }
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
                /* $itemDMLCantidadDesde = $itmMDLCanti['CantidadDesde'];
                  $itemDMLCantidadHasta = $itmMDLCanti['CantidadHasta']; */
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
                            if ($itemDMLCodigoGrupoClienteDescuentoMultilinea == $txtCodigoGrupoClienteDescuentoMultilinea && $itemDMLCodigoGrupoArticulosDescuentoMultilinea == "EMPTY" && $itemMDLSitio == "EMPTY" && $itemDMLCodigoAlmacen == "EMPTY") {
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
        /* echo '<pre>';
          print_r($arrayRespuesta);
          exit(); */
        $arrayRespuesta = array(
            'descuentoMultiLinea' => $totalDescuento,
            'acuerdoComercialMulti' => $IdAcuerdoComercial,
            'nidadMedidaAcuerdoMulti' => $CodigoUnidadMedida,
            'CodigoGrupoArticulosDescuentoMultilinea' => $CodigoGrupoArticulosDescuentoMultilinea
        );
        echo json_encode($arrayRespuesta);
    }

    ////AQUI SE CARGAN LOS LOTES /////
    public function actionAjaxCargarSaldoLote() {
        if ($_POST) {
            $lote = $_POST['lote'];
            $ubicacion = $_POST['ubicacion'];
            $variante = $_POST['variante'];
            $LoteDisponible = Consultas::model()->getSaltoLote($lote, $ubicacion, $variante);
            echo $LoteDisponible[0]['Disponible'];
        }
    }

    ///AQUI SE REALIZA LA FUNCION AJAX DE AGREGAR EL PEDIDO
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
        $IdSaldoAutoventa = $_POST['IdSaldoAutoventa'];
        $descuentoEspecialProveedor = $descuentoEspecialSelect == 'Proveedor' ? $descuentoEspecial : $_POST['descuentoEspecialProveedor'];
        $descuentoEspecialAltipal = $descuentoEspecialSelect == 'Altipal' ? $descuentoEspecial : $_POST['descuentoEspecialAltipal'];
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
                'IdSaldoAutoventa' => $IdSaldoAutoventa
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
                'nombreUnidadMedida' => $nombreUnidadMedida,
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
                'aplicaImpoconsumo' => $aplicaImpoconsumo,
                'txtCodigoGrupoArticulosDescuentoMultilinea' => $txtCodigoGrupoArticulosDescuentoMultilinea,
                'txtIdAcuerdoLinea' => $txtIdAcuerdoLinea,
                'txtIdAcuerdoMultilinea' => $txtIdAcuerdoMultilinea,
                'txtlote' => $txtlote,
                'IdSaldoAutoventa' => $IdSaldoAutoventa
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
                'IdSaldoAutoventa' => $IdSaldoAutoventa
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
                    $cantidad = $itemDatos['cantidad'];
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
                    $datosBusquedaArray = $this->validarAcuerdoMultiLinea($itemTxtCodigoVariante, $itemTxtCodigoGrupoDescuentoMultiLinea, $itemTxtCantidad, $itemTxtUnidadMedida, $itemTxtCodigoArticulo);
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
            echo $this->renderPartial('_tablaDetalle', true);
        }
    }

    ///AQUI SE REALIZA LA FUNCION AJAX DE ELIMINAR EL PEDIDO
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

    ////AQUI SE RELIZA AL FUNCON DE AJAX KIT COMPONENTE
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

    ////AQUI SE RELAIZA LA FUNCION  DE AJAX KIT  VIRTUAL
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
                'txtCliente' => $txtCliente
                    ), true);
        } catch (Exception $exc) {
            echo '0';
            echo $exc->getMessage();
        }
    }

    ////AQUI SE REALIZA LA FUNCION DE TOTALES
    public function actionAjaxTotalesPedido() {
        Yii::import('application.extensions.pedido.Pedido');
        $pedido = new Pedido();
        $pedido->getCalcularTotales();
        $saldoCupo = $_POST['saldoCupo'];
        echo $this->renderPartial('_tablaTotales', array('saldoCupo' => $saldoCupo), true);
    }

    ////AQUI SE LLAMA LA FUNCION DE ACTUALIZAR AGREGAR
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

    /////AQUI SE LLAMA LA FUNCION DE AJAX ACUERDO PRECIO VENTA 
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
            echo '<pre>';
            print_r($productoAcuerdoComercialProducto);
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

    ///AQUI SE LLAMA LA FUNCON AJAX ACDL
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
            echo $$CodigoUnidadMedida . '</br>';
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

    ///AQUI SE LLAMA LA FUNCION  AJAX DETALLE ARTICULO 
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

    ///AQUI SE VALIDA EL NUMERO DE LA FACTURA
    public function actionAjaxValidarFactura() {
        $factura = $_POST['factura'];
        $busquedaFactura = Consultas::model()->getValidarFactura($factura);
        $validarRango = Consultas:: model()->getValidarRangoFactura();
        if ($busquedaFactura['Total'] == 0 && $factura >= $validarRango['RangoDesde'] && $factura <= $validarRango['RangoHasta']) {
            echo '0';
        } else {
            echo '1';
        }
    }

    ////AQUI SE LLAMA LA FUNCION DE VALIDACION DEL ITEM DE PEDIDO
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

    ////AQUI SE LLAMA LA FUNCION AJAX DE CALCULAR  SALDO  KIT VIRTUAL 
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

    ///AQUI SE LLAMA LA FUNCION DE CALCULAR SALDO KIT DINAMICO 
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

    ///AQUI SE LLAMA LA FUNCION VALIDA ACUERDO MULTILINEA EN EL AGREGADO ITEM PEDIDO
    private function validarAcuerdoMultiLinea($txtCodigoVariante, $txtCodigoGrupoDescuentoMultiLinea, $txtCantidad, $txtUnidadMedida, $txtCodigoArticulo) {
        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];
        if ($session['acuerdoMultiLinea']) {
            $descuentoMultiLinea = $session['acuerdoMultiLinea'];
        } else {
            $descuentoMultiLinea = array();
        }
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
                        echo 'entre a validar cantidades';
                        $this->codigoArticulo = $txtCodigoArticulo;
                        $this->validateAcuerdo($itemDMLCodigoUnidadMedida, $txtUnidadMedida, $txtCantidad);
                        if ($txtCantidad >= $itemDMLCantidadDesde && $itemDMLCantidadHasta <= $txtCantidad) {
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
        foreach ($descuentosMultiLineaConsultaCantidad as $itemConsulta) {
            $fechaInicio = $itemConsulta['FechaInicio'];
            if ($fechaInicio >= $fechaMayor) {
                $descuento1 = $itemConsulta['PorcentajeDescuentoMultilinea1'];
                $descuento2 = $itemConsulta['PorcentajeDescuentoMultilinea2'];
                $IdAcuerdoComercial = $itemConsulta['IdAcuerdoComercial'];
                $CodigoUnidadMedida = $itemConsulta['CodigoUnidadMedida'];
                $CodigoGrupoArticulosDescuentoMultilinea = $itemConsulta['CodigoGrupoArticulosDescuentoMultilinea'];
                $fechaMayor = $fechaInicio;
            }
        }
        $arrayRespuesta = array();
        $totalDescuento = $descuento1 + $descuento2;
        $arrayRespuesta = array(
            "descuentoMultiLinea" => $totalDescuento,
            "acuerdoComercialMulti" => $IdAcuerdoComercial,
            "unidadMedidaAcuerdoMulti" => $CodigoUnidadMedida,
            "CodigoGrupoArticulosDescuentoMultilinea" => $CodigoGrupoArticulosDescuentoMultilinea
        );
        return $arrayRespuesta;
    }

    ///AQUI SE LLAMA EL LA ACCION DE AJAX GUARDAR KIT DINAMICO

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
        $textKitCantidad = $_POST['txtCantidad'];
        $txtKitPrecioVentaBaseVariante = $_POST['txtKitPrecioVentaBaseVariante'];
        if ($session['componenteKitDinamico']) {
            $datosKit = $session['componenteKitDinamico'];
        } else {
            $datosKit = array();
        }
        if ($_POST['kd'] == 1) {
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
                'txtKitPrecioVentaBaseVariante' => $txtKitPrecioVentaBaseVariante
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
            echo '<pre>';
            print_r($datosKit);
            echo '</pre>';
        } elseif ($_POST['kd'] == 2) {
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
                'txtKitPrecioVentaBaseVariante' => $txtKitPrecioVentaBaseVariante
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
            echo '<pre>';
            print_r($datosKit);
            echo '</pre>';
        }
    }

    /////////////////////////////////CODIGO VIEJO////////////////////////////

    private function getRestriccionesProveedor($zonaventas, $cuentaCliente, $codigoVariante) {
        /* $zonaventas = $_POST['zonaventas'];
          $cuentaCliente = $_POST['cliente'];
          $codigoVariante = $_POST['codigoVariante']; */
        $restriccionesArticulo = Consultas::model()->getRestriccionesProveedorArticulo($cuentaCliente, $zonaventas, $codigoVariante);
        $restriccionesArticulo = $restriccionesArticulo['Total'];
        //echo $restriccionesArticulo;
        if ($restriccionesArticulo > 0) {
            return false;
        } else {
            $restriccionesGrupo = Consultas::model()->getRestriccionesProveedorGrupo($cuentaCliente, $zonaventas, $codigoVariante);
            $restriccionesGrupo = $restriccionesGrupo['Total'];
            //echo $restriccionesGrupo;
            if ($restriccionesGrupo > 0) {
                return false;
            } else {
                $restriccionesProveedor = Consultas::model()->getRestriccionesProveedor($cuentaCliente, $zonaventas, $codigoVariante);
                $restriccionesProveedor = $restriccionesProveedor['Total'];
                //echo $restriccionesProveedor;
                return $restriccionesProveedor > 0;
            }
        }
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

    private function getPortafolioInventarioTipoVenta($codigoSitio, $codigoAlmacen, $zonaVentas, $cuentaCliente, $tipoInventario) {
        $session = new CHttpSession;
        $session->open();
        $portafolioZonaVentas = Consultas::model()->getPortafolio($zonaVentas, $codigoSitio, $codigoAlmacen);
        $portafolioSinRestriccion = array();
        foreach ($portafolioZonaVentas as $itemPortafolio) {
            $zonaventas = $zonaVentas;
            $codigoVariante = $itemPortafolio['CodigoVariante'];
            $grupoVentas = $itemPortafolio['CodigoGrupoVentas'];
            $detalleProducto = Consultas::model()->getDetalleProductoPedido($grupoVentas, $codigoVariante, $codigoSitio, $codigoAlmacen);
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
                    $saldoInventario = Consultas::model()->getSaldoInventarioPedidoAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion);
                } else {
                    $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
                }
                /* if($saldoInventario['LoteArticulo']== 'LTE-001' ){
                  echo  $saldoInventario['Disponible'].' ---------';
                  } */
                /*
                  if($CodigoUnidadMedida!=$saldoInventario['CodigoUnidadMedida']){
                  $saldoInventario['Disponible']=$this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'],$saldoInventario['CodigoUnidadMedida'],$CodigoUnidadMedida, $saldoInventario['Disponible']);
                  }
                 */
                if (count($saldoInventario) > 0) {
                    $itemPortafolio['SaldoInventario'] = count($saldoInventario);
                    $itemPortafolio['CodigoUnidadMedida'] = $saldoInventario['CodigoUnidadMedida'];
                    $itemPortafolio['IdSaldoInventario'] = count($saldoInventario);
                } else {
                    $itemPortafolio['SaldoInventario'] = '0';
                }
                array_push($portafolioSinRestriccion, $itemPortafolio);
            }
        }
        return $portafolioSinRestriccion;
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

    public function actionAjaxPedidoMinimo() {
        if ($_POST) {
            $session = new CHttpSession;
            $session->open();
            $datos = $session['datosCompletarForm'];
            $datoPedido = $session['pedidoForm'];
            $datosKit = $session['componenteKitDinamico'];
            $session['pedidoFromAlmacenadoAutoventa'] = $datoPedido;
            $session['componenteKitDinamicoAlmacenadoAutoventa'] = $datosKit;
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
            $factura = $_POST['factura'];
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
                'longitud' => $longitud,
                'factura' => $factura
            );
            $session['EncabezadoPedidoAlamcenadoAutoventa'] = $pedidoAlamcenado;
            $session['TotalesAlmacenadosAutoventa'] = $totalesAlmacenados;
        }
    }

}
