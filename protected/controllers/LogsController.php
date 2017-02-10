<?php

class LogsController extends Controller {

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

}
