<?php

class TransferenciaConsignacionController extends Controller {

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
    private $cargarVariantesInactivas;
    private $variantesInactivas;

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

    public function actionCrearTransferencia($cliente, $zonaVentas) {



        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/transferenciaConsignacion/transferenciaconsignacion.js', CClientScript::POS_END
        );

        $codagencia = Yii::app()->user->_Agencia;

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
            $CodGrupoVenta = $datos['grupoVentas'];
            $CodigoCanal = $_POST['CodigoCanal'];
            $Responsable = $_POST['Responsable'];
            $HoraPedido = $_POST['horaPedido'];
             
           

            $consulta = Consultas::model()->getGrupoPrecio($CodZonaVentas, $CuentaCliente);

            $CodGrupoPrecios = $consulta['CodigoGrupoPrecio'];
            $Ruta = trim($datos['diaRuta']);
            $CodigoSitio = $datos['codigositio'];
            $CodigoAlmacen = $datos['codigoAlmacen'];
            $FechaTransferencia = date('Y-m-d');
            $HoraDigitado = $HoraPedido;
            $HoraEnviado = date('H:i:s');
            $Estado = '1';
            $ArchivoXml = '';
            $Web = '1';
            $PedidoMaquina = '0';
            $IdentificadorEnvio = '1';




            $arrayEncabezado = array(
                'CodAsesor' => $CodAsesor,
                'CodZonaVentas' => $CodZonaVentas,
                'CuentaCliente' => $CuentaCliente,
                'CodGrupoVenta' => $CodGrupoVenta,
                'CodGrupoPrecios' => $CodGrupoPrecios,
                'Ruta' => $Ruta,
                'CodigoSitio' => $CodigoSitio,
                'CodigoAlmacen' => $CodigoAlmacen,
                'FechaTransferencia' => $FechaTransferencia,
                'HoraDigitado' => $HoraDigitado,
                'HoraEnviado' => $HoraEnviado,
                'Estado' => $Estado,
                'ArchivoXml' => $ArchivoXml,
                'Web' => $Web,
                'PedidoMaquina' => $PedidoMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'CodigoCanal' => $CodigoCanal,
                'Responsable' => $Responsable,
                'ExtraRuta' => $session['extraruta'],
                'Ruta' => $session['clienteSeleccionado']['diaRuta'],
            );
            
            

            $model = new Transferenciaconsignacion;
            $model->attributes = $arrayEncabezado;

