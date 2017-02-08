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
class Pedidos extends DatabaseUtilities {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getAcuerdoscomercialesPrecioventa($idDataBase) {
        try {
            $db = Db::getInstance();
            $zonaVentas = trim($value['zona']);
            $ruta = trim($value['ruta']);
            $inicio = trim($value['inicio']);
            $fin = trim($value['fin']);
            $posicion = $inicio;
            $fechaActual = date('Y-m-d');

            //Acuerdo Comercial
            $datosAcuerdo = array();
            /*     $sqlAc = "SELECT a.* FROM `acuerdoscomercialesprecioventa` AS a 
              INNER JOIN clienteruta AS cr ON (cr.CuentaCliente=a.CuentaCliente OR cr.CodigoGrupoPrecio = a.CodigoGrupoPrecio)
              INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita=cr.NumeroVisita
              WHERE cr.CodZonaVentas='" . $zonaVentas . "' AND
              (`R1`='$ruta' OR `R2`='$ruta' OR `R3`='$ruta' OR `R4`='$ruta') AND FechaInicio<>'0000-00-00' AND FechaInicio<='" . $fechaActual . "' AND (FechaTermina>='" . $fechaActual . "' OR FechaTermina='0000-00-00')
              GROUP BY a.Id
              ORDER BY `a`.`FechaInicio` DESC,a.PrecioVenta DESC LIMIT " . $inicio . "," . $fin . " ; "; */

            $sqlAc = "SELECT a.* FROM `acuerdoscomercialesprecioventa` AS a 
             INNER JOIN clienteruta AS cr ON (cr.CuentaCliente=a.CuentaCliente OR cr.CodigoGrupoPrecio = a.CodigoGrupoPrecio)
             INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita=cr.NumeroVisita
             WHERE cr.CodZonaVentas='" . $zonaVentas . "' AND
             (`R1`='$ruta' OR `R2`='$ruta' OR `R3`='$ruta' OR `R4`='$ruta') AND FechaInicio<>'0000-00-00' AND FechaInicio<='" . $fechaActual . "' AND (FechaTermina>='" . $fechaActual . "' OR FechaTermina='0000-00-00')
             GROUP BY a.Id
             ORDER BY `a`.`FechaInicio` DESC,a.PrecioVenta DESC; ";

            $rs_cltesAc = $db->ejecutar($sqlAc);
            if ($rs_cltesAc) {
                $posicion = $inicio;
                while ($col_cltesAc = $db->obtener_fila($rs_cltesAc, 0)) {

                    $json = array(
                        'Id' => $col_cltesAc['Id'],
                        'IdAcuerdoComercial' => $col_cltesAc['IdAcuerdoComercial'],
                        'TipoAcuerdo' => $col_cltesAc['TipoAcuerdo'],
                        'TipoCuentaCliente' => $col_cltesAc['TipoCuentaCliente'],
                        'CuentaCliente' => $col_cltesAc['CuentaCliente'],
                        'CodigoGrupoPrecio' => $col_cltesAc['CodigoGrupoPrecio'],
                        'CodigoVariante' => $col_cltesAc['CodigoVariante'],
                        'PrecioVenta' => $col_cltesAc['PrecioVenta'],
                        'CodigoUnidadMedida' => $col_cltesAc['CodigoUnidadMedida'],
                        'NombreUnidadMedida' => $col_cltesAc['NombreUnidadMedida'],
                        'CantidadDesde' => $col_cltesAc['CantidadDesde'],
                        'CantidadHasta' => $col_cltesAc['CantidadHasta'],
                        'FechaInicio' => $col_cltesAc['FechaInicio'],
                        'FechaTermina' => $col_cltesAc['FechaTermina'],
                        'Sitio' => $col_cltesAc['Sitio'],
                        'Almacen' => $col_cltesAc['Almacen'],
                        'Posicion' => $posicion
                    );
                    array_push($datosAcuerdo, $json);
                    $posicion++;
                }
            }

            $subArray = array('AcuerdoComercial' => $datosAcuerdo);
            return json_encode($subArray);
        } catch (Exeption $ex) {
            return "error Pedidos::model->getSales: " . $ex;
        }
    }

