<?php

Yii::import('application.extensions.ActivityLog');

/**
 * Created by Activity Technology SAS.
 */
class DatabaseUtilities extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*     * ********************************** json log ************************************************ * */

    public function createLog($class, $function, $e) {
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    /*     * ********************************** datautilities ******************************************* * */

    public function excecuteDatabaseStoredFunctions($function) {
        try {
            $query = "SELECT $function;";
            return YII::app()->db->createCommand($query)->queryScalar();
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'excecuteDatabaseStoredFunctions', $ex);
            return $ex;
        }
    }

    public function Utf8encodedecode($sql) {
        try {
            $encode = utf8_encode($sql);
            $decode = utf8_decode($encode);
            return $decode;
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'Utf8encodedecode', $ex);
            return $ex;
        }
    }

    public function InsertUpdateWithAgency($table, $columns, $values, $columnsu, $agency) {
        try {
            $query = "INSERT INTO $table $columns VALUES $values ON DUPLICATE KEY UPDATE $columnsu";
            return $this->ExecuteQueryByAgency($query, $agency);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'InsertUpdateWithAgency', $ex);
            return $ex;
        }
    }

    public function InsertUpdate($table, $columns, $values, $columnsu) {
        try {
            $query = "INSERT INTO $table $columns VALUES $values ON DUPLICATE KEY UPDATE $columnsu";
            YII::app()->db->createCommand($query)->query();
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'InsertUpdate', $ex);
            return $ex;
        }
    }

    public function InsertUpdateAllAgencies($table, $columns, $values, $columnsu) {
        try {
            $sql = "INSERT INTO $table $columns VALUES $values ON DUPLICATE KEY UPDATE $columnsu";
            return $this->insertDatosAll($sql);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'InsertUpdateAllAgencies', $ex);
            return $ex;
        }
    }

    public function updatebasic($table, $set, $where) {
        try {
            $sql = "UPDATE $table SET $set WHERE 1=1 $where";
            //return $sql;
            YII::app()->db->createCommand($sql)->query();
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'updatebasic', $ex);
            return $ex;
        }
    }

    public function updatebasicAgency($table, $set, $where, $Agency) {
        try {
            $sql = "UPDATE $table SET $set WHERE 1=1 $where";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'updatebasicAgency', $ex);
            return $ex;
        }
    }

    public function deletebasicAgencyFK($table, $where, $Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE 1=1 $where;SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'deletebasicAgencyFK', $ex);
            return $ex;
        }
    }

    public function excecuteDatabaseStoredProcedures($function) {
        try {
            $query = "CALL $function";
            return YII::app()->db->createCommand($query)->queryAll();
        } catch (Exception $e) {
            $this->createLog('DatabaseUtilities', 'excecuteDatabaseStoredProcedures', $e);
            return $ex;
        }
    }

    public function excecuteDatabaseStoredProceduresQuery($function) {
        try {
            $query = "CALL $function";
            YII::app()->db->createCommand($query)->query();
            return "OK";
        } catch (Exception $e) {
            $this->createLog('DatabaseUtilities', 'excecuteDatabaseStoredProceduresQuery', $e);
            return $ex;
        }
    }

    public function excecuteQueryAll($query) {
        try {
            return YII::app()->db->createCommand($query)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'excecuteQueryAll', $ex);
            return $ex;
        }
    }

    public function ReplaceDelete($table, $columns, $values, $valuesuni, $columnsuni, $numbercolumns) {
        try {
            if ($numbercolumns > 1) {
                $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;";
                $sql .= "DELETE FROM $table WHERE CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            } else {
                $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;";
                $sql .= "DELETE FROM $table WHERE $columnsuni NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            }
            YII::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ReplaceDelete', $ex);
            return $ex;
        }
    }

    public function DeleteOldValues($table, $valuesuni, $columnsuni, $NumberColumns) {
        try {
            if ($NumberColumns > 1) {
                $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            } else {
                $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE $columnsuni NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            }
            YII::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'DeleteOldValues', $ex);
            return $ex;
        }
    }

    public function ReplaceWithAgency($table, $columns, $values, $Agency) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ReplaceWithAgency', $ex);
            return $ex;
        }
    }

    public function DeletebySaleZone($table, $columnsuni, $valuesuni, $SaleZone) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE CodZonaVentas='$SaleZone' AND CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            YII::app()->db->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'DeletebySaleZone', $ex);
            return $ex;
        }
    }

    public function DeletebyAgencyWithWhere($table, $columnsuni, $valuesuni, $Agency, $where, $NumberColumns) {
        try {
            if ($NumberColumns > 1) {
                $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE $where AND CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            } else {
                $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE $where AND $columnsuni NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            }
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'DeletebyAgencyWithWhere', $ex);
            return $ex;
        }
    }

    public function DeletebyAgencyAndSite($table, $columnsuni, $valuesuni, $Agency, $Site) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE CodigoSitio='$Site' AND CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExecuteQueryByAgency($sql, $Agency);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'DeletebyAgencyAndSite', $ex);
            return $ex;
        }
    }

    public function InsertInfoActiveAgency($sql) {
        try {
            $query = "SELECT CodAgencia FROM `agencia` WHERE Activo=1;";
            $Agencies = YII::app()->db->createCommand($query)->queryAll();
            foreach ($Agencies as $Agency) {
                $this->ExecuteQueryByAgency($sql, $Agency['CodAgencia']);
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'InsertInfoActiveAgency', $ex);
            return $ex;
        }
    }

    public function InsertInfoAgencyBusinessAdvisors($AsesorCode, $SalesZone, $Name, $agency) {
        try {
            $query = "SELECT CodAgencia FROM `agencia` WHERE Activo=1";
            $Agencies = YII::app()->db->createCommand($query)->queryAll();
            foreach ($Agencies as $Agency) {
                if ($Agency['CodAgencia'] == $agency) {
                    $sql = "SELECT COUNT(`CodAsesor`) AS CONT FROM `asesorescomerciales` WHERE `CodAsesor`='$AsesorCode'";
                    $exist = $this->GetDatosAgencia($sql, $agency);
                    if ($exist[0]['CONT'] > 0) {
                        $sql3 = "UPDATE `asesorescomerciales` SET `Clave`='$SalesZone',`Nombre`='$Name',`InfoActivity`=0,`IdPerfil`=3,`Agencia`='$agency' WHERE `CodAsesor`='$AsesorCode'";
                        $this->ExecuteQueryByAgency($sql3, $agency);
                    } else if ($exist[0]['CONT'] == 0) {
                        $sql2 = "SELECT MAX(`NuevaVersion`) AS lastversion FROM `asesorescomerciales`";
                        $version = $this->GetDatosAgenciaRow($sql2, $agency);
                        $sql3 = "INSERT INTO `asesorescomerciales`(`CodAsesor`,`Cedula`,`Clave`,`Nombre`,`Version`,`NuevaVersion`,`InfoActivity`,`IdPerfil`,`Agencia`) VALUES('$AsesorCode','$AsesorCode','$SalesZone','$Name','" . $version['lastversion'] . "','" . $version['lastversion'] . "',0,3,'$agency')";
                        $this->ExecuteQueryByAgency($sql3, $agency);
                    }
                    break;
                }
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'InsertInfoAgencyBusinessAdvisors', $ex);
            return $ex;
        }
    }

    public function ReplaceAllActiveAgencies($table, $columns, $values) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;SET FOREIGN_KEY_CHECKS=1;";
            return $this->InsertInfoActiveAgency($sql);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ReplaceAllActiveAgencies', $ex);
            return $ex;
        }
    }

    public function ReplaceAllActiveAgenciesWithGroup($table, $columns, $values, $group) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExcecuteQueryAllActiveAgenciesWithGroup($sql, $group);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ReplaceAllActiveAgenciesWithGroup', $ex);
            return $ex;
        }
    }

    public function DeleteAllActiveAgenciesWithGroup($table, $where, $columnsuni, $valuesuni, $group) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE $where='$group' AND CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            return $this->ExcecuteQueryAllActiveAgenciesWithGroup($sql, $group);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'DeleteAllActiveAgenciesWithGroup', $ex);
            return $ex;
        }
    }

    public function ExcecuteQueryAllActiveAgenciesWithGroup($sql, $group) {
        try {
            $query = "SELECT DISTINCT(G.`CodAgencia`) FROM `gruposventas` G INNER JOIN `agencia` A ON A.`CodAgencia`=G.`CodAgencia` WHERE A.`Activo`=1 AND G.`CodigoGrupoVentas`=" . $group;
            $Agencies = YII::app()->db->createCommand($query)->queryAll();
            foreach ($Agencies as $Agency) {
                $this->ExecuteQueryByAgency($sql, $Agency['CodAgencia']);
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ExcecuteQueryAllActiveAgenciesWithGroup', $ex);
            return $ex;
        }
    }

    public function InsertAllActiveAgencies($sqlcount, $sqlinsert, $sqlupdate) {
        try {
            $query = "SELECT CodAgencia FROM `agencia` WHERE Activo=1";
            $Agencies = YII::app()->db->createCommand($query)->queryAll();
            foreach ($Agencies as $Agency) {
                $cont = $this->GetDatosAgenciaScalar($sqlcount, $Agency['CodAgencia']);
                if ($cont == 0) {
                    $this->ExecuteQueryByAgency($sqlinsert, $Agency['CodAgencia']);
                } else {
                    $this->ExecuteQueryByAgency($sqlupdate, $Agency['CodAgencia']);
                }
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'InsertAllActiveAgencies', $ex);
            return $ex;
        }
    }

    public function ReplaceAllActiveAgenciesWithDelete($table, $columns, $values, $valuesuni, $columnsuni, $NumberColumns) {
        try {
            if ($NumberColumns > 1) {
                $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;";
                $sql .= "DELETE FROM $table WHERE CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            } else {
                $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $table ($columns) VALUES $values;";
                $sql .= "DELETE FROM $table WHERE $columnsuni NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            }
            return $this->InsertInfoActiveAgency($sql);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ReplaceAllActiveAgenciesWithDelete', $ex);
            return $ex;
        }
    }

    public function DeleteAllActiveAgencies($table, $valuesuni, $columnsuni, $NumberColumns) {
        try {
            if ($NumberColumns > 1) {
                $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE CONCAT($columnsuni) NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            } else if ($NumberColumns == 1) {
                $sql = "SET FOREIGN_KEY_CHECKS=0;DELETE FROM $table WHERE $columnsuni NOT IN ($valuesuni);SET FOREIGN_KEY_CHECKS=1;";
            }
            return $this->InsertInfoActiveAgency($sql);
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'DeleteAllActiveAgencies', $ex);
            return $ex;
        }
    }

    public function ExecuteQueryByAgency($sql, $agencia) {
        try {
            $sql = $this->Utf8encodedecode($sql);
            switch ($agencia) {
                case '000':
                    Yii::app()->db->createCommand($sql)->query();
                    break;
                case '001':
                    Yii::app()->Apartado->createCommand($sql)->query();
                    break;
                case '002':
                    Yii::app()->Bogota->createCommand($sql)->query();
                    break;
                case '003':
                    Yii::app()->Cali->createCommand($sql)->query();
                    break;
                case '004':
                    Yii::app()->Duitama->createCommand($sql)->query();
                    break;
                case '005':
                    Yii::app()->Ibague->createCommand($sql)->query();
                    break;
                case '006':
                    Yii::app()->Medellin->createCommand($sql)->query();
                    break;
                case '007':
                    Yii::app()->Monteria->createCommand($sql)->query();
                    break;
                case '008':
                    Yii::app()->Pasto->createCommand($sql)->query();
                    break;
                case '009':
                    Yii::app()->Pereira->createCommand($sql)->query();
                    break;
                case '010':
                    Yii::app()->Popayan->createCommand($sql)->query();
                    break;
                case '011':
                    Yii::app()->Villavicencio->createCommand($sql)->query();
                    break;
                default:
                    return "Not found Database";
                    break;
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ExecuteQueryByAgency', $ex);
            return $ex;
        }
    }

    public function ExecuteQueryByAgencyWithReplace($TableName, $ColumnsName, $values, $agencia) {
        try {
            $sql = "SET FOREIGN_KEY_CHECKS=0;Replace INTO $TableName ($ColumnsName) VALUES $values;SET FOREIGN_KEY_CHECKS=1;";
            switch ($agencia) {
                case '000':
                    Yii::app()->db->createCommand($sql)->query();
                    break;
                case '001':
                    Yii::app()->Apartado->createCommand($sql)->query();
                    break;
                case '002':
                    Yii::app()->Bogota->createCommand($sql)->query();
                    break;
                case '003':
                    Yii::app()->Cali->createCommand($sql)->query();
                    break;
                case '004':
                    Yii::app()->Duitama->createCommand($sql)->query();
                    break;
                case '005':
                    Yii::app()->Ibague->createCommand($sql)->query();
                    break;
                case '006':
                    Yii::app()->Medellin->createCommand($sql)->query();
                    break;
                case '007':
                    Yii::app()->Monteria->createCommand($sql)->query();
                    break;
                case '008':
                    Yii::app()->Pasto->createCommand($sql)->query();
                    break;
                case '009':
                    Yii::app()->Pereira->createCommand($sql)->query();
                    break;
                case '010':
                    Yii::app()->Popayan->createCommand($sql)->query();
                    break;
                case '011':
                    Yii::app()->Villavicencio->createCommand($sql)->query();
                    break;
                default:
                    return "Not found Database";
                    break;
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'ExecuteQueryByAgency', $ex);
            return $ex;
        }
    }

    public function GetDatosAgencia($sql, $agencia) {
        try {
            switch ($agencia) {
                case '000':
                    return Yii::app()->db->createCommand($sql)->queryAll();
                    break;
                case '001':
                    return Yii::app()->Apartado->createCommand($sql)->queryAll();
                    break;
                case '002':
                    return Yii::app()->Bogota->createCommand($sql)->queryAll();
                    break;
                case '003':
                    return Yii::app()->Cali->createCommand($sql)->queryAll();
                    break;
                case '004':
                    return Yii::app()->Duitama->createCommand($sql)->queryAll();
                    break;
                case '005':
                    return Yii::app()->Ibague->createCommand($sql)->queryAll();
                    break;
                case '006':
                    return Yii::app()->Medellin->createCommand($sql)->queryAll();
                    break;
                case '007':
                    return Yii::app()->Monteria->createCommand($sql)->queryAll();
                    break;
                case '008':
                    return Yii::app()->Pasto->createCommand($sql)->queryAll();
                    break;
                case '009':
                    return Yii::app()->Pereira->createCommand($sql)->queryAll();
                    break;
                case '010':
                    return Yii::app()->Popayan->createCommand($sql)->queryAll();
                    break;
                case '011':
                    return Yii::app()->Villavicencio->createCommand($sql)->queryAll();
                    break;
                default:
                    return "";
                    break;
            }
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'GetDatosAgencia', $ex);
            return $ex;
        }
    }

    public function GetDatosAgenciaRow($sql, $agencia) {
        try {
            switch ($agencia) {
                case '000':
                    return Yii::app()->db->createCommand($sql)->queryRow();
                    break;
                case '001':
                    return Yii::app()->Apartado->createCommand($sql)->queryRow();
                    break;
                case '002':
                    return Yii::app()->Bogota->createCommand($sql)->queryRow();
                    break;
                case '003':
                    return Yii::app()->Cali->createCommand($sql)->queryRow();
                    break;
                case '004':
                    return Yii::app()->Duitama->createCommand($sql)->queryRow();
                    break;
                case '005':
                    return Yii::app()->Ibague->createCommand($sql)->queryRow();
                    break;
                case '006':
                    return Yii::app()->Medellin->createCommand($sql)->queryRow();
                    break;
                case '007':
                    return Yii::app()->Monteria->createCommand($sql)->queryRow();
                    break;
                case '008':
                    return Yii::app()->Pasto->createCommand($sql)->queryRow();
                    break;
                case '009':
                    return Yii::app()->Pereira->createCommand($sql)->queryRow();
                    break;
                case '010':
                    return Yii::app()->Popayan->createCommand($sql)->queryRow();
                    break;
                case '011':
                    return Yii::app()->Villavicencio->createCommand($sql)->queryRow();
                    break;
                default:
                    return "";
                    break;
            }
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'GetDatosAgenciaRow', $ex);
            return $ex;
        }
    }

    public function GetDatosAgenciaScalar($sql, $agencia) {
        try {
            switch ($agencia) {
                case '000':
                    return Yii::app()->db->createCommand($sql)->queryScalar();
                    break;
                case '001':
                    return Yii::app()->Apartado->createCommand($sql)->queryScalar();
                    break;
                case '002':
                    return Yii::app()->Bogota->createCommand($sql)->queryScalar();
                    break;
                case '003':
                    return Yii::app()->Cali->createCommand($sql)->queryScalar();
                    break;
                case '004':
                    return Yii::app()->Duitama->createCommand($sql)->queryScalar();
                    break;
                case '005':
                    return Yii::app()->Ibague->createCommand($sql)->queryScalar();
                    break;
                case '006':
                    return Yii::app()->Medellin->createCommand($sql)->queryScalar();
                    break;
                case '007':
                    return Yii::app()->Monteria->createCommand($sql)->queryScalar();
                    break;
                case '008':
                    return Yii::app()->Pasto->createCommand($sql)->queryScalar();
                    break;
                case '009':
                    return Yii::app()->Pereira->createCommand($sql)->queryScalar();
                    break;
                case '010':
                    return Yii::app()->Popayan->createCommand($sql)->queryScalar();
                    break;
                case '011':
                    return Yii::app()->Villavicencio->createCommand($sql)->queryScalar();
                    break;
                default:
                    return "";
                    break;
            }
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'GetDatosAgenciaRow', $ex);
            return $ex;
        }
    }

    public function insertDatosAll($sql) {
        try {
            $sql = $this->Utf8encodedecode($sql);
            set_time_limit(-1);
            ini_set('max_execution_time', -1);
            ini_set('memory_limit', -1);
            Yii::app()->Apartado->createCommand($sql)->query();
            Yii::app()->Bogota->createCommand($sql)->query();
            Yii::app()->Cali->createCommand($sql)->query();
            Yii::app()->Duitama->createCommand($sql)->query();
            Yii::app()->Ibague->createCommand($sql)->query();
            Yii::app()->Medellin->createCommand($sql)->query();
            Yii::app()->Monteria->createCommand($sql)->query();
            Yii::app()->Pasto->createCommand($sql)->query();
            Yii::app()->Pereira->createCommand($sql)->query();
            Yii::app()->Popayan->createCommand($sql)->query();
            Yii::app()->Villavicencio->createCommand($sql)->query();
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('DatabaseUtilities', 'insertDatosAll', $ex);
            return $ex;
        }
    }

    public function SelectQueryRow($sql) {
        $datos = array();
        $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_001);
        $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_002);
        $dataReader_003 = Yii::app()->Cali->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_003);
        $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_004);
        $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_005);
        $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_006);
        $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_007);
        $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_008);
        $dataReader_009 = Yii::app()->Pereira->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_009);
        $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_010);
        $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_011);
        return $datos;
    }

}