            if ($model->validate()) {

               $model->save();
                  
                
                foreach ($datosForm as $itemDatos) {

                    $IdTransferencia = $model->IdTransferencia;
                    $CodVariante = $itemDatos['variante'];
                    $CodigoArticulo = $itemDatos['articulo'];
                    $NombreArticulo = $itemDatos['nombreProducto'];
                    $Cantidad = $itemDatos['cantidad'];
                    $UnidadMedida = $itemDatos['unidadMedida'];
                    $PedidoMaquina = '0';
                    $IdentificadorEnvio = '0';


                   
                    $datosDetalle = array(
                        'IdTransferencia' => $IdTransferencia,
                        'CodVariante' => $CodVariante,
                        'CodigoArticulo' => $CodigoArticulo,
                        'NombreArticulo' => $NombreArticulo,
                        'Cantidad' => $Cantidad,
                        'PedidoMaquina' => $PedidoMaquina,
                        'UnidadMedida'=>$UnidadMedida,
                        'IdentificadorEnvio' => $IdentificadorEnvio,
                    );
                    
                    

                    $modelDetalle = new Descripciontransferenciaconsignacion;
                    $modelDetalle->attributes = $datosDetalle;

                    if (!$modelDetalle->validate()) {

                        print_r($modelDetalle->getErrors());
                    } else {
                        $modelDetalle->save();
                        
                        
                       foreach ($datosKit as $itemKit) {



                            if ($CodigoArticulo == $itemKit['txtCodigoArticuloKit']) {
                                

                                if ($itemKit['txtCantidadItemFijo'] != "" || $itemKit['txtCantidadItemOpcional'] != "") {


                                    $arrayDatosKit = array(
                                        'IdDescripcionTransferencia' => $modelDetalle->Id,
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

                                    $modelDetalleKit = new Kitdescripciontransferencia;
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
                                        'IdDescripcionTransferencia' => $modelDetalle->Id,
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



                                    $modelDetalleKit = new Kitdescripciontransferencia;
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
                    
                    /*$transferecniaExistente = Transferenciaconsignacion::model()->getTransaccionExistente($model->IdTransferencia);
                    
                    if($transferecniaExistente['transacciones'] == 0){
                    
                    $codtipodoc = '8';
                    $estado = '0';

                        $TransaxConsiga = array(
                            'CodTipoDocumentoActivity' => $codtipodoc,
                            'IdDocumento' => $model->IdTransferencia,
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
                    }*/    
                    
                }
            } else {
                print_r($model->getErrors());
            }

            Yii::app()->user->setFlash('succe', '');
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
        $ubicacion = Preventa::model()->cargarUbicacionZona($zonaVentas);
        
       
        $this->zonaVentas = $zonaVentas;
        $this->cuentaCliente = $cliente;
        $this->codigoSitio = $codigoSitio;
        $this->codigoAlmacen = $codigoAlmacen;
        $this->ubicacion = $ubicacion['CodigoUbicacion'];


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
                                                exit();
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
                    }
                }
            }
        }




       $portafolioZonaVentas = $this->portafolio;
       
       /*echo '<pre>';
       print_r($portafolioZonaVentas);
       exit();*/

       $permisosDescuentoEspecial = Consultas::model()->getPermisosDescuentoEspecial($zonaVentas);

        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $datoszona = Transferenciaconsignacion::model()->getDatosZona($zonaVentas);

        $this->render('index', array('datosCliente' => $datosCliente,
            'zonaVentas' => $zonaVentas,
            'condicionPago' => $condicionPago,
            'sitiosVentas' => $sitiosVentas,
            'portafolioZonaVentas' => $portafolioZonaVentas,
            'permisosDescuentoEspecial' => $permisosDescuentoEspecial,
            'datoszona' => $datoszona
        ));
        
          
       
    }

    
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
            echo 'Division';
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
                'txtCodigoGrupoClienteDescuentoMultilinea' => $txtCodigoGrupoClienteDescuentoMultilinea
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
        $textKitCantidad = $_POST['txtCantidad'];
        $txtKitPrecioVentaBaseVariante = $_POST['txtKitPrecioVentaBaseVariante'];
        $txtKitCodigoVarianteComponente = $_POST['txtKitCodigoVarianteComponente'];


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
                'txtKitPrecioVentaBaseVariante' => $txtKitPrecioVentaBaseVariante,
                'txtCodigoVarianteComponente' => $txtKitCodigoVarianteComponente
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
                'txtKitPrecioVentaBaseVariante' => $txtKitPrecioVentaBaseVariante,
                'txtCodigoVarianteComponente' => $txtKitCodigoVarianteComponente
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

    /*
     * Cargar portafolio
     */

