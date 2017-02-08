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
class Portafolio extends DatabaseUtilities {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getPortafolio() {
        //Portafolio
        $datosPortafolio = array();
        $sqlPo = "SELECT p.Id,p.CodigoGrupoVentas,p.CodigoVariante,p.CodigoArticulo,p.NombreArticulo,p.CodigoCaracteristica1,p.CodigoCaracteristica2,p.CodigoTipo,tp.Nombre AS NombreTipo,p.CodigoMarca,p.CodigoGrupoCategoria,p.CodigoGrupoDescuentoLinea,p.CodigoGrupoDescuentoMultiLinea,p.CodigoGrupodeImpuestos,p.PorcentajedeIVA,p.ValorIMPOCONSUMO,p.CuentaProveedor,p.DctoPPNivel1,p.DctoPPNivel2,p.IdentificadorProductoNuevo,(SELECT COUNT(1) FROM variantesinactivas AS ina WHERE ina.CodigoVariante=p.CodigoVariante AND ina.CodigoSitio =  'EMPTY' AND ina.CodigoAlmacen =  'EMPTY' ) AS existe,(SELECT NombreCuentaProveedor FROM `proveedores` WHERE CodigoCuentaProveedor = CuentaProveedor) as fabricante,(SELECT IdPrincipal FROM `jerarquiaarticulos` WHERE Nombre = CodigoGrupoCategoria) as grupo,(SELECT MAX(PrecioVenta) FROM `acuerdoscomercialesprecioventa` WHERE CodigoVariante = p.CodigoVariante) as max_val
                    FROM `portafolio` AS p 
                    INNER JOIN zonaventas AS z ON p.CodigoGrupoVentas=z.CodigoGrupoVentas 
                    LEFT JOIN tipoproducto AS tp ON tp.CodigoTipoProducto = p.CodigoTipo
                    WHERE z.CodZonaVentas='" . $usuario . "' 
                    GROUP BY p.CodigoVariante,p.CodigoArticulo HAVING existe=0; ";
        $rs_cltesPo = $db->ejecutar($sqlPo);
        if ($rs_cltesPo) {
            while ($colPo = $db->obtener_fila($rs_cltesPo, 0)) {

                $conteoVarienteInactivas = 0;
                $sqlSitio = "SELECT CodigoSitio FROM zonaventaalmacen WHERE CodZonaVentas = '" . $usuario . "';";
                $stmSitio = $db->ejecutar($sqlSitio);
                $resultadoSitio = $db->obtener_fila($stmSitio, 0);
                $sitioZonaVentas = $resultadoSitio['CodigoSitio'];
                //$almacenZonaVentas = $resultadoSitio['CodigoAlmacen'];

                $sqlVariantesSitio = "SELECT COUNT(*) AS Conteo FROM variantesinactivas  WHERE CodigoVariante='" . $colPo['CodigoVariante'] . "' AND CodigoSitio =  '" . $sitioZonaVentas . "' AND CodigoAlmacen = 'EMPTY';";
                $stmtVariantesSitio = $db->ejecutar($sqlVariantesSitio);
                $resultadoVariantesSitio = $db->obtener_fila($stmtVariantesSitio, 0);
                $ConteoVariantesSitio = $resultadoVariantesSitio['Conteo'];

                /* $sqlVariantesSitioAlmacen = "SELECT COUNT(*) AS Conteo FROM variantesinactivas  WHERE CodigoVariante='" . $colPo['CodigoVariante'] . "' AND CodigoSitio =  '" . $sitioZonaVentas . "' AND CodigoAlmacen = '" . $almacenZonaVentas . "';";
                  $stmtVariantesSitioAlmacen = $db->ejecutar($sqlVariantesSitioAlmacen);
                  $resultadoVariantesSitioAlmacen = $db->obtener_fila($stmtVariantesSitioAlmacen, 0);
                  $ConteoVariantesSitioAlmacen = $resultadoVariantesSitioAlmacen['Conteo']; */

                if ($ConteoVariantesSitio > 0) {
                    $conteoVarienteInactivas++;
                }
                /* if ($ConteoVariantesSitioAlmacen > 0) {
                  $conteoVarienteInactivas++;
                  } */

                if ($conteoVarienteInactivas == 0) {
                    $caracteristica2 = trim(str_replace("N/A", "", $colPo['CodigoCaracteristica2']));
                    $caracteristica2 = trim(str_replace("null", "", $caracteristica2));
                    $codigoTipoArticulo = $colPo['CodigoTipo'];
                    $verificarExistencia = 1;

                    if ($codigoTipoArticulo == KD || $codigoTipoArticulo == KV) {
                        $codigoVarianteKit = $colPo['CodigoVariante'];
                        $sqlListaKit = "SELECT lmd.`CodigoVarianteComponente`FROM `listadematerialesdetalle` lmd INNER JOIN listademateriales lm ON lmd.`CodigoListaMateriales` = lm.CodigoListaMateriales WHERE lm.`CodigoVarianteKit` = '" . $codigoVarianteKit . "';";
                        $rsListaKit = $db->ejecutar($sqlListaKit);

                        while ($colListaKit = $db->obtener_fila($rsListaKit, 0)) {
                            $codigoVarianteComponente = $colListaKit['CodigoVarianteComponente'];

                            $sqlKit = "SELECT COUNT(*) AS Conteo FROM `portafolio` WHERE `CodigoVariante` = '" . $codigoVarianteComponente . "';";
                            $stmtKit = $db->ejecutar($sqlKit);
                            $resultadoKit = $db->obtener_fila($stmtKit, 0);
                            $ConteoKit = $resultadoKit['Conteo'];

                            if ($ConteoKit == 0) {
                                $verificarExistencia = 0;
                            }
                        }
                    }

                    /* if(!empty($colPo['fabricante']))
                      { */
                    if ($verificarExistencia == 1) {
                        $json = array(
                            'Id' => $colPo['Id'],
                            'CodigoGrupoVentas' => $colPo['CodigoGrupoVentas'],
                            'CodigoVariante' => $colPo['CodigoVariante'],
                            'CodigoArticulo' => $colPo['CodigoArticulo'],
                            'NombreArticulo' => $colPo['NombreArticulo'],
                            'CodigoCaracteristica1' => $colPo['CodigoCaracteristica1'],
                            'CodigoCaracteristica2' => $caracteristica2,
                            'CodigoTipo' => $colPo['CodigoTipo'],
                            'NombreTipo' => $colPo['NombreTipo'],
                            'CodigoMarca' => $colPo['CodigoMarca'],
                            'CodigoGrupoCategoria' => $colPo['CodigoGrupoCategoria'],
                            'CodigoGrupoDescuentoLinea' => $colPo['CodigoGrupoDescuentoLinea'],
                            'CodigoGrupoDescuentoMultiLinea' => $colPo['CodigoGrupoDescuentoMultiLinea'],
                            'CodigoGrupodeImpuestos' => $colPo['CodigoGrupodeImpuestos'],
                            'PorcentajedeIVA' => $colPo['PorcentajedeIVA'],
                            'ValorIMPOCONSUMO' => $colPo['ValorIMPOCONSUMO'],
                            'CuentaProveedor' => $colPo['CuentaProveedor'],
                            'DctoPPNivel1' => $colPo['DctoPPNivel1'],
                            'DctoPPNivel2' => $colPo['DctoPPNivel2'],
                            'IdentificadorProductoNuevo' => $colPo['IdentificadorProductoNuevo'],
                            'fabricante' => $colPo['fabricante'],
                            'grupo' => $colPo['grupo'],
                            'max_val' => $colPo['max_val']
                        );
                        array_push($datosPortafolio, $json);
                        // }
                    }
                }
            }
        }

