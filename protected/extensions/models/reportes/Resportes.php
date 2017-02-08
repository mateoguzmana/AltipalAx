<?php

 
class Resportes extends AgenciaActiveRecord
{
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
         
       
        public function getSumaByCountpedidos(){
            
            
            $consulta = new Multiple();
            $sql = "SELECT COUNT(IdPedido) num_pedidos, SUM(ValorPedido) total_valor_pedidos ,CodigoCanal FROM pedidos WHERE FechaPedido = CURDATE() GROUP BY CodigoCanal";
            $dataReader=  $consulta->multiConsultaQuery($sql);
            return $dataReader;
            
        }
        
        public function  getSumaByCountrecaudos(){
            
            $consulta = new Multiple();
            $sql = "SELECT COUNT(recicaja.`IdReciboCaja`) AS num_recudos , SUM(recicaja.`ValorAbono`) AS total_recaudos,caja.`CodigoCanal` FROM reciboscajafacturas recicaja join reciboscaja caja on recicaja.`IdReciboCaja`=caja.Id WHERE caja.Fecha = CURDATE() GROUP BY caja.`CodigoCanal`";
            $dataReader=  $consulta->multiConsultaQuery($sql);
            return $dataReader;       
            
        }
         
        public function getCountCliente(){
            
            $consulta = new Multiple();
            $sql = "SELECT COUNT(*)AS clientes, CodigoCanal,NombreCanal FROM `clientenuevo` WHERE FechaRegistro = CURDATE() GROUP BY NombreCanal";
            $dataReader=  $consulta->multiConsultaQuery($sql);
            return $dataReader;       
            
        }
        
        
}        