    private function cargarPotafolio() {

        try {

            Preventa::model()->setZonaVentas($this->zonaVentas);
            $this->cargarPortafolio = Preventa::model()->cargarPortafolio();

            if (!$this->cargarPortafolio) {
                $this->txtError = "No se ha realizado la carga del portafolio";
                return false;
            } else {
                $this->portafolio = Preventa::model()->getDataReader();

                /* echo '<pre>';
                  print_r($this->portafolio);
                  echo '</pre>';*/


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
            $this->ubicacion = Yii::app()->user->_cedula;
            Preventa::model()->setUbicacion($this->ubicacion);

            if (!Preventa::model()->cargarSaldoInventarioPreventa()) {
                $this->txtError = Preventa::model()->getTxtError;
                return false;
            } else {
                $this->saldoPreventa = Preventa::model()->getDataReader();
            }


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
                
                ///////Saldooos
               /* echo '<pre>';
                print_r($this->saldoPreventa);
                exit();*/

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

                    foreach ($this->listaMateriales as $itemLista) {

                        /* echo '<pre>';
                          print_r($itemLista);
                          exit(); */

                        $codigoVarianteComponente = $itemLista['LMDCodigoVarianteComponente'];
                        $LMCodigoVarianteKit = $itemLista['LMCodigoVarianteKit'];

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
                            }

                            $session = new CHttpSession;
                            $session->open();
                            $session['listaMateriales'] = $this->listaMateriales;
                        }
                    }
                    //exit(); 
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
                      print_r($this->saldoAutoventa); */

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

                        //echo $itemListaMateriales['LMCodigoArticuloKit'].' </br>';
                        //exit();


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
                        //$contListaAuto++;
                    }
                }
            }



            /* $session = new CHttpSession;
              $session->open();
              $session['listaMateriales'] = $this->listaMateriales; */

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




        /* $cont=0;
          foreach ($this->portafolio as $itemPortafolio){

          $porCodigoArticulo=$itemPortafolio['CodigoArticulo'];
          $porCodigoVariante=$itemPortafolio['CodigoVariante'];
          $porCodigoTipo=$itemPortafolio['CodigoTipo'];
          $porACPrecioVenta=$itemPortafolio['ACPrecioVenta'];


          if($porCodigoTipo=="KV" || $porCodigoTipo=="KD"){

          $contLista=0;
          foreach ($this->listaMateriales as $itemListaMateriales){



          $LMCodigoArticuloKit=$itemListaMateriales['LMCodigoArticuloKit'];
          $LMDCodigoArticuloComponente=$itemListaMateriales['LMDCodigoArticuloComponente'];
          $LMSPDisponible=$itemListaMateriales['SPDisponible'];

          if($LMCodigoArticuloKit==$porCodigoArticulo && $LMSPDisponible==""){
          $this->portafolio[$cont]['kitActivo']='0';
          }
          }
          }

          $cont++;

          } */


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

        try {

            $txtCodigoVariante = $_POST['txtCodigoVariante'];
            $txtCodigoArticulo = $_POST['txtCodigoArticulo'];
            $txtCliente = $_POST['txtCliente'];
            $txtCodigoAcuerdoPrecioVenta = $_POST['txtCodigoAcuerdoPrecioVenta'];
            $txtNombreUnidadMedidaPrecioVenta = $_POST['txtNombreUnidadMedidaPrecioVenta'];
            $txtTipoVenta = $_POST['tipoVenta'];
            $txtLote = $_POST['txtLote'];
            $txtSaldo = $_POST['txtSaldo'];
            $ubicacion = Yii::app()->user->_cedula;

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

    
    /*
     * acciones de transferencia
     */
    
    public function actionAjaxACDLTransferencia() {


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
                    'PorcentajeDescuentoLinea1' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLÃ­nea1'],
                    'PorcentajeDescuentoLinea2' => $ACDLClienteArticuloSaldo['PorcentajeDescuentoLÃ­nea2']
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
                        'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteArticuloSaldo['PorcentajeDescuentoLÃ­nea1'],
                        'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteArticuloSaldo['PorcentajeDescuentoLÃ­nea2']
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
                            'PorcentajeDescuentoLinea1' => $ACDLClienteGrupoArticuloSaldo['PorcentajeDescuentoLÃ­nea1'],
                            'PorcentajeDescuentoLinea2' => $ACDLClienteGrupoArticuloSaldo['PorcentajeDescuentoLÃ­nea2']
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
                                'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteGrupoArticuloSaldo['PorcentajeDescuentoLÃ­nea1'],
                                'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteGrupoArticuloSaldo['PorcentajeDescuentoLÃ­nea2']
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
                                    'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteArticuloSinSitioSaldo['PorcentajeDescuentoLÃ­nea1'],
                                    'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteArticuloSinSitioSaldo['PorcentajeDescuentoLÃ­nea2']
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
                                        'PorcentajeDescuentoLinea1' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['PorcentajeDescuentoLÃ­nea1'],
                                        'PorcentajeDescuentoLinea2' => $ACDLGrupoClienteGrupoArticuloSinSitioSaldo['PorcentajeDescuentoLÃ­nea2']
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
    
    public function actionAjaxDetalleArticuloTransferencia() {
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

          

            if ($tipoInventario == "Autoventa") {
           
                $ubicacion = $session['Ubicacion'];
                $saldoInventario = Consultas::model()->getSaldoInventarioAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion);
            } else {
                
                $saldoInventario = Consultas::model()->getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen);
            }
            
            /*$ubicacion = $session['Ubicacion'];
            $saldoInventario = Consultas::model()->getSaldoInventarioAutoventaConsignacion($codigoVariante, $codigoSitio, $codigoAlmacen, $ubicacion);*/
             
             /*echo '<pre>';
             print_r($saldoInventario);
             exit();*/
            
            if ($CodigoUnidadMedida != $saldoInventario['CodigoUnidadMedida']) {

                $saldoInventario['Disponible'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], $saldoInventario['CodigoUnidadMedida'], $CodigoUnidadMedida, $saldoInventario['Disponible']);
            }
            
           
            if ($CodigoUnidadMedida != 003) {
                //Para el impoconsumo se invierte la funcion de de una mayor a una menor
                $detalleProducto['ValorIMPOCONSUMO'] = $this->buscaUnidadesConversionACDM($detalleProducto['CodigoArticulo'], '003', $CodigoUnidadMedida, $detalleProducto['ValorIMPOCONSUMO']);
            }

