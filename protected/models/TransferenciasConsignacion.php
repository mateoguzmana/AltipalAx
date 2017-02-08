<?php

class TransferenciasConsignacion extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function ConsultaAsesor($ZonaVentas) {
        $sql = "SELECT asesor.Nombre FROM zonaventas zona join asesorescomerciales asesor on zona.CodAsesor=asesor.CodAsesor WHERE zona.CodZonaVentas = '$ZonaVentas'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }
    
    
    public function getClientes($cliente){      
        $sql="SELECT `CuentaCliente`,`NombreCliente` FROM `cliente` WHERE `CuentaCliente` = '$cliente'";  
        return Yii::app()->db->createCommand($sql)->queryRow();
    }
    
    public function getProductoPortafolio($variantearticulo){
        $sql="SELECT p.NombreArticulo, p.CodigoCaracteristica1, p.CodigoCaracteristica2, p.CodigoTipo, p.`CodigoVariante`, p.CodigoArticulo, p.PorcentajedeIVA, p.ValorIMPOCONSUMO FROM `portafolio` p WHERE p.`CodigoVariante`='$variantearticulo' ";  
        return Yii::app()->db->createCommand($sql)->queryRow();        
    } 

}
