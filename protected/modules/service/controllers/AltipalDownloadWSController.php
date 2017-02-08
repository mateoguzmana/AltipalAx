<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AltipalDownloadWSController extends Controller {

    public function actions() {
        return array(
            'Service' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /*     * **********************************json log********************************************* */

    public function createLog($class, $function, $e) {
        Yii::import('application.extensions.ActivityLog');
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    /*     * ***************************************************************************************** */

    /**
     * @return string
     * @soap
     */
    public function QueryActiveTransactionDocument() {
        return json_encode(AltipalPrivateWS::model()->getActiveTransactionDocument());
    }

    /**
     * @param string
     * @return string
     * @soap
     */
    public function getTransactionAx($documenTipe) {
        return json_encode(AltipalPrivateWS::model()->getTransactionTipeAx($documenTipe));
    }

    /**
     * @param string
     * @param string
     * @param string
     * @return string
     * @soap   
     */
    public function getGenerateXMLOrder($idPedido, $idTipoDoc, $CodAgencia) {
        return json_encode(AltipalPrivateWS::model()->getInfoOrder($idPedido, $idTipoDoc, $CodAgencia));
    }

    /**
     * @return string
     * @soap   
     */
    public function UpdateGlobalSalesZone() {
        return json_encode(AltipalPrivateWS::model()->setUpdateGlobalSalesZone());
    }

    /**
     * @param string $agencia
     * @return string
     * @soap
     */
    public function QuerySalesZonesbyAgency($agencia) {
        return json_encode(ServiceAltipal::model()->getQuerySalesZonesbyAgency($agencia));
    }

}
