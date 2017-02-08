<?php

class GestionnoventasController extends Controller {

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
        $Criteria->condition = "Cedula=$cedula";
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

    public function actionIndex() {
        $session = new CHttpSession;
        $session->open();
        $clienteSeleccionado = $session['clienteSeleccionado'];
        $codigoAsesor = $clienteSeleccionado['codigoAsesor'];
        $nombreAsesor = $clienteSeleccionado['nombreAsesor'];
        $diaRuta = $clienteSeleccionado['diaRuta'];
        $zonaVentas = $clienteSeleccionado['zonaVentas'];
        //echo '<pre>';
        //print_r($clienteSeleccionado);
        //echo count($clienteSeleccionado);
        $clientesRuta = Consultas::model()->getClientesZonaDiaRuta($diaRuta, $zonaVentas, $codigoAsesor);
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/clienterutagestionnoventa/clienteRutaGestionnoVenta.js', CClientScript::POS_END
        );
        $this->render('index', array(
            'clientesRuta' => $clientesRuta,
            'diaRuta' => $diaRuta,
            'zonaVentas' => $zonaVentas,
            'codigoAsesor' => $codigoAsesor
        ));
    }

}
