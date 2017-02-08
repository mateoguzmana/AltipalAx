<?php

class DevolucionesController extends Controller {

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
        $session = new CHttpSession;
        $session->open();
        
       
        if ($session['portafolioProveedores']) {

            Yii::import('application.extensions.devoluciones.Devoluciones');
            $devoluciones = new Devoluciones();
            $devoluciones->getCalcularTotales();
            $portafolioProveedores = $session['portafolioProveedores'];
        } else {
            $portafolioProveedores = array();
        }

        if ($_POST) {



            $totalDevolucion = 0;
            $valorDevolucion = 0;
            $totalCantidad = 0;
            
           

            foreach ($portafolioProveedores as $item) {
                if ($item['Cantidad'] != 0) {
                    $valorDevolucion+=$item['valorNeto'];
                    $totalCantidad+=$item['Cantidad'];
                    $totalDevolucion++;
                }
            }
            
            
            $Agencia = Yii::app()->user->_Agencia;
            $CodAsesor = Yii::app()->user->getState('_cedula');
            $CodZonaVentas = $_POST['zonaVentas'];
            $CuentaCliente = $_POST['cuentaCliente'];
            $CodigoMotivoDevolucion = $_POST['txtMotivo'];
            $CuentaProveedor = $_POST['proveedor'];
            $CodigoSitio = $_POST['sitio'];
            $CodigoAlmacen = $session['Almacen'];
            $TotalDevolucion = $totalDevolucion;
            $ValorDevolucion = $valorDevolucion;
            $FechaDevolucion = date('Y-m-d');
            $HoraInicio = $_POST['horaInicio'];
            $HoraFinal = date('H:i:s');
            $Estado = '1';
            $Observacion = $_POST['txtObservacion'];
            $Web = '1';
            $ArchivoXml = '';
            $IdDevolucionMaquina = '0';
            $IdentificadorEnvio = '1';
            $Autoriza = '0';
            $QuienAutoriza = '';
            $FechaAutorizacion = '';
            $HoraAutorizacion = '';
            $AutorizaDetail = '0';
            $UnidadMedidaStandar = "Unidad";
            
            if($session['Responsable'] == ""){
                
                $Responsable = '0';
            }else{
                
               $Responsable = $session['Responsable'];
                
            }

            $datosDevoluciones = array(
                'CodAsesor' => $CodAsesor,
                'CodZonaVentas' => $CodZonaVentas,
                'CuentaCliente' => $CuentaCliente,
                'CodigoMotivoDevolucion' => $CodigoMotivoDevolucion,
                'CuentaProveedor' => $CuentaProveedor,
                'CodigoSitio' => $CodigoSitio,
                'TotalDevolucion' => $totalCantidad,
                'ValorDevolucion' => $ValorDevolucion,
                'FechaDevolucion' => $FechaDevolucion,
                'HoraInicio' => $HoraInicio,
                'HoraFinal' => $HoraFinal,
                'Estado' => $Estado,
                'Observacion' => $Observacion,
                'Web' => $Web,
                'ArchivoXml' => $ArchivoXml,
                'IdDevolucionMaquina' => $IdDevolucionMaquina,
                'IdentificadorEnvio' => $IdentificadorEnvio,
                'Autoriza' => $Autoriza,
                'QuienAutoriza' => $QuienAutoriza,
                'FechaAutorizacion' => $FechaAutorizacion,
                'HoraAutorizacion' => $HoraAutorizacion,
                'CodigoCanal' => $session['canalEmpleado'],
                'Responsable' => $Responsable,
                'ExtraRuta' => $session['extraruta'],
                'Ruta' => $session['rutaSeleccionada'],
                'Imei' => ''
            );



            $devolucion = new DevolucionesModel;
            $devolucion->attributes = $datosDevoluciones;


            if ($devolucion->validate()) {


                $devolucion->save();


                foreach ($portafolioProveedores as $item) {
                    if ($item['Cantidad'] != 0) {
                        
                      //se hace la convercion si es diferente a unidad
                        if ($item['NombreUnidadMedida'] != "Unidad") {

                            $FactorConversion = Consultas::model()->getFactorConvercionUnidad($Agencia, $item['CodigoArticulo'], $item['NombreUnidadMedida']);

                            $unidadMedidaConversion = $item['Cantidad'] * $FactorConversion;
                        } else {
                            $unidadMedidaConversion = $item['Cantidad'];
                        }

                        $datosDevolucionesDetalle = array(
                            'IdDevolucion' => $devolucion->IdDevolucion,
                            'CodigoVariante' => $item['CodigoVariante'],
                            'CodigoArticulo' => $item['CodigoArticulo'],
                            'NombreArticulo' => $item['NombreArticulo'] . ' ' . $item['CodigoCaracteristica1'] . ' ' . $item['CodigoCaracteristica2'],
                            'CodigoUnidadMedida' => $item['CodigoUnidadMedida'],
                            'NombreUnidadMedida' => $item['NombreUnidadMedida'],
                            'Cantidad' => $item['Cantidad'],
                            'ValorUnitario' => $item['precioNeto'],
                            'ValorBruto' => $item['totalValorPrecioNeto'],
                            'Impoconsumo' => $item['ValorIMPOCONSUMO'],
                            'ValorImpoconsumo' => $item['valorImpoconsumo'],
                            'Iva' => $item['PorcentajedeIVA'],
                            'ValorIva' => $item['totalValorIva'],
                            'ValorTotalProducto' => $item['valorNeto'],
                            'Autoriza' => $AutorizaDetail,
                            'UnidadMedidaConversion' => $UnidadMedidaStandar,
                            'CantidadConversion' => $unidadMedidaConversion 
                             
                        );
                        
                            /*echo '<pre>';
                            print_r($datosDevolucionesDetalle);
                            die();*/
                        

                        $Descripciondevolucion = new Descripciondevolucion;
                        $Descripciondevolucion->attributes = $datosDevolucionesDetalle;

                        if ($Descripciondevolucion->validate()) {
                            $Descripciondevolucion->save();
                        } else {
                            print_r($Descripciondevolucion->getErrors());
                        }

                       
                    }
                }
            } else {
                print_r($devolucion->getErrors());
                exit();
            }

            /*$codtipodoc = '6';
            $estado = '0';

            $TransaxDevoluciones = array(
                'CodTipoDocumentoActivity' => $codtipodoc,
                'IdDocumento' => $devolucion->IdDevolucion,
                'CodigoAgencia' => $codagencia,
                'EstadoTransaccion' => $estado
            );

            $modeltransax = new Transaccionesax;
            $modeltransax->attributes = $TransaxDevoluciones;

            if (!$modeltransax->validate()) {

                print_r($modeltransax->getErrors());
            } else {

                $modeltransax->save();
            }*/


            Yii::app()->user->setFlash('success', "Devolución enviada satisfactoriamente!!!");
            $this->redirect(array('Clientes/ClientesRutas'));
        }

