<?php

class ReporteAcumuladoDia extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getAgencias($cedula) {        
        $sql = " SELECT DISTINCT(ca.CodAgencia) as CodAgencia,agen.Nombre FROM `administrador` a
        Inner JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
        Inner JOIN agencia as agen on ca.CodAgencia=agen.CodAgencia WHERE `Cedula`='$cedula'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getGruposVentaxAgecnia($Agencia) {        
        $sql = "SELECT DISTINCT(g.CodigoGrupoVentas) AS codigoGrupo,NombreGrupoVentas FROM gruposventas AS g 
        INNER JOIN zonaventas AS z ON g.CodigoGrupoVentas = z.CodigoGrupoVentas 
        INNER JOIN `zonaventaalmacen` AS za ON z.CodZonaVentas=za.CodZonaVentas
        WHERE za.Agencia='$Agencia'";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($Agencia, $sql);
    }

    public function getZonasVentasXGrupos($GrupoVentas, $agencia) {
        $consulta = new Multiple();
        $sql = " SELECT zv.CodZonaVentas,zv.NombreZonadeVentas FROM `zonaventas` as zv 
        join `gruposventas` as grv on zv.CodigoGrupoVentas=grv.CodigoGrupoVentas
        where grv.CodigoGrupoVentas = '$GrupoVentas' GROUP BY zv.CodZonaVentas";
        $dataReader = $consulta->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getZonasVentasXGruposNombre($GrupoVentas, $agencia) {        
        $sql = "SELECT zv.CodZonaVentas, zv.NombreZonadeVentas, asesores.Nombre
        FROM `zonaventas` AS zv
        JOIN `gruposventas` AS grv ON zv.CodigoGrupoVentas = grv.CodigoGrupoVentas
        INNER JOIN asesorescomerciales AS asesores ON zv.`CodAsesor`=asesores.CodAsesor
        WHERE grv.CodigoGrupoVentas='$GrupoVentas' GROUP BY zv.CodZonaVentas";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getProveedoresXZonaVentas($ZonaVentas, $agencia) {        
        $sql = "SELECT prov.CodigoCuentaProveedor,prov.NombreCuentaProveedor FROM `zonaventas` AS zv
        join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
        join portafolio po on gr.CodigoGrupoVentas=po.CodigoGrupoVentas 
        join proveedores prov on po.CuentaProveedor=prov.CodigoCuentaProveedor 
        WHERE zv.CodZonaVentas='$ZonaVentas' GROUP BY prov.CodigoCuentaProveedor";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargaGraficaPorZonaVentasPedidos($zona, $fecha, $agencia) {        
        $sql = " SELECT COUNT(DISTINCT(p.IdPedido)) num_pedidos, SUM(DISTINCT(p.ValorPedido)) total_valor_pedidos ,p.CodigoCanal,jerar.NombreCanal FROM pedidos AS p 
        JOIN zonaventas AS zv on p.CodZonaVentas=zv.CodZonaVentas
        LEFT JOIN jerarquiacomercial jerar on p.CodigoCanal=jerar.CodigoCanal
        WHERE zv.CodZonaVentas='$zona' AND FechaPedido='$fecha' GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargaGraficaPorZonaVentasRecuados($zona, $fecha, $agencia) {        
        $sql = " SELECT COUNT(DISTINCT(recicaja.`IdReciboCaja`)) AS num_recudos , SUM(DISTINCT(recicaja.`ValorAbono`)) AS total_recaudos,caja.`CodigoCanal`,jerar.NombreCanal
        FROM reciboscajafacturas recicaja
        join reciboscaja caja on recicaja.`IdReciboCaja`=caja.Id 
        join zonaventas AS zv on caja.ZonaVenta=zv.CodZonaVentas  
        left join jerarquiacomercial jerar on caja.CodigoCanal=jerar.CodigoCanal
        WHERE  caja.ZonaVenta='$zona' AND caja.Fecha='$fecha' GROUP BY caja.`CodigoCanal`";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargaGraficaPorZonaVentasClientesNuevos($zona, $fecha, $agencia) {
        $sql = " SELECT COUNT(*)AS clientes, CodigoCanal, NombreCanal
        FROM `clientenuevo` AS clinv 
        join zonaventas AS zv on clinv.CodZonaVentas=zv.CodZonaVentas
        WHERE zv.CodZonaVentas='$zona' AND FechaRegistro='$fecha' GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargaGraficaPorFechaPedidos($fecha, $agencia) {        
        $sql = "SELECT COUNT(DISTINCT(p.IdPedido)) num_pedidos, SUM(DISTINCT(p.ValorPedido)) total_valor_pedidos ,p.CodigoCanal,jerar.NombreCanal FROM pedidos AS p 
	join gruposventas as gr on p.CodGrupoVenta=gr.CodigoGrupoVentas 
        join agencia as ag on gr.CodAgencia=ag.CodAgencia
        LEFT JOIN jerarquiacomercial jerar on p.CodigoCanal=jerar.CodigoCanal
        WHERE ag.CodAgencia='$agencia' AND FechaPedido='$fecha' GROUP BY p.CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargaGraficaPorFechaRecaudo($fecha, $agencia) {        
        $sql = "SELECT COUNT(DISTINCT(recicaja.`IdReciboCaja`)) AS num_recudos , SUM(DISTINCT(recicaja.`ValorAbono`)) AS total_recaudos,caja.`CodigoCanal`,jerar.NombreCanal 
        FROM reciboscajafacturas recicaja 
        join reciboscaja caja on recicaja.`IdReciboCaja`=caja.Id
        left join jerarquiacomercial jerar on caja.CodigoCanal=jerar.CodigoCanal
        WHERE caja.Fecha = '$fecha' GROUP BY caja.`CodigoCanal`";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);        
    }

    public function getCargaGraficaPorFechaClientesNuevos($fecha, $agencia) {
        $sql = "SELECT COUNT(*)AS clientes, CodigoCanal, NombreCanal FROM `clientenuevo` WHERE FechaRegistro='$fecha' GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargarGraficaPorGrupoVentasPedidos($grupo, $fecha, $agencia) {        
        $sql = "SELECT COUNT(DISTINCT(p.IdPedido)) num_pedidos, SUM(DISTINCT(p.ValorPedido)) total_valor_pedidos ,p.CodigoCanal,jerar.NombreCanal FROM pedidos AS p 
                    join gruposventas AS gv on p.CodGrupoVenta=gv.CodigoGrupoVentas
                    LEFT JOIN jerarquiacomercial jerar on p.CodigoCanal=jerar.CodigoCanal
                    WHERE p.CodGrupoVenta='$grupo' AND p.FechaPedido='$fecha' GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargarGraficaPorGrupoVentasRecaudos($grupo, $fecha, $agencia) {        
        $sql = "SELECT COUNT(DISTINCT(recicaja.`IdReciboCaja`)) AS num_recudos , SUM(DISTINCT(recicaja.`ValorAbono`)) AS total_recaudos,caja.`CodigoCanal`,jerar.NombreCanal
            FROM reciboscajafacturas recicaja
            join reciboscaja caja on recicaja.`IdReciboCaja`=caja.Id 
            join zonaventas AS zv on caja.ZonaVenta=zv.CodZonaVentas
            join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
            left join jerarquiacomercial jerar on caja.CodigoCanal=jerar.CodigoCanal
            WHERE gr.CodigoGrupoVentas='$grupo' AND caja.Fecha='$fecha' GROUP BY caja.`CodigoCanal`";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargarGraficaPorGrupoVentasClientesNuevos($grupo, $fecha, $agencia) {        
        $sql = "SELECT COUNT(*)AS clientes, CodigoCanal, NombreCanal
        FROM `clientenuevo` AS clinv 
        join zonaventas AS zv on clinv.CodZonaVentas=zv.CodZonaVentas
        join gruposventas AS gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
        WHERE gr.CodigoGrupoVentas='$grupo' AND FechaRegistro='$fecha'  GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($agencia, $sql);
    }

    public function getCargarGraficaAgenciaPedidos($Agencia, $fecha) {        
        $sql = "SELECT COUNT(DISTINCT(p.IdPedido)) num_pedidos, SUM(DISTINCT(p.ValorPedido)) total_valor_pedidos ,p.CodigoCanal,jerar.NombreCanal FROM pedidos AS p 
	join gruposventas as gr on p.CodGrupoVenta=gr.CodigoGrupoVentas 
        join agencia as ag on gr.CodAgencia=ag.CodAgencia
        LEFT JOIN jerarquiacomercial jerar on p.CodigoCanal=jerar.CodigoCanal
        WHERE ag.CodAgencia='$Agencia' AND FechaPedido='$fecha' GROUP BY p.CodigoCanal";
        $consulta = new Multiple();
        return $consulta->consultaAgencia($Agencia, $sql);
    }

    public function getCargarGraficaAgenciaRecaudos($Agencia, $fecha) {        
        $sql = "SELECT COUNT(DISTINCT(recicaja.`IdReciboCaja`)) AS num_recudos , SUM(DISTINCT(recicaja.`ValorAbono`)) AS total_recaudos,caja.`CodigoCanal`,jerar.NombreCanal FROM reciboscajafacturas recicaja 
                    join reciboscaja caja on recicaja.`IdReciboCaja`=caja.Id 
                    join zonaventas AS zv on caja.ZonaVenta=zv.CodZonaVentas 
                    join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
                    join agencia as ag on gr.CodAgencia=ag.CodAgencia
                    left join jerarquiacomercial jerar on caja.CodigoCanal=jerar.CodigoCanal
                    WHERE ag.CodAgencia = '$Agencia' AND caja.Fecha = '$fecha' GROUP BY caja.`CodigoCanal`";
        $consulta = new Multiple();
        return $consulta->multiConsulta($sql);
    }

    public function getCargarGraficaAgenciaClienteNuevo($Agencia, $fecha) {        
        $sql = "SELECT COUNT(DISTINCT clinv.Id)AS clientes, CodigoCanal, NombreCanal FROM `clientenuevo` AS clinv
                    join zonaventas AS zv on clinv.CodZonaVentas=zv.CodZonaVentas 
                    join gruposventas as gr on zv.CodigoGrupoVentas=gr.CodigoGrupoVentas 
                    join agencia as ag on gr.CodAgencia=ag.CodAgencia
                    WHERE ag.CodAgencia='$Agencia' AND clinv.FechaRegistro='$fecha' GROUP BY CodigoCanal";
        $consulta = new Multiple();
        return $consulta->multiConsulta($sql);
    }

    /////efectivida global

    public function getPedidosDiarioCanal() {
        try {
            $sql = "SELECT COUNT(DISTINCT p.CuentaCliente) AS ClientesCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE p.FechaPedido=CURDATE() GROUP BY p.CodigoCanal";
            $connection = new Multiple;
            return $connection->multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getClientesDiaPresupuestado($canal) {
        $sql = "SELECT SUM(predime.Presupuestado) AS presupuestadoEfc,SUM(predime.Ejecutado) AS ejecutadoEfc,jerar.NombreCanal FROM `presupuestos` pre 
        INNER JOIN presupuestodimensiones predime ON pre.Id=predime.IdPresupuesto
        INNER JOIN jerarquiacomercial jerar ON pre.CodZonaVentas= jerar.CodigoZonaVentas
        WHERE jerar.NombreCanal='$canal' AND predime.NombreDimension='COBERTURA'";
        return Yii::app()->Bogota->createCommand($sql)->queryAll();
    }

    //// EFECTIVIDAD AGENCIA

    public function getPedidosDiarioCanalAgencia($agencia) {
        try {
            $sql = "SELECT COUNT(DISTINCT p.CuentaCliente) AS ClientesCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE p.FechaPedido=CURDATE() GROUP BY p.CodigoCanal";
            $connection = new Multiple;
            return $connection->consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getClientesDiaPresupuestadoAgencia($canal, $agencia) {
        $sql = "SELECT SUM(predime.Presupuestado) AS presupuestadoEfc,SUM(predime.Ejecutado) AS ejecutadoEfc,jerar.NombreCanal FROM `presupuestos` pre 
        INNER JOIN presupuestodimensiones predime ON pre.Id=predime.IdPresupuesto
        INNER JOIN jerarquiacomercial jerar ON pre.CodZonaVentas= jerar.CodigoZonaVentas
        WHERE jerar.NombreCanal='$canal' AND pre.Agencia='$agencia' AND predime.NombreDimension='COBERTURA'";
        return Yii::app()->Bogota->createCommand($sql)->queryAll();
    }

    ////EFECTIVIDAD POR FECHA

    public function getPedidosDiarioCanalFecha($fecha, $agencia) {
        try {
            $sql = "SELECT COUNT(DISTINCT p.CuentaCliente) AS ClientesCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE p.FechaPedido='$fecha' GROUP BY p.CodigoCanal";
            $connection = new Multiple;
            return $connection->consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    ////EFECTIVIDAD POR GRUPO VENTAS

    public function getPedidosDiarioCanalGrupo($grupo, $fecha, $agencia) {
        try {
            $sql = "SELECT COUNT(DISTINCT p.CuentaCliente) AS ClientesCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE p.CodGrupoVenta='$grupo' AND p.FechaPedido='$fecha' GROUP BY p.CodigoCanal";
            $connection = new Multiple;
            return $connection->consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    ////EFECTIVIDAD POR ZONA VENTAS

    public function getPedidosDiarioCanalZona($zona, $fecha, $agencia) {
        try {
            $sql = "SELECT COUNT(DISTINCT p.CuentaCliente) AS ClientesCanal, p.CodigoCanal,(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal FROM `pedidos` p WHERE p.CodZonaVentas='$zona' AND p.FechaPedido='$fecha' GROUP BY p.CodigoCanal";
            $connection = new Multiple;
            return $connection->consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getClientesDiaPresupuestadoZonaVentas($canal, $zona) {
        $sql = "SELECT SUM(predime.Presupuestado) AS presupuestadoEfc,SUM(predime.Ejecutado) AS ejecutadoEfc,jerar.NombreCanal FROM `presupuestos` pre 
        INNER JOIN presupuestodimensiones predime ON pre.Id=predime.IdPresupuesto
        INNER JOIN jerarquiacomercial jerar ON pre.CodZonaVentas= jerar.CodigoZonaVentas
        WHERE jerar.NombreCanal='$canal' AND pre.CodZonaVentas='$zona' AND predime.NombreDimension='COBERTURA'";
        return Yii::app()->Bogota->createCommand($sql)->queryAll();
    }

}
