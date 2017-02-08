<?php

class ReporteMapas extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }
    
    
    public  function getCoordenadas($agencia,$fechaini,$fechafin){
        
        try {
            
        $connection = new Multiple();
        $sql = "SELECT coo.CodZonaVentas,coo.CuentaCliente,coo.Longitud,coo.Latitud,coo.Fecha,coo.Hora,coo.Origen, cli.`DireccionEntrega` as direccion FROM `coordenadas` coo INNER JOIN `cliente` cli ON coo.`CuentaCliente` = cli.`CuentaCliente` WHERE  coo.Id IN(SELECT DISTINCT (Id) FROM coordenadas WHERE Origen = '1' AND IdDocumento IN(SELECT IdPedido FROM `pedidos` WHERE FechaPedido BETWEEN '$fechaini' AND '$fechafin')) OR Id IN(SELECT DISTINCT (Id) FROM coordenadas WHERE Origen = '4' AND IdDocumento IN(SELECT Id FROM `noventas` WHERE FechaNoVenta BETWEEN '$fechaini' AND '$fechafin'))";
        $dataReader = $connection->consultaAgencia($agencia,$sql);
        return $dataReader; 
            
        } catch (Exception $ex) {
            
            echo $ex->getMessage('Error');
            return false;
        }
        
    }
    
    public  function getCoordenadasGrupoVentas($agencia,$fechaini,$fechafin,$grupoventas){
        
        try {
            
            $connection = new Multiple();
            $sql = "SELECT coo.CodZonaVentas,coo.CuentaCliente,coo.Longitud,coo.Latitud,coo.Fecha,coo.Hora,coo.Origen, cli.`DireccionEntrega` as direccion FROM `coordenadas` coo INNER JOIN `cliente` cli ON coo.`CuentaCliente` = cli.`CuentaCliente` WHERE coo.Id IN(SELECT DISTINCT (Id) FROM coordenadas WHERE Origen = '1' AND IdDocumento IN(SELECT IdPedido FROM `pedidos` WHERE CodZonaVentas IN(SELECT DISTINCT(CodZonaVentas) FROM `zonaventas` WHERE CodigoGrupoVentas = '$grupoventas') AND FechaPedido BETWEEN '$fechaini' AND '$fechafin')) OR Id IN(SELECT DISTINCT (Id) FROM coordenadas WHERE Origen = '4' AND IdDocumento IN(SELECT Id FROM `noventas` WHERE CodZonaVentas IN(SELECT DISTINCT(CodZonaVentas) FROM `zonaventas` WHERE CodigoGrupoVentas = '$grupoventas') AND FechaNoVenta BETWEEN '$fechaini' AND '$fechafin')) ";
            $dataReader = $connection->consultaAgencia($agencia,$sql);
            return $dataReader; 
            
        } catch (Exception $ex) {
            
            echo $ex->getMessage('Error');
            return false; 
        }
        
    }
    
    
    
      public  function getCoordenadasZonaVentas($agencia,$fechaini,$fechafin,$zonaventas){
        
        try {
            
            $connection = new Multiple();
            $sql = "SELECT coo.CodZonaVentas,coo.CuentaCliente,coo.Longitud,coo.Latitud,coo.Fecha,coo.Hora,coo.Origen, cli.`DireccionEntrega` as direccion FROM `coordenadas` coo INNER JOIN `cliente` cli ON coo.`CuentaCliente` = cli.`CuentaCliente` WHERE  coo.Id IN(SELECT DISTINCT (Id) FROM coordenadas WHERE   Origen = '1' AND IdDocumento IN(SELECT IdPedido FROM `pedidos` WHERE CodZonaVentas = '$zonaventas' AND FechaPedido BETWEEN '$fechaini' AND '$fechafin')) OR Id IN(SELECT DISTINCT (Id) FROM coordenadas WHERE Origen = '4' AND IdDocumento IN(SELECT Id FROM `noventas` WHERE CodZonaVentas = '$zonaventas' AND FechaNoVenta BETWEEN '$fechaini' AND '$fechafin'))";
            $dataReader = $connection->consultaAgencia($agencia,$sql);
            return $dataReader; 
            
        } catch (Exception $ex) {
            
            echo $ex->getMessage('Error');
            return false; 
        }
          
    }
    
    
}    
