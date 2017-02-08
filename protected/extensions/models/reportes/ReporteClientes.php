<?php

class ReporteClientes extends CActiveRecord {

    public static function model($className = __CLASS__) {
         Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getAgencias($cedula) {


        $connection = Yii::app()->db;
        $sql = "SELECT DISTINCT(ca.CodAgencia) as CodAgencia,agen.Nombre FROM `administrador` a
        Inner JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
        Inner JOIN agencia as agen on ca.CodAgencia=agen.CodAgencia WHERE `Cedula`='$cedula'";
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

    public function getGraficaClientes() {

        $consulta = new Multiple();
        $sql = "SELECT SUM(SaldoFactura)as total_deuda,cli.NombreCliente FROM `facturasaldo` as fac 
        join cliente as cli on fac.CuentaCliente=cli.CuentaCliente
        WHERE fac.FechaVencimientoFactura < CURDATE() GROUP BY cli.NombreCliente ORDER BY total_deuda  DESC LIMIT 10";
        $dataReader=  $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    public function getGraficaNoVentas() {

        $consulta = new Multiple();
        $sql = "  SELECT motinove.Nombre,COUNT(DISTINCT(nov.CuentaCliente)) AS total_clientes_noventas FROM `noventas` as nov
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta
        where nov.FechaNoVenta = CURDATE() GROUP BY motinove.CodMotivoNoVenta ";
        $dataReader=  $consulta->multiConsulta($sql);
        return $dataReader;
    }

    public function getGraficaNotasCredito() {

        $consulta = new Multiple();
        $sql = " SELECT SUM(nota.valor) as total_notascredito,concep.NombreConceptoNotaCredito FROM `notascredito` as nota 
        join conceptosnotacredito as concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
        WHERE nota.Fecha = CURDATE() GROUP BY concep.CodigoConceptoNotaCredito ORDER BY total_notascredito DESC ";
        $dataReader=  $consulta->multiConsultaQuery($sql); 
        return $dataReader;
    }

    public function getGraficaNotasCreditoxZona($fecha, $ZonaVentas,$agencia) {

        $consulta = new Multiple();
        $sql = " SELECT SUM(nota.valor) as total_notascredito,concep.NombreConceptoNotaCredito FROM `notascredito` as nota 
        join conceptosnotacredito as concep on nota.Concepto=concep.CodigoConceptoNotaCredito
        WHERE nota.Fecha = '$fecha' AND nota.CodZonaVentas = '$ZonaVentas'  
        GROUP BY concep.CodigoConceptoNotaCredito ORDER BY total_notascredito DESC ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNoVentasXZona($fecha, $ZonaVentas,$agencia) {

        $consulta = new Multiple();
        $sql = " SELECT motinove.Nombre,COUNT(DISTINCT(nov.CuentaCliente)) AS total_clientes_noventas FROM `noventas` as nov
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta
        where nov.FechaNoVenta = '$fecha' AND nov.CodZonaVentas = '$ZonaVentas' GROUP BY motinove.CodMotivoNoVenta ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaclientesCarteraVenciadaXZona($fecha, $ZonaVentas,$agencia) {

        $consulta = new Multiple();
        $sql = " SELECT SUM(SaldoFactura)as total_deuda,cli.NombreCliente FROM `facturasaldo` as fac 
        join cliente as cli on fac.CuentaCliente=cli.CuentaCliente
        WHERE fac.FechaVencimientoFactura < '$fecha' AND fac.CodigoZonaVentas = '$ZonaVentas'
        GROUP BY cli.NombreCliente ORDER BY total_deuda  DESC LIMIT 10";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNotasCreditoxGrupo($fecha,$grupo,$agencia) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(nota.valor) as total_notascredito,concep.NombreConceptoNotaCredito FROM `notascredito` as nota 
        join conceptosnotacredito as concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
        join zonaventas as  zv on nota.CodZonaVentas=zv.CodZonaVentas 
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas  
        WHERE nota.Fecha = '$fecha' AND gr.CodigoGrupoVentas = '$grupo'  
        GROUP BY concep.CodigoConceptoNotaCredito ORDER BY total_notascredito DESC";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNoVentasXGrupo($fecha,$grupo,$agencia) {

        $consulta = new Multiple();
        $sql = "SELECT motinove.Nombre,COUNT(DISTINCT(nov.CuentaCliente)) AS total_clientes_noventas FROM `noventas` as nov 
	join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
	join zonaventas zv on nov.CodZonaVentas=zv.CodZonaVentas
	join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
	where nov.FechaNoVenta = '$fecha' AND gr.CodigoGrupoVentas = '$grupo' GROUP BY motinove.CodMotivoNoVenta  
	";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaclientesCarteraVenciadaXGrupo($fecha,$grupo,$agencia) {

        $consulta = new Multiple();
        $sql = " SELECT SUM(SaldoFactura)as total_deuda,cli.NombreCliente FROM `facturasaldo` as fac 
	join cliente as cli on fac.CuentaCliente=cli.CuentaCliente 
	join zonaventas as zv on zv.CodZonaVentas=fac.CodigoZonaVentas 
	join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
	WHERE fac.FechaVencimientoFactura < '$fecha' AND gr.CodigoGrupoVentas = '$grupo' 
	GROUP BY cli.NombreCliente ORDER BY total_deuda DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNotasCreditoxFecha($fecha,$agencia) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(nota.valor) as total_notascredito,concep.NombreConceptoNotaCredito FROM `notascredito` as nota 
        join conceptosnotacredito as concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
        WHERE nota.Fecha = '$fecha' GROUP BY concep.CodigoConceptoNotaCredito ORDER BY total_notascredito DESC   ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNoVentasXFecha($fecha,$agencia) {

        $consulta = new Multiple();
        $sql = "SELECT motinove.Nombre,COUNT(DISTINCT(nov.CuentaCliente)) AS total_clientes_noventas FROM `noventas` as nov 
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
        where nov.FechaNoVenta = '$fecha' GROUP BY motinove.CodMotivoNoVenta ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaclientesCarteraVenciadaXFecha($fecha,$agencia) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(SaldoFactura)as total_deuda,cli.NombreCliente FROM `facturasaldo` as fac 
        join cliente as cli on fac.CuentaCliente=cli.CuentaCliente
        WHERE fac.FechaVencimientoFactura < '$fecha' GROUP BY cli.NombreCliente ORDER BY total_deuda  DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNotasCreditoxCanal($fecha, $canal, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(nota.valor) as total_notascredito,concep.NombreConceptoNotaCredito FROM `notascredito` as nota 
        join conceptosnotacredito as concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
	WHERE nota.Fecha = '$fecha' AND nota.CodigoCanal = '$canal'
	GROUP BY concep.CodigoConceptoNotaCredito ORDER BY total_notascredito DESC ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNoVentasXCanal($fecha, $canal, $agencia) {

        $consulta = new Multiple();
        $sql = " SELECT motinove.Nombre,COUNT(DISTINCT(nov.CuentaCliente)) AS total_clientes_noventas FROM `noventas` as nov 
	join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta
	where nov.FechaNoVenta = '$fecha' AND nov.`CodigoCanal` = '$canal' GROUP BY motinove.CodMotivoNoVenta  ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaclientesCarteraVenciadaXCanal($fecha, $canal, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(SaldoFactura)as total_deuda,cli.NombreCliente FROM `facturasaldo` as fac 
        join cliente as cli on fac.CuentaCliente=cli.CuentaCliente 
        join zonaventas as zv on zv.CodZonaVentas=fac.CodigoZonaVentas 
        join jerarquiacomercial as jerar on zv.CodZonaVentas=jerar.CodigoZonaVentas 
        WHERE fac.FechaVencimientoFactura < '$fecha' AND jerar.CodigoCanal = '$canal' GROUP BY cli.NombreCliente ORDER BY total_deuda  DESC LIMIT 10 ";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNotasCreditoxAgencia($fecha, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT SUM(DISTINCT (nota.valor)) as total_notascredito,concep.NombreConceptoNotaCredito FROM `notascredito` as nota 
	join conceptosnotacredito as concep on nota.Concepto=concep.CodigoConceptoNotaCredito 
	join zonaventas as zv on nota.CodZonaVentas=zv.CodZonaVentas 
	join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
	join agencia as ag on gr.CodAgencia=ag.CodAgencia
	WHERE nota.Fecha = '$fecha' AND gr.CodAgencia = '$agencia' GROUP BY concep.CodigoConceptoNotaCredito ORDER BY total_notascredito DESC";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaNoVentasXAgencia($fecha, $agencia) {

        $consulta = new Multiple();
        $sql = "SELECT motinove.Nombre,COUNT(DISTINCT(nov.CuentaCliente)) AS total_clientes_noventas FROM `noventas` as nov 
	join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
	join zonaventas zv on nov.CodZonaVentas=zv.CodZonaVentas 
	join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
	join agencia as ag on gr.CodAgencia=ag.CodAgencia where nov.FechaNoVenta = '$fecha' AND ag.CodAgencia = '$agencia' GROUP BY motinove.CodMotivoNoVenta";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

    public function getGraficaclientesCarteraVenciadaXAgencia($fecha, $agencia) {

        $consulta = new Multiple();
        $sql = " SELECT SUM(SaldoFactura)as total_deuda,cli.NombreCliente FROM `facturasaldo` as fac 
	join cliente as cli on fac.CuentaCliente=cli.CuentaCliente 
	join zonaventas as zv on zv.CodZonaVentas=fac.CodigoZonaVentas 
	join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
	join agencia as ag on gr.CodAgencia=ag.CodAgencia WHERE fac.FechaVencimientoFactura < '$fecha' AND ag.CodAgencia = '$agencia' GROUP BY cli.NombreCliente ORDER BY total_deuda DESC LIMIT 10";
        $dataReader=  $consulta->consultaAgencia($agencia,$sql);
        return $dataReader;
    }

}