        $Agencia = Yii::app()->user->_Agencia;
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $motivosproveedor = Consultas::model()->getProveedoresMotivo();
        $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas,$Agencia);
        
        

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/devoluciones/devolucionesIndex.js', CClientScript::POS_END
        );



        $this->render('index', array(
            'datosCliente' => $datosCliente,
            'cliente' => $cliente,
            'sitiosVentas' => $sitiosVentas,
            'motivosproveedor' => $motivosproveedor,
            'zonaVentas' => $zonaVentas
        ));
    }

    /* private function DevolucionesXML($CodZonaVentas) {

      $InfoXMl = DevolucionesModel::model()->getDevoluciones($CodZonaVentas);

      $xml = '<?xml version="1.0" encoding="utf-8"?>';

      foreach ($InfoXMl as $itemInfo) {

      $xml .= '<panel>';
      $xml .= '<Header>';
      $xml .= '<SalesAreaCode>' . $itemInfo['CodZonaVentas'] . '</SalesAreaCode>';
      $xml .= '<AdvisorCode>' . $itemInfo['CodAsesor'] . '</AdvisorCode>';
      $xml .= '<ReasonCode>'.$itemInfo['CodigoMotivoDevolucion'].'</ReasonCode>';
      $xml .= '<Date>' . $itemInfo['FechaDevolucion'] . '</Date>';
      $xml .= '<CustAccount>' . $itemInfo['CuentaCliente'] . '</CustAccount>';


      $InfoXMLDetail = DevolucionesModel::model()->getDescripcionDevoluciones($itemInfo['IdDevolucion']);

      foreach ($InfoXMLDetail as $Itemdetail) {

      $xml .= '<Detail>';
      $xml .= '<VariantCode>' . $Itemdetail['CodigoVariante'] . '</VariantCode>';
      $xml .= '<MeasureUnit>' . $Itemdetail['NombreUnidadMedida'] . '</MeasureUnit>';
      $xml .= '<Quantity>' . $Itemdetail['Cantidad'] . '</Quantity>';
      $xml .= '<Site>' . $itemInfo['CodigoSitio'] . '</Site>';
      $xml .= '</Detail>';
      $xml .= '</Header>';
      }
      $xml .= '</panel>';
      }
      echo $xml;
      exit();

      } */

    public function actionAjaxGetPortafolioProveedor() {

        $session = new CHttpSession;
        $session->open();
        if ($session['portafolioProveedores']) {
            $portafolioProveedores = $session['portafolioProveedores'];
        } else {
            $portafolioProveedores = array();
        }



        $cuentaProveedor = $_POST['cuentaProveedor'];
        $zonaVentas = $_POST['zonaVentas'];
        $cuentaCliente = $_POST['cuentaCliente'];
        $CodigoMotivoDevolucion = $_POST['CodigoMotivoDevolucion'];

        $codigoSitio = $session['codigositio'];
        $codigoAlmacen = $session['Almacen'];
        $contProductosDevoluciones = 0;

        $portafolioProveedor = Consultas::model()->getPortafolioProveedor($zonaVentas, $cuentaProveedor);

        /*echo '<pre>';
        print_r($portafolioProveedor);
        */
        

        $portafolioSinRestriccion = array();

        foreach ($portafolioProveedor as $itemPortafolio) {
            $zonaventas = $zonaVentas;
            $cuentaCliente = $cuentaCliente;
            $codigoVariante = $itemPortafolio['CodigoVariante'];


            $productoMotivos = Consultas::model()->getProductoMotivos($cuentaProveedor, $CodigoMotivoDevolucion, $itemPortafolio['CodigoArticulo']);

            

            if ($productoMotivos) {

                $contProductosDevoluciones++;

                $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProdutoDevolucionesSitio($cuentaCliente, $codigoVariante, $codigoSitio, $zonaventas);
                
                if ($productoAcuerdoComercialProducto) {



                     $itemPortafolio['AcuerdoComercial'] = '1';
                     $itemPortafolio['PrecioVentaAcuerdo'] = $productoAcuerdoComercialProducto['PrecioVenta'];
                     $itemPortafolio['ValorIva'] = $productoAcuerdoComercialProducto['PrecioVenta'] * ($itemPortafolio['PorcentajedeIVA'] / 100);
                     $itemPortafolio['CodigoUnidadMedida'] = $productoAcuerdoComercialProducto['CodigoUnidadMedida'];
                     $itemPortafolio['NombreUnidadMedida'] = $productoAcuerdoComercialProducto['NombreUnidadMedida'];
                     $itemPortafolio['ImagenProducto'] = '0';
                     $itemPortafolio['Cantidad'] = '0';
                } else {

                    $productoAcuerdoComercialGrupo = Consultas::model()->getAcuerdoComercialGrupoDevolucionesSitio($cuentaCliente, $codigoVariante, $codigoSitio, $zonaventas);

                   
                    if ($productoAcuerdoComercialGrupo) {
                        $itemPortafolio['AcuerdoComercial'] = '1';
                        $itemPortafolio['PrecioVentaAcuerdo'] = $productoAcuerdoComercialGrupo['PrecioVenta'];
                        $itemPortafolio['ValorIva'] = $productoAcuerdoComercialGrupo['PrecioVenta'] * ($itemPortafolio['PorcentajedeIVA'] / 100);
                        $itemPortafolio['CodigoUnidadMedida'] = $productoAcuerdoComercialGrupo['CodigoUnidadMedida'];
                        $itemPortafolio['NombreUnidadMedida'] = $productoAcuerdoComercialGrupo['NombreUnidadMedida'];
                        $itemPortafolio['ImagenProducto'] = '0';
                        $itemPortafolio['Cantidad'] = '0';
                    } else {
                        $itemPortafolio['AcuerdoComercial'] = '0';
                        $itemPortafolio['PrecioVentaAcuerdo'] = '0';
                    }
                }
  
                if ($itemPortafolio['PrecioVentaAcuerdo'] != 0) {
                    
                    array_push($portafolioSinRestriccion, $itemPortafolio);
                   
                }
            }
        }
        

        $session['portafolioProveedores'] = $portafolioSinRestriccion;


        if (count($portafolioSinRestriccion) > 0) {
            echo $this->renderPartial('_portafolioProveedores', true);
        } else {

            if ($contProductosDevoluciones == 0) {

               
                
                $portafolioSinRestriccion = array();
                $cont = 1;


                foreach ($portafolioProveedor as $itemPortafolio) {
                    $zonaventas = $zonaVentas;
                    $cuentaCliente = $cuentaCliente;
                    $codigoVariante = $itemPortafolio['CodigoVariante'];
                   
                    $cont++;

                    $productoAcuerdoComercialProducto = Consultas::model()->getAcuerdoComercialProdutoDevoluciones($cuentaCliente, $codigoVariante, $zonaventas);

                    if ($productoAcuerdoComercialProducto) {



                        $itemPortafolio['AcuerdoComercial'] = '1';
                        $itemPortafolio['PrecioVentaAcuerdo'] = $productoAcuerdoComercialProducto['PrecioVenta'];
                        $itemPortafolio['ValorIva'] = $productoAcuerdoComercialProducto['PrecioVenta'] * ($itemPortafolio['PorcentajedeIVA'] / 100);
                        $itemPortafolio['CodigoUnidadMedida'] = $productoAcuerdoComercialProducto['CodigoUnidadMedida'];
                        $itemPortafolio['NombreUnidadMedida'] = $productoAcuerdoComercialProducto['NombreUnidadMedida'];
                        $itemPortafolio['ImagenProducto'] = '0';
                        $itemPortafolio['Cantidad'] = '0';
                    } else {

                        $productoAcuerdoComercialGrupo = Consultas::model()->getAcuerdoComercialGrupoDevoluciones($cuentaCliente, $codigoVariante, $zonaventas);

                        if ($productoAcuerdoComercialGrupo) {
                            $itemPortafolio['AcuerdoComercial'] = '1';
                            $itemPortafolio['PrecioVentaAcuerdo'] = $productoAcuerdoComercialGrupo['PrecioVenta'];
                            $itemPortafolio['ValorIva'] = $productoAcuerdoComercialGrupo['PrecioVenta'] * ($itemPortafolio['PorcentajedeIVA'] / 100);
                            $itemPortafolio['CodigoUnidadMedida'] = $productoAcuerdoComercialGrupo['CodigoUnidadMedida'];
                            $itemPortafolio['NombreUnidadMedida'] = $productoAcuerdoComercialGrupo['NombreUnidadMedida'];
                            $itemPortafolio['ImagenProducto'] = '0';
                            $itemPortafolio['Cantidad'] = '0';
                        } else {
                            $itemPortafolio['AcuerdoComercial'] = '0';
                            $itemPortafolio['PrecioVentaAcuerdo'] = '0';
                        }
                    }

                    
                    if ($itemPortafolio['PrecioVentaAcuerdo'] != 0) {

                        array_push($portafolioSinRestriccion, $itemPortafolio);
                    }
                }
                
                $session['portafolioProveedores'] = $portafolioSinRestriccion;

                if (count($portafolioSinRestriccion) > 0) {
                    echo $this->renderPartial('_portafolioProveedores', true);
                } else {
                    echo '0';
                }
            } else {
                echo '0';
            }
        }
    }

    public function actionAjaxMotivosDevolucion() {

        $CuentaProveedor = $_POST['CuentaProveedor'];
        $data = Consultas::model()->getProveedoresMotivoSelect($CuentaProveedor);

        echo "<option value=''>Seleccione un Motivo</option>";
        foreach ($data as $item) {
            echo "<option value='" . $item['CodigoMotivoDevolucion'] . "' data-proveedor='" . $CuentaProveedor . "' >" . $item['NombreMotivoDevolucion'] . "</option>";
        }
    }

    public function actionAjaxSetProductosDevolucion() {

        $Codigovariante = $_POST['Codigovariante'];
        $Descripcion = $_POST['Descripcion'];
        $UnidadMedida = $_POST['UnidadMedida'];
        $Valor = $_POST['Valor'];
        $Cantidad = $_POST['Cantidad'];

        $session = new CHttpSession;
        $session->open();
        if ($session['portafolioProveedores']) {
            $portafolioProveedores = $session['portafolioProveedores'];
        } else {
            $portafolioProveedores = array();
        }

        $cont = 0;
        foreach ($portafolioProveedores as $item) {
            if (trim($item['CodigoVariante']) == trim($Codigovariante)) {

                $portafolioProveedores[$cont]['Cantidad'] = $Cantidad;
            }
            $cont++;
        }


        $session['portafolioProveedores'] = $portafolioProveedores;
        echo $this->renderPartial('_portafolioProveedores', true);
    }

    public function actionAjaxSetProductosDevolucionAgregados() {

        $this->renderPartial('_portafolioProveedoresAgregados');
    }

    public function actionAjaxGetProductosDevolucionAgregados() {

        $this->renderPartial('_portafolioProveedores');
    }

    public function actionAjaxEliminarDevolucionAgregados() {

        $CodigoVariante = $_POST['CodigoVariante'];


        $session = new CHttpSession;
        $session->open();
        if ($session['portafolioProveedores']) {
            $portafolioProveedores = $session['portafolioProveedores'];
        } else {
            $portafolioProveedores = array();
        }

        $cont = 0;
        foreach ($portafolioProveedores as $item) {
            if ($item['CodigoVariante'] == $CodigoVariante) {
                $portafolioProveedores[$cont]['Cantidad'] = '0';
            }
            $cont++;
        }

        $session['portafolioProveedores'] = $portafolioProveedores;
        //echo $this->renderPartial('_portafolioProveedores', true);
        $this->renderPartial('_portafolioProveedoresAgregados');
    }

    public function actionAjaxLimpiarPorafolioProveedor() {

        $session = new CHttpSession;
        $session->open();
        $portafolioProveedores = array();
        $session['portafolioProveedores'] = array();
        $session['portafolioProveedores'] = $portafolioProveedores;
    }

}