    public function getAcuerdoscomercialesDescuentoMultilinea() {
        //Acuerdo Comercial descuento Multi linea
        $datosAcuerdoMultiLinea = array();
        $sqlMulinea = "SELECT a.* FROM `acuerdoscomercialesdescuentomultilinea` AS a 
            INNER JOIN clienteruta AS cr ON (cr.CuentaCliente=a.CuentaCliente OR cr.CodigoGrupoDescuentoMultiLinea = a.CodigoGrupoClienteDescuentoMultilinea OR a.`TipoCuentaCliente` = '3') 
            INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita=cr.NumeroVisita 
            WHERE cr.CodZonaVentas='" . $zonaVentas . "' AND
            (`R1`='" . $ruta . "' OR `R2`='" . $ruta . "' OR `R3`='" . $ruta . "' OR `R4`='" . $ruta . "') AND FechaInicio<>'0000-00-00' AND FechaInicio<='" . $fechaActual . "' AND (FechaFinal>='" . $fechaActual . "' OR FechaFinal='0000-00-00')
                GROUP BY a.Id
            ORDER BY `a`.`FechaInicio` DESC,SUM(PorcentajeDescuentoMultilinea1+PorcentajeDescuentoMultilinea2) ASC ;";
        $rs_cltesMulinea = $db->ejecutar($sqlMulinea);
        if ($rs_cltesMulinea) {
            while ($col_cltesMulinea = $db->obtener_fila($rs_cltesMulinea, 0)) {

                $json = array(
                    'Id' => $col_cltesMulinea['Id'],
                    'IdAcuerdoComercial' => $col_cltesMulinea['IdAcuerdoComercial'],
                    'TipoAcuerdo' => $col_cltesMulinea['TipoAcuerdo'],
                    'TipoCuentaCliente' => $col_cltesMulinea['TipoCuentaCliente'],
                    'CuentaCliente' => $col_cltesMulinea['CuentaCliente'],
                    'CodigoGrupoClienteDescuentoMultilinea' => $col_cltesMulinea['CodigoGrupoClienteDescuentoMultilinea'],
                    'CodigoGrupoArticulosDescuentoMultilinea' => $col_cltesMulinea['CodigoGrupoArticulosDescuentoMultilinea'],
                    'PorcentajeDescuentoMultilinea1' => $col_cltesMulinea['PorcentajeDescuentoMultilinea1'],
                    'PorcentajeDescuentoMultilinea2' => $col_cltesMulinea['PorcentajeDescuentoMultilinea2'],
                    'CodigoUnidadMedida' => $col_cltesMulinea['CodigoUnidadMedida'],
                    'NombreUnidadMedida' => $col_cltesMulinea['NombreUnidadMedida'],
                    'CantidadDesde' => $col_cltesMulinea['CantidadDesde'],
                    'CantidadHasta' => $col_cltesMulinea['CantidadHasta'],
                    'FechaInicio' => $col_cltesMulinea['FechaInicio'],
                    'FechaFinal' => $col_cltesMulinea['FechaFinal'],
                    'Sitio' => $col_cltesMulinea['Sitio'],
                    'Almacen' => $col_cltesMulinea['Almacen']
                );
                array_push($datosAcuerdoMultiLinea, $json);
            }
        }

        $subArray = array('AcuerdoMultiLinea' => $datosAcuerdoMultiLinea);

        return json_encode($subArray);
    }

