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
            $sql = "SELECT SUM(Presupuestado) AS PrsupuestoCobertura FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'COBERTURA'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalesClientesCoberturaMes() {
        try {            
            $sql = "SELECT COUNT(DISTINCT `CuentaCliente`) AS PedidosMesActual FROM pedidos WHERE MONTH(`FechaPedido`)=MONTH(CURDATE())";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalesClientesCoberturaMesEjecutado() {
        try {
            $sql = "SELECT SUM(Ejecutado) AS EjecutadoCobertura FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'COBERTURA'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalVolumenMes() {
        try {
            $sql = "SELECT SUM(Presupuestado) AS PrsupuestoVolumen FROM `cumplimientoagenciadetalle` WHERE NombreDimension = 'VOLUMEN'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalVolumenEjecutadoMes() {
        try {            
            $sql = "SELECT SUM(Ejecutado) AS EjecutadoVolumen FROM `cumplimientoagenciadetalle` WHERE NombreDimension='VOLUMEN'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalesPedidosDiaMes() {
        try {            
            $sql = "SELECT SUM(ValorPedido) as TotalPedidos FROM `pedidos` WHERE MONTH(`FechaPedido`)=MONTH(CURDATE())";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getEfectividadMes() {
        try {            
            $sql = "SELECT SUM(Presupuestado) as EfectividadPresupuestada,SUM(Ejecutado) as EfectividadTotal FROM `cumplimientoagenciadetalle` WHERE NombreDimension='EFECTIVIDAD'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function PedidosMes($fecha) {
        try {            
            $sql = "SELECT COUNT(IdPedido) AS PedidosMesActual,SUM(ValorPedido) as TotalPedidoMensual FROM pedidos WHERE `FechaPedido`='$fecha'";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function FechaPedidos() {
        try {            
            $sql = "SELECT FechaPedido FROM `pedidos` WHERE MONTH(`FechaPedido`)=MONTH(CURDATE()) GROUP BY FechaPedido";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPedidosMesCanal() {
        try {            
            $sql = "SELECT SUM(p.ValorPedido) AS ValorPedidoCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE MONTH(`FechaPedido`) = MONTH(CURDATE()) GROUP BY p.CodigoCanal";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPedidosValorMes() {
        try {            
            $sql = "SELECT SUM(p.ValorPedido) AS Valor WHERE `FechaPedido`=CURDATE()";
            $connection = new Multiple;
            return $connection->multiConsultaQueryRow($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function Canales() {
        try {            
            $sql = "select distinct(NombreCanal) from jerarquiacomercial jerar INNER JOIN pedidos AS p ON p.CodigoCanal=jerar.CodigoCanal WHERE MONTH(`FechaPedido`) = MONTH(CURDATE()) GROUP BY MONTH(`FechaPedido`)";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function PedidosMesDia() {
        try {            
            $sql = "SELECT p.FechaPedido,p.IdPedido,p.ValorPedido AS ValorPedidoCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE MONTH(`FechaPedido`) = MONTH(CURDATE())";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

}
