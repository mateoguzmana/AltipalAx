<?php

class FuerzaVentas extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDbConnection() {
        return self::setConexion();
    }

    public function getNumPedidos($zona) {
        $sql = "SELECT COUNT(IdPedido) as Numpedidos FROM `pedidos` WHERE CodZonaVentas='$zona' AND FechaPedido=CURDATE() ";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTotalPedidos($zona) {
        $sql = "SELECT SUM(ValorPedido)as Totalpedidos FROM `pedidos` WHERE CodZonaVentas='$zona' AND FechaPedido=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getNumRecibos($zona) {
        $sql = "SELECT COUNT(*) as Reciboscaja FROM `reciboscaja` WHERE ZonaVenta='$zona' AND Fecha=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTotalRecibos($zona) {
        $sql = "SELECT SUM(ValorAbono) AS Totalrccaja FROM `reciboscajafacturas` as rccajafactura 
     join reciboscaja as rccaja on rccajafactura.IdReciboCaja=rccaja.Id 
     WHERE rccaja.ZonaVenta = '$zona' AND rccaja.Fecha= CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getAsesor($zona) {
        $sql = "SELECT CodAsesor FROM `zonaventas` where CodZonaVentas='$zona'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

}
