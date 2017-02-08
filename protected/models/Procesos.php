<?php

class Procesos extends AgenciaActiveRecord {

    private $gruposVentas;

    public function getDbConnection() {
        return self::setConexion();
    }

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function AdministradoresCartera() {

        $connection = Yii::app()->db;
        $sql = "SELECT * FROM `administrador` where IdPerfil = '29'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function NotasCreditosSinAprobar48($cedula) {

        try {

            $consulta = new Multiple();

            $this->gruposVentas = $consulta->getGrupoVentasAdminCartera($cedula);

            $cadena = "";
            foreach ($this->gruposVentas as $item) {

                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }

            $cadena = substr($cadena, 0, -4);

            $sql = "SELECT * FROM `notascredito` nota  
        INNER JOIN zonaventas AS z ON nota.CodZonaVentas=z.CodZonaVentas
        INNER JOIN gruposventas AS gv ON z.CodigoGrupoVentas=gv.CodigoGrupoVentas
        WHERE  nota.Autoriza = '0' AND nota.ArchivoXml = '' AND ($cadena)";
            $dataReader = $consulta->multiConsultaProceso48($sql, $cedula);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function DescuentosSinAprobar48($cedula) {

        try {

            $consulta = new Multiple();

            $this->gruposVentas = $consulta->getGrupoVentasAdminCartera($cedula);

            $cadena = "";
            foreach ($this->gruposVentas as $item) {

                $cadena.= "gv.CodigoGrupoVentas=" . $item['CodigoGrupoVentas'] . " || ";
            }

            $cadena = substr($cadena, 0, -4);

            $sql = "SELECT * FROM `pedidos` p INNER JOIN descripcionpedido dsp ON p.IdPedido=dsp.IdPedido INNER JOIN  gruposventas gv ON p.CodGrupoVenta=gv.CodigoGrupoVentas WHERE ($cadena) AND  dsp.DsctoEspecial > 0 AND p.Estado = '1' AND p.ArchivoXml = ''";
            $dataReader = $consulta->multiConsultaProceso48($sql, $cedula);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

    public function FestivosTimeAaout($fecha_com, $nuevafecha) {

        $connection = Yii::app()->db;
        $sql = "SELECT Fechas FROM `festivostimeout` WHERE `Fechas`>='$fecha_com' AND `Fechas`<='$nuevafecha'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function UpdateNotaCredito($id, $agencia) {

        try {

            $consulta = new Multiple();
            $sql = "UPDATE `notascredito` SET `Estado`='3',`Autoriza`='0' WHERE `IdNotaCredito`='$id'";
            $dataReader = $consulta->queryAgencia($agencia, $sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }

      public function UpdatePedidoDescuento($id, $agencia) {

        try {

            $consulta = new Multiple();
            $sql = "UPDATE `pedidos` SET `Estado`='3' WHERE `IdPedido`='$id'";
            $dataReader = $consulta->queryAgencia($agencia, $sql);
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    
}
