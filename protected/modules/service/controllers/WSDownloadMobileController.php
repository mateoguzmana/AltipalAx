<?php

class DownloadSalesController extends Controller {

    public function actions(){
        return array(
            'quote'=>array(
                'class'=>'CWebServiceAction',
            ),
        );
         
    }

    /**
     * @return string
     * @param string
     * @soap
     */
    public function getLoginUser($jsonInfo) {
        try {
            $webServiceController = Yii::app()->createController('DownloadMobileController'); 
            return $webServiceController->getLoginUser($jsonInfo);
        } catch (Exeption $ex) {
            return "error getDatabases: " . $ex;
        }
    }

    /**
     * @return string
     * @param string
     * @soap
     */
    public function getPaqueteZonaventas($jsonInfo) {
        try {
            $webServiceController = Yii::app()->createController('DownloadMobileController'); 
            return $webServiceController->getPaqueteZonaventas($jsonInfo);
        } catch (Exeption $ex) {
            return "error getNoSales: " . $ex;
        }
    }

    /**
     * @return string
     * @param string
     * @soap
     */
    public function getSales($idDataBase) {
        try {
            $arraySales = Pedidos::model()->getSales($idDataBase);
            return $this->callConstructorXml($arraySales, "getXMLSales");
        } catch (Exeption $ex) {
            return "error getSales: " . $ex;
        }
    }

    /**
     * @return string
     * @param string
     * @param string
     * @soap
     */
    public function getTypeRead($idDataBase, $documenType) {
        try {
            $arrayTypeRead = VerificacionQr::model()->getTypeRead($idDataBase, $documenType);
            return $this->callConstructorXml($arrayTypeRead, "getXMLTypeRead");
        } catch (Exeption $ex) {
            return "error getTypeRead: " . $ex;
        }
    }

    /**
     * @return string
     * @param string
     * @param string
     * @soap
     */
    public function getLocationSales($idDataBase, $documenType) {
        try {
            $arrayLocationSales = CoordenadasCelular::model()->getLocationSales($idDataBase, $documenType);
            return $this->callConstructorXml($arrayLocationSales, "getXMLLocationSales");
        } catch (Exeption $ex) {
            return "error getLocationSales: " . $ex;
        }
    }

    public function callConstructorXml($arrayXml, $functionXmlConstructor) {
        try {
            $xmlReturn = "";
            /*Yii::import('application.components.XMLConstructor');
            $xmlConstructor = new XMLConstructor();
            $xmlReturn = $xmlConstructor->xmlConstructor($arrayXml, $functionXmlConstructor);*/
            return $xmlReturn;
        } catch (Exeption $ex) {
            return "error callConstructorXml" . $ex;
        }
    }

}
