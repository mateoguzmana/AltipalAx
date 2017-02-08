<?php

class LogEjecucionProcesosController extends Controller {

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
        $Methods = LogEjecucionProcesos::model()->getAllExcecutedMethods();
        /*echo "<pre>";
        print_r($Methods);
        exit();*/
        $this->render('index', array('Methods' => $Methods));
    }

    public function actionAjaxQueryLogProcessExcecutionDetail() {
        $headerid = $_POST['id'];
        echo json_encode(LogEjecucionProcesos::model()->getLogProcessExcecutionDetail($headerid));
    }

    public function actionAjaxQueryLogProcessExcecutionDetailParameters() {
        $Methodid = $_POST['id'];
        echo json_encode(LogEjecucionProcesos::model()->getLogProcessExcecutionDetailParameters($Methodid));
    }

    public function actionAjaxQueryLogExcecutionProcess() {
        $fechaini = $_POST['fechaini'];
        $fechafin = $_POST['fechafin'];
        echo json_encode(LogEjecucionProcesos::model()->getQueryLogExcecutionProcess($fechaini, $fechafin));
    }

}
