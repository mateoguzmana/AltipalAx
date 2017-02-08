<?php

Yii::import('application.extensions.multiple.Multiple');

class WebMobile extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDatosZonaVentas($zonaVentas, $agencia) {
        $sql = "SELECT 
                    z.`CodZonaVentas`,
                    z.`NombreZonadeVentas`,
                    ac.Nombre,
                    ac.TelefonoMovilEmpresarial
                    FROM `zonaventas` z
                    INNER JOIN asesorescomerciales  ac ON z.CodAsesor=ac.CodAsesor
                    WHERE z.`CodZonaVentas`='$zonaVentas'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getDatosCliente($cuentaCliente, $agencia) {
        $sql = "SELECT 
                    c.`CuentaCliente`,
                    c.NombreCliente,
                    c.NombreBusqueda,
                    c.DireccionEntrega,
                    c.CorreoElectronico,
                    c.Identificacion
                    FROM `cliente` c 
                    WHERE c.CuentaCliente='$cuentaCliente'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getFacturasProvicional($zonaVentas, $cuentaCliente, $provisional) {
        $sql = "SELECT 
                    rc.Fecha,
                    rcf.Id,
                    rcf.NumeroFactura,
                    rcf.ValorAbono,
                    rcf.DtoProntoPago,
                    (SELECT `SaldoFactura` FROM `facturasaldo` WHERE `CuentaCliente`='$cuentaCliente' AND `NumeroFactura`=rcf.NumeroFactura) AS saldo 
                    FROM `reciboscaja` rc
                    LEFT JOIN reciboscajafacturas rcf ON rc.Id=rcf.IdReciboCaja  
                    WHERE rc.`ZonaVenta`='$zonaVentas' 
                    AND rc.`CuentaCliente`='$cuentaCliente'
                    AND rc.`Provisional`='$provisional'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getValorFacturaEfectivo($id) {
        $sql = "SELECT `Valor` FROM `recibosefectivo` WHERE `IdReciboCajaFacturas`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getValorFacturaEfectivoConsignacion($id) {
        $sql = "SELECT SUM(`Valor`) AS `Valor` FROM `recibosefectivoconsignacion` WHERE `IdReciboCajaFacturas`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getValorFacturaChequeConsignacion($id) {
        $sql = "SELECT SUM(rccd.Valor) as Valor FROM `reciboschequeconsignacion` rcc
                    LEFT JOIN reciboschequeconsignaciondetalle rccd ON rccd.IdRecibosChequeConsignacion=rcc.Id	
                    WHERE `IdReciboCajaFacturas`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getValorFacturaCheque($id) {
        $sql = "SELECT SUM(`Valor`) as `Valor` FROM `reciboscheque` WHERE `IdReciboCajaFacturas`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getIdPedidoFactura($factura, $agencia) {
        $sql = "SELECT IdPedido FROM `pedidos` WHERE NroFactura='$factura'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

    public function getPedidosFactura($idPedido, $agencia) {
        $sql = "SELECT * FROM `pedidos` p join descripcionpedido as dp on p.`IdPedido`=dp.IdPedido WHERE p.IdPedido='$idPedido'";
        return Multiple::consultaAgencia($agencia, $sql);
    }

}