        $subArray = array('Portafolio' => $datosPortafolio);
        $sqlUpdateFechaActualizacion = "INSERT INTO `logactualizaciones`(`CodigoZonaVenta`, `FechaActualizacion`, `HoraActualizacion`, `Estado`) VALUES ('" . $usuario . "',CURDATE(),CURTIME(),'2');";
        $db->ejecutar($sqlUpdateFechaActualizacion);
        return json_encode($subArray);
    }

    public function getSaldosInventarioPreventa() {
        $usuario = trim($value['datos']);

        //SaldoInventarioPreventa
        $datosSaldoPreventa = array();
        $sqlSaldoPreventa = "SELECT sa.* FROM `saldosinventariopreventa` AS sa 
                                        INNER JOIN zonaventaalmacen AS z ON z.CodigoSitio=sa.CodigoSitio AND z.CodigoAlmacen=sa.CodigoAlmacen 
                                        WHERE z.CodZonaVentas='" . $usuario . "' GROUP BY sa.Id; ";
        $rs_cltesSaldoPreventa = $db->ejecutar($sqlSaldoPreventa);
        if ($rs_cltesSaldoPreventa) {
            while ($colSaldoPreventa = $db->obtener_fila($rs_cltesSaldoPreventa, 0)) {
                $json = array(
                    'Id' => $colSaldoPreventa['Id'],
                    'CodigoSitio' => $colSaldoPreventa['CodigoSitio'],
                    'CodigoAlmacen' => $colSaldoPreventa['CodigoAlmacen'],
                    'CodigoVariante' => $colSaldoPreventa['CodigoVariante'],
                    'CodigoArticulo' => $colSaldoPreventa['CodigoArticulo'],
                    'CodigoTipo' => $colSaldoPreventa['CodigoTipo'],
                    'Disponible' => $colSaldoPreventa['Disponible'],
                    'CodigoUnidadMedida' => $colSaldoPreventa['CodigoUnidadMedida'],
                    'NombreUnidadMedida' => $colSaldoPreventa['NombreUnidadMedida']
                );
                array_push($datosSaldoPreventa, $json);
            }
        }
    }

