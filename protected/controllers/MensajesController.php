<?php

class MensajesController extends Controller {

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

    public function actionEnviarMensajes() {
        Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/js/mensajes/mensajes.js', CClientScript::POS_END
        );
        $this->render('index');
    }

    /*
     * se crea la funcion para mensajes
     */

    public function actionAjaxMensajes() {
        $this->renderPartial('_RMensajes');
    }

    /*
     * 
     * se crea la funcion para la vista  enviar los mensajes 
     * 
     */

    public function actionAjaxVistaEnviarMensajes() {
        $supervisores = Mensajes::model()->getSupervisores();
        $this->renderPartial('_REnviarMensajes', array('supervisores' => $supervisores));
    }

    /*
     * se crea la funcion para cargar los asesores comerciales a sociados al supervisor  
     * @parameters
     * @_POST  supervisor
     */

    public function actionAjaxAsesoresSupervisor() {
        if ($_POST) {
            $supervisor = $_POST['supervisor'];
            if ($supervisor == 1) {
                $Asesores = Mensajes::model()->getAsesoresTodos();
                $this->renderPartial('_Asesores', array(
                    'Asesores' => $Asesores
                        ), false, true);
            } else {
                $Asesores = Mensajes::model()->getAsesoresSupervisor($supervisor);
                $this->renderPartial('_Asesores', array(
                    'Asesores' => $Asesores
                        ), false, true);
            }
        }
    }

    /*
     * se crea la funcion  para el envio de mensaje a los asesores
     * @parameters
     * @Array (Asesores)
     */

    public function actionAjaxEnviarMnesajeaAsesores() {
        if ($_POST) {
            $Asesores = $_POST['asesores'];
            $supervisor = $_POST['supervisor'];
            if ($supervisor == '1') {
                $supervisor = Yii::app()->user->_cedula;
            }
            $mensaje = $_POST['mensaje'];
            foreach ($Asesores as $itemAsesor) {
                $ZonaAgencia = explode(',', $itemAsesor);
                $zonaventa = $ZonaAgencia[0];
                $agencia = $ZonaAgencia[1];
                Mensajes::model()->InsertMensajes($mensaje, $zonaventa, $agencia, $supervisor);
            }
            echo 'OK';
        }
    }

    /*
     * se crea la funcion para ver los mensajes
     */

    public function actionAjaxVerMensajes() {
        $agencia = Mensajes::model()->getAgencia();
        $this->renderPartial('_VerMensajes', array('agencia' => $agencia));
    }

    public function actionAjaxCargarTablaMensajes() {
        $this->renderPartial('_TablaMensajes');
    }

    /*
     * se cargar la tabla de ver mensaje
     * @parameters
     * @GET
     * @GET fecha iniciala
     * @GET fecha final
     * @GET fecha agencia
     */

    public function actionAjaxCargarReporteMensajes() {
        if ($_GET) {
            $fechaini = $_GET['fechaini'];
            $fechafin = $_GET['fechafin'];
            $agencia = $_GET['agencia'];
            $ReporteMensajes = array();
            $Mensajes = Mensajes::model()->getMesajesAgencia($fechaini, $fechafin, $agencia);
            foreach ($Mensajes as $itemMensajes) {
                $estado = $itemMensajes['FechaAutorizacion'] == 1 ? 'Leido' : 'No Leido';
                $Remitente = $itemMensajes['IdRemitente'] == 185 ? 'Supervisor' : $itemMensajes['IdRemitente'];
                $json = array(
                    'IdDestinatario' => $itemMensajes['IdDestinatario'],
                    'NombreZonadeVentas' => $itemMensajes['NombreZonadeVentas'],
                    'IdRemitente' => $Remitente,
                    'FechaMensaje' => $itemMensajes['FechaMensaje'],
                    'HoraMensaje' => $itemMensajes['HoraMensaje'],
                    'Mensaje' => $itemMensajes['Mensaje'],
                    'CodAsesor' => $itemMensajes['CodAsesor'],
                    'Estado' => $estado
                );
                array_push($ReporteMensajes, $json);
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($ReporteMensajes),
                "iTotalDisplayRecords" => count($ReporteMensajes),
                "aaData" => $ReporteMensajes);
            echo json_encode($results);
        }
    }

}
