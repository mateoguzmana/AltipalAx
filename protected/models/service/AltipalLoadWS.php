<?php

Yii::import('application.extensions.ActivityLog');
Yii::import('DatabaseUtilities');
Yii::import('DataUtilities');

/**
 * Created by Activity Technology SAS.
 */
class AltipalLoadWS extends DatabaseUtilities {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ********************************** json log ************************************************** */

    public function createLog($class, $function, $e) {
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
        return $e;
    }

    /*     * ********************************** datautilities ********************************************* */

    public function ValidateItem($validateType, $var) {
        try {
            $validate = new DataUtilities();
            switch ($validateType) {
                case 'ValidateItem1cero':
                    return $validate->ValidateItem1cero($var);
                    break;
                case 'ValidateItem1cero2':
                    return $validate->ValidateItem1cero2($var);
                    break;
                case 'ValidateItem2cero':
                    return $validate->ValidateItem2cero($var);
                    break;
                case 'ValidateItem3cero':
                    return $validate->ValidateItem3cero($var);
                    break;
                case 'ValidateItem4cero':
                    return $validate->ValidateItem4cero($var);
                    break;
                case 'ValidateItem5cero':
                    return $validate->ValidateItem5cero($var);
                    break;
                case 'ValidateItem6cero':
                    return $validate->ValidateItem6cero($var);
                    break;
                case 'ValidateItem7cero':
                    return $validate->ValidateItem7cero($var);
                    break;
                case 'ValidateItem8cero':
                    return $validate->ValidateItem8cero($var);
                    break;
                case 'ValidateItemSinDato':
                    return $validate->ValidateItemSinDato($var);
                    break;
                case 'ValidateItemStringToInt':
                    return $validate->ValidateItemStringToInt($var);
                    break;
                case 'ValidateItemCodigoTipoActivity':
                    return $validate->ValidateItemCodigoTipoActivity($var);
                    break;
                case 'ValidateItemFalso':
                    return $validate->ValidateItemFalso($var);
                    break;
                case 'ValidateBlankTo1':
                    return $validate->ValidateBlankTo1($var);
                    break;
                case 'ValidateItemFalsoL':
                    return $validate->ValidateItemFalsoL($var);
                    break;
                case 'ValidateItemFecha':
                    return $validate->ValidateItemFecha($var);
                    break;
                case 'ValidateAccountType':
                    return $validate->ValidateAccountType($var);
                    break;
                case 'ValidateUnitCode':
                    return $validate->ValidateUnitCode($var);
                    break;
                case 'ValidateToLower':
                    return $validate->ValidateToLower($var);
                    break;
                case 'ValidateItemEmpty':
                    return $validate->ValidateItemEmpty($var);
                    break;
                case 'ValidateItemSpecChar':
                    return $validate->ValidateItemSpecChar($var);
                    break;
                case 'ValidateToUpper':
                    return $validate->ValidateToUpper($var);
                    break;
                default:
                    return "";
                    break;
            }
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'ValidateItem', $ex);
        }
    }

    /*     * ********************************** Methods ********************************************* */

    public function setIndividualProcess($ControllerId, $status, $ServerName, $Date, $Time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_setindividualprocess`($ControllerId,$status,'$ServerName','$Date','$Time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setIndividualProcess', $ex);
        }
    }

    public function setIndividualProcessDetails($Method, $status, $ControllerId, $Date, $Time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_setindividualprocessdetails`('$Method',$status,$ControllerId,'$Date','$Time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setIndividualProcessDetails', $ex);
        }
    }

    public function setErrorGlobal($Message, $ControllerName, $Error, $Agency, $Date, $time, $Param, $ServerName, $ErrorType, $ControllerId) {
        try {
            $sql = "INSERT INTO `erroresactualizacion`(`MensajeActivity`,`MensajeServicio`,`Fecha`,`Hora`,`ServicioSRF`,`TablasActualizar`,`Agencia`,"
                    . "`Parametros`,`NombreServidor`,`TipoError`,`IdControlador`) VALUES ('$Message','$Error','$Date','$time','$ControllerName',"
                    . "'','$Agency','$Param','$ServerName','$ErrorType','$ControllerId')";
            Yii::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setErrorGlobal', $ex);
        }
    }

    public function getProcessingMethods() {
        try {
            return $this->excecuteDatabaseStoredProcedures("`sp_processingmethods`();");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getProcessingMethods', $ex);
        }
    }

    public function getAllSalesZones() {
        try {
            return $this->excecuteDatabaseStoredProcedures("`sp_queryallsaleszones`();");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getallSalesZones', $ex);
        }
    }

    public function setBudget($JsonBudget) {
        try {
            $objPresu = json_decode($JsonBudget, true);
            if ($objPresu['SaleZone']['Code'] != "" && $objPresu['SaleZone']['Code'] != null) {
                //$sql = "INSERT INTO `presupuestos`(`CodZonaVentas`,`Agencia`,`NombreAgencia`,`Año`,`Mes`,`DiasHabiles`,`DiasTranscurridos`) VALUES ('$CodZonaVentas1','$Agencia1','$NombreAgencia1','$ano1','$Mes1','$DiasHabiles1','$DiasTranscurridos1')";

                $TableName = "presupuestos";
                $ColumnsName = "`CodZonaVentas`,`Agencia`,`NombreAgencia`,`Año`,`Mes`,`DiasHabiles`,`DiasTranscurridos`";
                $values = "('" . $objPresu['SaleZone']['Code'] . "','" . $objPresu['SaleZone']['AgencyId'] . "','" . $objPresu['SaleZone']['AgencyName'] . "',"
                        . "'" . $objPresu['SaleZone']['Year'] . "','" . $objPresu['SaleZone']['Month'] . "','" . $objPresu['SaleZone']['BusinessDays'] . "',"
                        . "'" . $objPresu['SaleZone']['ElapsedDays'] . "')";

                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);

                //$this->insertDatosAll($sql);
                $cadenaid = "SELECT MAX(Id) as IdPresupuesto FROM `presupuestos`";

                $IdPre = $this->SelectQueryRow($cadenaid);

                $idPresupuesto = $IdPre['IdPresupuesto'];
                $contarInsertarProfundidad = 0;
                $contarInsertarDimenciones = 0;
                $contarInsertarFabricante = 0;

                /* $sqlInsertProfundidad = "INSERT INTO `presupuestoprofundidad`(`IdPresupuesto`,`Presupuestado`,`Tipo`,`CodDimension`,`NombreDimension`,`Ejecutado`,`PorcentajeCumplimiento`,`Indicador`) VALUES";
                  $sqlInsertDimenciones = "INSERT INTO `presupuestodimensiones`(`IdPresupuesto`,`NombreDimension`,`Presupuestado`,`Ejecutado`,`PorcentajeCumplimiento`) VALUES";
                  $sqlInsertFabricante = "INSERT INTO `presupuestofabricante`(`IdPresupuesto`,`CodigoFabricante`,`NombreFabricante`,`Pesos`,`Devoluciones`,`CuotaPesos`,`Cumplimiento`) VALUES"; */
                $sqlInsertProfundidad = "";
                $sqlInsertDimensiones = "";
                $sqlInsertFabricante = "";
                foreach ($objPresu as $key => $valor) {
                    if (is_array($valor)) {
                        foreach ($valor as $keyProfundida => $keyProfundidaValor) {
                            if ($keyProfundida == 'Depth' && is_array($keyProfundidaValor)) {
                                foreach ($keyProfundidaValor as $keyProf => $keyProfValor) {
                                    $Presupuestado = $keyProfValor['Budgeted'];
                                    $Tipo = $keyProfValor['BudgetedType'];
                                    $CodDimension = $keyProfValor['DimensionId'];
                                    $NombreDimension = $keyProfValor['DimensionName'];
                                    $NombreDimension = str_replace("'", "", $NombreDimension);
                                    $NombreDimension = str_replace("&", "", $NombreDimension);
                                    $Ejecutado = $keyProfValor['Executed'];
                                    $PorcentajeCumplimiento = $keyProfValor['Fulfillment'];
                                    $Indicador = $keyProfValor['Indicator'];
                                    $Indicador = str_replace("'", "", $Indicador);
                                    $Indicador = str_replace("&", "", $Indicador);
                                    $sqlInsertProfundidad .= "('$idPresupuesto','$Presupuestado','$Tipo','$CodDimension','$NombreDimension','$Ejecutado','$PorcentajeCumplimiento','$Indicador'),";
                                    $contarInsertarProfundidad++;
                                }
                            } else if ($keyProfundida == 'Dimensions' && is_array($keyProfundidaValor)) {
                                foreach ($keyProfundidaValor as $keyDimensiones => $keyDimensionesValor) {
                                    $PresupuestadoDimensiones = $keyDimensionesValor['Budgeted'];
                                    $NombreDimensiones = $keyDimensionesValor['DimensionName'];
                                    $NombreDimensiones = str_replace("'", " ", $NombreDimensiones);
                                    $NombreDimensiones = str_replace("&", "y", $NombreDimensiones);
                                    $EjecutadoDimensiones = $keyDimensionesValor['Executed'];
                                    $PorcentajeCumplimientoDimensiones = $keyDimensionesValor['Fulfillment'];
                                    $sqlInsertDimensiones .= "('$idPresupuesto','$NombreDimensiones','$PresupuestadoDimensiones','$EjecutadoDimensiones','$PorcentajeCumplimientoDimensiones'),";
                                    $contarInsertarDimenciones++;
                                }
                            } else if ($keyProfundida == 'Manufacturers' && is_array($keyProfundidaValor)) {
                                foreach ($keyProfundidaValor as $keyManofactura => $keyManofacturaValor) {
                                    $CodigoFabricante = $keyManofacturaValor['ManufacturerId'];
                                    $NombreFabricante = $keyManofacturaValor['ManufacturerName'];
                                    $NombreFabricante = str_replace("'", " ", $NombreFabricante);
                                    $NombreFabricante = str_replace("&", "y", $NombreFabricante);
                                    $Devoluciones = $keyManofacturaValor['ReturnsSales'];
                                    $CuotaPesos = $keyManofacturaValor['Cuote'];
                                    $Cumplimiento = $keyManofacturaValor['Fulfillment'];
                                    $Pesos = $keyManofacturaValor['Amount'];
                                    $sqlInsertFabricante .= "('$idPresupuesto','$CodigoFabricante','$NombreFabricante','$Pesos','$Devoluciones','$CuotaPesos','$Cumplimiento'),";
                                    $contarInsertarFabricante++;
                                }
                            }
                        }
                    }
                }
                if ($contarInsertarProfundidad > 0) {

                    $TableName = "presupuestoprofundidad";
                    $ColumnsName = "`IdPresupuesto`,`Presupuestado`,`Tipo`,`CodDimension`,`NombreDimension`,`Ejecutado`,`PorcentajeCumplimiento`,`Indicador`";

                    $sqlInsertProfundidad = substr($sqlInsertProfundidad, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $sqlInsertProfundidad);
                    //$this->insertDatosAll($sqlInsertProfundidad);
                    //ServiceAltipal::model()->insertDatosAll($sqlInsertProfundidad);
                }
                if ($contarInsertarDimenciones > 0) {

                    $TableName = "presupuestodimensiones";
                    $ColumnsName = "`IdPresupuesto`,`NombreDimension`,`Presupuestado`,`Ejecutado`,`PorcentajeCumplimiento`";

                    $sqlInsertDimensiones = substr($sqlInsertDimensiones, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $sqlInsertDimensiones);
                    //$this->insertDatosAll($sqlInsertDimenciones);
                    //ServiceAltipal::model()->insertDatosAll($sqlInsertDimenciones);
                }
                if ($contarInsertarProfundidad > 0) {

                    $TableName = "presupuestofabricante";
                    $ColumnsName = "`IdPresupuesto`,`CodigoFabricante`,`NombreFabricante`,`Pesos`,`Devoluciones`,`CuotaPesos`,`Cumplimiento`";

                    $sqlInsertFabricante = substr($sqlInsertFabricante, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $sqlInsertFabricante);

                    //$this->insertDatosAll($sqlInsertFabricante);
                    //ServiceAltipal::model()->insertDatosAll($sqlInsertFabricante);
                }
                return 'OK';
            } else {
                return "la zona de ventas no posee informacion";
            }
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setBudget', $ex);
        }
    }

    public function setMallaActivation($JsonMalla) {
        try {
            $MallaActivacion = json_decode($JsonMalla);
            //$valuesuni = "";
            $cont = 0;
            if ($MallaActivacion->Message == null) {
                if (is_object($MallaActivacion)) {
                    if (($MallaActivacion->SaleZone->Month != '') && ($MallaActivacion->SaleZone->Year != '')) {
                        $values = "('" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->BusinessDays) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->ElapsedDays) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->Month) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->Year) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->AgencyId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->AgencyName) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->Code) . "')";
                        /* $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->AgencyId) . "'" .
                          "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->Code) . "',"; */
                        $cont++;
                        $TableName = "mallaactivacion";
                        $ColumnsName = "`DiasHabiles`,`DiasTranscurridos`,`Mes`,`Año`,`CodAgencia`,`NombreAgencia`,`CodZonaVentas`";
                        $ColumnsName = utf8_encode($ColumnsName);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        for ($i = 0; $i < count($MallaActivacion->ActivationMesh->ActivationMeshDetails); $i++) {
                            $query = "SELECT CodAgencia FROM `agencia` WHERE Activo=1";
                            $Agencies = YII::app()->db->createCommand($query)->queryAll();
                            foreach ($Agencies as $Agency) {
                                $Mallaid = "SELECT Id as IdMallaActivacion FROM `mallaactivacion` WHERE CodAgencia='" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->AgencyId) . "'"
                                        . "AND CodZonaVentas='" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->SaleZone->Code) . "'";
                                $IdMallaAct = $this->GetDatosAgenciaRow($Mallaid, $Agency['CodAgencia']);
                                $values = "('" . $IdMallaAct['IdMallaActivacion'] . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->ActivationMesh->ActivationMeshDetails[$i]->Attribute) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->ActivationMesh->ActivationMeshDetails[$i]->Budgeted) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->ActivationMesh->ActivationMeshDetails[$i]->ClientId) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->ActivationMesh->ActivationMeshDetails[$i]->ClientName) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->ActivationMesh->ActivationMeshDetails[$i]->Executed) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $MallaActivacion->ActivationMesh->ActivationMeshDetails[$i]->Fulfillment) . "')";
                                //$valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->SalesDistrictId) . "',";
                                $TableName = "mallaactivaciondetalle";
                                $ColumnsName = "`IdMallaActivacion`,`Tipo`,`Presupuestado`,`CuentaCliente`,`NombreCliente`,`Ejecutado`,`Cumplimiento`";
                                $values = utf8_encode($values);
                                //$values = utf8_decode($values);
                                $this->ExecuteQueryByAgencyWithReplace($TableName, $ColumnsName, $values, $Agency['CodAgencia']);
                            }
                            $cont++;
                        }
                        return $cont;
                    }
                }
            }
            return "";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setMallaActivation', $ex);
        }
    }

    public function setGeneral($JsonGeneral) {
        try {
            $objJson = utf8_encode($JsonGeneral);
            $objCumplimiento = json_decode($objJson, true);
            foreach ($objCumplimiento as $key => $valor) {
                if (!is_array($valor)) {
                    
                } else {
                    foreach ($valor as $keyDimens => $keyDimensValor) {
                        if (!is_array($keyDimensValor)) {
                            $encabezado['diasHabiles'] = $valor['BusinessDays'];
                            $encabezado['diasTrans'] = $valor['ElapsedDays'];
                            $encabezado['mes'] = $valor['Month'];
                            $encabezado['ano'] = $valor['Year'];
                        } else {
                            foreach ($keyDimensValor as $keyDimensDetalle => $keyDimensValorDetalle) {
                                $agenciaEncabezado[$keyDimensDetalle]['codAgencia'] = $keyDimensValorDetalle['AgencyId'];
                                $agenciaEncabezado[$keyDimensDetalle]['NombreAgencia'] = utf8_decode($keyDimensValorDetalle['AgencyName']);
                                foreach ($keyDimensValorDetalle['Dimensions'] as $keyDetalle => $keyDetalleValor) {
                                    $agencia[$keyDimensDetalle][$keyDetalle]['PresupuestadoCumplimiento'] = $keyDetalleValor['Budgeted'];
                                    $agencia[$keyDimensDetalle][$keyDetalle]['NombreDimensionCumplimiento'] = $keyDetalleValor['DimensionName'];
                                    $agencia[$keyDimensDetalle][$keyDetalle]['EjecutadoCumplimiento'] = $keyDetalleValor['Executed'];
                                    $agencia[$keyDimensDetalle][$keyDetalle]['CumplimientoCumplimiento'] = $keyDetalleValor['Fulfillment'];
                                }
                            }
                        }
                    }
                }
            }
            $values = "";
            $valuesD = "";
            foreach ($agenciaEncabezado as $arrayresult) {
                $newEncabezado[] = array_merge($arrayresult, $encabezado);
            }
            for ($i = 0; $i < count($newEncabezado); $i++) {
                /* $modelEncabezado = new Cumplimientoagencia;
                  $modelEncabezado->DiasHabiles = $newEncabezado[$i]['diasHabiles'];
                  $modelEncabezado->DiasTranscurridos = $newEncabezado[$i]['diasTrans'];
                  $modelEncabezado->Mes = $newEncabezado[$i]['mes'];
                  $modelEncabezado->AÃ±o = $newEncabezado[$i]['ano'];
                  $modelEncabezado->CodAgencia = $newEncabezado[$i]['codAgencia'];
                  $modelEncabezado->NombreAgencia = $newEncabezado[$i]['NombreAgencia']; */
                $values .= "(" . $newEncabezado[$i]['diasHabiles'] . "," . $newEncabezado[$i]['diasTrans'] . "," . $newEncabezado[$i]['mes'] . ","
                        . "" . $newEncabezado[$i]['ano'] . "," . $newEncabezado[$i]['codAgencia'] . "," . $newEncabezado[$i]['NombreAgencia'] . ")";
                $TableName = "cumplimientoagencia";
                $ColumnsName = "`DiasHabiles`,`DiasTranscurridos`,`Mes`,`Año`,`CodAgencia`,`NombreAgencia`";
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, "000");
                $header = $this->excecuteDatabaseStoredFunctions("`fn_getidfromagencycumplimiento`(" . $newEncabezado[$i]['codAgencia'] . ")");
                //$modelEncabezado->save();
                foreach ($agencia[$i] as $toInsertDetallekey => $toInsertDetalleVal) {
                    for ($p = 0; $p < count($toInsertDetalleVal); $p++) {
                        /* $modeloDetalle = new Cumplimientoagenciadetalle;
                          $modeloDetalle->IdCumplimientoAgencia = $modelEncabezado->Id;
                          $modeloDetalle->Presupuestado = $agencia[$i][$p]['PresupuestadoCumplimiento'];
                          $modeloDetalle->NombreDimension = $agencia[$i][$p]['NombreDimensionCumplimiento'];
                          $modeloDetalle->Ejecutado = $agencia[$i][$p]['EjecutadoCumplimiento'];
                          $modeloDetalle->Cumplimiento = $agencia[$i][$p]['CumplimientoCumplimiento'];
                          $modeloDetalle->save(); */
                        $valuesD .= "($header," . $agencia[$i][$p]['PresupuestadoCumplimiento'] . "," . $agencia[$i][$p]['NombreDimensionCumplimiento'] . ","
                                . "" . $agencia[$i][$p]['EjecutadoCumplimiento'] . "," . $agencia[$i][$p]['CumplimientoCumplimiento'] . "),";
                    }
                    //$modeloDetalle->unsetAttributes();
                    //$modelEncabezado->unsetAttributes();
                }
            }
            $valuesD = substr($valuesD, 0, -1);
            $TableNameD = "mallaactivaciondetalle";
            $ColumnsNameD = "`IdCumplimientoAgencia`,`Presupuestado`,`NombreDimension`,`Ejecutado`,`Cumplimiento`";
            $this->ReplaceAllActiveAgencies($TableNameD, $ColumnsNameD, $valuesD);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setGeneral', $ex);
        }
    }

    public function getProcessingMethodsReRun() {
        try {
            return $this->excecuteDatabaseStoredProcedures("`sp_processingmethodsrerun`();");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getProcessingMethods', $ex);
        }
    }

    public function getActiveAgencies() {
        try {
            return $this->excecuteDatabaseStoredProcedures("`sp_getactiveagencies`();");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getActiveAgencies', $ex);
        }
    }

    public function setDeleteInactiveSalesZoneFromZonaVentas() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_deleteinactivesaleszonefromzonaventas`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSalesZoneFromZonaVentas', $ex);
        }
    }

    public function getAmountofActiveAgenciesofGroups() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_getamountofactiveagenciesofgroups`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getAmountofActiveAgenciesofGroups', $ex);
        }
    }

    public function setUpdateStatusForCompleteProcess() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatestatusforcompleteprocess`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateStatusForCompleteProcess', $ex);
        }
    }

    public function getActiveSites() {
        try {
            $sql = "SELECT CodSitio,CodAgencia FROM `sitios` WHERE Activo=1 ORDER BY CodAgencia";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getSitebyAgency', $ex);
        }
    }

    public function setUpdateSaleGroupStatus($group) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatesalegroupstatus`('$group')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateSaleGroupStatus', $ex);
        }
    }

    public function setUpdateInventLocationPreSales($site) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateinventlocationpresales`('$site')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateInventLocationPreSales', $ex);
        }
    }

    public function setUpdateSiteConPreSalesInvent($site) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatesiteconpresalesinvent`('$site')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateSiteConPreSalesInvent', $ex);
        }
    }

    public function setUpdateInactiveVariantsSite($site) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateinactivevariantssite`('$site')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateInactiveVariantsSite', $ex);
        }
    }

    public function setUpdateUpdateStatusSaleGroup($agency) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateupdatestatussalegroup`('$agency')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateUpdateStatusSaleGroup', $ex);
        }
    }

    public function setUpdateMethodStatusToOne($id) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatemethodstatustoone`($id)");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateMethodStatusToOne', $ex);
        }
    }

    public function setUpdateMethodStatusToCero($id) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatemethodstatustocero`($id)");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateMethodStatusToCero', $ex);
        }
    }

    public function setUpdateSalesZoneByAgencyToCero($Agency) {
        try {
            $sql = "UPDATE `zonaventas` SET `EstadoActualizacion`=0";
            $this->ExecuteQueryByAgency($sql, $Agency);
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateSalesZoneByAgencyToCero', $ex);
        }
    }

    public function setActiveZonesStatusInCero() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_setactivezonesstatusincero`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setActiveZonesStatusInCero', $ex);
        }
    }

    public function setUpdateGlobalSalesZone() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatezonaventasglobales`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateGlobalSalesZone', $ex);
        }
    }

    public function setUpdateGlobalSalesZoneCapacityCredit() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateglobalsaleszonecapacitycredit`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateGlobalSalesZoneCapacityCredit', $ex);
        }
    }

    public function getActiveGroups() {
        try {
            $sql = "DELETE FROM `portafolio` WHERE CodigoGrupoVentas NOT IN (SELECT CodigoGrupoVentas FROM `gruposventas`)";
            $this->InsertInfoActiveAgency($sql);
            return $this->excecuteDatabaseStoredProcedures("`sp_getactivegroups`();");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getActiveGroups', $ex);
        }
    }

    public function setUpdateGroupSalesStatus() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updategroupsalesstatus`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateGroupSalesStatus', $ex);
        }
    }

    public function getQuerySalesZonesbyAgency($agencia) {
        try {
            return $this->excecuteDatabaseStoredProcedures("`sp_querysaleszonesbyagency`('$agencia');");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getQuerySalesZonesbyAgency', $ex);
        }
    }

    public function setUpdateDate($Zone, $Date, $time) {
        try {
            return $this->excecuteDatabaseStoredProceduresQuery("`sp_setupdatedate`('$Zone','$Date','$time');");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateDate', $ex);
        }
    }

    public function setUpdateInvoiceBalanceStatus() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateinvoicebalancestatus`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateInvoiceBalanceStatus', $ex);
        }
    }

    public function setUpdateDateInvoiceBalanceStatus($Zone, $Date, $time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatedateinvoicebalancestatus`('$Zone','$Date','$time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'UpdateDateInvoiceBalanceStatus', $ex);
        }
    }

    public function setUpdateInvoiceTransactionsStatus() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateinvoicetransactionsstatus`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateInvoiceTransactionsStatus', $ex);
        }
    }

    public function setUpdateDateInvoiceTransactionsStatus($Zone, $Date, $time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatedateinvoicetransactionsstatus`('$Zone','$Date','$time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateDateInvoiceTransactionsStatus', $ex);
        }
    }

    public function setUpdateOutstandingInvoiceStatus() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updateoutstandinginvoicestatus`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateOutstandingInvoiceStatus', $ex);
        }
    }

    public function setUpdateDateOutstandingInvoiceStatus($Zone, $Date, $time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatedateoutstandinginvoicestatus`('$Zone','$Date','$time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateDateOutstandingInvoiceStatus', $ex);
        }
    }

    public function setUpdateSalesBudgetStatus() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatesalesbudgetstatus`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateSalesBudgetStatus', $ex);
        }
    }

    public function setUpdateDateSalesBudgetStatus($Zone, $Date, $time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatedatesalesbudgetstatus`('$Zone','$Date','$time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateDateSalesBudgetStatus', $ex);
        }
    }

    public function setUpdateCreditCapacityStatus($Zone, $Date, $time) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_updatecreditcapacitystatus`('$Zone','$Date','$time')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateCreditCapacityStatus', $ex);
        }
    }

    public function setUpdateDatebyAgency($Zone, $Date, $time, $Agency) {
        try {
            $ColumnsName = "`CodZonaVentas`,`FechaComparacion`,`HoraComparacion`";
            $values = "('$Zone','$Date','$time')";
            $TableName = '`fechaactualizaciones`';
            return $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setUpdateDatebyAgency', $ex);
        }
    }

    public function setSalesZoneActives($SaleZones) {
        try {
            $SaleZones = json_decode($SaleZones);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            if (is_object($SaleZones)) {
                if (($SaleZones->SalesDistrictId != '') && ($SaleZones->AgencyCode != '')) {
                    $this->excecuteDatabaseStoredFunctions("`fn_insertupdatesalezone`('" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->SalesDistrictId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->AgencyCode) . "','" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->AgencyName) . "')");
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->SalesDistrictId) . "',";
                    $cont++;
                }
            } else {
                for ($i = 0; $i < count($SaleZones); $i++) {
                    if (($SaleZones[$i]->SalesDistrictId != '') && ($SaleZones[$i]->AgencyCode != '')) {
                        $this->excecuteDatabaseStoredFunctions("`fn_insertupdatesalezone`('" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->SalesDistrictId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->AgencyCode) . "','" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->AgencyName) . "')");
                        $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->SalesDistrictId) . "',";
                        $cont++;
                    }
                }
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $TableName = "`zonaventasglobales`";
            $columnsuni = "`CodZonaVentas`";
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalesZoneActives', $ex);
        }
    }

    public function setSalesZoneInactives($SaleZones) {
        try {
            $SaleZones = json_decode($SaleZones);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            if (is_object($SaleZones)) {
                if (($SaleZones->SalesDistrictId != '') && ($SaleZones->AgencyCode != '')) {
                    $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->SalesDistrictId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->Description) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->AdvisorIdentification) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->AdvisorName) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->AgencyCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->AgencyName) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones->SalesDistrictId) . "',";
                    $cont++;
                }
            } else {
                for ($i = 0; $i < count($SaleZones); $i++) {
                    if (($SaleZones[$i]->SalesDistrictId != '') && ($SaleZones[$i]->AgencyCode != '')) {
                        $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->SalesDistrictId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->Description) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->AdvisorIdentification) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->AdvisorName) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->AgencyCode) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->AgencyName) . "'),";
                        $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $SaleZones[$i]->SalesDistrictId) . "',";
                        $cont++;
                    }
                }
            }
            $values = substr($values, 0, -1);
            $valuesuni = substr($valuesuni, 0, -1);
            $TableName = "`zonaventasinactivas`";
            $ColumnsName = "`CodigoZonaVentas`,`NombreZonaVentas`,`CedulaAsesor`,`NombreAsesorComercial`,`CodigoAgencia`,`NombreAgencia`";
            $columnsuni = "`CodigoZonaVentas`";
//$set = "EstadoInsert=0";
//$this->updatebasic($TableName,$set,"");
            $this->ReplaceDelete($TableName, $ColumnsName, $values, $valuesuni, $columnsuni, 1);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalesZoneInactives', $ex);
        }
    }

    public function setMerchandisers($Merchandisers) {//falta terminarlo
        try {
            $Merchandisers = json_decode($Merchandisers);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            if (is_object($Merchandisers)) {
                if (($Merchandisers->SalesDistrictId != '') && ($Merchandisers->AgencyCode != '')) {
                    $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->SalesDistrictId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->Description) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->AdvisorIdentification) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->AdvisorName) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->AgencyCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->AgencyName) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers->SalesDistrictId) . "',";
                    $cont++;
                }
            } else {
                for ($i = 0; $i < count($SaleZones); $i++) {
                    if (($SaleZones[$i]->SalesDistrictId != '') && ($SaleZones[$i]->AgencyCode != '')) {
                        $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->AccountNum) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->IdentificationNum) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->Name) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->NameAlias) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->DeliveryAddress) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->Phone) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->MobilePhone) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->Email) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->Status) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->ChainId) . "'),";
                        $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $Merchandisers[$i]->SalesDistrictId) . "',";
                        $cont++;
                    }
                }
            }
            $values = substr($values, 0, -1);
            $valuesuni = substr($valuesuni, 0, -1);
            $TableName = "`zonaventasinactivas`";
            $ColumnsName = "`CodigoZonaVentas`,`NombreZonaVentas`,`CedulaAsesor`,`NombreAsesorComercial`,`CodigoAgencia`,`NombreAgencia`";
            $columnsuni = "`CodigoZonaVentas`";
//$set = "EstadoInsert=0";
//$this->updatebasic($TableName,$set,"");
            $this->ReplaceDelete($TableName, $ColumnsName, $values, $valuesuni, $columnsuni, 1);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalesZoneInactives', $ex);
        }
    }

    public function setLogisticZone($logisticZones) {
        try {
            $logisticZones = json_decode($logisticZones);
            $values = "";
            $valuesuni = "";
            for ($i = 0; $i < count($logisticZones); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $logisticZones[$i]->ZoneId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $logisticZones[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $logisticZones[$i]->ZoneId) . "',";
            }
            $values = substr($values, 0, -1);
            $valuesuni = substr($valuesuni, 0, -1);
            $TableName = "`zonalogistica`";
            $ColumnsName = "`CodZonaLogistica`,`NombreZonaLogistica`";
            $columnsuni = "`CodZonaLogistica`";
            $this->ReplaceAllActiveAgenciesWithDelete($TableName, $ColumnsName, $values, $valuesuni, $columnsuni, '1');
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setLogisticZone', $ex);
        }
    }

    public function setVehicles($vehicles) {
        try {
            $vehicles = json_decode($vehicles);
            $values = "";
            $valuesuni = "";
            $valuesd = "";
            $valuesunid = "";
            for ($i = 0; $i < count($vehicles); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->vehicleId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $vehicles[$i]->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->DriverId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->Phone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->PlateId) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->vehicleId) . "',";
                $valuesd.="('" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->vehicleId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $vehicles[$i]->SiteId->InventSite->InventSiteId) . "'),";
            }
            $values = substr($values, 0, -1);
            $valuesuni = substr($valuesuni, 0, -1);
            $TableName = "`vehiculos`";
            $ColumnsName = "`CodigoVehiculo`,`NombreTransportador`,`CedulaConductor`,`Telefono`,`Placa`";
            $columnsuni = "`CodigoVehiculo`";
            $valuesd = substr($valuesd, 0, -1);
            $TableNamed = "`vehiculossitio`";
            $ColumnsNamed = "`CodigoVehiculo`,`CodSitio`";
            $this->ReplaceAllActiveAgenciesWithDelete($TableName, $ColumnsName, $values, $valuesuni, $columnsuni, 1);
            $this->ReplaceAllActiveAgenciesWithDelete($TableNamed, $ColumnsNamed, $valuesd, $valuesuni, $columnsuni, 1);
            $sql = "DELETE FROM `vehiculossitio` WHERE CodSitio NOT IN (SELECT CodigoSitio FROM `zonaventaalmacen`)";
            $this->InsertInfoActiveAgency($sql);
            $sql = "DELETE FROM `vehiculos` WHERE CodigoVehiculo NOT IN (SELECT CodigoVehiculo FROM `vehiculossitio`)";
            $this->InsertInfoActiveAgency($sql);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setVehicles', $ex);
        }
    }

    public function setProviderRestriction($ProviderRestriction) {
        try {
            $ProviderRestriction = json_decode($ProviderRestriction);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`restriccioncuentaproveedor`";
            $ColumnsName = "`CuentaCliente`,`CodZonaVentas`,`CuentaProveedor`,`TipoCuenta`,`CodigoVariante`,`CodigoArticulo`,`CodigoArticuloGrupoCategoria`,`Tipo`,"
                    . "`Caracteristica1`,`Caracteristica2`";
            $columnsuni = "`CuentaCliente`,`CodZonaVentas`,`CuentaProveedor`";
            for ($i = 0; $i < count($ProviderRestriction); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem6cero', $ProviderRestriction[$i]->CustAccount) . "',"
                        . "'" . $this->ValidateItem('ValidateItem5cero', $ProviderRestriction[$i]->SalesZone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem8cero', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->VendAccountId) . "',"
                        . "'" . $this->ValidateItem('ValidateAccountType', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->AccountYype) . "',"
                        . "'" . $this->ValidateItem('ValidateItem8cero', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->RetailVariantId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem8cero', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->ItemId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->GroupCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->InventSizeId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->InventColorId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->InventStyleId) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem6cero', $ProviderRestriction[$i]->CustAccount) . $this->ValidateItem('ValidateItem5cero', $ProviderRestriction[$i]->SalesZone) .
                        $this->ValidateItem('ValidateItem8cero', $ProviderRestriction[$i]->VendorRestricion->VendorRestricionid->VendAccountId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 3);
            $columnsunidel = "`CodZonaVentas`";
            $valuesunidel = "SELECT `CodZonaVentas` FROM `zonaventas`";
            $this->DeleteAllActiveAgencies($TableName, $valuesunidel, $columnsunidel, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setProviderRestriction', $ex);
        }
    }

    public function setConvertionUnits($ConvertionUnit) {
        try {
            $ConvertionUnits = json_decode($ConvertionUnit);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`unidadesdeconversion`";
            $ColumnsName = "`CodigoArticulo`,`CodigoDesdeUnidad`,`NombreDesdeUnidad`,`CodigoHastaUnidad`,`NombreHastaUnidad`,`Factor`";
            $columnsuni = "`CodigoArticulo`,`CodigoDesdeUnidad`,`CodigoHastaUnidad`";
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            for ($i = 0; $i < count($ConvertionUnits); $i++) {
                if ($ConvertionUnits[$i]->Itemid != '') {
                    foreach ($ValidateUnitCode as $value) {
                        if (strtolower($ConvertionUnits[$i]->FromUnitCode) == strtolower($value['NombreUnidad'])) {
                            $FromUnitCode = $value['CodigoUnidad'];
                        }
                        if (strtolower($ConvertionUnits[$i]->ToUnitCode) == strtolower($value['NombreUnidad'])) {
                            $ToUnitCode = $value['CodigoUnidad'];
                        }
                    }
                    if (!isset($FromUnitCode)) {
                        $FromUnitCode = '000';
                    }
                    if (!isset($ToUnitCode)) {
                        $ToUnitCode = '000';
                    }
                    $values.="('" . $this->ValidateItem('ValidateItem3cero', $ConvertionUnits[$i]->Itemid) . "',"
                            . "'$FromUnitCode',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConvertionUnits[$i]->DescriptionFrom) . "',"
                            . "'$ToUnitCode',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConvertionUnits[$i]->DescriptionTo) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $ConvertionUnits[$i]->Factor) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $ConvertionUnits[$i]->Itemid) . $FromUnitCode . $ToUnitCode . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 3);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setConvertionUnits', $ex);
        }
    }

    public function setPriceGroups($PriceGroups) {
        try {
            $PriceGroups = json_decode($PriceGroups);
            $values = "";
            $valuesuni = "";
            $TableName = "`grupodeprecios`";
            $ColumnsName = "`CodigoGrupoPrecio`,`NombreGrupodePrecio`";
            $columnsuni = "`CodigoGrupoPrecio`";
            $cont = 0;
            for ($i = 0; $i < count($PriceGroups); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $PriceGroups[$i]->PriceGroup) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $PriceGroups[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $PriceGroups[$i]->PriceGroup) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setPriceGroups', $ex);
        }
    }

    public function setArticleHierarchy($ArticleHierarchy) {
        try {
            $ArticleHierarchy = json_decode($ArticleHierarchy);
            $values = "";
            $valuesuni = "";
            $TableName = "`jerarquiaarticulos`";
            $ColumnsName = "`Nivel`,`Nombre`,`IdPrincipal`";
            $columnsuni = "`Nombre`";
            $cont = 0;
            for ($i = 0; $i < count($ArticleHierarchy); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $ArticleHierarchy[$i]->Level) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ArticleHierarchy[$i]->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $ArticleHierarchy[$i]->PrincipalId) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $ArticleHierarchy[$i]->Name) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setArticleHierarchy', $ex);
        }
    }

    public function setLineDiscountGroup($LineDiscountGroup) {
        try {
            $LineDiscountGroup = json_decode($LineDiscountGroup);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`grupodedescuentodelinea`";
            $ColumnsName = "`CodigoGrupoDescuentoLinea`,`NombreGrupoDescuentoLinea`";
            $columnsuni = "`CodigoGrupoDescuentoLinea`";
            for ($i = 0; $i < count($LineDiscountGroup); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $LineDiscountGroup[$i]->PriceGroup) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $LineDiscountGroup[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $LineDiscountGroup[$i]->PriceGroup) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setLineDiscountGroup', $ex);
        }
    }

    public function setMultiLineDiscountGroup($MultiLineDiscountGroup) {
        try {
            $MultiLineDiscountGroup = json_decode($MultiLineDiscountGroup);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`grupodedescuentodemultilinea`";
            $ColumnsName = "`CodigoGrupoDescuentoMultiLinea`,`NombreGrupoDescuentoMultiLinea`";
            $columnsuni = "`CodigoGrupoDescuentoMultiLínea`";
            for ($i = 0; $i < count($MultiLineDiscountGroup); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $MultiLineDiscountGroup[$i]->PriceGroup) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $MultiLineDiscountGroup[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $MultiLineDiscountGroup[$i]->PriceGroup) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setMultiLineDiscountGroup', $ex);
        }
    }

    public function setSites($Sites) {
        try {
            $Sites = json_decode($Sites);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`sitios`";
            $ColumnsName = "`CodSitio`,`Nombre`";
            $columnsuni = "`CodSitio`";
            for ($i = 0; $i < count($Sites); $i++) {
                $CodSite = $this->ValidateItem('ValidateItem3cero', $Sites[$i]->InventSiteId);
                $Name = $this->ValidateItem('ValidateItemSinDato', $Sites[$i]->Name);
                $values.="('$CodSite','$Name'),";
                $valuesuni.="'$CodSite',";
                $this->excecuteDatabaseStoredFunctions("`fn_insertupdatesite`('$CodSite','$Name')");
                $cont++;
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $columnsunidel = "`CodSitio`";
            $valuesunidel = "SELECT DISTINCT(`CodigoSitio`) FROM `zonaventaalmacen`";
            $this->DeleteAllActiveAgencies($TableName, $valuesunidel, $columnsunidel, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSites', $ex);
        }
    }

    public function setStock($Stock) {
        try {
            $Stock = json_decode($Stock);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`almacenes`";
            $ColumnsName = "`CodigoAlmacen`,`Nombre`,`CodSitio`";
            $columnsuni = "`CodigoAlmacen`";
            for ($i = 0; $i < count($Stock); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Stock[$i]->InventLocationId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Stock[$i]->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Stock[$i]->InventSiteId) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Stock[$i]->InventLocationId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $sql = "SET FOREIGN_KEY_CHECKS =0;DELETE FROM `almacenes` WHERE CodSitio NOT IN (SELECT CodSitio FROM `sitios` );SET FOREIGN_KEY_CHECKS=1";
            $this->InsertInfoActiveAgency($sql);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setStock', $ex);
        }
    }

    public function setProvider($Provider) {
        try {
            $Provider = json_decode($Provider);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont3 = 0;
            $TableName = "`proveedores`";
            $ColumnsName = "`CodigoCuentaProveedor`,`NombreCuentaProveedor`";
            $columnsuni = "`CodigoCuentaProveedor`";
            $valuesd = "";
            $valuesunid = "";
            $TableNamed = "`proveedoresdetalle`";
            $ColumnsNamed = "`CodigoCuentaProveedor`,`TipoContacto`,`ValorContacto`,`NombreContacto`";
            for ($i = 0; $i < count($Provider); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Provider[$i]->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Provider[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Provider[$i]->AccountNum) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
                    $values = "";
                    $cont = 0;
                }
                if ($Provider[$i]->ElectronicAddress != null) {
                    $valuesd.="('" . $this->ValidateItem('ValidateItem3cero', $Provider[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Provider[$i]->ElectronicAddress->ElectronicAddress->Type) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Provider[$i]->ElectronicAddress->ElectronicAddress->Locator) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Provider[$i]->ElectronicAddress->ElectronicAddress->Description) . "'),";
                    $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $Provider[$i]->AccountNum) .
                            $this->ValidateItem('ValidateItemSinDato', $Provider[$i]->ElectronicAddress->ElectronicAddress->Type) .
                            $this->ValidateItem('ValidateItem1cero', $Provider[$i]->ElectronicAddress->ElectronicAddress->Locator) .
                            $this->ValidateItem('ValidateItemSinDato', $Provider[$i]->ElectronicAddress->ElectronicAddress->Description) . "',";
                    $cont3++;
                    if ($cont3 == 2000) {
                        $valuesd = substr($valuesd, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableNamed, $ColumnsNamed, $valuesd);
                        $this->ReplaceWithAgency($TableNamed, $ColumnsNamed, $valuesd, '000');
                        $valuesd = "";
                        $cont3 = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
            }
            if ($valuesd != "") {
                $valuesd = substr($valuesd, 0, -1);
                $this->ReplaceAllActiveAgencies($TableNamed, $ColumnsNamed, $valuesd);
                $this->ReplaceWithAgency($TableNamed, $ColumnsNamed, $valuesd, '000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteAllActiveAgencies($TableNamed, $valuesunid, $ColumnsNamed, 4);
            $this->DeleteOldValues($TableNamed, $valuesunid, $ColumnsNamed, 4);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setProvider', $ex);
        }
    }

    public function setDocumentType($DocumentType) {
        try {
            $DocumentType = json_decode($DocumentType);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`tipodocumento`";
            $ColumnsName = "`Codigo`,`Nombre`";
            $columnsuni = "`Codigo`";
            for ($i = 0; $i < count($DocumentType); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $DocumentType[$i]->Code) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $DocumentType[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $DocumentType[$i]->Code) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDocumentType', $ex);
        }
    }

    public function setPaymentConditions($PaymentConditions) {
        try {
            $PaymentConditions = json_decode($PaymentConditions);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`condicionespago`";
            $ColumnsName = "`CodigoCondicionPago`,`Descripcion`,`Dias`";
            $columnsuni = "`CodigoCondicionPago`";
            for ($i = 0; $i < count($PaymentConditions); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $PaymentConditions[$i]->PaymTermId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $PaymentConditions[$i]->Description) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $PaymentConditions[$i]->NumOfDays) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $PaymentConditions[$i]->PaymTermId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setPaymentConditions', $ex);
        }
    }

    public function setPaymentTerms($PaymentTerms) {
        try {
            $PaymentTerms = json_decode($PaymentTerms);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`formaspago`";
            $ColumnsName = "`CodigoFormadePago`,`Descripcion`,`CuentaPuente`";
            $columnsuni = "`CodigoFormadePago`";
            for ($i = 0; $i < count($PaymentTerms); $i++) {
                $this->excecuteDatabaseStoredFunctions("`fn_insertupdatePaymentTerms`("
                        . "'" . $this->ValidateItem('ValidateItem3cero', $PaymentTerms[$i]->PaymModeId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $PaymentTerms[$i]->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $PaymentTerms[$i]->Description) . "')");
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $PaymentTerms[$i]->PaymModeId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setPaymentTerms', $ex);
        }
    }

    public function setBankAccounts($BankAccounts) {
        try {
            $BankAccounts = json_decode($BankAccounts);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`bancos`";
            $ColumnsName = "`CodBanco`,`Nombre`,`IdentificadorBanco`";
            $columnsuni = "`IdentificadorBanco`";
            for ($i = 0; $i < count($BankAccounts); $i++) {
                if (($BankAccounts[$i]->BankAgroupId != "") && ($BankAccounts[$i]->Name != "") && ($BankAccounts[$i]->RegistrationNum != "")) {
                    $values.="('" . $this->ValidateItem('ValidateItem3cero', $BankAccounts[$i]->BankAgroupId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $BankAccounts[$i]->Name) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $BankAccounts[$i]->RegistrationNum) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $BankAccounts[$i]->RegistrationNum) . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setBankAccounts', $ex);
        }
    }

    public function setCommercialHierarchy($CommercialHierarchy) {
        try {
            $CommercialHierarchy = json_decode($CommercialHierarchy);
            $values = "";
            $valuesA = "";
            $valuesuni = "";
            $valuesuniA = "";
            $cont = 0;
            $contA = 0;
            $TableName = "`jerarquiacomercial`";
            $ColumnsName = "`NumeroIdentidad`,`NombreEmpleado`,`NombreCargo`,`CodigoZonaVentas`,`Ciudad`,`CelularCorporativo`,`IdSucursal`,`NombreSucursal`,"
                    . "`IdCargoJefe`,`NombreJefe`,`CelularCorporativoJefe`,`CodigoCanal`,`NombreCanal`,`CódigoSubcanal`,`NombreSubCanal`";
            $columnsuni = "`NumeroIdentidad`";
            $TableNameA = "`asesorescomerciales`";
            $ColumnsNameA = "`CodAsesor`,`Cedula`,`Clave`,`Nombre`,`Telefono`,`TelefonoMovilPersonal`,`TelefonoMovilEmpresarial`,`CorreoElectronico`,`Direccion`,"
                    . "`Imagen`,`InfoActivity`,`IdPerfil`,`Agencia`";
            $columnsuniA = "`CodAsesor`";
            for ($i = 0; $i < count($CommercialHierarchy); $i++) {
                $SalesZoneCode = $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->SalesAreaCode);
                $agency = $this->excecuteDatabaseStoredFunctions("`fn_getzoneagencybysaleszonecode`('$SalesZoneCode')");
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeEmployee) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $CommercialHierarchy[$i]->NameEmployee) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $CommercialHierarchy[$i]->HcmTitle) . "',"
                        . "'$SalesZoneCode',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->city) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CorporateMobilePhone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->Branch) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->BranchName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->LeaderPosition) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->LeaderName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->LeaderMobilePhone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeChannel) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $CommercialHierarchy[$i]->CodeChannelName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeSubChannel) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $CommercialHierarchy[$i]->CodeSubChannelName) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeEmployee) . "',";
                $cont++;
                $this->excecuteDatabaseStoredFunctions("`fn_insertupdatebusinessadvisors`("
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeEmployee) . "',"
                        . "'$SalesZoneCode',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $CommercialHierarchy[$i]->NameEmployee) . "',"
                        . "'$agency')");
                $codeEmployee = $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeEmployee);
                $nameEmployee = $this->ValidateItem('ValidateItemSinDato', $CommercialHierarchy[$i]->NameEmployee);
                $this->InsertInfoAgencyBusinessAdvisors($codeEmployee, $SalesZoneCode, $nameEmployee, $agency);
                $valuesuniA.="'" . $this->ValidateItem('ValidateItem3cero', $CommercialHierarchy[$i]->CodeEmployee) . "',";
                $contA++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $ColumnsName = utf8_encode($ColumnsName);
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            $valuesuniA = substr($valuesuniA, 0, -1);
            $this->DeleteAllActiveAgencies($TableNameA, $valuesuniA, $columnsuniA, 1);
            $this->DeleteOldValues($TableNameA, $valuesuniA, $columnsuniA, 1);
            $sql = "DELETE FROM `jerarquiacomercial` WHERE `CodigoZonaVentas` NOT IN (SELECT `CodZonaVentas` FROM `zonaventas`)";
            $this->InsertInfoActiveAgency($sql);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setCommercialHierarchy', $ex);
        }
    }

    public function setLocalization($Localization) {
        try {
            $Localization = json_decode($Localization);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`Localizacion`";
            $ColumnsName = "`CodigoBarrio`,`NombreBarrio`,`CodigoLocalidad`,`NombreLocalidad`,`CodigoCiudad`,`NombreCiudad`,`CodigoDepartamento`,`NombreDepartamento`,"
                    . "`CodigoPais`,`NombrePais`";
            $columnsuni = "`CodigoBarrio`";
            for ($i = 0; $i < count($Localization); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Localization[$i]->CodDistrict) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Localization[$i]->NameDistrict) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Localization[$i]->CodCity) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Localization[$i]->NameCity) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Localization[$i]->CodCounty) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Localization[$i]->NameCounty) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Localization[$i]->CodState) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Localization[$i]->NameState) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Localization[$i]->CodCountryRegion) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Localization[$i]->NameCountryRegion) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Localization[$i]->CodDistrict) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setLocalization', $ex);
        }
    }

    public function setManagementReasonsCollection($ReasonsCollection) {
        try {
            $ReasonsCollection = json_decode($ReasonsCollection);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`motivosgestiondecobros`";
            $ColumnsName = "`CodMotivoGestion`,`Nombre`";
            $columnsuni = "`CodMotivoGestion`";
            for ($i = 0; $i < count($ReasonsCollection); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $ReasonsCollection[$i]->TypeId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ReasonsCollection[$i]->Name) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $ReasonsCollection[$i]->TypeId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setManagementReasonsCollection', $ex);
        }
    }

    public function setReturnReasonsProvider($ReturnReasonsProvider) {
        try {
            $ReturnReasonsProvider = json_decode($ReturnReasonsProvider);
            $values = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`motivosdevolucionproveedor`";
            $ColumnsName = "`CodigoGrupoMotivoDevolucion`,`CodigoMotivoDevolucion`,`NombreMotivoDevolucion`,`CuentaProveedor`";
            $columnsuni = "`CodigoMotivoDevolucion`,`CuentaProveedor`";
            for ($i = 0; $i < count($ReturnReasonsProvider->VendAccount); $i++) {
                for ($j = 0; $j < count($ReturnReasonsProvider->VendAccount[$i]->ReasonCode); $j++) {
                    $values.="('" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProvider->ReasonCodeGroupId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProvider->VendAccount[$i]->ReasonCode[$j]->ReasonCodeId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ReturnReasonsProvider->VendAccount[$i]->ReasonCode[$j]->Name) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProvider->VendAccount[$i]->VendAccountId) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProvider->VendAccount[$i]->ReasonCode[$j]->ReasonCodeId) .
                            $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProvider->VendAccount[$i]->VendAccountId) . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 2);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setReturnReasonsProvider', $ex);
        }
    }

    public function setReturnReasonsProviderArticle($ReturnReasonsProviderArticle) {
        try {
            $ReturnReasonsProviderArticle = json_decode($ReturnReasonsProviderArticle);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`motivosdevolucionproveedorarticulo`";
            $ColumnsName = "`CodigoGrupoMotivoDevolucion`,`CodigoMotivoDevolucion`,`CodigoArticulo`,`CuentaProveedor`,`Porcentaje`";
            $columnsuni = "`CodigoMotivoDevolucion`,`CuentaProveedor`";
            if (is_object($ReturnReasonsProviderArticle)) {
                $values.="('" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle->ReturnReasonGroupId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle->ReturnReasonCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle->ItemId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ReturnReasonsProviderArticle->VendAccount) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle->Percent) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle->ReturnReasonCode) .
                        $this->ValidateItem('ValidateItemSinDato', $ReturnReasonsProviderArticle->VendAccount) . "',";
                $i = 1;
            } else {
                for ($i = 0; $i < count($ReturnReasonsProviderArticle); $i++) {
                    $values.="('" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle[$i]->ReturnReasonGroupId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle[$i]->ReturnReasonCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle[$i]->ItemId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ReturnReasonsProviderArticle[$i]->VendAccount) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle[$i]->Percent) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle[$i]->ReturnReasonCode) .
                            $this->ValidateItem('ValidateItem1cero', $ReturnReasonsProviderArticle[$i]->VendAccount) . "',";
                    $cont++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 2);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setReturnReasonsProviderArticle', $ex);
        }
    }

    public function setReturnReasonsCustomers($ReturnReasonsCustomers) {
        try {
            $ReturnReasonsCustomers = json_decode($ReturnReasonsCustomers);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`motivosdevolucionclientes`";
            $ColumnsName = "`CodigoGrupoMotivoDevolucion`,`CodigoMotivoDevolucion`,`NombreMotivoDevolucion`";
            $columnsuni = "`CodigoMotivoDevolucion`";
            for ($i = 0; $i < count($ReturnReasonsCustomers); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsCustomers[$i]->ReturnReasonGroupId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsCustomers[$i]->ReturnReasonCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ReturnReasonsCustomers[$i]->Description) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $ReturnReasonsCustomers[$i]->ReturnReasonCode) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setReturnReasonsCustomers', $ex);
        }
    }

    public function setConceptsCreditNotes($ConceptsCreditNotes) {
        try {
            $ConceptsCreditNotes = json_decode($ConceptsCreditNotes);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`conceptosnotacredito`";
            $ColumnsName = "`CodigoConceptoNotaCredito`,`NombreConceptoNotaCredito`,`CodigoDimension`,`Interfaz`";
            $columnsuni = "`CodigoConceptoNotaCredito`";
            for ($i = 0; $i < count($ConceptsCreditNotes); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItemSinDato', $ConceptsCreditNotes[$i]->Concept) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConceptsCreditNotes[$i]->Description) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $ConceptsCreditNotes[$i]->DimensionCode) . "',"
                        . "'" . substr($this->ValidateItem('ValidateItem3cero', $ConceptsCreditNotes[$i]->DimensionCode), 3, 1) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItemSinDato', $ConceptsCreditNotes[$i]->Concept) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setConceptsCreditNotes', $ex);
        }
    }

    public function setSetOfOrders($SetOfOrders) {
        try {
            $SetOfOrders = json_decode($SetOfOrders);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`conjuntopedido`";
            $ColumnsName = "`CodigoConjunto`,`NombreConjunto`,`CodigoResolucion`";
            $columnsuni = "`CodigoConjunto`";
            for ($i = 0; $i < count($SetOfOrders); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $SetOfOrders[$i]->SalesPoolId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $SetOfOrders[$i]->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $SetOfOrders[$i]->CodeResolution) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $SetOfOrders[$i]->SalesPoolId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
//$this->ReplaceWithAgency($TableName,$ColumnsName,$values,'000');
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
//$this->ReplaceWithAgency($TableName,$ColumnsName,$values,'000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
//$this->DeleteOldValues($TableName,$valuesuni,$columnsuni,1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSetOfOrders', $ex);
        }
    }

    public function setHomologationGroupTax($HomologationGroupTax) {
        try {
            $HomologationGroupTax = json_decode($HomologationGroupTax);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`homologaciongrupoimpuestos`";
            $ColumnsName = "`CodigoGrupoImpuestos`,`NombreGrupoImpuestos`,`CodigoTipoContribuyente`,`NombreTipoContribuyente`,`CodigoDepartamento`,`NombreDepartamento`,"
                    . "`CodigoCiudad`,`NombreCiudad`";
            $columnsuni = "`CodigoGrupoImpuestos`,`CodigoDepartamento`,`CodigoCiudad`";
            for ($i = 0; $i < count($HomologationGroupTax); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $HomologationGroupTax[$i]->TaxGroup) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationGroupTax[$i]->TaxGroupName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $HomologationGroupTax[$i]->ContributorCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationGroupTax[$i]->ContributorName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $HomologationGroupTax[$i]->County) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationGroupTax[$i]->CountyName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $HomologationGroupTax[$i]->State) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationGroupTax[$i]->StateName) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $HomologationGroupTax[$i]->TaxGroup) .
                        $this->ValidateItem('ValidateItemSinDato', $HomologationGroupTax[$i]->County) .
                        $this->ValidateItem('ValidateItemSinDato', $HomologationGroupTax[$i]->State) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 3);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setHomologationGroupTax', $ex);
        }
    }

    public function setCiiu($Ciiu) {
        try {
            $Ciiu = json_decode($Ciiu);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`ciiu`";
            $ColumnsName = "`CodigoCIIU`,`NombreCIIU`";
            $columnsuni = "`CodigoCIIU`";
            for ($i = 0; $i < count($Ciiu); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Ciiu[$i]->ActivityCIIU) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Ciiu[$i]->Description) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Ciiu[$i]->ActivityCIIU) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setCiiu', $ex);
        }
    }

    public function setHomologationDocumentTypes($HomologationDocumentTypes) {
        try {
            $HomologationDocumentTypes = json_decode($HomologationDocumentTypes);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`homologaciontiposdocumento`";
            $ColumnsName = "`CodigoTipoDocumento`,`NombreTipoDocumento`,`CodigoTipoContribuyente`,`NombreTipocontribuyente`,`CodigoTipoRegistro`,`NombreTipoRegistro`";
            $columnsuni = "`CodigoTipoDocumento`";
            for ($i = 0; $i < count($HomologationDocumentTypes); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $HomologationDocumentTypes[$i]->DocuTypeCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationDocumentTypes[$i]->DocuTypeName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $HomologationDocumentTypes[$i]->ContributorCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationDocumentTypes[$i]->ContributorName) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $HomologationDocumentTypes[$i]->RegistrationCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $HomologationDocumentTypes[$i]->RegistrationName) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $HomologationDocumentTypes[$i]->DocuTypeCode) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setHomologationDocumentTypes', $ex);
        }
    }

    public function setBalanceReason($BalanceReason) {
        try {
            $BalanceReason = json_decode($BalanceReason);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`motivossaldo`";
            $ColumnsName = "`CodMotivoSaldo`,`Nombre`";
            $columnsuni = "`CodMotivoSaldo`";
            for ($i = 0; $i < count($BalanceReason); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem1cero', $BalanceReason[$i]->SalesBalanceReasonCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $BalanceReason[$i]->Description) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $BalanceReason[$i]->SalesBalanceReasonCode) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setBalanceReason', $ex);
        }
    }

    public function setResolutions($Resolutions) {
        try {
            $Resolutions = json_decode($Resolutions);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`resoluciones`";
            $ColumnsName = "`CodigoResolucion`,`NumeroResolucion`,`Prefijo`,`RangoDesde`,`RangoHasta`,`AlarmaNumero`,`FechaInicio`,`FechaFinal`,`AlarmaFecha`,"
                    . "`CodigoSecuencia`,`CantidadRangoFactura`";
            $columnsuni = "`CodigoResolucion`";
            for ($i = 0; $i < count($Resolutions); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->Code) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->Number) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->Pefix) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->FromResolution) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->ToResolution) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->AlarmFromNumber) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $Resolutions[$i]->FromDate) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $Resolutions[$i]->ToDate) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $Resolutions[$i]->AlarmFromDate) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->SequenceCode) . "',20),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Resolutions[$i]->Code) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000');
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $this->DeleteOldValues($TableName, $valuesuni, $columnsuni, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setResolutions', $ex);
        }
    }

    public function setCommercialDynamic($CommercialDynamic) {
        try {
            $CommercialDynamic = json_decode($CommercialDynamic);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`dinamicascomerciales`";
            $ColumnsName = "`Codigo`,`Descripcion`,`CodigoSitio`,`Concepto`,`CodigoProveedor`,`ValorTotalDinamica`,`ValorGastado`,`Saldo`";
            $columnsuni = "`Codigo`";
            $sqlupdate = "UPDATE `dinamicascomerciales` SET `Estado`=0";
            $this->InsertInfoActiveAgency($sqlupdate);
            $sql = "SELECT COUNT(`Codigo`) FROM `dinamicascomerciales` WHERE `Codigo`=";
            $sqlupdate = "UPDATE `dinamicascomerciales` SET `Estado`=1 WHERE `Codigo`=";
            if (is_object($CommercialDynamic)) {
                $sql .= "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->ProjectId) . "'";
                $sqlInsert = "INSERT INTO `dinamicascomerciales`(`Codigo`,`Descripcion`,`CodigoSitio`,`Concepto`,`CodigoProveedor`,`ValorTotalDinamica`,`ValorGastado`,`Saldo`,`Estado`) "
                        . "VALUES ('" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->ProjectId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $CommercialDynamic->Description) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->Sites) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->ProjGroupId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->CustAccount) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->TotalValue) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->SpentValue) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->Balance) . "',1)";
                $sqlupdate.="'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->ProjectId) . "'";
                $this->InsertAllActiveAgencies($sql, $sqlInsert, $sqlupdate);
                $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic->ProjectId) . "',";
                $i = 1;
            } else {
                for ($i = 0; $i < count($CommercialDynamic); $i++) {
                    $sql2 = $sql . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->ProjectId) . "'";
                    $sqlInsert = "INSERT INTO `dinamicascomerciales`(`Codigo`,`Descripcion`,`CodigoSitio`,`Concepto`,`CodigoProveedor`,`ValorTotalDinamica`,`ValorGastado`,`Saldo`,`Estado`) "
                            . "VALUES ('" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->ProjectId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $CommercialDynamic[$i]->Description) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->Sites) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->ProjGroupId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->CustAccount) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->TotalValue) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->SpentValue) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->Balance) . "',1)";
                    $sqlupdate2 = $sqlupdate . "'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->ProjectId) . "'";
                    $this->InsertAllActiveAgencies($sql2, $sqlInsert, $sqlupdate2);
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem1cero', $CommercialDynamic[$i]->ProjectId) . "',";
                    $cont++;
                }
            }
            $this->DeleteAllActiveAgencies($TableName, "'1'", "`Estado`", 1); //Elimina dinamicas comerciales en estado diferente de 1
            $columnsunidel = "`CodigoProveedor`";
            $valuesunidel = "SELECT `CodigoCuentaProveedor` FROM `proveedores`";
            $this->DeleteAllActiveAgencies($TableName, $valuesunidel, $columnsunidel, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setCommercialDynamic', $ex);
        }
    }

    public function setTradeAgreementsLineDiscount($TradeAgreementsLineDiscount) {
        try {
            $TradeAgreementsLineDiscount = json_decode($TradeAgreementsLineDiscount);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`acuerdoscomercialesdescuentolinea`";
            $ColumnsName = "`IdAcuerdoComercial`,`TipoAcuerdo`,`TipoCuentaCliente`,`CuentaCliente`,`CodigoClienteGrupoDescuentoLinea`,`TipoCuentaArticulos`,`CodigoVariante`,"
                    . "`CodigoArticuloGrupoDescuentoLinea`,`PorcentajeDescuentoLinea1`,`PorcentajeDescuentoLinea2`,`CodigoUnidadMedida`,`NombreUnidadMedida`,`CantidadDesde`,"
                    . "`CantidadHasta`,`FechaInicio`,`FechaFinal`,`LimiteVentas`,`Saldo`,`Sitio`,`CodigoAlmacen`,`PorcentajeAlerta`";
            $columnsuni = "`IdAcuerdoComercial`";
            $sql = "DELETE FROM `acuerdoscomercialesdescuentolinea` WHERE `CodigoAlmacen`='EMPTY'";
            $this->InsertInfoActiveAgency($sql);
            $sqlDel = "DELETE FROM `acuerdoscomercialesdescuentolinea` WHERE `Sitio`='EMPTY'";
            $this->InsertInfoActiveAgency($sqlDel);
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            for ($i = 0; $i < count($TradeAgreementsLineDiscount); $i++) {
                if ((trim($TradeAgreementsLineDiscount[$i]->AgreementId) != "") && (trim($TradeAgreementsLineDiscount[$i]->AgreementId) != 0)) {
                    foreach ($ValidateUnitCode as $value) {
                        if (strtolower($TradeAgreementsLineDiscount[$i]->Unit) == strtolower($value['NombreUnidad'])) {
                            $UnitCode = $value['CodigoUnidad'];
                        }
                    }
                    if (!isset($UnitCode)) {
                        $UnitCode = '000';
                    }
                    $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $TradeAgreementsLineDiscount[$i]->AgreementId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->Relation) . "',"
                            . "'" . $this->ValidateItem('ValidateAccountType', $TradeAgreementsLineDiscount[$i]->AccountCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $TradeAgreementsLineDiscount[$i]->CustCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsLineDiscount[$i]->GroupCodePrice) . "',"
                            . "'" . $this->ValidateItem('ValidateAccountType', $TradeAgreementsLineDiscount[$i]->ItemCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $TradeAgreementsLineDiscount[$i]->RetailVariantId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsLineDiscount[$i]->ItemRelation) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->DiscountPercent1) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->DiscountPercent2) . "',"
                            . "'$UnitCode',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $TradeAgreementsLineDiscount[$i]->UnitDescription) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->QuantityFrom) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->QuantityTo) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $TradeAgreementsLineDiscount[$i]->FromDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $TradeAgreementsLineDiscount[$i]->ToDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->Limit) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->Amount) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsLineDiscount[$i]->Site) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsLineDiscount[$i]->Location) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsLineDiscount[$i]->PercentAlert) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $TradeAgreementsLineDiscount[$i]->AgreementId) . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $valuesuni2 = "`Sitio`";
            $columnsuni2 = "SELECT CodSitio FROM `sitios`) AND `Sitio` NOT IN ('EMPTY'";
            $this->DeleteAllActiveAgencies($TableName, $valuesuni2, $columnsuni2, 1);
            $valuesuni3 = "`CuentaCliente`";
            $columnsuni3 = "SELECT CuentaCliente FROM `cliente`) AND (CuentaCliente<>'Sin Dato'";
            $this->DeleteAllActiveAgencies($TableName, $valuesuni3, $columnsuni3, 1);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setTradeAgreementsLineDiscount', $ex);
        }
    }

    public function setTradeAgreementsMultiLineDiscount($TradeAgreementsMultiLineDiscount) {
        try {
            $TradeAgreementsMultiLineDiscount = json_decode($TradeAgreementsMultiLineDiscount);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`acuerdoscomercialesdescuentomultilinea`";
            $ColumnsName = "`IdAcuerdoComercial`,`TipoAcuerdo`,`TipoCuentaCliente`,`CuentaCliente`,`CodigoGrupoClienteDescuentoMultilinea`,`CodigoGrupoArticulosDescuentoMultilinea`,"
                    . "`PorcentajeDescuentoMultilinea1`,`PorcentajeDescuentoMultilinea2`,`CodigoUnidadMedida`,`NombreUnidadMedida`,`CantidadDesde`,`CantidadHasta`,`FechaInicio`,"
                    . "`FechaFinal`,`Sitio`,`Almacen`";
            $sql = "DELETE FROM `acuerdoscomercialesdescuentomultilinea` WHERE `Almacen`='EMPTY'";
            $this->InsertInfoActiveAgency($sql);
            $sqlDel = "DELETE FROM `acuerdoscomercialesdescuentomultilinea` WHERE `Sitio`='EMPTY'";
            $this->InsertInfoActiveAgency($sqlDel);
            $columnsuni = "`IdAcuerdoComercial`";
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            for ($i = 0; $i < count($TradeAgreementsMultiLineDiscount); $i++) {
                if (trim($TradeAgreementsMultiLineDiscount[$i]->AgreementId) != "") {
                    foreach ($ValidateUnitCode as $value) {
                        if (strtolower($TradeAgreementsMultiLineDiscount[$i]->Unit) == strtolower($value['NombreUnidad'])) {
                            $UnitCode = $value['CodigoUnidad'];
                        }
                    }
                    if (!isset($UnitCode)) {
                        $UnitCode = '000';
                    }
                    $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $TradeAgreementsMultiLineDiscount[$i]->AgreementId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsMultiLineDiscount[$i]->Relation) . "',"
                            . "'" . $this->ValidateItem('ValidateAccountType', $TradeAgreementsMultiLineDiscount[$i]->AccountCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $TradeAgreementsMultiLineDiscount[$i]->CustCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsMultiLineDiscount[$i]->GroupCodePrice) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsMultiLineDiscount[$i]->ItemRelation) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsMultiLineDiscount[$i]->DiscountPercentMultiLine1) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsMultiLineDiscount[$i]->DiscountPercentMultiLine2) . "',"
                            . "'$UnitCode',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $TradeAgreementsMultiLineDiscount[$i]->UnitDescription) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsMultiLineDiscount[$i]->QuantityFrom) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $TradeAgreementsMultiLineDiscount[$i]->QuantityTo) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $TradeAgreementsMultiLineDiscount[$i]->FromDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $TradeAgreementsMultiLineDiscount[$i]->ToDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsMultiLineDiscount[$i]->Site) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $TradeAgreementsMultiLineDiscount[$i]->Location) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $TradeAgreementsMultiLineDiscount[$i]->AgreementId) . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $valuesuni2 = "`Sitio`";
            $columnsuni2 = "SELECT CodSitio FROM `sitios`) AND `Sitio` NOT IN ('EMPTY'";
            $this->DeleteAllActiveAgencies($TableName, $valuesuni2, $columnsuni2, 1);
            $valuesuni3 = "`CuentaCliente`";
            $columnsuni3 = "SELECT CuentaCliente FROM `cliente`) AND (CuentaCliente<>'Sin Dato'";
            $this->DeleteAllActiveAgencies($TableName, $valuesuni3, $columnsuni3, 1);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setTradeAgreementsMultiLineDiscount', $ex);
        }
    }

    public function setSalePriceTradeAgreements($SalePriceTradeAgreements) {
        try {
            $SalePriceTradeAgreements = json_decode($SalePriceTradeAgreements);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`acuerdoscomercialesprecioventa`";
            $ColumnsName = "`IdAcuerdoComercial`,`TipoAcuerdo`,`TipoCuentaCliente`,`CuentaCliente`,`CodigoGrupoPrecio`,`CodigoVariante`,`PrecioVenta`,`CodigoUnidadMedida`,"
                    . "`NombreUnidadMedida`,`CantidadDesde`,`CantidadHasta`,`FechaInicio`,`FechaTermina`,`Sitio`,`Almacen`";
            $columnsuni = "`IdAcuerdoComercial`";
            $sql = "DELETE FROM `acuerdoscomercialesprecioventa` WHERE `Almacen`='EMPTY'";
            $this->InsertInfoActiveAgency($sql);
            $sqlDel = "DELETE FROM `acuerdoscomercialesprecioventa` WHERE `Sitio`='EMPTY'";
            $this->InsertInfoActiveAgency($sqlDel);
            $valuesuni3 = "`CuentaCliente`";
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            for ($i = 0; $i < count($SalePriceTradeAgreements); $i++) {
                if (trim($SalePriceTradeAgreements[$i]->AgreementId) != "") {
                    foreach ($ValidateUnitCode as $value) {
                        if (strtolower($SalePriceTradeAgreements[$i]->UnitId) == strtolower($value['NombreUnidad'])) {
                            $UnitId = $value['CodigoUnidad'];
                        }
                        if (strtolower($SalePriceTradeAgreements[$i]->QuantityAmountFrom) == strtolower($value['NombreUnidad'])) {
                            $QuantityAmountFrom = $value['CodigoUnidad'];
                        }
                    }
                    if (!isset($UnitId)) {
                        $UnitId = '000';
                    }
                    if (!isset($QuantityAmountFrom)) {
                        $QuantityAmountFrom = '000';
                    }
                    $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $SalePriceTradeAgreements[$i]->AgreementId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $SalePriceTradeAgreements[$i]->Relation) . "',"
                            . "'" . $this->ValidateItem('ValidateAccountType', $SalePriceTradeAgreements[$i]->AccountCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalePriceTradeAgreements[$i]->CustCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $SalePriceTradeAgreements[$i]->GroupCodePrice) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $SalePriceTradeAgreements[$i]->RetailVariantId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $SalePriceTradeAgreements[$i]->Amount) . "',"
                            . "'$UnitId',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $SalePriceTradeAgreements[$i]->Symbol) . "',"
                            . "'$QuantityAmountFrom',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $SalePriceTradeAgreements[$i]->QuantityAmountTo) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $SalePriceTradeAgreements[$i]->FromDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $SalePriceTradeAgreements[$i]->ToDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $SalePriceTradeAgreements[$i]->InventSiteId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $SalePriceTradeAgreements[$i]->InventLocationId) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSinDato', $SalePriceTradeAgreements[$i]->AgreementId) . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $sql = "DELETE FROM `acuerdoscomercialesprecioventa` WHERE `Almacen` NOT IN (SELECT `CodigoAlmacen` FROM `almacenes`) AND Almacen<>'EMPTY'";
            $this->InsertInfoActiveAgency($sql);
            $sqlDel = "DELETE FROM `acuerdoscomercialesprecioventa` WHERE `Sitio` NOT IN (SELECT `CodSitio` FROM `sitios`) AND `Sitio`<>'EMPTY'";
            $this->InsertInfoActiveAgency($sqlDel);
            $valuesuni3 = "`CuentaCliente`";
            $columnsuni3 = "SELECT CuentaCliente FROM `cliente`) AND (CuentaCliente<>''";
            $this->DeleteAllActiveAgencies($TableName, $valuesuni3, $columnsuni3, 1);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalePriceTradeAgreements', $ex);
        }
    }

    public function setPortfolio($Portfolio, $group) {
        try {
            $Portfolio = json_decode($Portfolio);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`portafolio`";
            $ColumnsName = "`CodigoGrupoVentas`,`CodigoVariante`,`CodigoArticulo`,`NombreArticulo`,`CodigoCaracteristica1`,`CodigoCaracteristica2`,`CodigoTipo`,`CodigoMarca`,"
                    . "`CodigoGrupoCategoria`,`CodigoGrupoDescuentoLinea`,`CodigoGrupoDescuentoMultiLinea`,`CodigoGrupodeImpuestos`,`PorcentajedeIVA`,`ValorIMPOCONSUMO`,"
                    . "`CuentaProveedor`,`DctoPPNivel1`,`DctoPPNivel2`,`IdentificadorProductoNuevo`";
            $columnsuni = "`CodigoGrupoVentas`,`CodigoVariante`";
            for ($i = 0; $i < count($Portfolio->PortfolioId->ItemId); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Portfolio->GroupId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem8cero', $Portfolio->PortfolioId->ItemId[$i]->RetailVariantId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem8cero', $Portfolio->PortfolioId->ItemId[$i]->ItemId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Portfolio->PortfolioId->ItemId[$i]->ItemIdName) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Portfolio->PortfolioId->ItemId[$i]->StandardInventColorId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Portfolio->PortfolioId->ItemId[$i]->StandardInventStyleId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Portfolio->PortfolioId->ItemId[$i]->StandardInventSizeId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem4cero', $Portfolio->PortfolioId->ItemId[$i]->MarkCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItem4cero', $Portfolio->PortfolioId->ItemId[$i]->Category) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Portfolio->PortfolioId->ItemId[$i]->LineDisc) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Portfolio->PortfolioId->ItemId[$i]->MultiLineDisc) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Portfolio->PortfolioId->ItemId[$i]->TaxGroup) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Portfolio->PortfolioId->ItemId[$i]->IVA) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Portfolio->PortfolioId->ItemId[$i]->IMPOCONSUMO) . "',"
                        . "'" . $this->ValidateItem('ValidateItem6cero', $Portfolio->PortfolioId->ItemId[$i]->VendAccount) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Portfolio->PortfolioId->ItemId[$i]->PP1Days) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Portfolio->PortfolioId->ItemId[$i]->PP2Days) . "',"
                        . "0),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Portfolio->GroupId) .
                        $this->ValidateItem('ValidateItem8cero', $Portfolio->PortfolioId->ItemId[$i]->RetailVariantId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgenciesWithGroup($TableName, $ColumnsName, $values, $group);
                    $values = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgenciesWithGroup($TableName, $ColumnsName, $values, $group);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $where = "`CodigoGrupoVentas`";
            $this->DeleteAllActiveAgenciesWithGroup($TableName, $where, $columnsuni, $valuesuni, $group);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setPortfolio', $ex);
        }
    }

    public function setInventLocationPreSales($InventLocationPreSales, $Agency, $Site) {
        try {
            $InventLocationPreSales = json_decode($InventLocationPreSales);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`saldosinventariopreventa`";
            $ColumnsName = "`CodigoSitio`,`NombreSitio`,`CodigoAlmacen`,`CodigoVariante`,`CodigoArticulo`,`CodigoCaracteristica1`,`CodigoCaracteristica2`,`CodigoTipo`,"
                    . "`CodigoUnidadMedida`,`NombreUnidadMedida`,`Disponible`";
            $columnsuni = "`CodigoSitio`,`CodigoAlmacen`,`CodigoVariante`";
            $cont = 0;
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            if (is_object($InventLocationPreSales)) {
                if ($InventLocationPreSales->CodeItemId != null) {
                    if (is_object($InventLocationPreSales->CodeItemId->RetailVariant)) {
                        foreach ($ValidateUnitCode as $value) {
                            if (strtolower($InventLocationPreSales->CodeItemId->RetailVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                $UnitId = $value['CodigoUnidad'];
                            }
                        }
                        if (!isset($UnitId)) {
                            $UnitId = '000';
                        }
                        $values.="('" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventSiteId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->Name) . "',"
                                . "'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventLocation) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->RetailVariantId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->ItemId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->InventColorId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->InventStyleId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->InventSizeId) . "',"
                                . "'$UnitId',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->Description) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InventLocationPreSales->CodeItemId->RetailVariant->AmoutBalance) . "')";
                        $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventSiteId) .
                                $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventLocation) .
                                $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant->RetailVariantId) . "',";
                        $cont2++;
                        $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                        $values = "";
                    } else {
                        for ($j = 0; $j < count($InventLocationPreSales->CodeItemId->RetailVariant); $j++) {
                            foreach ($ValidateUnitCode as $value) {
                                if (strtolower($InventLocationPreSales->CodeItemId->RetailVariant[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                    $UnitId = $value['CodigoUnidad'];
                                }
                            }
                            if (!isset($UnitId)) {
                                $UnitId = '000';
                            }
                            $values.="('" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventSiteId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->Name) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventLocation) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->RetailVariantId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->ItemId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->InventColorId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->InventStyleId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->InventSizeId) . "',"
                                    . "'$UnitId',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->Description) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->AmoutBalance) . "'),";
                            $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventSiteId) .
                                    $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales->InventLocation) .
                                    $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales->CodeItemId->RetailVariant[$j]->RetailVariantId) . "',";
                            $cont++;
                            $cont2++;
                            if ($cont == 2000) {
                                $values = substr($values, 0, -1);
                                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                $values = "";
                                $cont = 0;
                            }
                        }
                    }
                }
            } else {
                for ($i = 0; $i < count($InventLocationPreSales); $i++) {
                    if ($InventLocationPreSales[$i]->CodeItemId != null) {
                        if (is_object($InventLocationPreSales[$i]->CodeItemId->RetailVariant)) {
                            foreach ($ValidateUnitCode as $value) {
                                if (strtolower($InventLocationPreSales[$i]->CodeItemId->RetailVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                    $UnitId = $value['CodigoUnidad'];
                                }
                            }
                            if (!isset($UnitId)) {
                                $UnitId = '000';
                            }
                            $values.="('" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventSiteId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->Name) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventLocation) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->RetailVariantId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->ItemId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->InventColorId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->InventStyleId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->InventSizeId) . "',"
                                    . "'$UnitId',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->Description) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->AmoutBalance) . "'),";
                            $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventSiteId) .
                                    $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventLocation) .
                                    $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant->RetailVariantId) . "',";
                            $cont++;
                            $cont2++;
                            if ($cont == 2000) {
                                $values = substr($values, 0, -1);
                                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                $values = "";
                                $cont = 0;
                            }
                        } else {
                            for ($j = 0; $j < count($InventLocationPreSales[$i]->CodeItemId->RetailVariant); $j++) {
                                foreach ($ValidateUnitCode as $value) {
                                    if (strtolower($InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                        $UnitId = $value['CodigoUnidad'];
                                    }
                                }
                                if (!isset($UnitId)) {
                                    $UnitId = '000';
                                }
                                $values.="('" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventSiteId) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->Name) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventLocation) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->RetailVariantId) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->ItemId) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->InventColorId) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->InventStyleId) . "',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->InventSizeId) . "',"
                                        . "'$UnitId',"
                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->Description) . "',"
                                        . "'" . $this->ValidateItem('ValidateItem1cero', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->AmoutBalance) . "'),";
                                $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventSiteId) .
                                        $this->ValidateItem('ValidateItemEmpty', $InventLocationPreSales[$i]->InventLocation) .
                                        $this->ValidateItem('ValidateItemSinDato', $InventLocationPreSales[$i]->CodeItemId->RetailVariant[$j]->RetailVariantId) . "',";
                                $cont++;
                                $cont2++;
                                if ($cont == 2000) {
                                    $values = substr($values, 0, -1);
                                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                    $values = "";
                                    $cont = 0;
                                }
                            }
                        }
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeletebyAgencyAndSite($TableName, $columnsuni, $valuesuni, $Agency, $Site);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setInventLocationPreSales', $ex);
        }
    }

    public function setConPreSalesInvent($ConPreSalesInvent, $Agency, $site) {
        try {
            $ConPreSalesInvent = json_decode($ConPreSalesInvent);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`saldosinventarioautoventayconsignacion`";
            $ColumnsName = "`CodigoSitio`,`NombreSitio`,`CodigoAlmacen`,`CodigoUbicacion`,`CodigoVariante`,`CodigoArticulo`,`Caracteristica1`,`Caracteristica2`,"
                    . "`LoteArticulo`,`CodigoTipo`,`CodigoUnidadMedida`,`NombreUnidadMedida`,`Disponible`,`FechaVencimiento`";
            $columnsuni = "`CodigoSitio`,`CodigoAlmacen`,`CodigoUbicacion`,`CodigoVariante`";
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            if (is_object($ConPreSalesInvent->InventLocationId)) {
                if (isset($ConPreSalesInvent->InventLocationId->WMSLocation)) {
                    if (is_object($ConPreSalesInvent->InventLocationId->WMSLocation)) {
                        if (isset($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant)) {
                            if (is_object($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant)) {
                                if (($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant != null) && ($this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->InventBatchId) != "")) {
                                    foreach ($ValidateUnitCode as $value) {
                                        if (strtolower($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                            $UnitId = $value['CodigoUnidad'];
                                        }
                                    }
                                    if (!isset($UnitId)) {
                                        $UnitId = '000';
                                    }
                                    $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) . "',"
                                            . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->WMSLocationId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->RetailVariantId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->ItemId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->InventColorId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->InventStyleId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->InventBatchId) . "',"
                                            . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->InventSizeId) . "',"
                                            . "'$UnitId',"
                                            . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->Description) . "',"
                                            . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->qty) . "',"
                                            . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->DueDate) . "'),";
                                    $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                            $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) .
                                            $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->WMSLocationId) .
                                            $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant->RetailVariantId) . "',";
                                    $cont++;
                                    $cont2++;
                                    $values = substr($values, 0, -1);
                                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                    $values = "";
                                }
                            } else {
                                for ($i = 0; $i < count($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant); $i++) {
                                    if (($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i] != null) && ($this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->InventBatchId) != "")) {
                                        foreach ($ValidateUnitCode as $value) {
                                            if (strtolower($ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->UnitId) == strtolower($value['NombreUnidad'])) {
                                                $UnitId = $value['CodigoUnidad'];
                                            }
                                        }
                                        if (!isset($UnitId)) {
                                            $UnitId = '000';
                                        }
                                        $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->WMSLocationId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->RetailVariantId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->ItemId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->InventColorId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->InventStyleId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->InventBatchId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->InventSizeId) . "',"
                                                . "'$UnitId',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->Description) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->qty) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->DueDate) . "'),";
                                        $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) .
                                                $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->WMSLocationId) .
                                                $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation->RetailVariant[$i]->RetailVariantId) . "'";
                                        $cont++;
                                        $cont2++;
                                        if ($cont == 2000) {
                                            $values = substr($values, 0, -1);
                                            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                            $values = "";
                                            $cont = 0;
                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        for ($i = 0; $i < count($ConPreSalesInvent->InventLocationId->WMSLocation); $i++) {
                            if (isset($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant)) {
                                if (is_object($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant)) {
                                    if ($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->InventBatchId != "") {
                                        foreach ($ValidateUnitCode as $value) {
                                            if (strtolower($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                                $UnitId = $value['CodigoUnidad'];
                                            }
                                        }
                                        if (!isset($UnitId)) {
                                            $UnitId = '000';
                                        }
                                        $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->WMSLocationId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->RetailVariantId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->ItemId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->InventColorId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->InventStyleId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->InventBatchId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->InventSizeId) . "',"
                                                . "'$UnitId',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->Description) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->qty) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->DueDate) . "'),";
                                        $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) .
                                                $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->WMSLocationId) .
                                                $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant->RetailVariantId) . "',";
                                        $cont++;
                                        $cont2++;
                                        if ($cont == 2000) {
                                            $values = substr($values, 0, -1);
                                            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                            $values = "";
                                            $cont = 0;
                                        }
                                    }
                                } else {
                                    if (isset($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant)) {
                                        for ($j = 0; $j < count($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant); $j++) {
                                            if ($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->InventBatchId != "") {
                                                foreach ($ValidateUnitCode as $value) {
                                                    if (strtolower($ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                                        $UnitId = $value['CodigoUnidad'];
                                                    }
                                                }
                                                if (!isset($UnitId)) {
                                                    $UnitId = '000';
                                                }
                                                $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->WMSLocationId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->RetailVariantId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->ItemId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->InventColorId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->InventStyleId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->InventBatchId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->InventSizeId) . "',"
                                                        . "'$UnitId',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->Description) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->qty) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->DueDate) . "'),";
                                                $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                        $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId->InventLocation) .
                                                        $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->WMSLocationId) .
                                                        $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId->WMSLocation[$i]->RetailVariant[$j]->RetailVariantId) . "',";
                                                $cont++;
                                                $cont2++;
                                                if ($cont == 2000) {
                                                    $values = substr($values, 0, -1);
                                                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                                    $values = "";
                                                    $cont = 0;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                for ($i = 0; $i < count($ConPreSalesInvent->InventLocationId); $i++) {
                    if (isset($ConPreSalesInvent->InventLocationId[$i]->WMSLocation)) {
                        if (is_object($ConPreSalesInvent->InventLocationId[$i]->WMSLocation)) {
                            if (isset($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant)) {
                                if (is_object($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant)) {
                                    if (($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant != null) && ($this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->InventBatchId) != "")) {
                                        foreach ($ValidateUnitCode as $value) {
                                            if (strtolower($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                                $UnitId = $value['CodigoUnidad'];
                                            }
                                        }
                                        if (!isset($UnitId)) {
                                            $UnitId = '000';
                                        }
                                        $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->WMSLocationId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->RetailVariantId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->ItemId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->InventColorId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->InventStyleId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->InventBatchId) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->InventSizeId) . "',"
                                                . "'$UnitId',"
                                                . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->Description) . "',"
                                                . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->qty) . "',"
                                                . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->DueDate) . "'),";
                                        $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) .
                                                $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->WMSLocationId) .
                                                $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant->RetailVariantId) . "',";
                                        $cont++;
                                        $cont2++;
                                        $values = substr($values, 0, -1);
                                        $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                        $values = "";
                                    }
                                } else {
                                    for ($j = 0; $j < count($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant); $j++) {
                                        if ($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->InventBatchId != "") {
                                            foreach ($ValidateUnitCode as $value) {
                                                if (strtolower($ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                                    $UnitId = $value['CodigoUnidad'];
                                                }
                                            }
                                            if (!isset($UnitId)) {
                                                $UnitId = '000';
                                            }
                                            $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->WMSLocationId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->RetailVariantId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->ItemId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->InventColorId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->InventStyleId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->InventBatchId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->InventSizeId) . "',"
                                                    . "'$UnitId',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->Description) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->qty) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->DueDate) . "'),";
                                            $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                    $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) .
                                                    $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->WMSLocationId) .
                                                    $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation->RetailVariant[$j]->RetailVariantId) . "',";
                                            $cont++;
                                            $cont2++;
                                            $values = substr($values, 0, -1);
                                            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                            $values = "";
                                        }
                                    }
                                }
                            }
                        } else {
                            for ($j = 0; $j < count($ConPreSalesInvent->InventLocationId[$i]->WMSLocation); $j++) {
                                if (isset($ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant)) {
                                    if (is_object($ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant)) {
                                        if ($this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->InventBatchId) != "") {
                                            foreach ($ValidateUnitCode as $value) {
                                                if (strtolower($ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                                    $UnitId = $value['CodigoUnidad'];
                                                }
                                            }
                                            if (!isset($UnitId)) {
                                                $UnitId = '000';
                                            }
                                            $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->WMSLocationId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->RetailVariantId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->ItemId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->InventColorId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->InventStyleId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->InventBatchId) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->InventSizeId) . "',"
                                                    . "'$UnitId',"
                                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->Description) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->qty) . "',"
                                                    . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->DueDate) . "'),";
                                            $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                    $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) .
                                                    $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->WMSLocationId) .
                                                    $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant->RetailVariantId) . "',";
                                            $cont++;
                                            $cont2++;
                                            if ($cont == 2000) {
                                                $values = substr($values, 0, -1);
                                                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                                $values = "";
                                                $cont = 0;
                                            }
                                        }
                                    } else {
                                        for ($k = 0; $k < count($ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant); $k++) {
                                            if ($ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->InventBatchId != "") {
                                                foreach ($ValidateUnitCode as $value) {
                                                    if (strtolower($ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->UnitId) == strtolower($value['NombreUnidad'])) {
                                                        $UnitId = $value['CodigoUnidad'];
                                                    }
                                                }
                                                if (!isset($UnitId)) {
                                                    $UnitId = '000';
                                                }
                                                $values.="('" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->Name) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->WMSLocationId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->RetailVariantId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->ItemId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->InventColorId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->InventStyleId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->InventBatchId) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem2cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->InventSizeId) . "',"
                                                        . "'$UnitId',"
                                                        . "'" . $this->ValidateItem('ValidateItemSinDato', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->Description) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItem1cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->qty) . "',"
                                                        . "'" . $this->ValidateItem('ValidateItemFecha', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->DueDate) . "'),";
                                                $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventSiteId) .
                                                        $this->ValidateItem('ValidateItemEmpty', $ConPreSalesInvent->InventLocationId[$i]->InventLocation) .
                                                        $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->WMSLocationId) .
                                                        $this->ValidateItem('ValidateItem5cero', $ConPreSalesInvent->InventLocationId[$i]->WMSLocation[$j]->RetailVariant[$k]->RetailVariantId) . "',";
                                                $cont++;
                                                $cont2++;
                                                if ($cont == 2000) {
                                                    $values = substr($values, 0, -1);
                                                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                                                    $values = "";
                                                    $cont = 0;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeletebyAgencyAndSite($TableName, $columnsuni, $valuesuni, $Agency, $Site);
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setConPreSalesInvent', $ex);
        }
    }

    public function setInactiveVariants($InactiveVariants, $Agency, $Site) {
        try {
            $InactiveVariants = json_decode($InactiveVariants);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`variantesinactivas`";
            $ColumnsName = "`CodigoSitio`,`CodigoAlmacen`,`CodigoArticulo`,`CodigoVariante`,`NombreVariante`";
            $columnsuni = "`CodigoSitio`,`CodigoArticulo`,`CodigoVariante`";
            if (is_object($InactiveVariants->Detail)) {
                $values.="('" . $this->ValidateItem('ValidateItemEmpty', $InactiveVariants->InventSiteId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemEmpty', $InactiveVariants->InventLocationId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail->RetailVariant->ItemId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail->RetailVariant->RetailVariantId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail->RetailVariant->RetailVariantName) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $InactiveVariants->InventSiteId) .
                        $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail->RetailVariant->ItemId) .
                        $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail->RetailVariant->RetailVariantId) . "',";
                $cont2++;
            } else {
                for ($i = 0; $i < count($InactiveVariants->Detail); $i++) {
                    $values.="('" . $this->ValidateItem('ValidateItemEmpty', $InactiveVariants->InventSiteId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemEmpty', $InactiveVariants->InventLocationId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail[$i]->RetailVariant->ItemId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail[$i]->RetailVariant->RetailVariantId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail[$i]->RetailVariant->RetailVariantName) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemEmpty', $InactiveVariants->InventSiteId) .
                            $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail[$i]->RetailVariant->ItemId) .
                            $this->ValidateItem('ValidateItem3cero', $InactiveVariants->Detail[$i]->RetailVariant->RetailVariantId) . "',";
                    $cont++;
                    $cont2++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        if ($Site == "EMPTY") {
                            $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                        } else {
                            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                        }
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                if ($Site == "EMPTY") {
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                } else {
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                }
            }
            if ($Site != "EMPTY") {
                $valuesuni = substr($valuesuni, 0, -1);
                $this->DeletebyAgencyAndSite($TableName, $columnsuni, $valuesuni, $Agency, $Site);
            }
            return $cont2;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setInactiveVariants', $ex);
        }
    }

    public function setCreditCapacity($CreditCapacity, $Agency, $SaleZone) {
        try {
            $CreditCapacity = json_decode($CreditCapacity);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`cupocredito`";
            $ColumnsName = "`CuentaCliente`,`Identificacion`,`NombreCliente`,`NombreBusqueda`,`Estado`,`ZonaVenta`,`ValorCupo`,`ValorCupoTemporal`,`SaldoCupo`";
            $columnsuni = "`CuentaCliente`,`Identificacion`,`ZonaVenta`";
            if (is_object($CreditCapacity)) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->IdentificationNumber) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->Namefind) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->Block) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->SalesZone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->CreditMax) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->CreditAddTmp) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->srf_creditMax) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity->AccountNum) .
                        $this->ValidateItem('ValidateItem3cero', $CreditCapacity->IdentificationNumber) .
                        $this->ValidateItem('ValidateItem3cero', $CreditCapacity->SalesZone) . "',";
                $i = 1;
            } else {
                for ($i = 0; $i < count($CreditCapacity); $i++) {
                    $values.="('" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->IdentificationNumber) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->Name) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->Namefind) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->Block) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->SalesZone) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->CreditMax) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->CreditAddTmp) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->srf_creditMax) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->AccountNum) .
                            $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->IdentificationNumber) .
                            $this->ValidateItem('ValidateItem3cero', $CreditCapacity[$i]->SalesZone) . "',";
                    $cont++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                        $values = "";
                        $cont = 0;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $where = "`ZonaVenta`=" . $SaleZone;
            $this->DeletebyAgencyWithWhere($TableName, $columnsuni, $valuesuni, $Agency, $where, 3);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setCreditCapacity', $ex);
        }
    }

    public function setInvoiceBalance($InvoiceBalance, $Agency, $SaleZone) {
        try {
            $InvoiceBalance = json_decode($InvoiceBalance);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $TableName = "`facturasaldo`";
            $ColumnsName = "`NumeroFactura`,`CuentaCliente`,`FechaFactura`,`ValorNetoFactura`,`CodigoCondicionPago`,`DtoProntoPagoNivel1`,`FechaDtoProntoPagoNivel1`,"
                    . "`DtoProntoPagoNivel2`,`FechaDtoProntoPagoNivel2`,`SaldoFactura`,`CodigoZonaVentas`,`CedulaAsesorComercial`,`FechaVencimientoFactura`";
            $columnsuni = "`NumeroFactura`";
            $details = "";
            $valuesunid = "";
            $contd = 0;
            $TableNameD = "`facturasaldodetalle`";
            $ColumnsNameD = "`NumeroFactura`,`CodigoVariante`,`CodigoArticulo`,`Caracteristica1`,`Caracteristica2`,`CodigoTipo`,`CodigoUnidadMedida`,`NombreUnidadMedida`,"
                    . "`ValorNetoArticulo`,`CuentaProveedor`,`DescuentoPPNivel1`,`DescuentoPPNivel2`,`CantidadFacturada`,`Almacen`";
            $columnsunid = "`NumeroFactura`,`CodigoVariante`";
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            if (is_object($InvoiceBalance)) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->InvoiceId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance->TransDate) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Amount) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->PaymSpec) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->DiscLevel1) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance->DateDiscLevel1) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->DiscLevel2) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance->DateDiscLevel2) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->Balance) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->SalesAreaCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->AdvisorCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance->DueDate) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->InvoiceId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                    $values = "";
                    $cont = 0;
                }
                if (is_object($InvoiceBalance->Details->DetailsVariant)) {
                    foreach ($ValidateUnitCode as $value) {
                        if (strtolower($InvoiceBalance->Details->DetailsVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                            $UnitId = $value['CodigoUnidad'];
                        }
                    }
                    if (!isset($UnitId)) {
                        $UnitId = '000';
                    }
                    $details.="('" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->InvoiceId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance->Details->DetailsVariant->RetailVariantId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance->Details->DetailsVariant->ItemId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant->Char1) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant->Char2) . "',"
                            . "'" . $this->ValidateItem('ValidateItem2cero', $InvoiceBalance->Details->DetailsVariant->Type) . "',"
                            . "'$UnitId',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant->UnitName) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant->ItemValue) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->Details->DetailsVariant->VendAccount) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant->DiscLevel1) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant->DiscLevel2) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant->Quantity) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant->LocationId) . "'),";
                    $contd++;
                    if ($contd == 2000) {
                        $details = substr($details, 0, -1);
                        $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                        $details = "";
                        $contd = 0;
                    }
                } else {
                    for ($j = 0; $j < count($InvoiceBalance->Details->DetailsVariant); $j++) {
                        foreach ($ValidateUnitCode as $value) {
                            if (strtolower($InvoiceBalance->Details->DetailsVariant[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                $UnitId = $value['CodigoUnidad'];
                            }
                        }
                        if (!isset($UnitId)) {
                            $UnitId = '000';
                        }
                        $details.="('" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->InvoiceId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance->Details->DetailsVariant[$j]->RetailVariantId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance->Details->DetailsVariant[$j]->ItemId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant[$j]->Char1) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant[$j]->Char2) . "',"
                                . "'" . $this->ValidateItem('ValidateItem2cero', $InvoiceBalance->Details->DetailsVariant[$j]->Type) . "',"
                                . "'$UnitId',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant[$j]->UnitName) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance->Details->DetailsVariant[$j]->ItemValue) . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance->Details->DetailsVariant[$j]->VendAccount) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant[$j]->DiscLevel1) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant[$j]->DiscLevel2) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant[$j]->Quantity) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance->Details->DetailsVariant[$j]->LocationId) . "'),";
                        $contd++;
                        if ($contd == 2000) {
                            $details = substr($details, 0, -1);
                            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                            $details = "";
                            $contd = 0;
                        }
                    }
                }
            } else {
                for ($i = 0; $i < count($InvoiceBalance); $i++) {
                    $values.="('" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->InvoiceId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance[$i]->TransDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Amount) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->PaymSpec) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->DiscLevel1) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance[$i]->DateDiscLevel1) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->DiscLevel2) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance[$i]->DateDiscLevel2) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->Balance) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->SalesAreaCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->AdvisorCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceBalance[$i]->DueDate) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->InvoiceId) . "',";
                    $cont++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                        $values = "";
                        $cont = 0;
                    }
                    if (is_object($InvoiceBalance[$i]->Details->DetailsVariant)) {
                        foreach ($ValidateUnitCode as $value) {
                            if (strtolower($InvoiceBalance[$i]->Details->DetailsVariant->UnitId) == strtolower($value['NombreUnidad'])) {
                                $UnitId = $value['CodigoUnidad'];
                            }
                        }
                        if (!isset($UnitId)) {
                            $UnitId = '000';
                        }
                        $details.="('" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->InvoiceId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance[$i]->Details->DetailsVariant->RetailVariantId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance[$i]->Details->DetailsVariant->ItemId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant->Char1) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant->Char2) . "',"
                                . "'" . $this->ValidateItem('ValidateItem2cero', $InvoiceBalance[$i]->Details->DetailsVariant->Type) . "',"
                                . "'$UnitId',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant->UnitName) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant->ItemValue) . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->Details->DetailsVariant->VendAccount) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant->DiscLevel1) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant->DiscLevel2) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant->Quantity) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant->LocationId) . "'),";
                        $contd++;
                        if ($contd == 2000) {
                            $details = substr($details, 0, -1);
                            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                            $details = "";
                            $contd = 0;
                        }
                    } else {
                        for ($j = 0; $j < count($InvoiceBalance[$i]->Details->DetailsVariant); $j++) {
                            foreach ($ValidateUnitCode as $value) {
                                if (strtolower($InvoiceBalance[$i]->Details->DetailsVariant[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                    $UnitId = $value['CodigoUnidad'];
                                }
                            }
                            if (!isset($UnitId)) {
                                $UnitId = '000';
                            }
                            $details.="('" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->InvoiceId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->RetailVariantId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->ItemId) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->Char1) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->Char2) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem2cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->Type) . "',"
                                    . "'$UnitId',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->UnitName) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->ItemValue) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->VendAccount) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->DiscLevel1) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->DiscLevel2) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->Quantity) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceBalance[$i]->Details->DetailsVariant[$j]->LocationId) . "'),";
                            $contd++;
                            if ($contd == 2000) {
                                $details = substr($details, 0, -1);
                                $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                                $details = "";
                                $contd = 0;
                            }
                        }
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            }
            if ($details != "") {
                $details = substr($details, 0, -1);
                $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $where = "`CodigoZonaVentas`=" . $SaleZone;
            $this->DeletebyAgencyWithWhere($TableName, $columnsuni, $valuesuni, $Agency, $where, 1);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setInvoiceBalance', $ex);
        }
    }

    public function setInvoiceTransactions($InvoiceTransactions, $Agency, $SaleZone) {
        try {
            $InvoiceTransactions = json_decode($InvoiceTransactions);
            $values = "";
            $valuesuni = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`facturastransacciones`";
            $ColumnsName = "`CodZonaVentas`,`NumeroFactura`,`CuentaCliente`,`FechaFactura`,`Saldo`";
            $columnsuni = "`NumeroFactura`";
            $details = "";
            $contd = 0;
            $contd2 = 0;
            $TableNameD = "`facturastransaccionesdetalle`";
            $ColumnsNameD = "`IdFacturaTransacciones`,`CodigoDocumento`,`NombreDocumento`,`NumeroDocumento`,`CodigoConcepto`,`NombreConcepto`,`ValorDocumento`";
            if (is_object($InvoiceTransactions)) {
                $values.="('$SaleZone','" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions->InvoiceId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceTransactions->TransDate) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceTransactions->Balance) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions->InvoiceId) . "',";
                $cont++;
                if (is_object($InvoiceTransactions->Details->custTransId)) {
                    $details.="('" . $InvoiceTransactions->InvoiceId . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions->Details->custTransId->DocumentCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions->Details->custTransId->DocumentName) . "',"
                            . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions->Details->custTransId->DocumentNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions->Details->custTransId->ConceptCode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions->Details->custTransId->ConceptName) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceTransactions->Details->custTransId->DocumentValue) . "'),";
                    $countd++;
                } else {
                    for ($j = 0; $j < count($InvoiceTransactions->Details->custTransId); $j++) {
                        $details.="('" . $InvoiceTransactions->InvoiceId . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions->Details->custTransId[$j]->DocumentCode) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions->Details->custTransId[$j]->DocumentName) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions->Details->custTransId[$j]->DocumentNum) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions->Details->custTransId[$j]->ConceptCode) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions->Details->custTransId[$j]->ConceptName) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceTransactions->Details->custTransId[$j]->DocumentValue) . "'),";
                        $countd++;
                        if ($contd == 2000) {
                            $details = substr($details, 0, -1);
                            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                            $details = "";
                            $contd = 0;
                        }
                    }
                }
            } else {
                for ($i = 0; $i < count($InvoiceTransactions); $i++) {
                    $values.="('$SaleZone','" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions[$i]->InvoiceId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItemFecha', $InvoiceTransactions[$i]->TransDate) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceTransactions[$i]->Balance) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions[$i]->InvoiceId) . "',";
                    $cont++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                        $values = "";
                        $cont = 0;
                    }
                    if (is_object($InvoiceTransactions[$i]->Details->custTransId)) {
                        $details.="('" . $this->ValidateItem('ValidateItemSpecChar', $InvoiceTransactions[$i]->InvoiceId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions[$i]->Details->custTransId->DocumentCode) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions[$i]->Details->custTransId->DocumentName) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions[$i]->Details->custTransId->DocumentNum) . "',"
                                . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions[$i]->Details->custTransId->ConceptCode) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions[$i]->Details->custTransId->ConceptName) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceTransactions[$i]->Details->custTransId->DocumentValue) . "'),";
                        $countd++;
                        if ($contd == 2000) {
                            $details = substr($details, 0, -1);
                            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                            $details = "";
                            $contd = 0;
                        }
                    } else {
                        for ($j = 0; $j < count($InvoiceTransactions[$i]->Details->custTransId); $j++) {
                            $details.="('" . $InvoiceTransactions[$i]->InvoiceId . "',"
                                    . "'" . $this->ValidateItem('ValidateItem3cero', $InvoiceTransactions[$i]->Details->custTransId[$j]->DocumentCode) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions[$i]->Details->custTransId[$j]->DocumentName) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions[$i]->Details->custTransId[$j]->DocumentNum) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem7cero', $InvoiceTransactions[$i]->Details->custTransId[$j]->ConceptCode) . "',"
                                    . "'" . $this->ValidateItem('ValidateItemSinDato', $InvoiceTransactions[$i]->Details->custTransId[$j]->ConceptName) . "',"
                                    . "'" . $this->ValidateItem('ValidateItem1cero', $InvoiceTransactions[$i]->Details->custTransId[$j]->DocumentValue) . "'),";
                            $countd++;
                            if ($contd == 2000) {
                                $details = substr($details, 0, -1);
                                $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
                                $details = "";
                                $contd = 0;
                            }
                        }
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            }
            if ($details != "") {
                $details = substr($details, 0, -1);
                $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $where = "`CodZonaVentas`=" . $SaleZone;
            $this->DeletebyAgencyWithWhere($TableName, $columnsuni, $valuesuni, $Agency, $where, 1);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setInvoiceTransactions', $ex);
        }
    }

    public function setOutstandingInvoice($OutstandingInvoice, $Agency, $SaleZone) {
        try {
            $OutstandingInvoice = json_decode($OutstandingInvoice);
            $values = "";
            $valuesuni = "";
            $TableName = "`pendientesporfacturar`";
            $ColumnsName = "`SalesZona`,`AdvisorName`,`Date`,`AccountNum`,`CustName`,`ReasonPendingInovice`,`Invoice`,`VariantCode`,`VariantName`,`UniTid`,`Type`,"
                    . "`CodKit`,`OrderedQty`,`OutstandingQty`,`SalesId`";
            $columnsuni = "`SalesZona`,`AccountNum`,`Invoice`,`VariantCode`,`OrderedQty`,`SalesId`";
            $cont = 0;
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            if (is_object($OutstandingInvoice)) {
                foreach ($ValidateUnitCode as $value) {
                    if (strtolower($OutstandingInvoice->UnitId) == strtolower($value['NombreUnidad'])) {
                        $UnitId = $value['CodigoUnidad'];
                    }
                }
                if (!isset($UnitId)) {
                    $UnitId = '000';
                }
                $newDate = date("Y-m-d", strtotime($this->ValidateItem('ValidateItemFecha', $OutstandingInvoice->Date)));
                $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->SalesZone) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->AdvisorName) . "',"
                        . "'$newDate',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->CustName) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->ReasonPendingInvoice) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->Invoice) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->Variantcode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->VariantName) . "',"
                        . "'$UnitId',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->Type) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->CodKit) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->OrderedQty) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->OutstandingQty) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->SalesId) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->SalesZone) .
                        $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->AccountNum) .
                        $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->Invoice) .
                        $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->Variantcode) .
                        $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->OrderedQty) .
                        $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice->SalesId) . "',";
                $i = 1;
            } else {
                for ($i = 0; $i < count($OutstandingInvoice); $i++) {
                    $newDate = date("Y-m-d", strtotime($this->ValidateItem('ValidateItemFecha', $OutstandingInvoice[$i]->Date)));
                    $values.="('" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->SalesZone) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->AdvisorName) . "',"
                            . "'$newDate',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->CustName) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->ReasonPendingInvoice) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->Invoice) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->Variantcode) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->VariantName) . "',"
                            . "'$UnitId',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->Type) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->CodKit) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->OrderedQty) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->OutstandingQty) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->SalesId) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->SalesZone) .
                            $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->AccountNum) .
                            $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->Invoice) .
                            $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->Variantcode) .
                            $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->OrderedQty) .
                            $this->ValidateItem('ValidateItemSpecChar', $OutstandingInvoice[$i]->SalesId) . "',";
                    $cont++;
                    if ($cont == 2000) {
                        $values = substr($values, 0, -1);
                        $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                        $values = "";
                        $cont = 0;
                    }
                }
                if ($values != "") {
                    $values = substr($values, 0, -1);
                    $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
                }
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $where = "`SalesZona`='$SaleZone'";
            $this->DeletebyAgencyWithWhere($TableName, $columnsuni, $valuesuni, $Agency, $where, 6);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setOutstandingInvoice', $ex);
        }
    }

    public function setSalesBudget($SalesBudget, $Agency, $SaleZone) {
        try {
            $AgencyGlobal = '000';
            $SalesBudget = json_decode($SalesBudget);
            $values = "";
            $valuesuni = "";
            $valuesunid = "";
            $valuesunid2 = "";
            $cont = 0;
            $TableName = "`presupuestoventas`";
            $ColumnsName = "`CodZonaVentas`,`Agencia`,`Year`,`Month`,`CustQuota`,`EffectivenessQuota`";
            $columnsuni = "`CodZonaVentas`,`Agencia`";
            $where = '`CodZonaVentas`';
            $details = "";
            $contd = 0;
            $TableNameD = "`presupuestoventascuotafabricante`";
            $ColumnsNameD = "`CodZonaVentas`,`Agencia`,`Year`,`Month`,`Code`,`QuotaPesos`,`BoxQuota`,`QuotaPesosDup`,`BoxQuotaDup`";
            $columnsunid = "`CodZonaVentas`,`Agencia`,`Code`,`QuotaPesos`";
            $details2 = "";
            $contd2 = 0;
            $TableNameD2 = "`presupuestoventasprofundidad`";
            $ColumnsNameD2 = "`CodZonaVentas`,`Agencia`,`Year`,`Month`,`Type`,`Name`,`CustomerQuota`,`profoundness`";
            $columnsunid2 = "`CodZonaVentas`,`Agencia`,`Name`";
            if (is_object($SalesBudget)) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $SalesBudget->NameSeller) . "',"
                        . "'" . $this->ValidateItem('ValidateItem4cero', $SalesBudget->Year) . "',"
                        . "'" . $this->ValidateItem('ValidateItem2cero', $SalesBudget->Month) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->CustQuota) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->EffectivenessQuota) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) .
                        $this->ValidateItem('ValidateItemSinDato', $SalesBudget->NameSeller) . "',";
                $cont++;
                if (is_object($SalesBudget->SalesBudgetDetail->Detail1)) {
                    $details.="('" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . "',"
                            . "'" . $Agency . "',"
                            . "'" . $this->ValidateItem('ValidateItem4cero', $SalesBudget->Year) . "',"
                            . "'" . $this->ValidateItem('ValidateItem2cero', $SalesBudget->Month) . "',"
                            . "'" . $this->ValidateItem('ValidateToUpper', $SalesBudget->SalesBudgetDetail->Detail1->Code) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1->QuotaPesos) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1->BoxQuota) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1->QuotaPesosDup) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1->BoxQuotaDup) . "'),";
                    $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . $Agency .
                            $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesBudgetDetail->Detail1->Code) .
                            $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1->QuotaPesos) . "',";
                    $contd++;
                } else {
                    for ($i = 0; $i < count($SalesBudget->SalesBudgetDetail->Detail1); $i++) {
                        $details.="('" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . "',"
                                . "'$Agency',"
                                . "'" . $this->ValidateItem('ValidateItem4cero', $SalesBudget->Year) . "',"
                                . "'" . $this->ValidateItem('ValidateItem2cero', $SalesBudget->Month) . "',"
                                . "'" . $this->ValidateItem('ValidateToUpper', $SalesBudget->SalesBudgetDetail->Detail1[$i]->Code) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1[$i]->QuotaPesos) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1[$i]->BoxQuota) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1[$i]->QuotaPesosDup) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1[$i]->BoxQuotaDup) . "'),";
                        $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . $Agency .
                                $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesBudgetDetail->Detail1[$i]->Code) .
                                $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail1[$i]->QuotaPesos) . "',";
                        $contd++;
                        if ($contd == 2000) {
                            $details = substr($details, 0, -1);
                            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $AgencyGlobal);
                            $details = "";
                            $contd = 0;
                        }
                    }
                }
                if (is_object($SalesBudget->SalesBudgetDetail->Detail2)) {
                    $details2.="('" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . "',"
                            . "'$Agency',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->Year) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->Month) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2->Type) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2->Name) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2->CustomerQuota) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2->profoundness) . "'),";
                    $valuesunid2.="'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . $Agency .
                            $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2->Name) . "',";
                    $contd2++;
                    $contd++;
                } else {
                    for ($i = 0; $i < count($SalesBudget->SalesBudgetDetail->Detail2); $i++) {
                        $details2.="('" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . "',"
                                . "'$Agency',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->Year) . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->Month) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2[$i]->Type) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2[$i]->Name) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2[$i]->CustomerQuota) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2[$i]->profoundness) . "'),";
                        $valuesunid2.="'" . $this->ValidateItem('ValidateItem3cero', $SalesBudget->SalesDistrict) . $Agency .
                                $this->ValidateItem('ValidateItemSpecChar', $SalesBudget->SalesBudgetDetail->Detail2[$i]->Name) . "',";
                        $contd2++;
                        $contd++;
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $AgencyGlobal);
            }
            if ($details != "") {
                $details = substr($details, 0, -1);
                $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $AgencyGlobal);
            }
            if ($details2 != "") {
                $details2 = substr($details2, 0, -1);
                $this->ReplaceWithAgency($TableNameD2, $ColumnsNameD2, $details2, $AgencyGlobal);
            }
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalesBudget', $ex);
        }
    }

    public function setMaterialsList($MaterialsList) {
        try {
            $MaterialsList = json_decode($MaterialsList);
            $values = "";
            $details = "";
            $valuesuni = "";
            $valuesunid = "";
            $cont = 0;
            $cont2 = 0;
            $TableName = "`listademateriales`";
            $ColumnsName = "`CodigoListaMateriales`,`CodigoArticuloKit`,`CodigoCaracteristica1Kit`,`CodigoCaracteristica2Kit`,`CodigoTipoKit`,`Cantidad`,`Sitio`,`Almacen`,"
                    . "`CantidadFijos`,`CantidadOpcionales`,`TotalPrecioVentaListaMateriales`,`CodigoVarianteKit`";
            $columnsuni = "`CodigoListaMateriales`";
            $TableNameD = "`listadematerialesdetalle`";
            $ColumnsNameD = "`CodigoListaMateriales`,`CodigoArticuloComponente`,`CodigoCaracteristica1`,`CodigoCaracteristica2`,`CodigoTipo`,`CantidadComponente`,`CodigoUnidadMedida`,"
                    . "`NombreUnidadMedida`,`Fijo`,`Opcional`,`PrecioVentaBaseVariante`,`TotalPrecioVentaBaseVariante`,`CodigoVarianteComponente`,`CodigoTipoActivity`";
            $columnsunid = "`CodigoListaMateriales`,`CodigoVarianteComponente`,`CodigoTipoActivity`";
            $ValidateUnitCode = $this->excecuteDatabaseStoredProcedures("`sp_getunitcode`();");
            for ($i = 0; $i < count($MaterialsList); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BOMId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->ItemId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->InventSize) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->InventColor) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->InventStyle) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->Quantity) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->InventSite) . "',"
                        . "'" . $this->ValidateItem('ValidateItem5cero', $MaterialsList[$i]->InventLocation) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->Quantity2) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->OptionalQuantity) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->TotalSalesPrice) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->KitVariantId) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BOMId) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $cont = 0;
                }
                if (is_object($MaterialsList[$i]->BomLines->BOMLine)) {
                    foreach ($ValidateUnitCode as $value) {
                        if (strtolower($MaterialsList[$i]->BomLines->BOMLine->UnitId) == strtolower($value['NombreUnidad'])) {
                            $UnitId = $value['CodigoUnidad'];
                        }
                    }
                    if (!isset($UnitId)) {
                        $UnitId = '000';
                    }
                    $details.="('" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BOMId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine->ItemId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BomLines->BOMLine->InventSize) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine->InventColor) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine->InventStyle) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine->BOMQuantity) . "',"
                            . "'$UnitId',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine->UnitName) . "',"
                            . "'" . $this->ValidateItem('ValidateItemStringToInt', $MaterialsList[$i]->BomLines->BOMLine->Fixed) . "',"
                            . "'" . $this->ValidateItem('ValidateItemStringToInt', $MaterialsList[$i]->BomLines->BOMLine->Optional) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine->SalesPriceBaseVariant) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine->TotalPriceBaseVariant) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine->ComponentId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemCodigoTipoActivity', $MaterialsList[$i]->BomLines->BOMLine->SalesPriceBaseVariant) . "'),";
                    $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BOMId) . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine->TotalPriceBaseVariant) .
                            $this->ValidateItem('ValidateItemSpecChar', $MaterialsList[$i]->BomLines->BOMLine->ComponentId) . "',";
                    $cont2++;
                    if ($cont2 == 2000) {
                        $details = substr($details, 0, -1);
                        $this->ReplaceAllActiveAgencies($TableNameD, $ColumnsNameD, $details);
                        $details = "";
                        $cont2 = 0;
                    }
                } else {
                    for ($j = 0; $j < count($MaterialsList[$i]->BomLines->BOMLine); $j++) {
                        foreach ($ValidateUnitCode as $value) {
                            if (strtolower($MaterialsList[$i]->BomLines->BOMLine[$j]->UnitId) == strtolower($value['NombreUnidad'])) {
                                $UnitId = $value['CodigoUnidad'];
                            }
                        }
                        if (!isset($UnitId)) {
                            $UnitId = '000';
                        }
                        $details.="('" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BOMId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine[$j]->ItemId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BomLines->BOMLine[$j]->InventSize) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine[$j]->InventColor) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine[$j]->InventStyle) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine[$j]->BOMQuantity) . "',"
                                . "'$UnitId',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $MaterialsList[$i]->BomLines->BOMLine[$j]->UnitName) . "',"
                                . "'" . $this->ValidateItem('ValidateItemStringToInt', $MaterialsList[$i]->BomLines->BOMLine[$j]->Fixed) . "',"
                                . "'" . $this->ValidateItem('ValidateItemStringToInt', $MaterialsList[$i]->BomLines->BOMLine[$j]->Optional) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine[$j]->SalesPriceBaseVariant) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine[$j]->TotalPriceBaseVariant) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine[$j]->ComponentId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemCodigoTipoActivity', $MaterialsList[$i]->BomLines->BOMLine[$j]->SalesPriceBaseVariant) . "'),";
                        $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $MaterialsList[$i]->BOMId) . $this->ValidateItem('ValidateItem1cero', $MaterialsList[$i]->BomLines->BOMLine[$j]->TotalPriceBaseVariant) .
                                $this->ValidateItem('ValidateItemSpecChar', $MaterialsList[$i]->BomLines->BOMLine[$j]->ComponentId) . "',";
                        $cont2++;
                        if ($cont2 == 2000) {
                            $details = substr($details, 0, -1);
                            $this->ReplaceAllActiveAgencies($TableNameD, $ColumnsNameD, $details);
                            $details = "";
                            $cont2 = 0;
                        }
                    }
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
            }
            if ($details != "") {
                $details = substr($details, 0, -1);
                $this->ReplaceAllActiveAgencies($TableNameD, $ColumnsNameD, $details);
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 3);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setMaterialsList', $ex);
        }
    }

    public function setSegmentation($Segmentation) {
        try {
            $Segmentation = json_decode($Segmentation);
            $values = "";
            $TableName = "`segmentos`";
            $ColumnsName = "`CodSegmento`,`Nombre`";
            $columnsuni = "`CodSegmento`";
            $valuesuni = "";
            $valuess = "";
            $TableNames = "`subsegmento`";
            $ColumnsNames = "`CodSubSegmento`,`Nombre`,`CodSegmento`";
            $columnsunis = "`CodSubSegmento`";
            $valuesunis = "";
            $TableNamec = "`cadenaempresa`";
            $ColumnsNamec = "`CodigoCadenaEmpresa`,`Nombre`,`ValorMinimo`,`CodSubSegmento`,`CodigoGrupoPrecioVenta`,`CodigoGrupoDescuentoLineaVenta`,`CodigoGrupoDescuentoMultilineaVenta`";
            $columnsunic = "`CodigoCadenaEmpresa`";
            $valuesunic = "";
            $cont = 0;
            for ($i = 0; $i < count($Segmentation); $i++) {
                $values.="('" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->CodSeg) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Segmentation[$i]->SegmentDescription) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->CodSeg) . "',";
                $valuess.="('" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->SubsegmentId) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Segmentation[$i]->SubSegmentDescription) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->CodSeg) . "'),";
                $valuesunis.="'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->SubsegmentId) . "',";
                $valuesc.="('" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->CompanyCode) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Segmentation[$i]->CompanyDescription) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Segmentation[$i]->MinimumAmount) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->SubsegmentId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->GroupPriceId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->GroupDiscountLineId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->GroupDiscountMulLineId) . "'),";
                $valuesunic.="'" . $this->ValidateItem('ValidateItem3cero', $Segmentation[$i]->CompanyCode) . "',";
                $cont++;
                if ($cont == 2000) {
                    $values = substr($values, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                    $values = "";
                    $valuess = substr($valuess, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableNames, $ColumnsNames, $valuess);
                    $valuess = "";
                    $valuesc = substr($valuesc, 0, -1);
                    $this->ReplaceAllActiveAgencies($TableNamec, $ColumnsNamec, $valuesc);
                    $valuesc = "";
                    $cont = 0;
                }
            }
            if ($values != "") {
                $values = substr($values, 0, -1);
                $this->ReplaceAllActiveAgencies($TableName, $ColumnsName, $values);
                $values = "";
                $valuess = substr($valuess, 0, -1);
                $this->ReplaceAllActiveAgencies($TableNames, $ColumnsNames, $valuess);
                $valuess = "";
                $valuesc = substr($valuesc, 0, -1);
                $this->ReplaceAllActiveAgencies($TableNamec, $ColumnsNamec, $valuesc);
                $valuesc = "";
            }
            $valuesuni = substr($valuesuni, 0, -1);
            $this->DeleteAllActiveAgencies($TableName, $valuesuni, $columnsuni, 1);
            $valuesunis = substr($valuesunis, 0, -1);
            $this->DeleteAllActiveAgencies($TableNames, $valuesunis, $columnsunis, 1);
            $valuesunic = substr($valuesunic, 0, -1);
            $this->DeleteAllActiveAgencies($TableNamec, $valuesunic, $columnsunic, 1);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSegmentation', $ex);
        }
    }

    public function setDeleteActiveZonesInCero() {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_deleteactivezonesincero`()");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteActiveZonesInCero', $ex);
        }
    }

    public function setDeleteEmptyXmlSalesBudget($SaleZone) {
        try {
            return $this->excecuteDatabaseStoredFunctions("`fn_deleteemptyxmlsalesbudget`('$SaleZone')");
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteEmptyXmlSalesBudget', $ex);
        }
    }

    public function setDeleteEmptyXmlInvoiceBalance($Agency, $SaleZone) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `facturasaldo` WHERE `CodigoZonaVentas`='$SaleZone';SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteEmptyXmlInvoiceBalance', $ex);
        }
    }

    public function setDeleteEmptyXmlInvoiceTransactions($Agency, $SaleZone) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `facturastransacciones` WHERE `CodZonaVentas`='$SaleZone';SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteEmptyXmlInvoiceTransactions', $ex);
        }
    }

    public function setDeleteEmptyXmlOutstandingInvoice($Agency, $SaleZone) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `pendientesporfacturar` WHERE `SalesZona`='$SaleZone';SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteEmptyXmlOutstandingInvoice', $ex);
        }
    }

    public function setDeleteInactiveCustomers($Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `clienteruta` where CodZonaVentas NOT IN (SELECT CodZonaVentas FROM `zonaventas`);SET FOREIGN_KEY_CHECKS=1;";
            $this->ExecuteQueryByAgency($sql, $Agency);
            $sql2 = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `cliente` WHERE `CuentaCliente` NOT IN (SELECT DISTINCT(CuentaCliente) FROM `clienteruta`);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql2, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveCustomers', $ex);
        }
    }

    public function setDeleteInactiveSalesGroup($Agency) {
        try {
            $table = '`gruposventas`';
            $where = "AND `CodigoGrupoVentas` NOT IN (SELECT DISTINCT(`CodigoGrupoVentas`) FROM `zonaventas`)";
            return $this->deletebasicAgencyFK($table, $where, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSalesGroup', $ex);
        }
    }

    public function setDeleteInactiveSalesGroupStatusCero() {
        try {
            $sql = "DELETE FROM `gruposventas` WHERE `EstadoActivo`=0;";
            Yii::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSalesGroupStatusCero', $ex);
        }
    }

    public function setDeleteInactiveSalesZoneFromGlobal($Agency) {
        try {
            $sales = "SELECT `CodZonaVentas` FROM `zonaventasglobales` WHERE `CodAgencia`='$Agency'";
            $salesZones = Yii::app()->db->createCommand($sales)->queryAll();
            $str = "";
            foreach ($salesZones as $value) {
                $str.="'" . $value['CodZonaVentas'] . "',";
            }
            $str = substr($str, 0, -1);
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `zonaventas` WHERE CodZonaVentas NOT IN ($str);SET FOREIGN_KEY_CHECKS=1";
            $this->ExecuteQueryByAgency($sql, $Agency);
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSalesZoneFromGlobal', $ex);
        }
    }

    public function setDeleteInactiveSalesGroupAgency($Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `gruposventas` WHERE CodAgencia<>'$Agency';SET FOREIGN_KEY_CHECKS=1";
            $this->ExecuteQueryByAgency($sql, $Agency);
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSalesGroupAgency', $ex);
        }
    }

    public function setDeleteInactiveSalesZoneStatusCero() {
        try {
            $sql = "DELETE FROM `zonaventas` WHERE `EstadoActualizacion`=0";
            Yii::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSalesZoneStatusCero', $ex);
        }
    }

    public function setDeleteOtherAgenciesInzonaventaalmacen($Agency) {
        try {
            $table = "`zonaventaalmacen`";
            $where = "AND Agencia not in('$Agency')";
            return $this->deletebasicAgencyFK($table, $where, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteOtherAgenciesInzonaventaalmacen', $ex);
        }
    }

    public function setDeleteInactiveZonesCreditCapacity($Agency) {
        try {
            $sql = "DELETE FROM `cupocredito` WHERE `ZonaVenta` not in (SELECT `CodZonaVentas` FROM `zonaventas`)";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveZonesCreditCapacity', $ex);
        }
    }

    public function setDeleteInactiveZonesInvoiceBalance($Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `facturasaldo` WHERE `CuentaCliente` NOT IN (SELECT CuentaCliente FROM `clienteruta`);SET FOREIGN_KEY_CHECKS=1;";
            $this->ExecuteQueryByAgency($sql, $Agency);
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `facturasaldo` WHERE CodigoZonaVentas NOT IN (SELECT CodZonaVentas FROM `zonaventas`);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveZonesInvoiceBalance', $ex);
        }
    }

    public function setDeleteInactiveZonesInvoiceBalanceDetails($Agency) {
        try {
            $sql = "DELETE FROM `facturasaldodetalle` WHERE `NumeroFactura` NOT IN (SELECT NumeroFactura FROM `facturasaldo`)";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveZonesInvoiceBalance', $ex);
        }
    }

    public function setDeleteInactiveZonesInvoiceTransactions($Agency) {
        try {
            $sql = "DELETE FROM `facturastransacciones` WHERE CodZonaVentas NOT IN (SELECT CodZonaVentas FROM `zonaventas`)";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveZonesInvoiceTransactions', $ex);
        }
    }

    public function setDeleteInactiveZonesOutstandingInvoice($Agency) {
        try {
            $sql = "DELETE FROM `pendientesporfacturar` WHERE SalesZona NOT IN (SELECT CodZonaVentas FROM `zonaventas`)";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveZonesOutstandingInvoice', $ex);
        }
    }

    public function setDeleteInactiveSitesConPreSalesInvent($Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `saldosinventarioautoventayconsignacion` WHERE CodigoSitio not in (SELECT CodSitio FROM `sitios`);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSitesConPreSalesInvent', $ex);
        }
    }

    public function setDeleteInactiveSitesInventLocationPreSales($Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `saldosinventariopreventa` WHERE CodigoSitio not in (SELECT CodSitio FROM `sitios`);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSitesInventLocationPreSales', $ex);
        }
    }

    public function setDeleteInactiveSitesInactiveVariants($Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM `variantesinactivas` WHERE `CodigoSitio` NOT IN (SELECT CodSitio FROM `sitios`);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveSitesInactiveVariants', $ex);
        }
    }

    public function setDeleteInactiveZonesSalesBudget() {
        try {
            $sql = "DELETE FROM `presupuestoventas` WHERE CodZonaVentas NOT IN (SELECT CodZonaVentas FROM `zonaventas`)";
            Yii::app()->db->createCommand($sql)->query();
            $sql1 = "DELETE FROM `presupuestoventasprofundidad` WHERE CodZonaVentas NOT IN (SELECT CodZonaVentas FROM `presupuestoventas`)";
            Yii::app()->db->createCommand($sql1)->query();
            $sql2 = "DELETE FROM `presupuestoventascuotafabricante` WHERE CodZonaVentas NOT IN (SELECT CodZonaVentas FROM `presupuestoventas`)";
            Yii::app()->db->createCommand($sql2)->query();
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteInactiveZonesSalesBudget', $ex);
        }
    }

    public function setSalesGroup($sales, $Agency, $SaleZone) {
        try {
            $sales = json_decode($sales);
            $GroupId = $this->ValidateItem('ValidateItem3cero', $sales->GroupId);
            $values = "('$GroupId',"
                    . "'" . $this->ValidateItem('ValidateItemSinDato', $sales->Name) . "',"
                    . "'$Agency',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->PP1Days) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->PP2Days) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->ModifyPrice) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscLine) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscMultiLine) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscSpecialAlt) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscSpecialVendor) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->AplyDpp) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->AplyCash) . "')";
            $this->excecuteDatabaseStoredFunctions("`fn_insertupdatesalegroup`('$GroupId',"
                    . "'" . $this->ValidateItem('ValidateItemSinDato', $sales->Name) . "',"
                    . "'$Agency',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->PP1Days) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->PP2Days) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->ModifyPrice) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscLine) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscMultiLine) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscSpecialAlt) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero2', $sales->ModifyDiscSpecialVendor) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->AplyDpp) . "',"
                    . "'" . $this->ValidateItem('ValidateItem1cero', $sales->AplyCash) . "')");
            $valuesuni = "'$GroupId'";
            $TableName = "`gruposventas`";
            $ColumnsName = "`CodigoGrupoVentas`,`NombreGrupoVentas`,`CodAgencia`,`DiasPPNivel1`,`DiasPPNivel2`,`PermitirModificarPrecio`,`PermitirModificarDescuentoLinea`,
                `PermitirModifiarDescuentoMultiLinea`,`PermitirModificarDescuentoEspecialAltipal`,`PermitirModificarDescuentoEspecialProveedor`,`AplicaDescuentoPP`,
                `AplicaContado`";
            $columnsuni = "`CodigoGrupoVentas`";
            $i = 1;
            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalesGroup', $ex);
        }
    }

    public function setSalesZone($sales, $Agency, $SaleZone) {
        try {
            $sales = json_decode($sales);
            $cont = 0;
            $values = "";
            $Detailsvalues = "";
            $valuesunid = "";
            $values.="('" . $this->ValidateItem('ValidateItem3cero', $sales->SalesDistrictId) . "',"
                    . "'" . $this->ValidateItem('ValidateItem7cero', $sales->PersonnelNumber) . "',"
                    . "'" . $this->ValidateItem('ValidateItemSinDato', $sales->Description) . "',"
                    . "'" . $this->ValidateItem('ValidateItem3cero', $sales->GroupIdSales) . "',"
                    . "'" . $this->ValidateItem('ValidateItemFalsoL', $sales->Transfer) . "',"
                    . "'" . $this->ValidateItem('ValidateItemFecha', $sales->Date_Retreat) . "',1)";
            $valuesuni = "'" . $this->ValidateItem('ValidateItem3cero', $sales->SalesDistrictId) . "'";
            $TableName = "`zonaventas`";
            $ColumnsName = "`CodZonaVentas`,`CodAsesor`,`NombreZonadeVentas`,`CodigoGrupoVentas`,`Transferencia`,`FechaRetiro`,`EstadoActualizacion`";
            $columnsuni = "`CodZonaVentas`";
            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, '000'); //global
            $where = '`CodZonaVentas`=' . $SaleZone;
            $this->DeletebyAgencyWithWhere($TableName, $columnsuni, $valuesuni, $Agency, $where, 1);
            $this->DeletebyAgencyWithWhere($TableName, $columnsuni, $valuesuni, '000', $where, 1); //global
            if (is_object($sales->SitiesZoneSales->SitiesZone)) {
                if ($this->ValidateItem('ValidateItemSinDato', $sales->SitiesZoneSales->SitiesZone->AgencyId) == $Agency) {
                    $details.="('" . $this->ValidateItem('ValidateItem3cero', $sales->SalesDistrictId) . "',"
                            . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone->wMSLocationId) . "',"
                            . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone->PreSale) . "',"
                            . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone->AutoSale) . "',"
                            . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone->Consignment) . "',"
                            . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone->Direct) . "',"
                            . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone->Focused) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $sales->SitiesZoneSales->SitiesZone->SiteId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem5cero', $sales->SitiesZoneSales->SitiesZone->InventLocationId) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $sales->SitiesZoneSales->SitiesZone->AgencyId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $sales->SitiesZoneSales->SitiesZone->AutoSalesQuotaLimit) . "'),";
                    $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $sales->SalesDistrictId) . $this->ValidateItem('ValidateItem3cero', $sales->SitiesZoneSales->SitiesZone->SiteId) .
                            $this->ValidateItem('ValidateItem5cero', $sales->SitiesZoneSales->SitiesZone->InventLocationId) . "',";
                    $cont = 1;
                }
            } else {
                for ($j = 0; $j < count($sales->SitiesZoneSales->SitiesZone); $j++) {
                    if ($this->ValidateItem('ValidateItemSinDato', $sales->SitiesZoneSales->SitiesZone[$j]->AgencyId) == $Agency) {
                        $details.="('" . $this->ValidateItem('ValidateItem3cero', $sales->SalesDistrictId) . "',"
                                . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone[$j]->wMSLocationId) . "',"
                                . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone[$j]->PreSale) . "',"
                                . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone[$j]->AutoSale) . "',"
                                . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone[$j]->Consignment) . "',"
                                . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone[$j]->Direct) . "',"
                                . "'" . $this->ValidateItem('ValidateToLower', $sales->SitiesZoneSales->SitiesZone[$j]->Focused) . "',"
                                . "'" . $this->ValidateItem('ValidateItem3cero', $sales->SitiesZoneSales->SitiesZone[$j]->SiteId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem5cero', $sales->SitiesZoneSales->SitiesZone[$j]->InventLocationId) . "',"
                                . "'" . $this->ValidateItem('ValidateItemSinDato', $sales->SitiesZoneSales->SitiesZone[$j]->AgencyId) . "',"
                                . "'" . $this->ValidateItem('ValidateItem1cero', $sales->SitiesZoneSales->SitiesZone[$j]->AutoSalesQuotaLimit) . "'),";
                        $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $sales->SalesDistrictId) . $this->ValidateItem('ValidateItem3cero', $sales->SitiesZoneSales->SitiesZone[$j]->SiteId) .
                                $this->ValidateItem('ValidateItem5cero', $sales->SitiesZoneSales->SitiesZone[$j]->InventLocationId) . "',";
                        $cont++;
                    }
                }
            }
            $TableNameD = "`zonaventaalmacen`";
            $ColumnsNameD = "`CodZonaVentas`,`CodigoUbicacion`,`Preventa`,`Autoventa`,`Consignacion`,`VentaDirecta`,`Focalizado`,`CodigoSitio`,`CodigoAlmacen`,`Agencia`,`CupoLimiteAutoventa`";
            $columnsunid = "`CodZonaVentas`,`CodigoSitio`,`CodigoAlmacen`";
