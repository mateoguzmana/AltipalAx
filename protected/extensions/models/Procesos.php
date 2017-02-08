<?php

class Procesos extends AgenciaActiveRecord {

    public function getDbConnection() {
        return self::setConexion();
    }

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function AdministradoresCartera() {        
        $sql = "SELECT * FROM `administrador` where IdPerfil='29'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function NotasCreditosSinAprobar48($cedula) {
        try {
            $gruposVentas = $consulta->getGrupoVentasAdminCartera($cedula);
            $cadena = "";
            foreach ($gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas='" . $item['CodigoGrupoVentas'] . "' || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT * FROM `notascredito` nota  
                INNER JOIN zonaventas AS z ON nota.CodZonaVentas=z.CodZonaVentas
                INNER JOIN gruposventas AS gv ON z.CodigoGrupoVentas=gv.CodigoGrupoVentas
                WHERE  nota.Autoriza='0' AND nota.ArchivoXml='' AND ($cadena)";
            return Multiple::multiConsultaProceso48($sql, $cedula);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function DescuentosSinAprobar48($cedula) {
        try {
            $this->gruposVentas = $consulta->getGrupoVentasAdminCartera($cedula);
            $cadena = "";            foreach ($this->gruposVentas as $item) {
                $cadena.= "gv.CodigoGrupoVentas='" . $item['CodigoGrupoVentas'] . "' || ";
            }
            $cadena = substr($cadena, 0, -4);
            $sql = "SELECT * FROM `pedidos` p INNER JOIN descripcionpedido dsp ON p.IdPedido=dsp.IdPedido INNER JOIN  gruposventas gv ON p.CodGrupoVenta=gv.CodigoGrupoVentas WHERE ($cadena) AND  dsp.DsctoEspecial > 0 AND p.Estado = '1' AND p.ArchivoXml = ''";
            return Multiple::multiConsultaProceso48($sql, $cedula);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function FestivosTimeAaout($fecha_com, $nuevafecha) {        
        $sql = "SELECT Fechas FROM `festivostimeout` WHERE `Fechas`>='$fecha_com' AND `Fechas`<='$nuevafecha'";
        return Yii::app()->db->createCommand($sql)->queryRow();
    }

    public function UpdateNotaCredito($id, $agencia) {
        try {
            $sql = "UPDATE `notascredito` SET `Estado`='3',`Autoriza`='0' WHERE `IdNotaCredito`='$id'";
            return Multiple::queryAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }

      public function UpdatePedidoDescuento($id, $agencia) {
        try {
            $sql = "UPDATE `pedidos` SET `Estado`='3' WHERE `IdPedido`='$id'";
            return Multiple::queryAgencia($agencia, $sql);
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    
}
