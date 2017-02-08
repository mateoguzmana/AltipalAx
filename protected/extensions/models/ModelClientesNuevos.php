<?php

class ModelClientesNuevos extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getBuscarCiudades() {
        $sql = "SELECT NombreCiudad,CodigoCiudad,CodigoDepartamento,CodigoBarrio FROM `Localizacion` GROUP BY CodigoCiudad,NombreCiudad";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getDepartamento($codCiudad, $codDepartamento) {
        $sql = "SELECT CodigoDepartamento,NombreDepartamento,CodigoCiudad FROM `Localizacion` WHERE `CodigoCiudad`='$codCiudad' AND CodigoDepartamento='$codDepartamento' GROUP BY CodigoDepartamento";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getBarrios($CodDepartamento, $codCiudad) {
        $sql = "SELECT CodigoBarrio,NombreBarrio FROM `Localizacion` where CodigoCiudad='$codCiudad' and CodigoDepartamento='$CodDepartamento'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTipoVia() {
        $sql = "SELECT * FROM `tipovia`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTipoViaComplemento() {
        $sql = "SELECT * FROM `tipoviacomplemento`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getOtrosBarrio($Ciudad, $Departamento) {
        $sql = "SELECT NombreBarrio,CodigoBarrio FROM `Localizacion` where CodigoCiudad='$Ciudad' and CodigoDepartamento='$Departamento' and NombreLocalidad='SIN LOCALIDAD' AND NombreBarrio='BARRIO SIN DEFINIR'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

}
