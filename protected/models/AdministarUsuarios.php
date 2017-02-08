<?php
/*
 * Conexion a la base de datos principal
 */

class AdministarUsuarios extends CActiveRecord {

    public static function model($className = __CLASS__) {       
        return parent::model($className);
    }

    public function getAgencias() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `agencia`";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getGrupoVentasAgencia($codigoAgencia) {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `gruposventas` WHERE `CodAgencia`='$codigoAgencia' GROUP BY  CodigoGrupoVentas";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getEliminarConfiguracion($id) {

        $connection = Yii::app()->db;
        $sql = "DELETE FROM `configuracionadministrador` WHERE `IdAdministrador` = '$id'";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->query();
        return $dataReader;
    }

    public function getVerificarConfiguracion($id) {


        $connection = Yii::app()->db;
        $sql = "SELECT COUNT(*) AS perimisoparaconceptos FROM `configuracionperfil` where IdPerfil = '$id' AND idListaLink  = '28' AND idAccion = '39'";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
     
    public function getConceptosNotasCredito($id) {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `conceptosnotacredito` WHERE Interfaz = '$id'";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->query();
        return $dataReader;
    }

    public function getEliminarConfiguracionConceptosNotasCredito($id) {

        $connection = Yii::app()->db;
        $sql = "DELETE FROM `configuracionconceptosnotascredito` WHERE `IdAdministrador` = '$id'";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->query();
        return $dataReader;
    }

    public function getProveedores() {

        $connection = Yii::app()->db;
        $sql = " SELECT * FROM `proveedores`";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getPerfilAprobacion() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `perfilesaprobacion`";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
    }
    
    public function getEstadoCorreo() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `estadoconfirmacion`";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
    }
    
    public function getEliminarConfiguracionAprobacionDocmuentos($id) {

        $connection = Yii::app()->db;
        $sql = "DELETE FROM `configuracionaprobaciondocumentos` WHERE `IdAdministrador` = '$id'";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->query();
        return $dataReader;
    }
     
}
