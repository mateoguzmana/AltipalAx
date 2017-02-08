<?php

class ModelTransferenciaAutoventa extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTransferenciaAutoventa($id) {
        
        $sql = "SELECT 
                    t.IdTransferenciaAutoventa,
                    t.`CodZonaVentas`,
                    (SELECT `NombreZonadeVentas` FROM `zonaventas` WHERE `CodZonaVentas`=t.`CodZonaVentas`) AS NombreZonaVentas,
                    t.`CodZonaVentasTransferencia`,
                    (SELECT `NombreZonadeVentas` FROM `zonaventas` WHERE `CodZonaVentas`=t.`CodZonaVentasTransferencia`) AS NombreZonaVentasTransferir,
                    t.FechaTransferenciaAutoventa,
                    dt.CodVariante,
                    dt.NombreUnidadMedida,
                    dt.Cantidad,
                    dt.Lote
                    FROM `transferenciaautoventa` t
                    INNER JOIN descripciontransferenciaautoventa dt ON t.`IdTransferenciaAutoventa`=dt.IdTransferenciaAutoventa
                    WHERE t.`IdTransferenciaAutoventa`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

}
