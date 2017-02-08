<?php

class DownloadMobileController extends Controller {

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'page' => array(
                'class' => 'CViewAction',
            ),
        );
    }

    public function getLoginUser($jsonInfo) {
        $usuario = trim($jsonInfo->usuario);
        $contrasena = trim($jsonInfo->contrasena);
        $version = trim($jsonInfo->version);
        $db = trim($jsonInfo->db);

        if (Login::model()->getJerarquia($usuario, $contrasena, $db) > 0) {
            $InfoUSuario = $this->getInfoUser($usuario, $contrasena, $db);
            $nueva_version = $InfoUSuario['NuevaVersion'];
            $nombre = $InfoUSuario['Nombre'];
            $fechaRetiro = $InfoUSuario['FechaRetiro'];
            $codigoAsesor = $InfoUSuario['CodAsesor'];
            $agencia = $InfoUSuario['Id'];
            $identificacion = '';

            $respuestaJerar = Login::model()->getJerarquia($codigoAsesor);

            if ($respuestaJerar['respuesta'] > 0) {

                if (empty($nueva_version)) {
                    $max_version = $this->getLastVersionApp($db);
                    Login::model()->getJerarquia($db, $max_version, $codigoAsesor, $contrasena, '1', $version);
                }

                if ($nueva_version > $version) {
                    $respuesta = "ACTUALIZA";
                } else {
                    Login::model()->getJerarquia($db, $max_version, $codigoAsesor, $contrasena, '2', $version);
                    if (($fechaRetiro == '') || ($fechaRetiro == '0000-00-00')) {
                        $respuesta = "OK";
                    } else {
                        $respuesta = "Identificate";
                    }
                }
            } else {
                $prodZona = Login::model()->getJerarquia($usuario);

                if ($prodZona > 0) {
                    $respuesta = "NO";
                    $nombre = "N/A";
                } else {
                    $respuesta = "NN";
                    $nombre = "N/A";
                }
            }
        } else {
            $prodZona = Login::model()->getJerarquia($usuario);
            if ($prodZona > 0) {
                $respuesta = "NO";
                $nombre = "N/A";
            } else {
                $respuesta = "NN";
                $nombre = "N/A";
            }
        }
        $json = array(
            'respuesta' => $respuesta,
            'cedula' => $usuario,
            'nombre' => $nombre,
            'contrasena' => $contrasena,
            'identificacion' => $identificacion,
            'agencia' => $agencia
        );

        $datos = array();
        array_push($datos, $json);
        $subArray = array('Login' => $datos);
        return json_encode($subArray);
    }
    
    public function getPaqueteZonaventas($jsonInfo){
        try{
            $datosUsuario = General::model()->getDatosUser($jsonInfo->db, $jsonInfo->usuario);
            $datosGrupoV = General::model()->getGruposVentas($jsonInfo->db, $jsonInfo->usuario);
            $datosZonaAlma = General::model()->getZonaAlma($jsonInfo->db, $jsonInfo->usuario);
            $datosOperacion = General::model()->getOperacionesConversion($jsonInfo->db);
            $datosFrecuencia = General::model()->getFrecuencia($jsonInfo->db);
            $datosCiiu = General::model()->getCodigoCIIU($jsonInfo->db);
            $datosBancos = General::model()->getBancos($jsonInfo->db);
            $datosCuentas = General::model()->getCuentas($jsonInfo->db);
            $datosMotivos = General::model()->getMotivosSaldo($jsonInfo->db);
            $datosMotivosGestion = General::model()->getMotivosGestiondeCobros($jsonInfo->db);
            $datosMotivosDevol = General::model()->getMotivosDevolucionProveedor($jsonInfo->db);
            $datosMotivosDevolucion = $datosMotivosDevol['datosMotivosDevolucion'];
            $datosMotivosDevolucionArticulo = $datosMotivosDevol['datosMotivosDevolucionArticulo'];
            $datosProveedores = General::model()->getProveedores($jsonInfo->db);
            $datosresponsablenota = General::model()->getResponsableNota($jsonInfo->db);
            $datosconceptosnotacredito = General::model()->getConceptosNotaCredito($jsonInfo->db);
            $datosMotivosNoVenta = General::model()->getMotivosNoventa($jsonInfo->db);
            $datosTipoDocumento = General::model()->getTipoDocumento($jsonInfo->db);
            $datosImpresion = General::model()->getDatosImpresion($jsonInfo->db);
            $devolver = General::model()->getBancosCheques();
            $datosCondiciones = General::model()->getCondicionesPago($jsonInfo->db);
            
            $resolucion = General::model()->getOperacionesConversion($jsonInfo->db);
            
            
            $configuracionImpresion = General::model()->getConfiguracion($jsonInfo->db, $jsonInfo->usuario);
            $datosTipoVia = General::model()->getTipovia($jsonInfo->db);
            $datosTipoComplemento = General::model()->getTipoviaComplemento($jsonInfo->db);
            $datosMallaActivacion = General::model()->getMallaactivacion($jsonInfo->db);
            $datosMallaActivacionDetalle = General::model()->getMallaActivacionDetalle($jsonInfo->db);
            $fechaActualizacionInfo = General::model()->getFechaActualizaciones($jsonInfo->db, $jsonInfo->usuario); 
            $datosFormasPago = General::model()->getFormasPago($jsonInfo->db);
            $datosProveedorVentadirecta = General::model()->getProveedoresVentadirecta($jsonInfo->db);
            $datosrelacionmotivosnotasrecibos = General::model()->getRelacioMmotivosNotasRecibos($jsonInfo->db);
            
            $subArray = array('Usuario' => $datosUsuario,
                            'GrupoVentas' => $datosGrupoV,
                            'ZonaAlmacen' => $datosZonaAlma,
                            'OperacionConversion' => $datosOperacion,
                            'Frecuencia' => $datosFrecuencia,
                            'Ciiu' => $datosCiiu,
                            'Bancos' => $datosBancos,
                            'Cuentas' => $datosCuentas,
                            'MotivosSaldo' => $datosMotivos,
                            'MotivosGestion' => $datosMotivosGestion,
                            'MotivosDevolucion' => $datosMotivosDevolucion,
                            'MotivosDevolucionArticulo' => $datosMotivosDevolucionArticulo,
                            'Proveedores' => $datosProveedores,
                            'ResponsableNota' => $datosresponsablenota,
                            'ConceptosNotaCredito' => $datosconceptosnotacredito,
                            'MotivosNoVenta' => $datosMotivosNoVenta,
                            'TipoDocumento' => $datosTipoDocumento,
                            'DatosImpresion' => $datosImpresion,
                            'bancosCheques' => $devolver,
                            'condicionesPago' => $datosCondiciones,
                            'Resolucion' => $resolucion,
                            'ConfiguracionImpresion' => $configuracionImpresion,
                            'TipoVia' => $datosTipoVia,
                            'TipoViaComplemento' => $datosTipoComplemento,
                            'datosMallaActivacion' => $datosMallaActivacion,
                            'datosMallaActivacionDetalle' => $datosMallaActivacionDetalle,
                            'fechaActualizacionInfo' => $fechaActualizacionInfo,
                            'datosFormasPago' => $datosFormasPago,
                            'proveedoresVentaDirecta' => $datosProveedorVentadirecta,
                            'datosrelacionmotivosnotasrecibos'=> $datosrelacionmotivosnotasrecibos);
            return json_encode($subArray);
        } catch (Exeption $ex){
            
        }
    }
    
    public function getResolucionesVentadirecta($zonaVentas) {

        $resolucionJson = array();
        $count = General::model()->countResolucionZonaventas($zonaVentas);
        //Variasbles que necesito
        $max = General::model()->getRangoFinal();
        $RangoHasta = General::model()->getRangoHasta();
        $RangoFactura = General::model()->getCantidadRangoFactura();

        if ($max < $RangoHasta) {
            if ($count == 0) {
                $resultDatos = General::model()->getresolucion();

                if ($max == null) {
                    $max = $resultDatos['RangoDesde'];
                    $rangoIncial = $max;
                    $rangoActual = $max;
                    $rangoFinal = $max + $RangoFactura;
                } else {
                    $rangoIncial = $max;
                    $rangoActual = $max + 1;
                    $rangoFinal = $max + $RangoFactura;
                }

                $json = array(
                    'IdResolucion' => 1,
                    'CodigoResolucion' => $resultDatos['CodigoResolucion'],
                    'NumeroResolucion' => $resultDatos['NumeroResolucion'],
                    'Prefijo' => $resultDatos['Prefijo'],
                    'RangoDesde' => $resultDatos['RangoDesde'],
                    'RangoHasta' => $resultDatos['RangoHasta'],
                    'AlarmaNumero' => $resultDatos['AlarmaNumero'],
                    'FechaInicio' => $resultDatos['FechaInicio'],
                    'FechaFinal' => $resultDatos['FechaFinal'],
                    'AlarmaFecha' => $resultDatos['AlarmaFecha'],
                    'CodigoSecuencia' => $resultDatos['CodigoSecuencia'],
                    'RangoActual' => $rangoActual,
                    'RangoFinal' => $rangoFinal
                );
                array_push($resolucionJson, $json);
                General::model()->insertResolucionesEntregadas($resultDatos, $zonaVentas, $rangoIncial, $rangoActual, $rangoFinal);
            } else {
                $resultadoU   = getRangosResolucion($zonaVentas);
                $RangoInicial = $resultadoU['RangoInicial'];
                $RangoActual = $resultadoU['RangoActual'];
                $RangoFinal = $resultadoU['RangoFinal'];
                $FechaEntrega = $resultadoU['FechaEntrega'];

                if ($RangoActual >= $RangoFinal) {
                    //se descarga nuevo rango de facturacion se debe entregar 60 facturas
                    $resultDatos = General::model()->getresolucion();

                    $rangoIncial = $max;
                    $rangoActual = $max + 1;
                    $rangoFinal = $max + $RangoFactura;

                    $json = array(
                        'IdResolucion' => 1,
                        'CodigoResolucion' => $resultDatos['CodigoResolucion'],
                        'NumeroResolucion' => $resultDatos['NumeroResolucion'],
                        'Prefijo' => $resultDatos['Prefijo'],
                        'RangoDesde' => $resultDatos['RangoDesde'],
                        'RangoHasta' => $resultDatos['RangoHasta'],
                        'AlarmaNumero' => $resultDatos['AlarmaNumero'],
                        'FechaInicio' => $resultDatos['FechaInicio'],
                        'FechaFinal' => $resultDatos['FechaFinal'],
                        'AlarmaFecha' => $resultDatos['AlarmaFecha'],
                        'CodigoSecuencia' => $resultDatos['CodigoSecuencia'],
                        'RangoActual' => $rangoActual,
                        'RangoFinal' => $rangoFinal
                    );
                    array_push($resolucionJson, $json);
                    
                    General::model()->insertResolucionesEntregadas($resultDatos, $zonaVentas, $rangoIncial, $rangoActual, $rangoFinal);
                } else if ($FechaEntrega < date("Y-m-01")) {

                    $resultDatos = General::model()->getresolucion();

                    $rangoIncial = $max;
                    $rangoActual = $max + 1;
                    $rangoFinal = $max + $RangoFactura;

                    $json = array(
                        'IdResolucion' => 1,
                        'CodigoResolucion' => $resultDatos['CodigoResolucion'],
                        'NumeroResolucion' => $resultDatos['NumeroResolucion'],
                        'Prefijo' => $resultDatos['Prefijo'],
                        'RangoDesde' => $resultDatos['RangoDesde'],
                        'RangoHasta' => $resultDatos['RangoHasta'],
                        'AlarmaNumero' => $resultDatos['AlarmaNumero'],
                        'FechaInicio' => $resultDatos['FechaInicio'],
                        'FechaFinal' => $resultDatos['FechaFinal'],
                        'AlarmaFecha' => $resultDatos['AlarmaFecha'],
                        'CodigoSecuencia' => $resultDatos['CodigoSecuencia'],
                        'RangoActual' => $rangoActual,
                        'RangoFinal' => $rangoFinal
                    );
                    array_push($resolucionJson, $json);
                    General::model()->insertResolucionesEntregadas($resultDatos, $zonaVentas, $rangoIncial, $rangoActual, $rangoFinal);
                } else {
                    //Sele entrega nuevo rango faltante por terminar
                    $sqlU = "SELECT * FROM `resolucionesentregadas` WHERE `ZonaVentas`='" . $zonaVentas . "' ORDER BY IdResolucion DESC;";
                    $stmtU = $db->ejecutar($sqlU);
                    $resultadoU = $db->obtener_fila($stmtU, 0);
                    $rangoNuevoActual = $resultadoU['RangoActual'] + 1;
                    $json = array(
                        'IdResolucion' => $resultadoU['IdResolucion'],
                        'CodigoResolucion' => $resultadoU['CodigoResolucion'],
                        'NumeroResolucion' => $resultadoU['NumeroResolucion'],
                        'Prefijo' => $resultadoU['Prefijo'],
                        'RangoDesde' => $resultadoU['RangoDesde'],
                        'RangoHasta' => $resultadoU['RangoHasta'],
                        'AlarmaNumero' => $resultadoU['AlarmaNumero'],
                        'FechaInicio' => $resultadoU['FechaInicio'],
                        'FechaFinal' => $resultadoU['FechaFinal'],
                        'AlarmaFecha' => $resultadoU['AlarmaFecha'],
                        'CodigoSecuencia' => $resultadoU['CodigoSecuencia'],
                        'RangoActual' => $rangoNuevoActual,
                        'RangoFinal' => $resultadoU['RangoFinal']
                    );
                    array_push($resolucionJson, $json);
                }
            }
        } else {
            //alertar al sistema los rangos se acabaron y no hay facturas para entregar.
        }
        return json_encode($resolucionJson);
    }

}
