<?php

class WebMobile extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

       public function getDatosZonaVentas($zonaVentas,$agencia) {

        $connection = new Multiple();
        $sql = "SELECT 
                        z.`CodZonaVentas`,
                        z.`NombreZonadeVentas`,
                        ac.Nombre,
                        ac.TelefonoMovilEmpresarial
                        FROM `zonaventas` z
                        INNER JOIN asesorescomerciales  ac ON z.CodAsesor=ac.CodAsesor
                        WHERE z.`CodZonaVentas`='$zonaVentas'";
        $dataReader = $connection->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getDatosCliente($cuentaCliente,$agencia) {

        $connection = new Multiple();
        $sql = "SELECT 
                        c.`CuentaCliente`,
                        c.NombreCliente,
                        c.NombreBusqueda,
                        c.DireccionEntrega,
                        c.CorreoElectronico,
                        c.Identificacion
                        FROM `cliente` c 
                        WHERE c.CuentaCliente='$cuentaCliente'";

        $dataReader = $connection->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getFacturasProvicional($zonaVentas, $cuentaCliente, $provisional) {

        $connection = Multiple::getConexionZonaVentas();
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

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        // Se el arreglo con toda la informaci�n
        return $dataReader;
    }

    public function getValorFacturaEfectivo($id) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT `Valor` FROM `recibosefectivo` WHERE `IdReciboCajaFacturas`='$id'";

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        // Se el arreglo con toda la informaci�n
        return $dataReader;
    }

    public function getValorFacturaEfectivoConsignacion($id) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT SUM(`Valor`) AS `Valor` FROM `recibosefectivoconsignacion` WHERE `IdReciboCajaFacturas`='$id'";

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        // Se el arreglo con toda la informaci�n
        return $dataReader;
    }

    public function getValorFacturaChequeConsignacion($id) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                    SUM(rccd.Valor) as Valor
                    FROM
                    `reciboschequeconsignacion` rcc
                    LEFT JOIN reciboschequeconsignaciondetalle rccd ON rccd.IdRecibosChequeConsignacion=rcc.Id	
                    WHERE `IdReciboCajaFacturas`='$id'";

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        // Se el arreglo con toda la informaci�n
        return $dataReader;
    }

    public function getValorFacturaCheque($id) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT SUM(`Valor`) as `Valor` FROM `reciboscheque` WHERE `IdReciboCajaFacturas`='$id'";

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        // Se el arreglo con toda la informaci�n
        return $dataReader;
    }

    public function getIdPedidoFactura($factura,$agencia){
        
        $connection = new Multiple();
        $sql = "SELECT IdPedido
        FROM  `pedidos` 
        WHERE NroFactura =  '$factura'";
        $dataReader = $connection->consultaAgencia($agencia, $sql);
        return $dataReader;
        
    }
    
    public function getPedidosFactura($idPedido,$agencia){
        
        $connection = new Multiple();
        $sql = "SELECT * FROM `pedidos` p join descripcionpedido as  dp on p.`IdPedido`=dp.IdPedido  WHERE  p.IdPedido = '$idPedido'";
        $dataReader = $connection->consultaAgencia($agencia, $sql);
        return $dataReader;   
        
    }
    
    
}
