<?php

class AprovacionDocumentos extends CActiveRecord {

    private $gruposVentas;

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getPedidosDescuentosAdminCartera() {

        $consulta = new Multiple();
        $this->gruposVentas = $consulta->getGrupoVentas();

        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);

        if ($cadena != "") {
        $sql = "SELECT 
                am.Agencia,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                ap.QuienAutorizaDscto,
                ap.EstadoRevisadoProveedor,                
                ap.EstadoRevisadoAltipal,
		dp.TotalPrecioNeto

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                
                WHERE am.Agencia<>'' AND dp.DsctoEspecial > '0' AND p.Estado = '3' AND ($cadena)";


        $dataReader = $consulta->multiConsulta($sql);
        }else{
            
            $dataReader = "";
        }

        return $dataReader;
    }

    public function getPedidosDescuentos($tipoUsuario, $proveedor = '') {

        $consulta = new Multiple();
        $this->gruposVentas = $consulta->getGrupoVentas();
        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);

        if ($cadena != "") {

            if ($tipoUsuario == 1) {

                $sql = "SELECT 
                am.Agencia,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                ap.QuienAutorizaDscto,
                ap.EstadoRevisadoProveedor,                
                ap.EstadoRevisadoAltipal,
		dp.TotalPrecioNeto

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                
                WHERE  am.Agencia<>'' AND ($cadena) AND dp.DsctoEspecial<> '' AND dp.DsctoEspecialAltipal >'0' AND  p.Estado = '1'
                ";
            } else {

                $sql = "SELECT 
                am.Agencia,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                ap.QuienAutorizaDscto,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal,
		TotalPrecioNeto

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                
                WHERE  am.Agencia<>'' AND dp.DsctoEspecial<>'' AND ($cadena) AND dp.DsctoEspecialProveedor >'0' AND dp.CuentaProveedor='$proveedor' AND  p.Estado = '1'
                ";
            }


            $dataReader = $consulta->multiConsultaQuery($sql);
        }else{
            
          $dataReader = "";  
        }

        return $dataReader;
    }

    public function getPedidosGrupoVentas($agencia, $grupoVentas, $tipoUsuario, $proveedor = '') {

        $consulta = new Multiple();

        if ($tipoUsuario == 1) {

            $sql = "SELECT 
                am.Agencia,
                ag.Nombre AS nombreAgencia,
                p.CodZonaVentas,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                c.NombreCliente,
                p.FechaPedido,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal,
                p.CodAsesor,
                p.CuentaCliente,
		SUM(dp.TotalPrecioNeto) AS TotalPrecioNeto,
                COUNT(p.`IdPedido`) AS pe
                

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT Join cliente c ON p.CuentaCliente=c.CuentaCliente
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                
                WHERE  am.Agencia<>'' AND dp.DsctoEspecial >'0'AND p.`CodGrupoVenta`='$grupoVentas' AND dp.DsctoEspecialAltipal >'0' AND p.Estado = '1' GROUP BY  p.`IdPedido`";
        } else {

            $sql = "SELECT 
                am.Agencia,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                c.NombreCliente,
                p.FechaPedido,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal,
		SUM(dp.TotalPrecioNeto) AS TotalPrecioNeto,
                COUNT(p.`IdPedido`) AS pe

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT Join cliente c ON p.CuentaCliente=c.CuentaCliente
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                
                WHERE  am.Agencia<>'' AND dp.DsctoEspecial<>''AND p.`CodGrupoVenta`='$grupoVentas'  AND dp.DsctoEspecialProveedor >'0' AND dp.CuentaProveedor='$proveedor' AND p.Estado = '1' GROUP BY  p.`IdPedido`";
        }
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosGrupoVentasAdminCartera($agencia, $grupoVentas) {

        $consulta = new Multiple();

        $sql = "SELECT 
                am.Agencia,
                ag.Nombre AS nombreAgencia,
                p.CodZonaVentas,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                c.NombreCliente,
                p.FechaPedido,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal,
                ap.QuienAutorizaDscto,
                p.CodAsesor,
                p.CuentaCliente,
		SUM(dp.TotalPrecioNeto) AS TotalPrecioNeto,
                COUNT(p.`IdPedido`) AS pe
                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT Join cliente c ON p.CuentaCliente=c.CuentaCliente
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                
                WHERE  am.Agencia<>'' AND dp.DsctoEspecial >'0' AND p.Estado = '3' AND p.`CodGrupoVenta`='$grupoVentas' GROUP BY  p.`IdPedido`";

        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosGrupoVentasDetalle($agencia, $grupoVentas, $tipoUsuario, $idPedido, $proveedor = '') {

        $consulta = new Multiple();

        if ($tipoUsuario == '1') {


            $sql = "SELECT 
                am.Agencia,
                p.CodZonaVentas,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                p.TotalSubtotalBaseIva,
                p.TotalValorDescuento,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                c.NombreCliente,
                c.CuentaCliente,
                p.FechaPedido,
                p.ActividadEspecial,
                ce.Nombre AS TipoNegocio,
                p.Observacion,
                dp.Id AS IdDescripcionPedido,
                dp.CodVariante,
                dp.NombreArticulo,
                dp.Cantidad,
                dp.CodigoUnidadMedida,
                dp.TotalPrecioNeto,
                dp.DsctoEspecialProveedor,
                dp.DsctoEspecialAltipal,
                dp.DsctoEspecial,
                dp.ValorDsctoEspecial,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal ,
                prov.NombreCuentaProveedor
                

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT Join cliente c ON p.CuentaCliente=c.CuentaCliente
                LEFT JOIN cadenaempresa ce on c.CodigoCadenaEmpresa=ce.CodigoCadenaEmpresa
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                LEFT JOIN proveedores prov ON dp.CuentaProveedor=prov.CodigoCuentaProveedor
                
                WHERE  am.Agencia<>'' AND dp.DsctoEspecial<>'' AND dp.DsctoEspecialAltipal >'0' AND  p.Estado = '1'  AND p.`CodGrupoVenta`='$grupoVentas' AND p.IdPedido='$idPedido'";
        } else {


            $sql = "SELECT 
                am.Agencia,
                p.CodZonaVentas,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                p.TotalSubtotalBaseIva,
                p.TotalValorDescuento,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                c.NombreCliente,
                c.CuentaCliente,
                p.FechaPedido,
                p.ActividadEspecial,
                ce.Nombre AS TipoNegocio,
                p.Observacion,
                dp.Id AS IdDescripcionPedido,
                dp.CodVariante,
                dp.NombreArticulo,
                dp.Cantidad,
                dp.CodigoUnidadMedida,
                dp.TotalPrecioNeto,
                dp.DsctoEspecialProveedor,
                dp.DsctoEspecialAltipal,
                dp.DsctoEspecial,
                dp.ValorDsctoEspecial,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal,
                prov.NombreCuentaProveedor,
                dp.CuentaProveedor

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT Join cliente c ON p.CuentaCliente=c.CuentaCliente
                LEFT JOIN cadenaempresa ce on c.CodigoCadenaEmpresa=ce.CodigoCadenaEmpresa
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                LEFT JOIN proveedores prov ON dp.CuentaProveedor=prov.CodigoCuentaProveedor
                
                WHERE  am.Agencia<>'' AND dp.DsctoEspecial<>''AND p.`CodGrupoVenta`='$grupoVentas' AND dp.DsctoEspecialProveedor >'0' AND p.IdPedido='$idPedido' AND dp.CuentaProveedor='$proveedor' AND p.Estado = '1' ";
        }


        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosGrupoVentasDetalleAdminCartera($agencia, $grupoVentas, $idPedido) {

        $consulta = new Multiple();

        $sql = "SELECT 
                am.Agencia,
                p.CodZonaVentas,
                ag.Nombre AS nombreAgencia,
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                p.`CodigoSitio`,
                p.TotalSubtotalBaseIva,
                p.TotalValorDescuento,
                s.Nombre AS nombreSitio,
                am.Nombre as nombreAsesor,
                c.NombreCliente,
                c.CuentaCliente,
                p.FechaPedido,
                p.ActividadEspecial,
                ce.Nombre AS TipoNegocio,
                p.Observacion,
                dp.Id AS IdDescripcionPedido,
                dp.CodVariante,
                dp.NombreArticulo,
                dp.Cantidad,
                dp.CodigoUnidadMedida,
                dp.TotalPrecioNeto,
                dp.DsctoEspecialProveedor,
                dp.DsctoEspecialAltipal,
                dp.DsctoEspecial,
                dp.ValorDsctoEspecial,
                ap.EstadoRevisadoProveedor,
                ap.EstadoRevisadoAltipal ,
                prov.NombreCuentaProveedor      

                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                LEFT JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
                LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
                LEFT Join cliente c ON p.CuentaCliente=c.CuentaCliente
                LEFT JOIN cadenaempresa ce on c.CodigoCadenaEmpresa=ce.CodigoCadenaEmpresa
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                LEFT JOIN proveedores prov ON dp.CuentaProveedor=prov.CodigoCuentaProveedor
                
                WHERE  am.Agencia<>'' AND ((dp.DsctoEspecial<>'' AND p.Estado = '3'))   AND p.`CodGrupoVenta`='$grupoVentas' AND p.IdPedido='$idPedido'";


        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function insertAutorizacionPedido($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro) {

        $consulta = new Multiple();

        $aprovacion = $this->consultaAprovacionPedido($idPedido, $idDescripcionPedido, $agencia);

        if ($aprovacion > 0) {


            if ($tipoUsuario == '1') {
                $sql = "UPDATE `aprovacionpedido`
                       SET               
                       `EstadoRevisadoAltipal`='1',  
                       `MotivoRechazoAltipal`='$motivo',                     
                       `EstadoRechazoAltipal`='$estadoRechazo',                    
                       `UsuarioAutorizoDsctoAltipal`='$cedulaUsuario',                    
                       `NombreAutorizoDsctoAltipal`='$nombreusuario',                      
                       `FechaAutorizaAltipal`='$fechaRegistro',                       
                       `HoraAutorizaAltipal`='$horaRegistro' 
                           
                        WHERE IdPedido='$idPedido' AND IdDetallePedido='$idDescripcionPedido'
                        
                      ";
            } else {

                $sql = "UPDATE `aprovacionpedido`
                       SET                                          
                       `EstadoRevisadoProveedor`='1',                      
                       `MotivoRechazoProveedor`='$motivo',                  
                       `EstadoRechazoProveedor`='$estadoRechazo',                  
                       `UsuarioAutorizoDsctoProveedor`='$cedulaUsuario',                      
                       `NombreAutorizoDsctoProveedor`='$nombreusuario',                 
                       `FechaAutorizaProveedor`='$fechaRegistro',                      
                       `HoraAutorizaProveedor`='$horaRegistro'
                       
                        WHERE IdPedido='$idPedido' AND IdDetallePedido='$idDescripcionPedido'
                          
                        ";
            }
        } else {

            if ($tipoUsuario == '1') {
                $sql = "INSERT 
                       INTO `aprovacionpedido`
                       (`IdPedido`, 
                       `IdDetallePedido`,                       
                       `QuienAutorizaDscto`,                       
                       `EstadoRevisadoAltipal`,  
                       `MotivoRechazoAltipal`,                     
                       `EstadoRechazoAltipal`,                    
                       `UsuarioAutorizoDsctoAltipal`,                    
                       `NombreAutorizoDsctoAltipal`,                      
                       `FechaAutorizaAltipal`,                       
                       `HoraAutorizaAltipal`
                      
                       ) 
                       VALUES (
                       '$idPedido',
                       '$idDescripcionPedido', 
                       '$QuienAutorizaDscto',
                       '1', 
                       '$motivo',
                       '$estadoRechazo',   
                       '$cedulaUsuario',    
                       '$nombreusuario',
                       '$fechaRegistro',
                       '$horaRegistro'  
                        )";
            } else {

                $sql = "INSERT 
                       INTO `aprovacionpedido`
                       (`IdPedido`,
                       `IdDetallePedido`, 
                       `QuienAutorizaDscto`,                   
                       `EstadoRevisadoProveedor`,                      
                       `MotivoRechazoProveedor`,                  
                       `EstadoRechazoProveedor`,                  
                       `UsuarioAutorizoDsctoProveedor`,                      
                       `NombreAutorizoDsctoProveedor`,                 
                       `FechaAutorizaProveedor`,                      
                       `HoraAutorizaProveedor`
                       
                       ) VALUES (
                       '$idPedido',
                       '$idDescripcionPedido', 
                       '$QuienAutorizaDscto',
                       '1', 
                       '$motivo',
                       '$estadoRechazo',   
                       '$cedulaUsuario',    
                       '$nombreusuario',
                       '$fechaRegistro',
                       '$horaRegistro'  
                        )";
            }
        }

        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function insertAutorizacionPedidoAdminCartera($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro) {

        $consulta = new Multiple();

        $aprovacion = $this->consultaAprovacionPedido($idPedido, $idDescripcionPedido, $agencia);

        if ($aprovacion > 0) {

            $sql = "UPDATE `aprovacionpedido`
                       SET               
                       `EstadoRevisadoAltipal`='1',  
                       `MotivoRechazoAltipal`='$motivo',                     
                       `EstadoRechazoAltipal`='$estadoRechazo',                    
                       `UsuarioAutorizoDsctoAltipal`='$cedulaUsuario',                    
                       `NombreAutorizoDsctoAltipal`='$nombreusuario',                      
                       `FechaAutorizaAltipal`='$fechaRegistro',                       
                       `HoraAutorizaAltipal`='$horaRegistro',
                       `EstadoRevisadoProveedor`='1',                      
                       `MotivoRechazoProveedor`='$motivo',                  
                       `EstadoRechazoProveedor`='$estadoRechazo',                  
                       `UsuarioAutorizoDsctoProveedor`='$cedulaUsuario',                      
                       `NombreAutorizoDsctoProveedor`='$nombreusuario',                 
                       `FechaAutorizaProveedor`='$fechaRegistro',                      
                       `HoraAutorizaProveedor`='$horaRegistro'   
                           
                        WHERE IdPedido='$idPedido' AND IdDetallePedido='$idDescripcionPedido'
                        
                      ";
        } else {


            $sql = "INSERT 
                       INTO `aprovacionpedido`
                       (`IdPedido`, 
                       `IdDetallePedido`,   
                       `AutorizaDscto`,
                       `QuienAutorizaDscto`,                       
                       `EstadoRevisadoAltipal`,  
                       `MotivoRechazoAltipal`,                     
                       `EstadoRechazoAltipal`,                    
                       `UsuarioAutorizoDsctoAltipal`,                    
                       `NombreAutorizoDsctoAltipal`,                      
                       `FechaAutorizaAltipal`,                       
                       `HoraAutorizaAltipal`
                      
                       ) 
                       VALUES (
                       '$idPedido',
                       '$idDescripcionPedido',
                       'CARTERA',
                       '$QuienAutorizaDscto',
                       '1', 
                       '$motivo',
                       '$estadoRechazo',   
                       '$cedulaUsuario',    
                       '$nombreusuario',
                       '$fechaRegistro',
                       '$horaRegistro'  
                        )";
        }

        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function pedidodosaprovados($idPedido, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM  `descripcionpedido` descripPedi join aprovacionpedido aproPedi on descripPedi.Id=aproPedi.IdDetallePedido where descripPedi.IdPedido = '$idPedido'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function InsertTransAxDescuentoEspecial($idPedido, $agencia) {

        $consulta = new Multiple();
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('1','$idPedido','$agencia','0')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function UpdateEstadoPedidoDesEspecial($idPedido, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `pedidos` SET  `Estado`= '0', AutorizaDescuentoEspecial = '1' WHERE `IdPedido` = '$idPedido'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function UpdateEstadoPedidoDesEspecialAdminCartera($idPedido, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `pedidos` SET  `Estado`= '0', AutorizaDescuentoEspecial = '1' WHERE `IdPedido` = '$idPedido'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateEstadoPedidoActividadEspecial($idPedido, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `pedidos` SET `Estado`= '1' WHERE `IdPedido` = '$idPedido'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getNotasCredito($conceptos, $tipoUsuario, $proveedor = '') {

        $consulta = new Multiple();
        $this->gruposVentas = $consulta->getGrupoVentas();
        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);
        $cadena = "(" . $cadena . ")";

        if ($tipoUsuario == 1) {

            $cont = 1;
            $sql = "SELECT 
                zv.CodZonaVentas,
                gv.NombreGrupoVentas,
                gv.CodAgencia,
                ag.Nombre,
                nc.Valor,
                gv.CodigoGrupoVentas,
                SUM(nc.Valor) as TotalNota,
                COUNT(*) as CantidadNotas 

                FROM `notascredito` nc
                LEFT JOIN zonaventas zv ON nc. CodZonaVentas=zv.CodZonaVentas
                INNER JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
                LEFT JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia

                WHERE (nc.Autoriza = '0') AND (nc.Estado = '1') AND nc.Concepto IN (";
            foreach ($conceptos as $itemzona) {
                if ($cont == count($conceptos)) {

                    $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "') ";
                } else {
                    $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "', ";
                }
                $cont++;
            }
            $sql.="GROUP BY gv.CodigoGrupoVentas";
        } else {

            //echo  'entre'; 

            $cont = 1;
            $sql = "SELECT 
                zv.CodZonaVentas,
                gv.NombreGrupoVentas,
                gv.CodAgencia,
                ag.Nombre,
                nc.Valor,
                gv.CodigoGrupoVentas,
                SUM(nc.Valor) as TotalNota,
                COUNT(*) as CantidadNotas 

                FROM `notascredito` nc
                LEFT JOIN  zonaventas zv ON nc. CodZonaVentas=zv.CodZonaVentas
                LEFT JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
                LEFT JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia

                WHERE $cadena AND (nc.Autoriza = '0') AND (nc.Estado = '1') AND (Fabricante = '$proveedor') AND nc.Concepto IN (";
            foreach ($conceptos as $itemzona) {
                if ($cont == count($conceptos)) {

                    $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "') ";
                } else {
                    $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "', ";
                }
                $cont++;
            }
            $sql.="GROUP BY gv.CodigoGrupoVentas";
        }
        // print_r($sql);
        // die();

        $dataReader = $consulta->multiConsultaQuery($sql);

        // print_r($dataReader);
        //  die();

        return $dataReader;
    }

    public function getNotasCreditoAdminCartera($conceptos) {


        $consulta = new Multiple();
        $this->gruposVentas = $consulta->getGrupoVentas();

        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);


        $cont = 1;
        $sql = "SELECT 
                zv.CodZonaVentas,
                gv.NombreGrupoVentas,
                gv.CodAgencia,
                ag.Nombre,
                nc.Valor,
                gv.CodigoGrupoVentas,
                SUM(nc.Valor) as TotalNota,
                COUNT(*) as CantidadNotas 

                FROM `notascredito` nc
                LEFT JOIN  zonaventas zv ON nc. CodZonaVentas=zv.CodZonaVentas
                LEFT JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
                LEFT JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia

                WHERE ($cadena) AND nc.Autoriza = '0' AND nc.Estado = '3' AND nc.Concepto IN (";
        foreach ($conceptos as $itemzona) {

            if ($cont == count($conceptos)) {
                $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "') ";
            } else {
                $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "', ";
            }
            $cont++;
        }
        $sql.="GROUP BY gv.CodigoGrupoVentas";

        $dataReader = $consulta->multiConsulta($sql);

        return $dataReader;
    }

    public function conceptosAdministradorNotasCredito($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT CodigoConceptoNotasCredito FROM `configuracionconceptosnotascredito` where IdAdministrador ='$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDetalleFotosNotasCreditoDhas($id) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `notascreditofoto` WHERE IdNotaCredito = '$id'";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getProveedorAdministrador($cedulaUsuario) {

        $connection = Yii::app()->db;
        $sql = "SELECT 
                cad.CodigoProveedor
                FROM `administrador` a 
                INNER JOIN configuracionaprobaciondocumentos cad ON a.Id=cad.IdAdministrador
                WHERE a.Cedula='$cedulaUsuario'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        return $dataReader;
    }

    private function consultaAprovacionPedido($idPedido, $idDetallePedido, $agencia) {
        $consulta = new Multiple();
        $sql = "SELECT 
                COUNT(*) as total
                FROM `aprovacionpedido` WHERE `IdPedido`='$idPedido' and `IdDetallePedido`='$idDetallePedido'";

        $dataReader = $consulta->consultaAgencia($agencia, $sql);

        $total = $dataReader[0]['total'];
        return $total;
    }

    public function getTotalTransConsigSinAprovar() {

        $consulta = new Multiple();
        $this->gruposVentas = $consulta->getGrupoVentas();

        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);

        $sql = "SELECT 
                COUNT(trans.IdTransferencia) as transferencias
                FROM `transferenciaconsignacion` trans
                
                LEFT JOIN zonaventas zv ON trans.CodZonaVentas=zv.CodZonaVentas
                LEFT JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
                LEFT JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia
                
                WHERE ($cadena) AND  Estado = '1' AND ArchivoXml = '' GROUP BY gv.CodigoGrupoVentas";


        $dataReader = $consulta->multiConsulta($sql);

        return $dataReader;
    }

    public function getTransConsigSinAprovar() {

        $consulta = new Multiple();

        $this->gruposVentas = $consulta->getGrupoVentas();

        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gr.`CodigoGrupoVentas`=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);


        $sql = "
        SELECT 

        trans.`CodAsesor`,
        trans.`CodZonaVentas`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas
  
        FROM `transferenciaconsignacion` as trans
   
        join zonaventas as zv on trans.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        join asesorescomerciales as asesor on asesor.CodAsesor=trans.CodAsesor
         
        WHERE ($cadena) AND Estado = '1' AND ArchivoXml = '' GROUP BY gr.CodigoGrupoVentas 

        ";

        $dataReader = $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    public function getTotalDevoluciones() {

        $consulta = new Multiple();

        $this->gruposVentas = $consulta->getGrupoVentas();

        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.`CodigoGrupoVentas`=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);


        $sql = "
          SELECT 
          COUNT(devolu.IdDevolucion) as devoluciones,
          SUM(devolu.ValorDevolucion) as totaldevoluciones		
          FROM `devoluciones` devolu
                
          join zonaventas zv ON devolu.CodZonaVentas=zv.CodZonaVentas
          join gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
          join agencia ag ON gv.CodAgencia=ag.CodAgencia
                
          WHERE ($cadena) AND  Estado = '1' AND  Autoriza = '0' GROUP BY gv.CodigoGrupoVentas
        ";

        /* echo $sql;
          exit(); */

        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getDevolucionesSinAprovar() {

        $consulta = new Multiple();
        $cedula = Yii::app()->getUser()->getState('_cedula');
        $this->gruposVentas = $consulta->getGrupoVentas();
        $agencia = $consulta->getCodagenciaAdminCartera($cedula);

        $cadena = "(";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gr.`CodigoGrupoVentas`=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);
        $cadena .= ')';

        $sql = "
        SELECT 

        devol.`CodAsesor`,
        devol.`CodZonaVentas`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        COUNT(devol.IdDevolucion) as devoluciones,
        SUM(devol.ValorDevolucion) as totaldevoluciones	
        FROM `devoluciones` as devol
   
        join zonaventas as zv on devol.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia
        INNER JOIN descripciondevolucion AS des ON devol.`IdDevolucion` = des.`IdDevolucion` 
        left join asesorescomerciales as asesor on asesor.CodAsesor=devol.CodAsesor
        WHERE $cadena AND  devol.Estado = '1' AND  devol.Autoriza = '0' GROUP BY gr.CodigoGrupoVentas, devol.`IdDevolucion`
        ";
        /* echo $sql;
          exit(); */
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getInforamcionDevoluciones($agencia, $grupoventas) {

        $consulta = new Multiple();
        $sql = "
        SELECT 
        devoluciones.`IdDevolucion`,		
        devoluciones.`CodAsesor`,
        devoluciones.`CodZonaVentas`,
        devoluciones.`FechaDevolucion`,
        devoluciones.`CuentaCliente`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        cli.NombreCliente
  
        FROM `devoluciones` as devoluciones
   
        join zonaventas as zv on devoluciones.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        left join asesorescomerciales as asesor on asesor.CodAsesor=devoluciones.CodAsesor
        left join cliente as cli on cli.`CuentaCliente`=devoluciones.`CuentaCliente` 
         
        WHERE ag.CodAgencia = '$agencia' AND devoluciones.Estado = '1' AND Autoriza = '0' AND gr.CodigoGrupoVentas = '$grupoventas'


        ";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getinforamcionDevolucionDetalle($id, $agencia) {

        $consulta = new Multiple();
        $sql = "
        SELECT 
        devoluciones.`IdDevolucion`,		
        devoluciones.`CodAsesor`,
        devoluciones.`CodZonaVentas`,
        devoluciones.`FechaDevolucion`,
        devoluciones.CodigoMotivoDevolucion,
        devoluciones.Observacion,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        cli.NombreCliente,
        devoluciones.CuentaCliente,
        descrip.CodigoVariante,
        descrip.NombreUnidadMedida,
        descrip.Cantidad,
        porta.NombreArticulo,
        descrip.ValorTotalProducto,
        cadempresa.Nombre as TipoNegocio,
        devoluciones.ValorDevolucion
        
  
        FROM `devoluciones` as devoluciones
        
        join descripciondevolucion descrip on devoluciones.IdDevolucion=descrip.IdDevolucion
        join portafolio porta on descrip.CodigoArticulo=porta.CodigoArticulo
        join zonaventas as zv on devoluciones.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        left join asesorescomerciales as asesor on asesor.CodAsesor=devoluciones.CodAsesor
        left join cliente as cli on cli.`CuentaCliente`=devoluciones.`CuentaCliente` 
        left join cadenaempresa as cadempresa on cli.CodigoCadenaEmpresa=cadempresa.CodigoCadenaEmpresa  
         
        WHERE devoluciones.`IdDevolucion` = '$id'  GROUP BY devoluciones.`IdDevolucion`,descrip.CodigoVariante
        ";

        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getProveedoresDevolcuiones($variante, $grupoventas) {

        $consulta = new Multiple();
        $sql = "
        SELECT provee.NombreCuentaProveedor,provee.CodigoCuentaProveedor FROM `descripciondevolucion` as descrip
        join portafolio porta on porta.CodigoVariante=descrip.CodigoVariante 
        join proveedores as provee on porta.CuentaProveedor=provee.CodigoCuentaProveedor 
        where descrip.CodigoVariante = '$variante' AND porta.CodigoGrupoVentas = '$grupoventas' GROUP BY provee.CodigoCuentaProveedor
        ";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getMotivoProveedoresDevolucion($codMotivo) {

        $consulta = new Multiple();
        $sql = "
        SELECT * FROM `motivosdevolucionproveedor` WHERE CodigoMotivoDevolucion = '$codMotivo'
        ";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getUpdateProdcutosDevolucionaAutorizado($id, $variante, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `descripciondevolucion` SET `Autoriza`='1' where `IdDevolucion` = '$id' AND `CodigoVariante` = '$variante'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateProdcutosDevolucionRechazar($id, $variante, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `descripciondevolucion` SET `Autoriza`='2' where `IdDevolucion` = '$id' AND `CodigoVariante` = '$variante' AND `Autoriza`<>1";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getObservacion($id, $observacion, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `devoluciones` SET `Comentario` = '$observacion' WHERE `IdDevolucion` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getInsertTansaccionesDevoluciones($id, $agencia) {

        $consulta = new Multiple();
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('6','$id','$agencia','0')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateAutirzaDevolucionApro($id, $agencia, $user, $fecha, $hora) {

        $consulta = new Multiple();
        $sql = "Update `devoluciones` SET `Autoriza` = '1',`Estado` = '0' , QuienAutoriza = '$user', FechaAutorizacion = '$fecha', HoraAutorizacion = '$hora' WHERE `IdDevolucion` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateAutirzaDevolucionRecha($id, $agencia, $user, $fecha, $hora) {

        $consulta = new Multiple();
        $sql = "Update `devoluciones` SET `Autoriza` = '2', Estado = '2' ,QuienAutoriza = '$user', FechaAutorizacion = '$fecha', HoraAutorizacion = '$hora' WHERE `IdDevolucion` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getDescrPedido($id) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `descripciondevolucion` WHERE IdDevolucion = '$id' AND Autoriza = '2'";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getUpdateValorDevolucion($id, $agencia, $totaldevolucion) {

        $consulta = new Multiple();
        $sql = "Update `devoluciones` SET `ValorDevolucion` = '$totaldevolucion'  WHERE `IdDevolucion` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getCountAutorizadoAprova($id) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) as aprovadas FROM `descripciondevolucion` WHERE Autoriza = '1' AND IdDevolucion = '$id'";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getCountAutorizadoRechaz($id) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) as rechazadas FROM `descripciondevolucion` WHERE Autoriza = '2' AND IdDevolucion = '$id'";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getInsertmensaje($zona, $remitente, $agencia, $msg, $asesor) {

        $consulta = new Multiple();
        echo $sql = "INSERT INTO `mensajes`(`IdDestinatario`, `IdRemitente`, `FechaMensaje`, `HoraMensaje`, `Mensaje`, `Estado`, `CodAsesor`) VALUES ('$zona','$remitente',CURDATE(),CURTIME(),'$msg','0','$asesor')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getinforamcionTrasnmfererncia($agencia, $grupoventas) {

        $consulta = new Multiple();
        $sql = "
        SELECT 
        trans.`IdTransferencia`,		
        trans.`CodAsesor`,
        trans.`CodZonaVentas`,
        trans.`FechaTransferencia`,
        trans.`CuentaCliente`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        cli.NombreCliente
  
        FROM `transferenciaconsignacion` as trans
   
        left join zonaventas as zv on trans.CodZonaVentas=zv.CodZonaVentas
        left join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        left join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        left join asesorescomerciales as asesor on asesor.CodAsesor=trans.CodAsesor
        left join cliente as cli on cli.`CuentaCliente`=trans.`CuentaCliente` 
         
        WHERE ag.CodAgencia = '$agencia' AND trans.Estado = '1' AND trans.ArchivoXml = '' AND gr.CodigoGrupoVentas = '$grupoventas'
        ";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getinforamcionTrasnmferernciaDetalle($id, $agencia) {

        $consulta = new Multiple();
        $sql = "
        SELECT 
        trans.`IdTransferencia`,		
        trans.`CodAsesor`,
        trans.`CodZonaVentas`,
        trans.`FechaTransferencia`,
        trans.`CuentaCliente`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        cli.NombreCliente,
        trans.CuentaCliente,
        descrip.CodVariante,
        descrip.UnidadMedida,
        descrip.Cantidad,
        porta.NombreArticulo,
        cadempresa.Nombre as TipoNegocio
        
  
        FROM `transferenciaconsignacion` as trans
        
        join descripciontransferenciaconsignacion descrip on trans.IdTransferencia=descrip.IdTransferencia
        join portafolio porta on descrip.CodigoArticulo=porta.CodigoArticulo
        join zonaventas as zv on trans.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        join asesorescomerciales as asesor on asesor.CodAsesor=trans.CodAsesor
        left join cliente as cli on cli.`CuentaCliente`=trans.`CuentaCliente` 
        left join cadenaempresa as cadempresa on cli.CodigoCadenaEmpresa=cadempresa.CodigoCadenaEmpresa  
         
        WHERE trans.`IdTransferencia` = '$id'  GROUP BY trans.`IdTransferencia`,descrip.CodVariante


        ";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateEstadoTGransferenciaConsignacion($id, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `transferenciaconsignacion` SET `Estado`= '0' WHERE `IdTransferencia` = '$id' ";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateEstadoTGransferenciaConsignacionRecha($id, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `transferenciaconsignacion` SET `Estado`= '2' WHERE `IdTransferencia` = '$id' ";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function InsertTransaAxTransConsig($id, $agencia) {

        $consulta = new Multiple();
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('8','$id','$agencia','0')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    /* public function getinforamcionNotasCredito($agencia,$grupoventas){

      $consulta = new Multiple();
      $sql = "SELECT notas.*,asesores.Nombre,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente FROM `notascredito` notas
      join asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
      join conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
      join facturasaldo factu on notas.Factura=factu.NumeroFactura
      join clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
      join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente
      join zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
      join gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
      join agencia ag on ag.CodAgencia=gv.CodAgencia

      where ag.CodAgencia = '$agencia' and gv.CodigoGrupoVentas='$grupoventas' and notas.Estado = '1'

      GROUP BY notas.`IdNotaCredito`
      ";
      $dataReader = $consulta->multiConsulta($sql);
      return $dataReader;

      } */

    public function getActividaEspecial() {

        $consulta = new Multiple();
        $this->gruposVentas = $consulta->getGrupoVentas();

        $cadena = "";
        foreach ($this->gruposVentas as $item) {

            $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
        }
        $cadena = substr($cadena, 0, -4);

        $sql = "SELECT 
                zv.CodZonaVentas,
                gv.NombreGrupoVentas,
                gv.CodAgencia,
                ag.Nombre,
                pe.ValorPedido,
                gv.CodigoGrupoVentas,
                SUM(pe.ValorPedido) as TotalPedidos,
                COUNT(*) as CantidadPedidos

                FROM `pedidos` pe
                JOIN  zonaventas zv ON pe.CodZonaVentas=zv.CodZonaVentas
                JOIN  gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
                JOIN  agencia ag ON gv.CodAgencia=ag.CodAgencia

                WHERE ($cadena) AND pe.ActividadEspecial = '1' AND (pe.Estado = '1' OR pe.Estado = '2') AND ArchivoXml = '' GROUP BY gv.CodigoGrupoVentas";


        $dataReader = $consulta->multiConsulta($sql);

        return $dataReader;
    }

    public function getInforActividadEspecial($agencia, $grupoventas) {

        $consulta = new Multiple();
        $sql = "
        SELECT 
        pe.`IdPedido`,		
        pe.`CodAsesor`,
        pe.`CodZonaVentas`,
        pe.`FechaPedido`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        cli.NombreCliente,
        pe.CuentaCliente,
        pe.CodAsesor
  
        FROM `pedidos` as pe
   
        join zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        join asesorescomerciales as asesor on asesor.CodAsesor=pe.CodAsesor
        join cliente as cli on cli.`CuentaCliente`=pe.`CuentaCliente` 
         
        WHERE ag.CodAgencia = '$agencia' AND pe.ActividadEspecial = '1' AND (pe.Estado = '1' OR pe.Estado = '2') AND ArchivoXml = '' AND  gr.CodigoGrupoVentas = '$grupoventas'
 
        ";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getEstadoPedidoActual($id, $agencia) {
        $consulta = new Multiple();
        $sql = "SELECT `Estado` FROM `pedidos` WHERE `IdPedido` = '$id'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getDetallePedidoActividadEspecial($id, $agencia) {

        $consulta = new Multiple();
        $sql = "
        SELECT 
        pe.`IdPedido`,		
        pe.`CodAsesor`,
        pe.`CodZonaVentas`,
        pe.`FechaPedido`,
        gr.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gr.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gr.CodigoGrupoVentas,
        cli.NombreCliente,
        pe.CuentaCliente,
        cadempresa.Nombre as TipoNegocio,
        pe.Observacion,
        pe.Plazo,
        pe.ValorPedido,
        cliruta.DiasGracia
        
  
        FROM `pedidos` as pe
        
        join clienteruta as cliruta on pe.CuentaCliente=cliruta.CuentaCliente
        join zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia    
        join asesorescomerciales as asesor on asesor.CodAsesor=pe.CodAsesor
        join cliente as cli on cli.`CuentaCliente`=pe.`CuentaCliente` 
        left join cadenaempresa as cadempresa on cli.CodigoCadenaEmpresa=cadempresa.CodigoCadenaEmpresa  
         
        WHERE pe.`IdPedido` = '$id' 


        ";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function DiasProntoPago($agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `condicionespago`";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function DiasPlazo($agencia, $CodDias) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `condicionespago` where CodigoCondicionPago = '$CodDias'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateEstadoPedidosActiEspecial($id, $agencia, $diasplazo, $estadoPedidoNuevo) {

        $consulta = new Multiple();
        $sql = "UPDATE `pedidos` SET `Estado`= '$estadoPedidoNuevo',`Plazo`= '$diasplazo' WHERE `ActividadEspecial` = '1' AND `IdPedido` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateEstadoPedidosActiEspecialRecha($id, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `pedidos` SET `Estado`= '4'  WHERE `ActividadEspecial` = '1' AND `IdPedido` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function InsertPedidosActiEspecialTransAx($id, $agencia) {

        $consulta = new Multiple();
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('1','$id','$agencia','0')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getDiasPlazo($diasplazo) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) dias FROM `condicionespago` WHERE Dias = '$diasplazo' ";
        $dataReader = $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getInformacionNotasCredito($agencia, $grupoventas, $tipoUsuario, $proveedor = '') {

        $consulta = new Multiple();


        if ($tipoUsuario == 1) {

            $sql = "SELECT notas.*,asesores.Nombre,conceptos.CodigoConceptoNotaCredito,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente,factu.NumeroFactura,prov.NombreCuentaProveedor,ag.Nombre as agencia,gv.NombreGrupoVentas,ag.CodAgencia,gv.CodigoGrupoVentas FROM `notascredito` notas
        left join asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
        left join conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
        left join facturasaldo factu on notas.Factura=factu.NumeroFactura
        left join clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
        left join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        left join zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
        left join gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        left join agencia ag on ag.CodAgencia=gv.CodAgencia 
        left join proveedores prov on notas.Fabricante=prov.CodigoCuentaProveedor

        where ag.CodAgencia = '$agencia' and gv.CodigoGrupoVentas='$grupoventas' and notas.Estado = '1' and notas.Autoriza = '0'  and notas.Fabricante = ''

        GROUP BY notas.`IdNotaCredito`";
        } else {

            $sql = "SELECT notas.*,asesores.Nombre,conceptos.CodigoConceptoNotaCredito,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente,factu.NumeroFactura,prov.NombreCuentaProveedor,ag.Nombre as agencia,gv.NombreGrupoVentas,ag.CodAgencia,gv.CodigoGrupoVentas FROM `notascredito` notas
        left join asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
        left join conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
        left join facturasaldo factu on notas.Factura=factu.NumeroFactura
        left join clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
        left join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        left join zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
        left join gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        left join agencia ag on ag.CodAgencia=gv.CodAgencia 
        left join proveedores prov on notas.Fabricante=prov.CodigoCuentaProveedor

        where ag.CodAgencia = '$agencia' and gv.CodigoGrupoVentas='$grupoventas' and notas.Estado = '1' and notas.Autoriza = '0' and notas.Fabricante = '$proveedor'

        GROUP BY notas.`IdNotaCredito`";
        }


        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getInformacionNotasCreditoAdminCarter($agencia, $grupoventas) {


        $consulta = new Multiple();
        $sql = "SELECT notas.*,asesores.Nombre,conceptos.CodigoConceptoNotaCredito,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente,factu.NumeroFactura,prov.NombreCuentaProveedor,ag.Nombre as agencia,gv.NombreGrupoVentas,ag.CodAgencia,gv.CodigoGrupoVentas FROM `notascredito` notas
        join asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
        join conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
        join facturasaldo factu on notas.Factura=factu.NumeroFactura
        join clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
        join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        join zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
        join gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        join agencia ag on ag.CodAgencia=gv.CodAgencia 
        join proveedores prov on notas.Fabricante=prov.CodigoCuentaProveedor

        where ag.CodAgencia = '$agencia' and gv.CodigoGrupoVentas='$grupoventas' and notas.Estado = '3' and notas.Autoriza = '0'

        GROUP BY notas.`IdNotaCredito`";

        $dataReader = $consulta->consultaAgencia($agencia, $sql);

        return $dataReader;
    }

    public function UpdateAutorizarNotaCredito($id, $agencia, $user, $fecha, $hora) {

        $consulta = new Multiple();
        $sql = "UPDATE `notascredito` SET `Estado`= '0',`Autoriza`= '1', QuienAutoriza='$user', FechaAutorizacion='$fecha', HoraAutorizacion = '$hora' WHERE `IdNotaCredito` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function UpdateAutorizarNotaCreditoAdminCartera($id, $agencia, $user, $fecha, $hora) {

        $consulta = new Multiple();
        $sql = "UPDATE `notascredito` SET `Estado`= '0',`Autoriza`= '1', `AutorizaCartera`='1' , QuienAutoriza='$user', FechaAutorizacion='$fecha', HoraAutorizacion = '$hora' WHERE `IdNotaCredito` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function UpdateRechazarNotaCredito($id, $comentario, $agencia, $user, $fecha, $hora) {

        $consulta = new Multiple();
        $sql = "UPDATE `notascredito` SET `Estado`= '2', `Autoriza`= '2',`Comentario`='$comentario', QuienAutoriza='$user', FechaAutorizacion='$fecha', HoraAutorizacion = '$hora' WHERE `IdNotaCredito` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function UpdateRechazarNotaCreditoAdminCartera($id, $comentario, $agencia, $user, $fecha, $hora) {

        $consulta = new Multiple();
        $sql = "UPDATE `notascredito` SET `Estado`= '2', `Autoriza`= '2', `AutorizaCartera`='1' ,`Comentario`='$comentario', QuienAutoriza='$user', FechaAutorizacion='$fecha', HoraAutorizacion = '$hora' WHERE `IdNotaCredito` = '$id'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function InsertTransaccionesNotasCredito($id, $agencia) {

        $consulta = new Multiple();
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('7','$id','$agencia','0')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function InsertMensajeNotasCredito($remitente, $zona, $fecha, $hora, $Mensaje, $asesor, $agencia) {

        $consulta = new Multiple();
        $sql = "INSERT INTO `mensajes`(`IdDestinatario`, `IdRemitente`, `FechaMensaje`, `HoraMensaje`, `Mensaje`, `Estado`, `CodAsesor`) VALUES ('$zona','$remitente','$fecha','$hora','$Mensaje','0','$asesor')";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function Detallefactura($numerofactura) {

        $consulta = new Multiple();
        $sql = "SELECT factur.NumeroFactura,factur.FechaFactura,cli.NombreCliente,factur.ValorNetoFactura,factusaldoDeta.CodigoVariante,porta.NombreArticulo,prove.CodigoCuentaProveedor,prove.NombreCuentaProveedor,factusaldoDeta.ValorNetoArticulo,factusaldoDeta.CantidadFacturada FROM `facturasaldodetalle` as factusaldoDeta 

      join facturasaldo factur on factusaldoDeta.NumeroFactura=factur.NumeroFactura 
      left join cliente cli on factur.CuentaCliente=cli.CuentaCliente
      join portafolio porta on factusaldoDeta.CodigoArticulo=porta.CodigoArticulo 
      join proveedores prove on factusaldoDeta.CuentaProveedor=prove.CodigoCuentaProveedor
  
      where factur.NumeroFactura = '$numerofactura' group by porta.CodigoArticulo";
        $dataReader = $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    Public function getConuntTransaccionesAx($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) as existe FROM `transaccionesax` where IdDocumento = '$id' AND CodigoAgencia = '$agencia' AND IdDocumento <> '' ";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosAltipal($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) descripcionssinaprobarAltipal FROM `pedidos` p join descripcionpedido dp on p.IdPedido=dp.IdPedido WHERE  p.IdPedido = '$id' AND  (dp.DsctoEspecialAltipal > 0 or p.Estado = '2') ";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosAprovadosActividaEspecial($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) as pedidoaprovadoActividaEspecial FROM `pedidos` p join descripcionpedido dp on p.IdPedido=dp.IdPedido WHERE p.Estado = '2' AND p.IdPedido = '$id'";
        $dataReader = $consulta->consultaAgenciaRow($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosProveedor($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) AS productosaenviarProveedor FROM `descripcionpedido` where IdPedido = '$id' AND  DsctoEspecialProveedor > 0";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosCompartido($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) AS productosaenviarCompatidos FROM `descripcionpedido` where IdPedido = '$id' AND  DsctoEspecialProveedor > 0 AND DsctoEspecialAltipal > 0";
        $dataReader = $consulta->consultaAgenciaRow($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosAprovados($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) AS productosaenviar FROM `aprovacionpedido` where IdPedido = '$id'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getPedidosAprovadosCompartidos($id, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) AS productosaenviar FROM `aprovacionpedido` where IdPedido = '$id' AND `EstadoRevisadoAltipal` > 0 AND `EstadoRevisadoProveedor` > 0;";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getDinamicas($agencia, $proveedor) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `dinamicascomerciales` where  CodigoProveedor = '$proveedor' AND Saldo > 0";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getValoresDinamicas($agencia, $coddimencion) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `dinamicascomerciales` where  Codigo = '$coddimencion'";
        $dataReader = $consulta->consultaAgenciaRow($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateSaldoDinamica($CodDinamica, $valordinamica, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `dinamicascomerciales` SET Saldo = '$valordinamica' where  Codigo = '$CodDinamica'";
        //$dataReader = $consulta->queryAgencia($agencia, $sql);
        $dataReader = $consulta->multiQuery($sql);
        return $dataReader;
    }

    public function getUpdateDescripcionPedidoDinamca($idDescripcionPedido, $CodDinamica, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE descripcionpedido SET CodigoDinamica = '$CodDinamica' WHERE Id = '$idDescripcionPedido'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getUpdateNotaDinamica($idNotas, $CodDinamica, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE notascredito SET CodigoDinamica = '$CodDinamica' WHERE IdNotaCredito = '$idNotas'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getDetalleAprobado($idDescripcionPedido, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT COUNT(*) as ProductoAprobado FROM `aprovacionpedido` WHERE IdDetallePedido = '$idDescripcionPedido'";
        $dataReader = $consulta->consultaAgenciaRow($agencia, $sql);
        return $dataReader;
    }

}
