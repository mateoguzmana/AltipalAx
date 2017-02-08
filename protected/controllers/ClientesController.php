<?php

class ClientesController extends Controller {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
                //  'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /* public function accessRules() {


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
      } */

    public function actionRutas() {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clientes/rutas.js', CClientScript::POS_END
        );

        if (Yii::app()->user->getState('_zonaVentas')) {
            $zonaVentas = Yii::app()->user->getState('_zonaVentas');
            $codigoAsesor = Yii::app()->user->getState('_cedula');
        }



        $frecuenciaVisita = Consultas::model()->getFrecuenciaSemana();
        $asesoresComerciales = Consultas::model()->getAsesoresComercialesZonaVentas();



        $this->render('rutas', array('asesoresComerciales' => $asesoresComerciales, 'rutas' => TRUE, 'frecuenciaVisita' => $frecuenciaVisita, 'zonaVentas' => $zonaVentas, 'codigoAsesor' => $codigoAsesor));
    }

    public function actionClientesRutas() {

        $session = new CHttpSession;
        $session->open();


        if ($_POST) {
            if ($_POST['codigoAsesor']) {
                $codigoAsesor = $_POST['codigoAsesor'];
                $nombreAsesor = $_POST['nombreAsesor'];
                $diaRuta = $_POST['numeroRuta'];
                $zonaVentas = $_POST['zonaVentas'];
                $datos['codigoAsesor'] = $codigoAsesor;
                $datos['diaRuta'] = $diaRuta;
                $session['datosCompletarForm'] = $datos;

                $clienteSeleccionado = array(
                    'codigoAsesor' => $codigoAsesor,
                    'nombreAsesor' => $nombreAsesor,
                    'diaRuta' => $diaRuta,
                    'zonaVentas' => $zonaVentas
                );

                $session['clienteSeleccionado'] = $clienteSeleccionado;

                try {
                    Yii::app()->clientScript->registerScriptFile(
                            Yii::app()->baseUrl . '/js/clientes/clientesRuta.js', CClientScript::POS_END
                    );

                    $clientesRuta = Consultas::model()->getClientesZonaDiaRuta($diaRuta, $zonaVentas, $codigoAsesor);
                    $clientesExtraRuta = Consultas::model()->getClientesZonaDiaExtraRuta($diaRuta, $zonaVentas, $codigoAsesor);


                    $this->render('clientesRuta', array('clientesRuta' => $clientesRuta, 'clientesExtraRuta' => $clientesExtraRuta, 'zonaVentas' => $zonaVentas, 'diaRuta' => $diaRuta, 'ClientesDisponible' => $ClientesDisponible));
                } catch (Exception $exc) {
                    echo "No se pudo realizar la consulta";
                }
            }
        } else {

            if ($session['clienteSeleccionado']) {
                $clienteSeleccionado = $session['clienteSeleccionado'];

                $codigoAsesor = $clienteSeleccionado['codigoAsesor'];
                $nombreAsesor = $clienteSeleccionado['nombreAsesor'];
                $diaRuta = $clienteSeleccionado['diaRuta'];
                $zonaVentas = $clienteSeleccionado['zonaVentas'];
                $datos['codigoAsesor'] = $codigoAsesor;
                $datos['diaRuta'] = $diaRuta;
                $session['datosCompletarForm'] = $datos;

                $clienteSeleccionado = array(
                    'codigoAsesor' => $codigoAsesor,
                    'nombreAsesor' => $nombreAsesor,
                    'diaRuta' => $diaRuta,
                    'zonaVentas' => $zonaVentas
                );

                $session['clienteSeleccionado'] = $clienteSeleccionado;

                try {
                    Yii::app()->clientScript->registerScriptFile(
                            Yii::app()->baseUrl . '/js/clientes/clientesRuta.js', CClientScript::POS_END
                    );

                    $clientesRuta = Consultas::model()->getClientesZonaDiaRuta($diaRuta, $zonaVentas, $codigoAsesor);
                    $clientesExtraRuta = Consultas::model()->getClientesZonaDiaExtraRuta($diaRuta, $zonaVentas, $codigoAsesor);

                    $this->render('clientesRuta', array('clientesRuta' => $clientesRuta, 'clientesExtraRuta' => $clientesExtraRuta, 'zonaVentas' => $zonaVentas, 'diaRuta' => $diaRuta, 'ClientesDisponible' => $ClientesDisponible));
                } catch (Exception $exc) {
                    echo "No se pudo realizar la consulta";
                }
            }
        }
    }

    public function actionMenuClientes($cliente, $zonaVentas) {

        $session = new CHttpSession;
        $session->open();

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clientes/menuClientes.js', CClientScript::POS_END
        );



        if (isset(Yii::app()->user->_Agencia)) {


            $codagencia = Yii::app()->user->_Agencia;
        } else {

            $codagencia = Yii::app()->user->getState("_Agencia");
        }


        $Nit = Consultas::model()->getNitcuentacliente($cliente);
        $asesor = Consultas::model()->getAsesorZona($zonaVentas,$codagencia);


        if ($_POST['noRecaudos']) {

            $facturasCliente = Consultas::model()->getFacturasClienteZona($Nit[0]['Identificacion']);
           
            $arrayNoRecaudo = array(
                'CodZonaVentas' => $zonaVentas,
                'CodAsesor' => $asesor['CodAsesor'],
                'CuentaCliente' => $cliente,
                'Fecha' => $_POST['noRecaudos']['Fecha'],
                'FechaProximaVisita' => $_POST['noRecaudos']['FechaProximaVisita'],
                'Hora' => date('H:m:s'),
                'CodMotivoGestion' => $_POST['noRecaudos']['Motivo'],
                'Observacion' => $_POST['noRecaudos']['Observaciones'],
                'Estado' => '0',
                'Web' => '1',
                'CodigoCanal' => $session['canalEmpleado'],
                'Responsable' => $session['Responsable'],
                'ExtraRuta' => $session['extraruta'],
                'Ruta' => $session['clienteSeleccionado']['diaRuta'],
            );
          
            $model = new Norecaudos;
            $model->attributes = $arrayNoRecaudo;

            if ($model->validate()) {
                $model->save();

                foreach ($facturasCliente as $itemFacturas) {
                    $arrayDatosFactura = array(
                        'IdNoCaudo' => $model->Id,
                        'Factura' => $itemFacturas['NumeroFactura'],
                    );
                    $modelNoRecaudoDetalle = new Norecaudosdetalle;
                    $modelNoRecaudoDetalle->attributes = $arrayDatosFactura;
                    if ($modelNoRecaudoDetalle->validate()) {
                        $modelNoRecaudoDetalle->save();
                    }
                }

                $codtipodoc = '4';
                $estado = '0';

                $TransaxConsiga = array(
                    'CodTipoDocumentoActivity' => $codtipodoc,
                    'IdDocumento' => $model->Id,
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

                Yii::app()->user->setFlash('success', " Gestion de No recaudo enviada satisfactoriamente!!!");
                $this->redirect(array('Clientes/menuClientes', 'cliente' => $cliente, 'zonaVentas' => $zonaVentas));
            } else {
                print_r($model->getErrors());
                exit();
            }
        }

       

        $noRecaudos = Consultas::model()->getNoRecaudos($zonaVentas,$asesor['CodAsesor'],$cliente);
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $contador = $session['contador'];


        $sitiosVentas = Consultas::model()->getSitiosTipo($zonaVentas, $codagencia);
        $sitio = Consultas::model()->getSitio($zonaVentas, $codagencia);
        //$sitiosVentasConsignacion = Consultas::model()->getSitiosTipo($zonaVentas);
        $motivosgestiondecobros = Motivosgestiondecobros::model()->findAll();
        $Formaspago = Formaspago::model()->findAll();
        $tipoPago = Consultas::model()->getTipoPago($zonaVentas);
        $recibosvsfacturas = Consultas::model()->getRecibosVsFacturas($cliente);

        //se verifica si hay una encuesta activa
        $codigoAsesor = Yii::app()->user->getState('_cedula');
        $grupoVentas = ClientesRuta::model()->getGrupoVentasAsesor($codigoAsesor);
        $encuestas = ClientesRuta::model()->getEncuestas($sitio['CodigoSitio'], $grupoVentas['CodigoGrupoVentas']);

     
        $tipo = 0;
        if (count($encuestas) > 0) {
            
            $datosEnviar="";
           
            $contencuestas = 0;
            $arrayEncuestas = array();
            foreach ($encuestas as $itemEncuesta) {
               
              

                $tipo+=intval($itemEncuesta['Tipo']);

                if ($itemEncuesta['Tipo'] == '1') {
                
                  
                    if ($itemEncuesta['TipoCliente'] == '1') {
                        
                        $ClienteAsignarEncuesta = ClientesRuta::model()->getAsignarEncusesta($cliente, $itemEncuesta['IdTitulo']);
                    }
                   
                    //echo $ClienteAsignarEncuesta['encuestaasignada'];
                    
                    ////aqui valido si la en cuesta tiene tipo cliente en 1     
                    if ($ClienteAsignarEncuesta['encuestaasignada'] > 0) {
                        
                       
                        ////eentro hacer las 2 validaciones si es frecuencia 1 o 0
                        if ($itemEncuesta['FrecuenciaObligatoria'] == '1') {
                            
                            
                        array_push($arrayEncuestas, $encuestas[$contencuestas]);
                           /* $datosEnviar =array('datosCliente' => $datosCliente,
                                'zonaVentas' => $zonaVentas,
                                'sitiosVentas' => $sitiosVentas,
                                'motivosgestiondecobros' => $motivosgestiondecobros,
                                'noRecaudos' => $noRecaudos,
                                'Formaspago' => $Formaspago,
                                'recibosvsfacturas' => $recibosvsfacturas,
                                'tipoPago' => $tipoPago,
                                'cliente' => $cliente,
                                'contador' => $contador,
                                'Obligatoria' => '1',
                                'Encuestas' => $encuestas,
                                'codigoAsesor' => $codigoAsesor
                            );
                            */
                            
                            
                        } elseif ($itemEncuesta['FrecuenciaObligatoria'] == '0') {

                            $ClienteEncuestado = ClientesRuta::model()->getClienteEncuestado($cliente, $itemEncuesta['IdTitulo']);


                            if ($ClienteEncuestado['clienteencuestado'] == 0) {

                                array_push($arrayEncuestas, $encuestas[$contencuestas]);
                               
                                
                               
                                
                            }else{
                                
                               
                                
                                /*$datosEnviar =array('datosCliente' => $datosCliente,
                                    'zonaVentas' => $zonaVentas,
                                    'sitiosVentas' => $sitiosVentas,
                                    'motivosgestiondecobros' => $motivosgestiondecobros,
                                    'noRecaudos' => $noRecaudos,
                                    'Formaspago' => $Formaspago,
                                    'recibosvsfacturas' => $recibosvsfacturas,
                                    'tipoPago' => $tipoPago,
                                    'cliente' => $cliente,
                                    'contador' => $contador
                                );*/
                                
                            }
                        }
                    } else {
                        
                        

                        ////aqui valido si la en cuesta tiene tipo cliente en 0
                    if($itemEncuesta['TipoCliente'] == '0'){    
                       
                        
                        if ($itemEncuesta['FrecuenciaObligatoria'] == '1') {
                            
                          array_push($arrayEncuestas, $encuestas[$contencuestas]);
                            
                           
                            
                           
                            
                        } elseif ($itemEncuesta['FrecuenciaObligatoria'] == '0') {

                           
                            
                            $ClienteEncuestado = ClientesRuta::model()->getClienteEncuestado($cliente, $itemEncuesta['IdTitulo']);
                            
                          
                            if ($ClienteEncuestado['clienteencuestado'] == 0) {

                                array_push($arrayEncuestas, $encuestas[$contencuestas]);
                                
                                
                                
                            } else {


                                
                               /* $datosEnviar = array('datosCliente' => $datosCliente,
                                    'zonaVentas' => $zonaVentas,
                                    'sitiosVentas' => $sitiosVentas,
                                    'motivosgestiondecobros' => $motivosgestiondecobros,
                                    'noRecaudos' => $noRecaudos,
                                    'Formaspago' => $Formaspago,
                                    'recibosvsfacturas' => $recibosvsfacturas,
                                    'tipoPago' => $tipoPago,
                                    'cliente' => $cliente,
                                    'contador' => $contador,
                                   
                                );*/
                              
                            }
                        }
                        
                      }else{
                        
                       
                          /*$datosEnviar = array('datosCliente' => $datosCliente,
                                    'zonaVentas' => $zonaVentas,
                                    'sitiosVentas' => $sitiosVentas,
                                    'motivosgestiondecobros' => $motivosgestiondecobros,
                                    'noRecaudos' => $noRecaudos,
                                    'Formaspago' => $Formaspago,
                                    'recibosvsfacturas' => $recibosvsfacturas,
                                    'tipoPago' => $tipoPago,
                                    'cliente' => $cliente,
                                    'contador' => $contador
                                );*/
                          
                          
                      }  
                    }
                }
                
                $contencuestas ++;
            }
            
            if(count($arrayEncuestas) > 0)
            {
                 $datosEnviar =array('datosCliente' => $datosCliente,
                                    'zonaVentas' => $zonaVentas,
                                    'sitiosVentas' => $sitiosVentas,
                                    'motivosgestiondecobros' => $motivosgestiondecobros,
                                    'noRecaudos' => $noRecaudos,
                                    'Formaspago' => $Formaspago,
                                    'recibosvsfacturas' => $recibosvsfacturas,
                                    'tipoPago' => $tipoPago,
                                    'cliente' => $cliente,
                                    'contador' => $contador,
                                    'Obligatoria' => '1',
                                    'Encuestas' => $arrayEncuestas,
                                    'codigoAsesor' => $codigoAsesor,
                                    'sitio' => $sitio  
                                );
            }
            else
            {
                $datosEnviar =array('datosCliente' => $datosCliente,
                                    'zonaVentas' => $zonaVentas,
                                    'sitiosVentas' => $sitiosVentas,
                                    'motivosgestiondecobros' => $motivosgestiondecobros,
                                    'noRecaudos' => $noRecaudos,
                                    'Formaspago' => $Formaspago,
                                    'recibosvsfacturas' => $recibosvsfacturas,
                                    'tipoPago' => $tipoPago,
                                    'cliente' => $cliente,
                                    'contador' => $contador,
                                    'codigoAsesor' => $codigoAsesor,
                                    'sitio' => $sitio  
                                );
            }
        
           $this->render('menuClientes', $datosEnviar);
          
        }
        
        if ($tipo == 0) {

            $this->render('menuClientes', array('datosCliente' => $datosCliente,
                'zonaVentas' => $zonaVentas,
                'sitiosVentas' => $sitiosVentas,
                'motivosgestiondecobros' => $motivosgestiondecobros,
                'noRecaudos' => $noRecaudos,
                'Formaspago' => $Formaspago,
                'recibosvsfacturas' => $recibosvsfacturas,
                'tipoPago' => $tipoPago,
                'cliente' => $cliente,
                'contador' => $contador,
                 'sitio' => $sitio  
                    // 'sitiosVentasConsignacion'=>$sitiosVentasConsignacion
            ));
        }
    }

    public function diff_dte($date1, $date2) {
        if (!is_integer($date1))
            $date1 = strtotime($date1);
        if (!is_integer($date2))
            $date2 = strtotime($date2);
        return floor(abs($date1 - $date2) / 60 / 60 / 24);
    }

    public function actionAjaxSetSitioTipoConsignacion() {

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

            $session = new CHttpSession;
            $session->open();

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

    public function actionAjaxSetExtraRuta() {

        $session = new CHttpSession;
        $session->open();
        $session['extraruta'] = $_POST['extraRuta'];
        $session['rutaSeleccionada'] = (int) $_POST['rutaSeleccionada'];
        $session['contador'] = $_POST['Contador'];
        echo '1';
    }

    public function actionEncuestas($cliente, $zonaVentas) {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clientes/encuestas.js', CClientScript::POS_END
        );

        if (Yii::app()->user->getState('_zonaVentas')) {
            $codigoAsesor = Yii::app()->user->getState('_cedula');
            $codagencia = Yii::app()->user->_Agencia;
        }

        $grupoVentas = ClientesRuta::model()->getGrupoVentasAsesor($codigoAsesor);

        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $sitio = Consultas::model()->getSitio($zonaVentas, $codagencia);

        $encuestas = ClientesRuta::model()->getEncuestasOpcionales($sitio['CodigoSitio'], $grupoVentas['CodigoGrupoVentas']);
        

        if (count($encuestas) > 0) {
            $this->render('encuestas', array('Encuestas' => $encuestas, 'datosCliente' => $datosCliente, 'CodAsesor' => $codigoAsesor));
        } else {
            $this->redirect(array('Clientes/menuClientes', 'cliente' => $cliente, 'zonaVentas' => $zonaVentas));
        }
    }

    public function actionAjaxSetEncuesta() {

        $session = new CHttpSession;
        $session->open();

        $idEncuesta = $_POST['idEncuesta'];
        $cuentaCliente = $_POST['cuentaCliente'];
        $zonaVentas = $_POST['zonaVentas'];
        $codAsesor = $_POST['codAsesor'];

        $Encuesta = array(
            'IdEncuesta' => $idEncuesta,
            'cuentaCliente' => $cuentaCliente,
            'zonaVentas' => $zonaVentas,
            'codAsesor' => $codAsesor,
        );

        $session['Encuesta'] = $Encuesta;
    }

    public function actionEncuestar($cliente, $zonaVentas) {

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clientes/encuestas.js', CClientScript::POS_END
        );

        $session = new CHttpSession;
        $session->open();
        $Encuestas = $session['Encuesta'];

        $PreguntaEncuesta = ClientesRuta::model()->getPreguntasEncuesta($idPreguntaSiguiente, $Encuestas['IdEncuesta']);

        $this->render('encuestar', array('PreguntaEncuesta' => $PreguntaEncuesta, 'cuentaCliente' => $cliente, 'zonaVentas' => $zonaVentas));
    }

    public function actionAjaxSetEncuestaPreguntas() {

        $pregunta = $_POST['pregunta'];
        $respuesta = $_POST['respuesta'];
        $siguientePregunta = $_POST['siguientePregunta'];
        $valorrespuesta = $_POST['valorrespuesta'];
        $CuentaCliente = $_POST['CuentaCliente'];
        $zonaVentas = $_POST['ZonaVentas'];
        $foto = $_POST['foto'];

        $session = new CHttpSession;
        $session->open();

        $Encuesta = $session['Encuesta'];

        $encuesta = array(
            'pregunta' => $pregunta,
            'respuesta' => $respuesta,
            'siguientePregunta' => $siguientePregunta,
            'valorrespuesta' => $valorrespuesta,
            'foto' => $foto
        );


        if (count($session['encuestarespondidas']) == 0) {
            $totalEncuesta = array();
            array_push($totalEncuesta, $encuesta);
            $session['encuestarespondidas'] = $totalEncuesta;
        } else {
            $totalEncuesta = $session['encuestarespondidas'];
            array_push($totalEncuesta, $encuesta);
            $session['encuestarespondidas'] = $totalEncuesta;
        }

        //echo '<pre>';
        //print_r($session['encuestarespondidas']);

        $PreguntaEncuesta = ClientesRuta::model()->getPreguntasEncuesta($siguientePregunta, $Encuesta['IdEncuesta']);

        if ($siguientePregunta == 0) {

            echo '0';
        } else {

            $this->renderPartial('encuestar', array('PreguntaEncuesta' => $PreguntaEncuesta, 'cuentaCliente' => $CuentaCliente, 'zonaVentas' => $zonaVentas));
        }
    }

    public function actionAjaxGuardarEncuesta() {

        $session = new CHttpSession;
        $session->open();

        $Encuesta = $session['Encuesta'];
        $DetalleEncuesta = $session['encuestarespondidas'];
        $codagencia = Yii::app()->user->_Agencia;


        $arrayEncuesta = array(
            'IdTituloEncuesta' => $Encuesta['IdEncuesta'],
            'CuentaCliente' => $Encuesta['cuentaCliente'],
            'CodZonaVentas' => $Encuesta['zonaVentas'],
            'CodAsesor' => $Encuesta['codAsesor'],
            'FechaEnvio' => date('Y-m-d'),
            'HoraEnvio' => date('H:i:s'),
            'FechaDispositivo' => date('Y-m-d'),
            'HoraDispositivo' => date('H:i:s'),
            'Consecutivo' => '1',
            'IdentificadorEnvio' => '1'
        );



        $model = new Encuestas;
        $model->attributes = $arrayEncuesta;

        if ($model->validate()) {
            $model->save();

            foreach ($DetalleEncuesta as $itemDetalleEncuesta) {

                if ($itemDetalleEncuesta['valorrespuesta'] != "") {

                    $valorrepuesta = $itemDetalleEncuesta['valorrespuesta'];
                } else {

                    $valorrepuesta = '0';
                }


                $arrayDetalleFactura = array(
                    'IdEncuesta' => $Encuesta['IdEncuesta'],
                    'IdPregunta' => $itemDetalleEncuesta['pregunta'],
                    'IdRespuesta' => $itemDetalleEncuesta['respuesta'],
                    'Texto' => $valorrepuesta,
                    'Foto' => $itemDetalleEncuesta['foto']
                );

                $modelEncuestaDetalle = new Detalleencuestas;
                $modelEncuestaDetalle->attributes = $arrayDetalleFactura;
                if ($modelEncuestaDetalle->validate()) {
                    $modelEncuestaDetalle->save();
                }
            }

            $ArrayclientesEncuestado = array(
                'CuentaCliente' => $Encuesta['cuentaCliente'],
                'IdEncuesta' => $Encuesta['IdEncuesta'],
                'Fecha' => date('Y-m-d'),
                'Hora' => date('H:i:S'),
                'CodZonaVentas' => $Encuesta['zonaVentas'],
                'CodAgencia' => $codagencia,
            );

            $modelClientesEncuestados = new Clientesencuestados();
            $modelClientesEncuestados->attributes = $ArrayclientesEncuestado;
            if ($modelClientesEncuestados->validate()) {
                $modelClientesEncuestados->save();
            }
             unset($session['Encuesta']);
             unset($session['encuestarespondidas']);
        }
    }

    public function actionAjaxGuardandoFotoEncuesta() {

        $session = new CHttpSession;
        $session->open();


        $Encuesta = $session['Encuesta'];

        //$idPregunta = $_POST['pregunta'];
        //$foto = $_POST['foto'];
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        if ($_FILES) {

            if ($_FILES["foto"] != "") {

                $file = $_FILES["foto"];
                $nombre = $file["name"];
                $tipo = $file["type"];
                $ruta_provisional = $file["tmp_name"];
                $size = $file["size"];
                $dimensiones = getimagesize($ruta_provisional);
                $width = $dimensiones[0];
                $height = $dimensiones[1];
                $carpeta = "imagenesEncuestas/";
            }

            $src = $carpeta . $nombre;
            move_uploaded_file($ruta_provisional, $src);

            //ClientesRuta::model()->InsertImagenesEncuestas($Encuesta['IdEncuesta'], $idPregunta, '1', $nombre, $fecha, $hora);
        }
    }
    
    Public function actionAjaxValidatePay()
    {
        try
        {
             if ($_POST) 
             {
                $userNit = $_POST['user'];
                $FacturasSaldo = Consultas::model()->getFacturasSaldoCliente($userNit);
                if (count($FacturasSaldo)>0) 
                {
                    $ContadorFacturasCancelada=0;
                    foreach($FacturasSaldo as $ItemFacturaSaldo)
                    {
                         $NumeroFactura = $ItemFacturaSaldo['NumeroFactura'];
                         $ReciboscajasFactura = Consultas::model()->getRecibosCajaFacturaNumeroFactura($NumeroFactura);
                         if (count($ReciboscajasFactura)>0) 
                         {
                           $ContadorFacturasCancelada++;
                         }
                    }
                    if ((int)$ContadorFacturasCancelada==0) {
                        echo "true";
                    }
                    else
                    {
                        echo "false";
                    }
                }
                else
                {
                     echo "true";
                }
             }
            else 
            {
                echo "false";
            }            
        }
        catch(execption $ex)
        { 
            echo $ex;
        }
    }

    public function actionAjaxGuardandoFotoEncuestaRespuesta() {


        if ($_FILES) {

            if ($_FILES["respuesta"] != "") {

                $file = $_FILES["respuesta"];
                $nombre = $file["name"];
                $tipo = $file["type"];
                $ruta_provisional = $file["tmp_name"];
                $size = $file["size"];
                $dimensiones = getimagesize($ruta_provisional);
                $width = $dimensiones[0];
                $height = $dimensiones[1];
                $carpeta = "imagenesEncuestas/";
            }

            $src = $carpeta . $nombre;
            move_uploaded_file($ruta_provisional, $src);
        }
    }
}
