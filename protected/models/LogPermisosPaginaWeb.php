<?php

class LogPermisosPaginaWeb extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createLog($class, $function, $e) {
        Yii::import('application.extensions.ActivityLog');
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    public function getAllPermissionsLogs() {
        try {
            $sql = "SELECT L.`Cedula`,L.`Fecha`,CONCAT(A.`Nombres`,' ',A.`Apellidos`) AS Nombre,P.CodZonaVentas,P.FechaInicial,P.FechaFinal,P.Observacion,AG.Nombre as Agencia FROM `logpermisosweb` L INNER JOIN `permisospaginaweb` P ON P.`Id`=L.`Id` INNER JOIN `administrador` A ON A.Cedula=L.Cedula INNER JOIN agencia AG ON AG.CodAgencia=P.CodAgencia WHERE L.`Fecha`=CURDATE()";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('LogEjecucionProcesos', 'getAllPermissionsLogs', $ex);
            return $ex;
        }
    }

    public function getQueryLogPermissions($fi,$ff) {
        try {
            $sql = "SELECT L.`Cedula`,L.`Fecha`,CONCAT(A.`Nombres`,' ',A.`Apellidos`) AS Nombre,P.CodZonaVentas,P.FechaInicial,P.FechaFinal,P.Observacion,AG.Nombre as Agencia FROM `logpermisosweb` L INNER JOIN `permisospaginaweb` P ON P.`Id`=L.`Id` INNER JOIN `administrador` A ON A.Cedula=L.Cedula INNER JOIN agencia AG ON AG.CodAgencia=P.CodAgencia WHERE L.`Fecha` BETWEEN '$fi' AND '$ff';";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('LogEjecucionProcesos', 'getQueryLogPermissions', $ex);
            return $ex;
        }
    }

}
