<?php

class ReporteVistaLink extends CActiveRecord {
    
    public static function model($className = __CLASS__) {
         Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }
    
    public function getCanales() {

        $connection = Yii::app()->db;
        $sql = "SELECT CodigoCanal,NombreCanal FROM `jerarquiacomercial` WHERE CodigoCanal <>'' GROUP BY CodigoCanal";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
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
    
    /////querys para grafica y reportes de ventas x vendedor /////
    
     public function getCargarGraficaAgenciaVentasXProveedor($agencia,$fecha){
          
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN gruposventas as gr ON p.CodGrupoVenta=gr.CodigoGrupoVentas 
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia  
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor 
        WHERE p.FechaPedido='$fecha' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
    }
    
    public function getCargarGraficaCanalVentasxPorveedor($agencia,$fecha,$canal){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN gruposventas as gr ON p.CodGrupoVenta=gr.CodigoGrupoVentas 
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia  
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor 
        WHERE p.FechaPedido='$fecha' AND p.CodigoCanal = '$canal' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
     
    }
    
     public function getCargarGraficaPorGrupoVentasXProveedor($agencia, $fecha, $grupo){
        
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
    
    
     public function getCargaGraficaZonaVentasProveedorxVentas($agencia,$fecha,$zona){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido
        INNER JOIN zonaventas as zv ON p.CodZonaVentas=zv.CodZonaVentas 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        WHERE p.FechaPedido='$fecha' AND zv.CodZonaVentas = '$zona' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;  
        
        
    }
    
    
    public function getCargaGraficaFechaVentasProveedorxVentas($agencia, $fecha){
        
        $consulta = new Multiple();
        $sql = "  SELECT prov.NombreCuentaProveedor, SUM(dp.TotalPrecioNeto) AS total_ventas_porveedor FROM `pedidos` as p 
        INNER JOIN descripcionpedido as dp ON p.IdPedido=dp.IdPedido 
        INNER JOIN portafolio as po ON p.CodGrupoVenta=po.CodigoGrupoVentas AND dp.CodigoArticulo=po.CodigoArticulo AND dp.CodVariante=po.CodigoVariante 
        INNER JOIN proveedores prov ON po.CuentaProveedor=prov.CodigoCuentaProveedor
        WHERE p.FechaPedido='$fecha' GROUP BY po.CuentaProveedor ORDER BY total_ventas_porveedor DESC LIMIT 12 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader; 
        
    }
    
    ///aqui se hace el query para traer los articulo de la descripcion pedido
    
    public function  getUnidadMedidaArticulos(){
        
        
      $consulta =  new Multiple();
      $sql = "SELECT despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,prov.NombreCuentaProveedor,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
      INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
      INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
      INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
      INNER JOIN proveedores prov ON despe.CuentaProveedor=prov.CodigoCuentaProveedor 
      where pe.FechaPedido = CURDATE()";
      $dataReader = $consulta->multiConsultaQuery($sql);
      return $dataReader;
        
    }
    
    public  function getUnidadConversion($CodArticulo,$UnidadMedida,$Agencia){
     
      $consulta =  new Multiple();
      $sql = "SELECT Factor,CodigoArticulo FROM `unidadesdeconversion` WHERE CodigoArticulo = '$CodArticulo' AND CodigoDesdeUnidad = '$UnidadMedida' AND CodigoHastaUnidad = '001'";
      $dataReader = $consulta->consultaAgencia($Agencia,$sql);
      return $dataReader;
        
    }
    
    public  function getCargarGraficaAgenciaCaja($agencia,$fecha){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
        INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
        INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
        INNER JOIN proveedores prov ON despe.CuentaProveedor=prov.CodigoCuentaProveedor 
        where pe.FechaPedido = '$fecha'";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader; 
         
    }
    
    
    public function  getCargarGraficaCanalCaja($agencia, $fecha,$canal){
       
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
        INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
        INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
        INNER JOIN proveedores prov ON despe.CuentaProveedor=prov.CodigoCuentaProveedor 
        where pe.FechaPedido = '$fecha' AND pe.CodigoCanal = '$canal' ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader; 
       
    }
    
    public function getCargarGraficaGrupoVentasCaja($agencia, $fecha, $grupo){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
        INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
        INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
        INNER JOIN proveedores prov ON despe.CuentaProveedor=prov.CodigoCuentaProveedor 
        where pe.FechaPedido = '$fecha' AND gr.CodigoGrupoVentas = '$grupo'";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;   
        
    }
    
    public function getCargarGraficaZonaVentasCaja($agencia, $fecha, $zona){
       
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
        INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
        INNER JOIN zonaventas as zv ON pe.CodZonaVentas=zv.CodZonaVentas 
        INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
        INNER JOIN proveedores prov ON despe.CuentaProveedor=prov.CodigoCuentaProveedor 
        where pe.FechaPedido = '$fecha' AND zv.CodZonaVentas = '$zona'";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
        
        
    }
    
    public function getCargarGraficaFechaCaja($agencia, $fecha){
        
        $consulta = new Multiple();
        $sql = "SELECT prov.NombreCuentaProveedor,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
        INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
        INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
        INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
        INNER JOIN proveedores prov ON despe.CuentaProveedor=prov.CodigoCuentaProveedor 
        where pe.FechaPedido = '$fecha'";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
        
        
    }
    
    public function getCategoria(){
        
      $consulta =  new Multiple();
      $sql = "SELECT po.CodigoGrupoCategoria,despe.TotalPrecioNeto,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
      INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
      INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
      INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
      INNER JOIN portafolio AS po ON despe.CodigoArticulo = po.CodigoArticulo
      where pe.FechaPedido = CURDATE() GROUP BY despe.CodigoArticulo";
      $dataReader = $consulta->multiConsultaQuery($sql);
      return $dataReader;
    }
    
    public function getCategoriaxAgencia($agencia,$fecha){
        
      $consulta =  new Multiple();
      $sql = "SELECT po.CodigoGrupoCategoria,despe.TotalPrecioNeto,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
      INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
      INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
      INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
      INNER JOIN portafolio AS po ON despe.CodigoArticulo = po.CodigoArticulo
      where pe.FechaPedido = '$fecha' GROUP BY despe.CodigoArticulo";
      $dataReader = $consulta->consultaAgencia($agencia,$sql);
      return $dataReader;   
        
    }
    
    public function getCategoriaxProveedor($agencia,$fecha,$proveedor){
        
      $consulta =  new Multiple();
      $sql = "SELECT po.CodigoGrupoCategoria,despe.TotalPrecioNeto,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
      INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
      INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
      INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
      INNER JOIN portafolio AS po ON despe.CodigoArticulo = po.CodigoArticulo
      where pe.FechaPedido = '$fecha'  AND despe.CuentaProveedor = '$proveedor' GROUP BY despe.CodigoArticulo";
      $dataReader = $consulta->consultaAgencia($agencia,$sql);
      return $dataReader;    
        
    }
    
    
    public function getCategoriaxCategoria($agencia,$fecha,$categoria){
        
      $consulta =  new Multiple();
      $sql = "SELECT po.CodigoGrupoCategoria,despe.TotalPrecioNeto,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
      INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
      INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
      INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
      INNER JOIN portafolio AS po ON despe.CodigoArticulo = po.CodigoArticulo
      where pe.FechaPedido = '$fecha'  AND po.CodigoGrupoCategoria = '$categoria' GROUP BY despe.CodigoArticulo";
      $dataReader = $consulta->consultaAgencia($agencia,$sql);
      return $dataReader;    
        
    }
    
    
     public function getCategoriaxMarca($agencia,$fecha,$marca){
        
      $consulta =  new Multiple();
      echo $sql = "SELECT po.CodigoGrupoCategoria,despe.TotalPrecioNeto,despe.CodigoArticulo,despe.Cantidad,despe.CodigoUnidadMedida,(SELECT CodAgencia FROM agencia LIMIT 1) as Agencia FROM  `pedidos` pe 
      INNER JOIN `descripcionpedido` despe on pe.IdPedido=despe.IdPedido
      INNER JOIN gruposventas as gr ON pe.CodGrupoVenta=gr.CodigoGrupoVentas
      INNER JOIN agencia as ag on gr.CodAgencia=ag.CodAgencia
      INNER JOIN portafolio AS po ON despe.CodigoArticulo = po.CodigoArticulo
      where pe.FechaPedido = '$fecha'  AND po.CodigoMarca = '$marca' GROUP BY despe.CodigoArticulo";
      $dataReader = $consulta->consultaAgencia($agencia,$sql);
      return $dataReader;    
        
    }

    public function getGrupos($CodigoCategoria){
        
      $connection = Yii::app()->db;
      $sql = "SELECT * FROM `jerarquiaarticulos` WHERE Nombre =  '$CodigoCategoria'";
      $command = $connection->createCommand($sql);
      $dataReader = $command->queryAll();
      return $dataReader; 
        
    }
    
    public function getMarcasCategoria($CodigoCategoria,$agencia){
        
      $consulta =  new Multiple();
      $sql = "SELECT DISTINCT CodigoMarca FROM portafolio WHERE CodigoGrupoCategoria = '$CodigoCategoria'";
      $dataReader = $consulta->consultaAgencia($agencia,$sql);
      return $dataReader; 
    }
    
    
    public  function getCategoriaProveedor($agencia,$proveedor){
        
      $consulta =  new Multiple();
      $sql = "SELECT DISTINCT CodigoGrupoCategoria FROM portafolio WHERE CuentaProveedor = '$proveedor'";
      $dataReader = $consulta->consultaAgencia($agencia,$sql);
      return $dataReader; 
        
    }


    public  function getProveedores(){
        
      $connection = Yii::app()->db;
      $sql = "SELECT * FROM `proveedores`";
      $command = $connection->createCommand($sql);
      $dataReader = $command->queryAll();
      return $dataReader;    
        
    }
    
    public function getCargarCategorias(){
        
      $consulta =  new Multiple();
      $sql = "SELECT DISTINCT  CodigoGrupoCategoria FROM `portafolio` GROUP BY CodigoGrupoCategoria";
      $dataReader = $consulta->multiConsultaQuery($sql);
      return $dataReader;
        
    }
    
    public function getMarcas($GrupoCatregoria){
        
      $consulta =  new Multiple();
      $sql = "SELECT DISTINCT  CodigoMarca FROM `portafolio` where CodigoGrupoCategoria = '$GrupoCatregoria' GROUP BY CodigoMarca";
      $dataReader = $consulta->multiConsultaQuery($sql);
      return $dataReader;  
        
    }
    
}

