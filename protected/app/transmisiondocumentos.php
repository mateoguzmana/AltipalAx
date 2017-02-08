<?php

class ReporteZonaVentas extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {
         Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

   public function getDatosPedido($fecha) {
	   
	    $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT COUNT(*) as conteo, SUM(ValorPedido) as Suma FROM `pedidos` WHERE FechaPedido = '$fecha'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;

   }
}