    public function getSaldosInventarioAutoventa() {
        //SaldoInventarioAutoVenta
        $datosSaldoAutoVenta = array();
        $sqlSaldoAutoventa = "SELECT sa.* FROM `saldosinventarioautoventayconsignacion` AS sa INNER JOIN zonaventaalmacen AS z ON z.CodigoSitio=sa.CodigoSitio AND z.CodigoAlmacen=sa.CodigoAlmacen AND z.CodigoUbicacion=sa.CodigoUbicacion WHERE z.CodZonaVentas='" . $usuario . "' AND sa.LoteArticulo<>'NULL' AND sa.LoteArticulo<>''  AND sa.Disponible > 0  GROUP BY sa.CodigoSitio,sa.CodigoAlmacen,sa.CodigoVariante,sa.LoteArticulo; ";
        $rs_cltesSaldoAutoVenta = $db->ejecutar($sqlSaldoAutoventa);
        if ($rs_cltesSaldoAutoVenta) {
            while ($colSaldoAutoVenta = $db->obtener_fila($rs_cltesSaldoAutoVenta, 0)) {
                $json = array(
                    'Id' => $colSaldoAutoVenta['Id'],
                    'CodigoSitio' => $colSaldoAutoVenta['CodigoSitio'],
                    'CodigoAlmacen' => $colSaldoAutoVenta['CodigoAlmacen'],
                    'CodigoUbicacion' => $colSaldoAutoVenta['CodigoUbicacion'],
                    'CodigoVariante' => $colSaldoAutoVenta['CodigoVariante'],
                    'CodigoArticulo' => $colSaldoAutoVenta['CodigoArticulo'],
                    'LoteArticulo' => $colSaldoAutoVenta['LoteArticulo'],
                    'CodigoTipo' => $colSaldoAutoVenta['CodigoTipo'],
                    'CodigoUnidadMedida' => $colSaldoAutoVenta['CodigoUnidadMedida'],
                    'NombreUnidadMedida' => $colSaldoAutoVenta['NombreUnidadMedida'],
                    'Disponible' => $colSaldoAutoVenta['Disponible']
                );
                array_push($datosSaldoAutoVenta, $json);
            }
        }
    }

    public function getVariantesInactivas() {

        $sqlIna = "SELECT v.* FROM `variantesinactivas` AS v INNER JOIN zonaventaalmacen AS z ON v.CodigoSitio=z.CodigoSitio WHERE z.CodZonaVentas='" . $usuario . "' GROUP BY v.CodigoSitio,v.CodigoAlmacen,v.CodigoVariante ORDER BY v.Id;";
        $rsIna = $db->ejecutar($sqlIna);
        if ($rsIna) {
            while ($colina = $db->obtener_fila($rsIna, 0)) {
                $json = array(
                    'Id' => $colina['Id'],
                    'CodigoSitio' => $colina['CodigoSitio'],
                    'CodigoAlmacen' => $colina['CodigoAlmacen'],
                    'CodigoArticulo' => $colina['CodigoArticulo'],
                    'CodigoVariante' => $colina['CodigoVariante'],
                    'NombreVariante' => $colina['NombreVariante']
                );
                array_push($datosInactivos, $json);
            }
        }

        $sqlIna = "SELECT * FROM `variantesinactivas` WHERE CodigoSitio = 'EMPTY' AND CodigoAlmacen = 'EMPTY'";
        $rsIna = $db->ejecutar($sqlIna);
        if ($rsIna) {
            while ($colina = $db->obtener_fila($rsIna, 0)) {
                $json = array(
                    'Id' => $colina['Id'],
                    'CodigoSitio' => $colina['CodigoSitio'],
                    'CodigoAlmacen' => $colina['CodigoAlmacen'],
                    'CodigoArticulo' => $colina['CodigoArticulo'],
                    'CodigoVariante' => $colina['CodigoVariante'],
                    'NombreVariante' => $colina['NombreVariante']
                );
                array_push($datosInactivos, $json);
            }
        }
    }

