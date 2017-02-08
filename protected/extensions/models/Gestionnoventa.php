<?php

/**
 * This is the model class for table "Gestionnoventas".
 *
 * The followings are the available columns in table 'mensajes':
 * @property integer $IdMensaje
 * @property string $IdDestinatario
 * @property string $IdRemitente
 * @property string $FechaMensaje
 * @property string $HoraMensaje
 * @property string $Mensaje
 * @property string $Estado
 */
class Gestionnoventa extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function ContarNoventas($cuentacliente) {        
        $sql = "SELECT COUNT(*) as noventas FROM `noventas` WHERE `CuentaCliente`='$cuentacliente' AND `FechaNoVenta`=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

    public function ContarPedidos($cuentacliente) {        
        $sql = "SELECT COUNT(*) as pedidos FROM `pedidos` WHERE CuentaCliente='$cuentacliente' AND FechaPedido=CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryRow();
    }

}
