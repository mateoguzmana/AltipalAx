<?php

class AprovacionDocumentos extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getGruposyAgenciasPorId($id) {
        $cadena = "";
        $sql = "SELECT CodAgencia,CodigoGrupoVentas FROM `configuracionadministrador` WHERE IdAdministrador=$id";
        $gruposventas = Yii::app()->db->createCommand($sql)->queryAll();
        foreach ($gruposventas as $item) {
            $cadena.="(gv.CodAgencia='" . $item['CodAgencia'] . "' AND gv.`CodigoGrupoVentas`='" . $item['CodigoGrupoVentas'] . "') || ";
        }
        return $cadena != "" ? substr($cadena, 0, -4) : "";
    }

    public function getPedidosDescuentosAdminCartera($id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
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
        INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
        LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
        LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
        INNER JOIN agencia ag ON am.Agencia=ag.CodAgencia
        LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido 
        WHERE am.Agencia<>'' AND dp.DsctoEspecial>'0' AND p.Estado='3' AND ($cadena)";
            return Multiple::multiConsulta($sql);
        }
        return "";
    }

    public function getPedidosDescuentos($tipoUsuario, $proveedor = '', $id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
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
            INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
            LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
            LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
            INNER JOIN agencia ag ON am.Agencia=ag.CodAgencia
            LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
            WHERE am.Agencia<>'' AND ($cadena) AND dp.DsctoEspecial<>'' AND dp.DsctoEspecialAltipal>'0' AND p.Estado='1'";
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
            INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
            LEFT JOIN sitios s ON p.CodigoSitio=s.CodSitio
            LEFT JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
            INNER JOIN agencia ag ON am.Agencia=ag.CodAgencia
            LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido 
            WHERE am.Agencia<>'' AND dp.DsctoEspecial<>'' AND ($cadena) AND dp.DsctoEspecialProveedor>'0' AND dp.CuentaProveedor='$proveedor' AND p.Estado='1'";
            }
            return Multiple::multiConsultaQuery($sql);
        }
        return "";
    }

    public function getPedidosGrupoVentas($agencia, $grupoVentas, $tipoUsuario, $proveedor = '') {
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
        WHERE am.Agencia<>'' AND dp.DsctoEspecial>'0' AND p.`CodGrupoVenta`='$grupoVentas' AND dp.DsctoEspecialAltipal>'0' AND p.Estado='1' GROUP BY p.`IdPedido`";
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
        WHERE am.Agencia<>'' AND dp.DsctoEspecial<>'' AND p.`CodGrupoVenta`='$grupoVentas' AND dp.DsctoEspecialProveedor >'0' AND dp.CuentaProveedor='$proveedor' AND p.Estado='1' GROUP BY p.`IdPedido`";
        }
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosGrupoVentasAdminCartera($agencia, $grupoVentas) {
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
        WHERE am.Agencia<>'' AND dp.DsctoEspecial>'0' AND p.Estado='3' AND p.`CodGrupoVenta`='$grupoVentas' GROUP BY p.`IdPedido`";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosGrupoVentasDetalle($agencia, $grupoVentas, $tipoUsuario, $idPedido, $proveedor = '') {
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
        dp.NombreUnidadMedida,
        dp.TotalPrecioNeto,
        dp.DsctoEspecialProveedor,
        dp.DsctoEspecialAltipal,
        dp.DsctoEspecial,
        dp.ValorDsctoEspecial,
        ap.EstadoRevisadoProveedor,
        ap.EstadoRevisadoAltipal,
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
        WHERE am.Agencia<>'' AND dp.DsctoEspecial<>'' AND dp.DsctoEspecialAltipal>'0' AND p.Estado='1' AND p.`CodGrupoVenta`='$grupoVentas' AND p.IdPedido='$idPedido'";
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
        dp.NombreUnidadMedida,
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
        WHERE am.Agencia<>'' AND dp.DsctoEspecial<>'' AND p.`CodGrupoVenta`='$grupoVentas' AND dp.DsctoEspecialProveedor>'0' AND p.IdPedido='$idPedido' AND dp.CuentaProveedor='$proveedor' AND p.Estado='1'";
        }
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosGrupoVentasDetalleAdminCartera($agencia, $grupoVentas, $idPedido) {
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
        dp.NombreUnidadMedida,
        dp.TotalPrecioNeto,
        dp.DsctoEspecialProveedor,
        dp.DsctoEspecialAltipal,
        dp.DsctoEspecial,
        dp.ValorDsctoEspecial,
        ap.EstadoRevisadoProveedor,
        ap.EstadoRevisadoAltipal,
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
        WHERE am.Agencia<>'' AND (dp.DsctoEspecial<>'' AND p.Estado='3') AND p.`CodGrupoVenta`='$grupoVentas' AND p.IdPedido='$idPedido'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function insertAutorizacionPedido($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro) {
        $aprovacion = $this->consultaAprovacionPedido($idPedido, $idDescripcionPedido, $agencia);
        if ($aprovacion > 0) {
            if ($tipoUsuario == '1') {
                $sql = "UPDATE `aprovacionpedido` SET 
            `EstadoRevisadoAltipal`='1',
            `MotivoRechazoAltipal`='$motivo',
            `EstadoRechazoAltipal`='$estadoRechazo',
            `UsuarioAutorizoDsctoAltipal`='$cedulaUsuario',
            `NombreAutorizoDsctoAltipal`='$nombreusuario',
            `FechaAutorizaAltipal`='$fechaRegistro',
            `HoraAutorizaAltipal`='$horaRegistro' 
             WHERE IdPedido='$idPedido' AND IdDetallePedido='$idDescripcionPedido'";
            } else {
                $sql = "UPDATE `aprovacionpedido` SET
            `EstadoRevisadoProveedor`='1',
            `MotivoRechazoProveedor`='$motivo',
            `EstadoRechazoProveedor`='$estadoRechazo',
            `UsuarioAutorizoDsctoProveedor`='$cedulaUsuario',
            `NombreAutorizoDsctoProveedor`='$nombreusuario',
            `FechaAutorizaProveedor`='$fechaRegistro',
            `HoraAutorizaProveedor`='$horaRegistro' 
             WHERE IdPedido='$idPedido' AND IdDetallePedido='$idDescripcionPedido'";
            }
        } else {
            if ($tipoUsuario == '1') {
                $sql = "INSERT INTO `aprovacionpedido` 
            (`IdPedido`,
            `IdDetallePedido`,
            `QuienAutorizaDscto`,
            `EstadoRevisadoAltipal`,
            `MotivoRechazoAltipal`,
            `EstadoRechazoAltipal`,
            `UsuarioAutorizoDsctoAltipal`,
            `NombreAutorizoDsctoAltipal`,
            `FechaAutorizaAltipal`,
            `HoraAutorizaAltipal`) 
            VALUES 
            ('$idPedido',
            '$idDescripcionPedido',
            '$QuienAutorizaDscto',
            '1',
            '$motivo',
            '$estadoRechazo',
            '$cedulaUsuario',
            '$nombreusuario',
            '$fechaRegistro',
            '$horaRegistro')";
            } else {
                $sql = "INSERT INTO `aprovacionpedido`
            (`IdPedido`,
            `IdDetallePedido`,
            `QuienAutorizaDscto`,
            `EstadoRevisadoProveedor`,
            `MotivoRechazoProveedor`,
            `EstadoRechazoProveedor`,
            `UsuarioAutorizoDsctoProveedor`,
            `NombreAutorizoDsctoProveedor`,
            `FechaAutorizaProveedor`,
            `HoraAutorizaProveedor`) 
            VALUES 
            ('$idPedido',
            '$idDescripcionPedido',
            '$QuienAutorizaDscto',
            '1',
            '$motivo',
            '$estadoRechazo',
            '$cedulaUsuario',
            '$nombreusuario',
            '$fechaRegistro',
            '$horaRegistro')";
            }
        }
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function insertAutorizacionPedidoAdminCartera($agencia, $tipoUsuario, $idPedido, $idDescripcionPedido, $QuienAutorizaDscto, $estadoRechazo, $motivo, $cedulaUsuario, $nombreusuario, $fechaRegistro, $horaRegistro) {
        $aprovacion = $this->consultaAprovacionPedido($idPedido, $idDescripcionPedido, $agencia);
        if ($aprovacion > 0) {
            $sql = "UPDATE `aprovacionpedido` SET 
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
         WHERE IdPedido='$idPedido' AND IdDetallePedido='$idDescripcionPedido'";
        } else {
            $sql = "INSERT INTO `aprovacionpedido` 
        (`IdPedido`,`IdDetallePedido`,`AutorizaDscto`,`QuienAutorizaDscto`,`EstadoRevisadoAltipal`,`MotivoRechazoAltipal`,`EstadoRechazoAltipal`,
        `UsuarioAutorizoDsctoAltipal`,`NombreAutorizoDsctoAltipal`,`FechaAutorizaAltipal`,`HoraAutorizaAltipal`) VALUES ('$idPedido','$idDescripcionPedido',"
                    . "'CARTERA','$QuienAutorizaDscto','1','$motivo','$estadoRechazo','$cedulaUsuario','$nombreusuario','$fechaRegistro','$horaRegistro')";
        }
        Multiple::queryAgencia($agencia, $sql);
    }

    public function pedidodosaprovados($idPedido, $agencia) {
        $sql = "SELECT * FROM `descripcionpedido` descripPedi JOIN aprovacionpedido aproPedi on descripPedi.Id=aproPedi.IdDetallePedido WHERE descripPedi.IdPedido='$idPedido'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function InsertTransAxDescuentoEspecial($idPedido, $agencia, $estadoRechazo) {
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`,`IdDocumento`,`CodigoAgencia`,`EstadoTransaccion`) VALUES ('1','$idPedido','$agencia','$estadoRechazo')";
        Multiple::queryAgencia($agencia, $sql);
    }

    public function UpdateEstadoPedidoDesEspecialAdminCartera($idPedido, $agencia, $estadoRechazo) {
        $Mensaje = $estadoRechazo == 1 ? "Pedido Rechazado" : "";
        $sql = "UPDATE `pedidos` SET `Estado`='$estadoRechazo',AutorizaDescuentoEspecial='1',ArchivoXml='$Mensaje' WHERE `IdPedido`='$idPedido'";
        Multiple::queryAgencia($agencia, $sql);
    }

    public function UpdateEstadoPedidoDesEspecial($idPedido, $agencia, $estadoRechazo) {
        $Mensaje = $estadoRechazo == 1 ? "Pedido Rechazado" : "";
        $sql = "UPDATE `pedidos` SET `Estado`='$estadoRechazo',AutorizaDescuentoEspecial='1',ArchivoXml='$Mensaje' WHERE `IdPedido`='$idPedido'";
        Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateEstadoPedidoActividadEspecial($idPedido, $agencia, $estadoRechazo) {
        $Mensaje = $estadoRechazo == 1 ? "Pedido Rechazado" : "";
        $sql = "UPDATE `pedidos` SET `Estado`='$estadoRechazo',ArchivoXml='$Mensaje' WHERE `IdPedido`='$idPedido'";
        Multiple::queryAgencia($agencia, $sql);
    }

    public function getNotasCreditoAdminCartera($conceptos, $id) {
        $cont = 1;
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
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
        LEFT JOIN zonaventas zv ON nc.CodZonaVentas=zv.CodZonaVentas
        INNER JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        INNER JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia 
        WHERE ($cadena) AND nc.Autoriza='0' AND nc.Estado='3' AND nc.Concepto IN (";
            foreach ($conceptos as $itemzona) {
                if ($cont == count($conceptos)) {
                    $sql.="'" . $itemzona['CodigoConceptoNotasCredito'] . "') ";
                } else {
                    $sql.="'" . $itemzona['CodigoConceptoNotasCredito'] . "',";
                }
                $cont++;
            }
            $sql.="GROUP BY gv.CodigoGrupoVentas";
            return Multiple::multiConsulta($sql);
        }
        return "";
    }

    public function getNotasCredito($conceptos, $tipoUsuario, $proveedor = '', $id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
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
            INNER JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia
            WHERE ($cadena) AND nc.Autoriza='0' AND nc.Estado='1' AND nc.Concepto IN (";
                foreach ($conceptos as $itemzona) {
                    if ($cont == count($conceptos)) {
                        $sql.="'" . $itemzona['CodigoConceptoNotasCredito'] . "') ";
                    } else {
                        $sql.="'" . $itemzona['CodigoConceptoNotasCredito'] . "',";
                    }
                    $cont++;
                }
                $sql.="GROUP BY gv.CodigoGrupoVentas";
            } else {
                //echo 'entre'; 
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
            INNER JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia 
            WHERE ($cadena) AND nc.Autoriza='0' AND nc.Estado='1' AND Fabricante='$proveedor' AND nc.Concepto IN (";
                foreach ($conceptos as $itemzona) {
                    if ($cont == count($conceptos)) {
                        $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "') ";
                    } else {
                        $sql.=" '" . $itemzona['CodigoConceptoNotasCredito'] . "',";
                    }
                    $cont++;
                }
                $sql.="GROUP BY gv.CodigoGrupoVentas";
            }
            return Multiple::multiConsultaQuery($sql);
        }
        return "";
    }

    public function conceptosAdministradorNotasCredito($id) {
        $sql = "SELECT CodigoConceptoNotasCredito FROM `configuracionconceptosnotascredito` WHERE IdAdministrador='$id'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getDetalleFotosNotasCreditoDias($id, $agencia) {
        $sql = "SELECT Nombre FROM `notascreditofoto` WHERE IdNotaCredito='$id'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getProveedorAdministrador($cedulaUsuario) {
        $sql = "SELECT cad.CodigoProveedor FROM `administrador` a INNER JOIN configuracionaprobaciondocumentos cad ON a.Id=cad.IdAdministrador WHERE a.Cedula='$cedulaUsuario'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    private function consultaAprovacionPedido($idPedido, $idDetallePedido, $agencia) {
        $sql = "SELECT COUNT(IdPedido) as total FROM `aprovacionpedido` WHERE `IdPedido`='$idPedido' AND `IdDetallePedido`='$idDetallePedido'";
        $dataReader = Multiple::consultaAgencia($agencia, $sql);
        return $dataReader[0]['total'];
    }

    public function getTotalTransConsigSinAprovar($id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
            $sql = "SELECT 
        COUNT(trans.IdTransferencia) as transferencias
        FROM `transferenciaconsignacion` trans 
        LEFT JOIN zonaventas zv ON trans.CodZonaVentas=zv.CodZonaVentas
        INNER JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        INNER JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia 
        WHERE ($cadena) AND Estado='1' AND ArchivoXml='' GROUP BY gv.CodigoGrupoVentas";
            return Multiple::multiConsulta($sql);
        }
        return "";
    }

    public function getTransConsigSinAprovar($id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
            $sql = "SELECT 
            trans.`CodAsesor`,
            trans.`CodZonaVentas`,
            gv.NombreGrupoVentas,
            ag.Nombre as NombreAgencia,
            gv.CodAgencia,
            asesor.Nombre as NombreAsesor,
            gv.CodigoGrupoVentas 
            FROM `transferenciaconsignacion` as trans 
            JOIN zonaventas as zv on trans.CodZonaVentas=zv.CodZonaVentas
            JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
            JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
            JOIN asesorescomerciales as asesor on asesor.CodAsesor=trans.CodAsesor 
            WHERE ($cadena) AND Estado='1' AND ArchivoXml='' GROUP BY gv.CodigoGrupoVentas";
            return Multiple::multiConsultaQuery($sql);
        }
        return "";
    }

    public function getTotalDevoluciones($id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
            $sql = "SELECT 
        COUNT(DISTINCT(devolu.IdDevolucion)) as devoluciones,
        SUM(devolu.ValorDevolucion) as totaldevoluciones 
        FROM `devoluciones` devolu 
        JOIN zonaventas zv ON devolu.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia 
        LEFT JOIN asesorescomerciales as asesor on asesor.CodAsesor=devolu.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=devolu.`CuentaCliente`
        WHERE ($cadena) AND devolu.Estado='1' AND devolu.Autoriza='0' GROUP BY gv.CodigoGrupoVentas";
            //INNER JOIN descripciondevolucion AS des ON devolu.`IdDevolucion`=des.`IdDevolucion` 
            /* echo $sql;
              exit(); */
            return Multiple::multiConsulta($sql);
        }
        return "";
    }

    public function getDevolucionesSinAprovar($id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
            $sql = "SELECT 
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        gv.CodigoGrupoVentas,
        COUNT(DISTINCT(devol.IdDevolucion)) as devoluciones,
        SUM(devol.ValorDevolucion) as totaldevoluciones	
        FROM `devoluciones` as devol 
        JOIN zonaventas as zv on devol.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia
        LEFT JOIN asesorescomerciales as asesor on asesor.CodAsesor=devol.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=devol.`CuentaCliente`
        WHERE ($cadena) AND devol.Estado='1' AND devol.Autoriza='0' GROUP BY gv.CodigoGrupoVentas";
            return Multiple::multiConsulta($sql);
        }
        return "";
    }

    public function getInforamcionDevoluciones($agencia, $grupoventas) {
        $sql = "SELECT 
        devoluciones.`IdDevolucion`,
        devoluciones.`CodAsesor`,
        devoluciones.`CodZonaVentas`,
        devoluciones.`FechaDevolucion`,
        devoluciones.`CuentaCliente`,
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gv.CodigoGrupoVentas,
        cli.NombreCliente 
        FROM `devoluciones` as devoluciones 
        JOIN zonaventas as zv on devoluciones.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
        LEFT JOIN asesorescomerciales as asesor on asesor.CodAsesor=devoluciones.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=devoluciones.`CuentaCliente`
        WHERE ag.CodAgencia='$agencia' AND devoluciones.Estado='1' AND devoluciones.Autoriza='0' AND gv.CodigoGrupoVentas='$grupoventas' ORDER BY devoluciones.`IdDevolucion`";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getinforamcionDevolucionDetalle($id, $agencia) {
        $sql = "SELECT 
        devoluciones.`IdDevolucion`,
        devoluciones.`CodAsesor`,
        devoluciones.`CodZonaVentas`,
        devoluciones.`FechaDevolucion`,
        devoluciones.CodigoMotivoDevolucion,
        devoluciones.Observacion,
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gv.CodigoGrupoVentas,
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
        JOIN descripciondevolucion descrip on devoluciones.IdDevolucion=descrip.IdDevolucion
        JOIN portafolio porta on descrip.CodigoArticulo=porta.CodigoArticulo
        JOIN zonaventas as zv on devoluciones.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
        LEFT JOIN asesorescomerciales as asesor on asesor.CodAsesor=devoluciones.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=devoluciones.`CuentaCliente` 
        LEFT JOIN cadenaempresa as cadempresa on cli.CodigoCadenaEmpresa=cadempresa.CodigoCadenaEmpresa 
        WHERE devoluciones.`IdDevolucion`='$id' GROUP BY devoluciones.`IdDevolucion`,descrip.CodigoVariante";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getProveedoresDevolcuiones($variante, $grupoventas) {
        $sql = "SELECT provee.NombreCuentaProveedor,provee.CodigoCuentaProveedor FROM `descripciondevolucion` as descrip
        JOIN portafolio porta on porta.CodigoVariante=descrip.CodigoVariante 
        JOIN proveedores as provee on porta.CuentaProveedor=provee.CodigoCuentaProveedor 
        WHERE descrip.CodigoVariante='$variante' AND porta.CodigoGrupoVentas='$grupoventas' GROUP BY provee.CodigoCuentaProveedor";
        return Multiple::multiConsulta($sql);
    }

    public function getMotivoProveedoresDevolucion($codMotivo) {
        $sql = "SELECT * FROM `motivosdevolucionproveedor` WHERE CodigoMotivoDevolucion='$codMotivo'";
        return Multiple::multiConsulta($sql);
    }

    public function getUpdateProdcutosDevolucionaAutorizado($id, $variante, $agencia) {
        $sql = "UPDATE `descripciondevolucion` SET `Autoriza`='1' WHERE `IdDevolucion`='$id' AND `CodigoVariante`='$variante'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateProdcutosDevolucionRechazar($id, $variante, $agencia) {
        $sql = "UPDATE `descripciondevolucion` SET `Autoriza`='2' WHERE `IdDevolucion`='$id' AND `CodigoVariante`='$variante' AND `Autoriza`<>1";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getObservacion($id, $observacion, $agencia) {
        $sql = "UPDATE `devoluciones` SET `Comentario`='$observacion' WHERE `IdDevolucion`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getInsertTansaccionesDevoluciones($id, $agencia) {
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`,`IdDocumento`,`CodigoAgencia`,`EstadoTransaccion`) VALUES ('6','$id','$agencia','0')";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateAutirzaDevolucionApro($id, $agencia, $user, $fecha, $hora) {
        $sql = "Update `devoluciones` SET `Autoriza`='1',`Estado`='0',QuienAutoriza='$user',FechaAutorizacion='$fecha',HoraAutorizacion='$hora' WHERE `IdDevolucion`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateAutirzaDevolucionRecha($id, $agencia, $user, $fecha, $hora) {
        $sql = "Update `devoluciones` SET `Autoriza`='2',Estado='2',QuienAutoriza='$user',FechaAutorizacion='$fecha',HoraAutorizacion='$hora' WHERE `IdDevolucion`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getDescrPedido($id) {
        $sql = "SELECT * FROM `descripciondevolucion` WHERE IdDevolucion='$id' AND Autoriza='2'";
        return Multiple::multiConsulta($sql);
    }

    public function getUpdateValorDevolucion($id, $agencia, $totaldevolucion) {
        $sql = "Update `devoluciones` SET `ValorDevolucion`='$totaldevolucion' WHERE `IdDevolucion`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getCountAutorizadoAprova($id) {
        $sql = "SELECT COUNT(*) as aprovadas FROM `descripciondevolucion` WHERE Autoriza='1' AND IdDevolucion='$id'";
        return Multiple::multiConsulta($sql);
    }

    public function getCountAutorizadoRechaz($id) {
        $sql = "SELECT COUNT(*) as rechazadas FROM `descripciondevolucion` WHERE Autoriza='2' AND IdDevolucion='$id'";
        return Multiple::multiConsulta($sql);
    }

    public function getInsertmensaje($zona, $remitente, $agencia, $msg, $asesor) {
        echo $sql = "INSERT INTO `mensajes`(`IdDestinatario`,`IdRemitente`,`FechaMensaje`,`HoraMensaje`,`Mensaje`,`Estado`,`CodAsesor`) VALUES ('$zona','$remitente',CURDATE(),CURTIME(),'$msg','0','$asesor')";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getinforamcionTrasnmfererncia($agencia, $grupoventas) {
        $sql = "SELECT 
        trans.`IdTransferencia`,
        trans.`CodAsesor`,
        trans.`CodZonaVentas`,
        trans.`FechaTransferencia`,
        trans.`CuentaCliente`,
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gv.CodigoGrupoVentas,
        cli.NombreCliente 
        FROM `transferenciaconsignacion` as trans 
        LEFT JOIN zonaventas as zv on trans.CodZonaVentas=zv.CodZonaVentas
        INNER JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        INNER JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
        LEFT JOIN asesorescomerciales as asesor on asesor.CodAsesor=trans.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=trans.`CuentaCliente` 
        WHERE ag.CodAgencia='$agencia' AND trans.Estado='1' AND trans.ArchivoXml='' AND gv.CodigoGrupoVentas='$grupoventas'";
        return Multiple::multiConsulta($sql);
    }

    public function getinforamcionTrasnmferernciaDetalle($id, $agencia) {
        $sql = "SELECT 
        trans.`IdTransferencia`,
        trans.`CodAsesor`,
        trans.`CodZonaVentas`,
        trans.`FechaTransferencia`,
        trans.`CuentaCliente`,
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gv.CodigoGrupoVentas,
        cli.NombreCliente,
        trans.CuentaCliente,
        descrip.CodVariante,
        descrip.UnidadMedida,
        descrip.Cantidad,
        porta.NombreArticulo,
        cadempresa.Nombre as TipoNegocio 
        FROM `transferenciaconsignacion` as trans 
        JOIN descripciontransferenciaconsignacion descrip on trans.IdTransferencia=descrip.IdTransferencia
        JOIN portafolio porta on descrip.CodigoArticulo=porta.CodigoArticulo
        JOIN zonaventas as zv on trans.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
        JOIN asesorescomerciales as asesor on asesor.CodAsesor=trans.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=trans.`CuentaCliente` 
        LEFT JOIN cadenaempresa as cadempresa on cli.CodigoCadenaEmpresa=cadempresa.CodigoCadenaEmpresa 
        WHERE trans.`IdTransferencia`='$id' GROUP BY trans.`IdTransferencia`,descrip.CodVariante";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getUpdateEstadoTGransferenciaConsignacion($id, $agencia) {
        $sql = "UPDATE `transferenciaconsignacion` SET `Estado`='0' WHERE `IdTransferencia`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateEstadoTGransferenciaConsignacionRecha($id, $agencia) {
        $sql = "UPDATE `transferenciaconsignacion` SET `Estado`='2' WHERE `IdTransferencia`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function InsertTransaAxTransConsig($id, $agencia) {
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`,`IdDocumento`,`CodigoAgencia`,`EstadoTransaccion`) VALUES ('8','$id','$agencia','0')";
        return Multiple::queryAgencia($agencia, $sql);
    }

    /* public function getinforamcionNotasCredito($agencia,$grupoventas){ 
      $sql="SELECT notas.*,asesores.Nombre,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente FROM `notascredito` notas
      JOIN asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
      JOIN conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
      JOIN facturasaldo factu on notas.Factura=factu.NumeroFactura
      JOIN clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
      JOIN cliente cli on cliruta.CuentaCliente=cli.CuentaCliente
      JOIN zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
      JOIN gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
      JOIN agencia ag on ag.CodAgencia=gv.CodAgencia
      WHERE ag.CodAgencia='$agencia' AND gv.CodigoGrupoVentas='$grupoventas' AND notas.Estado='1'
      GROUP BY notas.`IdNotaCredito`";
      return Multiple::multiConsulta($sql);
      } */

    public function getActividaEspecial($id) {
        $cadena = $this->getGruposyAgenciasPorId($id);
        if ($cadena != "") {
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
        JOIN zonaventas zv ON pe.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas gv ON zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia ag ON gv.CodAgencia=ag.CodAgencia
        JOIN asesorescomerciales as asesor on asesor.CodAsesor=pe.CodAsesor
        JOIN cliente as cli on cli.`CuentaCliente`=pe.`CuentaCliente` 
        WHERE ($cadena) AND pe.ActividadEspecial='1' AND (pe.Estado='1' OR pe.Estado='2') AND ArchivoXml='' GROUP BY gv.CodigoGrupoVentas";
            return Multiple::multiConsulta($sql);
        }
        return "";
    }

    public function getInforActividadEspecial($agencia, $grupoventas) {
        $sql = "SELECT 
        pe.`IdPedido`,
        pe.`CodAsesor`,
        pe.`CodZonaVentas`,
        pe.`FechaPedido`,
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gv.CodigoGrupoVentas,
        cli.NombreCliente,
        pe.CuentaCliente,
        pe.CodAsesor 
        FROM `pedidos` as pe 
        JOIN zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
        LEFT JOIN asesorescomerciales as asesor on asesor.CodAsesor=pe.CodAsesor
        LEFT JOIN cliente as cli on cli.`CuentaCliente`=pe.`CuentaCliente` 
        WHERE ag.CodAgencia='$agencia' AND pe.ActividadEspecial='1' AND (pe.Estado='1' OR pe.Estado='2') AND ArchivoXml='' AND gv.CodigoGrupoVentas='$grupoventas'";
        return Multiple::multiConsulta($sql);
    }

    public function getEstadoPedidoActual($id, $agencia) {
        $sql = "SELECT `Estado` FROM `pedidos` WHERE `IdPedido`='$id'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getDetallePedidoActividadEspecial($id, $agencia) {
        $sql = "SELECT 
        pe.`IdPedido`,
        pe.`CodAsesor`,
        pe.`CodZonaVentas`,
        pe.`FechaPedido`,
        gv.NombreGrupoVentas,
        ag.Nombre as NombreAgencia,
        gv.CodAgencia,
        asesor.Nombre as NombreAsesor,
        gv.CodigoGrupoVentas,
        cli.NombreCliente,
        pe.CuentaCliente,
        cadempresa.Nombre as TipoNegocio,
        pe.Observacion,
        pe.Plazo,
        pe.ValorPedido,
        cliruta.DiasGracia 
        FROM `pedidos` as pe 
        JOIN clienteruta as cliruta on pe.CuentaCliente=cliruta.CuentaCliente
        JOIN zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas
        JOIN gruposventas as gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia as ag on gv.CodAgencia=ag.CodAgencia 
        JOIN asesorescomerciales as asesor on asesor.CodAsesor=pe.CodAsesor
        JOIN cliente as cli on cli.`CuentaCliente`=pe.`CuentaCliente` 
        LEFT JOIN cadenaempresa as cadempresa on cli.CodigoCadenaEmpresa=cadempresa.CodigoCadenaEmpresa 
        WHERE pe.`IdPedido`='$id'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function DiasProntoPago($agencia) {
        $sql = "SELECT * FROM `condicionespago`";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function DiasPlazo($agencia, $CodDias) {
        $sql = "SELECT * FROM `condicionespago` WHERE CodigoCondicionPago='$CodDias'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getUpdateEstadoPedidosActiEspecial($id, $agencia, $diasplazo, $estadoPedidoNuevo) {
        $sql = "UPDATE `pedidos` SET `Estado`='$estadoPedidoNuevo',`Plazo`='$diasplazo' WHERE `ActividadEspecial`='1' AND `IdPedido`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateEstadoPedidosActiEspecialRecha($id, $agencia) {
        $sql = "UPDATE `pedidos` SET `Estado`='4' WHERE `ActividadEspecial`='1' AND `IdPedido`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function InsertPedidosActiEspecialTransAx($id, $agencia) {
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`,`IdDocumento`,`CodigoAgencia`,`EstadoTransaccion`) VALUES ('1','$id','$agencia','0')";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getDiasPlazo($diasplazo) {
        $sql = "SELECT COUNT(*) dias FROM `condicionespago` WHERE Dias='$diasplazo'";
        return Multiple::multiConsulta($sql);
    }

    public function getInformacionNotasCredito($agencia, $grupoventas, $tipoUsuario, $proveedor = '') {        
        if ($tipoUsuario == 1) {
            $sql = "SELECT notas.*,asesores.Nombre,conceptos.CodigoConceptoNotaCredito,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente,factu.NumeroFactura,prov.NombreCuentaProveedor,ag.Nombre as agencia,gv.NombreGrupoVentas,ag.CodAgencia,gv.CodigoGrupoVentas FROM `notascredito` notas
        LEFT JOIN asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
        LEFT JOIN conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
        LEFT JOIN facturasaldo factu on notas.Factura=factu.NumeroFactura
        LEFT JOIN clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
        LEFT JOIN cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        LEFT JOIN zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
        LEFT JOIN gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        LEFT JOIN agencia ag on ag.CodAgencia=gv.CodAgencia 
        LEFT JOIN proveedores prov on notas.Fabricante=prov.CodigoCuentaProveedor
        WHERE ag.CodAgencia='$agencia' AND gv.CodigoGrupoVentas='$grupoventas' AND notas.Estado='1' AND notas.Autoriza='0' AND notas.Fabricante='' 
        GROUP BY notas.`IdNotaCredito`";
        } else {
            $sql = "SELECT notas.*,asesores.Nombre,conceptos.CodigoConceptoNotaCredito,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente,factu.NumeroFactura,prov.NombreCuentaProveedor,ag.Nombre as agencia,gv.NombreGrupoVentas,ag.CodAgencia,gv.CodigoGrupoVentas FROM `notascredito` notas
        LEFT JOIN asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
        LEFT JOIN conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
        LEFT JOIN facturasaldo factu on notas.Factura=factu.NumeroFactura
        LEFT JOIN clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
        LEFT JOIN cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        LEFT JOIN zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
        LEFT JOIN gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        LEFT JOIN agencia ag on ag.CodAgencia=gv.CodAgencia 
        LEFT JOIN proveedores prov on notas.Fabricante=prov.CodigoCuentaProveedor
        WHERE ag.CodAgencia='$agencia' AND gv.CodigoGrupoVentas='$grupoventas' AND notas.Estado='1' AND notas.Autoriza='0' AND notas.Fabricante='$proveedor'
        GROUP BY notas.`IdNotaCredito`";
        }
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getInformacionNotasCreditoAdminCarter($agencia, $grupoventas) {
        $sql = "SELECT notas.*,asesores.Nombre,conceptos.CodigoConceptoNotaCredito,conceptos.NombreConceptoNotaCredito,factu.ValorNetoFactura,cli.NombreCliente,factu.NumeroFactura,prov.NombreCuentaProveedor,ag.Nombre as agencia,gv.NombreGrupoVentas,ag.CodAgencia,gv.CodigoGrupoVentas FROM `notascredito` notas
        JOIN asesorescomerciales asesores on notas.CodAsesor=asesores.CodAsesor
        JOIN conceptosnotacredito conceptos on notas.Concepto=conceptos.CodigoConceptoNotaCredito
        JOIN facturasaldo factu on notas.Factura=factu.NumeroFactura
        JOIN clienteruta cliruta on notas.CuentaCliente=cliruta.CuentaCliente
        JOIN cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        JOIN zonaventas zv on zv.CodZonaVentas=notas.CodZonaVentas
        JOIN gruposventas gv on zv.CodigoGrupoVentas=gv.CodigoGrupoVentas
        JOIN agencia ag on ag.CodAgencia=gv.CodAgencia 
        JOIN proveedores prov on notas.Fabricante=prov.CodigoCuentaProveedor
        WHERE ag.CodAgencia='$agencia' AND gv.CodigoGrupoVentas='$grupoventas' AND notas.Estado='3' AND notas.Autoriza='0'
        GROUP BY notas.`IdNotaCredito`";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function UpdateAutorizarNotaCredito($id, $agencia, $user, $fecha, $hora) {
        $sql = "UPDATE `notascredito` SET `Estado`='0',`Autoriza`='1',QuienAutoriza='$user',FechaAutorizacion='$fecha',HoraAutorizacion='$hora' WHERE `IdNotaCredito`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function UpdateAutorizarNotaCreditoAdminCartera($id, $agencia, $user, $fecha, $hora) {
        $sql = "UPDATE `notascredito` SET `Estado`='0',`Autoriza`='1',`AutorizaCartera`='1',QuienAutoriza='$user',FechaAutorizacion='$fecha',HoraAutorizacion='$hora' WHERE `IdNotaCredito`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function UpdateRechazarNotaCredito($id, $comentario, $agencia, $user, $fecha, $hora) {
        $sql = "UPDATE `notascredito` SET `Estado`='2',`Autoriza`='2',`Comentario`='$comentario',QuienAutoriza='$user',FechaAutorizacion='$fecha',HoraAutorizacion='$hora' WHERE `IdNotaCredito`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function UpdateRechazarNotaCreditoAdminCartera($id, $comentario, $agencia, $user, $fecha, $hora) {
        $sql = "UPDATE `notascredito` SET `Estado`='2',`Autoriza`='2',`AutorizaCartera`='1',`Comentario`='$comentario',QuienAutoriza='$user',FechaAutorizacion='$fecha',HoraAutorizacion='$hora' WHERE `IdNotaCredito`='$id'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function InsertTransaccionesNotasCredito($id, $agencia) {
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`,`IdDocumento`,`CodigoAgencia`,`EstadoTransaccion`) VALUES ('7','$id','$agencia','0')";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function InsertMensajeNotasCredito($remitente, $zona, $fecha, $hora, $Mensaje, $asesor, $agencia) {
        $sql = "INSERT INTO `mensajes`(`IdDestinatario`,`IdRemitente`,`FechaMensaje`,`HoraMensaje`,`Mensaje`,`Estado`,`CodAsesor`) VALUES ('$zona','$remitente','$fecha','$hora','$Mensaje','0','$asesor')";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function Detallefactura($numerofactura) {
        $sql = "SELECT factur.NumeroFactura,factur.FechaFactura,cli.NombreCliente,factur.ValorNetoFactura,factusaldoDeta.CodigoVariante,porta.NombreArticulo,prove.CodigoCuentaProveedor,prove.NombreCuentaProveedor,factusaldoDeta.ValorNetoArticulo,factusaldoDeta.CantidadFacturada FROM `facturasaldodetalle` as factusaldoDeta 
        JOIN facturasaldo factur on factusaldoDeta.NumeroFactura=factur.NumeroFactura 
        LEFT JOIN cliente cli on factur.CuentaCliente=cli.CuentaCliente 
        JOIN portafolio porta on factusaldoDeta.CodigoArticulo=porta.CodigoArticulo 
        JOIN proveedores prove on factusaldoDeta.CuentaProveedor=prove.CodigoCuentaProveedor 
        WHERE factur.NumeroFactura='$numerofactura' group by porta.CodigoArticulo";
        return Multiple::multiConsultaQuery($sql);
    }

    Public function getConuntTransaccionesAx($id, $agencia) {
        $sql = "SELECT COUNT(*) as existe FROM `transaccionesax` WHERE IdDocumento='$id' AND CodigoAgencia='$agencia' AND IdDocumento<>''";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosAltipal($id, $agencia) {
        $sql = "SELECT COUNT(*) descripcionssinaprobarAltipal FROM `pedidos` p JOIN descripcionpedido dp on p.IdPedido=dp.IdPedido WHERE p.IdPedido='$id' AND (dp.DsctoEspecialAltipal>0 or p.Estado='2') ";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosAprovadosActividaEspecial($id, $agencia) {
        $sql = "SELECT COUNT(*) as pedidoaprovadoActividaEspecial FROM `pedidos` p JOIN descripcionpedido dp on p.IdPedido=dp.IdPedido WHERE p.Estado='2' AND p.IdPedido='$id'";
        return Multiple::consultaAgenciaRow($agencia, $sql);
    }

    public function getPedidosProveedor($id, $agencia) {
        $sql = "SELECT COUNT(*) AS productosaenviarProveedor FROM `descripcionpedido` WHERE IdPedido='$id' AND DsctoEspecialProveedor>0";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosCompartido($id, $agencia) {
        $sql = "SELECT COUNT(*) AS productosaenviarCompatidos FROM `descripcionpedido` WHERE IdPedido='$id' AND DsctoEspecialProveedor>0 AND DsctoEspecialAltipal>0";
        return Multiple::consultaAgenciaRow($agencia, $sql);
    }

    public function getPedidosAprovados($id, $agencia) {
        $sql = "SELECT COUNT(*) AS productosaenviar FROM `aprovacionpedido` WHERE IdPedido='$id'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosAprovadosCompartidos($id, $agencia) {
        $sql = "SELECT COUNT(*) AS productosaenviar FROM `aprovacionpedido` WHERE IdPedido='$id' AND `EstadoRevisadoAltipal`>0 AND `EstadoRevisadoProveedor`>0;";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getDinamicas($agencia, $proveedor) {
        $sql = "SELECT * FROM `dinamicascomerciales` WHERE CodigoProveedor='$proveedor' AND Saldo>0";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getValoresDinamicas($agencia, $coddimencion) {
        $sql = "SELECT * FROM `dinamicascomerciales` WHERE Codigo='$coddimencion'";
        return Multiple::consultaAgenciaRow($agencia, $sql);
    }

    public function getUpdateSaldoDinamica($CodDinamica, $valordinamica, $agencia) {
        $sql = "UPDATE `dinamicascomerciales` SET Saldo='$valordinamica' WHERE Codigo='$CodDinamica'";
        //$dataReader=Multiple::queryAgencia($agencia,$sql);
        return Multiple::multiQuery($sql);
    }

    public function getUpdateDescripcionPedidoDinamca($idDescripcionPedido, $CodDinamica, $agencia) {
        $sql = "UPDATE descripcionpedido SET CodigoDinamica='$CodDinamica' WHERE Id='$idDescripcionPedido'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getUpdateNotaDinamica($idNotas, $CodDinamica, $agencia) {
        $sql = "UPDATE notascredito SET CodigoDinamica='$CodDinamica' WHERE IdNotaCredito='$idNotas'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getDetalleAprobado($idDescripcionPedido, $agencia) {
        $sql = "SELECT COUNT(*) as ProductoAprobado FROM `aprovacionpedido` WHERE IdDetallePedido='$idDescripcionPedido'";
        return Multiple::consultaAgenciaRow($agencia, $sql);
    }

}
