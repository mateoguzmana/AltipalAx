<?php

class ProcesoAltipal extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createLog($class, $function, $e) {
        Yii::import('application.extensions.ActivityLog');
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    public function getAllServiceExcecute() {
        try {
            $sql = "SELECT Id,NombreClase FROM `metodosactualizacionax` WHERE OrdenEjecucion>0";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'getAllServiceExcecute', $ex);
            return $ex;
        }
    }

    public function getAllAgencies() {
        try {
            $sql = "SELECT CodAgencia,Nombre FROM `agencia`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'getAllAgencies', $ex);
            return $ex;
        }
    }

    public function GetAmountParameters($Methods) {
        try {
            $sql = "SELECT COUNT(DISTINCT(`Parametro`)) FROM `metodosactualizacionax` WHERE `Id` IN($Methods)";
            return Yii::app()->db->createCommand($sql)->queryScalar();
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'GetAmountParameters', $ex);
            return $ex;
        }
    }

    public function GetDataSelect($Methods) {
        try {
            $sql2 = "SELECT QuerySelect,NombreParametro FROM `ConfiguracionParametrosMetodos` WHERE Id=(SELECT Parametro FROM `metodosactualizacionax` WHERE Id IN($Methods) GROUP BY Parametro)";
            return Yii::app()->db->createCommand($sql2)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'GetDataSelect', $ex);
            return $ex;
        }
    }

    public function GetDataSelectAgency($Method) {
        try {
            $sql2 = "SELECT RequiereAgencia FROM `ConfiguracionParametrosMetodos` WHERE Id=(SELECT Parametro FROM `metodosactualizacionax` WHERE Id=$Method)";
            $queryagencies = Yii::app()->db->createCommand($sql2)->queryScalar();
            if ($queryagencies == 1) {
                $sql3 = "SELECT CodAgencia,Nombre FROM `agencia`";
                $DataSelect = Yii::app()->db->createCommand($sql3)->queryAll();
                $DataAgencyJson = array(
                    'SelectName' => "Agencia",
                    'Select' => $DataSelect
                );
                return json_encode($DataAgencyJson);
            } else {
                return "";
            }
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'GetDataSelectAgency', $ex);
            return $ex;
        }
    }

    public function ExcecuteQuery($sql, $Agencies) {
        try {
            if ($sql != "") {
                $Query = $sql . " AND CodAgencia IN($Agencies) GROUP BY Param";
                return Yii::app()->db->createCommand($Query)->queryAll();
            }
            return "";
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'ExcecuteQuery', $ex);
            return $ex;
        }
    }

    public function getProcessExecution() {
        try {
            $QueryError = "SELECT COUNT(`Id`) FROM `logprocesosactualizacion` WHERE ((`IdControlador`<>0 AND `Estado`<>0) OR (`IdControlador`=0 AND `Estado`=0)) AND `Id`=(SELECT MAX(`Id`) FROM `logprocesosactualizacion`)";
            $count = Yii::app()->db->createCommand($QueryError)->queryScalar();
            $Query = "SELECT L.`Fecha`,L.`Hora`,L.`Estado`,M.`NombreClase` FROM `logprocesosactualizacion` L INNER JOIN `metodosactualizacionax` M ON M.`Id`=L.`IdControlador` WHERE L.`Id`=(SELECT MAX(`Id`) FROM `logprocesosactualizacion`) AND L.`IdControlador`<>0";
            $Process = Yii::app()->db->createCommand($Query)->queryRow();
            $ProcessArr = array(
                'Cont' => $count,
                'Name' => $Process['NombreClase'],
                //'Date' => $Process['Fecha'],
                //'Time' => $Process['Hora'],
                'Time' => (date("H:i:s", strtotime("00:00:00") + strtotime(date("H:i:s")) - strtotime($Process['Hora']))),
                'Status' => $Process['Estado']
            );
            return $ProcessArr;
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'ExcecuteQuery', $ex);
            return $ex;
        }
    }

    public function getProcessExecutionindex() {
        try {
            $QueryError = "SELECT COUNT(`Id`) FROM `logprocesosactualizacion` WHERE ((`IdControlador`<>0 AND `Estado`<>0) OR (`IdControlador`=0 AND `Estado`=0)) AND `Id`=(SELECT MAX(`Id`) FROM `logprocesosactualizacion`)";
            $count = Yii::app()->db->createCommand($QueryError)->queryScalar();
            $Query = "SELECT COUNT(L.`Id`) FROM `logprocesosactualizacion` L WHERE L.`Id`=(SELECT MAX(`Id`) FROM `logprocesosactualizacion`) AND L.`IdControlador`<>0";
            $Process = Yii::app()->db->createCommand($Query)->queryScalar();
            $ProcessArr = array(
                'Cont' => $count,
                //'Time' => $Process['Hora'],
                'Status' => $Process
            );
            return $ProcessArr;
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'ExcecuteQuery', $ex);
            return $ex;
        }
    }

    public function setControlUpdateProcess($JsonArr) {
        try {
            $ProcesRunSql = "select true from logprocesosactualizacion WHERE IdControlador=0 and Estado=1 and Id=(select Max(Id) FROM `logprocesosactualizacion`)";
            $ProcesRun = YII::app()->db->createCommand($ProcesRunSql)->queryScalar();
            if ($ProcesRun == true) {
                $sql = "INSERT INTO `logprocesosusuarios`(`Cedula`,`FechaInicio`,`HoraInicio`,`TipoEjecucion`) "
                        . "VALUES (" . Yii::app()->user->_cedula . ",CURDATE(),CURTIME(),2)";
                Yii::app()->db->createCommand($sql)->query();
                $sql = "SELECT MAX(Id) FROM `logprocesosusuarios`";
                $idprocess = Yii::app()->db->createCommand($sql)->queryScalar();
                if (is_object($JsonArr)) {
                    $sql = "INSERT INTO `ControlProcesoActualizacionEncabezado`(`IdControlador`, `Fecha`, `Hora`, `Estado`, `Orden`) "
                            . "VALUES (" . $JsonArr->Controller . ",CURDATE(),CURTIME(),2,1)";
                    Yii::app()->db->createCommand($sql)->query();
                    $sql2 = "SELECT MAX(Id) FROM `ControlProcesoActualizacionEncabezado`";
                    $HeaderId = Yii::app()->db->createCommand($sql2)->queryScalar();
                    if (is_array($JsonArr->Agencies)) {
                        foreach ($JsonArr->Agencies as $Agency) {
                            if (is_array($JsonArr->Params)) {
                                foreach ($JsonArr->Params as $Param) {
                                    $queryInsertMethod = "SELECT `QueryInsert` FROM `ConfiguracionParametrosMetodos` C INNER JOIN `metodosactualizacionax` M ON M.`Parametro`=C.`Id` WHERE M.`Id`=" . $JsonArr->Controller;
                                    $query = Yii::app()->db->createCommand($queryInsertMethod)->queryRow();
                                    $sqlconcat = $query['QueryInsert'] . $Param . " AND CodAgencia='$Agency'";
                                    $Exist = Yii::app()->db->createCommand($sqlconcat)->queryScalar();
                                    if ($Exist > 0) {
                                        $sql3 = "INSERT INTO `ControlProcesoActualizacionDetalle`(`IdEncabezado`,`Agencia`,`Parametro`) "
                                                . "VALUES ($HeaderId,'$Agency','$Param')";
                                        Yii::app()->db->createCommand($sql3)->query();
                                    }
                                }
                            } else {
                                $sql3 = "INSERT INTO `ControlProcesoActualizacionDetalle`(`IdEncabezado`,`Agencia`) VALUES ($HeaderId,'$Agency')";
                                Yii::app()->db->createCommand($sql3)->query();
                            }
                        }
                    } else {
                        $sql4 = "INSERT INTO `ControlProcesoActualizacionDetalle`(`IdEncabezado`,`Agencia`,`Parametro`) VALUES ($HeaderId,'','')";
                        Yii::app()->db->createCommand($sql4)->query();
                    }
                } else {
                    for ($i = 0; $i < count($JsonArr); $i++) {
                        $sql = "INSERT INTO `ControlProcesoActualizacionEncabezado`(`IdControlador`, `Fecha`, `Hora`, `Estado`, `Orden`) "
                                . "VALUES (" . $JsonArr[$i]->Controller . ",CURDATE(),CURTIME(),0," . ($i + 1) . ")";
                        Yii::app()->db->createCommand($sql)->query();
                        $sql2 = "SELECT MAX(Id) FROM `ControlProcesoActualizacionEncabezado`";
                        $HeaderId = Yii::app()->db->createCommand($sql2)->queryScalar();
                        if (is_array($JsonArr[$i]->Agencies)) {
                            foreach ($JsonArr[$i]->Agencies as $Agency) {
                                if (is_array($JsonArr[$i]->Params)) {
                                    foreach ($JsonArr[$i]->Params as $Param) {
                                        $queryInsertMethod = "SELECT `QueryInsert` FROM `ConfiguracionParametrosMetodos` C INNER JOIN `metodosactualizacionax` M ON M.`Parametro`=C.`Id` WHERE M.`Id`=" . $JsonArr[$i]->Controller;
                                        $query = Yii::app()->db->createCommand($queryInsertMethod)->queryRow();
                                        $sqlconcat = $query['QueryInsert'] . $Param . " AND CodAgencia='$Agency'";
                                        $Exist = Yii::app()->db->createCommand($sqlconcat)->queryScalar();
                                        if ($Exist > 0) {
                                            $sql3 = "INSERT INTO `ControlProcesoActualizacionDetalle`(`IdEncabezado`,`Agencia`,`Parametro`) "
                                                    . "VALUES ($HeaderId,'$Agency','$Param')";
                                            Yii::app()->db->createCommand($sql3)->query();
                                        }
                                    }
                                } else {
                                    $sql3 = "INSERT INTO `ControlProcesoActualizacionDetalle`(`IdEncabezado`, `Agencia`) "
                                            . "VALUES ($HeaderId, '$Agency')";
                                    Yii::app()->db->createCommand($sql3)->query();
                                }
                            }
                        } else {
                            $sql4 = "INSERT INTO `ControlProcesoActualizacionDetalle`(`IdEncabezado`,`Agencia`,`Parametro`) "
                                    . "VALUES ($HeaderId,'','')";
                            Yii::app()->db->createCommand($sql4)->query();
                        }
                    }
                }
                $sql = "UPDATE `logprocesosusuarios` SET `FechaFin`=CURDATE(),`HoraFin`=CURTIME() WHERE `Id`=$idprocess";
                Yii::app()->db->createCommand($sql)->query();
                return $this->CallServiceProcess();
            } else {
                return "NO";
            }
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'setControlUpdateProcess', $ex);
            return $ex;
        }
    }

    public function setStatusProcessToRun($method) {
        try {
            $ProcesRunSql = "select true from logprocesosactualizacion where IdControlador=0 and Estado=1 and Id=(select Max(Id) FROM `logprocesosactualizacion`)";
            $ProcesRun = YII::app()->db->createCommand($ProcesRunSql)->queryScalar();
            if ($ProcesRun == true) {
                $sql = "INSERT INTO `logprocesosusuarios`(`Cedula`,IdControlador,`FechaInicio`,`HoraInicio`,`TipoEjecucion`) "
                        . "VALUES (" . Yii::app()->user->_cedula . ",$method,CURDATE(),CURTIME(),1)";
                Yii::app()->db->createCommand($sql)->query();
                $ChangeStatus = "SELECT `fn_updatestatusforprocessday`();";
                YII::app()->db->createCommand($ChangeStatus)->queryScalar();
                $queryUpdateMethod = "SELECT `UpdateProcess` FROM `ConfiguracionParametrosMetodos` C INNER JOIN `metodosactualizacionax` M ON M.`Parametro`=C.`Id` WHERE M.`Id`=" . $method;
                $query = Yii::app()->db->createCommand($queryUpdateMethod)->queryRow();
                $sqlconcat = $query['UpdateProcess'] . $method;
                Yii::app()->db->createCommand($sqlconcat)->query();
                return $this->CallServiceProcess();
            } else {
                return "NO";
            }
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'setStatusProcessToRun', $ex);
            return $ex;
        }
    }

    public function setExcecuteAllProcessComplete($method) {
        try {
            $ProcesRunSql = "select true from logprocesosactualizacion where IdControlador=0 and Estado=1 and Id=(select Max(Id) FROM `logprocesosactualizacion`)";
            $ProcesRun = YII::app()->db->createCommand($ProcesRunSql)->queryScalar();
            if ($ProcesRun == true) {
                $sql = "INSERT INTO `logprocesosusuarios`(`Cedula`,IdControlador,`FechaInicio`,`HoraInicio`,`TipoEjecucion`) "
                        . "VALUES (" . Yii::app()->user->_cedula . ",0,CURDATE(),CURTIME(),1)";
                Yii::app()->db->createCommand($sql)->query();
                $ChangeStatus = "SELECT `fn_updatestatusforcompleteprocess`();";
                YII::app()->db->createCommand($ChangeStatus)->queryScalar();
                return $this->CallServiceProcess();
            } else {
                return "NO";
            }
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'setStatusProcessToRun', $ex);
            return $ex;
        }
    }

    public function CallServiceProcess() {
        try {
            $servicio = "http://209.133.196.89/AltipalTriggerService/TriggerService.svc?wsdl";
            $client = new SoapClient($servicio);
            $client->excecuteProcess();
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('ProcesoAltipal', 'CallServiceProcess', $ex);
            return $ex;
        }
    }

}
