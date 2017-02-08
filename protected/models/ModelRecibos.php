<?php

class ModelRecibos extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getDatosZonaVentas($zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                        z.`CodZonaVentas`,
                        z.`NombreZonadeVentas`,
                        ac.Nombre,
                        ac.TelefonoMovilEmpresarial
                        FROM `zonaventas` z
                        INNER JOIN asesorescomerciales  ac ON z.CodAsesor=ac.CodAsesor
                        WHERE z.`CodZonaVentas`='$zonaVentas'";

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        // Se el arreglo con toda la informaci�n
        return $dataReader;
    }

    public function getDatosCliente($cuentaCliente) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                        c.`CuentaCliente`,
                        c.NombreCliente,
                        c.NombreBusqueda,
                        c.DireccionEntrega,
                        c.Telefono,
                        c.TelefonoMovil,
                        c.CorreoElectronico
                        FROM `cliente` c 
                        WHERE c.CuentaCliente='$cuentaCliente'";

        // Se prepara el query para ser ejecutado
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        // Se el arreglo con toda la informaci�n
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
                        (SELECT `SaldoFactura` FROM `facturasaldo` WHERE `CuentaCliente`='$cuentaCliente' AND `NumeroFactura`=rcf.NumeroFactura)-rcf.ValorAbono AS saldo

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

    public function getverificarBanco($codbanc) {

        $connection = Yii::app()->db;
        $sql = "SELECT COUNT(*) AS Bancos FROM `bancocheque` WHERE  CodigoBanco = '$codbanc'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getNombreBanaco($codbanc) {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `bancocheque` WHERE  CodigoBanco = '$codbanc'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function UpdateReciboTerminarRuta($zona, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `reciboscaja` SET IdentificadorEnvio='1' WHERE ZonaVenta = '$zona' AND Fecha = CURDATE() AND IdentificadorEnvio = '0'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }
    
    public function getFactuSaldo($NoFactura){
        
        try {
            
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT ValorNetoFactura,SaldoFactura FROM `facturasaldo` where NumeroFactura = '$NoFactura'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
            
        } catch (Exception $ex) {
            
            echo $ex->getMessage('Error');
        }
        
    }

}
