<?php

class LogEjecucionProcesos extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function createLog($class, $function, $e) {
        Yii::import('application.extensions.ActivityLog');
        $utility = new ActivityLog();
        $utility->createLog($class, $function, $e);
    }

    public function getAllExcecutedMethods() {
        try {
            $sql = "SELECT L.Id,M.NombreClase,L.Cedula,L.IdControlador,L.FechaInicio,L.HoraInicio,CONCAT(A.Nombres,' ',A.Apellidos) AS Nombre FROM `logprocesosusuarios` L INNER JOIN administrador A ON L.Cedula=A.Cedula LEFT JOIN `metodosactualizacionax` M ON M.Id=L.IdControlador WHERE FechaInicio=CURDATE();";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('LogEjecucionProcesos', 'getAllExcecutedMethods', $ex);
            return $ex;
        }
    }

    public function getLogProcessExcecutionDetail($id) {
        try {
            $sql = "SELECT M.NombreClase,CE.Fecha,CE.Hora,CE.Estado,CE.Orden,CE.Id FROM `ControlProcesoActualizacionEncabezado` CE INNER JOIN `metodosactualizacionax` M ON M.Id=CE.IdControlador WHERE"
                    . " CE.Fecha BETWEEN (SELECT FechaInicio FROM `logprocesosusuarios` WHERE Id=$id) AND (SELECT FechaFin FROM `logprocesosusuarios` WHERE Id=$id)"
                    . " AND CE.Hora>=(SELECT HoraInicio FROM `logprocesosusuarios` WHERE Id=$id) AND CE.Hora<=(SELECT HoraFin FROM `logprocesosusuarios` WHERE Id=$id)"
                    . " ORDER BY `CE`.`Orden` ASC";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('LogEjecucionProcesos', 'getLogProcessExcecutionDetail', $ex);
            return $ex;
        }
    }

    public function getLogProcessExcecutionDetailParameters($id) {
        try {
            $sql = "SELECT A.Nombre,C.Parametro FROM `ControlProcesoActualizacionDetalle` C INNER JOIN `agencia` A ON A.CodAgencia=C.Agencia WHERE C.IdEncabezado=$id ORDER BY C.`Id` ASC";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('LogEjecucionProcesos', 'getLogProcessExcecutionDetailParameters', $ex);
            return $ex;
        }
    }

    public function getQueryLogExcecutionProcess($fi,$ff) {
        try {
            $sql = "SELECT L.Id,M.NombreClase,L.Cedula,L.IdControlador,L.FechaInicio,L.HoraInicio,CONCAT(A.Nombres,' ',A.Apellidos) AS Nombre FROM `logprocesosusuarios` L INNER JOIN administrador A ON L.Cedula=A.Cedula LEFT JOIN `metodosactualizacionax` M ON M.Id=L.IdControlador WHERE FechaInicio BETWEEN '$fi' AND '$ff';";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            $this->createLog('LogEjecucionProcesos', 'getQueryLogExcecutionProcess', $ex);
            return $ex;
        }
    }

}
