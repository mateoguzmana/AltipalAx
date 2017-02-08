<?php

class Rutero extends AgenciaActiveRecord {

    public function getDbConnection() {
        return self::setConexion();
    }

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getRutero($zona, $agencia) {
        $sql = "SELECT fv.*,cr.CodZonaVentas,cr.CuentaCliente,c.NombreCliente,c.DireccionEntrega,c.Telefono,c.TelefonoMovil,CONCAT (l.NombreBarrio,' - ',l.NombreCiudad) NombreBarrio,(cr.ValorCupo + cr.ValorCupoTemporal) Valorcupo FROM clienteruta cr,cliente c,frecuenciavisita fv,Localizacion l WHERE cr.CuentaCliente = c.CuentaCliente AND cr.NumeroVisita = fv.NumeroVisita AND cr.CodZonaVentas = '" . $zona . "' AND l.CodigoBarrio = c.CodigoBarrio GROUP BY cr.CuentaCliente";
        return Multiple::consultaAgencia($agencia, $sql);
    }

}
