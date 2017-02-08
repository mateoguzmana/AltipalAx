<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ZonasVentasGlobales extends AgenciaActiveRecord {

    public function getDbConnection() {
        return self::setConexion();
    }

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getZonaVentasGlobales() {        
        $sql = "SELECT * FROM  `zonaventasglobales`";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getClientes($zona, $agencia) {        
        $sql = "SELECT COUNT(*) AS clientes FROM `clienteruta` where CodZonaVentas='$zona'";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getGrupoVentas($zona, $agencia) {        
        $sql = "SELECT COUNT(*) as grupos FROM `zonaventas` zv join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas WHERE zv.CodZonaVentas = '$zona'";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getGrupoVentasZona($zona, $agencia) {
        $sql = "SELECT zv.CodigoGrupoVentas,gr.NombreGrupoVentas  FROM `zonaventas` zv join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas WHERE zv.CodZonaVentas = '$zona'";
        $connection = new Multiple;
        return $connection->consultaAgencia($agencia, $sql);
    }

    public function getPortafolio($grupo, $agencia) {        
        $sql = "SELECT COUNT(*) as portafolio FROM `portafolio` where CodigoGrupoVentas='$grupo'";
        $connection = new Multiple;
        return  $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getJerarquiacomercial($zona) {        
        $sql = "SELECT NombreEmpleado FROM `jerarquiacomercial` WHERE CodigoZonaVentas='$zona'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getCartera($zona, $agencia) {        
        $sql = "SELECT COUNT(*) as cartera FROM `facturasaldo` where CodigoZonaVentas = '$zona'";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getAgencia($agencia) {        
        $sql = "SELECT Nombre FROM `agencia` where CodAgencia='$agencia'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getZonaAlmacen($zona, $agencia) {        
        $sql = "SELECT Preventa,Autoventa,Consignacion,VentaDirecta,Focalizado FROM `zonaventaalmacen` where CodZonaVentas = '$zona'";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getLinea($agencia) {        
        $sql = "SELECT COUNT(*) as linea FROM `acuerdoscomercialesdescuentolinea`";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getMultilinea($agencia) {        
        $sql = "SELECT COUNT(*) as multilinea FROM `acuerdoscomercialesdescuentomultilinea`";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getZonasInactivas() {        
        $sql = "SELECT COUNT(*) as zonainactivas FROM `zonaventasinactivas`";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getLocalizacion() {
        $sql = "SELECT COUNT(*) as barrios FROM `Localizacion`";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getPrecioVenta($agencia) {        
        $sql = "SELECT COUNT(*) as precioventa  FROM `acuerdoscomercialesprecioventa`";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getBancos($agencia) {        
        $sql = "SELECT COUNT(*) as bancos FROM `bancos`";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getCuentaBancarias($agencia) {        
        $sql = "SELECT COUNT(*) as cuentasbancarias FROM `cuentasbancarias`";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getCiiu($agencia) {        
        $sql = "SELECT COUNT(*) as ciiu FROM `ciiu`";
        $connection = new Multiple;
        return $connection->consultaAgenciaRow($agencia, $sql);
    }

    public function getCodeAsesor($zonaVentas) {        
        $sql = "SELECT `CodAsesor` FROM `zonaventas` WHERE `CodZonaVentas`='$zonaVentas'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
