<?php

class ConsignacionVendedor extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function InsertarConsignacion($codzona, $codasesor, $numeroconsignacion, $banco, $codBanco, $cuenta, $fecha, $valorefectivo, $valorcheque, $oficina, $ciudad) {

        $session = new CHttpSession;
        $session->open();

        $CodigoCanal = $session['canalEmpleado'];
        $Responsable = $session['Responsable'];

        $connection = Multiple::getConexionZonaVentas();
        //print_r($connection);
        //$connection = Yii::app()->db;

        $sql = "INSERT INTO consignacionesvendedor "
                . "(CodZonaVentas,"
                . "CodAsesor,"
                . "FechaConsignacion,"
                . "HoraConsignacion,"
                . "NroConsignacion,"
                . "Banco,"
                . "IdentificadorBanco,"
                . "CuentaConsignacion,"
                . "FechaConsignacionVendedor,"
                . "ValorConsignadoEfectivo,"
                . "ValorConsignadoCheque,"
                . "Oficina,"
                . "Ciudad,"
                . "IdentificadorEnvio,"
                . "Estado,"
                . "Web, CodigoCanal, Responsable"
                . ") "
                . "VALUES ("
                . "'$codzona',"
                . "'$codasesor',"
                . "CURDATE(),"
                . "CURTIME(),"
                . "'$numeroconsignacion',"
                . "'$banco',"
                . "'$codBanco',"
                . "'$cuenta',"
                . "'$fecha',"
                . "'$valorefectivo',"
                . "'$valorcheque',"
                . "'$oficina',"
                . "'$ciudad',"
                . "'1',"
                . "'0',"
                . "'1', '$CodigoCanal', '$Responsable')";

        $command = $connection->createCommand($sql);
        $dataReader = $command->query();

        $id = $connection->getLastInsertID('consignacionesvendedor');

