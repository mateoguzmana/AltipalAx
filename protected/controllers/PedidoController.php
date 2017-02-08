<?php

class PedidoController extends Controller {

    public function filters() {
        return array('accessControl'); // perform access control for CRUD operations
    }

    public function accessRules() {
        return array(
            array('allow', // allow authenticated users to access all actions
                'users' => array('@'),
            ),
            array('deny'),
        );
    }

    public function actionAjaxCompletarFormAsesor() {
        if ($_POST) {
            if ($_POST['codigoAsesor']) {
                $codigoAsesor = $_POST['codigoAsesor'];
                $consultaAsesor = Consultas::model()->getNombreAsesor($codigoAsesor);
                echo json_encode($consultaAsesor);
            }
            if ($_POST['nombreAsesor']) {
                $nombreAsesor = $_POST['nombreAsesor'];
                $consultaAsesor = Consultas::model()->getCodigoAsesor($nombreAsesor);
                echo json_encode($consultaAsesor);
            }
        }
    }

    public function actionPCrearedido($cliente, $zonaVentas) {
        if ($_POST) {
            $request = (object) $_POST;
            $session = new CHttpSession;
            $session->open();
            $datos = $session['datosCompletarForm'];
            $datosForm = $session['pedidoForm'];
            $Conjunto = '';
            $CodAsesor = $datos['codigoAsesor'];
            $CodZonaVentas = $request->zonaVentas;
            $CuentaCliente = $request->cuentaCliente;
            $CodGrupoVenta = $datos['grupoVentas'];
            $consulta = Consultas::model()->getGrupoPrecio($CodZonaVentas, $CuentaCliente);
            $CodGrupoPrecios = $consulta['CodigoGrupoPrecio'];
            $Ruta = $datos['diaRuta'];
            $CodigoSitio = $datos['codigositio'];
            $CodigoAlmacen = $datos['codigoAlmacen'];
            $FechaPedido = date('Y-m-d');
            $HoraDigitado = date('H:m:s');
            $HoraEnviado = date('H:m:s');
            $FechaEntrega = $request->fechaEntrega;
            $FormaPago = $request->formaPago;
            $Plazo = $request->plazo;
            $TipoVenta = $request->tipoVenta;
            $ActividadEspecial = $request->actividadEspecial;
            $Observacion = $request->Observaciones;
            $NroFactura = '';
            $saldoCupo = $request->saldoCupo;
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
            $Estado = '';
            $ArchivoXml = '';
            $FechaTerminacion = date('Y-m-d');
            $HoraTerminacion = date('H:i:s');
            $EstadoPedido = '0';
            $AutorizaDescuentoEspecial = '0';
            $Web = '1';
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '1';
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
                'HoraDigitado' => $HoraDigitado,
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
                'FechaTerminacion' => $FechaTerminacion,
                'HoraTerminacion' => $HoraTerminacion,
                'EstadoPedido' => $EstadoPedido,
                'AutorizaDescuentoEspecial' => $AutorizaDescuentoEspecial,
                'Web' => $Web,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'CodigoCanal' => $session['canalEmpleado'],
                'Responsable' => $session['Responsable'],
                'ExtraRuta' => $session['extraruta']
            );
            $model = new Pedidos;
            //$model->tableName();
            $model->attributes = $arrayEncabezado;
            if ($model->validate()) {
                $model->save();
                foreach ($datosForm as $itemDatos) {
                    $IdPedido = $model->IdPedido;
                    $CodVariante = $itemDatos['variante'];
                    $CodigoArticulo = $itemDatos['articulo'];
                    $NombreArticulo = $itemDatos['nombreProducto'];
                    $Cantidad = $itemDatos['cantidad'];
                    $ValorUnitario = $itemDatos['valorUnitario'];
                    $Iva = $itemDatos['iva'];
                    $Impoconsumo = $itemDatos['impoconsumo'];
                    $CodigoUnidadMedida = $itemDatos['codigoUnidadMedida'];
                    $Saldo = $itemDatos['saldo'];
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
                    $AutorizaDscto = '';
                    $FechaAutorizacionDscto = '';
                    $HoraAutorizacionDscto = '';
                    $QuienAutorizaDscto = '';
                    $EstadoRevisadoAltipal = '';
                    $EstadoRevisadoProveedor = '';
                    $MotivoRechazo = '';
                    $EstadoRechazoAltipal = '';
                    $EstadoRechazoProveedor = '';
                    $UsuarioAutorizoDscto = '';
                    $NombreAutorizoDscto = '';
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
                        'Cantidad' => $Cantidad,
                        'ValorUnitario' => $ValorUnitario,
                        'Iva' => $Iva,
                        'Impoconsumo' => $Impoconsumo,
                        'CodigoUnidadMedida' => $CodigoUnidadMedida,
                        'Saldo' => $Saldo,
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
                        'NombreAutorizoDscto' => NombreAutorizoDscto,
                        'PedidoMaquina' => $PedidoMaquina,
                        'IdentificadorEnvio' => $IdentificadorEnvio,
                        'EstadoTerminacion' => $EstadoTerminacion,
                    );
                    $modelDetalle = new Descripcionpedido;
                    $modelDetalle->attributes = $datosDetalle;
                    if (!$modelDetalle->validate()) {
                        print_r($modelDetalle->getErrors());
                        exit();
                    } else {
                        $modelDetalle->save();
                    }
                }
            } else {
                print_r($model->getErrors());
            }
            //Restar el valor del pedido del saldo del cliente
            if ($FormaPago == 'credito') {
                $nuevoValor = $saldoCupo - $ValorPedido;
                Consultas::model()->actualizarSaldoCupo($CuentaCliente, $CodZonaVentas, $nuevoValor);
            }
        }
        $condicionPago = Consultas::model()->getCondicionPagoCliente($cliente, $zonaVentas);
        $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas);
        $portafolioZonaVentas = Consultas::model()->getPortafolio($zonaVentas);
        $portafolioSinRestriccion = array();
        $session = new CHttpSession;
        $session->open();
        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];
        $datos = $session['datosCompletarForm'];
        $datos['codigositio'] = $codigoSitio;
        $datos['codigoAlmacen'] = $codigoAlmacen;
        $session['datosCompletarForm'] = $datos;
        foreach ($portafolioZonaVentas as $itemPortafolio) {
            $zonaventas = $zonaVentas;
            $cuentaCliente = $cliente;
            $codigoVariante = $itemPortafolio['CodigoVariante'];
            if ($this->getRestriccionesProveedor($zonaventas, $cuentaCliente, $codigoVariante)) {
                $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProduto($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);
                if ($productoAcuerdoComercialProducto) {
                    $itemPortafolio['AcuerdoComercial'] = '1';
                } else {
                    $productoAcuerdoComercialGrupo = Consultas::model()->getAcuerdoComercialGrupo($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaventas);
                    if ($productoAcuerdoComercialGrupo) {
                        $itemPortafolio['AcuerdoComercial'] = '1';
                    } else {
                        $itemPortafolio['AcuerdoComercial'] = '0';
                    }
                }
                $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
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
        $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($zonaVentas);
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $this->render('crearPedido', array('datosCliente' => $datosCliente,
            'zonaVentas' => $zonaVentas,
            'condicionPago' => $condicionPago,
            'sitiosVentas' => $sitiosVentas,
            'portafolioZonaVentas' => $portafolioZonaVentas,
            'permisosDescuentoEspecial' => $permisosDescuentoEspecial
        ));
    }

    public function actionAjaxGetTipoventa() {

        if ($_POST) {

            $zonaVentas = $_POST['zonaVentas'];
            $cliente = $_POST['cliente'];
            $sitio = $_POST['sitio'];

            $tipoVentas = Consultas::model()->getTipoVenta($zonaVentas, $sitio);

            $option.="<option value>Seleccione un tipo de venta</option>";

            if ($tipoVentas['Preventa'] == "Verdadero") {
                $option.="<option value='Preventa'>Preventa</option>";
            }

            if ($tipoVentas['Autoventa'] == "Verdadero") {
                $option.="<option value='Autoventa'>Autoventa</option>";
            }

            if ($tipoVentas['Consignacion'] == "Verdadero") {
                $option.="<option value='Consignacion'>Consignacion</option>";
            }

            if ($tipoVentas['VentaDirecta'] == "Verdadero") {
                $option.="<option value='VentaDirecta'>Venta Directa</option>";
            }

            if ($tipoVentas['Focalizado'] == "Verdadero") {
                $option.="<option value='Focalizado'>Focalizado</option>";
            }

            echo $option;
        }
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

    //Metodo para crear un pedido
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

    public function actionAjaxACDLCantidades() {

        if ($_POST) {

            $session = new CHttpSession;
            $session->open();
            $codigoSitio = $session['codigositio'];
            $codigoAlmacen = $session['Almacen'];
            $zonaVentas = $_POST['zonaventas'];

            $codigoVariante = $_POST['codigoVariante'];
            $cuentaCliente = $_POST['cliente'];
            $CodigoUnidadMedida = $_POST['unidadMedida'];
            $articulo = $_POST['articulo'];
            $cantidad = $_POST['cantidadPedida'];


            $ACDLClienteArticuloSaldo = Consultas::model()->getACDLClienteArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida);

            if ($ACDLClienteArticuloSaldo) {

                $resultado = array(
                    'IdAcuerdo' => $ACDLClienteArticuloSaldo['Id'],
                    'LimiteVentas' => $ACDLClienteArticuloSaldo['LimiteVentas'],
                    'Saldo' => $ACDLClienteArticuloSaldo['Saldo'],
                    'SaldoSinConversion' => $ACDLClienteArticuloSaldo['Saldo'],
                    'CodigoUnidadMedida' => $ACDLClienteArticuloSaldo['CodigoUnidadMedida'],
                    'PorcentajeDescuentoLinea1' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLinea1'],
                    'PorcentajeDescuentoLinea2' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLinea2']
                );

                echo json_encode($resultado);
            } else {

                $ACDLGrupoClienteArticuloSaldo = Consultas::model()->getACDLGrupoClienteArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida, $zonaVentas);

                //print_r($ACDLGrupoClienteArticuloSaldo);

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

                    echo json_encode($resultado);
                } else {

                    $ACDLClienteGrupoArticuloSaldo = Consultas::model()->getACDLClienteGrupoArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida);

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

                        echo json_encode($resultado);
                    } else {
                        $ACDLGrupoClienteGrupoArticuloSaldo = Consultas::model()->getACDLGrupoClienteGrupoArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida, $zonaVentas);
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
                            echo json_encode($resultado);
                        } else {
                            $ACDLGrupoClienteArticuloSinSitioSaldo = Consultas::model()->getACDLGrupoClienteArticuloSinSitioSinSaldo($articulo, $codigoVariante, $cuentaCliente, $cantidad, $CodigoUnidadMedida, $zonaVentas);
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
                                echo json_encode($resultado);
                            } else {
                                $ACDLGrupoClienteGrupoArticuloSinSitioSaldo = Consultas::model()->getACDLGrupoClienteGrupoArticuloSinSitioSinSaldo($articulo, $codigoVariante, $cuentaCliente, $cantidad, $CodigoUnidadMedida, $zonaVentas);
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

    public function actionAjaxACDM() {
        if ($_POST) {
            $session = new CHttpSession;
            $session->open();
            $codigoAlmacen = $session['Almacen'];
            $cuentaCliente = $_POST['cliente'];
            $codigoVariante = $_POST['codigoVariante'];
            $cantidadPedida = $_POST['cantidadPedida'];
            $sitio = $_POST['sitio'];
            $CodigoUnidadMedida = $_POST['unidadMedida'];
            $articulo = $_POST['articulo'];
            $ACDMClienteGrupoarticulos = Consultas::model()->getClienteGrupoArticulosACDM($articulo, $cuentaCliente, $codigoVariante, $cantidadPedida, $sitio, $codigoAlmacen, $CodigoUnidadMedida);
            if ($ACDMClienteGrupoarticulos) {
                $resultado = array(
                    'CodigoUnidadMedida' => $ACDMClienteGrupoarticulos['CodigoUnidadMedida'],
                    'PorcentajeDescuentoMultilinea1' => $ACDMClienteGrupoarticulos['PorcentajeDescuentoMultilinea1'],
                    'PorcentajeDescuentoMultilinea2' => $ACDMClienteGrupoarticulos['PorcentajeDescuentoMultilinea2']
                );
                echo json_encode($resultado);
            } else {
                $ACDMGrupoClienteGrupoarticulos = Consultas::model()->getGrupoClienteGrupoArticulosACDM($articulo, $cuentaCliente, $codigoVariante, $cantidadPedida, $sitio, $codigoAlmacen, $CodigoUnidadMedida);
                if ($ACDMGrupoClienteGrupoarticulos) {
                    $resultado = array(
                        'CodigoUnidadMedida' => $ACDMGrupoClienteGrupoarticulos['CodigoUnidadMedida'],
                        'PorcentajeDescuentoMultilinea1' => $ACDMGrupoClienteGrupoarticulos['PorcentajeDescuentoMultilinea1'],
                        'PorcentajeDescuentoMultilinea2' => $ACDMGrupoClienteGrupoarticulos['PorcentajeDescuentoMultilinea2']
                    );
                    echo json_encode($resultado);
                } else {
                    $ClienteGrupoArticulosACDMSinSitio = Consultas::model()->getClienteGrupoArticulosACDMSinSitio($articulo, $cuentaCliente, $codigoVariante, $cantidadPedida, $CodigoUnidadMedida);
                    if ($ClienteGrupoArticulosACDMSinSitio) {
                        $resultado = array(
                            'CodigoUnidadMedida' => $ClienteGrupoArticulosACDMSinSitio['CodigoUnidadMedida'],
                            'PorcentajeDescuentoMultilinea1' => $ClienteGrupoArticulosACDMSinSitio['PorcentajeDescuentoMultilinea1'],
                            'PorcentajeDescuentoMultilinea2' => $ClienteGrupoArticulosACDMSinSitio['PorcentajeDescuentoMultilinea2']
                        );
                        echo json_encode($resultado);
                    } else {
                        $GrupoClienteGrupoArticulosACDMSinSitio = Consultas::model()->getGrupoClienteGrupoArticulosACDMSinSitio($articulo, $cuentaCliente, $codigoVariante, $cantidadPedida, $CodigoUnidadMedida);
                        if ($GrupoClienteGrupoArticulosACDMSinSitio) {
                            $resultado = array(
                                'CodigoUnidadMedida' => $GrupoClienteGrupoArticulosACDMSinSitio['CodigoUnidadMedida'],
                                'PorcentajeDescuentoMultilinea1' => $GrupoClienteGrupoArticulosACDMSinSitio['PorcentajeDescuentoMultilinea1'],
                                'PorcentajeDescuentoMultilinea2' => $GrupoClienteGrupoArticulosACDMSinSitio['PorcentajeDescuentoMultilinea2']
                            );
                            echo json_encode($resultado);
                        } else {
                            echo '0';
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
            $detalleProducto = Consultas::model()->getDetalleProductoPedido($grupoVentas, $codigoVariante);
            //echo $tipoInventario;
            if ($tipoInventario == "Autoventa") {
                $ubicacion = $session['Ubicacion'];
                $saldoInventario = Consultas::model()->getSaldoInventarioAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion, $cliente);
            } else {
                $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
            }
            //exit();
            // print_r($saldoInventario);
            //echo $CodigoUnidadMedida.'!='.$saldoInventario['CodigoUnidadMedida'];
            if ($CodigoUnidadMedida != $saldoInventario['CodigoUnidadMedida']) {
                $saldoInventario['Disponible'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $saldoInventario['CodigoUnidadMedida'], $CodigoUnidadMedida, $saldoInventario['Disponible']);
            }
            //echo $saldoInventario['Disponible'];
            //exit();
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
                    'PorcentajedeIVA' => $detalleProducto['PorcentajedeIVA'],
                    'ValorIMPOCONSUMO' => $detalleProducto['ValorIMPOCONSUMO'],
                    'CodigoTipoKit' => $detalleProducto['CodigoTipoKit'],
                    'TotalPrecioVentaListaMateriales' => $detalleProducto['TotalPrecioVentaListaMateriales'],
                    'CodigoListaMateriales' => $detalleProducto['CodigoListaMateriales']
                );
                echo json_encode($detalle);
            }
        }
    }

    public function actionAjaxSetSitioTipoVenta() {
        if ($_POST) {
            $codigositio = $_POST['codigositio'];
            $tipoVenta = $_POST['tipoVenta'];
            $nombreSitio = $_POST['nombreSitio'];
            $nombreTipoVenta = $_POST['nombreTipoVenta'];
            $desPreventa = $_POST['desPreventa'];
            $desAutoventa = $_POST['desAutoventa'];
            $desConsignacion = $_POST['desConsignacion'];
            $desVentaDirecta = $_POST['desVentaDirecta'];
            $desAlmacen = $_POST['desAlmacen'];
            $ubicacion = $_POST['ubicacion'];
            $codagencia = Yii::app()->user->_Agencia;
            $zonaVentas = Yii::app()->user->_zonaVentas;
            $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas, $codagencia);
            $sitio = Consultas::model()->getSitio($zonaVentas, $codagencia);
            /* echo '<pre>';
              print_r($sitiosVentas); */
            $session = new CHttpSession;
            $session->open();
            $cont = 0;
            foreach ($sitiosVentas as $item) {
                if ($item['CodigoAlmacen'] == $sitio[0]['CodigoAlmacen'] && $sitio[0]['CodigoSitio'] == $item['CodigoSitio'] && ($item['Consignacion'] == 'verdadero' || $item['Preventa'] == 'verdadero' )) {

                    $cont++;
                }
            }
            echo $cont;
            if ($cont > 1) {
                $session['desPreventa'] = 'verdadero';
                $session['Consignacion'] = 'verdadero';
                $session['codigositio'] = $codigositio;
                $session['tipoVenta'] = $tipoVenta;
                $session['nombreSitio'] = $nombreSitio;
                $session['nombreTipoVenta'] = $nombreTipoVenta;
                $session['Autoventa'] = $desAutoventa;
                $session['Almacen'] = $desAlmacen;
                $session['Ubicacion'] = $ubicacion;
            } else {
                $session['codigositio'] = $codigositio;
                $session['tipoVenta'] = $tipoVenta;
                $session['nombreSitio'] = $nombreSitio;
                $session['nombreTipoVenta'] = $nombreTipoVenta;
                $session['desPreventa'] = $desPreventa;
                $session['Autoventa'] = $desAutoventa;
                $session['Consignacion'] = $desConsignacion;
                $session['VentaDirecta'] = $desVentaDirecta;
                $session['Almacen'] = $desAlmacen;
                $session['Ubicacion'] = $ubicacion;
            }
        }
    }

    public function diff_dte($date1, $date2) {
        if (!is_integer($date1))
            $date1 = strtotime($date1);
        if (!is_integer($date2))
            $date2 = strtotime($date2);
        return floor(abs($date1 - $date2) / 60 / 60 / 24);
    }

    /*     * ************************************************************************************************************* */

    public function actionAgregarItemPedido() {
        $session = new CHttpSession;
        $session->open();
        if ($session['pedidoForm']) {
            $datos = $session['pedidoForm'];
        } else {
            $datos = array();
        }
        $nombreProducto = $_POST['nombreProducto'];
        $codigoArticulo = $_POST['codigoArticulo'];
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
                'aplicaImpoconsumo' => $aplicaImpoconsumo
            );
            $itemAgregarPedido2 = array(
                'nombreProducto' => $nombreProducto,
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

    public function actionEliminarItemPedido() {
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

    public function actionTotalesPedido() {
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
    public function actionAjaxGetTipoSaldo() {
        $session = new CHttpSession;
        $session->open();
        $session['tipoInventario'] = $_POST['saldoInventario'];
    }
    /*     * ************************************************************************************************************** */
}
