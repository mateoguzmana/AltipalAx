<?php

class ReporteZonaVentas extends AgenciaActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getAgencias($cedula) {
        $sql ="SELECT DISTINCT(ca.CodAgencia) as CodAgencia,agen.Nombre FROM `administrador` a INNER JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
        INNER JOIN agencia as agen on ca.CodAgencia=agen.CodAgencia WHERE `Cedula`='$cedula'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getCanales() {
        $sql ="SELECT CodigoCanal,NombreCanal FROM `jerarquiacomercial` WHERE CodigoCanal<>'' GROUP BY CodigoCanal";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    //esta consulta es muy pesada
    public function getGraficaEfectividad() {
        $sql ="SELECT COUNT(DISTINCT(cliruta.CuentaCliente)) AS Total_ClientesVisita,frecu.CodFrecuencia,(SELECT COUNT(*)FROM clienteruta as clirutasub join frecuenciavisita frecusub on clirutasub.NumeroVisita=frecusub.NumeroVisita join pedidos pe on clirutasub.CuentaCliente=pe.CuentaCliente WHERE MONTH(pe.FechaPedido)=MONTH(CURDATE()) AND frecusub.CodFrecuencia=frecu.CodFrecuencia GROUP BY frecusub.CodFrecuencia) 
        As numVisitasEfectiva,(SELECT COUNT(*) FROM clienteruta 
        AS clirutanoventa
        join frecuenciavisita frecunovisita on clirutanoventa.NumeroVisita=frecunovisita.NumeroVisita 
        join noventas nov on clirutanoventa.CuentaCliente=nov.CuentaCliente WHERE MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) AND frecunovisita.CodFrecuencia=frecu.CodFrecuencia GROUP BY frecunovisita.CodFrecuencia) as numNovisita FROM `clienteruta` as cliruta 
        join frecuenciavisita frecu on cliruta.NumeroVisita=frecu.NumeroVisita 
        join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente GROUP BY frecu.CodFrecuencia";
        $consulta = new Multiple();
        return $consulta->multiConsulta($sql);
    }