        return $id;
    }

    public function InserTransaccinAx($id, $codagencia) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "INSERT INTO `transaccionesax`(`CodTipoDocumentoActivity`, `IdDocumento`, `CodigoAgencia`, `EstadoTransaccion`) VALUES ('5','$id','$codagencia','0') ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function Asesor($zonaVentas) {


        $connection = Multiple::getConexionZonaVentas();
        $sql = " SELECT `CodAsesor` FROM `zonaventas` WHERE `CodZonaVentas` = '$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function Consignaciones($zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT consig.NroConsignacion,consig.Estado,consig.IdConsignacion,consig.CodZonaVentas,consig.CodAsesor,ban.Nombre,consig.FechaConsignacionVendedor,consig.ValorConsignadoEfectivo,consig.ValorConsignadoCheque,consig.Oficina,consig.Ciudad,cuentas.NumeroCuentaBancaria FROM consignacionesvendedor  consig join bancos ban on consig.Banco=ban.CodBanco join cuentasbancarias cuentas on ban.CodBanco=cuentas.CodBanco WHERE consig.CodZonaVentas = '$zonaVentas'  and consig.ArchivoXml = '' Group by consig.IdConsignacion";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function DeleteConsignacion($idconsignacion) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "DELETE FROM `consignacionesvendedor` WHERE `IdConsignacion` = '$idconsignacion' and  `Estado` = '' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function Valor($zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT SUM(`ValorAbono`) as valorrecaudado  FROM `reciboscajafacturas` WHERE `IdReciboCaja` IN (SELECT DISTINCT(`Id`) FROM `reciboscaja` WHERE `ZonaVenta` = '$zonaVentas' AND `IdentificadorEnvio` = 0 AND `Estado` = '')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function sumacheque($zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT SUM(Valor) AS total_cheque_posfechado FROM reciboscheque reciche join reciboscajafacturas recfactu on reciche.IdReciboCajaFacturas=recfactu.Id join reciboscaja reccaja on recfactu.IdReciboCaja=reccaja.Id WHERE reciche.Posfechado = '1' AND reccaja.ZonaVenta = '$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function ConsultarBancos($IdentificadorBanco, $codbanco) {


        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT count(*) as banco FROM `bancos` where IdentificadorBanco = '$IdentificadorBanco' and `CodBanco` = '$codbanco' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function Cosignaciones($zona) {

        $connection = Multiple::getConexionZonaVentas($zona);
        $sql = "SELECT * FROM `consignacionesvendedor` where Estado = '' AND CodZonaVentas = '$zona'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function CosignacionesUpdate($Id) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "UPDATE `consignacionesvendedor` SET  `ArchivoXml` =  'Archivoxml' , `Estado` = '1' WHERE `IdConsignacion` = '$Id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function UpdateConsignacionVendedorTerminarRuta($zona, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `consignacionesvendedor` SET IdentificadorEnvio='1' WHERE CodZonaVentas = '$zona' AND FechaConsignacion = CURDATE() AND IdentificadorEnvio='0'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getInfoJerarquiaComercial($asesor, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT CodigoCanal FROM `jerarquiacomercial` WHERE NumeroIdentidad = '$asesor'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getRecibosCajas($zona, $fechaini, $fechafin, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `reciboscaja` WHERE `ZonaVenta` = '$zona' and Fecha between '$fechaini' and '$fechafin'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getCajaFactura($idCaja, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `reciboscajafacturas` where IdReciboCaja = '$idCaja'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getEfectivo($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT `Valor` as Valor FROM `recibosefectivo` where IdReciboCajaFacturas = '$idCajaFactura'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getCheque($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT `ValorTotal` as Cheque FROM `reciboscheque` where IdReciboCajaFacturas = '$idCajaFactura' AND Posfechado = '0'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getChequePosfechado($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT `ValorTotal` as ChequePosfechado FROM `reciboscheque` where IdReciboCajaFacturas = '$idCajaFactura' AND Posfechado = '1'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getConsignacionEfectivo($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT `ValorTotal` as EfectivoConsignacion FROM `recibosefectivoconsignacion` where IdReciboCajaFacturas = '$idCajaFactura'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getConsignacioChequen($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT rcChecongDetall.`ValorTotal` as ConsignacionCheque FROM `reciboschequeconsignacion` rcChecong join `reciboschequeconsignaciondetalle` rcChecongDetall on rcChecong.Id=rcChecongDetall.IdRecibosChequeConsignacion WHERE rcChecong.IdReciboCajaFacturas = '$idCajaFactura'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getRecibosCajasWeb($zona, $fecha, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `reciboscaja` WHERE `ZonaVenta` = '$zona' and Fecha = '$fecha' AND Web = '1'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getChequeDeldia($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT NroCheque, CodBanco, CuentaCheque, Fecha, ValorTotal, Girado, Otro FROM `reciboscheque` where IdReciboCajaFacturas = '$idCajaFactura' AND Posfechado = '0'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getSumaEfectivo($idCajaFactura, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `recibosefectivo` where IdReciboCajaFacturas = '$idCajaFactura'";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getSumaEfectivoConsgnados($zonaVentas, $agencia, $fecha) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(ValorConsignadoEfectivo) as valorEfect FROM `consignacionesvendedor` WHERE CodZonaVentas = '$zonaVentas' AND FechaConsignacion = '$fecha'";
        //echo $sql. "   -   ".$agencia. "   -   ";
        
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        
       // print_r($dataReader);
        return $dataReader;
    }

    public function ConsultarBancosCheques($IdentificadorBanco) {


        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT Nombre FROM `bancos` where IdentificadorBanco = '$IdentificadorBanco';";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function InsertarChequesConsignacion($Agencia, $numero, $banco, $cuenta, $fecha, $girado, $otro, $valor) {

        $connection = Multiple::getConexionZonaVentas();
        //print_r($connection);
        //$connection = Yii::app()->db;

        $sql = "INSERT INTO `consignacionchequesvendedor`( `IdConsignacionVendedor`, `NroCheque`, `CodBanco`, `CuentaCheque`, `Fecha`,Girado,Otro,`Valor`) VALUES ('" . $Agencia . "','" . $numero . "','" . $banco . "','" . $cuenta . "','" . $fecha . "','" . $girado . "','" . $otro . "','" . $valor . "');";
        echo $sql;
        
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();

        return "ok";
    }
    
        public function ContarChequesdelDia($numerCheque,$IdentificadorBanco) {
            
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT COUNT(*) AS cont FROM `consignacionchequesvendedor` WHERE NroCheque = '$numerCheque' AND CodBanco = '$IdentificadorBanco';";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

}
