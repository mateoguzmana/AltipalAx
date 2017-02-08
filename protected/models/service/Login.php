<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class Login extends ConexionActive {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function getJerarquia($identificacion) {
        $sql = "SELECT COUNT(*) AS Conteo FROM `jerarquiacomercial` WHERE NumeroIdentidad='" . $identificacion . "';";
        $respuesta = Yii::app()->db->createCommand($sql)->queryRow();

        $sqlU = "SELECT NombreEmpleado FROM `jerarquiacomercial` WHERE NumeroIdentidad='" . $identificacion . "';";
        $nombre = Yii::app()->db->createCommand($sqlU)->queryRow();
        $json = array(
            'respuesta' => $respuesta,
            'nombre' => $nombre
        );
        $datos = array();
        array_push($datos, $json);
        $subArray = array('Jerarquia' => $datos);
        return json_encode($subArray);
    }

    public function countUserLogion($usuario, $contrasena, $db) {
        $multiple = new Multiple();
        $sql = "SELECT COUNT(a.CodAsesor) AS Conteo FROM `asesorescomerciales` AS a INNER JOIN zonaventas AS z ON a.CodAsesor=z.CodAsesor WHERE z.CodZonaVentas='" . $usuario . "' AND a.Clave='" . $contrasena . "';";
        $prod = $multiple->consultaAgenciaRow($db, $sql);
        return $prod['Conteo'];
    }

    public function getInfoUser($usuario, $contrasena, $db) {
        $multiple = new Multiple();
        $sqlU = "SELECT a.Nombre,a.NuevaVersion,z.FechaRetiro,z.CodAsesor,ag.Id FROM `asesorescomerciales` AS a INNER JOIN zonaventas AS z ON a.CodAsesor=z.CodAsesor INNER JOIN agencia AS ag ON ag.CodAgencia=a.Agencia WHERE z.CodZonaVentas='" . $usuario . "' AND a.Clave='" . $contrasena . "';";
        $resultadoU = $multiple->consultaAgenciaRow($db, $sqlU);
        return $resultadoU;
    }

    public function getLastVersionApp($db) {
        $multiple = new Multiple();
        $sqlVe = "SELECT MAX(NuevaVersion) AS max FROM `asesorescomerciales`";
        $max_version = $multiple->consultaAgenciaRow($db, $sqlVe);
        if (empty($max_version)) {
            $max_version = '0';
        }
        return $max_version;
    }

    public function updateVersionUser($agencia, $max_version, $codigoAsesor, $contrasena, $callMetod, $version) {
        try {
            if ($callMetod == 1) {
                $sql = "UPDATE `asesorescomerciales` SET `NuevaVersion`='" . $max_version . "' WHERE CodAsesor='" . $codigoAsesor . "' AND Clave='" . $contrasena . "'; ";
            } else {
                $sql = "UPDATE `asesorescomerciales` SET `Version`='" . $version . "',`FechaVersion`= CURDATE(),`HoraVersion`= CURTIME() WHERE CodAsesor='" . $codigoAsesor . "' AND Clave='" . $contrasena . "';";
            }
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function countZonaventas($usuario, $db) {
        $multiple = new Multiple();
        $sql = "SELECT COUNT(*) AS Conteo FROM zonaventas  WHERE CodZonaVentas='" . $usuario . ";";
        $prod = $multiple->consultaAgenciaRow($db, $sql);
        return $prod['Conteo'];
    }
}
