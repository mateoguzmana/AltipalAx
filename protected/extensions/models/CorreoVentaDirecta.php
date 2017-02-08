<?php

class CorreoVentaDirecta extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCorreosVentaDirecta() {        
        $sql = "SELECT confi.*,ag.Nombre as NombreAgencia FROM `configuracioncorreoventadirecta` confi INNER JOIN agencia as ag ON confi.CodAgencia=ag.CodAgencia ";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function geProveedores() {
        $sql = "SELECT confi.*,pro.NombreCuentaProveedor, ag.Nombre as NombreAgencia FROM `proveedoresventadirecta` confi INNER JOIN proveedores as pro ON confi.CodProveedor=pro.CodigoCuentaProveedor INNER JOIN agencia as ag ON confi.CodAgencia=ag.CodAgencia";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getAgencia() {
        $sql = "SELECT * FROM agencia";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getSelectProveedores() {
        $sql = "SELECT * FROM proveedores";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getProveedoresInsert($Nombre, $Apellido, $Correo, $agencia) {
        $sql = "INSERT INTO configuracioncorreoventadirecta (`Nombres`,`Apellidos`,`CorreoElectronico`,`CodAgencia`) VALUES ('$Nombre','$Apellido','$Correo','$agencia')";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function setGuardarProveedores($codProveedor, $codAgencia) {
        $sql = "INSERT INTO proveedoresventadirecta (`CodProveedor`, `CodAgencia`, `FechaRegistro`, `Estado`) VALUES ('$codProveedor','$codAgencia',CURDATE(),'1')";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function eliminarCorreo($id) {
        $sql = "DELETE FROM `configuracioncorreoventadirecta` WHERE Id = '$id'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function eliminarProveedor($id) {
        $sql = "DELETE FROM `proveedoresventadirecta` WHERE Id = '$id'";
        Yii::app()->db->createCommand($sql)->query();
    }

}
