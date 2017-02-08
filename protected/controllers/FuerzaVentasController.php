<?php

class FuerzaVentasController extends Controller {

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

    public function actionMenuFuerzaVentas() {

        $session = new CHttpSession;
        $session->open();

        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/fuerzaVentas/fuerzavantas.js', CClientScript::POS_END
        );


        if (Yii::app()->user->getState('_idPerfil') != '3' && !$_POST) {
            Yii::app()->user->setState("_zonaVentas", '');
            Yii::app()->user->setState("_codAsesor", '');
            Yii::app()->user->setState("_Agencia", '');
        }

        if ($_POST) {

            $txtZonaVentas = $_POST['zonaVentas'];
            $txtCodigoAsesor = $_POST['hdnCodigoAsesor'];
            $txtAgencia = $_POST['hdnAgencia'];
            
            
            Yii::app()->user->setState("_zonaVentas", $txtZonaVentas);
            Yii::app()->user->setState("_codAsesor", $txtCodigoAsesor);
            Yii::app()->user->setState("_Agencia", $txtAgencia);
          
            $cedulaAsesorZona = Consultas::model()->getCedulaAsesor($txtCodigoAsesor);
            $validarIdentificacion = Consultas::model()->getValidarIdentificacion($cedulaAsesorZona['Cedula']);
         
             
            if ($validarIdentificacion) {
                $session['canalEmpleado'] = $validarIdentificacion['CodigoCanal'];
            }
        }

        $zonaVentas = Yii::app()->user->getState('_zonaVentas');
        $codigoAsesor = Yii::app()->user->getState('_codAsesor');
        $agencia =  Yii::app()->user->getState("_Agencia");
        
        
        if (!$zonaVentas && !$codigoAsesor && !$agencia) {
            $this->render('formZonaVentas');
        } else {
            $clienteSeleccionado = $session['clienteSeleccionado'];
            $diaRuta = $clienteSeleccionado['diaRuta'];
            $MensajesTransferencia = Consultas::model()->getMensaje($zonaVentas);
            $this->render('index', array(
                'diaRuta' => $diaRuta,
                'MensajesTransferencia'=>$MensajesTransferencia
                    
            ));
        }
    }

    public function actionAjaxTerminarRuta() {

        if ($_POST) {
            
            $zona = $_POST['zona'];
            
            $session = new CHttpSession;
            $session->open();

            $clienteSeleccionado = $session['clienteSeleccionado'];

            $codigoAsesor = $clienteSeleccionado['codigoAsesor'];
            $nombreAsesor = $clienteSeleccionado['nombreAsesor'];
            $diaRuta = $clienteSeleccionado['diaRuta'];
            $zonaVentas = $clienteSeleccionado['zonaVentas'];


            $clientesRuta = Consultas::model()->getClientesZonaDiaRuta($diaRuta, $zonaVentas, $codigoAsesor);
            
            $gf;
            $conn = 0;
            foreach ($clientesRuta as $itemClientes) 
            {
                /*consulta pedido donde sea cliente asesor y fecha actual*/
                $pedidos = ClientesRuta::model()->ContarPedidosRutaSinTerminar($itemClientes['CuentaCliente'],$zonaVentas);
               /* echo '<pre>';
                print_r($pedidos);*/
              /*  consultar no ventas para ese cliente, asesor para la fecha actual */
                $noventas = ClientesRuta::model()->ContarNoventasRutaSinTerminar($itemClientes['CuentaCliente'],$zonaVentas);        
                /*echo '<pre>';
                print_r($noventas);*/
               
                if($pedidos['pedidos'] <=0 && $noventas['noventas'] <=0){
                      $conn++;
                   $gf=$gf."Cliente: ". $itemClientes['NombreCliente']." (".$itemClientes['CuentaCliente'].")<br>";
                 }          
            }
         
             

            $numpedidos = FuerzaVentas::model()->getNumPedidos($zona);
            $totalpedidos = FuerzaVentas::model()->getTotalPedidos($zona);
            $numrecibos = FuerzaVentas::model()->getNumRecibos($zona);
            $totalrecibos = FuerzaVentas::model()->getTotalRecibos($zona);
            $asesor = FuerzaVentas::model()->getAsesor($zona);
            
            //echo $conn;
          
            if ($conn > 0) {
              
                 $this->renderPartial('//mensajes/_alertaValidacionRuta',array('gf'=>$gf));
                
            } else {

              $this->renderPartial('//mensajes/_terminaruta', array(
                    'numpedidos' => $numpedidos,
                    'totalpedidos' => $totalpedidos,
                    'numrecibos' => $numrecibos,
                    'totalrecibos' => $totalrecibos,
                    'zona' => $zona,
                    'asesor' => $asesor
                ));
            }
         }
    }

    public function actionAjaxGuardarTerminarRuta() {

        if ($_POST) {

            $zona = $_POST['zona'];
            $asesor = $_POST['asesor'];
            $agencia = Yii::app()->user->_Agencia;


            $destinatario = 'Admin';
            $mensaje = 'Termino Ruta';
            $Fechamensaje = date('Y-m-d');
            $horamensaje = date('H:i:s');
            
            $hora =  date('Y-m-d');
            $fecha =  date('H:i:s');        

            $arraydatos = array(
                'IdDestinatario' => $destinatario,
                'IdRemitente' => $zona,
                'FechaMensaje' => $Fechamensaje,
                'HoraMensaje' => $horamensaje,
                'Mensaje' => $mensaje,
                'Estado'=>'0',
                'CodAsesor' => $asesor
            );
            
            

            
            $model = new MensajeTerminarRuta;
            $model->attributes = $arraydatos;

            if ($model->validate()) {

                $model->save();
                
                /*Clientenuevo::model()->UpdateclienesNuvosTerminarRuta($zona,$agencia);
                Pedidos::model()->UpdatePedidosTerminarRuta($zona,$agencia);
                DevolucionesModel::model()->UpdateDevolucionTerminarRuta($zona,$agencia);
                ConsignacionVendedor::model()->UpdateConsignacionVendedorTerminarRuta($zona,$agencia);
                Transferenciaconsignacion::model()->UpdateTransfConsigTerminarRuta($zona,$agencia);
                Transferenciaautoventa::model()->UpdateTransAuto($zona,$agencia);
                ModelRecibos::model()->UpdateReciboTerminarRuta($zona,$agencia);
                Noventas::model()->UpdateNoventaTerminarRuta($zona,$agencia);*/
                Pedidos::model()->UpdatePedidosTerminarRuta($fecha,$hora,$zona,$agencia);
                Yii::app()->user->logout();
                
            } else {

                print_r($model->getErrors());
            }
        }
    }

}