//            if ($detalleProducto) {


            if ($detalleProducto['CodigoTipo'] == 'KV') {
                $saldoKit = $this->actionValidateExistenciaKit($detalleProducto['CodigoArticulo'], $codigoSitio, $codigoAlmacen);
                $saldoInventario['Disponible'] = $saldoKit;
            }
            
            /*echo '<pre>';
            print_r($saldoInventario);
            exit();*/
            
            /*echo $detalleProducto['ValorIMPOCONSUMO'];
            exit();*/

            $detalle = array(
                'Cliente' => $cliente,
                'CodigoVariante' => $detalleProducto['CodigoVariante'],
                'NombreArticulo' => $detalleProducto['NombreArticulo'],
                'CodigoCaracteristica1' => $detalleProducto['CodigoCaracteristica1'],
                'CodigoCaracteristica2' => $detalleProducto['CodigoCaracteristica2'],
                'CodigoTipo' => $detalleProducto['CodigoTipo'],
                'SaldoInventarioPreventa' => $saldoInventario['Disponible'],
                'CodigoUnidadMedidaSaldo' => $saldoInventario['CodigoUnidadMedida'],
                'PorcentajedeIVA' => $detalleProducto['PorcentajedeIVA'],
                'ValorIMPOCONSUMO' => $detalleProducto['ValorIMPOCONSUMO']
            );

            echo json_encode($detalle);
