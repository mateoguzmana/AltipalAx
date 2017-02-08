<?php

class Consultas extends CActiveRecord {

    public $txtError;

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getDepartamentos() {
        $sql = "SELECT * FROM `comunidadautonomadpto`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getCiudades() {
        $sql = "SELECT * FROM `ciudades`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getBarrios() {
        $sql = "SELECT * FROM `barrios`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTipoDocumento() {
        $sql = "SELECT * FROM `tipodocumento`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getSementos() {
        $sql = "SELECT * FROM `segmentos`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getSubSementos($codigoSegmento) {
        $sql = "SELECT * FROM `subsegmento` where `CodSegmento`='$codigoSegmento'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getGrupoImpuesto($zonaVentas, $cuntacliente) {
        $sql = "SELECT CodigoGrupodeImpuestos FROM `clienteruta` WHERE `CodZonaVentas`='$zonaVentas' AND CuentaCliente='$cuntacliente' Group by CodigoGrupodeImpuestos";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSubSementosAll() {
        $sql = "SELECT * FROM `subsegmento`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTipoResgistro() {
        $sql = "SELECT * FROM `tiporegistro`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getDiaSemanaRuta($condicionalRuta) {
        $sql = "SELECT * FROM `frecuenciavisita`" . $condicionalRuta;
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getNombreDepartamento($codigo) {
        $sql = "SELECT Nombre FROM `comunidadautonomadpto` where Codigo='$codigo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getNombreCiudad($codigo) {
        $sql = "SELECT Nombre FROM `ciudades` where Codigo='$codigo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getNombreBarrio($codigo) {
        $sql = "SELECT Nombre FROM `barrios` where CodBarrio='$codigo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    /*     * *******************************************Encuesta General**************************************** */

    public function getPreguntasEncuesta($TipoEncuesta) {
        $sql = "SELECT * FROM `preguntasencuesta` WHERE `IdTipoEncuesta`='$TipoEncuesta' AND `IdEstado`='1'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getPreguntasEncuestaId($idPregunta) {
        $sql = "SELECT 
                            p.IdPregunta as IdPregunta,
                            p.`Pregunta` AS pregunta,
                            r.Descripcion AS respuesta,
                            r.Id AS IdRespuesta,
                            t.Descripcion AS campo,
                            t.Id AS IdCampo,
                            r.IdSiguientePregunta
                            FROM 
                            preguntasencuestas p,
                            respuestasencuesta r,
                            tipocampo t
                            WHERE 
                            p.`IdPregunta`='$idPregunta'
                            AND p.IdPregunta=r.IdPreguntaEncuesta
                            AND p.IdTipoCampo=t.Id AND p.IdTituloEncuesta='1'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getSegmentacionIdRespuesta($idRespuesta) {
        $sql = "SELECT IdCodigoSegmentacion
        FROM `respuestasencuesta`
        WHERE Id='$idRespuesta'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    /*     * *************************************************Perfil***************************************************** */

    public function getPerfilAcciones($idPerfil, $controlador) {
        $sql = "SELECT p.`IdPerfil` , p.`IdListaMenu` , p.`IdListaLink` , p.`IdAccion` , a.Descripcion, l.Controlador
                        FROM `configuracionperfil` p
                        INNER JOIN accion a ON p.`IdAccion`=a.IdAccion
                        INNER JOIN listalink l ON p.`IdListaLink`=l.IdListaLink
                        WHERE `IdPerfil`='$idPerfil' AND l.Controlador='$controlador'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getPerfilId($idPerfil) {
        $sql = "SELECT 
                    c.`IdPerfil`,
                    c.`IdListaMenu`,
                    c.`IdListaLink`,
                    c.`IdAccion`,
                    a.Descripcion,
                    l.Controlador,
                    l.Descripcion As DescripcionControlador
                    FROM 
                    `configuracionperfil` c
                    INNER JOIN accion a ON c.`IdAccion`=a.IdAccion
                    INNER JOIN listalink l ON c.`IdListaLink`=l.IdListaLink
                    WHERE 
                    `IdPerfil`='$idPerfil'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getIdMenu($listaLink) {
        $sql = "SELECT `IdListaMenu` FROM `listalink` WHERE `IdListaLink`='$listaLink'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getIdAccion($descripcion) {
        $sql = "SELECT `IdAccion`,TextoMostrar FROM `accion` WHERE `Descripcion` LIKE '%$descripcion%'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function deleteAccionesPerfil($idPerfil) {
        $sql = "DELETE FROM `configuracionperfil` WHERE `IdPerfil`='$idPerfil'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function InsertAccionesPerfil($idPerfil, $idListaMenu, $idListaLink, $idAccion) {
        $sql = "INSERT INTO `configuracionperfil`(`IdPerfil`, `IdListaMenu`, `IdListaLink`, `IdAccion`) VALUES ('$idPerfil','$idListaMenu','$idListaLink','$idAccion')";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function updatePerfil($cedula, $perfil) {
        $sql = "UPDATE `administrador` SET `IdPerfil`='$perfil' WHERE `Cedula`='$cedula'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function getToken($idAdmin, $token) {
        $sql = "UPDATE `administrador` SET `Token`='$token' WHERE `Id`='$idAdmin'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function UpdateToken($idAdmin, $token) {
        $sql = "UPDATE `administrador` SET `Token`='' WHERE `Id`='$idAdmin'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function getDatosAdministrador($id) {
        $sql = "SELECT Usuario,Clave,Token FROM `administrador` WHERE Id='$id'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getLinkControladores() {
        $sql = "SELECT * FROM `listalink` ORDER BY `IdListaMenu`";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getLinkModulos() {
        $sql = "SELECT * FROM `listamenu`";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getMenuModulos($perfil) {
        $sql = "SELECT * 
                FROM 
                `configuracionperfil` c
                INNER JOIN listamenu m ON c.`IdListaMenu`=m.`IdListaMenu`
                WHERE `IdPerfil`='$perfil'
                GROUP BY m.`IdListaMenu`";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function eliminarPerfil($idPerfil) {
        $sql = "DELETE FROM `perfil` WHERE `IdPerfil`='$idPerfil'";
        try {
            Yii::app()->db->createCommand($sql)->query();
            return TRUE;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getNombreAsesor($codigo) {
        $sql = "SELECT 
                a.Nombre, 
                z.CodZonaVentas 
                FROM `zonaventas` z 
                INNER JOIN asesorescomerciales a ON a.CodAsesor=z.CodAsesor 
                WHERE a.`CodAsesor`='$codigo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getCodigoAsesor($nombre) {
        $sql = "SELECT a.CodAsesor,z.CodZonaVentas FROM asesorescomerciales a INNER JOIN zonaventas z ON z.`CodAsesor`=a.`CodAsesor` WHERE `Nombre` like '%$nombre%'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getAsesoresComercialesZonaVentas() {
        $sql = "SELECT CodAsesor,Nombre FROM `asesorescomerciales`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getFrecuenciaSemana() {
        //SELECT * FROM `frecuenciavisita` WHERE `CodFrecuencia`='S'
        $sql = "SELECT * FROM `frecuenciavisita` WHERE `CodFrecuencia`='S'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getZonaAsesor($codAsesor) {
        $sql = "SELECT 
                z.`CodZonaVentas` 
                FROM `asesorescomerciales` a
                INNER JOIN zonaventas z ON a.CodAsesor=z.CodAsesor
                WHERE z.`CodAsesor`='$codAsesor'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getNombreCanal($codAsesor) {
        $sql = "SELECT NombreCanal FROM `jerarquiacomercial` where NumeroIdentidad='$codAsesor'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getClientesZonaDiaRuta($diaRuta, $zonaVentas, $codigoAsesor) {
        $sql = "select
            f.`NumeroVisita`,
            f.`CodFrecuencia`,
            f.`R1`,
            f.`R2`,
            f.`R3`,
            f.`R4`,
            cr.CuentaCliente,
            c.NombreCliente,
            c.Identificacion,
            c.DireccionEntrega,
            c.NombreBusqueda,
            c.Telefono,
            c.TelefonoMovil, 
            cr.CodZonaVentas,
            cr.ValorCupo,
            cr.SaldoCupo,
            cr.Posicion,
            cr.	ValorCupoTemporal
            
            FROM 
            `frecuenciavisita` f
            INNER JOIN clienteruta cr ON cr.NumeroVisita=f.NumeroVisita 
            INNER JOIN cliente c ON c.CuentaCliente=cr.CuentaCliente
            INNER JOIN zonaventas z ON cr.`CodZonaVentas`=z.`CodZonaVentas`
            WHERE cr.CodZonaVentas='$zonaVentas' AND (`R1`='$diaRuta' OR `R2`='$diaRuta' OR `R3`='$diaRuta' OR `R4`='$diaRuta') ORDER BY Posicion ASC, NombreCliente";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getClientesZonaDiaExtraRuta($diaRuta, $zonaVentas, $codigoAsesor) {
        $sql = " select
            f.`NumeroVisita`,
            f.`CodFrecuencia`,
            f.`R1`,
            f.`R2`,
            f.`R3`,
            f.`R4`,
            cr.CuentaCliente,
            c.NombreCliente,
            c.Identificacion,
            c.DireccionEntrega,
            c.NombreBusqueda,
            c.Telefono,
            c.TelefonoMovil, 
            cr.CodZonaVentas,
            cr.ValorCupo,
            cr.SaldoCupo,
            cr.Posicion,
            cr.	ValorCupoTemporal 
            FROM 
            `frecuenciavisita` f
            INNER JOIN clienteruta cr ON cr.NumeroVisita=f.NumeroVisita 
            INNER JOIN cliente c ON c.CuentaCliente=cr.CuentaCliente
            INNER JOIN zonaventas z ON cr.`CodZonaVentas`=z.`CodZonaVentas`
            WHERE cr.CodZonaVentas='$zonaVentas' AND (`R1`<>'$diaRuta' AND `R2`<>'$diaRuta' AND `R3`<>'$diaRuta' AND `R4`<>'$diaRuta') ORDER BY Posicion ASC, NombreCliente";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getDatosCliente($cuentaCliente, $zonaVentas) {
        $sql = "SELECT 
                c.CuentaCliente,
                c.Identificacion,
                c.NombreCliente,
                c.NombreBusqueda,
                c.DireccionEntrega,
                c.Telefono,
                c.TelefonoMovil,
                c.CorreoElectronico,
                c.Estado,
                c.CodigoCadenaEmpresa,
                c.CodigoBarrio,
                c.CodigoPostal,
                c.Latitud,
                c.Longitud,
                cr.IdClienteRuta,
                cr.CodZonaVentas,
                cr.NumeroVisita,
                cr.Posicion,
                cr.CodigoZonaLogistica,
                cr.ValorCupo,
                cr.ValorCupoTemporal,
                cr.SaldoCupo,
                cr.CodigoCondicionPago,
                cr.DiasGracia,
                cr.DiasAdicionales,
                cr.CodigoFormadePago,
                cr.CodigoGrupoDescuentoLinea,
                cr.CodigoGrupoDescuentoMultiLinea,
                cr.CodigoGrupodeImpuestos,
                cr.CodigoGrupoPrecio,
                sb.CodSubSegmento,
                sb.Nombre as NombreSubsegmento,
                s.CodSegmento,
                s.Nombre as NombreSegmento,
                fp.Descripcion as DescripcionFormaPago,
                ce.Nombre as TipoNegocio
                FROM 
                cliente c
                INNER JOIN clienteruta cr ON cr.`CuentaCliente`=c.`CuentaCliente`
                LEFT JOIN cadenaempresa ce ON ce.`CodigoCadenaEmpresa`=c.`CodigoCadenaEmpresa`
                LEFT JOIN subsegmento sb ON sb.CodSubSegmento=ce.CodSubSegmento
                LEFT JOIN segmentos s ON s.CodSegmento=sb.CodSegmento
                LEFT JOIN formaspago fp ON cr.CodigoFormadePago=fp.CodigoFormadePago	
                WHERE c.`CuentaCliente`='$cuentaCliente' AND cr.CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSaldoFacturaCliente($cuentaCliente) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                sum(ValorAbono) as ValorAbonos
                FROM `reciboscaja` r
                INNER JOIN reciboscajafacturas rf ON r.`Id`=rf.`IdReciboCaja`
                WHERE 
                r.`CuentaCliente`='$cuentaCliente'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();


        foreach ($dataReader as $Item) {

            $valorAbonos = $Item['ValorAbonos'];
            if (!$valorAbonos || $valorAbonos == NULL) {
                $valorAbonos = 0;
            }

            $sql = "SELECT 
                SUM(fs.`SaldoFactura`)- ($valorAbonos) AS SaldoFactura 
                FROM `facturasaldo` fs
                WHERE fs.`CuentaCliente`='$cuentaCliente' AND CURDATE() > fs.`FechaVencimientoFactura` AND fs.SaldoFactura >0";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        }
    }

    public function getSaldoFacturaClienteAsesor($cuentaCliente, $zonaVentas) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                `SaldoFactura` ,
                NumeroFactura
                FROM `facturasaldo` fs
                WHERE fs.`CuentaCliente`='$cuentaCliente' 
                AND fs.CodigoZonaVentas='$zonaVentas' AND CURDATE() > fs.`FechaVencimientoFactura` AND fs.SaldoFactura >0";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $totalSaldos = 0;
        foreach ($dataReader as $item) {
            $totalSaldos+=$item['SaldoFactura'];
            $factura = $item['NumeroFactura'];

            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT sum(`ValorAbono`) as SaldoRecibos FROM `reciboscajafacturas` WHERE `NumeroFactura`='$factura'";
            $command = $connection->createCommand($sql);
            $resultado = $command->queryRow();
            $totalSaldos-=$resultado['SaldoRecibos'];
        }
        return $totalSaldos;
    }

    public function getSaldoFacturaCarteraVencida($IdentificacionCuentaCliente) {
        $sql = "SELECT SUM(fs.`SaldoFactura`) AS SaldoFactura 
                FROM `facturasaldo` fs
                INNER JOIN cliente cli on fs.CuentaCliente=cli.CuentaCliente
                WHERE cli.`Identificacion`='$IdentificacionCuentaCliente' AND fs.SaldoFactura >0";
        return Multiple::multiConsultaQuery($sql);
    }

    public function getSaldoFacturaCarteraVencidaTotal($IdentificacionCuentaCliente) {

        $sql = "SELECT 
                (COUNT(*))As Total 
                FROM `facturasaldo` fs
                INNER JOIN cliente cli on fs.CuentaCliente=cli.CuentaCliente
                WHERE CURDATE() > fs.`FechaVencimientoFactura` AND cli.`Identificacion`='$IdentificacionCuentaCliente' AND fs.SaldoFactura >0";
        return Multiple::multiConsultaQuery($sql);
    }

    // con esta funcion validamos si hay facturas vencidas
    public function getContarFacturasVencidas($IdentificacionCuentaCliente) {
        //echo '<script>alert("'.$IdentificacionCuentaCliente.'");</script>';
        $sql = "SELECT 
                (COUNT(fs.`NumeroFactura`))As total , fs.`NumeroFactura` 
                FROM `facturasaldo` fs
                INNER JOIN cliente cli on fs.CuentaCliente=cli.CuentaCliente
                WHERE CURDATE() > fs.`FechaVencimientoFactura` AND cli.`Identificacion`='$IdentificacionCuentaCliente' AND fs.SaldoFactura >0";
        $dataReader = Multiple::multiConsultaQuery($sql);
        echo '<script>alert("' . print_r($dataReader) . '");</script>';
        return $dataReader;
    }

    public function getFacturasCliente($IdentificacionCuentaCliente) {
        $sql = "SELECT f.Id,f.NumeroFactura,
            f.CuentaCliente,
            f.FechaFactura,
            f.ValorNetoFactura,
            f.CodigoCondicionPago,
            cond.Dias,
            f.DtoProntoPagoNivel1,
            f.FechaDtoProntoPagoNivel1,
            f.DtoProntoPagoNivel2,
            f.FechaDtoProntoPagoNivel2,
            f.SaldoFactura,
            f.CodigoZonaVentas,
            f.CedulaAsesorComercial,
            f.FechaVencimientoFactura,
            fd.Id AS IdDetalle,
            fd.NumeroFactura AS NumeroFacturaDetalle,
            fd.CodigoVariante,
            fd.CodigoArticulo,
            fd.Caracteristica1,
            fd.Caracteristica2,
            fd.CodigoTipo,
            fd.CodigoUnidadMedida,
            fd.NombreUnidadMedida,
            fd.ValorNetoArticulo,
            fd.CuentaProveedor,
            fd.DescuentoPPNivel1,
            fd.DescuentoPPNivel2,
            fd.CantidadFacturada,
            gr.NombreGrupoVentas,
            gr.CodigoGrupoVentas,
            jerar.NombreEmpleado,
            jerar.CelularCorporativo,
            cli.Identificacion,
            cli.NombreCliente,
            (SELECT NombreZonadeVentas FROM zonaventas WHERE CodZonaVentas=f.CodigoZonaVentas) AS NombreZonadeVentas
            FROM clienteruta AS cr 
            INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita=cr.NumeroVisita 
            INNER JOIN facturasaldo AS f ON cr.CuentaCliente=f.CuentaCliente 
            INNER JOIN cliente As cli ON f.CuentaCliente=cli.CuentaCliente
            LEFT JOIN zonaventas AS zv ON f.CodigoZonaVentas=zv.CodZonaVentas
            LEFT JOIN gruposventas gr ON zv.CodigoGrupoVentas=gr.CodigoGrupoVentas
            LEFT JOIN jerarquiacomercial jerar ON zv.CodZonaVentas=jerar.CodigoZonaVentas
            LEFT JOIN facturasaldodetalle AS fd ON f.NumeroFactura=fd.NumeroFactura 
            LEFT JOIN condicionespago AS cond ON cond.CodigoCondicionPago=f.CodigoCondicionPago
            WHERE cli.Identificacion='$IdentificacionCuentaCliente' AND f.SaldoFactura>0 group by f.NumeroFactura ORDER BY f.NumeroFactura ASC";
        return Multiple::multiConsultaQuery($sql);
    }

    public function getFacturasClienteZona($identificacionCliente) {
        $sql = "SELECT 
            f.`NumeroFactura`,
            f.`CuentaCliente`,
            f.`FechaFactura`,
            f.`ValorNetoFactura`,
            f.SaldoFactura,
            f.`SaldoFactura`-((SELECT SUM(`ValorAbono`) FROM `reciboscajafacturas` WHERE `NumeroFactura`=f.NumeroFactura)) AS Total,
            (SELECT SUM(`ValorAbono`) FROM `reciboscajafacturas` WHERE `NumeroFactura`=f.NumeroFactura) AS saldoAbonado,
            f.`CodigoCondicionPago`,
            f.`DtoProntoPagoNivel1`,
            f.`FechaDtoProntoPagoNivel1`,
            f.`DtoProntoPagoNivel2`,
            f.`FechaDtoProntoPagoNivel2`,
            f.`SaldoFactura`,
            f.`CodigoZonaVentas`,  
            f.`CedulaAsesorComercial`, 
            f.`FechaVencimientoFactura`,
            z.CodigoGrupoVentas,
            z.CodZonaVentas,
            a.Nombre as NombreAsesorComercial,
            z.NombreZonadeVentas,
            c.TelefonoMovil as ClienteTelefonoMovil,
            a.TelefonoMovilEmpresarial as AsesorTelefonoMovil,
            g.NombreGrupoVentas,
            cp.Dias as DiasPago
            FROM `facturasaldo` f
            INNER JOIN zonaventas z ON z.CodZonaVentas=f.CodigoZonaVentas
            INNER JOIN gruposventas g ON z.CodigoGrupoVentas=g.CodigoGrupoVentas  
            LEFT JOIN asesorescomerciales a ON z.CodAsesor=a.CodAsesor  
            LEFT JOIN cliente c ON c.CuentaCliente=f.CuentaCliente	
            LEFT JOIN condicionespago cp ON f.CodigoCondicionPago=cp.CodigoCondicionPago	
            WHERE c.`Identificacion`='$identificacionCliente' AND f.`SaldoFactura`>0 AND CURDATE() > f.`FechaVencimientoFactura` ORDER BY f.`FechaVencimientoFactura` ASC";
        //$command=$connection->createCommand($sql);
        return Multiple::multiConsultaQuery($sql);
    }

    public function getFacturaDetalleCliente($numeroFactura) {
        $sql = "SELECT 
                fd.NombreDocumento,
                fd.`NumeroDocumento`,
                fd.`CodigoConcepto`,
                fd.`NombreConcepto`,
                fd.`ValorDocumento`
                FROM facturastransacciones f
                INNER JOIN facturastransaccionesdetalle fd ON f.IdFacturaTransacciones=fd.IdFacturaTransacciones 
                WHERE f.`NumeroFactura`='$numeroFactura'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getAsesoresCliente($cuentaCliente, $zonaVentas) {
        $sql = "SELECT c.`CodZonaVentas`, z.NombreZonadeVentas, a.Cedula, a.Nombre,j.CelularCorporativo FROM clienteruta c INNER JOIN zonaventas z ON z.CodZonaVentas=c.CodZonaVentas INNER JOIN asesorescomerciales a ON z.CodAsesor=a.CodAsesor INNER JOIN jerarquiacomercial as j on c.`CodZonaVentas`=j.CodigoZonaVentas WHERE `CuentaCliente`='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    /*     * *************************************************Pedidos*************************************************************************** */

    public function getGrupoVentasZona($zonaVentas) {
        $sql = "SELECT 
                z.`CodZonaVentas`,
                z.`NombreZonadeVentas`,
                z.`CodigoGrupoVentas`,
                g.NombreGrupoVentas,
                g.AplicaContado
                FROM 
                zonaventas z
                INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas 
                WHERE 
                z.`CodZonaVentas`='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getCondicionPagoCliente($cliente, $zonaVentas, $codigo) {
        $sql = "SELECT 
                c.`CuentaCliente`,
                cp.CodigoCondicionPago, 
                cp.Descripcion,
                cp.Dias,
                z.CodigoGrupoVentas,
                g.AplicaContado,
                cr.SaldoCupo 
                FROM 
                cliente c  
                INNER JOIN clienteruta cr ON cr.CuentaCliente=c.CuentaCliente 
                 INNER JOIN condicionespago cp ON cr.CodigoCondicionPago=cp.CodigoCondicionPago 
                INNER JOIN zonaventas z ON z.CodZonaVentas=cr.CodZonaVentas 
                INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas 
                WHERE 
                c.`CuentaCliente`='$cliente'
                AND cr.CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSitiosTipo($zonaVentas, $Agencia, $codigositios = '') {
        $sql = "SELECT 
                z.`CodZonaVentas`,
                z.`NombreZonadeVentas`, 
                a.Nombre as NombreAlmacen,
                a.CodigoAlmacen as CodigoAlmacen,
                a.Nombre as NombreAlmacen,
                zva.CodigoUbicacion,
                zva.Preventa,
                zva.Autoventa,
                zva.Consignacion,
                zva.VentaDirecta,
                zva.Focalizado,
                zva.CodigoSitio, 
                s.Nombre as NombreSitio
                FROM zonaventas z
                INNER JOIN zonaventaalmacen zva ON z.CodZonaVentas=zva.CodZonaVentas 
                INNER JOIN almacenes a ON zva.CodigoAlmacen=a.CodigoAlmacen
                INNER JOIN sitios s ON zva.CodigoSitio=s.CodSitio 
                WHERE z.`CodZonaVentas`='$zonaVentas' AND (Preventa='verdadero'||Autoventa='verdadero'||Consignacion='verdadero'||VentaDirecta='verdadero'|| Focalizado='verdadero')";
        if ($codigositios !== '') {
            $sql.=" AND zva.CodigoSitio='$codigositios'";
        }
        return Multiple::consultaAgencia($Agencia, $sql);
    }

    public function getSitio($zonaVentas, $Agencia) {
        $sql = "SELECT CodigoAlmacen,CodigoSitio FROM `zonaventaalmacen` where CodZonaVentas='$zonaVentas' AND Agencia='$Agencia'";
        return Multiple::consultaAgencia($Agencia, $sql);
    }

    public function getSitiosAlmacenados($zonaVentas, $Agencia, $CodigoSitio) {
        $sql = "SELECT 
                z.`CodZonaVentas`,
                z.`NombreZonadeVentas`, 
                a.Nombre as NombreAlmacen,
                a.CodigoAlmacen as CodigoAlmacen,
                a.Nombre as NombreAlmacen,
                zva.CodigoUbicacion,
                zva.Preventa,
                zva.Autoventa,
                zva.Consignacion,
                zva.VentaDirecta,
                zva.Focalizado, 
                zva.CodigoSitio, 
                s.Nombre as NombreSitio
                FROM zonaventas z
                INNER JOIN zonaventaalmacen zva ON z.CodZonaVentas=zva.CodZonaVentas 
                INNER JOIN almacenes a ON zva.CodigoAlmacen=a.CodigoAlmacen
                INNER JOIN sitios s ON a.CodSitio=s.CodSitio 
                WHERE z.`CodZonaVentas`='$zonaVentas' AND zva.Agencia='$Agencia' AND zva.Preventa='verdadero'
                AND zva.CodigoSitio<>'$CodigoSitio'";
        return Multiple::consultaAgencia($Agencia, $sql);
    }

    public function getTipoVenta($zonaVentas, $sitio) {
        $sql = "SELECT 
                z.`CodZonaVentas`,
                z.`NombreZonadeVentas`,
                a.Nombre as NombreAlmacen,
                a.CodigoAlmacen as CodigoAlmacen,
                zva.Preventa,
                zva.Autoventa,
                zva.Consignacion,
                zva.VentaDirecta,
                zva.Focalizado,
                a.CodSitio, 
                s.Nombre as NombreSitio
                FROM zonaventas z
                INNER JOIN zonaventaalmacen zva ON z.CodZonaVentas=zva.CodZonaVentas 
                INNER JOIN almacenes a ON zva.CodigoAlmacen=a.CodigoAlmacen
                INNER JOIN sitios s ON a.CodSitio=s.CodSitio 
                WHERE z.`CodZonaVentas`='$zonaVentas' AND s.CodSitio='$sitio'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getPortafolio($zonaVentas, $sitio = '', $almacen = '') {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                p.CodigoVariante,
                p.CodigoArticulo,
                p.NombreArticulo,
                p.CodigoTipo,
                p.CodigoCaracteristica1,
                p.CodigoCaracteristica2,
                p.CodigoGrupoVentas,
                p.IdentificadorProductoNuevo,
                l.CodigoTipoKit
                FROM 
                zonaventas z
                INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas
                INNER JOIN portafolio p ON p.CodigoGrupoVentas=g.CodigoGrupoVentas 
                LEFT JOIN listademateriales l ON p.CodigoArticulo=l.CodigoArticuloKit AND l.Sitio='$sitio' AND Almacen='$almacen'
                WHERE 
                z.`CodZonaVentas`='$zonaVentas' ORDER BY p.IdentificadorProductoNuevo DESC,p.NombreArticulo";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        $arrayAux = array();
        foreach ($dataReader as $itemPortafolio) {
            $codigoVariante = $itemPortafolio['CodigoVariante'];
            $codigoArticulo = $itemPortafolio['CodigoArticulo'];
            $sql = "SELECT * FROM "
                    . "`variantesinactivas` "
                    . "WHERE `CodigoSitio`='$sitio'"
                    . "AND `CodigoAlmacen`='$almacen'"
                    . "AND `CodigoArticulo`='$codigoArticulo'"
                    . "AND `CodigoVariante`='$codigoVariante'";
            $command = $connection->createCommand($sql);
            $variantesInactivas = $command->queryAll();

            if (count($variantesInactivas) <= 0) {
                array_push($arrayAux, $itemPortafolio);
            }
        }
        return $arrayAux;
    }

    public function getPortafolioProveedor($zonaVentas, $cuentaProveedor) {
        $sql = "SELECT 
                p.CodigoVariante,
                p.CodigoArticulo,
                p.NombreArticulo,
                p.CodigoTipo,
                p.CodigoCaracteristica1,
                p.CodigoCaracteristica2,
                p.CodigoGrupoVentas,
                p.IdentificadorProductoNuevo,
                p.CuentaProveedor,
                p.PorcentajedeIVA,
                p.ValorIMPOCONSUMO
                FROM 
                zonaventas z
                INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas
                INNER JOIN portafolio p ON p.CodigoGrupoVentas=g.CodigoGrupoVentas
                WHERE 
                z.`CodZonaVentas`='$zonaVentas' AND p.CuentaProveedor='$cuentaProveedor' ORDER BY p.IdentificadorProductoNuevo DESC";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getPortafolioProductosNuevos($zonaVentas) {
        $sql = "SELECT 
                p.CodigoVariante,
                p.CodigoArticulo,
                p.NombreArticulo,
                p.CodigoArticulo,
                p.CodigoCaracteristica1,
                p.CodigoCaracteristica2,
                p.CodigoGrupoVentas
                FROM 
                zonaventas z
                INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas
                INNER JOIN portafolio p ON p.CodigoGrupoVentas=g.CodigoGrupoVentas
                WHERE 
                z.`CodZonaVentas`='$zonaVentas'
                AND p.IdentificadorProductoNuevo='1' 
                ";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getPortafolioTranAutoventa($zonaVentas) {
        $sql = "SELECT p.*, sa . * 
        FROM `saldosinventarioautoventayconsignacion` AS sa
        INNER JOIN portafolio p ON sa.CodigoVariante=p.CodigoVariante
        INNER JOIN acuerdoscomercialesprecioventa pv on pv.CodigoVariante=p.CodigoVariante
        INNER JOIN zonaventaalmacen AS z ON z.CodigoUbicacion=sa.CodigoUbicacion
        AND z.CodigoUbicacion=sa.CodigoUbicacion
        WHERE z.CodZonaVentas='$zonaVentas'
        AND sa.LoteArticulo<>'NULL'
        AND sa.LoteArticulo<>''
        AND sa.Disponible >0
        GROUP BY sa.CodigoSitio, sa.CodigoAlmacen, sa.CodigoVariante, sa.LoteArticulo";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    /*     * ********************************************************************************************************************* */

    public function getAcuerdoComercialProduto($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaVentas) {
        $sql = "
            SELECT 
            a.CodigoVariante,
            a.PrecioVenta,
            a.CodigoUnidadMedida,
            a.NombreUnidadMedida
            FROM 
            `acuerdoscomercialesprecioventa` a
            INNER JOIN clienteruta cr ON a.CuentaCliente=cr.CuentaCliente 
            WHERE a.`CodigoVariante`='$codigoVariante' 
            AND a.`TipoCuentaCliente`='1' 
            AND cr.CuentaCliente='$cuentaCliente'
            AND cr.CodZonaVentas='$zonaVentas'
            AND a.sitio='$codigoSitio'
            AND a.FechaInicio < CURDATE()
            AND a.FechaTermina > CURDATE()
            AND a.Almacen='$codigoAlmacen'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAcuerdoComercialGrupo($cuentaCliente, $codigoVariante, $codigoSitio, $codigoAlmacen, $zonaVentas) {
        $sql = "SELECT 
                a.CodigoVariante,
                a.PrecioVenta,
                a.CodigoUnidadMedida,
                a.NombreUnidadMedida
               FROM 
               `acuerdoscomercialesprecioventa` a
               INNER JOIN clienteruta cr ON a.CodigoGrupoPrecio=cr.CodigoGrupoPrecio
               WHERE a.`CodigoVariante`='$codigoVariante' 
               AND a.`TipoCuentaCliente`='2' 
               AND cr.CuentaCliente='$cuentaCliente'
               AND cr.CodZonaVentas='$zonaVentas' 
               AND a.sitio='$codigoSitio'
               AND a.FechaInicio < CURDATE()
               AND a.FechaTermina > CURDATE()
               AND a.Almacen='$codigoAlmacen'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    /////********* devoluciones *****//////////


    public function getAcuerdoComercialProdutoDevolucionesSitio($cuentaCliente, $codigoVariante, $codigoSitio, $zonaVentas) {
        $sql = "
            SELECT 
            a.CodigoVariante,
            a.PrecioVenta,
            a.CodigoUnidadMedida,
            a.NombreUnidadMedida
            FROM 
            `acuerdoscomercialesprecioventa` a
            INNER JOIN clienteruta cr ON a.CuentaCliente=cr.CuentaCliente 
            WHERE a.`CodigoVariante`='$codigoVariante' 
            AND a.`TipoCuentaCliente`='1' 
            AND cr.CuentaCliente='$cuentaCliente'
            AND cr.CodZonaVentas='$zonaVentas'
            AND a.sitio='$codigoSitio'
            AND a.FechaInicio<CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAcuerdoComercialGrupoDevolucionesSitio($cuentaCliente, $codigoVariante, $codigoSitio, $zonaVentas) {
        $sql = "SELECT 
                a.CodigoVariante,
                a.PrecioVenta,
                a.CodigoUnidadMedida,
                a.NombreUnidadMedida
               FROM 
               `acuerdoscomercialesprecioventa` a
               INNER JOIN clienteruta cr ON a.CodigoGrupoPrecio=cr.CodigoGrupoPrecio

               WHERE a.`CodigoVariante`='$codigoVariante' 
               AND a.`TipoCuentaCliente`='2' 
               AND cr.CuentaCliente='$cuentaCliente'
               AND cr.CodZonaVentas='$zonaVentas' 
               AND a.sitio='$codigoSitio'
               AND a.FechaInicio<CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAcuerdoComercialProdutoDevoluciones($cuentaCliente, $codigoVariante, $zonaVentas) {
        $sql = "
            SELECT 
            a.CodigoVariante,
            a.PrecioVenta,
            a.CodigoUnidadMedida,
            a.NombreUnidadMedida
            FROM 
            `acuerdoscomercialesprecioventa` a
            INNER JOIN clienteruta cr ON a.CuentaCliente=cr.CuentaCliente 
            WHERE a.`CodigoVariante`='$codigoVariante' 
            AND a.`TipoCuentaCliente`='1' 
            AND cr.CuentaCliente='$cuentaCliente'
            AND cr.CodZonaVentas='$zonaVentas'
            AND a.FechaInicio < CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAcuerdoComercialGrupoDevoluciones($cuentaCliente, $codigoVariante, $zonaVentas) {
        $sql = "SELECT 
                a.CodigoVariante,
                a.PrecioVenta,
                a.CodigoUnidadMedida,
                a.NombreUnidadMedida
               FROM 
               `acuerdoscomercialesprecioventa` a
               INNER JOIN clienteruta cr ON a.CodigoGrupoPrecio=cr.CodigoGrupoPrecio
               WHERE a.`CodigoVariante`='$codigoVariante' 
               AND a.`TipoCuentaCliente`='2' 
               AND cr.CuentaCliente='$cuentaCliente'
               AND cr.CodZonaVentas='$zonaVentas' 
               AND a.FechaInicio < CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    /* public function getRestriccionesProveedor($cuentaCliente, $zonaventas, $codigoVariante){
      $sql="SELECT
      count(*) As Total
      FROM `restriccioncuentaproveedor` r
      INNER JOIN zonaventas z ON z.`CodZonaVentas`=r.`CodZonaVentas`
      INNER JOIN gruposventas g ON g.`CodigoGrupoVentas`=z.CodigoGrupoVentas
      INNER JOIN portafolio p ON p.`CodigoGrupoVentas`=g.CodigoGrupoVentas
      WHERE
      r.CuentaCliente='$cuentaCliente' AND r.`CodZonaVentas`='$zonaventas' AND r.`CodigoVariante`='$codigoVariante'";
      $connection = Multiple::getConexionZonaVentas();
      return $connection->createCommand($sql)->queryRow();
      } */

    public function getRestriccionesProveedorArticulo($cuentaCliente, $zonaventas, $codigoVariante) {
        $sql = "SELECT 
            count(*) As Total  
            FROM `restriccioncuentaproveedor` r 
            INNER JOIN zonaventas z ON z.`CodZonaVentas`=r.`CodZonaVentas`
            INNER JOIN gruposventas g ON g.`CodigoGrupoVentas`=z.CodigoGrupoVentas
            INNER JOIN portafolio p ON p.`CodigoGrupoVentas`=g.CodigoGrupoVentas  
            WHERE 
            r.CuentaCliente='$cuentaCliente' 
            AND r.`CodZonaVentas`='$zonaventas' 
            AND r.`CodigoVariante`='$codigoVariante' 
            AND r.CodigoVariante=p.CodigoVariante
            AND r.`TipoCuenta`='1'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getRestriccionesProveedorGrupo($cuentaCliente, $zonaventas, $CodigoGrupoCategoria) {
        $sql = "SELECT 
            count(*) As Total  
            FROM `restriccioncuentaproveedor` r 
            INNER JOIN zonaventas z ON z.`CodZonaVentas`=r.`CodZonaVentas`
            INNER JOIN gruposventas g ON g.`CodigoGrupoVentas`=z.CodigoGrupoVentas
            INNER JOIN portafolio p ON p.`CodigoGrupoVentas`=g.CodigoGrupoVentas  
            WHERE 
            r.CuentaCliente='$cuentaCliente' 
            AND r.`CodZonaVentas`='$zonaventas' 
            AND p.`CodigoGrupoCategoria`='$CodigoGrupoCategoria'
            AND r.CodigoArticuloGrupoCategoria=p.CodigoGrupoCategoria
            AND r.`TipoCuenta`='2'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getRestriccionesProveedor($cuentaCliente, $zonaventas, $CuentaProveedor) {
        $sql = "SELECT 
            count(*) As Total  
            FROM `restriccioncuentaproveedor` r 
            INNER JOIN zonaventas z ON z.`CodZonaVentas`=r.`CodZonaVentas`
            INNER JOIN gruposventas g ON g.`CodigoGrupoVentas`=z.CodigoGrupoVentas
            INNER JOIN portafolio p ON p.`CodigoGrupoVentas`=g.CodigoGrupoVentas  
            WHERE 
            r.CuentaCliente='$cuentaCliente' 
            AND r.`CodZonaVentas`='$zonaventas' 
            AND p.`CuentaProveedor`='$CuentaProveedor'
            AND r.CuentaProveedor=p.CuentaProveedor
            AND r.`TipoCuenta`='3'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getDetalleProductoPedido($grupoVentas, $codigoVariante, $sitio = '', $almacen = '') {
        $sql = "SELECT 
                p.`NombreArticulo`,
                p.CodigoCaracteristica1,
                p.CodigoCaracteristica2,
                p.CodigoTipo,
                p.`CodigoVariante`,
                p.CodigoArticulo,
                p.PorcentajedeIVA,
                p.ValorIMPOCONSUMO,
                p.CuentaProveedor,
                l.TotalPrecioVentaListaMateriales,
                l.CodigoTipoKit,
                l.CodigoListaMateriales,
                l.CodigoArticuloKit,
                l.Sitio,
                l.Almacen
                FROM `portafolio` p 
                LEFT JOIN listademateriales l ON p.CodigoArticulo=l.CodigoArticuloKit AND l.Sitio='$sitio' AND Almacen='$almacen'
                WHERE 
                p.`CodigoGrupoVentas`='$grupoVentas'
                AND p.`CodigoVariante`='$codigoVariante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSaldoInventarioPreventa($codigoVariante, $codigoSitio, $codigoAlmacen) {
        $sql = "SELECT 
                s.Id,
                s.`Disponible`,
                s.`CodigoUnidadMedida`,
                s.NombreUnidadMedida 
                FROM 
                `saldosinventariopreventa` s
                WHERE 
                 s.`CodigoSitio`='$codigoSitio'
                AND s.`CodigoAlmacen`='$codigoAlmacen'
                AND s.`CodigoVariante`='$codigoVariante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSaldoInventarioAutoventaForm($codigoVariante, $codigoSitio, $codigoAlmacen, $codigoUbicacion, $cliente) {
        $sql = "SELECT 
                s.Id,
                SUM(s.`Disponible`) AS Disponible,
                s.`CodigoUnidadMedida`,
                s.NombreUnidadMedida
                FROM 
                `saldosinventarioautoventayconsignacion` s
                WHERE 
                 s.`CodigoSitio`='$codigoSitio'
                AND s.`CodigoAlmacen`='$codigoAlmacen'
                AND s.`CodigoVariante`='$codigoVariante'
                AND s.`CodigoUbicacion`='$codigoUbicacion'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSaldoInventarioAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $codigoUbicacion, $cliente) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT `Identificacion` FROM `cliente` WHERE `CuentaCliente`='$cliente'";
        $command = $connection->createCommand($sql);
        $dataCliente = $command->queryRow();
        $identificacion = $dataCliente['Identificacion'];
        $sql = "SELECT 
                s.Id,
                SUM(s.`Disponible`) AS Disponible,
                s.`CodigoUnidadMedida`,
                s.NombreUnidadMedida
                FROM 
                `saldosinventarioautoventayconsignacion` s
                WHERE 
                 s.`CodigoSitio`='$codigoSitio'
                AND s.`CodigoAlmacen`='$codigoAlmacen'
                AND s.`CodigoVariante`='$codigoVariante'
                AND s.`CodigoUbicacion`='$identificacion'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getSaldoInventarioAutoventaConsignacion($codigoVariante, $codigoSitio, $codigoAlmacen, $codigoUbicacion) {
        $sql = "SELECT 
                s.Id,
                SUM(s.`Disponible`) AS Disponible,
                s.`CodigoUnidadMedida`,
                s.NombreUnidadMedida
                FROM 
                `saldosinventarioautoventayconsignacion` s
                WHERE 
                 s.`CodigoSitio`='$codigoSitio'
                AND s.`CodigoAlmacen`='$codigoAlmacen'
                AND s.`CodigoVariante`='$codigoVariante'
                AND s.`CodigoUbicacion`='$codigoUbicacion'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    //Modulo Autoventa
    public function getSaldoInventarioPedidoAutoventa($codigoVariante, $codigoSitio, $codigoAlmacen, $codigoUbicacion) {
        $sql = "SELECT 
                s.Id,
                s.LoteArticulo,
                s.`Disponible`,
                s.`CodigoUnidadMedida`,
                s.NombreUnidadMedida
                FROM 
                `saldosinventarioautoventayconsignacion` s
                WHERE 
                 s.`CodigoSitio`='$codigoSitio'
                AND s.`CodigoAlmacen`='$codigoAlmacen'
                AND s.`CodigoVariante`='$codigoVariante'
                AND s.`LoteArticulo`<>'' 
                AND s.`CodigoUbicacion`='$codigoUbicacion'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    /*     * ******************************************************************************************************************************** */

    public function getACDLClienteArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen) {
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`, 
                acdl.`Saldo`,
                acdl.CodigoUnidadMedida,
                acdl.NombreUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                WHERE 
                acdl.`TipoCuentaCliente`='1' 
                AND acdl.`CuentaCliente`='$cuentaCliente'
                AND acdl.`TipoCuentaArticulos`='1'
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`=0
                AND acdl.`CantidadHasta`=0
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
		AND acdl.Sitio='$codigoSitio'
		AND acdl.CodigoAlmacen='$codigoAlmacen'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getACDLGrupoClienteArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $zonaVentas) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                  INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.CuentaCliente='$cuentaCliente'
                AND cr.CodZonaVentas='$zonaVentas'
                AND acdl.`TipoCuentaArticulos`='1' 
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`=0
                AND acdl.`CantidadHasta`=0
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='$codigoSitio'
		AND acdl.CodigoAlmacen='$codigoAlmacen' ORDER BY FechaInicio ASC";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        if (!$dataReader) {
            $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                  INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.CuentaCliente='$cuentaCliente'
                AND cr.CodZonaVentas='$zonaVentas'
                AND acdl.`TipoCuentaArticulos`='1' 
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`=0
                AND acdl.`CantidadHasta`=0
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
        }
        return $dataReader;
    }

    public function getACDLClienteGrupoArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen) {
        $sql = "SELECT 
            acdl.Id,
            acdl.`LimiteVentas`,
            acdl.`Saldo`,
            acdl.CodigoUnidadMedida,
            acdl.`PorcentajeDescuentoLinea1`,
            acdl.`PorcentajeDescuentoLinea2`
            FROM 
            `acuerdoscomercialesdescuentolinea` acdl
            INNER JOIN portafolio p ON acdl.CodigoArticuloGrupoDescuentoLinea=p.CodigoGrupoDescuentoLinea
            WHERE 
            acdl.`TipoCuentaCliente`='1' 
            AND acdl.`CuentaCliente`='$cuentaCliente'
            AND acdl.`TipoCuentaArticulos`='2'
            AND p.`CodigoVariante`='$codigoVariante'
            AND acdl.`CantidadDesde`=0
            AND acdl.`CantidadHasta`=0
            AND acdl.`FechaInicio`<=CURDATE()
            AND acdl.`FechaFinal`>=CURDATE()
            AND acdl.Sitio='$codigoSitio'
            AND acdl.CodigoAlmacen='$codigoAlmacen'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getACDLGrupoClienteGrupoArticuloSaldo($codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $zonaVentas) {
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                INNER JOIN portafolio p ON acdl.CodigoArticuloGrupoDescuentoLinea=p.CodigoGrupoDescuentoLinea
                INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.`CuentaCliente`='$cuentaCliente'
                AND cr.`CodZonaVentas`='$zonaVentas' 
                AND acdl.`TipoCuentaArticulos`='2'
                AND p.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`=0
                AND acdl.`CantidadHasta`=0
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='$codigoSitio'
                AND acdl.CodigoAlmacen='$codigoAlmacen'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getACDLGrupoClienteArticuloSinSitioSaldo($codigoVariante, $cuentaCliente, $zonaVentas) {
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                  INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.CuentaCliente='$cuentaCliente'
                AND cr.CodZonaVentas='$zonaVentas'
                AND acdl.`TipoCuentaArticulos`='1' 
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`=0
                AND acdl.`CantidadHasta`=0
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='000'
		AND acdl.CodigoAlmacen='000'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getACDLGrupoClienteGrupoArticuloSinSitioSaldo($codigoVariante, $cuentaCliente, $zonaVentas) {
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                INNER JOIN portafolio p ON acdl.CodigoArticuloGrupoDescuentoLinea=p.CodigoGrupoDescuentoLinea
                INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.`CuentaCliente`='$cuentaCliente'
                AND cr.`CodZonaVentas`='$zonaVentas' 
                AND acdl.`TipoCuentaArticulos`='2'
                AND p.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`=0
                AND acdl.`CantidadHasta`=0
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='000'
                AND acdl.CodigoAlmacen='000'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getACDLClienteArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CantidadDesde,
                acdl.CantidadHasta,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                WHERE 
                acdl.`TipoCuentaCliente`='1' 
                AND acdl.`CuentaCliente`='$cuentaCliente'
                AND acdl.`TipoCuentaArticulos`='1'
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`<>'0'
                AND acdl.`CantidadHasta`<>'0'
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
		AND acdl.Sitio='$codigoSitio'
		AND acdl.CodigoAlmacen='$codigoAlmacen'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {
            $itemAcuerdo['CodigoUnidadMedida'] . '!=' . $CodigoUnidadMedida;
            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }
        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getACDLGrupoClienteArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida, $zonaVentas) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CantidadDesde,
                acdl.CantidadHasta,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                  INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.CuentaCliente='$cuentaCliente'
                AND cr.CodZonaVentas='$zonaVentas' 
                AND acdl.`TipoCuentaArticulos`='1' 
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`<>'0'
                AND acdl.`CantidadHasta`<>'0'
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='$codigoSitio'
		AND acdl.CodigoAlmacen='$codigoAlmacen'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {

            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }

        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getACDLClienteGrupoArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
            acdl.Id,
            acdl.`LimiteVentas`,
            acdl.`Saldo`,
            acdl.CantidadDesde,
            acdl.CantidadHasta,
            acdl.CodigoUnidadMedida,
            acdl.`PorcentajeDescuentoLinea1`,
            acdl.`PorcentajeDescuentoLinea2`
            FROM 
            `acuerdoscomercialesdescuentolinea` acdl
            INNER JOIN portafolio p ON acdl.CodigoArticuloGrupoDescuentoLinea=p.CodigoGrupoDescuentoLinea
            WHERE 
            acdl.`TipoCuentaCliente`='1' 
            AND acdl.`CuentaCliente`='$cuentaCliente'
            AND acdl.`TipoCuentaArticulos`='2'
            AND p.`CodigoVariante`='$codigoVariante'
            AND acdl.`CantidadDesde`<>'0'
            AND acdl.`CantidadHasta`<>'0'
            AND acdl.`FechaInicio`<=CURDATE()
            AND acdl.`FechaFinal`>=CURDATE()
            AND acdl.Sitio='$codigoSitio'
            AND acdl.CodigoAlmacen='$codigoAlmacen'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {

            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }

        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getACDLGrupoClienteGrupoArticuloSinSaldo($articulo, $codigoVariante, $cuentaCliente, $codigoSitio, $codigoAlmacen, $cantidad, $CodigoUnidadMedida, $zonaVentas) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CantidadDesde,
                acdl.CantidadHasta,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                INNER JOIN portafolio p ON acdl.CodigoArticuloGrupoDescuentoLinea=p.CodigoGrupoDescuentoLinea
                INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.`CuentaCliente`='$cuentaCliente'
                AND cr.`CodZonaVentas`='$zonaVentas' 
                AND acdl.`TipoCuentaArticulos`='2'
                AND p.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`<>'0'
                AND acdl.`CantidadHasta`<>'0'
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='$codigoSitio'
                AND acdl.CodigoAlmacen='$codigoAlmacen'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {

            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }

        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getACDLGrupoClienteArticuloSinSitioSinSaldo($articulo, $codigoVariante, $cuentaCliente, $cantidad, $CodigoUnidadMedida, $zonaVentas) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CantidadDesde,
                acdl.CantidadHasta,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`

                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                  INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.CuentaCliente='$cuentaCliente'
                AND cr.CodZonaVentas='$zonaVentas'
                AND acdl.`TipoCuentaArticulos`='1' 
                AND acdl.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`<>'0'
                AND acdl.`CantidadHasta`<>'0'
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='000'
		AND acdl.CodigoAlmacen='000'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {

            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }

        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getACDLGrupoClienteGrupoArticuloSinSitioSinSaldo($articulo, $codigoVariante, $cuentaCliente, $cantidad, $CodigoUnidadMedida, $zonaVentas) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT 
                acdl.Id,
                acdl.`LimiteVentas`,
                acdl.`Saldo`,
                acdl.CantidadDesde,
                acdl.CantidadHasta,
                acdl.CodigoUnidadMedida,
                acdl.`PorcentajeDescuentoLinea1`,
                acdl.`PorcentajeDescuentoLinea2`
                FROM 
                `acuerdoscomercialesdescuentolinea` acdl
                INNER JOIN portafolio p ON acdl.CodigoArticuloGrupoDescuentoLinea=p.CodigoGrupoDescuentoLinea
                INNER JOIN clienteruta cr ON acdl.CodigoClienteGrupoDescuentoLinea=cr.CodigoGrupoDescuentoLinea
                WHERE 
                acdl.`TipoCuentaCliente`='2' 
                AND cr.`CuentaCliente`='$cuentaCliente'
                AND cr.`CodZonaVentas`='$zonaVentas' 
                AND acdl.`TipoCuentaArticulos`='2'
                AND p.`CodigoVariante`='$codigoVariante'
                AND acdl.`CantidadDesde`<>'0'
                AND acdl.`CantidadHasta`<>'0'
                AND acdl.`FechaInicio`<=CURDATE()
                AND acdl.`FechaFinal`>=CURDATE()
                AND acdl.Sitio='000'
                AND acdl.CodigoAlmacen='000'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {
            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }
        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    /*     * *************************************************************************************************************** */

    public function getClienteGrupoArticulosACDM($articulo, $cuentaCliente, $codigoVariante, $cantidad, $sitio, $codigoAlmacen, $CodigoUnidadMedida) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "
            SELECT 
            acdm.Id,
            acdm.CodigoUnidadMedida,
            acdm.CantidadDesde,
            acdm.CantidadHasta,
            acdm.`PorcentajeDescuentoMultilinea1`,
            acdm.`PorcentajeDescuentoMultilinea2`
            FROM 
            `acuerdoscomercialesdescuentomultilinea` acdm
            INNER JOIN portafolio p ON acdm.CodigoGrupoArticulosDescuentoMultilinea=p.CodigoGrupoDescuentoMultiLinea
            WHERE 
            acdm.`TipoCuentaCliente`='1' 
            AND acdm.`CuentaCliente`='$cuentaCliente' 
            AND p.`CodigoVariante`='$codigoVariante'
            AND acdm.`CantidadDesde`<>'0'
            AND acdm.`CantidadHasta`<>'0'
            AND acdm.`FechaInicio`<=CURDATE()
            AND acdm.`FechaFinal`>=CURDATE()
            AND acdm.sitio='$sitio'
            AND acdm.Almacen='$codigoAlmacen'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {

            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }

        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getGrupoClienteGrupoArticulosACDM($articulo, $cuentaCliente, $codigoVariante, $cantidad, $sitio, $codigoAlmacen, $CodigoUnidadMedida) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "
           SELECT 
                acdm.Id,
                acdm.CodigoUnidadMedida,
                acdm.CantidadDesde,
                acdm.CantidadHasta,
                acdm.`PorcentajeDescuentoMultilinea1`,
                acdm.`PorcentajeDescuentoMultilinea2`
                FROM 
                `acuerdoscomercialesdescuentomultilinea` acdm
                INNER JOIN portafolio p ON acdm.CodigoGrupoArticulosDescuentoMultilinea	=p.CodigoGrupoDescuentoMultiLinea
                INNER JOIN clienteruta cr ON acdm.CodigoGrupoClienteDescuentoMultilinea=cr.CodigoGrupoDescuentoMultiLinea
                WHERE 
                acdm.`TipoCuentaCliente`='2' 
                AND cr.`CuentaCliente`='$cuentaCliente' 
                AND p.`CodigoVariante`='$codigoVariante'
                AND acdm.`CantidadDesde`<>'0'
                AND acdm.`CantidadHasta`<>'0'
                AND acdm.`FechaInicio`<=CURDATE()
                AND acdm.`FechaFinal`>=CURDATE()
                AND acdm.sitio='$sitio'
                AND acdm.Almacen='$codigoAlmacen'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {
            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }
        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getClienteGrupoArticulosACDMSinSitio($articulo, $cuentaCliente, $codigoVariante, $cantidad, $CodigoUnidadMedida) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "
            SELECT 
            acdm.Id,
            acdm.CodigoUnidadMedida,
            acdm.CantidadDesde,
            acdm.CantidadHasta,
            acdm.`PorcentajeDescuentoMultilinea1`,
            acdm.`PorcentajeDescuentoMultilinea2`
            FROM 
            `acuerdoscomercialesdescuentomultilinea` acdm
            INNER JOIN portafolio p ON acdm.CodigoGrupoArticulosDescuentoMultilinea=p.CodigoGrupoDescuentoMultiLinea
            WHERE 
            acdm.`TipoCuentaCliente`='1' 
            AND acdm.`CuentaCliente`='$cuentaCliente' 
            AND p.`CodigoVariante`='$codigoVariante'
            AND acdm.`CantidadDesde`<>'0'
            AND acdm.`CantidadHasta`<>'0'
            AND acdm.`FechaInicio`<=CURDATE()
            AND acdm.`FechaFinal`>=CURDATE()
            AND acdm.sitio='000'
            AND acdm.Almacen='000'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {
            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }
        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    public function getGrupoClienteGrupoArticulosACDMSinSitio($articulo, $cuentaCliente, $codigoVariante, $cantidad, $CodigoUnidadMedida) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "
           SELECT
                acdm.Id,
                acdm.CodigoUnidadMedida,
                acdm.CantidadDesde,
                acdm.CantidadHasta,
                acdm.`PorcentajeDescuentoMultilinea1`,
                acdm.`PorcentajeDescuentoMultilinea2`
                FROM 
                `acuerdoscomercialesdescuentomultilinea` acdm
                INNER JOIN portafolio p ON acdm.CodigoGrupoArticulosDescuentoMultilinea	=p.CodigoGrupoDescuentoMultiLinea
                INNER JOIN clienteruta cr ON acdm.CodigoGrupoClienteDescuentoMultilinea=cr.CodigoGrupoDescuentoMultiLinea
                WHERE 
                acdm.`TipoCuentaCliente`='2' 
                AND cr.`CuentaCliente`='$cuentaCliente' 
                AND p.`CodigoVariante`='$codigoVariante'
                AND acdm.`CantidadDesde`<>'0'
                AND acdm.`CantidadHasta`<>'0'
                AND acdm.`FechaInicio`<=CURDATE()
                AND acdm.`FechaFinal`>=CURDATE()
                AND acdm.sitio='000'
                AND acdm.Almacen='000'";

        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        $respuesta = '';
        foreach ($dataReader as $itemAcuerdo) {

            if ($itemAcuerdo['CodigoUnidadMedida'] != $CodigoUnidadMedida) {
                $cantidadConvertida = $this->buscaUnidadesConversionACDM(
                        $articulo, $itemAcuerdo['CodigoUnidadMedida'], $CodigoUnidadMedida, $cantidad
                );
            } else {
                $cantidadConvertida = $cantidad;
            }
            if ($itemAcuerdo['CantidadDesde'] <= $cantidadConvertida && $itemAcuerdo['CantidadHasta'] >= $cantidadConvertida) {
                $respuesta = $itemAcuerdo;
            }
        }

        if ($respuesta != "") {
            return $respuesta;
        } else {
            return FALSE;
        }
    }

    /*     * ********************************************************************************************************************** */

    public function getUnidadesConversionArticulo($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo) {
        $sql = "SELECT * 
                FROM 
                `unidadesdeconversion` u
                INNER JOIN operacionesunidades o ON u.CodigoDesdeUnidad=o.CodigoDesde
                AND u.CodigoHastaUnidad=o.CodigoHasta
                WHERE `CodigoDesdeUnidad`='$codigoUnidadMedidaProducto'
                AND `CodigoHastaUnidad`='$codigoUnidadMedidaAcuerdo'
                AND `CodigoArticulo`='$articulo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getUnidadesConversionArticuloACDM($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo) {
        $sql = "SELECT * 
                FROM 
                `unidadesdeconversion` u
                INNER JOIN operacionesunidades o ON u.CodigoDesdeUnidad=o.CodigoDesde
                AND u.CodigoHastaUnidad=o.CodigoHasta
                WHERE `CodigoDesdeUnidad`='$codigoUnidadMedidaAcuerdo'
                AND `CodigoHastaUnidad`='$codigoUnidadMedidaProducto'
                AND `CodigoArticulo`='$articulo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getPermisosDescuentoEspecial($zonaVentas) {
        $sql = "SELECT 
                g.PermitirModificarDescuentoEspecialAltipal,
                g.PermitirModificarDescuentoEspecialProveedor,
                g.`PermitirModificarPrecio`
                FROM `zonaventas` z
                INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas
                WHERE 
                z.CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getGrupoPrecio($zonaVentas, $cuentaCliente) {
        $sql = "SELECT `CodigoGrupoPrecio` FROM `clienteruta` WHERE `CodZonaVentas`='$zonaVentas' AND `CuentaCliente`='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getGrupoVentas($asesor) {
        $sql = " SELECT CodigoGrupoVentas FROM `zonaventas` where CodAsesor='$asesor'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    private function buscaUnidadesConversionACDM($articulo, $codigoUnidadMedidaProducto, $codigoUnidadMedidaAcuerdo, $saldo) {
        $conversion = $this->getUnidadesConversionArticuloACDM($articulo, $codigoUnidadMedidaAcuerdo, $codigoUnidadMedidaProducto);
        $factor = $conversion['Factor'];
        $operacion = $conversion['Operacion'];
        if ($operacion == "Division") {
            $unidades = floor(($saldo / $factor));
        }
        if ($operacion == "Multiplicacion") {
            $unidades = floor(($saldo * $factor));
        }
        return $unidades;
    }

    public function getUnidadesConversion($codigoArticulo, $desde, $hasta) {
        $sql = "SELECT * 
                FROM 
                `unidadesdeconversion` u
                INNER JOIN operacionesunidades o ON u.CodigoDesdeUnidad=o.CodigoDesde
                AND u.CodigoHastaUnidad=o.CodigoHasta
                WHERE `CodigoDesdeUnidad`='$desde'
                AND `CodigoHastaUnidad`='$hasta'
                AND `CodigoArticulo`='$codigoArticulo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    /*     * ******************************************************************************************************************* */

    public function actualizarSaldoCupo($cuentaCliente, $zonaVentas, $nuevoSaldo) {
        $sql = "UPDATE `clienteruta` SET `SaldoCupo`='$nuevoSaldo' WHERE `CodZonaVentas`='$zonaVentas' AND `CuentaCliente`='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function actualizarSaldoLimite($saldo, $idAcuerdo) {
        $sql = "UPDATE `acuerdoscomercialesdescuentolinea` SET `Saldo`='$saldo' WHERE `Id`='$idAcuerdo'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function actualizarSaldoInventarioPreventa($idSaldo, $cantidadRestar) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT `Disponible` FROM `saldosinventariopreventa` WHERE `Id`='$idSaldo'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        $cantidad = $dataReader['Disponible'];

        $total = $cantidad - $cantidadRestar;

        $sql = "UPDATE `saldosinventariopreventa` SET `Disponible`='$total' WHERE `Id`='$idSaldo'";

        $connection->createCommand($sql)->query();
    }

    public function actualizarSaldoInventarioAutoventa($idSaldo, $cantidadRestar) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT * FROM `saldosinventarioautoventayconsignacion` WHERE `Id`='$idSaldo'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        $CodigoAlmacen = $dataReader['CodigoAlmacen'];
        $CodigoSitio = $dataReader['CodigoSitio'];
        $CodigoUbicacion = $dataReader['CodigoUbicacion'];
        $CodigoVariante = $dataReader['CodigoVariante'];
        $CodigoArticulo = $dataReader['CodigoArticulo'];
        $CodigoUnidadMedida = $dataReader['CodigoUnidadMedida'];

        $sql = "SELECT * FROM `saldosinventarioautoventayconsignacion` WHERE 
               `CodigoAlmacen`='$CodigoAlmacen'
               AND `CodigoSitio`='$CodigoSitio'
               AND `CodigoUbicacion`='$CodigoUbicacion'
               AND `CodigoVariante`='$CodigoVariante'
               AND `CodigoArticulo`='$CodigoArticulo'
               AND `CodigoUnidadMedida`='$CodigoUnidadMedida' 
                ";
        $command = $connection->createCommand($sql);
        $registrosInventario = $command->queryAll();

        $cantidad = 0;
        foreach ($registrosInventario as $item) {
            $cantidad+=$item['Disponible'];
        }

        foreach ($registrosInventario as $item) {
            $cantidad+=$item['Disponible'];

            $cantidadRestar . '<=' . $item['Disponible'];
            if ($cantidadRestar <= $item['Disponible']) {
                $idSaldo = $item['Id'];
                $total = $item['Disponible'] - $cantidadRestar;

                $sql = "UPDATE `saldosinventarioautoventayconsignacion` SET `Disponible`='$total' WHERE `Id`='$idSaldo'";

                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
                break;
            }
        }
        return $dataReader;
    }

    public function actualizarNoRecaudosAsesor() {
        $sql = "SELECT `Disponible` FROM `saldosinventariopreventa` WHERE `Id`='$idSaldo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getNoRecaudos($zonaVentas, $codigoAsesor, $cuentaCliente) {
        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT * FROM `norecaudos` WHERE `CodZonaVentas`='$zonaVentas' AND `CodAsesor`='$codigoAsesor' AND `CuentaCliente`='$cuentaCliente' AND Fecha=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getRecibosVsFacturas($cuentaCliente) {
        $sql = "SELECT 
                f.NumeroFactura,
                f.`SaldoFactura`,
                (SELECT SUM(`ValorAbono`) FROM `reciboscajafacturas` WHERE `NumeroFactura`=f.NumeroFactura) as Total
                FROM 
                `facturasaldo` f
                WHERE 
                `CuentaCliente`='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getFabricantes($idFactura) {
        $sql = "SELECT facdetalle.CuentaProveedor,pro.NombreCuentaProveedor FROM facturasaldo fac join facturasaldodetalle facdetalle on fac.NumeroFactura=facdetalle.NumeroFactura join proveedores pro on facdetalle.CuentaProveedor=pro.CodigoCuentaProveedor where fac.NumeroFactura='$idFactura'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getNumeroCuenta($cli, $zona) {
        $sql = "SELECT NumeroFactura FROM `facturasaldo` where CuentaCliente='$cli' and CodigoZonaVentas='$zona'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getProveedoresMotivo() {
        $sql = "SELECT
                DISTINCT(CodigoCuentaProveedor) as CuentaProveedor,
                p.NombreCuentaProveedor	
                FROM `motivosdevolucionproveedor` m
                INNER JOIN proveedores p ON m.`CuentaProveedor`=p.`CodigoCuentaProveedor`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getProveedoresMotivoSelect($proveedores) {
        $sql = "SELECT DISTINCT(m.`CodigoMotivoDevolucion`), m.`NombreMotivoDevolucion` FROM `motivosdevolucionproveedor` m WHERE m.`CuentaProveedor`='$proveedores'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getProductoMotivos($CuentaProveedor, $CodigoMotivoDevolucion, $CodigoArticulo) {
        $sql = "SELECT 
            CodigoArticulo
            FROM `motivosdevolucionproveedorarticulo`
            WHERE `CuentaProveedor`='$CuentaProveedor'
            AND `CodigoMotivoDevolucion`='$CodigoMotivoDevolucion'
            AND `CodigoArticulo`='$CodigoArticulo'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getZonaventasverdadero($zonaVentas) {
        $sql = "SELECT Transferencia FROM `zonaventas` WHERE CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAutoVentasInformacion($zonaVentas) {
        $sql = "SELECT zona.NombreZonadeVentas,asesor.Nombre,zona.CodAsesor FROM zonaventas zona join asesorescomerciales asesor on zona.CodAsesor=asesor.CodAsesor WHERE zona.CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAddAtoventas($CodigoVariante) {
        // $sql="SELECT por.NombreArticulo,sa.* FROM `saldosinventarioautoventayconsignacion` AS sa INNER JOIN zonaventaalmacen AS z ON z.CodigoSitio=sa.CodigoSitio AND z.CodigoAlmacen=sa.CodigoAlmacen AND z.CodigoUbicacion=sa.CodigoUbicacion INNER JOIN portafolio por on sa.CodigoVariante=por.CodigoVariante WHERE z.CodZonaVentas='$zona' AND sa.LoteArticulo<>'NULL' AND sa.LoteArticulo<>'' and sa.Disponible > 0 and sa.CodigoVariante='$CodigoVariante' and sa.CodigoUbicacion='$asesor'";
        $sql = "SELECT por.CodigoVariante as cod, por.NombreArticulo,(SELECT MAX(PrecioVenta) FROM `acuerdoscomercialesprecioventa` where CodigoVariante=cod) as PrecioVenta, sa . * FROM `saldosinventarioautoventayconsignacion` AS sa INNER JOIN zonaventaalmacen AS z ON z.CodigoSitio=sa.CodigoSitio AND z.CodigoAlmacen=sa.CodigoAlmacen AND z.CodigoUbicacion=sa.CodigoUbicacion INNER JOIN portafolio por ON sa.CodigoVariante=por.CodigoVariante INNER JOIN acuerdoscomercialesprecioventa AS preciov ON por.CodigoVariante=preciov.CodigoVariante WHERE sa.Disponible >0 AND sa.CodigoVariante='$CodigoVariante' GROUP BY LoteArticulo";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAddAtoventasAll($CodigoVariante, $zona, $asesor) {
        //$sql="SELECT sa.* FROM `saldosinventarioautoventayconsignacion` AS sa INNER JOIN zonaventaalmacen AS z ON z.CodigoSitio=sa.CodigoSitio AND z.CodigoAlmacen=sa.CodigoAlmacen AND z.CodigoUbicacion=sa.CodigoUbicacion WHERE z.CodZonaVentas='$zona' AND sa.LoteArticulo<>'NULL' AND sa.LoteArticulo<>'' and sa.CodigoVariante='$CodigoVariante' and sa.CodigoUbicacion='$asesor'";
        $sql = "SELECT sa.* FROM `saldosinventarioautoventayconsignacion` AS sa INNER JOIN zonaventaalmacen AS z ON z.CodigoSitio=sa.CodigoSitio AND z.CodigoAlmacen=sa.CodigoAlmacen WHERE z.CodZonaVentas='$zona' AND sa.LoteArticulo<>'NULL' AND sa.LoteArticulo<>'' and sa.Disponible >0 and sa.CodigoVariante='$CodigoVariante' and sa.CodigoUbicacion='$asesor'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getArticuloByVariante($CodigoVariante) {
        $sql = "SELECT NombreArticulo,CodigoCaracteristica1,CodigoCaracteristica2,CodigoArticulo FROM `portafolio` where CodigoVariante='$CodigoVariante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getTransferenciaautoventa($zonaVentas) {
        $sql = "SELECT descrip.IdTransferenciaAutoventa,descrip.CodVariante,descrip.CodigoArticulo,descrip.NombreArticulo,descrip.Cantidad,descrip.Lote FROM descripciontransferenciaautoventa descrip join transferenciaautoventa trans on descrip.IdTransferenciaAutoventa=trans.IdTransferenciaAutoventa where trans.CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getEliminarTransferenciaDescripcion($IdTranferencia) {
        $sql = "DELETE FROM `descripciontransferenciaautoventa` WHERE `IdTransferenciaAutoventa`='$IdTranferencia'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function getEliminarTransferenciaDetalle($IdTranferencia) {
        $sql = "DELETE FROM `transferenciaautoventa` WHERE `IdTransferenciaAutoventa`='$IdTranferencia'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function getGrupoventa($zonaVentas) {
        $sql = "SELECT CodigoGrupoVentas FROM `zonaventas` WHERE CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAlmacen($zonaVentas) {
        $sql = "SELECT agencia FROM `zonaventaalmacen` where CodZonaVentas='$zonaVentas' group by agencia ";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getSelectTransaccion($grupoventa, $almacen, $zonaVentas) {
        $sql = "SELECT zona.CodZonaVentas,zona.NombreZonadeVentas,almacen.CodigoUbicacion FROM zonaventas zona join zonaventaalmacen almacen on zona.CodZonaVentas=almacen.CodZonaVentas join gruposventas grup on zona.CodigoGrupoVentas=grup.CodigoGrupoVentas WHERE grup.CodigoGrupoVentas='$grupoventa' and almacen.Agencia='$almacen' and zona.CodZonaVentas <> '$zonaVentas' AND almacen.CodigoUbicacion <>'' group by zona.CodZonaVentas ";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getValidarFactura($factura) {
        $sql = "SELECT count(*) AS Total FROM `pedidos` WHERE `NroFactura`='$factura'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getValidarRangoFactura() {
        try {
            $sql = "SELECT `RangoDesde`,`RangoHasta` FROM `resoluciones` WHERE `CodigoResolucion`='003';";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getCantidadDisponible($lote, $asesor, $variante) {
        $sql = "SELECT `Disponible` FROM `saldosinventarioautoventayconsignacion` WHERE `LoteArticulo`='$lote' and CodigoUbicacion='$asesor' and CodigoVariante='$variante'";
        //$sql="SELECT `Disponible` FROM `saldosinventarioautoventayconsignacion` WHERE `LoteArticulo`='$lote' and CodigoVariante='$variante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getValidarSaldo($CodigoVariante) {
        $sql = "SELECT * FROM `saldosinventarioautoventayconsignacion` where CodigoVariante='$CodigoVariante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getUltimaTranfrencia() {
        $sql = "SELECT MAX(IdTransferenciaAutoventa) AS id FROM `transferenciaautoventa`";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getCodUbicacionaTransferir($zona) {
        $sql = "SELECT CodigoUbicacion FROM `zonaventaalmacen` where CodZonaVentas='$zona'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getCodUbicacionaRemitente($zona) {
        $sql = "SELECT CodigoUbicacion FROM `zonaventaalmacen` where CodZonaVentas='$zona'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    /*     * ***************************************************kids***************************************************** */

    public function getEncabezadoKit($codigoListaMateriales) {
        try {
            $sql = "SELECT * FROM `listademateriales` WHERE `CodigoListaMateriales`='$codigoListaMateriales'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $exc) {
            $this->txtError = "No se realizado la consulta -- Modelo Consultas -- Metodo getEncabezadoKit";
            return false;
        }
    }

    public function getComponentesKit($codigoListaMateriales, $codigoArticuloComponente) {
        try {
            $sql = "SELECT 
                l.`CodigoArticuloKit`,
                ld.CodigoArticuloComponente,
                ld.CodigoCaracteristica1,
                ld.CantidadComponente,
                ld.CodigoTipo,
                ld.Fijo,
                ld.Opcional,
                p.NombreArticulo,
                p.CodigoCaracteristica1,
                p.CodigoCaracteristica2, 
                SUM(ld.CantidadComponente) AS CantidadComponente 
                FROM `listademateriales` l
                INNER JOIN listadematerialesdetalle ld ON l.CodigoListaMateriales=ld.CodigoListaMateriales 
                LEFT JOIN portafolio p ON l.CodigoArticuloKit=p.CodigoArticulo AND ld.CodigoArticuloComponente=p.CodigoVariante 
                WHERE 
                l.`CodigoListaMateriales`='$codigoListaMateriales' AND `CodigoArticuloKit`='$codigoArticuloComponente' GROUP BY ld.CodigoArticuloComponente";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $exc) {

            $this->txtError = "No se realizado la consulta -- Modelo Consultas -- Metodo getComponentesKit";
            return false;
        }
    }

    public function getComponentesKitDinamico($codigoListaMateriales, $codigoArticuloComponente) {
        try {
            $sql = "SELECT 
                l.`CodigoArticuloKit`,
                ld.CodigoArticuloComponente,
                ld.CodigoCaracteristica1 AS CodigoCaracteristica1D,
                ld.CantidadComponente,
                ld.CodigoTipo,
                ld.Fijo,
                ld.Opcional,
                ld.CodigoUnidadMedida,
                ld.CodigoListaMateriales,
                p.NombreArticulo,
                p.CodigoCaracteristica1,
                p.CodigoCaracteristica2, 
                SUM(ld.CantidadComponente) AS CantidadComponente 
                FROM `listademateriales` l
                INNER JOIN listadematerialesdetalle ld ON l.CodigoListaMateriales=ld.CodigoListaMateriales 
                LEFT JOIN portafolio p ON l.CodigoArticuloKit=p.CodigoArticulo AND ld.CodigoArticuloComponente=p.CodigoVariante 
                WHERE 
                l.`CodigoListaMateriales`='$codigoListaMateriales' AND `CodigoArticuloKit`='$codigoArticuloComponente' GROUP BY ld.Id";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $exc) {

            $this->txtError = "No se realizado la consulta -- Modelo Consultas -- Metodo getComponentesKit";
            return false;
        }
    }

    public function getTipoPago($zonaVentas) {
        $sql = "SELECT `AplicaContado` FROM `gruposventas` g INNER JOIN zonaventas z ON z.`CodigoGrupoVentas`=g.`CodigoGrupoVentas` WHERE z.CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getProvisional($txtProvisional, $codAsesor) {
        $fecha = date('Y-m-d');
        $sql = "SELECT count(*) as Total FROM `reciboscaja` WHERE `Provisional`='$txtProvisional' AND `CodAsesor`='$codAsesor' AND `Fecha`='$fecha'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getValorMinimo($cuentaCliente) {
        $sql = "SELECT ce.ValorMinimo FROM `cliente` c INNER JOIN cadenaempresa ce ON c.CodigoCadenaEmpresa=ce.CodigoCadenaEmpresa WHERE `CuentaCliente`='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    /*     * *************************************************************************************************************** */

    public function getValidarIdentificacion($txtIdentificacion) {
        $sql = "SELECT * FROM `jerarquiacomercial` WHERE `NumeroIdentidad`='$txtIdentificacion'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getSaldoRecibosCupo($cuentaCliente, $zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();

        $totalCupo = 0;

        $sql = "SELECT 
            SUM(re.Valor) as ValorEfectivo
            FROM `reciboscaja` r
            INNER JOIN reciboscajafacturas rf ON r.Id=rf.IdReciboCaja
            Left JOIN recibosefectivo re ON rf.Id=re.IdReciboCajaFacturas
            WHERE 
            r.`Fecha`=CURDATE() AND r.CuentaCliente='$cuentaCliente' AND ZonaVentaFactura='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        $totalCupo+=$dataReader['ValorEfectivo'];

        $sql = "SELECT 
            sum(rec.Valor) as ValorEfectivoConsignacion
            FROM `reciboscaja` r
            INNER JOIN reciboscajafacturas rf ON r.Id=rf.IdReciboCaja
            Left JOIN recibosefectivoconsignacion rec ON rf.Id=rec.IdReciboCajaFacturas
            WHERE 
            r.`Fecha`=CURDATE() AND r.CuentaCliente='$cuentaCliente' AND ZonaVentaFactura='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        $totalCupo+=$dataReader['ValorEfectivoConsignacion'];

        $sql = "SELECT 
            SUM(rc.Valor) as ValorCheque
            FROM `reciboscaja` r
            lEFT JOIN reciboscajafacturas rf ON r.Id=rf.IdReciboCaja
            lEFT JOIN reciboscheque rc ON rf.Id=rc.IdReciboCajaFacturas and rc.Fecha <=CURDATE()
            WHERE 
            r.`Fecha`=CURDATE() AND r.CuentaCliente='$cuentaCliente' AND ZonaVentaFactura='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        $totalCupo+=$dataReader['ValorCheque'];

        $sql = "SELECT 
            SUM(rccd.Valor) AS ValorConsignacionCheque
            FROM `reciboscaja` r
            INNER JOIN reciboscajafacturas rf ON r.Id=rf.IdReciboCaja
            Left JOIN reciboschequeconsignacion rcc ON rf.Id=rcc.IdReciboCajaFacturas
            Left Join reciboschequeconsignaciondetalle rccd ON rcc.Id=rccd.IdRecibosChequeConsignacion
            WHERE 
            r.`Fecha`=CURDATE() AND r.CuentaCliente='$cuentaCliente' AND ZonaVentaFactura='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        $totalCupo+=$dataReader['ValorConsignacionCheque'];


        $sql = "SELECT 
                SUM(`ValorPedido`) as ValorPedido
                FROM `pedidos` WHERE `CuentaCliente`='$cuentaCliente' AND `FechaPedido`=CURDATE() AND CodZonaVentas='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();

        $totalCupo-=$dataReader['ValorPedido'];

        return $totalCupo;
    }

    public function getEmailCliente($cuentaCliente) {
        $sql = "SELECT CorreoElectronico FROM `cliente` WHERE `CuentaCliente`='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getCedulaAsesor($codAsesor) {
        $sql = "SELECT 
            ac.Cedula
            FROM `zonaventas` z
            INNER JOIN asesorescomerciales ac ON z.`CodAsesor`=ac.CodAsesor
            WHERE z.`CodAsesor`='$codAsesor'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getAllZonasAsesor() {
        $sql = "SELECT 
                z.CodZonaVentas,
                z.NombreZonadeVentas,
                z.CodAsesor,
                ac.Nombre,
	        zvglo.CodAgencia
                FROM `zonaventas` z 
                lEFT JOIN asesorescomerciales ac ON z.CodAsesor=ac.CodAsesor
		INNER JOIN zonaventasglobales zvglo ON zvglo.CodZonaVentas=z.CodZonaVentas";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function UpdateEstadoPosFcha($id) {
        $sql = "UPDATE `reciboscaja` SET `EstadoChequePosfechado`='0' where `Id`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function getSumaSaldoNegativoFactura($CuentaCliente) {
        $sql = "SELECT ABS(SUM(SaldoFactura)) as saldosumavalornegativo FROM `facturasaldo` WHERE SaldoFactura<0 AND CuentaCliente='$CuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getDiasAdicionales($ruta, $cuentaCliente) {
        $sql = "SELECT DiasAdicionales FROM `clienteruta` where NumeroVisita='$ruta' AND CuentaCliente='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getNitcuentacliente($cuentaCliente) {
        $sql = "SELECT Identificacion FROM `cliente` where CuentaCliente='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getFacturaMasAntigua($Identifiacion) {
        $sql = "SELECT NumeroFactura,FechaVencimientoFactura FROM `facturasaldo` fs INNER JOIN cliente as cli on fs.CuentaCliente=cli.CuentaCliente WHERE cli.Identificacion='$Identifiacion' AND fs.SaldoFactura>0 ORDER BY fs.FechaFactura ASC LIMIT 1";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getAsesorVetaConsignacion($cedulaAsesor) {
        $sql = "SELECT COUNT(*) as saldodisponible FROM `saldosinventarioautoventayconsignacion` where CodigoUbicacion='$cedulaAsesor'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getListaMateriales($CodVariante) {
        $sql = "SELECT CodigoListaMateriales FROM `listademateriales` where CodigoVarianteKit='$CodVariante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getComponentesOB($idListaMateriales) {
        $sql = "SELECT COUNT(*) AS componentes FROM `listadematerialesdetalle` WHERE CodigoListaMateriales='$idListaMateriales'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getListaMaterialesDetalle($idListaMateriales) {
        $sql = "SELECT * FROM `listadematerialesdetalle` WHERE CodigoListaMateriales='$idListaMateriales' AND CodigoTipo='OB'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getLoteVariante($codVariante, $ubicacion) {
        $sql = "SELECT * FROM `saldosinventarioautoventayconsignacion` where CodigoVariante='$codVariante' AND CodigoUbicacion='$ubicacion' AND Disponible > 0";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getLoteMenorVariante($saldo, $ubicacion) {
        $sql = "SELECT LoteArticulo FROM `saldosinventarioautoventayconsignacion` where Disponible='$saldo' AND CodigoUbicacion='$ubicacion' GROUP BY LoteArticulo";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getSaltoLote($Lote, $ubicacion, $variante) {
        $sql = "SELECT Disponible FROM `saldosinventarioautoventayconsignacion` where LoteArticulo='$Lote' AND CodigoUbicacion='$ubicacion' AND CodigoVariante='$variante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getDiasAdicionaGraciasCliente($CuentaCliente, $Zonaventas) {
        $sql = "SELECT (DiasGracia + DiasAdicionales) as diasgracia FROM `clienteruta` where CuentaCliente='$CuentaCliente' and CodZonaVentas='$Zonaventas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getCodArtiDesLinaCliente($CuentaCliente, $zonaVentas) {
        $sql = "SELECT CodigoGrupoDescuentoLinea,CodigoGrupoDescuentoMultiLinea FROM `clienteruta` where CuentaCliente='$CuentaCliente' AND `CodZonaVentas`='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getSaldoFact($factura) {
        $sql = "SELECT SaldoFactura FROM `facturasaldo` where NumeroFactura='$factura'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getFacturaDetalleCurdateRecibos($numerofactura) {
        $sql = "SELECT r.Id,mtvs.Nombre,rf.ValorAbono FROM `reciboscaja` r join reciboscajafacturas rf on r.Id=rf.IdReciboCaja left join motivossaldo mtvs on rf.CodMotivoSaldo=mtvs.CodMotivoSaldo WHERE rf.NumeroFactura='$numerofactura' AND r.Fecha=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getFacturaDetalleCurdateNotas($numerofactura) {
        $sql = "SELECT nota.IdNotaCredito,cop.NombreConceptoNotaCredito,nota.Valor FROM `notascredito` nota JOIN conceptosnotacredito cop on nota.Concepto=cop.CodigoConceptoNotaCredito WHERE Factura='$numerofactura' AND Fecha=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getAgencia($agencia) {
        $sql = "SELECT Nombre FROM agencia WHERE CodAgencia='$agencia'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getPedidoAltipal($idpedido) {
        $sql = "SELECT p.IdPedido,p.CodZonaVentas,p.CuentaCliente,p.CodGrupoVenta FROM `pedidos` AS p INNER JOIN descripcionpedido AS dp ON p.IdPedido=dp.IdPedido WHERE p.IdPedido='$idpedido' AND dp.DsctoEspecial>0 AND dp.DsctoEspecialAltipal>0 GROUP BY p.IdPedido";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getPedidoProveedor($idpedido) {
        $sql = "SELECT p.IdPedido,p.CodZonaVentas,p.CuentaCliente,p.CodGrupoVenta,dp.CuentaProveedor FROM `pedidos` AS p INNER JOIN descripcionpedido AS dp ON p.IdPedido=dp.IdPedido WHERE p.IdPedido='$idpedido' AND dp.DsctoEspecial>0 AND dp.DsctoEspecialProveedor>0 GROUP BY dp.CuentaProveedor";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getAdministradoresConfiguradosAltipal($grupoVentas, $agencia) {
        $sql = "SELECT a.Id,a.Cedula,a.Usuario,a.Clave,a.Nombres,a.Apellidos,a.Email FROM `administrador` AS a 
        INNER JOIN configuracionadministrador AS ca ON a.Id=ca.IdAdministrador 
        INNER JOIN configuracionaprobaciondocumentos AS cad ON a.Id=cad.IdAdministrador 
        INNER JOIN configuracionperfil AS cf ON a.IdPerfil=cf.IdPerfil 
        WHERE a.Activo='1' AND ca.CodigoGrupoVentas='$grupoVentas' AND CodAgencia='$agencia' AND cad.EnvioCorreo='1' AND cad.CodigoProveedor='0' AND cf.IdListaMenu='4' AND cf.IdListaLink='28' AND cf.IdAccion='37' GROUP BY a.Id";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getAdministradoresConfiguradosProveedor($grupoVentas, $agencia, $proveedor) {
        $sql = "SELECT a.Id,a.Cedula,a.Usuario,a.Clave,a.Nombres,a.Apellidos,a.Email FROM `administrador` AS a 
        INNER JOIN configuracionadministrador AS ca ON a.Id=ca.IdAdministrador 
        INNER JOIN configuracionaprobaciondocumentos AS cad ON a.Id=cad.IdAdministrador 
        INNER JOIN configuracionperfil AS cf ON a.IdPerfil=cf.IdPerfil 
        WHERE a.Activo='1' AND ca.CodigoGrupoVentas='$grupoVentas' AND CodAgencia='$agencia' AND cad.EnvioCorreo='1' AND cad.CodigoProveedor='$proveedor' AND cf.IdListaMenu='4' AND cf.IdListaLink='28' AND cf.IdAccion='37' GROUP BY a.Id";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getTotalAcuerdos($CuentaCliente, $CodigoGrupoPrecio) {
        $sql = "SELECT COUNT(*) AS TotalAcuerdos FROM `acuerdoscomercialesprecioventa` WHERE CuentaCliente='$CuentaCliente' OR CodigoGrupoPrecio='$CodigoGrupoPrecio'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getSaldoDisponible($CuentaCliente) {
        $sql = "SELECT SaldoCupo FROM `clienteruta` where CuentaCliente='$CuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getActualizarsaldocupocliente($SaldoActual, $cuentaCliente, $zonaVentas) {
        $sql = "UPDATE `clienteruta` SET `SaldoCupo`='$SaldoActual' WHERE `CuentaCliente`='$cuentaCliente' and CodZonaVentas='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function getUpdateEstadoDescuento($idPedido) {
        $sql = "UPDATE `pedidos` SET `Estado`='1' WHERE IdPedido='$idPedido'";
        $connection = Multiple::getConexionZonaVentas();
        $connection->createCommand($sql)->query();
    }

    public function getZonaFactura($CodZonaVentas) {
        $sql = "SELECT CodAgencia FROM `zonaventasglobales` where CodZonaVentas='$CodZonaVentas'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getActualizarSaldoFacturasAgencia($agencia, $valorabono, $factura) {
        $sql = "UPDATE facturasaldo SET `SaldoFactura`='$valorabono' WHERE `NumeroFactura`='$factura'";
        return Multiple::queryAgencia($agencia, $sql);
    }

    public function getFormasdePago($cuentaCliente) {
        $sql = "SELECT CodigoCondicionPago FROM `clienteruta` WHERE CuentaCliente='$cuentaCliente'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function getPedidoRelizadoActual($CuentaCliente) {
        try {
            $sql = "SELECT COUNT(*) as pedidoactuales FROM `pedidos` where CuentaCliente='$CuentaCliente' AND FechaPedido=CURDATE()";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $exc) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getCupoLimite($zonaVentas) {
        try {
            $sql = "SELECT CupoLimiteAutoventa FROM `zonaventaalmacen` WHERE CodZonaVentas='$zonaVentas'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $exc) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getPedidoZonaVentas($zonaVentas) {
        try {
            $sql = "SELECT SUM( ValorPedido ) AS Pedidos FROM `pedidos` WHERE CodZonaVentas='$zonaVentas' AND FechaTerminacion='00-00-00' AND HoraTerminacion='00:00:00'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $exc) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    Public function getTansferenciasEchas($ZonaTransferir) {
        try {
            $sql = "SELECT SUM(TotalTransferencia) AS totaltransferencia FROM `transferenciaautoventa` where CodZonaVentasTransferencia='$ZonaTransferir' and FechaTransferenciaAutoventa=CURDATE()";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $exc) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getEstadoDescuento($IdPedido) {
        try {
            $sql = "SELECT COUNT(*) as pedidosdescuentos FROM `pedidos` p join descripcionpedido dp on p.IdPedido=dp.IdPedido WHERE dp.IdPedido='$IdPedido' AND dp.DsctoEspecial > 0";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getEstadoActividadDescuento($IdPedido) {
        try {
            $sql = "SELECT COUNT(*) as pedidosdescuentosactividad FROM `pedidos` p join descripcionpedido dp on p.IdPedido=dp.IdPedido WHERE dp.IdPedido='$IdPedido' AND dp.DsctoEspecial > 0 AND p.ActividadEspecial > 0";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getUpdateEstadoPedidoDescuento($IdPedido) {
        try {
            $sql = "UPDATE `pedidos` SET `Estado`='1' WHERE `IdPedido`='$IdPedido' AND `ActividadEspecial`='0'";
            $connection = Multiple::getConexionZonaVentas();
            $connection->createCommand($sql)->query();
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getUpdateEstadoPedidoDescuentoActividad($IdPedido) {
        try {
            $sql = "UPDATE `pedidos` SET `Estado`='2' WHERE `IdPedido`='$IdPedido'";
            $connection = Multiple::getConexionZonaVentas();
            $connection->createCommand($sql)->query();
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    /*
     * inserta en la tabla de log ingreso en la base de datos principal
     * @parameters
     * String @ZonaVentas
     * Date @Fecha
     * Time @Hora 
     */

    public function InsertLogIngreso($ZonaVentas, $Fecha, $Hora) {
        try {
            $sql = "INSERT INTO `LogIngreso`(`CodigoZonaVentas`, `FechaIngreso`, `HoraIngreso`, `Version`) VALUES ('$ZonaVentas','$Fecha','$Hora','WEB')";
            Yii::app()->db->createCommand($sql)->query();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            exit();
        }
    }

    public function getReporteHoraVisita($agencia, $fechaini, $fechafin, $grupoventas) {
        try {
            $sql = "SELECT z.CodZonaVentas,jerar.NombreJefe,ases.Nombre,ases.TelefonoMovilEmpresarial,ases.TelefonoMovilPersonal,jerar.CelularCorporativoJefe FROM pedidos p 
            INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
            INNER JOIN zonaventas z ON p.CodZonaVentas=z.CodZonaVentas
            INNER JOIN gruposventas g ON z.CodigoGrupoVentas=g.CodigoGrupoVentas
            INNER JOIN asesorescomerciales ases ON z.CodAsesor=ases.CodAsesor
            INNER JOIN jerarquiacomercial jerar ON z.CodZonaVentas=jerar.CodigoZonaVentas 
            WHERE p.FechaPedido between '$fechaini' AND '$fechafin' AND z.CodigoGrupoVentas='$grupoventas' GROUP BY p.CodZonaVentas";
            return Multiple::consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPrimerPedido($agencia, $fechaini, $ZonaVentas) {
        try {
            $sql = "SELECT MIN(HoraEnviado) AS Hora1erPedido FROM pedidos WHERE FechaPedido='$fechaini' AND CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getUltimoPedido($agencia, $fechaini, $ZonaVentas) {
        try {
            $sql = "SELECT MAX(HoraEnviado) AS HoraUltimoPedido FROM pedidos WHERE FechaPedido='$fechaini' AND CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getHoraCierre($agencia, $fechaini, $ZonaVentas) {
        try {
            $sql = "SELECT HoraMensaje AS HoraCierre FROM `mensajes` WHERE Mensaje='Termino Ruta' AND FechaMensaje='$fechaini' AND IdRemitente='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getClientesConCompras($agencia, $fechaini, $fechafin, $ZonaVentas) {
        try {
            $sql = "SELECT COUNT(DISTINCT CuentaCliente) AS ClientesConCompras FROM `pedidos` WHERE FechaPedido between '$fechaini' AND '$fechafin' AND CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getClientesSinCompras($agencia, $fechaini, $fechafin, $ZonaVentas) {
        try {
            $sql = "SELECT COUNT(DISTINCT cli.CuentaCliente) AS ClientesSinCompras FROM `noventas` WHERE FechaNoVenta between '$fechaini' AND '$fechafin' AND CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getClientesNuevosHoraVisita($agencia, $fechaini, $fechafin, $ZonaVentas) {
        try {
            $sql = "SELECT COUNT(*) AS TotalClientesNuevos FROM `clientenuevo` WHERE CodZonaVentas='$ZonaVentas' AND FechaRegistro between '$fechaini' AND '$fechafin'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getValorTotalPedidos($agencia, $fechaini, $fechafin, $ZonaVentas) {
        try {
            $sql = "SELECT TotalSubtotalBaseIva as TotalValorPedido FROM `pedidos` WHERE FechaPedido between '$fechaini' and '$fechafin' AND CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getTotalPedidos($agencia, $fechaini, $fechafin, $ZonaVentas) {
        try {
            $sql = "SELECT COUNT(IdPedido) as TotalPedidos FROM `pedidos` WHERE FechaPedido between '$fechaini' and '$fechafin' AND CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getIngresoSistema($ZonaVentas) {
        try {
            $sql = "SELECT MAX(HoraIngreso) as horaIngreso FROM `LogIngreso` WHERE CodigoZonaVentas='$ZonaVentas'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            exit();
        }
    }

    public function getReportePedidosActivityAx($agencia, $fechaini, $fechafin, $grupoventa) {
        try {
            $sql = "SELECT g.NombreGrupoVentas,p.CodZonaVentas,ases.Nombre,(SELECT Nombre FROM agencia) as agencia FROM pedidos p 
            INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
            INNER JOIN zonaventas z ON p.CodZonaVentas=z.CodZonaVentas
            INNER JOIN gruposventas g ON z.CodigoGrupoVentas=g.CodigoGrupoVentas
            INNER JOIN asesorescomerciales ases ON z.CodAsesor=ases.CodAsesor
            WHERE p.FechaPedido between '$fechaini' AND '$fechafin' AND p.CodGrupoVenta='$grupoventa' GROUP BY p.CodZonaVentas ";
            return Multiple::consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getPedidoAx($agencia, $fechaini, $fechafin, $zona) {
        try {
            $sql = "SELECT COUNT(*) AS TotalPedidosAx FROM `pedidos` WHERE ArchivoXml <> '' AND CodZonaVentas='$zona' AND FechaPedido between '$fechaini' and '$fechafin'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getClienteRutas($agencia, $fechaini, $fechafin, $zona) {
        try {
            $sql = "SELECT COUNT(cli.CuentaCliente) AS ClienteRuta FROM `clienteruta` cli join pedidos p on cli.CuentaCliente=p.CuentaCliente WHERE cli.CodZonaVentas='$zona' AND p.FechaPedido between '$fechaini' AND '$fechafin'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getPedidosExtraRuta($agencia, $fechaini, $fechafin, $zona) {
        try {
            $sql = "SELECT COUNT(*) as PedidosExtraRuta FROM pedidos WHERE ExtraRuta > 0 AND CodZonaVentas='$zona' AND FechaPedido between '$fechaini' and '$fechafin'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getPedidosActivity($agencia, $fechaini, $fechafin, $zona) {
        try {
            $sql = "SELECT COUNT(*) as PedidosActivity FROM pedidos WHERE CodZonaVentas='$zona' AND FechaPedido between '$fechaini' and '$fechafin'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getClientesNuevos($agencia, $fechaini, $fechafin, $zona) {
        try {
            $sql = "SELECT COUNT(DISTINCT clinuv.CuentaCliente) AS ClienteNuevos FROM `clientenuevo` clinuv join pedidos p on clinuv.CuentaCliente=p.CuentaCliente WHERE p.CodZonaVentas='$zona' AND p.FechaPedido between '$fechaini' AND '$fechafin'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getDetallePedidoZonas($agencia, $zona, $fechaini, $fechafin) {
        try {
            $sql = "SELECT p.*,ases.Nombre
            FROM `pedidos` p
            INNER JOIN asesorescomerciales ases ON p.CodAsesor=ases.CodAsesor
            WHERE p.CodZonaVentas='$zona' AND FechaPedido BETWEEN '$fechaini' AND '$fechafin' ORDER BY p.FechaPedido ASC";
            return Multiple::consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getClientesNuevosPedidos($agencia, $CuentaCliente) {
        try {
            $sql = "SELECT COUNT(*) as clientesnuevos FROM `pedidos` p join clientenuevo clinvu on p.CuentaCliente=clinvu.CuentaCliente where p.CuentaCliente='$CuentaCliente'";
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getDescripcionesPedidos($agencia, $IdPedido) {
        try {
            $sql = "SELECT p.IdPedido, p.ArchivoXml, p.CuentaCliente, dp.CodVariante, dp.CodigoArticulo, dp.Cantidad, cli.NombreCliente, por.NombreArticulo
            FROM `pedidos` p
            INNER JOIN descripcionpedido dp ON p.IdPedido=dp.IdPedido
            INNER JOIN cliente cli ON cli.CuentaCliente=p.CuentaCliente
            LEFT JOIN portafolio por ON dp.CodVariante=por.CodigoVariante
            WHERE p.IdPedido='$IdPedido'
            GROUP BY por.CodigoVariante";
            return Multiple::consultaAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getAsesoresComercial() {
        try {
            $sql = "SELECT DISTINCT(asesores.Agencia),asesores.Nombre,asesores.CodAsesor,asesores.Cedula,asesores.Clave,asesores.Version,asesores.NuevaVersion,z.CodZonaVentas FROM `asesorescomerciales` asesores INNER JOIN zonaventas z ON asesores.CodAsesor=z.CodAsesor";
            return Multiple::multiConsulta($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAgencias($CodAgencia) {
        try {
            $sql = "SELECT * FROM `agencia` WHERE CodAgencia='$CodAgencia'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getUpdateVersion($asesores, $version) {
        try {
            $sql = "UPDATE asesorescomerciales SET NuevaVersion='$version' WHERE CodAsesor='$asesores'";
            return Multiple::multiQuery($sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function getUltimaVersion() {
        try {
            $sql = "SELECT MAX(Version) as version FROM `versiones`";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAgenciasPaginaWeb() {
        try {
            $sql = "SELECT * FROM `agencia`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getZonaVentasxAgencia($codAgencia) {
        try {
            $sql = "SELECT * FROM `zonaventas` z INNER JOIN gruposventas g ON z.CodigoGrupoVentas=g.CodigoGrupoVentas WHERE g.CodAgencia='$codAgencia' GROUP BY z.CodZonaVentas";
            return Multiple::consultaAgencia($codAgencia, $sql);
        } catch (Exception $ex) {
            echo $exc->getMessage('Error');
            return false;
        }
    }

    public function InsertPermisoPaginaWeb($agencia, $zona, $fechaini, $fechafin, $observacion) {
        try {
            $sql = "INSERT INTO `permisospaginaweb`(`CodAgencia`,`CodZonaVentas`,`FechaInicial`,`FechaFinal`,`Observacion`) VALUES ('$agencia','$zona','$fechaini','$fechafin','$observacion')";
            Yii::app()->db->createCommand($sql)->query();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getValidarPermisosWeb($ZonaVentas) {
        try {
            $sql = "SELECT MAX(FechaInicial) as FechaInicial,MAX(FechaFinal) as FechaFinal FROM `permisospaginaweb` WHERE CodZonaVentas='$ZonaVentas'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPermisosWebZonaNoExitentes($ZonaVentas) {
        try {
            $sql = "SELECT COUNT(*) AS zonaventa FROM `permisospaginaweb` WHERE CodZonaVentas='$ZonaVentas'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAdministradores($usuario) {
        try {
            $sql = "SELECT Usuario FROM `administrador` WHERE Usuario='$usuario'";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getVersiones() {
        try {
            $sql = "SELECT * FROM `versiones`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getMensaje($zonaVentas) {
        try {
            $sql = "SELECT * FROM `mensajes` where IdDestinatario='$zonaVentas' AND Estado='0'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPendientesPorFacturar($zonaVentas) {
        try {
            $sql = "SELECT * FROM `pendientesporfacturar` WHERE SalesZona='$zonaVentas'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getMallaActivacion($CuentaCliente) {
        try {
            $sql = "SELECT * FROM `mallaactivacion` ma INNER JOIN mallaactivaciondetalle mad ON ma.Id=mad.IdMallaActivacion WHERE mad.CuentaCliente='$CuentaCliente'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPresupuestoZona($zonaVentas) {
        try {
            $sql = "SELECT * FROM `presupuestos` pre INNER JOIN zonaventas z ON pre.CodZonaVentas=z.CodZonaVentas INNER JOIN asesorescomerciales asesor ON z.CodAsesor=asesor.CodAsesor WHERE pre.CodZonaVentas='$zonaVentas'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getDimenciones($IdPresupuesto) {
        try {
            $sql = "SELECT * FROM `presupuestodimensiones` where IdPresupuesto='$IdPresupuesto'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getProfundidad($IdPresupuesto) {
        try {
            $sql = "SELECT * FROM `presupuestoprofundidad` where IdPresupuesto='$IdPresupuesto' ORDER BY PorcentajeCumplimiento DESC";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getProveedoresPresupuesto($IdPresupuesto) {
        try {
            $sql = "SELECT * FROM `presupuestofabricante` where IdPresupuesto='$IdPresupuesto'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getSitiosConPreventa($zonaVentas, $codigoSitio, $codagencia) {
        try {
            $sql = "SELECT COUNT(*) AS sitios FROM `zonaventaalmacen` WHERE CodZonaVentas='$zonaVentas' AND Preventa='verdadero' AND CodigoSitio<>'$codigoSitio'";
            return Multiple::consultaAgenciaRow($codagencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getCanales() {
        try {
            $sql = "SELECT distinct(NombreCanal) FROM `jerarquiacomercial` WHERE NombreCanal<>''";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getCodigoZonaVentas($NombreZona) {
        $sql = "SELECT * FROM `jerarquiacomercial` WHERE `NombreEmpleado`='$NombreZona'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getPresupuestoCanal($canal) {
        try {
            $sql = "SELECT SUM(prefa.Pesos) AS pesos,SUM(prefa.CuotaPesos) AS cuotapesos,jerar.NombreCanal FROM `presupuestos` pre 
        INNER JOIN presupuestofabricante prefa ON pre.Id=prefa.IdPresupuesto
        INNER JOIN jerarquiacomercial jerar ON pre.CodZonaVentas=jerar.CodigoZonaVentas
        WHERE jerar.NombreCanal='$canal'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function insertCoordenadaPedido($agencia, $sql) {
        try {
            return Multiple::queryAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function idpedidocoordenada($agencia, $sql) {
        try {
            return Multiple::consultaAgenciaRow($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getPedidoActual($cuentaCliente) {
        try {
            $sql = "SELECT COUNT(*) as pedidos FROM `pedidos` WHERE FechaPedido=CURDATE() AND CuentaCliente='$cuentaCliente'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAsesorZona($ZonaVentas, $codagencia) {
        try {
            $sql = "SELECT CodAsesor FROM `zonaventas` WHERE CodZonaVentas='$ZonaVentas'";
            return Multiple::consultaAgenciaRow($codagencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAsesorExistente($cedula) {
        try {
            $sql = "SELECT COUNT(*) as asesorexiste FROM `asesorescomerciales` WHERE CodAsesor='$cedula'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getZonaLogistioca($SemanaRuta, $RutaSeleccionada, $zona) {
        try {
            $sql = "SELECT CodigoZonaLogistica FROM `clienteruta` cr INNER JOIN frecuenciavisita f ON cr.`NumeroVisita`=f.NumeroVisita WHERE " . $SemanaRuta . "='$RutaSeleccionada' AND cr.CodZonaVentas='$zona' GROUP BY CodigoZonaLogistica ORDER BY `cr`.`CodigoZonaLogistica` DESC";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getGrupVentas($zonaventas) {
        try {
            $sql = "SELECT CodigoGrupoVentas FROM `zonaventas` where CodZonaVentas='$zonaventas'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getCorreoVentaDirecta($cuentaProveedor) {
        try {
            $sql = "SELECT c.* , a.Nombre as NombreAgencia FROM `configuracioncorreoventadirecta` AS c INNER JOIN agencia AS a ON c.`CodAgencia`=a.CodAgencia";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getNombreProveedor($cuentaProveedor) {
        try {
            $sql = "SELECT NombreCuentaProveedor FROM `proveedores` where CodigoCuentaProveedor='$cuentaProveedor'";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getFactorConvercionUnidad($agencia, $codigoArticulo, $nombreUnidad) {
        try {
            $sqlFactor = "SELECT `Factor` FROM `unidadesdeconversion` WHERE `CodigoArticulo`='$codigoArticulo' AND `NombreDesdeUnidad`='$nombreUnidad' AND `NombreHastaUnidad`='Unidad'";
            return Multiple::consultaAgenciaRow($agencia, $sqlFactor);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getFacturasSaldoCliente($Nit) {
        try {
            $sql = "SELECT * FROM `facturasaldo` fs INNER JOIN cliente AS cli ON fs.CuentaCliente=cli.CuentaCliente WHERE cli.Identificacion='$Nit'
                    AND fs.FechaVencimientoFactura<CURDATE();";
            return Multiple::multiQueryFacturas($sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getRecibosCajaFacturaNumeroFactura($NumeroFactura) {
        try {
            $sql = "SELECT rf.*,rc.* FROM `reciboscajafacturas` AS rf INNER JOIN `reciboscheque` AS rc ON rf.Id=rc.IdReciboCajaFacturas
                    WHERE rf.`NumeroFactura`='$NumeroFactura' AND rc.Posfechado=1";
            $connection = Multiple::getConexionZonaVentas();
            return $connection->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function getAllAgencia($zonaventas) {
        $sql = "SELECT * FROM `zonaventaalmacen` WHERE `CodZonaVentas`='$zonaventas'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getProveedoresVentadirecta($codAgencia) {
        $sql = "SELECT * FROM `proveedoresventadirecta` WHERE `CodAgencia`='$codAgencia'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getListaMaterialesDetalles($codVariate, $codgrupoVentas) {
        $sql = "SELECT lm.*,lmd.*,p.* FROM `listademateriales` as lm 
			INNER JOIN `listadematerialesdetalle` as lmd on lm.CodigoListaMateriales=lmd.CodigoListaMateriales 
			INNER JOIN `portafolio` as p on lmd.CodigoVarianteComponente=p.CodigoVariante 
			where lm.`CodigoVarianteKit`='$codVariate'and p.CodigoGrupoVentas='$codgrupoVentas' and lmd.`TotalPrecioVentaBaseVariante`>0 and lmd.`PrecioVentaBaseVariante`>0";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    //////////*permisoss web todas las zonas//////////////////

    /* public function getTodaslasZonas() {
      $sql="SELECT * FROM zonaventasglobales";
      return Yii::app()->db->createCommand($sql)->queryAll();
      }

      public function insertTodaslasZonas($zona,$agencia) {
      $sql="INSERT INTO `permisospaginaweb`(`CodAgencia`, `CodZonaVentas`, `FechaInicial`, `FechaFinal`, `Observacion`) VALUES ('$agencia','$zona','2015-12-01','2015-12-31','pruebas altipal')";
      Yii::app()->db->createCommand($sql)->query();
      } */
}
