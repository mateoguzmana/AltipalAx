<?php

/**
 * This is the model class for table "semanas".
 *
 * The followings are the available columns in table 'semanas':
 * @property integer $id
 * @property integer $ano
 * @property integer $mes
 * @property integer $semana
 * @property string $fechaInicial
 * @property string $fechaFinal
 * @property string $hora
 * @property string $fecha
 * @property integer $idUsuario
 */
class Clientes extends ConexionActive {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getClientes() {
        //Clientes
        $datosClientes = array();
        $sql = "SELECT 
            f.NumeroVisita,
            f.CodFrecuencia,
            f.R1,
            f.R2,
            f.R3,
            f.R4,
            cr.IdClienteRuta,
            cr.CodZonaVentas,
            cr.CuentaCliente,
            cr.Posicion,
            cr.CodigoZonaLogistica,
            zl.NombreZonaLogistica,
            cr.ValorCupo,
            cr.ValorCupoTemporal,
            cr.SaldoCupo,
            c.Identificacion,
            c.NombreCliente,
            c.NombreBusqueda,
            c.DireccionEntrega,
            c.Telefono,
            c.TelefonoMovil,
            c.CorreoElectronico,
            c.Estado,
            c.CodigoCadenaEmpresa,
            cd.Nombre AS NombreCadenaEmpresa,
            cd.ValorMinimo,
            cd.CodSubSegmento,
            sg.Nombre AS NombreSubsegmento,
            sg.CodSegmento,
            sgt.Nombre AS NombreSegmento,
            cr.CodigoCondicionPago,
            cp.Descripcion AS DescripcionCondicionPago,
            cp.Dias,
            cr.CodigoFormadePago,
            fp.Descripcion AS DescripcionFormaPago,
            fp.CuentaPuente,
            c.CodigoBarrio,
            lo.NombreBarrio AS NombreBarrio,
            lo.CodigoLocalidad AS CodigoLocalidad,
            lo.NombreLocalidad AS NombreLocalidad,
            lo.CodigoCiudad AS CodigoCiudad,
            lo.NombreCiudad AS NombreCiudad,
            lo.CodigoDepartamento AS CodigoDepartamento,
            lo.NombreDepartamento AS NombreDepartamento,
            c.CodigoPostal,
            c.Latitud,
            c.Longitud,
            cr.CodigoGrupodeImpuestos,
            gi.NombreGrupoImpuestos,
            gi.CodigoTipoContribuyente,
            gi.NombreTipoContribuyente,
            gi.CodigoDepartamento AS CodigoDepartamentoImpuesto,
            gi.NombreDepartamento AS NombreDepartamentoImpuesto,
            gi.CodigoCiudad AS CodigoCiudadImpuesto,
            gi.NombreCiudad AS NombreCiudadImpuesto,
            cr.CodigoGrupoPrecio,
            gp.NombreGrupodePrecio,
            cr.CodigoGrupoDescuentoLinea,
            'N/N',
            cr.CodigoGrupoDescuentoMultiLinea,
            'N/N',
            cr.DiasGracia,
            cr.DiasAdicionales
            FROM 
            `frecuenciavisita` f
            INNER JOIN clienteruta  cr ON cr.NumeroVisita=f.NumeroVisita            
            INNER JOIN cliente  c ON c.CuentaCliente=cr.CuentaCliente
            INNER JOIN zonaventas  z ON cr.`CodZonaVentas`=z.`CodZonaVentas`
            LEFT JOIN zonalogistica zl ON zl.CodZonaLogistica=cr.CodigoZonaLogistica
            LEFT JOIN cadenaempresa cd ON cd.CodigoCadenaEmpresa=c.CodigoCadenaEmpresa
            LEFT JOIN subsegmento sg ON sg.CodSubSegmento=cd.CodSubSegmento
            LEFT JOIN segmentos sgt ON sgt.CodSegmento=sg.CodSegmento
            LEFT JOIN condicionespago cp ON cp.CodigoCondicionPago=cr.CodigoCondicionPago       
            LEFT JOIN formaspago fp ON fp.CodigoFormadePago=cr.CodigoFormadePago
            LEFT JOIN Localizacion lo ON lo.CodigoBarrio = c.CodigoBarrio
            LEFT JOIN grupoimpuestos gi ON gi.CodigoGrupoImpuestos=cr.CodigoGrupodeImpuestos
            LEFT JOIN grupodeprecios gp ON gp.CodigoGrupoPrecio=cr.CodigoGrupoPrecio
            WHERE cr.CodZonaVentas='$zonaVentas' AND
            (`R1`='$ruta' OR `R2`='$ruta' OR `R3`='$ruta' OR `R4`='$ruta') GROUP BY cr.CuentaCliente;";
        $rs_cltes = $db->ejecutar($sql);
        if ($rs_cltes) {
            while ($col_cltes = $db->obtener_fila($rs_cltes, 0)) {

                $DescripcionFormaPago = trim($col_cltes['DescripcionFormaPago']);
                if (($DescripcionFormaPago == "NULL") || ($DescripcionFormaPago == "null")) {
                    $DescripcionFormaPago = "";
                }
                $codigoCondicionPago = trim($col_cltes['CodigoCondicionPago']);

                if ($codigoCondicionPago == 022) {

                    $valorCupoCliente = 0;
                } else {

                    $valorCupoCliente = trim($col_cltes['SaldoCupo']);
                }
                $sqlSaldoFavor = "SELECT ABS(SUM(`SaldoFactura`)) AS saldo FROM `facturasaldo` WHERE `CuentaCliente`='" . $col_cltes['CuentaCliente'] . "' AND `SaldoFactura` < 0;";
                $stFavor = $db->ejecutar($sqlSaldoFavor);
                $resu = $db->obtener_fila($stFavor, 0);
                $saldoFavor = $resu['saldo'];

                if (empty($saldoFavor) || is_null($saldoFavor)) {
                    $saldoFavor = '0';
                }
                $json = array(
                    'NumeroVisita' => $col_cltes['NumeroVisita'],
                    'CodFrecuencia' => $col_cltes['CodFrecuencia'],
                    'R1' => $col_cltes['R1'],
                    'R2' => $col_cltes['R2'],
                    'R3' => $col_cltes['R3'],
                    'R4' => $col_cltes['R4'],
                    'IdClienteRuta' => $col_cltes['IdClienteRuta'],
                    'CodZonaVentas' => $col_cltes['CodZonaVentas'],
                    'CuentaCliente' => trim($col_cltes['CuentaCliente']),
                    'Posicion' => $col_cltes['Posicion'],
                    'CodigoZonaLogistica' => $col_cltes['CodigoZonaLogistica'],
                    'NombreZonaLogistica' => $col_cltes['NombreZonaLogistica'],
                    'ValorCupo' => $col_cltes['ValorCupo'],
                    'ValorCupoTemporal' => $col_cltes['ValorCupoTemporal'],
                    'SaldoCupo' => vacio($valorCupoCliente),
                    'Identificacion' => $col_cltes['Identificacion'],
                    'NombreCliente' => $col_cltes['NombreCliente'],
                    'NombreBusqueda' => $col_cltes['NombreBusqueda'],
                    'DireccionEntrega' => $col_cltes['DireccionEntrega'],
                    'Telefono' => $col_cltes['Telefono'],
                    'TelefonoMovil' => vacio($col_cltes['TelefonoMovil']),
                    'CorreoElectronico' => $col_cltes['CorreoElectronico'],
                    'Estado' => $col_cltes['Estado'],
                    'CodigoCadenaEmpresa' => $col_cltes['CodigoCadenaEmpresa'],
                    'NombreCadenaEmpresa' => vacio($col_cltes['NombreCadenaEmpresa']),
                    'ValorMinimo' => $col_cltes['ValorMinimo'],
                    'CodSubSegmento' => $col_cltes['CodSubSegmento'],
                    'NombreSubsegmento' => $col_cltes['NombreSubsegmento'],
                    'CodSegmento' => $col_cltes['CodSegmento'],
                    'NombreSegmento' => $col_cltes['NombreSegmento'],
                    'CodigoCondicionPago' => $col_cltes['CodigoCondicionPago'],
                    'DescripcionCondicionPago' => $col_cltes['DescripcionCondicionPago'],
                    'Dias' => vacio($col_cltes['Dias']),
                    'CodigoFormadePago' => $col_cltes['CodigoFormadePago'],
                    'DescripcionFormaPago' => $DescripcionFormaPago,
                    'CuentaPuente' => $col_cltes['CuentaPuente'],
                    'CodigoBarrio' => $col_cltes['CodigoBarrio'],
                    'NombreBarrio' => $col_cltes['NombreBarrio'],
                    'CodigoLocalidad' => $col_cltes['CodigoLocalidad'],
                    'NombreLocalidad' => $col_cltes['NombreLocalidad'],
                    'CodigoCiudad' => $col_cltes['CodigoCiudad'],
                    'NombreCiudad' => $col_cltes['NombreCiudad'],
                    'CodigoDepartamento' => $col_cltes['CodigoDepartamento'],
                    'NombreDepartamento' => $col_cltes['NombreDepartamento'],
                    'CodigoPostal' => $col_cltes['CodigoPostal'],
                    'Latitud' => $col_cltes['Latitud'],
                    'Longitud' => $col_cltes['Longitud'],
                    'CodigoGrupodeImpuestos' => $col_cltes['CodigoGrupodeImpuestos'],
                    'NombreGrupoImpuestos' => $col_cltes['NombreGrupoImpuestos'],
                    'CodigoTipoContribuyente' => $col_cltes['CodigoTipoContribuyente'],
                    'NombreTipoContribuyente' => $col_cltes['NombreTipoContribuyente'],
                    'CodigoDepartamentoImpuesto' => $col_cltes['CodigoDepartamentoImpuesto'],
                    'NombreDepartamentoImpuesto' => $col_cltes['NombreDepartamentoImpuesto'],
                    'CodigoCiudadImpuesto' => $col_cltes['CodigoCiudadImpuesto'],
                    'NombreCiudadImpuesto' => $col_cltes['NombreCiudadImpuesto'],
                    'CodigoGrupoPrecio' => $col_cltes['CodigoGrupoPrecio'],
                    'NombreGrupodePrecio' => $col_cltes['NombreGrupodePrecio'],
                    'CodigoGrupoDescuentoLinea' => $col_cltes['CodigoGrupoDescuentoLinea'],
                    'NombreGrupoDescuentoLinea' => 'N/N',
                    'CodigoGrupoDescuentoMultiLinea' => $col_cltes['CodigoGrupoDescuentoMultiLinea'],
                    'NombreGrupoDescuentoMultiLinea' => 'N/N',
                    'SaldoFavor' => $saldoFavor,
                    'DiasGracia' => $col_cltes['DiasGracia'],
                    'DiasAdicionales' => $col_cltes['DiasAdicionales']);
                array_push($datosClientes, $json);
            }
        }
        $subArray = array('Clientes' => $datosClientes);