//            }
        }
    }
    
    public function actionAjaxValidarItemTransferencia() {

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
    
    public function actionAjaxACDMTransferencia() {

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
    
    public function actionAjaxAgregarItemTransferencia() {


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
        
        $Impo =  str_replace('$', '', $_POST['impoconsumo']);;
        $impoconsumo = $Impo;
        
        $cantidad = $_POST['cantidad'];
        $saldo = $_POST['saldo'];
        $saldoLimite = $_POST['saldoLimite'];
        $descuentoProveedor = $_POST['descuentoProveedor'];
        $descuentoAltipal = $_POST['descuentoAltipal'];
        $descuentoEspecial = $_POST['descuentoEspecial'];
        $iva = $_POST['iva'];
        $descuentoEspecialSelect = $_POST['descuentoEspecialSelect'];
        $descuentoEspecialProveedor = $_POST['descuentoEspecialProveedor'];
        $descuentoEspecialAltipal = $_POST['descuentoEspecialAltipal'];
        $aplicaImpoconsumo = $_POST['aplicaImpoconsumo'];

        $codigoUnidadMedidaACDL = $_POST['codigoUnidadMedidaACDL'];
        $saldoACDLSinConversion = $_POST['saldoACDLSinConversion'];
        $idAcuerdo = $_POST['idAcuerdo'];
        $idSaldoInventario = $_POST['idSaldoInventario'];
        $codigoUnidadSaldoInventario = $_POST['codigoUnidadSaldoInventario'];
        $unidadMedida = $_POST['unidadMedida'];
        $codigoCliente = $_POST['codigoCliente'];
        $zonaVentas = $_POST['zonaVentas'];
        $grupoVentas = $_POST['grupoVentas'];


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


        $itemAgregarPedido = array(
            'nombreProducto' => $nombreProducto,
            'codigoCliente' => $codigoCliente,
            'zonaVentas' => $zonaVentas,
            'grupoVentas' => $grupoVentas,
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
            'aplicaImpoconsumo' => $aplicaImpoconsumo,
            'unidadMedida' => $unidadMedida
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

    public function actionAjaxEliminarItemTransferencia() {


        $session = new CHttpSession;
        $session->open();
        $datos = $session['pedidoForm'];


        if ($_POST) {

            $variante = $_POST['variante'];

            $cont = 0;
            $position = -1;
            $busqueda = false;
            foreach ($datos as $itemDatos) {
                if ($itemDatos['variante'] == $variante) {
                    $busqueda = true;
                    $position = $cont;
                }
                $cont++;
            }


            $auxiliar = array();



            if ($busqueda) {
                $llaves = array_keys($datos);
                foreach ($llaves as $key => $value) {

                    if ($datos[$value]['variante'] == $variante) {
                        $position = $value;
                    }
                }

                unset($datos[$position]);
            }

            $session['pedidoForm'] = $datos;



            Yii::import('application.extensions.pedido.Pedido');
            $pedido = new Pedido();
            $pedido->getCalcularTotales();
            echo $this->renderPartial('_tablaDetalle', array(), true);
        }
    }
    
    public function actionAjaxTotalesTransferencias() {
        Yii::import('application.extensions.pedido.Pedido');
        $pedido = new Pedido();
        $saldoCupo = $_POST['saldoCupo'];
        $pedido->getCalcularTotales();
        echo $this->renderPartial('_tablaTotales', array('saldoCupo' => $saldoCupo), true);
    }
    
    public function actionAjaxActualizaPortafolioAgregarTransferencia() {

        $session = new CHttpSession;
        $session->open();
        $datos = $session['pedidoForm'];

        $articulosAgregados = array();

        foreach ($datos as $itemDatos) {
            array_push($articulosAgregados, $itemDatos['variante']);
        }
        echo json_encode($articulosAgregados);
    }
    
    
    public function actionAjaxSetSitioTipoVenta() {

        if ($_POST) {

            $codigositio = $_POST['codigositio'];
            $desAlmacen = $_POST['desAlmacen'];
            $nombreSitio = $_POST['nombreSitio'];




            $session = new CHttpSession;
            $session->open();

            $session['codigositio'] = $codigositio;
            $session['Almacen'] = $desAlmacen;
            $session['nombreSitio'] = $nombreSitio;


            echo $session['codigositio'] . '<br>';
            echo $session['Almacen'] . '<br>';
            echo $session['nombreSitio'];
        }
    }
}
