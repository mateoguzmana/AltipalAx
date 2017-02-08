<?php

class ReporteDashboard extends AgenciaActiveRecord {

    private $gruposVentas;
    private $ConceptosNotasCredito;

    public function getDbConnection() {
        return self::setConexion();
    }

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getNotasTramitadas($fechIni, $fechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT 
                p.`IdPedido` as IdDocumento,
                p.CodAsesor,
		p.CodZonaVentas,
		p.FechaPedido as Fecha,
		p.HoraDigitado as Hora,
		ap.FechaAutorizacionDscto as FechaAutorizacion,
		ap.HoraAutorizacionDscto as HoraAutorizacion,
		dp.ValorDsctoEspecial as Valor,
		'Sin información' as Factura,
		'Sin información' as Concepto,
		p.Observacion as Comentario,
		'Sin información' as ObservacionCartera, 
		(SELECT if(sum(`EstadoRechazoAltipal` + `EstadoRechazoProveedor`)>0,0,1) FROM `aprovacionpedido` WHERE `IdDetallePedido` = ap.IdDetallePedido )as Autoriza,
		ap.AutorizaDscto as responsableDocumento,
		am.Nombre as NombreAsesor,
		cli.NombreCliente,		
                'Sin información' as NombreConceptoNotaCredito,
          	gv.NombreGrupoVentas,
        	(select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal,
                dp.NombreArticulo,
                dp.Cantidad,
                dp.DsctoEspecialProveedor,
 		dp.DsctoEspecialAltipal,
		dp.DsctoEspecial,
		dp.CuentaProveedor ,
		'Descuento Especial' as TipoConsulta                           
                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                INNER JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
        INNER JOIN cliente cli ON p.CuentaCliente=cli.CuentaCliente
        INNER JOIN Localizacion loca ON cli.CodigoBarrio=loca.CodigoBarrio
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido
                WHERE  am.Agencia<>'' AND ($cadena) AND dp.DsctoEspecial<>''
                AND p.FechaPedido BETWEEN '$fechIni' AND '$fechaFin' and dp.DsctoEspecial >'0'
UNION 
    SELECT  'Sin información' as IdDocumento,
            nota.CodAsesor,
            nota.CodZonaVentas,
            nota.Fecha as Fecha,
            nota.Hora as Hora,
            nota.FechaAutorizacion as FechaAutorizacion,
            nota.HoraAutorizacion as HoraAutorizacion,
            nota.Valor as Valor,
            nota.Factura,
            nota.Concepto,
            nota.Comentario as Comentario,
            nota.ObservacionCartera,
            nota.Autoriza as Autoriza,
            nota.QuienAutoriza as responsableDocumento,
            asesor.Nombre as NombreAsesor,
            cli.NombreCliente,
            concep.NombreConceptoNotaCredito,
            gv.NombreGrupoVentas,
            (select distinct(NombreCanal) from jerarquiacomercial jerar where nota.CodigoCanal=jerar.CodigoCanal) as NombreCanal,
            'Sin informacion' as NombreArticulo,
            0 as Cantidad,
         0.00 as DsctoEspecialProveedor,
            0.00 as DsctoEspecialAltipal,
            0.00 as DsctoEspecial,
          'Sin información' as EstadoRevisadoProveedor,
              'Nota Cr&#233dito' as TipoConsulta
            FROM `notascredito` AS nota 
            INNER JOIN asesorescomerciales AS asesor ON  nota.CodAsesor=asesor.CodAsesor
            INNER JOIN cliente AS cli ON nota.CuentaCliente=cli.CuentaCliente
            INNER JOIN conceptosnotacredito AS concep ON nota.Concepto=concep.CodigoConceptoNotaCredito
            INNER JOIN zonaventas AS z ON nota.CodZonaVentas=z.CodZonaVentas
            INNER JOIN gruposventas AS gv ON z.CodigoGrupoVentas=gv.CodigoGrupoVentas
            WHERE ($cadena) AND nota.Autoriza IN (1,2) AND nota.Fecha between '$fechIni' AND '$fechaFin'";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNotasPendientes($fechaIni, $FechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT nota.*,asesor.Nombre as NombreAsesor,cli.NombreCliente as NombreCliente,concep.NombreConceptoNotaCredito,gv.NombreGrupoVentas,(select distinct(NombreCanal) from jerarquiacomercial jerar where nota.CodigoCanal=jerar.CodigoCanal) as NombreCanal,cli.NombreBusqueda,loca.NombreCiudad,prove.NombreCuentaProveedor FROM `notascredito` AS nota 
        INNER JOIN asesorescomerciales AS asesor ON  nota.CodAsesor=asesor.CodAsesor
        INNER JOIN cliente AS cli ON nota.CuentaCliente=cli.CuentaCliente
        INNER JOIN conceptosnotacredito AS concep ON nota.Concepto=concep.CodigoConceptoNotaCredito
        INNER JOIN zonaventas AS z ON nota.CodZonaVentas=z.CodZonaVentas
        INNER JOIN gruposventas AS gv ON z.CodigoGrupoVentas=gv.CodigoGrupoVentas
    INNER JOIN Localizacion AS loca ON cli.CodigoBarrio=loca.CodigoBarrio
    LEFT JOIN proveedores AS prove ON nota.Fabricante=prove.CodigoCuentaProveedor
        WHERE ($cadena) AND nota.Fecha between '$fechaIni' AND '$FechaFin' AND nota.Autoriza = 0";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getDevoluciones($fechaIni, $fechafin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT dev.*,Nombre as NombreAsesor,cli.NombreCliente as NombreCliente,gv.NombreGrupoVentas,gv.CodAgencia FROM `devoluciones` dev 
        INNER JOIN descripciondevolucion AS devdp ON dev.IdDevolucion=devdp.IdDevolucion
        INNER JOIN zonaventas AS z ON dev.CodZonaVentas=z.CodZonaVentas
        INNER JOIN gruposventas AS gv ON z.CodigoGrupoVentas=gv.CodigoGrupoVentas
        INNER JOIN cliente AS cli ON dev.CuentaCliente=cli.CuentaCliente
        INNER JOIN asesorescomerciales AS asesor ON  dev.CodAsesor=asesor.CodAsesor
        WHERE ($cadena) AND dev.FechaDevolucion BETWEEN '$fechaIni' AND '$fechafin' GROUP BY dev.IdDevolucion ";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getDevolucionesDetalle($id, $agencia) {
        try {
            $sql = "SELECT dev.*,desdvl.*,motivo.NombreMotivoDevolucion FROM `devoluciones` AS dev INNER JOIN descripciondevolucion AS desdvl ON dev.IdDevolucion=desdvl.IdDevolucion INNER JOIN motivosdevolucionproveedor AS motivo ON motivo.CodigoMotivoDevolucion=dev.CodigoMotivoDevolucion WHERE dev.IdDevolucion='$id' GROUP BY desdvl.NombreArticulo";
            $agencia = trim($agencia);
            return Multiple::consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAdministradoresDirectorComercial() {
        try {
            $sql = "SELECT * FROM administrador WHERE IdPerfil='12'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAdministradoresDirectorComercialAndAgencias() {
        try {
            $sql = "SELECT DISTINCT a.id, a.nombres, c.codagencia FROM administrador a INNER JOIN configuracionadministrador c ON a.id = c.IdAdministrador WHERE IdPerfil = '12'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $e) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAdministradoresDirectorComercialUsuario($usuario) {
        try {
            $sql = "SELECT * FROM `configuracionadministrador` confi INNER JOIN "
                    . "administrador admin ON confi.IdAdministrador=admin.Id where admin.IdPerfil='12' AND confi.IdAdministrador='$usuario'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNotasCreditoDirectorComercialTransmitidas($cedula, $usuario, $fechaIni, $fechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentasAdminCartera($cedula);
            $this->ConceptosNotasCredito = Multiple::getConcepto($cedula);
            $Conceptos = "(";
            foreach ($this->ConceptosNotasCredito as $itemConceptos) {
                $Conceptos.= "nc.Concepto=" . $itemConceptos['CodigoConceptoNotasCredito'] . " || ";
            }
            $Conceptos = substr($Conceptos, 0, -4);
            $Conceptos .= ')';
            $cadena = "(";
            foreach ($this->gruposVentas as $item) {

                $cadena.= "zn.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);

            if ($Conceptos == "") {
                $Conceptos = "nc.Concepto=''";
            }
            $cadena .= ')';
            //$sql = "SELECT COUNT(*) AS notas,nota.QuienAutoriza,SUM(Valor) AS ValorTotal,(SELECT COUNT(*) AS notasAsignadas  FROM `notascredito` nota INNER JOIN zonaventas z ON nota.CodZonaVentas=z.CodZonaVentas WHERE ($cadena)  AND  ($Conceptos)  AND nota.Fecha BETWEEN '$fechaIni' AND '$fechaFin')  as NotasAsignadas FROM `notascredito` nota INNER JOIN zonaventas z ON nota.CodZonaVentas=z.CodZonaVentas WHERE  ($cadena) AND nota.QuienAutoriza = '$usuario' AND nota.Fecha BETWEEN '$fechaIni' AND '$fechaFin'";
            $sql = "SELECT COUNT(*) Notas FROM notascredito nc 
                    INNER jOIN zonaventas zn ON zn.CodZonaVentas = nc.CodZonaVentas WHERE $cadena AND $Conceptos AND nc.Fecha BETWEEN '$fechaIni' AND '$fechaFin'";
            // Cantidas de notas asignadas        
            $result = Multiple::multiConsultaQuery($sql);
            $nC = 0;
            foreach ($result as $key => $c) {
                $nC = $nC + $c['Notas'];
            }
            $sql = "SELECT COUNT(*) Notas FROM notascredito nc 
                    INNER jOIN zonaventas zn ON zn.CodZonaVentas = nc.CodZonaVentas WHERE $cadena AND $Conceptos AND nc.Fecha BETWEEN '$fechaIni' AND '$fechaFin' AND nc.QuienAutoriza='$usuario' AND Autoriza=1";
            // Cantidad de notas tramitadas
            $result = Multiple::multiConsultaQuery($sql);
            foreach ($result as $key => $c) {
                $nA = $nA + $c['Notas'];
            }
            $sqlAdmin = "SELECT Nombres FROM `administrador` WHERE `Cedula`='$cedula'";
            $Nombre = Yii::app()->db->createCommand($sqlAdmin)->queryRow();
            $datos = array('notas' => $nC, "QuienAutoriza" => $Nombre['Nombres'], 'notasAsignadas' => $nA);
            return $datos;
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    ///esta funcion trae el valor de las notas por time out 

    public function getValorNotasCreditoDirectorComercialGestionadas($cedula, $usuario, $fechaIni, $fechaFin) {

        try {
            $sql = "SELECT SUM(Valor) AS ValornotasGestionadas  FROM `notascredito` nota  WHERE `QuienAutoriza` = '$usuario'  AND Autoriza = 1 AND AutorizaCartera = 1 AND  Fecha BETWEEN '$fechaIni' AND '$fechaFin'";
            $dataReader = Multiple::multiConsultaQuery($sql);
            $Valornotas = 0;
            foreach ($dataReader as $item) {
                $Valornotas = $Valornotas + $item['ValornotasGestionadas'];
            }
            return $Valornotas;
            die();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    ///esta funcion trae la cantidad de notas por time out

    public function getNotasCreditoDirectorComercialTransmitidasTimeOut($cedula, $fechaIni, $fechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentasAdminCartera($cedula);
            $this->ConceptosNotasCredito = Multiple::getConcepto($cedula);
            $Conceptos = "";
            foreach ($this->ConceptosNotasCredito as $itemConceptos) {
                $Conceptos.= "nota.Concepto=" . $itemConceptos['CodigoConceptoNotasCredito'] . " || ";
            }
            $Conceptos = substr($Conceptos, 0, -4);
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "z.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "z.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT COUNT(*) AS notasTimeOut,SUM(Valor) AS ValorTimeOut,(SELECT COUNT(*) AS notasAsignadas  FROM `notascredito` nota INNER JOIN zonaventas z ON nota.CodZonaVentas=z.CodZonaVentas WHERE ($cadena)  AND  ($Conceptos)  AND nota.Fecha BETWEEN '$fechaIni' AND '$fechaFin')  as NotasAsignadas  FROM `notascredito` nota INNER JOIN zonaventas z ON nota.CodZonaVentas=z.CodZonaVentas WHERE ($cadena) AND ($Conceptos) AND AutorizaCartera = '1' AND Fecha BETWEEN '$fechaIni' AND '$fechaFin'";
            $dataReader = Multiple::multiConsultaQuery($sql);
            $sqlAdmin = "SELECT Nombres FROM `administrador` WHERE `Cedula`='$cedula'";
            $Nombre = Yii::app()->db->createCommand($sqlAdmin)->queryRow();
            $notasTimeOut = 0;
            $notasAsignadas = 0;
            $ValorTimeOut = 0;
            foreach ($dataReader as $row) {
                $notasAsignadas = $notasAsignadas + $row['NotasAsignadas'];
                $notasTimeOut = $notasTimeOut + $row['notasTimeOut'];
                $ValorTimeOut = $ValorTimeOut + $row['ValorTimeOut'];
            }
            $arrayDatos = array("NotasAutorizadasPorTimeOut" => $notasTimeOut, "QuienAutoriza" => $Nombre['Nombres'], "valorNotas" => $ValorTimeOut, "notasAsignadas" => $notasAsignadas);
            return $arrayDatos;
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    /////GERENTE
    public function AdministradoresGerente() {
        try {
            $sql = "SELECT * FROM `administrador` where IdPerfil='20'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    /// CARTERA

    public function AdministradoresCartera() {
        try {
            $sql = "SELECT * FROM `administrador` where IdPerfil='29'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    ///GRUPO DE VENTAS GLOBALES

    public function getGrupoVentas() {
        try {
            $sql = "SELECT distinct(CodigoGrupoVentas),NombreGrupoVentas FROM `gruposventas`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNotas($grupo, $fechaini, $fechaFin) {
        try {
            $sql = "SELECT SUM( Valor ) AS notas, g.NombreGrupoVentas, g.CodigoGrupoVentas
            FROM  `notascredito` nota
            INNER JOIN zonaventas z ON nota.CodZonaVentas = z.CodZonaVentas
            INNER JOIN gruposventas g ON z.CodigoGrupoVentas = g.CodigoGrupoVentas
            WHERE z.CodigoGrupoVentas='$grupo'
            AND Autoriza =1
            AND Fecha
            BETWEEN '$fechaini'
            AND '$fechaFin'";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getDescuentosPendientes($fechaIni, $fechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
//            $sql = "SELECT 
//                am.Agencia,
//                p.`IdPedido`,
//                p.CodAsesor,
//                p.`CodGrupoVenta`,
//                gv.NombreGrupoVentas,
//                p.`ValorPedido`,
//                am.Nombre as nombreAsesor,
//                dp.TotalPrecioNeto,
//                cli.NombreCliente,
//                cli.NombreBusqueda as razonsoscial,
//                loca.NombreCiudad,
//                (select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal,
//                dp.NombreUnidadMedida,
//                dp.NombreArticulo,
//                dp.Cantidad,
//                dp.DsctoEspecialAltipal,
//                dp.DsctoEspecialProveedor,
//                aped.QuienAutorizaDscto,
//                aped.EstadoRevisadoAltipal,
//                aped.EstadoRevisadoProveedor
//                FROM `pedidos` p  
//                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
//                INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
//                INNER JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
//                INNER JOIN cliente cli ON p.CuentaCliente=cli.CuentaCliente
//                INNER JOIN Localizacion loca ON cli.CodigoBarrio=loca.CodigoBarrio
//                LEFT JOIN aprovacionpedido aped ON dp.Id = aped.IdDetallePedido
//                LEFT JOIN agencia ag ON am.Agencia=ag.CodAgencia
//                WHERE (p.ArchivoXml = ''  AND  am.Agencia<>'') AND ($cadena) AND (dp.DsctoEspecial<>'') AND (p.Estado = 1) 
//                AND (p.FechaPedido BETWEEN '$fechaIni' AND '$fechaFin')";
            $sql = "SELECT 
                am.Agencia,
                p.`IdPedido`,
                p.CodAsesor,
                dp.Id as idDetallePedido,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                am.Nombre as nombreAsesor,
                dp.TotalPrecioNeto,
                cli.NombreCliente,
                cli.NombreBusqueda as razonsoscial,
                loca.NombreCiudad,
                (select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal,
                dp.NombreUnidadMedida,
                dp.NombreArticulo,
                dp.Cantidad,
                dp.DsctoEspecialAltipal,
                dp.DsctoEspecialProveedor,
                prov.NombreCuentaProveedor
                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                INNER JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
                INNER JOIN cliente cli ON p.CuentaCliente=cli.CuentaCliente
                INNER JOIN Localizacion loca ON cli.CodigoBarrio=loca.CodigoBarrio
                INNER JOIN agencia ag ON am.Agencia=ag.CodAgencia
                INNER JOIN proveedores prov ON dp.CuentaProveedor=prov.CodigoCuentaProveedor
                WHERE (p.ArchivoXml = ''  AND  am.Agencia<>'' AND p.Estado = 1) AND ($cadena) AND 
		(((dp.`DsctoEspecialAltipal` >0 AND dp.`DsctoEspecialProveedor` >0) AND dp.Id NOT IN ( SELECT IdDetallePedido
		FROM aprovacionpedido WHERE EstadoRevisadoAltipal = '1' AND EstadoRevisadoProveedor = '1' ))OR(((dp.`DsctoEspecialAltipal` >0
		AND dp.`DsctoEspecialProveedor` = 0 ) OR ( dp.`DsctoEspecialAltipal` = 0 AND dp.`DsctoEspecialProveedor` >0 )) AND dp.Id NOT IN (
		SELECT IdDetallePedido FROM aprovacionpedido )))
                AND (p.FechaPedido BETWEEN '$fechaIni' AND '$fechaFin') GROUP BY dp.Id";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getItemDiscount($idPedidoDetalle) {
        $sql = "SELECT `EstadoRevisadoAltipal`,`EstadoRevisadoProveedor` FROM `aprovacionpedido` WHERE `IdDetallePedido`='$idPedidoDetalle'";
        return Multiple::multiConsultaQuery($sql);
    }

    public function getDescuentosAprobadosProveedor($FechaIni, $FechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT 
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                am.Nombre as nombreAsesor,
                dp.TotalPrecioNeto,
        cli.NombreCliente,
        cli.NombreBusqueda as razonsoscial,
        loca.NombreCiudad,
        (select distinct(NombreCanal) from jerarquiacomercial jerar where p.CodigoCanal=jerar.CodigoCanal) as NombreCanal,
                dp.NombreUnidadMedida,
                dp.NombreArticulo,
                dp.Cantidad,
                dp.DsctoEspecialProveedor,
                ap.QuienAutorizaDscto,
                ap.EstadoRevisadoProveedor,
                dp.CuentaProveedor                
                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                INNER JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
        INNER JOIN cliente cli ON p.CuentaCliente=cli.CuentaCliente
        INNER JOIN Localizacion loca ON cli.CodigoBarrio=loca.CodigoBarrio
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido                  
                WHERE  am.Agencia<>'' AND ($cadena) AND (dp.DsctoEspecial<>'' AND  dp.DsctoEspecialProveedor >'0') 
                AND p.FechaPedido BETWEEN '$FechaIni' AND '$FechaFin' AND ap.QuienAutorizaDscto = '2'";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNotasTramitadasCartera($fechIni, $fechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT nota.*,asesor.Nombre as NombreAsesor,cli.NombreCliente as NombreCliente,concep.NombreConceptoNotaCredito,gv.NombreGrupoVentas FROM `notascredito` nota 
        INNER JOIN asesorescomerciales AS asesor ON  nota.CodAsesor=asesor.CodAsesor
        INNER JOIN cliente AS cli ON nota.CuentaCliente=cli.CuentaCliente
        LEFT JOIN conceptosnotacredito AS concep ON nota.Concepto=concep.CodigoConceptoNotaCredito
        INNER JOIN zonaventas AS z ON nota.CodZonaVentas=z.CodZonaVentas
        INNER JOIN gruposventas AS gv ON z.CodigoGrupoVentas=gv.CodigoGrupoVentas
        WHERE ($cadena) AND  nota.Fecha between '$fechIni' AND '$fechaFin' AND AutorizaCartera = '1'";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getResponsables($concepto) {
        try {
            $sql = "SELECT Nombres
           FROM `administrador` admin
           INNER JOIN configuracionconceptosnotascredito adminnotas ON admin.Id = adminnotas.IdAdministrador
           WHERE adminnotas.CodigoConceptoNotasCredito='$concepto'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getDescuentosFueraDelRango($FechaIni, $FechaFin) {
        try {
            $this->gruposVentas = Multiple::getGrupoVentas();
            $cadena = "";
            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT 
                p.`IdPedido`,
                p.CodAsesor,
                p.`CodGrupoVenta`,
                gv.NombreGrupoVentas,
                p.`ValorPedido`,
                am.Nombre as nombreAsesor,
                cli.NombreCliente,
        cli.NombreBusqueda as razonsoscial,
        loca.NombreCiudad,
        p.TotalPedido,
                ap.QuienAutorizaDscto,
                ap.FechaAutorizaAltipal,
                ap.NombreAutorizoDsctoAltipal,
                p.FechaPedido
                FROM `pedidos` p  
                INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
                INNER JOIN gruposventas gv ON p.`CodGrupoVenta`=gv.CodigoGrupoVentas
                INNER JOIN asesorescomerciales am ON p.`CodAsesor`=am.CodAsesor
        INNER JOIN cliente cli ON p.CuentaCliente=cli.CuentaCliente
        INNER JOIN Localizacion loca ON cli.CodigoBarrio=loca.CodigoBarrio
                LEFT JOIN aprovacionpedido ap ON dp.Id=ap.IdDetallePedido                  
                WHERE  am.Agencia<>'' AND ($cadena) AND (dp.DsctoEspecial<>'') 
                AND p.FechaPedido BETWEEN '$FechaIni' AND '$FechaFin' AND ap.QuienAutorizaDscto = '4' GROUP BY p.IdPedido";
            return Multiple::multiConsultaQuery($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNotasAprobadasCartera($fechaIni, $fechaFin) {
        try {
            $sql = "SELECT COUNT(*) AS notasaprobadascartera FROM `notascredito` WHERE Autoriza = 1 AND AutorizaCartera = 1 AND Fecha BETWEEN '$fechaIni' AND '$fechaFin'";
            $dataReader = Multiple::multiConsultaQuery($sql);
            $cantidadAprobadas = 0;
            foreach ($dataReader as $item) {
                $cantidadAprobadas = $cantidadAprobadas + $item['notasaprobadascartera'];
            }
            return $cantidadAprobadas;
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNotasRechazadasCartera($fechaIni, $fechaFin) {
        try {
            $sql = "SELECT COUNT(*) AS notasarechazadascartera FROM `notascredito` WHERE Autoriza = 2 AND AutorizaCartera = 1 AND Fecha BETWEEN '$fechaIni' AND '$fechaFin'";
            $dataReader = Multiple::multiConsultaQuery($sql);
            $cantidadRechzadas = 0;
            foreach ($dataReader as $item) {
                $cantidadRechzadas = $cantidadRechzadas + $item['notasarechazadascartera'];
            }
            return $cantidadRechzadas;
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNombreUsuario($username) {
        return Multiple::getNombreUsuario($username);
    }

}
