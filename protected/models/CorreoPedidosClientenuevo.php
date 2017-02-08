<?php

class CorreoPedidosClientenuevo extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCorreosPedidosClientenuevo() {
        $connection = Yii::app()->db;
        $sql = "SELECT correos.*,ag.Nombre as NombreAgencia FROM `correospedidosclientenuevo` correos INNER JOIN agencia as ag ON correos.CodAgencia=ag.CodAgencia GROUP BY correos.Id";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();

        return $dataReader;
    }

    public function gePedidoMaximo() {
        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `pedidomaximoclientenuevo`";
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

    public function getCorreoInfoInsert($Nombre, $Apellido, $Correo, $agencia) {

        $connection = Yii::app()->db;
        $sql = "INSERT INTO correospedidosclientenuevo (`Nombre`, `Apellidos`, `CorreoElectronico`, `CodAgencia`, `Estado`) VALUES ('$Nombre','$Apellido','$Correo','$agencia', '1')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function eliminarCorreo($id) {

        $connection = Yii::app()->db;
        $sql = "DELETE FROM `correospedidosclientenuevo` WHERE Id = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function consultarRegistro($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `correospedidosclientenuevo` WHERE Id = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getCorreoInfoUpdate($Nombre, $Apellido, $Correo, $agencia, $estado, $id) {

        $connection = Yii::app()->db;
        $sql = "UPDATE correospedidosclientenuevo SET `Nombre` = '$Nombre', `Apellidos` = '$Apellido', `CorreoElectronico` = '$Correo', `CodAgencia` = '$agencia', `Estado` = '$estado' WHERE Id = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    public function consultarRegistroValor() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `pedidomaximoclientenuevo` LIMIT 1";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getValorInfoUpdate($usuario, $valor, $id) {

        $connection = Yii::app()->db;
        $sql = "UPDATE pedidomaximoclientenuevo SET `Valor` = '$valor', `Fecha` = CURDATE(), `Hora` = CURTIME(), `IdUsuario` = '$usuario' WHERE Id = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

}
