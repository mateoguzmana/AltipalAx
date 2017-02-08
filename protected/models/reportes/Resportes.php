<?php

class Resportes extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getSumaByCountpedidos() {
        $sql = "SELECT COUNT(IdPedido) num_pedidos, SUM(ValorPedido) total_valor_pedidos ,CodigoCanal FROM pedidos WHERE FechaPedido=CURDATE() GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->multiConsultaQuery($sql);
    }

    public function getSumaByCountrecaudos() {
        $sql = "SELECT COUNT(recicaja.`IdReciboCaja`) AS num_recudos , SUM(recicaja.`ValorAbono`) AS total_recaudos,caja.`CodigoCanal` FROM reciboscajafacturas recicaja join reciboscaja caja on recicaja.`IdReciboCaja`=caja.Id WHERE caja.Fecha=CURDATE() GROUP BY caja.`CodigoCanal`";
        $consulta = new Multiple();
        return $consulta->multiConsultaQuery($sql);
    }

    public function getCountCliente() {
        $sql = "SELECT COUNT(*)AS clientes, CodigoCanal,NombreCanal FROM `clientenuevo` WHERE FechaRegistro=CURDATE() GROUP BY NombreCanal";
        $consulta = new Multiple();
        return $consulta->multiConsultaQuery($sql);
    }

}