        return json_encode($subArray);
    }

    public function getRestriccionCuentaProveedor($db) {
        //Restrinccion Proveedor
        $restrinccion = array();
        $sqlRs = "SELECT rp.* FROM `restriccioncuentaproveedor` AS rp 
            INNER JOIN clienteruta AS cr ON cr.CuentaCliente=rp.CuentaCliente 
            INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita=cr.NumeroVisita 
            WHERE rp.CodZonaVentas='" . $zonaVentas . "' AND cr.CodZonaVentas='" . $zonaVentas . "' AND
            (`R1`='$ruta' OR `R2`='$ruta' OR `R3`='$ruta' OR `R4`='$ruta' ); ";
        $rs_cltesRs = $db->ejecutar($sqlRs);
        if ($rs_cltesRs) {
            while ($col_cltesRs = $db->obtener_fila($rs_cltesRs, 0)) {

                $json = array(
                    'Id' => $col_cltesRs['Id'],
                    'CuentaCliente' => $col_cltesRs['CuentaCliente'],
                    'CodZonaVentas' => $col_cltesRs['CodZonaVentas'],
                    'CuentaProveedor' => $col_cltesRs['CuentaProveedor'],
                    'TipoCuenta' => $col_cltesRs['TipoCuenta'],
                    'CodigoVariante' => $col_cltesRs['CodigoVariante'],
                    'CodigoArticulo' => $col_cltesRs['CodigoArticulo'],
                    'CodigoArticuloGrupoCategoria' => $col_cltesRs['CodigoArticuloGrupoCategoria'],
                    'Tipo' => $col_cltesRs['Tipo'],
                    'Caracteristica1' => $col_cltesRs['Caracteristica1'],
                    'Caracteristica2' => $col_cltesRs['Caracteristica2']
                );
                array_push($restrinccion, $json);
            }
        }

        $subArray = array('RestrinccionProveedor' => $restrinccion);

        return json_encode($subArray);
    }

