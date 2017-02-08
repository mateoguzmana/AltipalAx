<?php

/**
 * This is the model class for table "pruebaconexion".
 *
 * The followings are the available columns in table 'pruebaconexion':
 * @property integer $Id
 * @property string $Nombre
 */
class Multiple {

    public function multiConsulta($sql) {
        $cedula = Yii::app()->getUser()->getState('_cedula');
        $consulta = "SELECT DISTINCT(ca.CodAgencia) FROM `administrador` a Inner JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador WHERE `Cedula`='$cedula'";
        $datos = array();
        $dataReader = Yii::app()->db->createCommand($consulta)->queryAll();
        foreach ($dataReader as $item) {
            switch ($item['CodAgencia']) {
                case "001":
                    $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_001);
                    break;
                case "002":
                    $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_002);
                    break;
                case "003":
                    $dataReader_003 = Yii::app()->Cali->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_003);
                    break;
                case "004":
                    $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_004);
                    break;
                case "005":
                    $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_005);
                    break;
                case "006":
                    $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_006);
                    break;
                case "007":
                    $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_007);
                    break;
                case "008":
                    $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_008);
                    break;
                case "009":
                    $dataReader_009 = Yii::app()->Pereira->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_009);
                    break;
                case "010":
                    $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_010);
                    break;
                case "011":
                    $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_011);
                    break;
                default:
                    break;
            }
        }
        return $datos;
    }

    public function multiConsultaQuery($sql) {
        $datos = array();
        $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_001);
        $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_002);
        $dataReader_003 = Yii::app()->Cali->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_003);
        $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_004);
        $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_005);
        $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_006);
        $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_007);
        $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_008);
        $dataReader_009 = Yii::app()->Pereira->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_009);
        $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_010);
        $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_011);
        return $datos;
    }

    public function multiConsultaQueryRow($sql) {
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

    public function multiQuery($sql) {
        $datos = array();
        $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_001);
        $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_002);
        $dataReader_003 = Yii::app()->Cali->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_003);
        $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_004);
        $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_005);
        $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_006);
        $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_007);
        $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_008);
        $dataReader_009 = Yii::app()->Pereira->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_009);
        $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_010);
        $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->query();
        $datos = array_merge($datos, $dataReader_011);
        return $datos;
    }

    public function multiQueryFacturas($sql) {
        $datos = array();
        $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_001);
        $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_002);
        $dataReader_003 = Yii::app()->Cali->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_003);
        $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_004);
        $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_005);
        $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_006);
        $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_007);
        $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_008);
        $dataReader_009 = Yii::app()->Pereira->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_009);
        $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_010);
        $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->queryAll();
        $datos = array_merge($datos, $dataReader_011);
        return $datos;
    }

    public function consultaAgencia($agencia, $sql) {
        switch ($agencia) {
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
        }
        return "";
    }

    public function queryAgencia($agencia, $sql) {
        switch ($agencia) {
            case '001':
                return Yii::app()->Apartado->createCommand($sql)->query();
                break;
            case '002':
                return Yii::app()->Bogota->createCommand($sql)->query();
                break;
            case '003':
                return Yii::app()->Cali->createCommand($sql)->query();
                break;
            case '004':
                return Yii::app()->Duitama->createCommand($sql)->query();
                break;
            case '005':
                return Yii::app()->Ibague->createCommand($sql)->query();
                break;
            case '006':
                return Yii::app()->Medellin->createCommand($sql)->query();
                break;
            case '007':
                return Yii::app()->Monteria->createCommand($sql)->query();
                break;
            case '008':
                return Yii::app()->Pasto->createCommand($sql)->query();
                break;
            case '009':
                return Yii::app()->Pereira->createCommand($sql)->query();
                break;
            case '010':
                return Yii::app()->Popayan->createCommand($sql)->query();
                break;
            case '011':
                return Yii::app()->Villavicencio->createCommand($sql)->query();
                break;
        }
        return "";
    }

    public function consultaAgenciaRow($agencia, $sql) {
        switch ($agencia) {
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
        }
        return "";
    }

    public function getGrupoVentas() {
        $cedula = Yii::app()->getUser()->getState('_cedula');
        $consulta = "SELECT DISTINCT CodigoGrupoVentas FROM `administrador` a INNER JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador WHERE `Cedula`='$cedula'";
        return Yii::app()->db->createCommand($consulta)->queryAll();
    }

    public function getGrupoVentasAdminCartera($cedula) {
        $consulta = "SELECT CodigoGrupoVentas FROM `administrador` a INNER JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador WHERE `Cedula`='$cedula' GROUP BY(CodigoGrupoVentas)";
        return Yii::app()->db->createCommand($consulta)->queryAll();
    }

    public function getConcepto($cedula) {
        $consulta = "SELECT CodigoConceptoNotasCredito FROM `administrador` a INNER JOIN configuracionconceptosnotascredito ca ON a.Id=ca.IdAdministrador WHERE `Cedula`='$cedula' GROUP BY (CodigoConceptoNotasCredito)";
        return Yii::app()->db->createCommand($consulta)->queryAll();
    }

    public function getCodagenciaAdminCartera($cedula) {
        $consulta = "SELECT ag.codagencia FROM `administrador` a INNER JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
                INNER JOIN agencia ag ON ag.codagencia=ca.codagencia WHERE `Cedula`='$cedula' GROUP BY(codagencia)";
        return Yii::app()->db->createCommand($consulta)->queryAll();
    }

    public static function getConexionZonaVentas($zonaVentas = '') {
        if (!$zonaVentas) {
            $zonaVentas = Yii::app()->getUser()->getState('_zonaVentas');
        }
        $sql = "SELECT CodAgencia FROM `zonaventasglobales` WHERE `CodZonaVentas`='$zonaVentas'";
        $dataReader = Yii::app()->db->createCommand($sql)->queryRow();
        switch ($dataReader['CodAgencia']) {
            case '001':
                return Yii::app()->Apartado;
                break;
            case '002':
                return Yii::app()->Bogota;
                break;
            case '003':
                return Yii::app()->Cali;
                break;
            case '004':
                return Yii::app()->Duitama;
                break;
            case '005':
                return Yii::app()->Ibague;
                break;
            case '006':
                return Yii::app()->Medellin;
                break;
            case '007':
                return Yii::app()->Monteria;
                break;
            case '008':
                return Yii::app()->Pasto;
                break;
            case '009':
                return Yii::app()->Pereira;
                break;
            case '010':
                return Yii::app()->Popayan;
                break;
            case '011':
                return Yii::app()->Villavicencio;
                break;
            default:
                break;
        }
    }

    public function multiConsultaProceso48($sql, $cedula) {
        echo $consulta = "SELECT DISTINCT(ca.CodAgencia) FROM `administrador` a INNER JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador WHERE `Cedula`='$cedula'";
        $datos = array();
        $dataReader = Yii::app()->db->createCommand($consulta)->queryAll();
        foreach ($dataReader as $item) {
            switch ($item['CodAgencia']) {
                case "001":
                    $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_001);
                    break;
                case "002":
                    $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_002);
                    break;
                case "003":
                    $dataReader_003 = Yii::app()->Cali->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_003);
                    break;
                case "004":
                    $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_004);
                    break;
                case "005":
                    $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_005);
                    break;
                case "006":
                    $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_006);
                    break;
                case "007":
                    $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_007);
                    break;
                case "008":
                    $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_008);
                    break;
                case "009":
                    $dataReader_009 = Yii::app()->Pereira->createCommand($sql) > queryAll();
                    $datos = array_merge($datos, $dataReader_009);
                    break;
                case "010":
                    $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_010);
                    break;
                case "011":
                    $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->queryAll();
                    $datos = array_merge($datos, $dataReader_011);
                    break;
                default:
                    break;
            }
        }
        return $datos;
    }

    public function getNombreUsuario($username) {
        $consulta = "SELECT CONCAT( Nombres, ' ', Apellidos ) AS Nombre FROM `administrador` WHERE `Usuario`='$username'";
        return Yii::app()->db->createCommand($consulta)->queryAll();
    }

    public function getNombreProveedor($cuentaProvedor) {
        $consulta = "SELECT NombreCuentaProveedor FROM `proveedores` WHERE `CodigoCuentaProveedor`='$cuentaProvedor'";
        return Yii::app()->db->createCommand($consulta)->queryAll();
    }

    public function getAgencias($cedula) {
        $consulta = "SELECT DISTINCT ca.CodAgencia From configuracionadministrador ca INNER JOIN administrador a ON ca.IdAdministrador=a.id WHERE a.cedula='$cedula'";
        $dataReader = Yii::app()->db->createCommand($consulta)->queryAll();
        $agencias = array();
        foreach ($dataReader as $d) {
            array_push($agencias, $d['CodAgencia']);
        }
        return $agencias;
    }

}
