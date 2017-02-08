<?php

class NoventasController extends Controller {
    
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
        
        $cedula =  Yii::app()->user->_cedula;
        $Criteria = new CDbCriteria();
        $Criteria->condition = "Cedula = $cedula";
        
        $idPerfil = Yii::app()->user->_idPerfil;
        
        $controlador = Yii::app()->controller->getId(); 
        
        $PerfilAcciones = Consultas::model()->getPerfilAcciones($idPerfil, $controlador);        
        
                
         Yii::import('application.extensions.function.Action');         
         $estedAction=new Action();
         
         try {    
           
              $actionAjax = $estedAction->getActions(ucfirst($controlador).'Controller', '');
             
         } catch (Exception $exc) {
             echo $exc->getTraceAsString();
         }

        $acciones = array();
        foreach ($PerfilAcciones as $itemAccion) {
            array_push($acciones, $itemAccion['Descripcion']);
        }

        foreach ($actionAjax as $item){
            $dato= strtolower ('ajax'.$item);
            array_push($acciones, $dato);
        }
        
        /*validacion para no mostrar botones*/
        $arrayAction = Listalink::model()->findPerfil(ucfirst($controlador),$idPerfil);
        $arrayDiferentes= $estedAction->diffActions(ucfirst($controlador).'Controller','',$arrayAction);
        
        $session=new CHttpSession;
        $session->open();
        $session['diferencia']=$arrayDiferentes;  
  
        
        
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

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/noVentas/noventas.js', CClientScript::POS_END
        );



        if ($_POST) {
            
            $session = new CHttpSession;
            $session->open();
             

            $asesor = $_POST['codasesor'];
            $codzona = $_POST['codzona'];
            $cuentacliente = $_POST['cuenta'];
            $txtmotivonoventa = $_POST['txtmotivonoventa'];
            $horanoventa = $_POST['horanoventa'];
            
            
            $arrayNoVentas = array(
                'CodAsesor' => $asesor,
                'CodZonaVentas' => $codzona,
                'CuentaCliente' => $cuentacliente,
                'FechaNoVenta' => date('Y-m-d'),
                'HoraNoVenta' => $horanoventa,
                'CodMotivoNoVenta' => $txtmotivonoventa,
                'IdentificadorEnvio' => '1',
                'EstadoXml' => '',
                'Web' => '1',
                'CodigoCanal'=>$session['canalEmpleado'],
                'Responsable'=>$session['Responsable'],
            );


            $model = new Noventas;
            $model->attributes = $arrayNoVentas;

            if (!$model->validate()) {

                print_r($model->getErrors());
                exit();
            } else {
                $model->save();
            }

            Yii::app()->user->setFlash('succes', '');
 
             
        }


        $clien = Noventas::model()->getClientesNoVentas($cliente);
        $zonaVen = Noventas::model()->getZonaNoVentas($zonaVentas);
        $asesor = Noventas::model()->getNoVentasAsesor($zonaVentas);

        $this->render('index', array(
            'clien' => $clien,
            'zonaVen' => $zonaVen,
            'asesor' => $asesor
        ));
    }
    
    
    public function actionAjaxGestionNoventa($cliente, $zonaVentas){
        
       Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/gestionNoVentas/gestionnoventas.js', CClientScript::POS_END
        );
       
        $session = new CHttpSession;
        $session->open();
        
        $session['lista']='1';
             
       $clienteSeleccionado=$session['clienteSeleccionado'];
       $diaRuta = $clienteSeleccionado['diaRuta'];
       
        $Nit = Consultas::model()->getNitcuentacliente($cliente);
       
        if ($_POST['noRecaudos']) {
            
            $facturasCliente = Consultas::model()->getFacturasClienteZona($Nit[0]['Identificacion']);
            
            $arrayNoRecaudo = array(
                'CodZonaVentas' => $zonaVentas,
                'CodAsesor' => Yii::app()->user->getState('_cedula'),
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
                'ExtraRuta' => '0',
                'Ruta' => $diaRuta,
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
                $this->redirect(array('Noventas/AjaxGestionNoventa', 'cliente' => $cliente, 'zonaVentas' => $zonaVentas));
            } else {
                print_r($model->getErrors());
                exit();
            }
        }

       
        if ($_POST) {
            
            $session = new CHttpSession;
            $session->open();
             

            $asesor = $_POST['codasesor'];
            $codzona = $_POST['codzona'];
            $cuentacliente = $_POST['cuenta'];
            $txtmotivonoventa = $_POST['txtmotivonoventa'];
            $horanoventa = $_POST['horanoventa'];

            $arrayNoVentas = array(
                'CodAsesor' => $asesor,
                'CodZonaVentas' => $codzona,
                'CuentaCliente' => $cuentacliente,
                'FechaNoVenta' => date('Y-m-d'),
                'HoraNoVenta' => $horanoventa,
                'CodMotivoNoVenta' => $txtmotivonoventa,
                'IdentificadorEnvio' => '1',
                'EstadoXml' => '',
                'Web' => '1',
                'CodigoCanal'=>$session['canalEmpleado'],
                'Responsable'=>$session['Responsable'],
            );


            $model = new Noventas;
            $model->attributes = $arrayNoVentas;

            if (!$model->validate()) {

                print_r($model->getErrors());
                exit();
            } else {
                $model->save();
            }

            Yii::app()->user->setFlash('succes', '');
 
             
        }
        
        
        $codagencia = Yii::app()->user->_Agencia;
        $Nit = Consultas::model()->getNitcuentacliente($cliente);

       
        $datosCliente = Consultas::model()->getDatosCliente($cliente, $zonaVentas);
        $motivosgestiondecobros = Motivosgestiondecobros::model()->findAll();
        $noRecaudos = Consultas::model()->getNoRecaudos($zonaVentas, Yii::app()->user->getState('_cedula'), $cliente);
        $tipoPago = Consultas::model()->getTipoPago($zonaVentas);

        $clien = Noventas::model()->getClientesNoVentas($cliente);
        $zonaVen = Noventas::model()->getZonaNoVentas($zonaVentas);
        $asesor = Noventas::model()->getNoVentasAsesor($zonaVentas);

        
        $this->render('formgestionnoventa', array(
            'clien' => $clien,
            'zonaVen' => $zonaVen,
            'asesor' => $asesor,
            'datosCliente'=>$datosCliente,
            'motivosgestiondecobros'=>$motivosgestiondecobros,
            'noRecaudos'=>$noRecaudos,
            'tipoPago'=>$tipoPago
        )); 
        
    }

}
