<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReporteMes
 *
 * @author activity
 */
class ReporteMes extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getTotalCoberturaMes() {

        try {

            $connection = Yii::app()->db;
            $sql = "SELECT SUM(Presupuestado) AS PrsupuestoCobertura FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'COBERTURA'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalesClientesCoberturaMes() {

        try {

            $connection = new Multiple;
            $sql = "SELECT COUNT(DISTINCT `CuentaCliente`) AS PedidosMesActual FROM pedidos WHERE MONTH(`FechaPedido`) = MONTH(CURDATE())";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    
        public function getTotalesClientesCoberturaMesEjecutado() {

        try {

            $connection = Yii::app()->db;
            $sql = "SELECT SUM(Ejecutado) AS EjecutadoCobertura FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'COBERTURA'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalVolumenMes() {

        try {

            $connection = Yii::app()->db;
            $sql = "SELECT SUM(Presupuestado) AS PrsupuestoVolumen FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'VOLUMEN'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    
     public function getTotalVolumenEjecutadoMes() {

        try {

            $connection = Yii::app()->db;
            $sql = "SELECT SUM(Ejecutado) AS EjecutadoVolumen FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'VOLUMEN'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    

    public function getTotalesPedidosDiaMes() {

        try {

            $connection = new Multiple;
            $sql = "SELECT SUM(ValorPedido) as TotalPedidos FROM `pedidos` WHERE MONTH(`FechaPedido`) = MONTH(CURDATE())";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getEfectividadMes() {

        try {

            $connection = Yii::app()->db;
            $sql = "SELECT SUM(Presupuestado) as EfectividadPresupuestada,SUM(Ejecutado) as EfectividadTotal FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'EFECTIVIDAD'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function PedidosMes($fecha) {

        try {

            $connection = new Multiple;
            $sql = "SELECT COUNT(IdPedido) AS PedidosMesActual,SUM(ValorPedido) as TotalPedidoMensual FROM pedidos WHERE `FechaPedido` = '$fecha'";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    public function FechaPedidos() {

        try {

            $connection = new Multiple;
            $sql = "SELECT FechaPedido FROM `pedidos` WHERE MONTH(`FechaPedido`) = MONTH(CURDATE()) GROUP BY FechaPedido";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    public  function getPedidosMesCanal(){
        
        try {

            $connection = new Multiple;
            $sql = "SELECT SUM(p.ValorPedido) AS ValorPedidoCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE MONTH(`FechaPedido`) = MONTH(CURDATE()) GROUP BY p.CodigoCanal";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
        
    }
    
    
    public  function getPedidosValorMes(){
        
        try {

            $connection = new Multiple;
            $sql = "SELECT SUM(p.ValorPedido) AS Valor WHERE `FechaPedido` = CURDATE()";
            $dataReader = $connection->multiConsultaQueryRow($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
        
    }
    
    
     public function Canales() {

        try {

            $connection = new Multiple;
            $sql = "select distinct(NombreCanal) from jerarquiacomercial jerar INNER JOIN pedidos AS p ON p.CodigoCanal=jerar.CodigoCanal WHERE MONTH(`FechaPedido`) = MONTH(CURDATE()) GROUP BY MONTH(`FechaPedido`)";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    public function PedidosMesDia(){
        
       try {

            $connection = new Multiple;
            $sql = "SELECT p.FechaPedido,p.IdPedido,p.ValorPedido AS ValorPedidoCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE MONTH(`FechaPedido`) = MONTH(CURDATE())";
            $dataReader = $connection->multiConsultaQuery($sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        } 
        
    }
    
    

}