    public function getLocalizacion() {
        //Localizacion
        $datosLocalizacion = array();
        $sqlLocali = "SELECT l.CodigoBarrio,l.NombreBarrio,l.CodigoLocalidad,l.NombreLocalidad,l.CodigoCiudad,l.NombreCiudad,l.CodigoDepartamento,l.NombreDepartamento,l.CodigoPais,l.NombrePais FROM `Localizacion` AS l INNER JOIN cliente AS c ON l.CodigoBarrio =c.CodigoBarrio GROUP BY c.CodigoBarrio;";
        $rsLocali = $db->ejecutar($sqlLocali);
        if ($rsLocali) {

            while ($row = $db->obtener_fila($rsLocali, 0)) {
                $json = array(
                    'CodigoBarrio' => $row['CodigoBarrio'],
                    'NombreBarrio' => $row['NombreBarrio'],
                    'CodigoLocalidad' => $row['CodigoLocalidad'],
                    'NombreLocalidad' => $row['NombreLocalidad'],
                    'CodigoCiudad' => $row['CodigoCiudad'],
                    'NombreCiudad' => $row['NombreCiudad'],
                    'CodigoDepartamento' => $row['CodigoDepartamento'],
                    'NombreDepartamento' => $row['NombreDepartamento'],
                    'CodigoPais' => $row['CodigoCiudad'],
                    'NombrePais' => $row['NombrePais']
                );
                array_push($datosLocalizacion, $json);
            }
        }
    }

