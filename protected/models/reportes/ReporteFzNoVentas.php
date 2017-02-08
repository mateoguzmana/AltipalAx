<?php

class ReporteFzNoVentas extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getZonaVentas($fechaini, $fechafin, $agencia) {
        $sql = "SELECT nov.CodZonaVentas,zv.NombreZonadeVentas FROM `noventas` as nov
        join zonaventas zv on nov.CodZonaVentas=zv.CodZonaVentas
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND`FechaNoVenta` BETWEEN '$fechaini' AND '$fechafin' GROUP BY CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasNotasCredito($fechaini, $fechafin, $agencia) {
        $sql = "SELECT notas.`CodZonaVentas`,zv.NombreZonadeVentas FROM `notascredito` AS notas 
        join zonaventas zv on notas.CodZonaVentas=zv.`CodZonaVentas`
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND notas.`Fecha` BETWEEN '$fechaini' AND '$fechafin' GROUP BY CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasTransCoinsignacion($fechaini, $fechafin, $agencia) {
        $sql = "SELECT transconsigna.`CodZonaVentas`,zv.NombreZonadeVentas FROM `transferenciaconsignacion` AS transconsigna 
        join zonaventas zv on transconsigna.CodZonaVentas=zv.`CodZonaVentas` 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND transconsigna.`FechaTransferencia` BETWEEN '$fechaini' AND '$fechafin' GROUP BY CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasConsignacionVeendedor($fechaini, $fechafin, $agencia) {
        $sql = "SELECT consig.`CodZonaVentas`,zv.NombreZonadeVentas FROM `consignacionesvendedor` AS consig 
        join zonaventas zv on consig.CodZonaVentas=zv.`CodZonaVentas`
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND consig.`FechaConsignacion` BETWEEN '$fechaini' AND '$fechafin' GROUP BY CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasTransAutoventa($fechaini, $fechafin, $agencia) {
        $sql = "SELECT transautoventa.`CodZonaVentas`,zv.NombreZonadeVentas FROM `transferenciaautoventa` AS transautoventa 
        join zonaventas zv on transautoventa.CodZonaVentas=zv.`CodZonaVentas` 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND transautoventa.`FechaTransferenciaAutoventa` BETWEEN '$fechaini' AND '$fechafin' GROUP BY CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleNoVenta($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleNotasCredito($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetalleFotosNotasCredito($id, $agencia) {
        $sql = "SELECT * FROM `notascreditofoto` WHERE IdNotaCredito='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleConsignacionVeendedor($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleTrnasferenciaConsig($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetalleTrnasferenciaConsig($id, $agencia) {
        $sql = "SELECT descrip.IdTransferencia,descrip.CodVariante,descrip.CodigoArticulo,descrip.NombreArticulo,descrip.Cantidad,acuerdos.NombreUnidadMedida FROM `descripciontransferenciaconsignacion` as descrip 
        left join acuerdoscomercialesprecioventa as acuerdos on descrip.CodVariante=acuerdos.CodigoVariante 
        WHERE descrip.IdTransferencia='$id' GROUP BY descrip.IdTransferencia,descrip.CodVariante";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleTrnasferenciaAutoventa($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetalleTrnasferenciaAutoventa($id, $agencia) {
        $sql = "SELECT * FROM `descripciontransferenciaautoventa` WHERE IdTransferenciaAutoventa='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getConsultarNombreZonaTransferir($zonaAtransferdia, $agencia) {
        $sql = " SELECT NombreZonadeVentas as NombreZonaVentasTransferida FROM `zonaventas` WHERE CodZonaVentas='$zonaAtransferdia'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasPedidos($fechaini, $fechafin, $agencia) {
        $sql = "SELECT pe.CodZonaVentas,zv.NombreZonadeVentas FROM `pedidos` AS pe 
        join zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
         WHERE ag.CodAgencia='$agencia' AND pe.FechaPedido BETWEEN '$fechaini' AND '$fechafin' GROUP BY pe.CodZonaVentas ";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasTerminarRuta($fechaini, $fechafin, $agencia) {
        $sql = "SELECT zv.CodZonaVentas,zv.NombreZonadeVentas FROM `mensajes` as msg
        join zonaventas as zv on msg.`CodAsesor`=zv.CodAsesor 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND msg.FechaMensaje BETWEEN '$fechaini' AND '$fechafin' AND msg.Mensaje='Termino Ruta' GROUP BY zv.CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleTerminarRuta($sql) {
        $consulta = new Multiple();
        return $consulta->multiConsulta($sql);
    }

    public function getGenrarDetallePedido($agencia, $sql) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetallePedido($id, $agencia) {
        $sql = "SELECT * FROM `descripcionpedido` WHERE IdPedido='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasFacturas($fechaini, $fechafin, $agencia) {
        $sql = "SELECT pe.CodZonaVentas,zv.NombreZonadeVentas FROM `pedidos` AS pe 
        join zonaventas as zv on pe.CodZonaVentas=zv.CodZonaVentas 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND pe.FechaPedido BETWEEN '$fechaini' AND '$fechafin' AND pe.TipoVenta='Autoventa' GROUP BY pe.CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleFactura($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetalleFactura($id, $agencia) {
        $sql = "SELECT * FROM `descripcionpedido` WHERE IdPedido='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasDevoluciones($fechaini, $fechafin, $agencia) {
        $sql = "SELECT devo.CodZonaVentas,zv.NombreZonadeVentas FROM `devoluciones` as devo
        join zonaventas as zv on devo.CodZonaVentas=zv.CodZonaVentas 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND devo.FechaDevolucion between '$fechaini' AND '$fechafin' GROUP BY devo.CodZonaVentas ";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleDevoluciones($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetalleDevolucion($id, $agencia) {
        $sql = "SELECT * FROM `descripciondevolucion` WHERE IdDevolucion='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasRecibos($fechaini, $fechafin, $agencia) {
        $sql = "SELECT recibo.ZonaVenta,zv.NombreZonadeVentas FROM `reciboscaja` as recibo 
        join zonaventas as zv on recibo.ZonaVenta=zv.CodZonaVentas 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND recibo.Fecha between '$fechaini' AND '$fechafin' GROUP BY recibo.ZonaVenta";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleRecibos($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDetalleRecibos($id, $agencia) {
        //$sql="SELECT recicaja.Id as IdReciboCaja,recicaja.ZonaVentaFactura,recicaja.NumeroFactura,recicaja.ValorAbono,recicaja.DtoProntoPago,motisaldo.Nombre as NombreMotivo,recicaja.ValorFactura FROM `reciboscajafacturas` as recicaja
        // left join motivossaldo as motisaldo on recicaja.CodMotivoSaldo=motisaldo.CodMotivoSaldo WHERE recicaja.IdReciboCaja='$id'";
        $sql = "SELECT recicaja.Id AS IdReciboCaja,recicaja.ZonaVentaFactura,recicaja.NumeroFactura,recicaja.ValorAbono,recicaja.DtoProntoPago,motisaldo.Nombre AS NombreMotivo, recicaja.ValorFactura, caja.Id
        FROM `reciboscajafacturas` AS recicaja
        LEFT JOIN motivossaldo AS motisaldo ON recicaja.CodMotivoSaldo=motisaldo.CodMotivoSaldo
        JOIN reciboscaja AS caja ON recicaja.IdReciboCaja=caja.Id
        WHERE recicaja.IdReciboCaja='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getZonaVentasClientesNuevos($fechaini, $fechafin, $agencia) {
        $sql = "SELECT clinuevo.CodZonaVentas,zv.NombreZonadeVentas FROM `clientenuevo` as clinuevo
        join zonaventas as zv on clinuevo.CodZonaVentas=zv.CodZonaVentas 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE ag.CodAgencia='$agencia' AND clinuevo.FechaRegistro BETWEEN '$fechaini' AND '$fechafin' GROUP BY clinuevo.CodZonaVentas ";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenrarDetalleClientesNuevos($sql, $agencia) {
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleKits($id, $agencia) {
        $sql = "SELECT * FROM `kitdescripcionpedido` WHERE IdDescripcionPedido='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getInformacionDetalleKit($id, $agencia) {
        $sql = "SELECT despedido.CodVariante,despedido.NombreArticulo FROM `kitdescripcionpedido` as kit join descripcionpedido as despedido on kit.IdDescripcionPedido=despedido.Id WHERE kit.IdDescripcionPedido='$id' GROUP BY kit.IdDescripcionPedido";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleKitsFactura($id, $agencia) {
        $sql = "SELECT * FROM `kitdescripcionpedido` WHERE IdDescripcionPedido='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getInformacionDetalleKitFactura($id, $agencia) {
        $sql = "SELECT despedido.CodVariante,despedido.NombreArticulo FROM `kitdescripcionpedido` as kit join descripcionpedido as despedido on kit.IdDescripcionPedido=despedido.Id WHERE kit.IdDescripcionPedido='$id' GROUP BY kit.IdDescripcionPedido";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleEfectivo($id, $agencia) {
        $sql = "SELECT reciefectivo.Valor,recicajafac.NumeroFactura FROM `recibosefectivo` as reciefectivo 
        join reciboscajafacturas as recicajafac on reciefectivo.IdReciboCajaFacturas=recicajafac.Id
        join reciboscaja as caja on recicajafac.IdReciboCaja=caja.Id
         WHERE caja.Id='$id'";
        //$sql="SELECT rc.id,rc.NumeroFactura,(SELECT Valor FROM recibosefectivo WHERE IdReciboCajaFacturas=rc.id) AS vlr FROM `reciboscajafacturas` rc WHERE rc.IdReciboCaja IN(SELECT IdReciboCaja FROM `reciboscajafacturas` WHERE id='$id')";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleEfectivoConsignacion($id, $agencia, $tipoConsignacion) {
        $sql = "SELECT recicajafac.NumeroFactura,reciefectivoconsig.NroConsignacionEfectivo,reciefectivoconsig.CodCuentaBancaria,reciefectivoconsig.Fecha,reciefectivoconsig.Valor,ban.CodBanco,ban.Nombre 
        FROM `recibosefectivoconsignacion` as reciefectivoconsig 
        join reciboscajafacturas as recicajafac on reciefectivoconsig.IdReciboCajaFacturas=recicajafac.Id
        join reciboscaja as caja on recicajafac.IdReciboCaja=caja.Id
        join bancos as ban on reciefectivoconsig.CodBanco=ban.CodBanco
        WHERE caja.Id='$id' AND reciefectivoconsig.TipoConsignacion='$tipoConsignacion'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleCheque($id, $agencia) {
        $sql = "SELECT recicheque.NroCheque,recifactucaja.NumeroFactura,recicheque.CodBanco,recicheque.CuentaCheque,recicheque.Fecha,recicheque.Girado,recicheque.Otro,recicheque.Valor,ban.Nombre FROM `reciboscheque` AS recicheque 
        join reciboscajafacturas as recifactucaja on recicheque.IdReciboCajaFacturas=recifactucaja.Id
	join reciboscaja as caja on recifactucaja.IdReciboCaja=caja.Id
        join bancos as ban on recicheque.CodBanco=ban.IdentificadorBanco
        WHERE caja.Id='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleChequeConsignacion($id, $agencia) {
        $sql = "SELECT chequeConsig.Id,facturecicaja.NumeroFactura,chequeConsig.NroConsignacionCheque,chequeConsig.CodCuentaBancaria,chequeConsig.Fecha,chequeConsig.CodBanco,ban.Nombre FROM `reciboschequeconsignacion` as chequeConsig
        join reciboscajafacturas as facturecicaja on chequeConsig.IdReciboCajaFacturas=facturecicaja.Id
        join bancos as ban on chequeConsig.CodBanco=ban.CodBanco
        join reciboscaja as caja on facturecicaja.IdReciboCaja=caja.Id WHERE caja.Id='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGenerarDetalleChequeConsignacionDetalle($id, $agencia) {
        $sql = "SELECT chqueConsigDetalle.`NroChequeConsignacion`,chqueConsigDetalle.`CuentaBancaria`,chqueConsigDetalle.`Fecha`,chqueConsigDetalle.`Valor`,chqueConsigDetalle.CodBanco FROM `reciboschequeconsignaciondetalle` as chqueConsigDetalle
        join reciboschequeconsignacion as checonsig on chqueConsigDetalle.`IdRecibosChequeConsignacion`=checonsig.`Id`
        join reciboscajafacturas as recicaja on checonsig.IdReciboCajaFacturas=recicaja.Id
        join reciboscaja as caja on recicaja.IdReciboCaja=caja.Id 	
        WHERE caja.`Id`='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getSumaEfectivo($id, $agencia) {
        $sql = "SELECT SUM(reciefectivo.Valor) as Efectivo FROM `recibosefectivo` as reciefectivo 
        join reciboscajafacturas as recicajafac on reciefectivo.IdReciboCajaFacturas=recicajafac.Id
        join reciboscaja as caja on recicajafac.IdReciboCaja=caja.Id
        WHERE caja.Id='$id'";
        ///$sql="SELECT SUM(Valor) as Efectivo FROM `recibosefectivo` WHERE IdReciboCajaFacturas='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getSumaEfectivoConsignacion($id, $agencia, $tipoConsignacion) {
        $sql = "SELECT SUM(Valor) as efectivoconsignacion 
        FROM `recibosefectivoconsignacion` as reciefectivoconsig 
        join reciboscajafacturas as recicajafac on reciefectivoconsig.IdReciboCajaFacturas=recicajafac.Id
        join reciboscaja as caja on recicajafac.IdReciboCaja=caja.Id
        WHERE caja.Id='$id' AND reciefectivoconsig.TipoConsignacion='$tipoConsignacion'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getSumaCheque($id, $agencia) {
        //$sql="SELECT SUM(`Valor`) AS cheque FROM `reciboscheque` WHERE `IdReciboCajaFacturas`='$id'";
        $sql = "SELECT SUM(recicheque.`Valor`) AS cheque FROM `reciboscheque` AS recicheque 
        join reciboscajafacturas as recifactucaja on recicheque.IdReciboCajaFacturas=recifactucaja.Id
	join reciboscaja as caja on recifactucaja.IdReciboCaja=caja.Id
        WHERE caja.Id='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getSumaChequeConsignacion($id, $agencia) {
        // $sql="SELECT SUM(Valor) as chequeconsignacion FROM `reciboschequeconsignaciondetalle` WHERE IdRecibosChequeConsignacion='$id'";
        $sql = "SELECT SUM(Valor) as chequeconsignacion FROM `reciboschequeconsignaciondetalle` as chqueConsigDetalle
        join reciboschequeconsignacion as checonsig on chqueConsigDetalle.`IdRecibosChequeConsignacion`=checonsig.`Id`
        join reciboscajafacturas as recicaja on checonsig.IdReciboCajaFacturas=recicaja.Id
        join reciboscaja as caja on recicaja.IdReciboCaja=caja.Id 	
        WHERE caja.`Id`='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getConsultarChequeConsignacion($id, $agencia) {
        $sql = "SELECT Id FROM `reciboschequeconsignacion` WHERE IdReciboCajaFacturas='$id'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getDiasPlazo($plazo) {
        $sql = "SELECT Dias FROM `condicionespago` WHERE CodigoCondicionPago='$plazo'";
        $consulta = new Multiple();
        return $consulta->multiConsulta($sql);
    }

    public function getDiasPlazoZonaVentas($plazo, $agencia) {
        $sql = "SELECT Dias FROM `condicionespago` WHERE CodigoCondicionPago='$plazo'";
        $consulta = new Multiple();
        return $consulta->consultaAgenciaRow($agencia, $sql);
    }

    public function getBancosGlobales($codBanco) {
        $sql = "SELECT Descripcion FROM `bancocheque` WHERE CodigoBanco='$codBanco'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

}
