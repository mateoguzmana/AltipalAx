<?php

class Transmisiondocumentos extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {

        return parent::model($className);
    }

    public function getDatosPedido($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;
        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) as conteo, SUM(ValorPedido) as Suma FROM `pedidos` WHERE FechaPedido BETWEEN '$fecha' AND '$fechafinal' AND CodZonaVentas = '$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosPedidoDetallado($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();


        $connection = $this->getConexionZonaVentas($zonaVentas);

        $sql = "SELECT c.NombreCliente,p.HoraDigitado,p.ValorPedido,p.FormaPago FROM pedidos  p,cliente c WHERE p.CuentaCliente = c.CuentaCliente AND p.FechaPedido BETWEEN '$fecha' AND '$fechafinal' AND p.CodZonaVentas = '$zonaVentas'";
        //echo  $sql;
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosReciboCaja($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT c.NombreCliente,rc.Fecha,rc.Hora FROM reciboscaja rc,cliente c WHERE  rc.Fecha BETWEEN '$fecha' AND '$fechafinal' AND rc.ZonaVenta = '$zonaVentas' AND c.CuentaCliente = rc.CuentaCliente";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosNotacredito($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);


        $sql = "SELECT c.NombreCliente,nc.Fecha,nc.hora,nc.Valor,nc.Factura FROM notascredito nc,cliente c WHERE  nc.Fecha BETWEEN '$fecha' AND '$fechafinal' AND nc.CodZonaVentas = '$zonaVentas' AND c.CuentaCliente = nc.CuentaCliente";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosClienteNuevo($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();
       
        $connection = $this->getConexionZonaVentas($zonaVentas);


        $sql = "SELECT cn.CuentaCliente,cn.Nombre,cn.FechaRegistro,cn.HoraRegistro FROM clientenuevo cn,cliente c WHERE  cn.FechaRegistro BETWEEN '$fecha' AND '$fechafinal' AND cn.CodZonaVentas = '$zonaVentas' AND c.CuentaCliente = cn.CuentaCliente";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosDevolucion($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();
        
        $connection = $this->getConexionZonaVentas($zonaVentas);

        $sql = "SELECT c.NombreCliente,d.FechaDevolucion,d.HoraInicio,d.ValorDevolucion FROM devoluciones d,cliente c WHERE  d.FechaDevolucion BETWEEN '$fecha' AND '$fechafinal' AND d.CodZonaVentas = '$zonaVentas' AND c.CuentaCliente = d.CuentaCliente";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosNorecaudado($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();


        $connection = $this->getConexionZonaVentas($zonaVentas);

        $sql = "SELECT c.NombreCliente,nr.Fecha,nr.FechaProximaVisita,nr.Hora  FROM norecaudos nr,cliente c WHERE  nr.Fecha BETWEEN '$fecha' AND '$fechafinal' AND nr.CodZonaVentas = '$zonaVentas' AND nr.CuentaCliente = c.CuentaCliente";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosNovisita($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);

        $sql = "SELECT c.NombreCliente,mn.Nombre,n.HoraNoVenta,n.FechaNoVenta FROM noventas n,cliente c,motivosnoventa mn WHERE  n.FechaNoVenta BETWEEN '$fecha' AND '$fechafinal' AND n.CodZonaVentas = '$zonaVentas' AND c.CuentaCliente = n.CuentaCliente AND mn.CodMotivoNoVenta = n.CodMotivoNoVenta";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosPedidoPendiente($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS Conteo, SUM(p.ValorPedido) as valor FROM `descripcionpedido` d, pedidos p WHERE d.IdPedido = p.IdPedido AND (d.DsctoEspecialAltipal > 0 OR d.DsctoEspecialProveedor > 0) AND p.FechaPedido BETWEEN '$fecha' AND '$fechafinal' AND p.CodZonaVentas = '$zonaVentas' AND p.ArchivoXml = ''
";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
        public function getDatosDetallePedidoPendiente($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT c.NombreCliente,p.HoraDigitado,p.ValorPedido,p.FormaPago FROM `descripcionpedido` d, pedidos p INNER JOIN cliente AS c ON p.CuentaCliente = c.CuentaCliente WHERE d.IdPedido = p.IdPedido AND (d.DsctoEspecialAltipal > 0 OR d.DsctoEspecialProveedor > 0) AND p.FechaPedido BETWEEN '$fecha' AND '$fechafinal' AND p.CodZonaVentas = '$zonaVentas' AND p.ArchivoXml = ''";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosRecibo($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(DISTINCT(r.Id)) AS conteo,SUM(f.ValorAbono) AS valor FROM `reciboscaja` r, reciboscajafacturas f WHERE r.Id = f.IdReciboCaja  AND r.ZonaVenta = '$zonaVentas' AND r.Fecha BETWEEN '$fecha' AND '$fechafinal'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosConsigvendedor($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);

        $sql = "SELECT ac.Nombre,cv.FechaConsignacion,cv.Banco,cv.ValorConsignadoEfectivo,cv.ValorConsignadoCheque FROM consignacionesvendedor cv,asesorescomerciales ac WHERE  cv.FechaConsignacion BETWEEN '$fecha' AND '$fechafinal' AND cv.CodZonaVentas = '$zonaVentas' AND cv.CodAsesor = ac.CodAsesor";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDatosDevoluciones($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS conteo,SUM(ValorDevolucion) as valor FROM `devoluciones` WHERE FechaDevolucion BETWEEN '$fecha' AND '$fechafinal' AND CodZonaVentas = '$zonaVentas'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosNotas($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS conteo,SUM(Valor) as valor FROM `notascredito` WHERE CodZonaVentas = '$zonaVentas' AND Fecha BETWEEN '$fecha' AND '$fechafinal'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosClientesNuevos($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();


        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS conteo, 'N/A' AS valor FROM `clientenuevo` WHERE FechaRegistro BETWEEN '$fecha' AND '$fechafinal' AND CodZonaVentas = '$zonaVentas'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosNoVisitas($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();


        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS conteo, 'N/A' as valor FROM `noventas` WHERE CodZonaVentas = '$zonaVentas' AND FechaNoVenta BETWEEN '$fecha' AND '$fechafinal'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosConsignacion($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();


        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS conteo, (SUM(ValorConsignadoEfectivo)+SUM(ValorConsignadoCheque)) as valor FROM `consignacionesvendedor` WHERE CodZonaVentas = '$zonaVentas' AND FechaConsignacion BETWEEN '$fecha' AND '$fechafinal'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDatosNoRecaudos($fecha, $fechafinal, $zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();

        $connection = $this->getConexionZonaVentas($zonaVentas);
        $sql = "SELECT COUNT(*) AS conteo,'N/A' as valor FROM `norecaudos` WHERE Fecha BETWEEN '$fecha' AND '$fechafinal' AND CodZonaVentas = '$zonaVentas'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getRutero() {



        $session = new CHttpSession;
        $session->open();
        $zonaVentas = $session['_zonaVentas'];


        $connection = $this->getConexionZonaVentas($zonaVentas);


        $sql = "SELECT fv.*,cr.CodZonaVentas,cr.CuentaCliente,c.NombreCliente,c.DireccionEntrega,c.Telefono,c.TelefonoMovil,CONCAT (l.NombreBarrio,' - ',l.NombreCiudad) NombreBarrio,(cr.ValorCupo + cr.ValorCupoTemporal) Valorcupo FROM clienteruta cr,cliente c,frecuenciavisita fv,Localizacion l WHERE cr.CuentaCliente = c.CuentaCliente AND cr.NumeroVisita = fv.NumeroVisita AND cr.CodZonaVentas = '" . $zonaVentas . "' AND l.CodigoBarrio = c.CodigoBarrio GROUP BY cr.CuentaCliente";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    function getBuscarCoordenadas($vendedor, $cliente) {



        $session = new CHttpSession;
        $session->open();
        $zonaVentas = $session['_zonaVentas'];
        $connection = $this->getConexionZonaVentas($zonaVentas);

        $sql = "SELECT Latitud,Longitud FROM  cliente WHERE  CuentaCliente =  '$cliente'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    function getConexionZonaVentas($zonaVentas) {

        $connection = Yii::app()->db;

        $session = new CHttpSession;
        $session->open();
        $sql = "SELECT * FROM  `zonaventasglobales` WHERE  `CodZonaVentas` =  '$zonaVentas'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();



        $Agencia = $dataReader['CodAgencia'];

        if ($Agencia == '001') {
            return Yii::app()->Apartado;
        }

        if ($Agencia == '002') {
            return Yii::app()->Bogota;
        }

        if ($Agencia == '003') {
            return Yii::app()->Cali;
        }

        if ($Agencia == '004') {
            return Yii::app()->Duitama;
        }

        if ($Agencia == '005') {
            return Yii::app()->Ibague;
        }

        if ($Agencia == '006') {
            return Yii::app()->Medellin;
        }

        if ($Agencia == '007') {
            return Yii::app()->Monteria;
        }

        if ($Agencia == '008') {
            return Yii::app()->Pasto;
        }

        if ($Agencia == '009') {
            return Yii::app()->Pereira;
        }

        if ($Agencia == '010') {
            return Yii::app()->Popayan;
        }

        if ($Agencia == '011') {
            return Yii::app()->Villavicencio;
        }
    }

}
