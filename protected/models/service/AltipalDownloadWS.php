<?php

Yii::import('DatabaseUtilities');
Yii::import('DataUtilities');
Yii::import('application.extensions.ActivityLog');

class AltipalDownloadWS extends DatabaseUtilities {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ********************************** json log ********************************************* */

    public function createLog($class, $function, $e) {        
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    /*     * ***************************************************************************************** */

    public function getActiveTransactionDocument() {
        try {
            return $this->excecuteDatabaseStoredProcedures("`sp_getactiveagencies`();");
        } catch (Exception $e) {
            $this->createLog('AltipalDownloadWS', 'getActiveTransactionDocument', $e);
        }
    }

    public function getTransactionTipeAx() {
        try {
            return ServiceAltipal::model()->ConsultaDatosGlobalDocumento($tipoDocumento);
        } catch (Exception $e) {
            $this->createLog('AltipalDownloadWS', 'getTransactionTipeAx', $e);
        }
    }

    public function getInfoOrder() {
        try {
            return ServiceAltipal::model()->getCountDetallePedidos($idPedido, $CodAgencia);
        } catch (Exception $e) {
            $this->createLog('AltipalDownloadWS', 'getInfoOrder', $e);
        }
    }

}
