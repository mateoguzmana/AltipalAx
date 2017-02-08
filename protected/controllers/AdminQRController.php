<?php

class AdminQRController extends Controller {

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
        $Agencies = AdminQR::model()->getAllAgencies();
        $this->render('index', array('Agencias' => $Agencies));
    }

    public function actionAjaxQuerySalesGroup() {
        $Agencies = $_POST['Agencies'];        
        $SalesGroup = AdminQR::model()->GetSalesGroupByAgency($Agencies);
        $GroupStatus = AdminQR::model()->GetSalesGroupStatus($Agencies);
        $arr = array('SalesGroup' => $SalesGroup, 'GroupStatus' => $GroupStatus);
        echo json_encode($arr);
        /* echo '<pre>';
          print_r($Agencies);
          die(); */
    }

    public function actionAjaxChangeStatusGroup() {
        $SaleGroup = $_POST['SaleGroup'];
        $Agency = $_POST['Agency'];
        $Select = $_POST['Select'];
        $Usuario = Yii::app()->user->_cedula;
        echo AdminQR::model()->setStatusSaleGroup($SaleGroup, $Agency, $Select, $Usuario);
    }

}
