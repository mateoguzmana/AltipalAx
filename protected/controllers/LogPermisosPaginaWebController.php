<?php

class LogPermisosPaginaWebController extends Controller {

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

    public function actionIndex() {
        $LogPermissions = LogPermisosPaginaWeb::model()->getAllPermissionsLogs();
        /*echo "<pre>";
        print_r($LogPermissions);
        exit();*/
        $this->render('index', array('LogPermissions' => $LogPermissions));
    }

    public function actionAjaxQueryLogPermissions() {
        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        echo json_encode(LogPermisosPaginaWeb::model()->getQueryLogPermissions($fechaini, $fechafin));
    }

}
