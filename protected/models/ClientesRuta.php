<?php

class ClientesRuta extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function ContarNoventas($cuentacliente, $fechamsg, $horamsg) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT COUNT(*) as noventas FROM `noventas` WHERE `CuentaCliente` = '$cuentacliente' AND `FechaNoVenta` >= '$fechamsg' AND HoraNoVenta > '$horamsg'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function ContarPedidos($cuentacliente, $fechamsg, $horamsg) {

        $connection = Multiple::getConexionZonaVentas();
        //$sql = "SELECT COUNT(*) as pedidos FROM `pedidos` WHERE CuentaCliente = '$cuentacliente' AND FechaPedido >= '$fechamsg' AND HoraEnviado > '$horamsg' ";
        $sql ="SELECT COUNT( * ) AS pedidos FROM  `pedidos` WHERE CuentaCliente =  '$cuentacliente' AND ( FechaPedido >  '$fechamsg' OR ( FechaPedido =  '$fechamsg'AND HoraEnviado >  '$horamsg'))";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function TerminarRuta($zonaventas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT * FROM mensajes where IdMensaje IN(SELECT MAX(IdMensaje) FROM mensajes where mensaje = 'Termino Ruta' AND IdRemitente = '$zonaventas')";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function ContarNoventasRutaSinTerminar($cuentacliente, $zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT COUNT(*) as noventas FROM `noventas` WHERE `CuentaCliente` = '$cuentacliente' AND IdentificadorEnvio ='1' AND FechaNoVenta = CURDATE() AND CodZonaVentas='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function ContarPedidosRutaSinTerminar($cuentacliente, $zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT COUNT(*) as pedidos FROM `pedidos` WHERE CuentaCliente = '$cuentacliente' AND IdentificadorEnvio = '1' AND FechaPedido = CURDATE() AND CodZonaVentas='$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
    
   
     public function getGrupoVentasAsesor($CedulaAsesor) {

        try {
            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT CodigoGrupoVentas FROM `zonaventas` WHERE CodAsesor = '$CedulaAsesor'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }           
    

    public function getEncuestas($sitio,$grupoVentas) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * 
            FROM  `tituloencuesta` titu
            INNER JOIN encuestasitio encusitio ON titu.IdTitulo = encusitio.IdTituloEncuesta
            WHERE encusitio.Sitio =  '$sitio' AND encusitio.GrupoVentas = '$grupoVentas' AND encusitio.Estado = '1' AND titu.Tipo = '1' AND titu.FechaInicio <= CURDATE() AND titu.FechaFin >= CURDATE()";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    
    public function getEncuestasOpcionales($sitio,$grupoVentas) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * 
            FROM  `tituloencuesta` titu
            INNER JOIN encuestasitio encusitio ON titu.IdTitulo = encusitio.IdTituloEncuesta
            WHERE encusitio.Sitio =  '$sitio' AND encusitio.GrupoVentas = '$grupoVentas' AND encusitio.Estado = '1' AND titu.Tipo = '0'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    
    public function getClienteEncuestado($CuentaCliente,$idEncuesta){
       
        try {
            $connection = Yii::app()->db;
            $sql = "SELECT COUNT(*) as clienteencuestado FROM `clientesencuestados` where CuentaCliente = '$CuentaCliente' AND IdEncuesta = '$idEncuesta'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
        
    }




    public function getAsignarEncusesta($CuentaCliente,$idEncuesta){
       
       try {
            $connection = Yii::app()->db;
            $sql = "SELECT COUNT(*) AS encuestaasignada FROM `clientesasignarencuesta` where CuentaCliente = '$CuentaCliente' AND IdEncuesta = '$idEncuesta'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
        
        
    }

    public function getPreguntasEncuesta($idPreguntaSiguiente = '',$idEncuesta) {

        if ($idPreguntaSiguiente != "") {

            //traigo la siguiente pregunta
            
            try {
                $connection = Yii::app()->db;
                $sql = "SELECT * FROM `preguntasencuestas` where IdPregunta = '$idPreguntaSiguiente' AND IdTituloEncuesta = '$idEncuesta'";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
                return $dataReader;
            } catch (Exception $ex) {

                echo $ex->getMessage('Error');
                return false;
            }
        } else {
            
            //traigo la primera pregunta
            
            try {
                $connection = Yii::app()->db;
                $sql = "SELECT * FROM `preguntasencuestas` WHERE  IdTituloEncuesta = '$idEncuesta'  LIMIT 1";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
                return $dataReader;
            } catch (Exception $ex) {

                echo $ex->getMessage('Error');
                return false;
            }
        }
    }

    public function getRespuestas($idPregunta) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM  `respuestasencuesta` WHERE IdPreguntaEncuesta =  '$idPregunta'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }
    }
    
    public function InsertImagenesEncuestas($idEncuesta,$idPregunta,$idBloque,$nombre,$fecha,$hora){
        
       try {
            $connection = Yii::app()->db;
            $sql = "INSERT INTO `imagenesencuestas`(`IdEncuesta`, `IdPregunta`, `IdBloque`, `Nombre`, `FechaEnvio`, `HoraEnvio`) VALUES ('$idEncuesta','$idPregunta','$idBloque','$nombre','$fecha','$hora')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }  
        
    }
    
    public function getfotosPreguntas($idEncuesta,$IdPregunta){
        
      try {
            $connection = Yii::app()->db;
            $sql = "SELECT Nombre FROM `imagenesencuestas` WHERE IdEncuesta = '$idEncuesta' AND IdPregunta = '$IdPregunta'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
            return false;
        }     
        
    }

}
