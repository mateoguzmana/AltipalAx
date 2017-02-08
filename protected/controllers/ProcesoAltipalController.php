<?php

class ProcesoAltipalController extends Controller {

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

    public function actionMenu() {
        $method = (ProcesoAltipal::model()->getProcessExecutionindex());
        /*echo '<pre>';
        print_r($method);
        exit();*/
        if (($method['Cont'] == 0)&&($method['Status'] == 0)) {
            $Methods = ProcesoAltipal::model()->getAllServiceExcecute();
            $this->render('index', array('Methods' => $Methods));
        } else {
        $this->render('runningProcess');
        }
    }

    public function actionAjaxQuerySelectOptions() {
        $Methods = $_POST['Methods'];
        $Agencies = $_POST['Agencies'];
        $Query = ProcesoAltipal::model()->GetDataSelect($Methods); //Traemos la consulta segun el parametro y el nombre 
        if ($Query != "") {
            $DataSelect = ProcesoAltipal::model()->ExcecuteQuery($Query[0]['QuerySelect'], $Agencies); // Consultamos la informacion del select segun las agencias
            if ($DataSelect != "") {
                $DataSelectJson = array(
                    'SelectName' => $Query[0]['NombreParametro'],
                    'Select' => $DataSelect
                );
                echo json_encode($DataSelectJson);
            } else {
                echo "";
            }
        } else
            echo "";
    }

    public function actionAjaxQuerySelectAgency() {
        $Method = $_POST['Method'];
        echo ProcesoAltipal::model()->GetDataSelectAgency($Method);
    }

    public function actionAjaxInsertControlUpdateProcess() {
        $JsonArr = json_decode($_POST['JsonArr']);
        /* echo '<pre>';
          print_r($JsonArr);
          die(); */
        //echo $JsonArr;
        echo ProcesoAltipal::model()->setControlUpdateProcess($JsonArr);
    }

    public function actionAjaxChangeStatusProcessToRun() {
        $method = $_POST['Process'];
        echo ProcesoAltipal::model()->setStatusProcessToRun($method);
    }

    public function actionAjaxExcecuteAllProcessComplete() {
        echo ProcesoAltipal::model()->setExcecuteAllProcessComplete();
    }

    public function actionAjaxQueryProcessExecution() {
        echo json_encode(ProcesoAltipal::model()->getProcessExecution());
    }

}
