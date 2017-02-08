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

    public function getZonaVentasGlobales(){
        
        
        $connection = Yii::app()->db;
        $sql = "SELECT * FROM  `zonaventasglobales`";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
        
    }
    
    public function getClientes($zona,$agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) AS clientes FROM `clienteruta` where CodZonaVentas = '$zona'";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
        
    }
    
    
    public function getGrupoVentas($zona,$agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as grupos FROM `zonaventas` zv join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas WHERE zv.CodZonaVentas = '$zona'";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
        
    }
    
     public function getGrupoVentasZona($zona,$agencia){
        
        $connection = new Multiple;
        $sql = "SELECT zv.CodigoGrupoVentas,gr.NombreGrupoVentas  FROM `zonaventas` zv join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas WHERE zv.CodZonaVentas = '$zona'";
        $dataReader = $connection->consultaAgencia($agencia,$sql);
        return $dataReader;
        
    }
    
     public function getPortafolio($grupo,$agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as portafolio FROM `portafolio` where CodigoGrupoVentas = '$grupo'";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
        
    }
    
    public function getJerarquiacomercial($zona){
        
        $connection = Yii::app()->db;
        $sql = "SELECT NombreEmpleado FROM `jerarquiacomercial` WHERE CodigoZonaVentas = '$zona'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;  
        
    }
    
    public function getCartera($zona,$agencia){
      
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as cartera FROM `facturasaldo` where CodigoZonaVentas = '$zona'";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
    }
    
    
    public function getAgencia($agencia){
        
        $connection = Yii::app()->db;
        $sql = "SELECT Nombre FROM `agencia` where CodAgencia = '$agencia'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;    
         
    }
    
    public function getZonaAlmacen($zona,$agencia){
        
        $connection = new Multiple;
        $sql = "SELECT Preventa,Autoventa,Consignacion,VentaDirecta,Focalizado FROM `zonaventaalmacen` where CodZonaVentas = '$zona'";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
        
    }
    
    public function getLinea($agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as linea FROM `acuerdoscomercialesdescuentolinea`";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader; 
        
    }
    
    public function getMultilinea($agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as multilinea FROM `acuerdoscomercialesdescuentomultilinea`";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader; 
        
    }
    
    public function getZonasInactivas(){
        
        $connection = Yii::app()->db;
        $sql = "SELECT COUNT(*) as zonainactivas FROM `zonaventasinactivas`";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;  
        
    }
    
    public function getLocalizacion(){
        
        $connection = Yii::app()->db;
        $sql = "SELECT COUNT(*) as barrios FROM `Localizacion`";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;  
        
    }
    
    public function getPrecioVenta($agencia){
        
       $connection = new Multiple;
        $sql = "SELECT COUNT(*) as precioventa  FROM `acuerdoscomercialesprecioventa`";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;    
        
    }
    
    public function getBancos($agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as bancos FROM `bancos`";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;      
        
    }
    
    public function getCuentaBancarias($agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as cuentasbancarias FROM `cuentasbancarias`";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
        
    }
    
    public function getCiiu($agencia){
        
        $connection = new Multiple;
        $sql = "SELECT COUNT(*) as ciiu FROM `ciiu`";
        $dataReader = $connection->consultaAgenciaRow($agencia,$sql);
        return $dataReader;
        
    }
    public function getCodeAsesor($zonaVentas){
        $connection = Yii::app()->db;
        $sql = "SELECT `CodAsesor` FROM `zonaventas` WHERE `CodZonaVentas`='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }
    
}
