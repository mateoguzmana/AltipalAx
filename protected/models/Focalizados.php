<?php

class Focalizados extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSemanas($ano = '', $mes = '') {
        if ($mes != "") {
            $sql = "SELECT * FROM `semanas` WHERE Ano = '$ano' AND Mes = '$mes'";
        } else {
            $sql = "SELECT * FROM `semanas`";
        }
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getSemanasMes($mes) {
        $sql = "SELECT COUNT(*) AS semanasingresadas FROM `semanas` WHERE  Mes = '$mes'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function InsertSemanas($ano, $mes, $semana, $fechaini, $fechafin, $usuario) {
        $sql = "INSERT INTO `semanas` (`Ano`, `Mes`, `Semana`, `FechaInicial`, `FechaFinal`, `Hora`, `Fecha`, `IdUsuario`) VALUES ('$ano','$mes','$semana','$fechaini','$fechafin',CURTIME(),CURDATE(),'$usuario') ";
        return Yii::app()->db->createCommand($sql)->query();
    }

    public function getDeleteSemana($id) {
        $sql = "DELETE FROM `semanas` WHERE `Id`='$id'";
        return Yii::app()->db->createCommand($sql)->query();
    }

    public function getSemanaYaResgistrada($ano, $mes, $semana) {
        $sql = "SELECT COUNT(*) AS semanayaregistrada FROM `semanas` WHERE  Mes='$mes' AND Ano='$ano' AND Semana = '$semana'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getFechasExistentes($fechaini, $fechafin) {
        $sql = "SELECT COUNT(*) AS FechasExistentes FROM `semanas` WHERE  FechaInicial='$fechaini' AND FechaFinal='$fechafin'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getAgencias($cedula) {
        $sql = "SELECT DISTINCT(ca.CodAgencia) as CodAgencia,agen.Nombre FROM `administrador` a
        Inner JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
        Inner JOIN agencia as agen on ca.CodAgencia=agen.CodAgencia WHERE `Cedula`='$cedula'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getClientesZona($agencia, $zona) {
        $sql = "SELECT cli.NombreCliente,cli.CuentaCliente FROM `cliente` cli INNER JOIN clienteruta clirut ON cli.CuentaCliente=clirut.CuentaCliente WHERE clirut.CodZonaVentas = '$zona' GROUP BY cli.CuentaCliente";
        $connection = new Multiple();
        $dataReader = $connection->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

    public function InsertEjecucionActividad($agencia, $zonas, $cliente, $fechaini, $fechafin, $descripcion, $inversion) {
        $sql = "INSERT INTO `ejecucionactividad`(`CodZonaVentas`, `CuentaCliente`, `Fechainicio`, `Fechafin`, `Descripcion`, `Inversion`, `Ejecucion`) "
                . "VALUES ('$zonas','$cliente','$fechaini','$fechafin','$descripcion','$inversion','0')";
        $connection = new Multiple();
        $dataReader = $connection->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getActividades($zona = '', $agencia, $cuantcliente = '') {
        if ($zona != "") {
            $sql = "SELECT * FROM `ejecucionactividad` where CodZonaVentas = '$zona'";
        } else if ($cuantcliente != "") {
            $sql = "SELECT * FROM `ejecucionactividad` where CuentaCliente = '$cuantcliente'";
        }
        $connection = new Multiple();
        $dataReader = $connection->consultaAgencia($agencia, $sql);
        return $dataReader;
    }

}