    public function getAcuerdoscomercialesDescuentoLinea() {
        //Acuerdo Comercial descuento linea
        $datosAcuerdoLinea = array();
        /* $sqlAlinea = "SELECT a.* FROM `acuerdoscomercialesdescuentolinea` AS a 
          INNER JOIN clienteruta AS cr ON (cr.CuentaCliente=a.CuentaCliente OR cr.CodigoGrupoDescuentoLinea = a.CodigoClienteGrupoDescuentoLinea)
          INNER JOIN frecuenciavisita AS fre ON fre.NumeroVisita=cr.NumeroVisita
          WHERE cr.CodZonaVentas='" . $zonaVentas . "' AND
          (`R1`='$ruta' OR `R2`='$ruta' OR `R3`='$ruta' OR `R4`='$ruta') AND FechaInicio<>'0000-00-00' AND FechaInicio<='" . $fechaActual . "' AND (FechaFinal>='" . $fechaActual . "' OR FechaFinal='0000-00-00')  GROUP BY a.Id
          ORDER BY `a`.`FechaInicio` DESC,SUM(PorcentajeDescuentoLinea1+PorcentajeDescuentoLinea2) ASC; "; */

        $sqlAlinea = "SELECT a.* FROM `acuerdoscomercialesdescuentolinea` AS a 
                       WHERE   FechaInicio<>'0000-00-00' AND FechaInicio<='" . $fechaActual . "' AND (FechaFinal>='" . $fechaActual . "' OR FechaFinal='0000-00-00')  GROUP BY a.Id
            ORDER BY `a`.`FechaInicio` DESC,SUM(PorcentajeDescuentoLinea1+PorcentajeDescuentoLinea2) ASC; ";

//       $sqlAlinea = "SELECT * FROM `acuerdoscomercialesdescuentolinea`  ORDER BY `Id` ASC";
        $rs_cltesAlinea = $db->ejecutar($sqlAlinea);
        if ($rs_cltesAlinea) {
            while ($col_cltesAlinea = $db->obtener_fila($rs_cltesAlinea, 0)) {

                $json = array(
                    'Id' => $col_cltesAlinea['Id'],
                    'IdAcuerdoComercial' => $col_cltesAlinea['IdAcuerdoComercial'],
                    'TipoAcuerdo' => $col_cltesAlinea['TipoAcuerdo'],
                    'TipoCuentaCliente' => $col_cltesAlinea['TipoCuentaCliente'],
                    'CuentaCliente' => trim($col_cltesAlinea['CuentaCliente']),
                    'CodigoClienteGrupoDescuentoLinea' => $col_cltesAlinea['CodigoClienteGrupoDescuentoLinea'],
                    'TipoCuentaArticulos' => $col_cltesAlinea['TipoCuentaArticulos'],
                    'CodigoVariante' => $col_cltesAlinea['CodigoVariante'],
                    'CodigoArticuloGrupoDescuentoLinea' => $col_cltesAlinea['CodigoArticuloGrupoDescuentoLinea'],
                    'PorcentajeDescuentoLinea1' => $col_cltesAlinea['PorcentajeDescuentoLinea1'],
                    'PorcentajeDescuentoLinea2' => $col_cltesAlinea['PorcentajeDescuentoLinea2'],
                    'CodigoUnidadMedida' => $col_cltesAlinea['CodigoUnidadMedida'],
                    'NombreUnidadMedida' => $col_cltesAlinea['NombreUnidadMedida'],
                    'CantidadDesde' => $col_cltesAlinea['CantidadDesde'],
                    'CantidadHasta' => $col_cltesAlinea['CantidadHasta'],
                    'FechaInicio' => $col_cltesAlinea['FechaInicio'],
                    'FechaFinal' => $col_cltesAlinea['FechaFinal'],
                    'LimiteVentas' => $col_cltesAlinea['LimiteVentas'],
                    'Saldo' => $col_cltesAlinea['Saldo'],
                    'Sitio' => $col_cltesAlinea['Sitio'],
                    'CodigoAlmacen' => $col_cltesAlinea['CodigoAlmacen'],
                    'PorcentajeAlerta' => $col_cltesAlinea['PorcentajeAlerta'],
                    'Posicion' => $posicion
                );
                array_push($datosAcuerdoLinea, $json);
                $posicion++;
            }
        }
        $subArray = array('AcuerdoLinea' => $datosAcuerdoLinea);
        return json_encode($subArray);
    }

    public function getDataBases() {
        $colums = "`id` AS iddatabase, `nombre` AS agenciname, `bd` AS database";
        $table = "`bases_datos`";
        $sql = $this->createBasicSelectWithWhere($colums, $table, "");
        return $this->excecuteQueryAll($sql);
    }

}