    public function getGraficaNoVentasMes() {
        $sql =" SELECT motinove.Nombre,COUNT(*) AS total_clientes_noventas_mes,nov.CuentaCliente FROM `noventas` as nov 
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
        join clienteruta as cliruta on nov.CuentaCliente=cliruta.CuentaCliente 
        join frecuenciavisita as fre on cliruta.NumeroVisita=fre.NumeroVisita 
        WHERE MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) group by motinove.CodMotivoNoVenta";
        $consulta = new Multiple();
        return $consulta->multiConsulta($sql);
    }

    /* public function getGruposVenta() {
      $sql="SELECT CodigoGrupoVentas,NombreGrupoVentas FROM `gruposventas`";
      return Yii::app()->db->createCommand($sql)->queryAll();
      } */

    public function getClientesAgencia($agencia) {
        $sql ="SELECT COUNT(*) AS Total_Clientes,frecu.CodFrecuencia AS Frecuencia, (SELECT COUNT(DISTINCT(PE.IdPedido)) FROM `pedidos` as PE join zonaventaalmacen as zvalmasub on PE.CodZonaVentas=zvalmasub.CodZonaVentas join clienteruta as clirutasub on PE.CuentaCliente=clirutasub.CuentaCliente join frecuenciavisita as frecuensub on clirutasub.NumeroVisita=frecuensub.NumeroVisita WHERE Frecuencia=frecuensub.CodFrecuencia) AS Visitas, (SELECT COUNT(DISTINCT NOV.Id) FROM `noventas` AS NOV
        join zonaventaalmacen zvalmanov on NOV.CodZonaVentas=zvalmanov.CodZonaVentas 
        join clienteruta clirutanov on NOV.CuentaCliente=clirutanov.CuentaCliente
        join frecuenciavisita frenov on clirutanov.NumeroVisita=frenov.NumeroVisita
        WHERE Frecuencia=frenov.CodFrecuencia)
        as Novisitas FROM `clienteruta` as cliruta 
        join frecuenciavisita frecu on cliruta.NumeroVisita=frecu.NumeroVisita 
        join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        join zonaventas zv on cliruta.CodZonaVentas=zv.CodZonaVentas 
        join zonaventaalmacen zvalma on zv.CodZonaVentas=zvalma.CodZonaVentas WHERE zvalma.Agencia='$agencia' GROUP BY frecu.CodFrecuencia";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    //////////////////////////////////////  CANAL  ///////////////////////////////////////////////

    public function getGraficaxCanalZonaVentas($canal, $agencia) {
        $sql ="SELECT COUNT(*) AS Total_ClientesxCanal,frecu.CodFrecuencia,jrar.CodigoCanal,
        (SELECT COUNT(*) FROM `clienteruta` as clirutacanal 
        join frecuenciavisita frecucanal on clirutacanal.NumeroVisita=frecucanal.NumeroVisita
        join pedidos pe on clirutacanal.CuentaCliente=pe.CuentaCliente
        WHERE MONTH(pe.FechaPedido)=MONTH(CURDATE()) AND frecu.CodFrecuencia=frecucanal.CodFrecuencia
       ) AS VisitasEfecxCanal,
        (SELECT COUNT(*) FROM `clienteruta` as clirutaNovcanal
        join frecuenciavisita frecunovcanal on clirutaNovcanal.NumeroVisita=frecunovcanal.NumeroVisita 
        join noventas nov on clirutaNovcanal.CuentaCliente=nov.CuentaCliente 
        join zonaventas zvcanal on nov.CodZonaVentas=zvcanal.CodZonaVentas WHERE
        MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) AND frecunovcanal.CodFrecuencia=frecu.CodFrecuencia) 
        AS NoVisitasxCanal
        FROM `clienteruta` as cliruta
	join frecuenciavisita frecu on cliruta.NumeroVisita=frecu.NumeroVisita 
	join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
	join zonaventas zv on cliruta.CodZonaVentas=zv.CodZonaVentas 
	join jerarquiacomercial jrar on zv.CodZonaVentas=jrar.CodigoZonaVentas 
	WHERE jrar.CodigoCanal='$canal' GROUP BY frecu.CodFrecuencia";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    ////////////////////////////////////// GRUPOS //////////////////////////////////////////////////////

    public function getGraficaxGrupoZonaVentas($grupo, $agencia) {
        $sql ="SELECT COUNT(*) AS Total_ClientesXGrupo,frecu.CodFrecuencia,
        (SELECT COUNT(*) FROM `clienteruta` as clirutaGrupo
        join frecuenciavisita frecuGrupo on clirutaGrupo.NumeroVisita=frecuGrupo.NumeroVisita 
        join pedidos pe on clirutaGrupo.CuentaCliente=pe.CuentaCliente 
        join zonaventas zvGrupo on clirutaGrupo.CodZonaVentas=zvGrupo.CodZonaVentas 
        join gruposventas grGrupo on zvGrupo.CodigoGrupoVentas=grGrupo.CodigoGrupoVentas
        WHERE MONTH(pe.FechaPedido)=MONTH(CURDATE()) AND frecuGrupo.CodFrecuencia=frecu.CodFrecuencia 
       ) AS visitasxGrupo,
        (SELECT COUNT(*) FROM `clienteruta` as clirutaNovGrupo
        join frecuenciavisita frecuNovGrupo on clirutaNovGrupo.NumeroVisita=frecuNovGrupo.NumeroVisita 
        join noventas nov on clirutaNovGrupo.CuentaCliente=nov.CuentaCliente 
        join zonaventas zvNovGrupo on nov.CodZonaVentas=zvNovGrupo.CodZonaVentas 
        join gruposventas grNovGrupo on zvNovGrupo.CodigoGrupoVentas=grNovGrupo.CodigoGrupoVentas
        WHERE MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) AND frecuNovGrupo.CodFrecuencia=frecu.CodFrecuencia 
       ) AS NovisitaxGrupo
        FROM `clienteruta` as cliruta 
        join frecuenciavisita frecu on cliruta.NumeroVisita=frecu.NumeroVisita 
        join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        join zonaventas zv on cliruta.CodZonaVentas=zv.CodZonaVentas 
        join gruposventas gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE gr.CodigoGrupoVentas='$grupo' GROUP BY frecu.CodFrecuencia";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    // ///////////////////////////////// ZONA ///////////////////////////////////////////////////////////////

    public function getGraficaxZonaVentas($zona, $agencia) {
        $sqlSemanal ="SELECT SUM(TABLA.Contador) AS TOTALF FROM (
            SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona' 
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 1 AND 6 AND CodFrecuencia='S'
            UNION ALL
            SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona' 
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 7 AND 12 AND CodFrecuencia='S'
            UNION ALL
            SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona' 
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 13 AND 18 AND CodFrecuencia='S'
            UNION ALL
            SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona' 
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 19 AND 24 AND CodFrecuencia='S'
           ) TABLA";
        $consulta = new Multiple();
        $dataReaderSemanal = $consulta->consultaAgencia($agencia, $sqlSemanal);
        foreach ($dataReaderSemanal as $itemSem) {
            $countSem = $itemSem['TOTALF'];
        }
        $sqlQuin ="SELECT SUM(TABLA.Contador) AS TOTALQ FROM (
            SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona' 
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 1 AND 12 AND CodFrecuencia='Q'
            UNION ALL
            SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona' 
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 13 AND 24 AND CodFrecuencia='Q'
           ) TABLA";
        $dataReaderQuin = $consulta->consultaAgencia($agencia, $sqlQuin);
        foreach ($dataReaderQuin as $itemQuin) {
            $countQuin = $itemQuin['TOTALQ'];
        }
        $sqlMes ="SELECT COUNT(DISTINCT p.`CuentaCliente`) AS Contador ,p.`IdPedido`, p.`Ruta` , p.`CodZonaVentas` , cr.NumeroVisita, p.`FechaPedido` , f.CodFrecuencia
            FROM `pedidos` p
            INNER JOIN clienteruta cr ON cr.CuentaCliente=p.`CuentaCliente` 
            INNER JOIN frecuenciavisita f ON cr.NumeroVisita=f.NumeroVisita
            WHERE p.`CodZonaVentas`='$zona'
            AND MONTH(p.`FechaPedido`)=MONTH(CURDATE()) AND p.`Ruta` BETWEEN 1 AND 24 AND CodFrecuencia='M'";
        $dataReaderMes = $consulta->consultaAgencia($agencia, $sqlMes);
        foreach ($dataReaderMes as $itemMes) {
            $countMes = $itemMes['Contador'];
        }
        $sql ="SELECT COUNT(*) AS Total_ClientesXZona,frecu.CodFrecuencia, (CASE frecu.CodFrecuencia
                WHEN 'Q' THEN COUNT(*) * 2
                WHEN 'M' THEN COUNT(*) * 1
                WHEN 'S' THEN COUNT(*) * 4
               END) AS objetivovisita,
        (CASE frecu.CodFrecuencia
                WHEN 'Q' THEN '$countQuin'
                WHEN 'M' THEN '$countMes'
                WHEN 'S' THEN '$countSem'
               END) AS Visitasxzona, 
        (CASE frecu.CodFrecuencia
                WHEN 'Q' THEN (COUNT(*) * 2) - '$countQuin'
                WHEN 'M' THEN (COUNT(*) * 1) - '$countMes'
                WHEN 'S' THEN (COUNT(*) * 4) - '$countSem'
               END) AS NoVisitaxZona
        FROM `clienteruta` as cliruta 
        join frecuenciavisita frecu on cliruta.NumeroVisita=frecu.NumeroVisita 
        join cliente cli on cliruta.CuentaCliente=cli.CuentaCliente 
        WHERE cliruta.CodZonaVentas='$zona' GROUP BY frecu.CodFrecuencia";
        return $consulta->consultaAgencia($agencia, $sql);
    }

    ////////////////////////////////////// FECHA //// ///////////////////////////////////////////



    public function getGraficaEfecxFecha($fecha, $agencia) {
        $sql ="SELECT COUNT(*) AS Total_Pedidosfecha,frecu.CodFrecuencia,
        (SELECT COUNT(*) FROM `clienteruta` as clirutaNovxFecha 
        join frecuenciavisita frecuNovxFecha on clirutaNovxFecha.NumeroVisita=frecuNovxFecha.NumeroVisita 
        join noventas nov on clirutaNovxFecha.CuentaCliente=nov.CuentaCliente WHERE
        nov.FechaNoVenta='$fecha') As NovistaxFEcha
        FROM `clienteruta` as cliruta 
        join frecuenciavisita frecu on cliruta.NumeroVisita=frecu.NumeroVisita 
        join pedidos pe on cliruta.CuentaCliente=pe.CuentaCliente
        WHERE pe.FechaPedido='$fecha' GROUP BY frecu.CodFrecuencia";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    //////////////////////////// NO VENTAS ///////////////////////////

    public function getGraficaNoVentasZonaVentasxAgencia($agencia) {
        $sql ="SELECT motinove.Nombre,COUNT(DISTINCT nov.Id) AS total_clientes_noventas_mes,nov.CuentaCliente FROM `noventas` as nov 
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
        join clienteruta as cliruta on nov.CuentaCliente=cliruta.CuentaCliente 
        join frecuenciavisita as fre on cliruta.NumeroVisita=fre.NumeroVisita 
        join zonaventas as zv on nov.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia as ag on gr.CodAgencia=ag.CodAgencia
        WHERE gr.CodAgencia='$agencia' AND MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) group by motinove.CodMotivoNoVenta";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGraficaNoVentasZonaVentasxCanal($canal, $agencia) {
        $sql ="SELECT motinove.Nombre,COUNT(*) AS total_clientes_noventas_mes,nov.CuentaCliente FROM `noventas` as nov 
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
        join clienteruta as cliruta on nov.CuentaCliente=cliruta.CuentaCliente 
        join frecuenciavisita as fre on cliruta.NumeroVisita=fre.NumeroVisita 
        WHERE nov.CodigoCanal='$canal' AND MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) group by motinove.CodMotivoNoVenta";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGraficaNoVentasZonaVentasxGrupo($grupo, $agencia) {
        $sql ="SELECT motinove.Nombre,COUNT(*) AS total_clientes_noventas_mes,nov.CuentaCliente FROM `noventas` as nov 
        join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta 
        join clienteruta as cliruta on nov.CuentaCliente=cliruta.CuentaCliente 
        join frecuenciavisita as fre on cliruta.NumeroVisita=fre.NumeroVisita
        join zonaventas as zv on nov.CodZonaVentas=zv.CodZonaVentas
        join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        join agencia ag on gr.CodAgencia=ag.CodAgencia
        WHERE gr.CodigoGrupoVentas='$grupo' AND MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) group by motinove.CodMotivoNoVenta";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getGraficaNoVentasZonaVentasxZona($zona, $agencia) {
        $sql ="SELECT motinove.CodMotivoNoVenta as idmot,motinove.Nombre,(SELECT COUNT(*) FROM `noventas` WHERE CodZonaVentas='$zona' AND MONTH(FechaNoVenta)=MONTH(CURDATE()) AND CodMotivoNoVenta=idmot) AS total_clientes_noventas_mes ,nov.CuentaCliente FROM `noventas` as nov join motivosnoventa as motinove on nov.CodMotivoNoVenta=motinove.CodMotivoNoVenta join clienteruta as cliruta on nov.CuentaCliente=cliruta.CuentaCliente join frecuenciavisita as fre on cliruta.NumeroVisita=fre.NumeroVisita WHERE nov.CodZonaVentas='$zona' AND MONTH(nov.FechaNoVenta)=MONTH(CURDATE()) group by motinove.CodMotivoNoVenta";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getObjetivo($zona, $agencia) {
        $sql ="SELECT predim.Presupuestado as objetivovisita FROM `presupuestodimensiones` predim INNER JOIN presupuestos pre ON predim.IdPresupuesto=pre.Id WHERE NombreDimension='COBERTURA' AND pre.CodZonaVentas='$zona'";
        $consulta = new Multiple();
        return $consulta->consultaAgenciaRow($agencia, $sql);
    }

    public function getProfundidad($zona, $agencia) {
        $sql ="SELECT prefprofu.* FROM `presupuestoprofundidad` prefprofu INNER JOIN presupuestos pre ON prefprofu.IdPresupuesto=pre.Id WHERE pre.CodZonaVentas='$zona' AND Tipo='Fabricante'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getProfundidadGM($zona, $agencia, $gm) {
        $sql ="SELECT prefprofu.* FROM `presupuestoprofundidad` prefprofu INNER JOIN presupuestos pre ON prefprofu.IdPresupuesto=pre.Id WHERE pre.CodZonaVentas='$zona' AND Tipo='$gm'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getProfundidadGlobal() {
        $sql ="SELECT SUM(prefprofu.Presupuestado) AS presupuestadoglobal,SUM(prefprofu.Ejecutado) AS ejecutadoglobal,prefprofu.NombreDimension FROM `presupuestoprofundidad` prefprofu INNER JOIN presupuestos pre ON prefprofu.IdPresupuesto=pre.Id WHERE Tipo='Fabricante' GROUP BY CodDimension ORDER BY ejecutadoglobal DESC";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getProfundidadGlobalTipo($tipo) {
        $sql ="SELECT SUM(prefprofu.Presupuestado) AS presupuestadoglobal,SUM(prefprofu.Ejecutado) AS ejecutadoglobal,prefprofu.NombreDimension FROM `presupuestoprofundidad` prefprofu INNER JOIN presupuestos pre ON prefprofu.IdPresupuesto=pre.Id WHERE Tipo='$tipo' GROUP BY CodDimension ORDER BY ejecutadoglobal DESC";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

}