//$setD = "EstadoInsAlmacen=0";//No se esta insertando en la global
//$this->updatebasic($TableNameD,$setD,"");
            $details = substr($details, 0, -1);
            $valuesunid = substr($valuesunid, 0, -1);
            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
//$this->ReplaceWithAgency($TableNameD,$ColumnsNameD,$details,'000');
            $where = "`CodZonaVentas`='$SaleZone'";
            $this->DeletebyAgencyWithWhere($TableNameD, $columnsunid, $valuesunid, $Agency, $where, 3);
            return $cont;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setSalesZone', $ex);
        }
    }

    public function setCustomers($Customers, $Agency, $SaleZone) {
        try {
            $Customers = json_decode($Customers);
            $values = "";
            $details = "";
            $valuesuni = "";
            $valuesunid = "";
            if (is_object($Customers)) {
                $values.="('" . $this->ValidateItem('ValidateItem7cero', $Customers->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItem7cero', $Customers->IdentificationNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers->Name) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers->NameAlias) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers->DeliveryAddress) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers->Phone) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers->MobilePhone) . "',"
                        . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers->Email) . "',"
                        . "'" . $this->ValidateItem('ValidateBlankTo1', $Customers->Status) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->ChainId) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->District) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->Postal) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->Latitude) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->Length) . "'),";
                $valuesuni.="'" . $this->ValidateItem('ValidateItem7cero', $Customers->AccountNum) . "',";
                $details.="('" . $this->ValidateItem('ValidateItem3cero', $Customers->Details->DetailId->SalesZone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem7cero', $Customers->AccountNum) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->Details->DetailId->RouteVisit) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->Details->DetailId->Position) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->Details->DetailId->LogisticZone) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->Details->DetailId->Value) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->Details->DetailId->TempValue) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->Details->DetailId->BalanceValue) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->PaymTerm) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->BaseDays) . "',"
                        . "'" . $this->ValidateItem('ValidateItem1cero', $Customers->AdditionalDays) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->PaymMode) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->LineDisc) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->MultiLineDisc) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->TaxGroup) . "',"
                        . "'" . $this->ValidateItem('ValidateItem3cero', $Customers->PriceGroup) . "'),";
                $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $Customers->Details->DetailId->SalesZone) . $this->ValidateItem('ValidateItem7cero', $Customers->AccountNum) . "',";
                $i = 1;
            } else {
                for ($i = 0; $i < count($Customers); $i++) {
                    $values.="('" . $this->ValidateItem('ValidateItem7cero', $Customers[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItem7cero', $Customers[$i]->IdentificationNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers[$i]->Name) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers[$i]->NameAlias) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers[$i]->DeliveryAddress) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers[$i]->Phone) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers[$i]->MobilePhone) . "',"
                            . "'" . $this->ValidateItem('ValidateItemSinDato', $Customers[$i]->Email) . "',"
                            . "'" . $this->ValidateItem('ValidateBlankTo1', $Customers[$i]->Status) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->ChainId) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->District) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->Postal) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->Latitude) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->Length) . "'),";
                    $valuesuni.="'" . $this->ValidateItem('ValidateItem7cero', $Customers[$i]->AccountNum) . "',";
                    $details.="('" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->Details->DetailId->SalesZone) . "',"
                            . "'" . $this->ValidateItem('ValidateItem7cero', $Customers[$i]->AccountNum) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->Details->DetailId->RouteVisit) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->Details->DetailId->Position) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->Details->DetailId->LogisticZone) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->Details->DetailId->Value) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->Details->DetailId->TempValue) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->Details->DetailId->BalanceValue) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->PaymTerm) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->BaseDays) . "',"
                            . "'" . $this->ValidateItem('ValidateItem1cero', $Customers[$i]->AdditionalDays) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->PaymMode) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->LineDisc) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->MultiLineDisc) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->TaxGroup) . "',"
                            . "'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->PriceGroup) . "'),";
                    $valuesunid.="'" . $this->ValidateItem('ValidateItem3cero', $Customers[$i]->Details->DetailId->SalesZone) . $this->ValidateItem('ValidateItem7cero', $Customers[$i]->AccountNum) . "',";
                }
            }
            $TableName = "`cliente`";
            $ColumnsName = "`CuentaCliente`,`Identificacion`,`NombreCliente`,`NombreBusqueda`,`DireccionEntrega`,`Telefono`,`TelefonoMovil`,`CorreoElectronico`,"
                    . "`Estado`,`CodigoCadenaEmpresa`,`CodigoBarrio`,`CodigoPostal`,`Latitud`,`Longitud`";
            $columnsuni = "`CuentaCliente`";
            $values = substr($values, 0, -1);
            $valuesuni = substr($valuesuni, 0, -1);
            $this->ReplaceWithAgency($TableName, $ColumnsName, $values, $Agency);
            $details = substr($details, 0, -1);
            $TableNameD = "`clienteruta`";
            $ColumnsNameD = "`CodZonaVentas`,`CuentaCliente`,`NumeroVisita`,`Posicion`,`CodigoZonaLogistica`,`ValorCupo`,`ValorCupoTemporal`,`SaldoCupo`,`CodigoCondicionPago`,"
                    . "`DiasGracia`,`DiasAdicionales`,`CodigoFormadePago`,`CodigoGrupoDescuentoLinea`,`CodigoGrupoDescuentoMultiLinea`,`CodigoGrupodeImpuestos`,`CodigoGrupoPrecio`";
            $columnsunid = "`CodZonaVentas`,`CuentaCliente`";
            $valuesunid = substr($valuesunid, 0, -1);
            $this->ReplaceWithAgency($TableNameD, $ColumnsNameD, $details, $Agency);
            $where = "CodZonaVentas='$SaleZone'";
            $this->DeletebyAgencyWithWhere($TableNameD, $columnsunid, $valuesunid, $Agency, $where, 2);
            return $i;
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setCustomers', $ex);
        }
    }

    public function setDeleteEmptyHeaderAndDetail() {
        try {
            $sql = "DELETE FROM `ControlProcesoActualizacionDetalle` WHERE IdEncabezado NOT IN (SELECT Id FROM `ControlProcesoActualizacionEncabezado`);
                    DELETE FROM `ControlProcesoActualizacionEncabezado` WHERE Id NOT IN (SELECT IdEncabezado FROM `ControlProcesoActualizacionDetalle`);";
            Yii::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setDeleteEmptyHeaderAndDetail', $ex);
        }
    }

    public function setChangeProcessAltipalFromProcessActivity() {
        try {
            $querycount = "SELECT COUNT(Id) FROM `ControlProcesoActualizacionEncabezado` WHERE `Estado`=0";
            $count = Yii::app()->db->createCommand($querycount)->queryScalar();
            if ($count > 0) {
                $queryheader = "SELECT Id,`IdControlador` FROM `ControlProcesoActualizacionEncabezado` WHERE Id=(SELECT MIN(`Id`) FROM `ControlProcesoActualizacionEncabezado` WHERE `Estado`=0)";
                $header = Yii::app()->db->createCommand($queryheader)->queryRow();
                $this->excecuteDatabaseStoredFunctions("`fn_updatestatusforprocessday`()");
                $sqlupdateMethod = "UPDATE `metodosactualizacionax` SET `Estado`=1 WHERE `Id`=" . $header['IdControlador'];
                Yii::app()->db->createCommand($sqlupdateMethod)->query();
                $queryupdateMethod = "SELECT `QueryUpdate` FROM `ConfiguracionParametrosMetodos` C INNER JOIN `metodosactualizacionax` M ON M.`Parametro`=C.`Id` WHERE M.`Id`=" . $header['IdControlador'];
                $query = Yii::app()->db->createCommand($queryupdateMethod)->queryRow();
                if ($query != "") {
                    $queryAgenciesParam = "SELECT `Agencia`,`Parametro` FROM `ControlProcesoActualizacionDetalle` WHERE `IdEncabezado`=" . $header['Id'];
                    $Details = Yii::app()->db->createCommand($queryAgenciesParam)->queryAll();
                    $agency = "";
                    $params = "";
                    $agencies = "";
                    foreach ($Details as $Detail) {
                        if ($Detail['Agencia'] != "") {
                            if ($Detail['Parametro'] != "") {
                                $params.="'" . $Detail['Parametro'] . "',";
                                if ($agency != $Detail['Agencia']) {
                                    $agency.= "'" . $Detail['Agencia'] . "',";
                                }
                            } else {
                                $agencies.="'" . $Detail['Agencia'] . "',";
                            }
                        }
                    }
                    if ($params != "") {
                        $params = substr($params, 0, -1);
                        $sqlconcat = $query['QueryUpdate'] . "($params)";
                        Yii::app()->db->createCommand($sqlconcat)->query();
                        $agency = substr($agency, 0, -1);
                        $sqlupdateagencies = "UPDATE `agencia` SET `Activo`=1 WHERE `CodAgencia` IN ($agency)";
                        Yii::app()->db->createCommand($sqlupdateagencies)->query();
                    }
                    if ($agencies != "") {
                        $agencies = substr($agencies, 0, -1);
                        $sqlconcat = $query['QueryUpdate'] . "($agencies)";
                        Yii::app()->db->createCommand($sqlconcat)->query();
                    }
                }
                return "OK";
            }
            return "NO";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setChangeProcessAltipalFromProcessActivity', $ex);
        }
    }

    public function setHeaderStatusToOne() {
        try {
            $sql = "SELECT MIN(`Id`) FROM `ControlProcesoActualizacionEncabezado` WHERE Estado=0";
            $HeaderId = Yii::app()->db->createCommand($sql)->queryScalar();
            $sql2 = "UPDATE `ControlProcesoActualizacionEncabezado` SET `Estado`=1 WHERE `Id`=$HeaderId";
            Yii::app()->db->createCommand($sql2)->query();
            return "OK";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'setHeaderStatusToOne', $ex);
        }
    }

    public function getEmailMessageActivity($fechaInicial, $fechaFinal, $horaInicial, $horaFinal) {
        try {
            $sql = "SELECT COUNT(Id) FROM `EnvioTipoCorreo` WHERE Estado=1 AND `Id`=1";
            $Status = Yii::app()->db->createCommand($sql)->queryScalar();
            if ($Status == 1) {
                $cont = 1;
                $txt = "";
                $Operator = ($fechaInicial == $fechaFinal) ? "AND" : "OR";
                $sql2 = "SELECT E.`MensajeActivity`,E.`MensajeServicio`,E.`Fecha`,E.`Hora`,E.`ServicioSRF`,E.`TablasActualizar`,E.`Parametros`,E.`Agencia`,E.`NombreServidor`,M.`NombreClase`
                    FROM `erroresactualizacion` E INNER JOIN `ConfiguracionControladorTipoEnvio` C ON C.`IdControlador`=E.`IdControlador` 
                    INNER JOIN `metodosactualizacionax` M ON M.`Id`=E.`IdControlador` 
                    WHERE (C.`Estado`=1 AND C.`IdTipoEnvio`=1 AND E.`TipoError`=1) AND ((E.`Fecha`='$fechaInicial' AND E.`Hora`>='$horaInicial') $Operator (E.`Fecha`='$fechaFinal' AND E.`Hora`<='$horaFinal'))";
                $MensajeCorreo = Yii::app()->db->createCommand($sql2)->queryAll();
                if (isset($MensajeCorreo)) {
                    foreach ($MensajeCorreo as $row) {
                        $txt .= $cont . "-)" . $row['NombreClase'] . ": ServicioSRF " . $row['ServicioSRF'] . " Mensaje Activity: " . $row['MensajeActivity'] . " Mensaje Servicio: " . $row['MensajeServicio'] . " Fecha: " . $row['Fecha'] . " Hora: " . $row['Hora'] . " Agencia: " . $row['Agencia'] . " Parametro: " . $row['Parametros'] . ".<br><br>";
                        $cont++;
                    }
                    if ($txt != "") {
                        $subject = "Status Procesos Activity";
                        $Correos = $this->getEmailProcessActivity();
                        foreach ($Correos as $datos) {
                            Yii::import('application.extensions.phpmailer.JPhpMailer');
                            $mail = new JPhpMailer;
                            $mail->IsSMTP();
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = "tls";
                            $mail->Host = "m1.redsegura.net";
                            $mail->Port = 25;
                            $mail->Username = 'soporte@activity.com.co';
                            $mail->Password = 'tech0304junio';
                            $mail->From = 'soporte@activity.com.co';
                            $mail->FromName = 'Activity soporte';
                            $mail->WordWrap = 50;
                            $mail->isHTML(true);
                            $mail->Subject = $subject;
                            $mail->AltBody = $subject;
                            $to = $datos['Correo'];
                            $txt0 = "Buenos Dias Sr(a) " . $datos['Usuario'] . " el dia de hoy se genero problemas en los siguientes servicios: <br><br>";
                            $Message = utf8_decode($txt0 . $txt);
                            file_put_contents('email1.txt', $Message);
                            $mail->addAddress($to, $datos['Usuario']);
                            $mail->Body = $Message;
                            $mail->Send();
                        }
                        return "OK";
                    }
                }
            }
            return "";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getEmailMessageActivity', $ex);
        }
    }

    public function getEmailMessageAltipal($fechaInicial, $fechaFinal, $horaInicial, $horaFinal) {
        try {
            $sql = "SELECT COUNT(Id) FROM `EnvioTipoCorreo` WHERE Estado=1 AND Id=2";
            $Status = Yii::app()->db->createCommand($sql)->queryScalar();
            if ($Status == 1) {
                $cont = 1;
                $txt = "";
                $Operator = ($fechaInicial == $fechaFinal) ? "AND" : "OR";
                $sql2 = "SELECT E.`MensajeActivity`,E.`MensajeServicio`,E.`Fecha`,E.`Hora`,E.`ServicioSRF`,E.`TablasActualizar`,E.`Parametros`,E.`Agencia`,E.`NombreServidor`,M.`NombreClase` 
                    FROM `erroresactualizacion` E INNER JOIN `ConfiguracionControladorTipoEnvio` C ON C.`IdControlador`=E.`IdControlador`
                    INNER JOIN `metodosactualizacionax` M ON M.`Id`=E.`IdControlador` 
                    WHERE (C.`Estado`=1 AND C.`IdTipoEnvio`=2 AND E.`TipoError`=2) AND ((E.`Fecha`='$fechaInicial' AND E.`Hora`>='$horaInicial') $Operator (E.`Fecha`='$fechaFinal' AND E.`Hora`<='$horaFinal'))";
                $MensajeCorreo = Yii::app()->db->createCommand($sql2)->queryAll();
                if (isset($MensajeCorreo)) {
                    foreach ($MensajeCorreo as $row) {
                        $txt .= $cont . "-)" . $row['NombreClase'] . " Mensaje Servicio: " . $row['MensajeServicio'] . " Fecha: " . $row['Fecha'] . " Hora: " . $row['Hora'] . " Agencia: " . $row['Agencia'] . " Parametro: " . $row['Parametros'] . ".<br><br>";
                        $cont++;
                    }
                    if ($txt != "") {
                        $subject = "Status Procesos Altipal";
                        $Correos = $this->getEmailSummaryProcess();
                        foreach ($Correos as $datos) {
                            Yii::import('application.extensions.phpmailer.JPhpMailer');
                            $mail = new JPhpMailer;
                            $mail->IsSMTP();
                            $mail->SMTPAuth = true;
                            $mail->SMTPSecure = "tls";
                            $mail->Host = "m1.redsegura.net";
                            $mail->Port = 25;
                            $mail->Username = 'soporte@activity.com.co';
                            $mail->Password = 'tech0304junio';
                            $mail->From = 'soporte@activity.com.co';
                            $mail->FromName = 'Activity soporte';
                            $mail->WordWrap = 50;
                            $mail->isHTML(true);
                            $mail->Subject = $subject;
                            $mail->AltBody = $subject;
                            $to = $datos['Correo'];
                            $txt0 = "Buenos Dias Sr(a) " . $datos['Usuario'] . " el dia de hoy se genero problemas en los siguientes servicios: <br><br>";
                            $Message = utf8_decode($txt0 . $txt);
                            file_put_contents('email3.txt', $Message);
                            $mail->addAddress($to, $datos['Usuario']);
                            $mail->Body = $Message;
                            $mail->Send();
                        }
                        return "OK";
                    }
                }
            }
            return "";
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getEmailMessageAltipal', $ex);
        }
    }

    public function getEmailMessageSummary($fechaInicial, $fechaFinal, $horaInicial, $horaFinal) {
        $sql = "SELECT COUNT(`Id`) FROM `EnvioTipoCorreo` WHERE `Estado`=1 AND `Id`=3";
        $Status = Yii::app()->db->createCommand($sql)->queryScalar();
        if ($Status == 1) {
            $cont = 0;
            $cont2 = 0;
            $txt = "";
            try {
                while ($cont2 < 2) {
                    if ($cont2 == 0) {
                        $DuracionProceso = $this->getEmailMessageProcessSummary($fechaInicial, $fechaFinal, $horaInicial, $horaFinal);
                    } else {
                        unset($DuracionProceso);
                        $DuracionProceso = $this->getEmailMessageIndividualProcessSummary($fechaInicial, $fechaFinal, $horaInicial, $horaFinal);
                    }
                    foreach ($DuracionProceso as $row) {
                        if ($row['Estado'] == 0) {
                            $Controlador = $row['IdControlador'];
                            $fechacomienzaproceso = $row['Fecha'];
                            $horacomienzaproceso = $row['Hora'];
                        } else if ($Controlador == $row['IdControlador']) {
                            $fechaterminaproceso = $row['Fecha'];
                            $horaterminaproceso = $row['Hora'];
                            $duracion = (date("H:i:s", strtotime("00:00:00") + strtotime($horaterminaproceso) - strtotime($horacomienzaproceso)));
                            if ($row['IdControlador'] != 0) {
                                $cont++;
                                if ($row['Estado'] == 2) {
                                    $txt .= $cont . "-)<b>" . $row['NombreClase'] . "</b>" . $duracion . "<br>Hora Inicio: " . $horacomienzaproceso . "   Hora Fin: " . $horaterminaproceso . "<br>Fecha Actualizacion: " . $fechacomienzaproceso . " " . $horacomienzaproceso . "<br>Nombre del Servidor: " . $row['NombreServidor'] . "<br><font color='red'>Termino Incompleto</font><br>----------------------------------------------------<br><br>";
                                } else {
                                    $txt .= $cont . "-)<b>" . $row['NombreClase'] . "</b>" . $duracion . "<br> Hora Inicio: " . $horacomienzaproceso . "   Hora Fin: " . $horaterminaproceso . "<br>Fecha Actualizacion: " . $fechacomienzaproceso . " " . $horacomienzaproceso . "<br>Nombre del Servidor: " . $row['NombreServidor'] . "<br>----------------------------------------------------<br><br>";
                                }
                            } else {
                                $txt .= "<b>" . $row['NombreClase'] . "</b>" . $duracion . "<br>Hora Inicio: " . $horacomienzaproceso . "   Hora Fin: " . $horaterminaproceso . "<br>Fecha Actualizacion: " . $fechacomienzaproceso . " " . $horacomienzaproceso . "<br>Nombre del Servidor: " . $row['NombreServidor'] . "<br>----------------------------------------------------<br><br>";
                            }
                        }
                    }
                    $cont2++;
                }
                if (($cont > 0) && ($txt != "")) {
                    $subject = "Resumen Proceso Altipal";
                    $Correos = $this->getEmailSummaryProcess();
                    foreach ($Correos as $datos) {
                        Yii::import('application.extensions.phpmailer.JPhpMailer');
                        $mail = new JPhpMailer;
                        $mail->IsSMTP();
                        $mail->SMTPAuth = true;
                        $mail->SMTPSecure = "tls";
                        $mail->Host = "m1.redsegura.net";
                        $mail->Port = 25;
                        $mail->Username = 'soporte@activity.com.co';
                        $mail->Password = 'tech0304junio';
                        $mail->From = 'soporte@activity.com.co';
                        $mail->FromName = 'Activity soporte';
                        $mail->WordWrap = 50;
                        $mail->isHTML(true);
                        $mail->AltBody = $subject;
                        $mail->Subject = $subject;
                        $to = $datos['Correo'];
                        $txt0 = "Buenos dias Sr(a) " . $datos['Usuario'] . " a continuacion se envia resumen con la duracion de cada uno de los procesos ejecutados durante el proceso nocturno: "
                                . "<br><br> El numero de procesos que se actualizaron fueron: " . $cont . "<br><br>";
                        $Message = utf8_decode($txt0 . $txt);
                        $mail->addAddress($to, $datos['Usuario']);
                        $mail->Body = $Message;
                        $mail->Send();
                        file_put_contents('email4.txt', $Message);
                        $manejador = fopen("LogCorreos/" . $to . 'CorreoErrores.txt', 'a+');
                        fputs($manejador, utf8_decode($txt0) . utf8_decode($txt) . "\n");
                        fclose($manejador);
                    }
                    return "OK";
                }
                return "";
            } catch (Exeption $e) {
                return $this->createLog('AltipalLoadWS', 'getEmailMessageSummary', $ex);
            }
        }
    }

    public function getEmailMessageIndividualProcessSummary($fechaInicial, $fechaFinal, $horaInicial, $horaFinal) {
        try {
            $Operator = ($fechaInicial == $fechaFinal) ? "AND" : "OR";
            $sql = "SELECT L.`IdControlador`,L.`Estado`,L.`Fecha`,L.`Hora`,L.`NombreServidor`,M.`NombreClase`  FROM `logprocesosactualizacion` L 
            INNER JOIN `ConfiguracionControladorTipoEnvio` C ON C.`IdControlador`=L.`IdControlador` 
            INNER JOIN `metodosactualizacionax` M ON M.`Id`=L.`IdControlador` WHERE (C.`Estado`=1 AND C.`IdTipoEnvio`=3 AND L.`IdControlador`>0) AND 
            ((L.`Fecha`='$fechaInicial' AND L.`Hora`>='$horaInicial') $Operator (L.`Fecha`='$fechaFinal' AND L.`Hora`<='$horaFinal')) ORDER BY L.`Id`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getEmailMessageIndividualProcessSummary', $ex);
        }
    }

    public function getEmailMessageProcessSummary($fechaInicial, $fechaFinal, $horaInicial, $horaFinal) {
        try {
            $Operator = ($fechaInicial == $fechaFinal) ? "AND" : "OR";
            $sql = "SELECT L.`IdControlador`,L.`Estado`,L.`Fecha`,L.`Hora`,L.`NombreServidor`,M.`NombreClase` FROM `logprocesosactualizacion` L 
            INNER JOIN `ConfiguracionControladorTipoEnvio` C ON C.`IdControlador`=L.`IdControlador` 
            INNER JOIN `metodosactualizacionax` M ON M.`Id`=L.`IdControlador` WHERE (C.`Estado`=1 AND C.`IdTipoEnvio`=3 AND L.`IdControlador`=0) AND 
            ((L.`Fecha`='$fechaInicial' AND L.`Hora`>='$horaInicial') $Operator (L.`Fecha`='$fechaFinal' AND L.`Hora`<='$horaFinal')) ORDER BY L.`Id`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getEmailMessageProcessSummary', $ex);
        }
    }

    public function getEmailProcessActivity() {
        try {
            $sql = "SELECT Usuario,Correo,EnviaCorreoResumen,EnviaCorreoActivity FROM `correosproceso` WHERE `EnviaCorreoActivity`=1";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getEmailProcessActivity', $ex);
        }
    }

    public function getEmailSummaryProcess() {
        try {
            $sql = "SELECT Usuario,Correo,EnviaCorreoResumen,EnviaCorreoActivity FROM `correosproceso` WHERE EnviaCorreoResumen=1";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return $this->createLog('AltipalLoadWS', 'getEmailSummaryProcess', $ex);
        }
    }

}
