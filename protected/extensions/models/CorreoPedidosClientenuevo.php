<?php

class CorreoPedidosClientenuevo extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCorreosPedidosClientenuevo() {
        $sql = "SELECT correos.*,ag.Nombre as NombreAgencia FROM `correospedidosclientenuevo` correos INNER JOIN agencia as ag ON correos.CodAgencia=ag.CodAgencia GROUP BY correos.Id";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function gePedidoMaximo() {
        $sql = "SELECT * FROM `pedidomaximoclientenuevo`";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getAgencia() {
        $sql = "SELECT * FROM agencia";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function getCorreoInfoInsert($Nombre, $Apellido, $Correo, $agencia) {
        $sql = "INSERT INTO correospedidosclientenuevo (`Nombre`,`Apellidos`,`CorreoElectronico`,`CodAgencia`,`Estado`) VALUES ('$Nombre','$Apellido','$Correo','$agencia', '1')";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function eliminarCorreo($id) {
        $sql = "DELETE FROM `correospedidosclientenuevo` WHERE Id='$id'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function consultarRegistro($id) {
        $sql = "SELECT * FROM `correospedidosclientenuevo` WHERE Id='$id'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getCorreoInfoUpdate($Nombre, $Apellido, $Correo, $agencia, $estado, $id) {
        $sql = "UPDATE correospedidosclientenuevo SET `Nombre`='$Nombre',`Apellidos`='$Apellido',`CorreoElectronico`='$Correo',`CodAgencia`='$agencia',`Estado`='$estado' WHERE Id='$id'";
        Yii::app()->db->createCommand($sql)->query();
    }

    public function consultarRegistroValor() {
        $sql = "SELECT * FROM `pedidomaximoclientenuevo` LIMIT 1";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function getValorInfoUpdate($usuario, $valor, $id) {
        $sql = "UPDATE pedidomaximoclientenuevo SET `Valor`='$valor',`Fecha`=CURDATE(),`Hora`=CURTIME(),`IdUsuario`='$usuario' WHERE Id='$id'";
        Yii::app()->db->createCommand($sql)->query();
    }

}