    public function getListadeMateriales() {
        //Listas de materiales
        $datosLista = array();
        $sqlLista = "SELECT l.* FROM `listademateriales` AS l INNER JOIN portafolio AS p ON l.CodigoArticuloKit=p.CodigoArticulo AND l.CodigoTipoKit=p.CodigoTipo INNER JOIN zonaventas AS z ON z.CodigoGrupoVentas=p.CodigoGrupoVentas WHERE z.CodZonaVentas='" . $usuario . "';";
        $rsLista = $db->ejecutar($sqlLista);
        if ($rsLista) {
            while ($colLista = $db->obtener_fila($rsLista, 0)) {

                $kitValido = 0;
                $sqlDetalle = "SELECT *,(SELECT COUNT(*) FROM listadematerialesdetalle WHERE `CodigoListaMateriales`='" . $colLista['CodigoListaMateriales'] . "' AND `CodigoTipo`<>'OB') AS cuantos FROM `listadematerialesdetalle` WHERE `CodigoListaMateriales`='" . $colLista['CodigoListaMateriales'] . "' HAVING cuantos>0;";
                $rsDetalle = $db->ejecutar($sqlDetalle);
                $datosDetalle = array();

                while ($colDet = $db->obtener_fila($rsDetalle, 0)) {

                    $sqlImpuestosDetalles = "SELECT PorcentajedeIVA, ValorIMPOCONSUMO, NombreArticulo FROM portafolio WHERE `CodigoArticulo` = '" . $colDet['CodigoArticuloComponente'] . "';";
                    $rsImpuestosDetalles = $db->ejecutar($sqlImpuestosDetalles);
                    $colImpuestosDetalles = $db->obtener_fila($rsImpuestosDetalles, 0);
                    $kitValido++;
                    $jsonDetalle = array(
                        'Id' => $colDet['Id'],
                        'CodigoListaMateriales' => $colDet['CodigoListaMateriales'],
                        'CodigoArticuloComponente' => $colDet['CodigoArticuloComponente'],
                        'CodigoCaracteristica1' => $colDet['CodigoCaracteristica1'],
                        'CodigoCaracteristica2' => $colDet['CodigoCaracteristica2'],
                        'CodigoTipo' => $colDet['CodigoTipo'],
                        'CantidadComponente' => $colDet['CantidadComponente'],
                        'CodigoUnidadMedida' => $colDet['CodigoUnidadMedida'],
                        'NombreUnidadMedida' => $colDet['NombreUnidadMedida'],
                        'Fijo' => $colDet['Fijo'],
                        'Opcional' => $colDet['Opcional'],
                        'PrecioVentaBaseVariante' => $colDet['PrecioVentaBaseVariante'],
                        'TotalPrecioVentaBaseVariante' => $colDet['TotalPrecioVentaBaseVariante'],
                        'CodigoVarianteComponente' => $colDet['CodigoVarianteComponente'],
                        'PorcentajedeIVA' => $colImpuestosDetalles['PorcentajedeIVA'],
                        'ValorIMPOCONSUMO' => $colImpuestosDetalles['ValorIMPOCONSUMO'],
                        'NombreArticulo' => $colImpuestosDetalles['NombreArticulo'],
                        'CodigoTipoActivity' => $colDet['CodigoTipoActivity']
                    );
                    array_push($datosDetalle, $jsonDetalle);
                }

                if ($kitValido > 0) {
                    $json = array(
                        'Id' => $colLista['Id'],
                        'CodigoListaMateriales' => $colLista['CodigoListaMateriales'],
                        'CodigoArticuloKit' => $colLista['CodigoArticuloKit'],
                        'CodigoCaracteristica1Kit' => $colLista['CodigoCaracteristica1Kit'],
                        'CodigoCaracteristica2Kit' => $colLista['CodigoCaracteristica2Kit'],
                        'CodigoTipoKit' => $colLista['CodigoTipoKit'],
                        'Cantidad' => $colLista['Cantidad'],
                        'Sitio' => $colLista['Sitio'],
                        'Almacen' => $colLista['Almacen'],
                        'CantidadFijos' => $colLista['CantidadFijos'],
                        'CantidadOpcionales' => $colLista['CantidadOpcionales'],
                        'TotalPrecioVentaListaMateriales' => $colLista['TotalPrecioVentaListaMateriales'],
                        'Detalles' => array('Detalles' => $datosDetalle)
                    );
                    array_push($datosLista, $json);
                }
            }
        }
    }
}
