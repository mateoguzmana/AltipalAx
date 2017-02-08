<?php

class CorreoVentaDirecta extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCorreosVentaDirecta() {
        $connection = Yii::app()->db;
        $sql = "SELECT confi.*,ag.Nombre as NombreAgencia FROM `configuracioncorreoventadirecta` confi INNER JOIN agencia as ag ON confi.CodAgencia=ag.CodAgencia ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        return $dataReader;
    }

    public function geProveedores() {
        $connection = Yii::app()->db;
        $sql = "SELECT confi.*,pro.NombreCuentaProveedor, ag.Nombre as NombreAgencia FROM `proveedoresventadirecta` confi INNER JOIN proveedores as pro ON confi.CodProveedor=pro.CodigoCuentaProveedor INNER JOIN agencia as ag ON confi.CodAgencia=ag.CodAgencia";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        return $dataReader;
    }

    public function getAgencia() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM agencia";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getSelectProveedores() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM proveedores";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getProveedoresInsert($Nombre, $Apellido, $Correo, $agencia) {

        $connection = Yii::app()->db;
        $sql = "INSERT INTO configuracioncorreoventadirecta (`Nombres`, `Apellidos`, `CorreoElectronico`, `CodAgencia`) VALUES ('$Nombre','$Apellido','$Correo','$agencia')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function setGuardarProveedores($codProveedor, $codAgencia) {

        $connection = Yii::app()->db;
        $sql = "INSERT INTO proveedoresventadirecta (`CodProveedor`, `CodAgencia`, `FechaRegistro`, `Estado`) VALUES ('$codProveedor','$codAgencia',CURDATE(),'1')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function eliminarCorreo($id) {

        $connection = Yii::app()->db;
        $sql = "DELETE FROM `configuracioncorreoventadirecta` WHERE Id = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function eliminarProveedor($id) {

        $connection = Yii::app()->db;
        $sql = "DELETE FROM `proveedoresventadirecta` WHERE Id = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

}