    public function getPreguntasEncuesta() {
        //Preguntas Encuesta Segmentacion
        $datosPreguntasEncuesta = array();
        $sql_preguntas_encuesta = "SELECT `Id`, `IdTipoEncuesta`, `Descripcion`, `IdTipoCampo`, `IdEstado` FROM `preguntasencuesta` WHERE `IdTipoEncuesta`=1 AND  `IdEstado`=1";
        $rs_preguntas_encuesta = $db->ejecutar($sql_preguntas_encuesta);
        if ($rs_preguntas_encuesta) {

            while ($col_preguntas_encuesta = $db->obtener_fila($rs_preguntas_encuesta, 0)) {
                $json = array(
                    'Id' => $col_preguntas_encuesta['Id'],
                    'IdTipoEncuesta' => $col_preguntas_encuesta['IdTipoEncuesta'],
                    'Descripcion' => $col_preguntas_encuesta['Descripcion'],
                    'IdTipoCampo' => $col_preguntas_encuesta['IdTipoCampo'],
                    'IdEstado' => $col_preguntas_encuesta['IdEstado']
                );
                array_push($datosPreguntasEncuesta, $json);
            }
        }
    }

    public function getRespuestasEncuesta() {
        //Respuestas Encuesta Segmentacion
        $datosRespuestasEncuesta = array();
        $sql_respuestas_encuesta = "SELECT resp.`Id` as Id, `IdPreguntaEncuesta`, resp.`Descripcion` as Descripcion, `IdSiguientePregunta`, `IdCodigoSegmentacion`, TipoTexto FROM `respuestasencuesta`AS resp INNER JOIN preguntasencuesta AS preg ON resp.`IdPreguntaEncuesta`= preg.Id AND preg.IdTipoEncuesta=1";
        $rs_respuestas_encuesta = $db->ejecutar($sql_respuestas_encuesta);
        if ($rs_respuestas_encuesta) {
            while ($col_respuestas_encuesta = $db->obtener_fila($rs_respuestas_encuesta, 0)) {
                $json = array(
                    'Id' => $col_respuestas_encuesta['Id'],
                    'IdPreguntaEncuesta' => $col_respuestas_encuesta['IdPreguntaEncuesta'],
                    'Descripcion' => $col_respuestas_encuesta['Descripcion'],
                    'IdSiguientePregunta' => $col_respuestas_encuesta['IdSiguientePregunta'],
                    'IdCodigoSegmentacion' => $col_respuestas_encuesta['IdCodigoSegmentacion'],
                    'TipoTexto' => $col_respuestas_encuesta['TipoTexto']
                );
                array_push($datosRespuestasEncuesta, $json);
            }
        }
    }

    public function getDataBases() {
        $colums = "`id` AS iddatabase, `nombre` AS agenciname, `bd` AS database";
        $table = "`bases_datos`";
        $sql = $this->createBasicSelectWithWhere($colums, $table, "");
        return $this->excecuteQueryAll($sql);
    }

}
