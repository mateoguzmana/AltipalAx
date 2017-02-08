<?php

class ReporteVentas extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }
    
     public function getAgencias($cedula) {
 
        $connection = Yii::app()->db;
        $sql = "SELECT DISTINCT(ca.CodAgencia) as CodAgencia,agen.Nombre FROM `administrador` a
        Inner JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
        Inner JOIN agencia as agen on ca.CodAgencia=agen.CodAgencia WHERE `Cedula`='$cedula' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }
    
    
    public function getCanales() {

        $connection = Yii::app()->db;
        $sql = "SELECT CodigoCanal,NombreCanal FROM `jerarquiacomercial` WHERE CodigoCanal <>'' GROUP BY CodigoCanal";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }
    
    
    public function getCompradores(){
        
        $connection = new Multiple();
        $sql = " 
        SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente 
        where p.FechaPedido = CURDATE() GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10 ";
        $dataReader = $connection->multiConsultaQuery($sql);
        return $dataReader;
        
        
    }
    
    public  function getProductosVendidos(){
        
        $connection = new Multiple();
        $sql = " SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido 
        where pe.FechaPedido = CURDATE() GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10";
        $dataReader = $connection->multiConsultaQuery($sql);
        return $dataReader; 
        
    }
    
        public  function getVentasProveedor(){
        
        $connection = new Multiple();
        $sql = "  SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        WHERE p.FechaPedido=CURDATE() GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader = $connection->multiConsultaQuery($sql);
        return $dataReader; 
        
    }
    
    public function getCargaGraficaPorZonaVentasCompradores($zona,$fecha){
        
        $consulta = new Multiple();
        $sql = " SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente 
        join zonaventas AS zv on p.CodZonaVentas=zv.CodZonaVentas
        where p.FechaPedido = '$fecha' AND zv.CodZonaVentas = '$zona' GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
        
        
    }

       public function getCargaGraficaPorZonaVentasProductosVendidos($zona,$fecha){
        
        $consulta = new Multiple();
        $sql = "SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido 
        join zonaventas AS zv on pe.CodZonaVentas=zv.CodZonaVentas
        where pe.FechaPedido = '$fecha' AND zv.CodZonaVentas = '$zona'  GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
        
        
    }
    
        public function getCargaGraficaPorZonaVentasProveedorxVentas($zona,$fecha){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido
        INNER JOIN zonaventas as zv ON p.CodZonaVentas=zv.CodZonaVentas 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        WHERE p.FechaPedido='$fecha' AND zv.CodZonaVentas = '$zona' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
        
        
    }
    
    
    public function getCargaGraficaPorFechaCompradores($fecha,$agencia){
        
        $consulta = new Multiple();
        $sql = " SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente 
        where p.FechaPedido = '$fecha' GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
        
        
    }
    
    public function getCargaGraficaPorFechaVentasProductosVendidos($fecha,$agencia){
        
        $consulta = new Multiple();
        $sql = "  SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido 
        where pe.FechaPedido = '$fecha'  GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
        
    }
     
    public function getCargaGraficaPorFechaVentasProveedorxVentas($fecha,$agencia){
        
        $consulta = new Multiple();
        $sql = "  SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        WHERE p.FechaPedido='$fecha' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader; 
        
    }
    
    
    public function getCargarGraficaPorGrupoVentasCompradores($grupo,$fecha,$agencia){
      
        $consulta = new Multiple();
        $sql = "SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente 
        join zonaventas AS zv on p.CodZonaVentas=zv.CodZonaVentas
        join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        where p.FechaPedido = '$fecha' AND gr.CodigoGrupoVentas = '$grupo' GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader; 
        
        
    }
    
    public function getCargarGraficaPorGrupoVentasProductosVendidos($grupo,$fecha,$agencia){
        
        $consulta = new Multiple();
        $sql = "SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido
        join zonaventas AS zv on pe.CodZonaVentas=zv.CodZonaVentas
        join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
        where pe.FechaPedido = '$fecha' AND gr.CodigoGrupoVentas = '$grupo' GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
        
    }
    
    
    public function getCargarGraficaPorGrupoVentasProveedorXVentas($grupo,$fecha,$agencia){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN zonaventas as zv ON p.CodZonaVentas=zv.CodZonaVentas 
        INNER JOIN gruposventas as gr ON zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        WHERE p.FechaPedido='$fecha' AND gr.CodigoGrupoVentas = '$grupo' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;    
        
        
    }
    
    public function getCargarGraficaAgenciaCompradores($agencia,$fecha){
       
        $consulta = new Multiple();
        $sql = "SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente 
        join gruposventas AS gr on p.CodGrupoVenta=gr.CodigoGrupoVentas
      	join agencia as ag on gr.CodAgencia=ag.CodAgencia
        where p.FechaPedido = '$fecha' AND ag.CodAgencia = '$agencia' GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
        
        
    }
    
    
    
     public function getCargarGraficaAgenciaProductosVendidos($agencia,$fecha){
         
        
        $consulta = new Multiple();
        $sql = "SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido
        join gruposventas AS gr on pe.CodGrupoVenta=gr.CodigoGrupoVentas 
        join agencia as ag on gr.CodAgencia=ag.CodAgencia
        where pe.FechaPedido = '$fecha' AND ag.CodAgencia = '$agencia' GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
     }
     
     
     
      public function getCargarGraficaAgenciaVentasXProveedor($agencia,$fecha){
          
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN gruposventas as gr ON p.CodGrupoVenta=gr.CodigoGrupoVentas 
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia  
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor 
        WHERE p.FechaPedido='$fecha' AND ag.CodAgencia = '$agencia' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
      }
      
      public  function getCargarGraficaProveedorCompradores($proveedor,$fecha){
          
        $consulta = new Multiple();
        $sql = " SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente join zonaventas AS zv on p.CodZonaVentas=zv.CodZonaVentas
        join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
        join portafolio AS por on gr.CodigoGrupoVentas=por.CodigoGrupoVentas
        join proveedores AS prove on por.CuentaProveedor=prove.CodigoCuentaProveedor 
        where p.FechaPedido = '$fecha' AND prove.CodigoCuentaProveedor = '$proveedor' GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10  ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
          
      }
      
      
        public  function getCargarGraficaProveedorProductosVendidos($proveedor,$fecha){
          
        $consulta = new Multiple();
        $sql = "SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido join zonaventas AS zv on pe.CodZonaVentas=zv.CodZonaVentas
        join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
        join portafolio AS por on gr.CodigoGrupoVentas=por.CodigoGrupoVentas 
        join proveedores AS prove on por.CuentaProveedor=prove.CodigoCuentaProveedor 
        where pe.FechaPedido = '$fecha' AND prove.CodigoCuentaProveedor = '$proveedor' GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
          
      }
    
       public  function getCargarGraficaProveedorVentasXProveedor($proveedor,$fecha){
          
        $consulta = new Multiple();
        $sql = " SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN zonaventas as zv ON p.CodZonaVentas=zv.CodZonaVentas 
        INNER JOIN gruposventas as gr ON zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
        INNER JOIN zonaventaalmacen as zvalma ON zv.CodZonaVentas=zvalma.CodZonaVentas 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor 
        WHERE p.FechaPedido='$fecha' AND prov.CodigoCuentaProveedor = '$proveedor' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;  
          
      }
      
      public function getGraficaCompradoresxCanal($fecha, $canal, $agencia){
          
        $consulta = new Multiple();
        $sql = "SELECT SUM(ValorPedido) AS totalpedidos,c.NombreCliente FROM `pedidos` AS p 
        join cliente AS c on p.CuentaCliente=c.CuentaCliente 
        join gruposventas AS gr on p.CodGrupoVenta=gr.CodigoGrupoVentas
      	join jerarquiacomercial As jerar on p.CodigoCanal=jerar.CodigoCanal 
        where p.FechaPedido = '$fecha' AND p.CodigoCanal = '$canal' GROUP BY p.`CuentaCliente` ORDER BY totalpedidos DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
          
      }
      
      public function getProductosVendidosXCanal($fecha, $canal, $agencia){
          
        
        $consulta = new Multiple();
        $sql = "SELECT SUM(descp.TotalPrecioNeto) AS totalcantidapedido,descp.NombreArticulo FROM `descripcionpedido` AS descp 
        join pedidos AS pe on descp.IdPedido=pe.IdPedido
        join gruposventas AS gr on pe.CodGrupoVenta=gr.CodigoGrupoVentas 
        join jerarquiacomercial As jerar on pe.CodigoCanal=jerar.CodigoCanal 
        where pe.FechaPedido = '$fecha' AND pe.CodigoCanal = '$canal' GROUP BY descp.CodVariante ORDER BY totalcantidapedido DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
          
      }
      
      public function getGraficaVantasPorProveedorXCanal($fecha, $canal, $agencia){
          
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        INNER JOIN jerarquiacomercial As jerar on p.CodigoCanal=jerar.CodigoCanal
        WHERE p.FechaPedido='$fecha' AND p.CodigoCanal = '$canal' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader; 
          
          
      }
      
}
