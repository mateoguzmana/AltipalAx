<?php

class AdminQR extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createLog($class, $function, $e) {
        Yii::import('application.extensions.ActivityLog');
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    public function getAllAgencies() {
        try {
            $sql = "SELECT CodAgencia,Nombre FROM `agencia`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('AdminQR', 'getAllAgencies', $ex);
            return $ex;
        }
    }

    public function setStatusSaleGroup($saleGroup, $agency, $estado, $usuario) {
        try {
            $sql = "SELECT COUNT(`CodGruposVentas`) FROM `asignargruposdeventaqr` WHERE `CodGruposVentas`='$saleGroup'";
            $check = $this->QueryScalarByAgency($sql, $agency);
            if ($check > 0) {
                $sqlupdate = "UPDATE `asignargruposdeventaqr` SET `Fecha`=CURDATE(),`Hora`=CURTIME(),`Estado`=$estado,`Usuario`='$usuario' "
                        . "WHERE `CodGruposVentas`='$saleGroup'";
                return $this->QueryByAgency($sqlupdate, $agency);
            } else {
                $sqlins = "INSERT INTO `asignargruposdeventaqr`(`CodGruposVentas`,`Fecha`,`Hora`,`Estado`,`Usuario`) "
                        . "VALUES ('$saleGroup',CURDATE(),CURTIME(),$estado,'$usuario')";
                return $this->QueryByAgency($sqlins, $agency);
            }
        } catch (Exception $ex) {
            $this->createLog('AdminQR', 'setStatusSaleGroup', $ex);
            return $ex;
        }
    }

    public function GetSalesGroupByAgency($agency) {
        try {
            $sql = "SELECT CodigoGrupoVentas,NombreGrupoVentas FROM `gruposventas` WHERE CodAgencia='$agency'";
            return $this->QueryAllByAgency($sql, $agency);
        } catch (Exception $ex) {
            $this->createLog('AdminQR', 'GetSalesGroupByAgency', $ex);
            return $ex;
        }
    }

    public function GetSalesGroupStatus($agency) {
        try {
            $sql = "SELECT CodGruposVentas,Estado FROM `asignargruposdeventaqr`";
            return $this->QueryAllByAgency($sql, $agency);
        } catch (Exception $ex) {
            $this->createLog('AdminQR', 'GetSalesGroupStatus', $ex);
            return $ex;
        }
    }

    public function QueryAllByAgency($sql, $agency) {
        try {
            switch ($agency) {
                /* case '000':
                  return Yii::app()->db->createCommand($sql)->queryAll();
                  break; */
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
            $this->createLog('AdminQR', 'QueryAllByAgency', $ex);
            return $ex;
        }
    }

    public function QueryByAgency($sql, $agency) {
        try {
            switch ($agency) {
                /* case '000':
                  return Yii::app()->db->createCommand($sql)->queryAll();
                  break; */
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
                    return "";
                    break;
            }
            return "OK";
        } catch (Exception $ex) {
            $this->createLog('AdminQR', 'QueryByAgency', $ex);
            return $ex;
        }
    }

    public function QueryScalarByAgency($sql, $agency) {
        try {
            switch ($agency) {
                /* case '000':
                  return Yii::app()->db->createCommand($sql)->queryAll();
                  break; */
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
            $this->createLog('AdminQR', 'QueryScalarByAgency', $ex);
            return $ex;
        }
    }

}
