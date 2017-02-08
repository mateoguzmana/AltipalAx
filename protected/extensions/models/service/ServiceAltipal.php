<?php

/**
 * This is the model class for table "bancos".
 *
 * The followings are the available columns in table 'bancos':
 * @property integer $CodBanco
 * @property string $Nombre
 * @property integer $IdentificadorBanco
 *
 * The followings are the available model relations:
 * @property Cuentasbancarias[] $cuentasbancariases
 */
class ServiceAltipal extends CActiveRecord {

    public static function model($className = __CLASS__) {
        Yii::import('application.extensions.multiple.Multiple');
        return parent::model($className);
    }

    public function insertDatosGlobal($cadena) {

        try {
            $connection = Yii::app()->db;
            $command = $connection->createCommand($cadena);
            $dataReader = $command->query();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function QueryRowGlobal($cadena) {

        try {
            $connection = Yii::app()->db;
            $command = $connection->createCommand($cadena);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function AgenciaGlobal() {

        try {
            $connection = Yii::app()->db;

            $sql = "SELECT DISTINCT(CodAgencia) FROM `zonaventasglobales` WHERE CodAgencia <> '000'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getZonaVentasGlo() {

        try {
            $connection = Yii::app()->db;

            $sql = "SELECT CodZonaVentas FROM `zonaventasglobales`";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertErroresInser($cadena) {

        try {
            $connection = Yii::app()->db;

            $sql = "INSERT INTO `errorestransacciones`(`Mensaje`, `Fecha`, `Hora`) VALUES ('$cadena',CURDATE(),CURTIME())";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertProcesosIndividuales($cadena, $status, $identificadorproceso, $identificadorestado) {

        try {
            $connection = Yii::app()->db;

            $sql = "INSERT INTO `logprocesosindividuales`(`Proceso`, `Status`, `Fecha`, `Hora`, `IdentificadorProceso`, `IdentificadorEstado`) VALUES ('$cadena','$status',CURDATE(),CURTIME(),'$identificadorproceso','$identificadorestado')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertProcesosIndividuales2($cadena, $status, $identificadorproceso, $identificadorestado, $nameServe) {

        try {
            $connection = Yii::app()->db;

            $sql = "INSERT INTO `logprocesosindividuales`(`Proceso`, `Status`, `Fecha`, `Hora`, `IdentificadorProceso`, `IdentificadorEstado`, `NombreServidor`) VALUES ('$cadena','$status',CURDATE(),CURTIME(),'$identificadorproceso','$identificadorestado', '$nameServe')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function GetSitios($agencia) {

        try {


            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {
                $connection = Yii::app()->Bogota;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {
                $connection = Yii::app()->Cali;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {
                $connection = Yii::app()->Duitama;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {
                $connection = Yii::app()->Medellin;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {
                $connection = Yii::app()->Monteria;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '008') {
                $connection = Yii::app()->Pasto;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {
                $connection = Yii::app()->Pereira;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {
                $connection = Yii::app()->Popayan;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {
                $connection = Yii::app()->Villavicencio;
                $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosAll($cadena) {

        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);

        $connection = Yii::app()->Bogota;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Cali;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Medellin;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Apartado;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Duitama;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Ibague;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Monteria;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Pasto;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Pereira;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Popayan;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Villavicencio;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();
    }

    public function insertDatosAllGlobal($cadena) {

        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);

        $connection = Yii::app()->db;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Apartado;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Bogota;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Cali;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Duitama;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Ibague;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Medellin;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Monteria;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Pasto;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Pereira;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Popayan;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();

        $connection = Yii::app()->Villavicencio;
        $command = $connection->createCommand($cadena);
        $dataReader = $command->query();
    }

    public function SelectQueryRow($sql) {

        $datos = array();

        $connection = Yii::app()->Apartado;
        $command = $connection->createCommand($sql);
        $dataReader_004 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_004);

        $connection = Yii::app()->Bogota;
        $command = $connection->createCommand($sql);
        $dataReader_001 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_001);

        $connection = Yii::app()->Cali;
        $command = $connection->createCommand($sql);
        $dataReader_003 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_003);

        $connection = Yii::app()->Duitama;
        $command = $connection->createCommand($sql);
        $dataReader_005 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_005);

        $connection = Yii::app()->Ibague;
        $command = $connection->createCommand($sql);
        $dataReader_006 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_006);

        $connection = Yii::app()->Medellin;
        $command = $connection->createCommand($sql);
        $dataReader_002 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_002);

        $connection = Yii::app()->Monteria;
        $command = $connection->createCommand($sql);
        $dataReader_007 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_007);

        $connection = Yii::app()->Pasto;
        $command = $connection->createCommand($sql);
        $dataReader_008 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_008);

        $connection = Yii::app()->Pereira;
        $command = $connection->createCommand($sql);
        $dataReader_009 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_009);

        $connection = Yii::app()->Popayan;
        $command = $connection->createCommand($sql);
        $dataReader_010 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_010);

        $connection = Yii::app()->Villavicencio;
        $command = $connection->createCommand($sql);
        $dataReader_011 = $command->queryRow();
        $datos = array_merge($datos, $dataReader_011);


        return $datos;
    }

    public function insertDatosAgencia($cadena, $agencia) {

        try {
            $sql = $cadena;

            if ($agencia == '000') {
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
        } catch (Exception $ex) {
            
        }
    }

    public function insertDatos($CodigoSitio) {


        try {

            $sql = $CodigoSitio;

            $connection = Yii::app()->Apartado;
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();

            return $dataReader;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgenciaZona($zonaVentas) {

        $connection = Yii::app()->db;
        $sql = "SELECT `CodAgencia` FROM `zonaventasglobales` WHERE `CodZonaVentas`='$zonaVentas' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader['CodAgencia'];
    }

    public function getCodigoAsesorZona($zonaVentas) {

        $connection = Yii::app()->db;
        $sql = "SELECT `CodAsesor` FROM `zonaventas` WHERE `CodZonaVentas`='$zonaVentas' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader['CodAsesor'];
    }

    public function getUltimaVersion() {

        $connection = Yii::app()->db;
        $sql = "SELECT MAX(`Version`) AS UltimaVersion FROM `versiones`";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader['UltimaVersion'];
    }

    public function getVersionActualZona($codigoasesor, $agencia) {
        try {
            $sql = "SELECT `Version` FROM `asesorescomerciales` WHERE `CodAsesor`='$codigoasesor';";
            if ($agencia == '000') {
                $connection = Yii::app()->db;
                $command = $connection->createCommand($sql);
                //$dataReader = $command->query();
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
                return $dataReader['Version'];
            }
        } catch (Exception $ex) {
            
        }
    }

    public function setAgenciaInsert($sql) {

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $dataReader = $command->query();
        return $dataReader;
    }

    /* public function insertDatos($cadena, $agencia) {


      if($agencia=="001"){

      $sql = $agencia;

      $connection = Yii::app() -> Cali;
      $command = $connection -> createCommand($sql);
      $dataReader = $command -> query();

      $connection = Yii::app() -> Cali;
      $command = $connection -> createCommand($sql);
      $dataReader = $command -> query();


      $connection = Yii::app() -> Cali;
      $command = $connection -> createCommand($sql);
      $dataReader = $command -> query();

      }



      } */

    public function ConsultaDatosGlobal() {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `transaccionesax` WHERE EstadoTransaccion = '0'";
        $dataReader = $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    public function ConsultaDatosGlobalDocumento($tipoDocumento) {
        $consulta = new Multiple();
        $sql = "SELECT * FROM `transaccionesax` WHERE EstadoTransaccion = '0' AND CodTipoDocumentoActivity = '" . $tipoDocumento . "'; ";
        $dataReader = $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    public function consultaGruposAgencia() {

        $consulta = new Multiple();
        $sql = "SELECT CodigoGrupoVentas,CodAgencia FROM `gruposventas` where CodigoGrupoVentas<>'000' GROUP BY CodigoGrupoVentas,CodAgencia";
        $dataReader = $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    public function getClientesNuevos($idCliente, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `clientenuevo` as clinu join transaccionesax as transax on clinu.Id=transax.IdDocumento  WHERE Id = '$idCliente' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND clinu.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCodHomologacion($CodTipoDocumento) {

        $consulta = new Multiple();
        $sql = "SELECT CodigoTipoRegistro,CodigoTipoContribuyente FROM homologaciontiposdocumento WHERE CodigoTipoDocumento = '$CodTipoDocumento'";
        $dataReader = $consulta->multiConsultaQuery($sql);
        return $dataReader;
    }

    public function getUpdateEstado($idCliente, $tipDoc, $agencia, $repuestaAx) {

        try {
            $sql = "Update `clientenuevo` as clinu join transaccionesax as transax on clinu.Id=transax.IdDocumento SET clinu.Estado = '1',transax.`EstadoTransaccion` ='1',clinu.ArchivoXml='$repuestaAx' WHERE Id = '$idCliente' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getDevolucionesService($idDevolciones, $idTipoDoc, $agencia) {

        try {

            $sql = "SELECT * FROM `devoluciones` as devolu join transaccionesax as transax on devolu.IdDevolucion=transax.IdDocumento  WHERE devolu.IdDevolucion = '$idDevolciones' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND devolu.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getDescripcionDevolucionesService($idDevolciones, $agencia) {

        try {
            $sql = "SELECT * FROM `descripciondevolucion` where IdDevolucion = '$idDevolciones' AND Autoriza = '1' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoDevoluciones($idDevolcuiones, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `devoluciones` as devoluci join transaccionesax as transax on devoluci.IdDevolucion=transax.IdDocumento SET devoluci.Estado = '1',transax.`EstadoTransaccion` ='1',devoluci.ArchivoXml='$repuestaAx' WHERE IdDevolucion = '$idDevolcuiones' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getNotasCreditos($idNotasCredito, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `notascredito` as nota join transaccionesax as transax on nota.IdNotaCredito=transax.IdDocumento  WHERE nota.IdNotaCredito = '$idNotasCredito' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND nota.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoNotasCredito($idNotasCredito, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `notascredito` as nota join transaccionesax as transax on nota.IdNotaCredito=transax.IdDocumento SET nota.Estado = '1',transax.`EstadoTransaccion` ='1',nota.ArchivoXml='$repuestaAx' WHERE nota.IdNotaCredito = '$idNotasCredito' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getConsignacionVendedor($idConsignacion, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `consignacionesvendedor` as consigvendedor join transaccionesax as transax on consigvendedor.IdConsignacion=transax.IdDocumento  WHERE consigvendedor.IdConsignacion = '$idConsignacion' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND consigvendedor.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoConsignacionVendedor($idConsignacion, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `consignacionesvendedor` as consigvendedor join transaccionesax as transax on consigvendedor.IdConsignacion=transax.IdDocumento SET consigvendedor.Estado = '1',transax.`EstadoTransaccion` ='1',consigvendedor.ArchivoXml='$repuestaAx' WHERE consigvendedor.IdConsignacion = '$idConsignacion' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCobros($idCobro, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `norecaudos` as recaudos join transaccionesax as transax on recaudos.Id=transax.IdDocumento  WHERE recaudos.Id = '$idCobro' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND recaudos.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCobrosDetalle($idCobro, $agencia) {

        try {

            $sql = "SELECT * FROM  norecaudosdetalle WHERE IdNoCaudo = '$idCobro'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoCobro($idCobro, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `norecaudos` as recaudos join transaccionesax as transax on recaudos.Id=transax.IdDocumento SET recaudos.Estado = '1',transax.`EstadoTransaccion` ='1',recaudos.ArchivoXml='$repuestaAx' WHERE recaudos.Id = '$idCobro' AND transax.CodTipoDocumentoActivity = '$tipDoc'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaConsignacionService($idTransfereciaConsignacion, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `transferenciaconsignacion` as transconsigna join transaccionesax as transax on transconsigna.IdTransferencia=transax.IdDocumento  WHERE transconsigna.IdTransferencia = '$idTransfereciaConsignacion' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND transconsigna.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaConsignacionNit($cuentaCliente, $agencia) {

        try {
            $sql = "SELECT Identificacion FROM `cliente` where CuentaCliente = '$cuentaCliente'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaConsignacionDescripcion($idTransfereciaConsignacion, $Agencia) {

        $consulta = new Multiple();
        $sql = "SELECT * FROM `descripciontransferenciaconsignacion` WHERE `IdTransferencia` = '$idTransfereciaConsignacion'";
        $dataReader = $consulta->consultaAgencia($Agencia, $sql);
        return $dataReader;
    }

    public function getUpdateEstadoTransfeConsignacion($idTransfereciaConsignacion, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `transferenciaconsignacion` as transfereconsig join transaccionesax as transax on transfereconsig.IdTransferencia=transax.IdDocumento SET transfereconsig.Estado = '1',transax.`EstadoTransaccion` ='1',transfereconsig.ArchivoXml='$repuestaAx' WHERE transfereconsig.IdTransferencia = '$idTransfereciaConsignacion' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaAutoventaService($idTransfereciaAutoventa, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `transferenciaautoventa` as transauto join transaccionesax as transax on transauto.IdTransferenciaAutoventa=transax.IdDocumento  WHERE transauto.IdTransferenciaAutoventa = '$idTransfereciaAutoventa' AND  transax.CodTipoDocumentoActivity = '$idTipoDoc' AND transauto.Estado = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getDescripcionTrnasAtoventaService($idTransfereciaAutoventa, $agencia) {

        try {
            $sql = "SELECT * FROM `descripciontransferenciaautoventa` WHERE `IdTransferenciaAutoventa` = '$idTransfereciaAutoventa'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoTransfeAutoventa($idTransfereciaAutoventa, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `transferenciaautoventa` as transfereautoventa join transaccionesax as transax on transfereautoventa.IdTransferenciaAutoventa=transax.IdDocumento SET transfereautoventa.Estado = '1',transax.`EstadoTransaccion` ='1',transfereautoventa.ArchivoXml='$repuestaAx' WHERE transfereautoventa.IdTransferenciaAutoventa = '$idTransfereciaAutoventa' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getPedidoPreventaService($idPedido, $idTipoDoc, $agencia) {

        try {

            //     $sql = "SELECT * FROM `pedidos` as pe join transaccionesax as transax on pe.IdPedido=transax.IdDocumento WHERE pe.IdPedido = '$idPedido' AND transax.CodTipoDocumentoActivity = '$idTipoDoc' AND pe.Estado = '0' ";
            $sql = "SELECT * FROM `pedidos` as pe join transaccionesax as transax on pe.IdPedido=transax.IdDocumento WHERE pe.IdPedido = '$idPedido' AND transax.CodTipoDocumentoActivity = '$idTipoDoc'  ";
            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getPedidoDescuentoAprovado($idDetallePedido, $agencia) {

        try {

            $sql = "SELECT * FROM  `descripcionpedido` descripPedi join aprovacionpedido aproPedi on descripPedi.Id=aproPedi.IdDetallePedido where aproPedi.IdDetallePedido = '$idDetallePedido'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getDetallePedidoPreventaService($idPedido, $agencia) {

        try {

            $sql = "SELECT DISTINCT descrpedido.*, proveeax.*
FROM descripcionpedido AS descrpedido
LEFT JOIN proveedoresestrategicosenvioax AS proveeax ON descrpedido.CuentaProveedor = proveeax.CuentaProveedor
INNER JOIN `portafolio` AS porta ON descrpedido.`CodVariante` = porta.`CodigoVariante`
INNER JOIN `jerarquiaarticulos` AS jerarti ON porta.`CodigoGrupoCategoria` = jerarti.`Nombre`
WHERE IdPedido = '$idPedido'
GROUP BY descrpedido.`CodVariante`
ORDER BY IF( proveeax.Item IS NULL , 1, 0 ) , proveeax.Item, proveeax.CuentaProveedor, porta.`CodigoGrupoCategoria` ASC , jerarti.`IdPrincipal` ASC, porta.`CodigoMarca` ASC ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getPedidoDetalleKidService($idDescripcionPedido, $agencia) {

        try {

            $sql = "SELECT * FROM `kitdescripcionpedido` WHERE `IdDescripcionPedido` = '$idDescripcionPedido' AND Cantidad > 0";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadopPedido($idPedido, $tipDoc, $agencia, $repuestaAx) {


        try {
            //$sql = "Update `pedidos` as pe join transaccionesax as transax on pe.IdPedido=transax.IdDocumento SET pe.Estado = '1',transax.`EstadoTransaccion` ='1',pe.ArchivoXml='$repuestaAx' WHERE pe.IdPedido = '$idPedido' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";
            $sql = "set @variable = (SELECT p.`ArchivoXml` FROM `pedidos` p WHERE p.IdPedido = '$idPedido');
                
                    Update `pedidos` as pe 
                    join transaccionesax as transax on pe.IdPedido=transax.IdDocumento 
                    SET pe.Estado = '1',
                    transax.`EstadoTransaccion` = '1',
                    pe.ArchivoXml = CONCAT(@variable, '$repuestaAx')
                    WHERE pe.IdPedido = '$idPedido' AND transax.CodTipoDocumentoActivity = '$tipDoc'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadopPedidoNoEnvio($idPedido, $tipDoc, $agencia, $repuestaAx) {


        try {
            $sql = "Update `pedidos` SET ArchivoXml='$repuestaAx' WHERE IdPedido = '$idPedido'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    /*     * **************************************************************************************** */

    public function getReciboCajaService($idRecibo, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento WHERE recibo.Id = '$idRecibo' AND transax.CodTipoDocumentoActivity = '$idTipoDoc' AND recibo.Estado = '0' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboCajaServiceCheque($idRecibo, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento WHERE recibo.Id = '$idRecibo' AND transax.CodTipoDocumentoActivity = '$idTipoDoc'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getDetallereciboCaja($idRecibo, $agencia) {

        try {

            $sql = "SELECT * FROM  reciboscajafacturas WHERE IdReciboCaja = '$idRecibo'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboChequeConsigVendedor($IdReciboConsignacionVendedor, $agencia) {

        try {
            $sql = "SELECT * FROM `consignacionchequesvendedor` WHERE `IdConsignacionVendedor` = '$IdReciboConsignacionVendedor'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboChequeConsig($IdReciboCajaFacturas, $agencia) {

        try {
            $sql = "SELECT chequeconsig.`Id` as IdConsignacion,recicajaFactura.`NumeroFactura`,`NroConsignacionCheque`, `CodBanco`, `CodCuentaBancaria`, `Fecha`,'001' FROM `reciboschequeconsignacion` as chequeconsig join reciboscajafacturas as recicajaFactura on recicajaFactura.Id=chequeconsig.IdReciboCajaFacturas WHERE chequeconsig.IdReciboCajaFacturas = '$IdReciboCajaFacturas'";


            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getChequeConsignacionDetalle($idReciboChequeConsignacion, $agencia) {

        try {
            $sql = "SELECT rcbcheDetalle.*,recicajafac.NumeroFactura FROM `reciboschequeconsignaciondetalle` rcbcheDetalle join reciboschequeconsignacion recichecon on recichecon.Id=rcbcheDetalle.IdRecibosChequeConsignacion join reciboscajafacturas recicajafac on recichecon.IdReciboCajaFacturas=recicajafac.Id where rcbcheDetalle.IdRecibosChequeConsignacion = '$idReciboChequeConsignacion'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboEfectivo($IdReciboCajaFacturas, $agencia) {

        try {
            $sql = "SELECT *,'005' FROM `recibosefectivo` as efectivo join reciboscajafacturas as recibocajafactu on recibocajafactu.Id=efectivo.IdReciboCajaFacturas WHERE IdReciboCajaFacturas ='$IdReciboCajaFacturas'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboEfectivoConsig($IdReciboCajaFactura, $agencia) {

        try {
            $sql = "SELECT *,'004' FROM `recibosefectivoconsignacion`  as efectivoconsig join reciboscajafacturas as reciboCajaFactu on reciboCajaFactu.Id=efectivoconsig.IdReciboCajaFacturas  WHERE IdReciboCajaFacturas = '$IdReciboCajaFactura'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getFechas($idReciboCajaFactura, $agencia) {

        try {
            $sql = "SELECT factu.FechaFactura,factu.FechaVencimientoFactura,reci.Fecha FROM `reciboscajafacturas` as recifactu join facturasaldo as factu on recifactu.NumeroFactura=factu.NumeroFactura join reciboscaja as reci on recifactu.IdReciboCaja=reci.Id where recifactu.Id = '$idReciboCajaFactura' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function consultarResponsableAsesor($responsableAsesor, $agencia) {

        try {
            $sql = "SELECT Nombre FROM `asesorescomerciales` where CodAsesor = '$responsableAsesor'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function consultarResponsable($responsable, $agencia) {

        try {
            $sql = "SELECT NombreEmpleado FROM `jerarquiacomercial` WHERE NumeroIdentidad = '$responsable'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getPaymentReference($idReciboChequeConsignacion, $agencia) {

        try {
            $sql = "SELECT * FROM `reciboschequeconsignacion` WHERE `Id` = '$idReciboChequeConsignacion'";

            $manejador = fopen('Consulta.txt', 'a+');
            fputs($manejador, $sql . "\n");
            fclose($manejador);

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoRecibos($idRecibo, $tipDoc, $agencia, $repuestaAx) {

        try {
            $sql = "Update `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento SET recibo.Estado = '1',transax.`EstadoTransaccion` ='1',recibo.ArchivoXml='$repuestaAx' WHERE recibo.Id = '$idRecibo' AND transax.CodTipoDocumentoActivity = '$tipDoc'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    ////********************************************/////

    public function getReciboCajaChequePostService($idRecibo, $idTipoDoc, $agencia) {

        try {
            $sql = "SELECT * FROM `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento WHERE recibo.Id = '$idRecibo' AND transax.CodTipoDocumentoActivity = '$idTipoDoc' AND recibo.EstadoChequePosfechado = '0' ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getInfoChequePosEncabezado($IdReciboCaja, $agencia) {

        try {
            $sql = "SELECT  cheque.Id,cheque.NroCheque,cheque.Fecha,cheque.CuentaCheque,cheque.Posfechado,cheque.CodBanco FROM reciboscaja as caja join `reciboscajafacturas` as reci on caja.Id=reci.IdReciboCaja join reciboscheque as cheque on reci.Id=cheque.IdReciboCajaFacturas  where caja.Id = '$IdReciboCaja' AND cheque.Posfechado = '1' GROUP BY cheque.NroCheque,cheque.CodBanco";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getInfoChequeEncabezado($IdReciboCaja, $agencia) {

        try {
            $sql = "SELECT  cheque.Id,cheque.NroCheque,cheque.Fecha,cheque.CuentaCheque,cheque.Posfechado,cheque.CodBanco FROM reciboscaja as caja join `reciboscajafacturas` as reci on caja.Id=reci.IdReciboCaja join reciboscheque as cheque on reci.Id=cheque.IdReciboCajaFacturas  where caja.Id = '$IdReciboCaja' AND cheque.Posfechado = '0' GROUP BY cheque.NroCheque,cheque.CodBanco";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getInfoChequeDetalle($IdReciboCajaFactura, $NoCheque, $agencia) {

        try {
            $sql = "SELECT reci.CuentaCliente,reci.NumeroFactura,cheque.Valor,cheque.ValorTotal FROM reciboscaja as caja join `reciboscajafacturas` as reci on caja.Id=reci.IdReciboCaja join reciboscheque as cheque on reci.Id=cheque.IdReciboCajaFacturas  where  caja.Id = '$IdReciboCajaFactura' and cheque.NroCheque = '$NoCheque'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoChquesPosfechados($idRecibo, $tipDoc, $agencia, $repuestaAx) {

        try {
            $sql = "UPDATE  
            `reciboscaja` rc
            INNER JOIN transaccionesax AS transax ON transax.IdDocumento = rc.Id
            INNER JOIN reciboscajafacturas rcf ON rcf.IdReciboCaja=rc.Id 
            INNER JOIN  reciboscheque rcc ON rcc.IdReciboCajaFacturas=rcf.Id

            SET rc.EstadoChequePosfechado = '1',
            transax.`EstadoTransaccion` = '1', 
            rcc.ArchivoXml = '$repuestaAx' 

            WHERE rc.Id='$idRecibo' AND rcc.Posfechado='1' AND transax.CodTipoDocumentoActivity = '$tipDoc' 
            AND transax.EstadoTransaccion = '0'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->query();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function insertDatos001($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `CodAgencia`='" . $agencia . "' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesPaqueteMasivoZonas($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacion`='0' AND `CodAgencia`='" . $agencia . "' ORDER BY CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesCupoCredito($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionCupoCredito`='0' AND `CodAgencia`='" . $agencia . "' ORDER BY CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesFacturasSaldo($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturaSaldo`='0' AND `CodAgencia`='" . $agencia . "' ORDER BY CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesFacturasTransacciones($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturasTransacciones`='0' AND `CodAgencia`='" . $agencia . "' ORDER BY CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesPendientesFacturar($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPendientesFacturar`='0' AND `CodAgencia`='" . $agencia . "' ORDER BY CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesPresupuestoVentas($agencia) {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPresupuesto`='0' AND `CodAgencia`='" . $agencia . "' ORDER BY CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantes() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacion`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesCupos() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionCupoCredito`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesFacturas() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturaSaldo`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesPresupuesto() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPresupuesto`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesPendientesFacturar() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPendientesFacturar`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesFacturasTransacciones() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturasTransacciones`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getAgenciasGlobales() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT DISTINCT(`CodAgencia`) FROM `zonaventasglobales` WHERE CodAgencia<>'000'; ";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getAgenciasSitiosGlobales() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT  DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `CodAgencia`<>'000' ORDER BY CodAgencia ASC;";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getSitiosGlobales() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `zonaventasglobales` WHERE 1";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getGruposGlobales() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT DISTINCT (`CodigoGrupoVentas`) FROM `gruposventas` ";
            //$sql = "SELECT DISTINCT (`CodigoGrupoVentas`) FROM `gruposventas` WHERE `CodigoGrupoVentas` = '032' ";
            //$sql = "SELECT DISTINCT (`CodigoGrupoVentas`) FROM `gruposventas` WHERE (`CodigoGrupoVentas`='013' OR `CodigoGrupoVentas`='017' OR `CodigoGrupoVentas`='019' OR `CodigoGrupoVentas`='023')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getGruposGlobalesFaltantes() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT DISTINCT (`CodigoGrupoVentas`) FROM `gruposventas` WHERE `EstadoActualizacionGrupoVenta` = '0'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getGruposVentas2($agencia) {

        try {
            $sql = "SELECT CodigoGrupoVentas,CodAgencia FROM `gruposventas` where CodigoGrupoVentas<>'000' GROUP BY CodigoGrupoVentas,CodAgencia";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCountDetallePedidos($idPedido, $agencia) {

        try {
            $sql = "SELECT COUNT(*) AS detallepedido FROM descripcionpedido where IdPedido = '$idPedido'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCountDevoluciones($iddevolucion, $agencia) {

        try {
            $sql = "SELECT COUNT(*) as devolucionesdetalle FROM `descripciondevolucion` WHERE `IdDevolucion` = '$iddevolucion' AND `Autoriza` = '1'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getDatosClienteNuevo($cuentaCliente, $agencia) {

        try {


            $sql = "SELECT * FROM `clientenuevo` WHERE `ArchivoXml`='" . $cuentaCliente . "' ORDER BY `Id` DESC LIMIT 1; ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function InsertClienteNuevo($cuentaCliente, $identificacion, $nombre, $razonSocial, $direccion, $telefono, $telefonoMovil, $email, $estado, $codigoCadena, $codigoBarrio, $codigoPostal, $latitud, $longitud, $agencia) {
        try {
            $sql = "INSERT INTO `cliente`(`CuentaCliente`, `Identificacion`, `NombreCliente`, `NombreBusqueda`, `DireccionEntrega`, `Telefono`, `TelefonoMovil`, `CorreoElectronico`, `Estado`, `CodigoCadenaEmpresa`, `CodigoBarrio`, `CodigoPostal`, `Latitud`, `Longitud`) 
	VALUES ('" . $cuentaCliente . "','" . $identificacion . "','" . $nombre . "','" . $razonSocial . "','" . $direccion . "','" . $telefono . "','" . $telefonoMovil . "','" . $email . "','" . $estado . "','" . $codigoCadena . "','" . $codigoBarrio . "','" . $codigoPostal . "','" . $latitud . "','" . $longitud . "'); ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCadenaEmpresa($codigo, $agencia) {

        try {
            $sql = "SELECT * FROM `cadenaempresa` WHERE `CodigoCadenaEmpresa` ='" . $codigo . "'; ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getGrupoImpuestos($tipoDocumento, $barrio, $agencia) {

        try {
            $sql = "SELECT h.CodigoGrupoImpuestos FROM `homologaciongrupoimpuestos` AS h INNER JOIN homologaciontiposdocumento AS hd ON h.CodigoTipoContribuyente = hd.CodigoTipoContribuyente INNER JOIN Localizacion AS l ON h.CodigoCiudad = l.CodigoCiudad AND h.CodigoDepartamento = l.CodigoDepartamento WHERE l.CodigoBarrio ='" . $barrio . "' AND hd.CodigoTipoDocumento = '" . $tipoDocumento . "' LIMIT 1; ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            $codigoGrupoImpuesto = "";
            foreach ($dataReader as $it) {
                $codigoGrupoImpuesto = $it['CodigoGrupoImpuestos'];
            }
            return $codigoGrupoImpuesto;
        } catch (Exception $ex) {
            
        }
    }

    public function InsertClienteNuevoRuta($zonasVentas, $cuentaCliente, $numero, $posicion, $codigoZonaLogistica, $valorCupo, $cupoTemporal, $saldo, $codigoPago, $diasGracia, $adicionales, $formaPago, $descuentoLinea, $descuentoMultilinea, $grupoImpuestos, $codigoPrecio, $agencia) {
        try {
            //$numero = $numero +1;
            $sql = "INSERT INTO `clienteruta`(`CodZonaVentas`, `CuentaCliente`, `NumeroVisita`, `Posicion`, `CodigoZonaLogistica`, `ValorCupo`, `ValorCupoTemporal`, `SaldoCupo`, `CodigoCondicionPago`, `DiasGracia`, 
                `DiasAdicionales`, `CodigoFormadePago`, `CodigoGrupoDescuentoLinea`, `CodigoGrupoDescuentoMultiLinea`, `CodigoGrupodeImpuestos`, `CodigoGrupoPrecio`) VALUES ('" . $zonasVentas . "','" . $cuentaCliente . "','" . $numero . "','" . $posicion . "','" . $codigoZonaLogistica . "','" . $valorCupo . "','" . $cupoTemporal . "','" . $saldo . "','" . $codigoPago . "','" . $diasGracia . "','" . $adicionales . "','" . $formaPago . "','" . $descuentoLinea . "','" . $descuentoMultilinea . "','" . $grupoImpuestos . "','" . $codigoPrecio . "'); ";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getCorreosProceso() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `correosproceso`";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getCorreosProcesoActivity() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `correosproceso` WHERE `EnviaCorreoActivity`='1'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getCorreosProcesoResumenProceso() {

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `correosproceso` WHERE EnviaCorreoResumen='1'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreo() {

        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM  `erroresactualizacion` WHERE ((Fecha='$fechaConsulta' AND Hora>='23:00:00') or (Fecha=curdate())) AND MensajeActivity NOT IN ('Error Proceso Clientes Nuevos') AND ServicioSRF NOT IN ('Servicio Activity','Facturas Transacciones','Pendientes por Facturar','Presupuesto de Ventas','Paquete Masivo Zonas')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoActivity() {

        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM  `erroresactualizacion` WHERE ((Fecha='$fechaConsulta' AND Hora>='23:00:00') or (Fecha=curdate())) AND ServicioSRF IN ('Servicio Activity')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoZonas() {

        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM  `erroresactualizacion` WHERE ((Fecha='$fechaConsulta' AND Hora>='23:00:00') or (Fecha=curdate())) AND ServicioSRF IN ('Facturas Transacciones','Pendientes por Facturar','Presupuesto de Ventas')";

            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoResumenProceso() {
        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));

        try {
            $connection = Yii::app()->db;
            //$sql = "SELECT * FROM  `logprocesosindividuales` WHERE ((Fecha='$fechaConsulta' AND `Hora`>='01:00:00') OR Fecha = CURDATE( )) AND `IdentificadorEstado`='1' ORDER BY `Id`";
            $sql = "SELECT * FROM  `logprocesosindividuales` WHERE (Fecha = CURDATE( )) AND `IdentificadorEstado`='1' ORDER BY `Id`";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoResumenProcesoIndividual($identificadorproceso) {
        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));

        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM  `logprocesosindividuales` WHERE ((Fecha='$fechaConsulta' AND `Hora`>='23:00:00') OR (Fecha = CURDATE() AND `Hora`<='06:00:00')) AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='" . $identificadorproceso . "' ORDER BY `Id`";
            //$sql = "SELECT * FROM  `logprocesosindividuales` WHERE (Fecha = CURDATE( )) AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='".$identificadorproceso."' ORDER BY `Id`";			
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoResumenProcesoIndividualError($identificadorproceso) {
        //$fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM  `logprocesosindividuales` WHERE (Fecha='CURDATE()' AND `Hora`>='23:00:00') AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='" . $identificadorproceso . "' ORDER BY `Id`";
            //$sql = "SELECT * FROM  `logprocesosindividuales` WHERE (Fecha = CURDATE( )) AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='".$identificadorproceso."' ORDER BY `Id`";			
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoVerificacionProcesoIndividual($columna, $zona) {
        try {
            $connection = Yii::app()->db;
            $sql = "SELECT `" . $columna . "` FROM `zonaventasglobales` WHERE `CodZonaVentas`='" . $zona . "'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function VerificarClientesNuevos() {

        try {
            $connection = Yii::app()->db;

            $sql = "SELECT Identificador,CodigoTipoDocumento,IdClienteVerificado FROM `clienteverificado` WHERE Estado = '0' ORDER BY IdClienteVerificado LIMIT 1";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getCuentalienteFactura($numerofactura, $agencia) {

        try {
            $sql = "SELECT CuentaCliente FROM `facturasaldo` where NumeroFactura = '$numerofactura'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboCheque($IdReciboCajaFacturas, $agencia) {

        try {
            $sql = "SELECT * FROM `reciboscheque` as cheque join `reciboscajafacturas` as reciCaja on reciCaja.Id=cheque.IdReciboCajaFacturas WHERE IdReciboCajaFacturas = '$IdReciboCajaFacturas'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryAll();
            }
            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function getSaldoLimiteAcuardoLinea($idAcuerdoLinea, $agencia) {

        try {
            $sql = "SELECT `Saldo` FROM `acuerdoscomercialesdescuentolinea` WHERE `IdAcuerdoComercial` = '$idAcuerdoLinea'";

            if ($agencia == '001') {
                $connection = Yii::app()->Apartado;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '002') {

                $connection = Yii::app()->Bogota;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '003') {

                $connection = Yii::app()->Cali;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '004') {

                $connection = Yii::app()->Duitama;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '005') {
                $connection = Yii::app()->Ibague;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '006') {

                $connection = Yii::app()->Medellin;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '007') {

                $connection = Yii::app()->Monteria;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }


            if ($agencia == '008') {

                $connection = Yii::app()->Pasto;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '009') {

                $connection = Yii::app()->Pereira;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '010') {

                $connection = Yii::app()->Popayan;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            if ($agencia == '011') {

                $connection = Yii::app()->Villavicencio;
                $command = $connection->createCommand($sql);
                $dataReader = $command->queryRow();
            }

            return $dataReader;
        } catch (Exception $ex) {
            
        }
    }

    public function insertLogPedidosEnviados($idPedido, $respuesta, $descipcionEstado, $estado, $fechaConsulta, $fechaEnvio, $fechafinenvio) {

        try {
            $connection = Yii::app()->db;

            $sql = "INSERT INTO `LogPedidosEnviados`(`IdPedido`, `FechaConsulta`, `FechaEnvio`, `Respuesta`, `FechageneraXml`, `DescripcionEstado`, `Estado`) VALUES ('$idPedido','$fechaConsulta','$fechaEnvio','$respuesta','$fechafinenvio','$descipcionEstado','$estado')";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {
            return FALSE;
        }
    }

}
