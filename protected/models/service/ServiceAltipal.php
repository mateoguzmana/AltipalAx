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
            Yii::app()->db->createCommand($cadena)->query();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function QueryRowGlobal($cadena) {
        try {
            return Yii::app()->db->createCommand($cadena)->queryRow();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function AgenciaGlobal() {
        try {
            $sql = "SELECT DISTINCT(CodAgencia) FROM `zonaventasglobales` WHERE CodAgencia<>'000'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getZonaVentasGlo() {
        try {
            $sql = "SELECT CodZonaVentas FROM `zonaventasglobales`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertErroresInser($cadena) {
        try {
            $sql = "INSERT INTO `errorestransacciones`(`Mensaje`,`Fecha`,`Hora`) VALUES ('$cadena',CURDATE(),CURTIME())";
            Yii::app()->db->createCommand($sql)->query();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertProcesosIndividuales($cadena, $status, $identificadorproceso, $identificadorestado) {
        try {
            $sql = "INSERT INTO `logprocesosindividuales`(`Proceso`,`Status`,`Fecha`,`Hora`,`IdentificadorProceso`,`IdentificadorEstado`) VALUES ('$cadena','$status',CURDATE(),CURTIME(),'$identificadorproceso','$identificadorestado')";
            Yii::app()->db->createCommand($sql)->query();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertProcesosIndividuales2($cadena, $status, $identificadorproceso, $identificadorestado, $nameServe) {
        try {
            $sql = "INSERT INTO `logprocesosindividuales`(`Proceso`,`Status`,`Fecha`,`Hora`,`IdentificadorProceso`,`IdentificadorEstado`,`NombreServidor`) VALUES ('$cadena','$status',CURDATE(),CURTIME(),'$identificadorproceso','$identificadorestado','$nameServe')";
            Yii::app()->db->createCommand($sql)->query();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function GetSitios($agencia) {
        try {
            $sql = "SELECT CodSitio FROM `sitios` WHERE CodSitio IN(SELECT DISTINCT(CodigoSitio) FROM `zonaventaalmacen`)";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function insertDatosAll($cadena) {
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        Yii::app()->Bogota->createCommand($cadena)->query();
        Yii::app()->Cali->createCommand($cadena)->query();
        Yii::app()->Medellin->createCommand($cadena)->query();
        Yii::app()->Apartado->createCommand($cadena)->query();
        Yii::app()->Duitama->createCommand($cadena)->query();
        Yii::app()->Ibague->createCommand($cadena)->query();
        Yii::app()->Monteria->createCommand($cadena)->query();
        Yii::app()->Pasto->createCommand($cadena)->query();
        Yii::app()->Pereira->createCommand($cadena)->query();
        Yii::app()->Popayan->createCommand($cadena)->query();
        Yii::app()->Villavicencio->createCommand($cadena)->query();
    }

    public function insertDatosAllGlobal($cadena) {
        set_time_limit(-1);
        ini_set('max_execution_time', -1);
        ini_set('memory_limit', -1);
        Yii::app()->db->createCommand($cadena)->query();
        Yii::app()->Apartado->createCommand($cadena)->query();
        Yii::app()->Bogota->createCommand($cadena)->query();
        Yii::app()->Cali->createCommand($cadena)->query();
        Yii::app()->Duitama->createCommand($cadena)->query();
        Yii::app()->Ibague->createCommand($cadena)->query();
        Yii::app()->Medellin->createCommand($cadena)->query();
        Yii::app()->Monteria->createCommand($cadena)->query();
        Yii::app()->Pasto->createCommand($cadena)->query();
        Yii::app()->Pereira->createCommand($cadena)->query();
        Yii::app()->Popayan->createCommand($cadena)->query();
        Yii::app()->Villavicencio->createCommand($cadena)->query();
    }

    public function SelectQueryRow($sql) {
        $datos = array();
        $dataReader_001 = Yii::app()->Apartado->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_001);
        $dataReader_002 = Yii::app()->Bogota->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_002);
        $dataReader_003 = Yii::app()->Cali->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_003);
        $dataReader_004 = Yii::app()->Duitama->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_004);
        $dataReader_005 = Yii::app()->Ibague->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_005);
        $dataReader_006 = Yii::app()->Medellin->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_006);
        $dataReader_007 = Yii::app()->Monteria->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_007);
        $dataReader_008 = Yii::app()->Pasto->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_008);
        $dataReader_009 = Yii::app()->Pereira->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_009);
        $dataReader_010 = Yii::app()->Popayan->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_010);
        $dataReader_011 = Yii::app()->Villavicencio->createCommand($sql)->queryRow();
        $datos = array_merge($datos, $dataReader_011);
        return $datos;
    }

    public function insertDatosAgencia($sql, $agencia) {
        try {
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function insertDatos($sql) {
        try {
            Yii::app()->Apartado->createCommand($sql)->query();
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getAgenciaZona($zonaVentas) {
        $sql = "SELECT `CodAgencia` FROM `zonaventasglobales` WHERE `CodZonaVentas`='$zonaVentas'";
        $dataReader = Yii::app()->db->createCommand($sql)->queryRow();
        return $dataReader['CodAgencia'];
    }

    public function getCodigoAsesorZona($zonaVentas) {
        $sql = "SELECT `CodAsesor` FROM `zonaventas` WHERE `CodZonaVentas`='$zonaVentas'";
        $dataReader = Yii::app()->db->createCommand($sql)->queryRow();
        return $dataReader['CodAsesor'];
    }

    public function getUltimaVersion() {
        $sql = "SELECT MAX(`Version`) AS UltimaVersion FROM `versiones`";
        $dataReader = Yii::app()->db->createCommand($sql)->queryRow();
        return $dataReader['UltimaVersion'];
    }

    public function getVersionActualZona($codigoasesor, $agencia) {
        try {
            $sql = "SELECT `Version` FROM `asesorescomerciales` WHERE `CodAsesor`='$codigoasesor';";
            $dataReader = $this->ExcecuteQueryRowInAgency($sql, $agencia);
            if (isset($dataReader)) {
                return $dataReader['Version'];
            }
        } catch (Exception $ex) {
            
        }
    }

    public function setAgenciaInsert($sql) {
        Yii::app()->db->createCommand($sql)->query();
    }

    public function ConsultaDatosGlobal() {
        $sql = "SELECT * FROM `transaccionesax` WHERE EstadoTransaccion='0'";
        return Multiple::multiConsultaQuery($sql);
    }

    public function ConsultaDatosGlobalDocumento($tipoDocumento) {
        $sql = "SELECT * FROM `transaccionesax` WHERE EstadoTransaccion='0' AND CodTipoDocumentoActivity='$tipoDocumento';";
        return Multiple::multiConsultaQuery($sql);
    }

    public function consultaGruposAgencia() {
        $sql = "SELECT CodigoGrupoVentas,CodAgencia FROM `gruposventas` where CodigoGrupoVentas<>'000' GROUP BY CodigoGrupoVentas,CodAgencia";
        return Multiple::multiConsultaQuery($sql);
    }

    public function getClientesNuevos($idCliente, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `clientenuevo` as clinu join transaccionesax as transax on clinu.Id=transax.IdDocumento WHERE Id='$idCliente' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND clinu.Estado=0";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getCodHomologacion($CodTipoDocumento) {
        $sql = "SELECT CodigoTipoRegistro,CodigoTipoContribuyente FROM homologaciontiposdocumento WHERE CodigoTipoDocumento='$CodTipoDocumento'";
        return Multiple::multiConsultaQuery($sql);
    }

    public function getUpdateEstado($idCliente, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `clientenuevo` as clinu join transaccionesax as transax on clinu.Id=transax.IdDocumento SET clinu.Estado='1',transax.`EstadoTransaccion`='1',clinu.ArchivoXml='$repuestaAx' WHERE Id='$idCliente' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getDevolucionesService($idDevolciones, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `devoluciones` as devolu join transaccionesax as transax on devolu.IdDevolucion=transax.IdDocumento WHERE devolu.IdDevolucion='$idDevolciones' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND devolu.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getDescripcionDevolucionesService($idDevolciones, $agencia) {
        try {
            $sql = "SELECT * FROM `descripciondevolucion` where IdDevolucion='$idDevolciones' AND Autoriza='1'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadoDevoluciones($idDevolcuiones, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `devoluciones` as devoluci join transaccionesax as transax on devoluci.IdDevolucion=transax.IdDocumento SET devoluci.Estado='1',transax.`EstadoTransaccion`='1',devoluci.ArchivoXml='$repuestaAx' WHERE IdDevolucion='$idDevolcuiones' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getNotasCreditos($idNotasCredito, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `notascredito` as nota join transaccionesax as transax on nota.IdNotaCredito=transax.IdDocumento WHERE nota.IdNotaCredito='$idNotasCredito' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND nota.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadoNotasCredito($idNotasCredito, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `notascredito` as nota join transaccionesax as transax on nota.IdNotaCredito=transax.IdDocumento SET nota.Estado='1',transax.`EstadoTransaccion`='1',nota.ArchivoXml='$repuestaAx' WHERE nota.IdNotaCredito='$idNotasCredito' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getConsignacionVendedor($idConsignacion, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `consignacionesvendedor` as consigvendedor join transaccionesax as transax on consigvendedor.IdConsignacion=transax.IdDocumento WHERE consigvendedor.IdConsignacion='$idConsignacion' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND consigvendedor.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadoConsignacionVendedor($idConsignacion, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `consignacionesvendedor` as consigvendedor join transaccionesax as transax on consigvendedor.IdConsignacion=transax.IdDocumento SET consigvendedor.Estado = '1',transax.`EstadoTransaccion` ='1',consigvendedor.ArchivoXml='$repuestaAx' WHERE consigvendedor.IdConsignacion='$idConsignacion' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getCobros($idCobro, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `norecaudos` as recaudos join transaccionesax as transax on recaudos.Id=transax.IdDocumento WHERE recaudos.Id='$idCobro' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND recaudos.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getCobrosDetalle($idCobro, $agencia) {
        try {
            $sql = "SELECT * FROM norecaudosdetalle WHERE IdNoCaudo='$idCobro'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadoCobro($idCobro, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `norecaudos` as recaudos join transaccionesax as transax on recaudos.Id=transax.IdDocumento SET recaudos.Estado='1',transax.`EstadoTransaccion`='1',recaudos.ArchivoXml='$repuestaAx' WHERE recaudos.Id='$idCobro' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaConsignacionService($idTransfereciaConsignacion, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `transferenciaconsignacion` as transconsigna join transaccionesax as transax on transconsigna.IdTransferencia=transax.IdDocumento  WHERE transconsigna.IdTransferencia='$idTransfereciaConsignacion' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND transconsigna.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getTransferenciaConsignacionNit($cuentaCliente, $agencia) {
        try {
            $sql = "SELECT Identificacion FROM `cliente` where CuentaCliente='$cuentaCliente'";
            return $this->ExcecuteQueryRowInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaConsignacionDescripcion($idTransfereciaConsignacion, $Agencia) {
        $sql = "SELECT * FROM `descripciontransferenciaconsignacion` WHERE `IdTransferencia`='$idTransfereciaConsignacion'";
        return Multiple::consultaAgencia($Agencia, $sql);
    }

    public function getUpdateEstadoTransfeConsignacion($idTransfereciaConsignacion, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `transferenciaconsignacion` as transfereconsig join transaccionesax as transax on transfereconsig.IdTransferencia=transax.IdDocumento SET transfereconsig.Estado='1',transax.`EstadoTransaccion`='1',transfereconsig.ArchivoXml='$repuestaAx' WHERE transfereconsig.IdTransferencia='$idTransfereciaConsignacion' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getTransferenciaAutoventaService($idTransfereciaAutoventa, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `transferenciaautoventa` as transauto join transaccionesax as transax on transauto.IdTransferenciaAutoventa=transax.IdDocumento WHERE transauto.IdTransferenciaAutoventa='$idTransfereciaAutoventa' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND transauto.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getDescripcionTrnasAtoventaService($idTransfereciaAutoventa, $agencia) {
        try {
            $sql = "SELECT * FROM `descripciontransferenciaautoventa` WHERE `IdTransferenciaAutoventa`='$idTransfereciaAutoventa'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadoTransfeAutoventa($idTransfereciaAutoventa, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `transferenciaautoventa` as transfereautoventa join transaccionesax as transax on transfereautoventa.IdTransferenciaAutoventa=transax.IdDocumento SET transfereautoventa.Estado='1',transax.`EstadoTransaccion`='1',transfereautoventa.ArchivoXml='$repuestaAx' WHERE transfereautoventa.IdTransferenciaAutoventa='$idTransfereciaAutoventa' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getPedidoPreventaService($idPedido, $idTipoDoc, $agencia) {
        try {
            //     $sql = "SELECT * FROM `pedidos` as pe join transaccionesax as transax on pe.IdPedido=transax.IdDocumento WHERE pe.IdPedido = '$idPedido' AND transax.CodTipoDocumentoActivity = '$idTipoDoc' AND pe.Estado = '0' ";
            $sql = "SELECT * FROM `pedidos` as pe join transaccionesax as transax on pe.IdPedido=transax.IdDocumento WHERE pe.IdPedido='$idPedido' AND transax.CodTipoDocumentoActivity='$idTipoDoc'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getPedidoDescuentoAprovado($idDetallePedido, $agencia) {
        try {
            $sql = "SELECT * FROM `descripcionpedido` descripPedi join aprovacionpedido aproPedi on descripPedi.Id=aproPedi.IdDetallePedido where aproPedi.IdDetallePedido='$idDetallePedido'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getDetallePedidoPreventaService($idPedido, $agencia) {
        try {
            $sql = "SELECT DISTINCT descrpedido.*,proveeax.* FROM descripcionpedido AS descrpedido 
                        LEFT JOIN proveedoresestrategicosenvioax AS proveeax ON descrpedido.CuentaProveedor=proveeax.CuentaProveedor 
                        INNER JOIN `portafolio` AS porta ON descrpedido.`CodVariante` = porta.`CodigoVariante`
                        INNER JOIN `jerarquiaarticulos` AS jerarti ON porta.`CodigoGrupoCategoria` = jerarti.`Nombre` 
                        WHERE IdPedido='$idPedido' GROUP BY descrpedido.`CodVariante` 
                        ORDER BY IF(proveeax.Item IS NULL,1,0),proveeax.Item, proveeax.CuentaProveedor, porta.`CodigoGrupoCategoria` ASC , jerarti.`IdPrincipal` ASC, porta.`CodigoMarca` ASC ";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getPedidoDetalleKidService($idDescripcionPedido, $agencia) {
        try {
            $sql = "SELECT * FROM `kitdescripcionpedido` WHERE `IdDescripcionPedido`='$idDescripcionPedido' AND Cantidad>0";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadopPedido($idPedido, $tipDoc, $agencia, $repuestaAx) {
        try {
            //$sql = "Update `pedidos` as pe join transaccionesax as transax on pe.IdPedido=transax.IdDocumento SET pe.Estado = '1',transax.`EstadoTransaccion` ='1',pe.ArchivoXml='$repuestaAx' WHERE pe.IdPedido = '$idPedido' AND transax.CodTipoDocumentoActivity = '$tipDoc' ";
            $sql = "set @variable=(SELECT p.`ArchivoXml` FROM `pedidos` p WHERE p.IdPedido='$idPedido');
                    Update `pedidos` as pe 
                    join transaccionesax as transax on pe.IdPedido=transax.IdDocumento 
                    SET pe.Estado='1',
                    transax.`EstadoTransaccion`='1',
                    pe.ArchivoXml=CONCAT(@variable,'$repuestaAx')
                    WHERE pe.IdPedido='$idPedido' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadopPedidoNoEnvio($idPedido, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `pedidos` SET ArchivoXml='$repuestaAx' WHERE IdPedido='$idPedido'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    /*     * **************************************************************************************** */

    public function getReciboCajaService($idRecibo, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento WHERE recibo.Id='$idRecibo' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND recibo.Estado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getReciboCajaServiceCheque($idRecibo, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento WHERE recibo.Id='$idRecibo' AND transax.CodTipoDocumentoActivity='$idTipoDoc'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getDetallereciboCaja($idRecibo, $agencia) {
        try {
            $sql = "SELECT * FROM reciboscajafacturas WHERE IdReciboCaja='$idRecibo'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getReciboChequeConsigVendedor($IdReciboConsignacionVendedor, $agencia) {
        try {
            $sql = "SELECT * FROM `consignacionchequesvendedor` WHERE `IdConsignacionVendedor`='$IdReciboConsignacionVendedor'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getReciboChequeConsig($IdReciboCajaFacturas, $agencia) {
        try {
            $sql = "SELECT chequeconsig.`Id` as IdConsignacion,recicajaFactura.`NumeroFactura`,`NroConsignacionCheque`,`CodBanco`,`CodCuentaBancaria`,`Fecha`,'001' FROM `reciboschequeconsignacion` as chequeconsig join reciboscajafacturas as recicajaFactura on recicajaFactura.Id=chequeconsig.IdReciboCajaFacturas WHERE chequeconsig.IdReciboCajaFacturas='$IdReciboCajaFacturas'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getChequeConsignacionDetalle($idReciboChequeConsignacion, $agencia) {
        try {
            $sql = "SELECT rcbcheDetalle.*,recicajafac.NumeroFactura FROM `reciboschequeconsignaciondetalle` rcbcheDetalle join reciboschequeconsignacion recichecon on recichecon.Id=rcbcheDetalle.IdRecibosChequeConsignacion join reciboscajafacturas recicajafac on recichecon.IdReciboCajaFacturas=recicajafac.Id where rcbcheDetalle.IdRecibosChequeConsignacion='$idReciboChequeConsignacion'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getReciboEfectivo($IdReciboCajaFacturas, $agencia) {
        try {
            $sql = "SELECT *,'005' FROM `recibosefectivo` as efectivo join reciboscajafacturas as recibocajafactu on recibocajafactu.Id=efectivo.IdReciboCajaFacturas WHERE IdReciboCajaFacturas='$IdReciboCajaFacturas'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getReciboEfectivoConsig($IdReciboCajaFactura, $agencia) {
        try {
            $sql = "SELECT *,'004' FROM `recibosefectivoconsignacion` as efectivoconsig join reciboscajafacturas as reciboCajaFactu on reciboCajaFactu.Id=efectivoconsig.IdReciboCajaFacturas WHERE IdReciboCajaFacturas='$IdReciboCajaFactura'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getFechas($idReciboCajaFactura, $agencia) {
        try {
            $sql = "SELECT factu.FechaFactura,factu.FechaVencimientoFactura,reci.Fecha FROM `reciboscajafacturas` as recifactu join facturasaldo as factu on recifactu.NumeroFactura=factu.NumeroFactura join reciboscaja as reci on recifactu.IdReciboCaja=reci.Id where recifactu.Id='$idReciboCajaFactura'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function consultarResponsableAsesor($responsableAsesor, $agencia) {
        try {
            $sql = "SELECT Nombre FROM `asesorescomerciales` where CodAsesor='$responsableAsesor'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function consultarResponsable($responsable, $agencia) {
        try {
            $sql = "SELECT NombreEmpleado FROM `jerarquiacomercial` WHERE NumeroIdentidad='$responsable'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getPaymentReference($idReciboChequeConsignacion, $agencia) {
        try {
            $sql = "SELECT * FROM `reciboschequeconsignacion` WHERE `Id`='$idReciboChequeConsignacion'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getUpdateEstadoRecibos($idRecibo, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "Update `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento SET recibo.Estado='1',transax.`EstadoTransaccion`='1',recibo.ArchivoXml='$repuestaAx' WHERE recibo.Id='$idRecibo' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    ////********************************************/////

    public function getReciboCajaChequePostService($idRecibo, $idTipoDoc, $agencia) {
        try {
            $sql = "SELECT * FROM `reciboscaja` as recibo join transaccionesax as transax on recibo.Id=transax.IdDocumento WHERE recibo.Id='$idRecibo' AND transax.CodTipoDocumentoActivity='$idTipoDoc' AND recibo.EstadoChequePosfechado='0'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getInfoChequePosEncabezado($IdReciboCaja, $agencia) {
        try {
            $sql = "SELECT  cheque.Id,cheque.NroCheque,cheque.Fecha,cheque.CuentaCheque,cheque.Posfechado,cheque.CodBanco FROM reciboscaja as caja join `reciboscajafacturas` as reci on caja.Id=reci.IdReciboCaja join reciboscheque as cheque on reci.Id=cheque.IdReciboCajaFacturas where caja.Id='$IdReciboCaja' AND cheque.Posfechado='1' GROUP BY cheque.NroCheque,cheque.CodBanco";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getInfoChequeEncabezado($IdReciboCaja, $agencia) {
        try {
            $sql = "SELECT  cheque.Id,cheque.NroCheque,cheque.Fecha,cheque.CuentaCheque,cheque.Posfechado,cheque.CodBanco FROM reciboscaja as caja join `reciboscajafacturas` as reci on caja.Id=reci.IdReciboCaja join reciboscheque as cheque on reci.Id=cheque.IdReciboCajaFacturas where caja.Id='$IdReciboCaja' AND cheque.Posfechado='0' GROUP BY cheque.NroCheque,cheque.CodBanco";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getInfoChequeDetalle($IdReciboCajaFactura, $NoCheque, $agencia) {
        try {
            $sql = "SELECT reci.CuentaCliente,reci.NumeroFactura,cheque.Valor,cheque.ValorTotal FROM reciboscaja as caja join `reciboscajafacturas` as reci on caja.Id=reci.IdReciboCaja join reciboscheque as cheque on reci.Id=cheque.IdReciboCajaFacturas where caja.Id='$IdReciboCajaFactura' and cheque.NroCheque='$NoCheque'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoChquesPosfechados($idRecibo, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "UPDATE `reciboscaja` rc
            INNER JOIN transaccionesax AS transax ON transax.IdDocumento=rc.Id
            INNER JOIN reciboscajafacturas rcf ON rcf.IdReciboCaja=rc.Id 
            INNER JOIN reciboscheque rcc ON rcc.IdReciboCajaFacturas=rcf.Id
            SET rc.EstadoChequePosfechado='1',
            transax.`EstadoTransaccion`='1', 
            rcc.ArchivoXml='$repuestaAx' 
            WHERE rc.Id='$idRecibo' AND rcc.Posfechado='1' AND transax.CodTipoDocumentoActivity='$tipDoc' 
            AND transax.EstadoTransaccion='0'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getUpdateEstadoChques($idRecibo, $tipDoc, $agencia, $repuestaAx) {
        try {
            $sql = "UPDATE `reciboscaja` rc INNER JOIN transaccionesax AS transax ON transax.IdDocumento=rc.Id INNER JOIN reciboscajafacturas rcf ON rcf.IdReciboCaja=rc.Id 
            INNER JOIN reciboscheque rcc ON rcc.IdReciboCajaFacturas=rcf.Id
            SET rc.Estado='1',
            transax.`EstadoTransaccion`='1', 
            rcc.ArchivoXml='$repuestaAx' 
            WHERE rc.Id='$idRecibo' AND transax.CodTipoDocumentoActivity='$tipDoc'";
            $this->ExcecuteQueryInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function insertDatos001($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `CodAgencia`='$agencia' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesPaqueteMasivoZonas($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacion`='0' AND `CodAgencia`='$agencia' ORDER BY CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesCupoCredito($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionCupoCredito`='0' AND `CodAgencia`='$agencia' ORDER BY CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesFacturasSaldo($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturaSaldo`='0' AND `CodAgencia`='$agencia' ORDER BY CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesFacturasTransacciones($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturasTransacciones`='0' AND `CodAgencia`='$agencia' ORDER BY CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesPendientesFacturar($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPendientesFacturar`='0' AND `CodAgencia`='$agencia' ORDER BY CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function ZonasFaltantesPresupuestoVentas($agencia) {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPresupuesto`='0' AND `CodAgencia`='$agencia' ORDER BY CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantes() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacion`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesCupos() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionCupoCredito`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesFacturas() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturaSaldo`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesPresupuesto() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPresupuesto`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesPendientesFacturar() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionPendientesFacturar`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function insertDatosZonasFaltantesFacturasTransacciones() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `EstadoActualizacionFacturasTransacciones`='0' ORDER BY CodAgencia ASC,CodZonaVentas";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getAgenciasGlobales() {
        try {
            $sql = "SELECT DISTINCT(`CodAgencia`) FROM `zonaventasglobales` WHERE CodAgencia<>'000'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getAgenciasSitiosGlobales() {
        try {
            $sql = "SELECT DISTINCT(`CodZonaVentas`),`CodAgencia`,`NombreAgencia` FROM `zonaventasglobales` WHERE `CodAgencia`<>'000' ORDER BY CodAgencia ASC";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getSitiosGlobales() {
        try {
            $sql = "SELECT * FROM `zonaventasglobales`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getGruposGlobales() {
        try {
            $sql = "SELECT DISTINCT(`CodigoGrupoVentas`) FROM `gruposventas`";
            //$sql = "SELECT DISTINCT (`CodigoGrupoVentas`) FROM `gruposventas` WHERE `CodigoGrupoVentas`='032' ";
            //$sql = "SELECT DISTINCT (`CodigoGrupoVentas`) FROM `gruposventas` WHERE (`CodigoGrupoVentas`='013' OR `CodigoGrupoVentas`='017' OR `CodigoGrupoVentas`='019' OR `CodigoGrupoVentas`='023')";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getGruposGlobalesFaltantes() {
        try {
            $sql = "SELECT DISTINCT(`CodigoGrupoVentas`) FROM `gruposventas` WHERE `EstadoActualizacionGrupoVenta`='0'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getGruposVentas2($agencia) {
        try {
            $sql = "SELECT CodigoGrupoVentas,CodAgencia FROM `gruposventas` where CodigoGrupoVentas<>'000' GROUP BY CodigoGrupoVentas,CodAgencia";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getCountDetallePedidos($idPedido, $agencia) {
        try {
            $sql = "SELECT COUNT(*) AS detallepedido FROM descripcionpedido where IdPedido='$idPedido'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getCountDevoluciones($iddevolucion, $agencia) {
        try {
            $sql = "SELECT COUNT(*) as devolucionesdetalle FROM `descripciondevolucion` WHERE `IdDevolucion`='$iddevolucion' AND `Autoriza`='1'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getDatosClienteNuevo($cuentaCliente, $agencia) {
        try {
            $sql = "SELECT * FROM `clientenuevo` WHERE `ArchivoXml`='$cuentaCliente' ORDER BY `Id` DESC LIMIT 1";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function InsertClienteNuevo($cuentaCliente, $identificacion, $nombre, $razonSocial, $direccion, $telefono, $telefonoMovil, $email, $estado, $codigoCadena, $codigoBarrio, $codigoPostal, $latitud, $longitud, $agencia) {
        try {
            $sql = "INSERT INTO `cliente`(`CuentaCliente`,`Identificacion`,`NombreCliente`,`NombreBusqueda`,`DireccionEntrega`,`Telefono`,`TelefonoMovil`,`CorreoElectronico`,`Estado`,`CodigoCadenaEmpresa`,`CodigoBarrio`,`CodigoPostal`,`Latitud`,`Longitud`) 
                VALUES ('$cuentaCliente','$identificacion','$nombre','$razonSocial','$direccion','$telefono','$telefonoMovil','$email','$estado','$codigoCadena','$codigoBarrio','$codigoPostal','$latitud','$longitud')";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getCadenaEmpresa($codigo, $agencia) {
        try {
            $sql = "SELECT * FROM `cadenaempresa` WHERE `CodigoCadenaEmpresa`='$codigo'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getGrupoImpuestos($tipoDocumento, $barrio, $agencia) {
        try {
            $sql = "SELECT h.CodigoGrupoImpuestos FROM `homologaciongrupoimpuestos` AS h INNER JOIN homologaciontiposdocumento AS hd ON h.CodigoTipoContribuyente = hd.CodigoTipoContribuyente INNER JOIN Localizacion AS l ON h.CodigoCiudad=l.CodigoCiudad AND h.CodigoDepartamento=l.CodigoDepartamento WHERE l.CodigoBarrio='$barrio' AND hd.CodigoTipoDocumento='$tipoDocumento' LIMIT 1";
            $dataReader = $this->ExcecuteQueryAllInAgency($sql, $agencia);
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
            $sql = "INSERT INTO `clienteruta`(`CodZonaVentas`,`CuentaCliente`,`NumeroVisita`,`Posicion`,`CodigoZonaLogistica`,`ValorCupo`,`ValorCupoTemporal`,`SaldoCupo`,`CodigoCondicionPago`,`DiasGracia`, 
                `DiasAdicionales`,`CodigoFormadePago`,`CodigoGrupoDescuentoLinea`,`CodigoGrupoDescuentoMultiLinea`,`CodigoGrupodeImpuestos`,`CodigoGrupoPrecio`) VALUES ('$zonasVentas','$cuentaCliente','$numero','$posicion','$codigoZonaLogistica','$valorCupo','$cupoTemporal','$saldo','$codigoPago','$diasGracia','$adicionales','$formaPago','$descuentoLinea','$descuentoMultilinea','$grupoImpuestos','$codigoPrecio')";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getCorreosProceso() {
        try {
            $sql = "SELECT * FROM `correosproceso`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getCorreosProcesoActivity() {
        try {
            $sql = "SELECT * FROM `correosproceso` WHERE `EnviaCorreoActivity`='1'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getCorreosProcesoResumenProceso() {
        try {
            $sql = "SELECT * FROM `correosproceso` WHERE EnviaCorreoResumen='1'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreo($consultaEstado) {
        $fechaConsulta = $consultaEstado == "Mayor" ? date("Y-m-d", strtotime("$fecha -1 day")) : $fechaConsulta = date("Y-m-d");
        try {
            $sql = "SELECT * FROM `erroresactualizacion` WHERE ((Fecha='$fechaConsulta' AND Hora>='21:00:00') or (Fecha=curdate())) AND MensajeActivity NOT IN ('Error Proceso Clientes Nuevos') AND ServicioSRF NOT IN ('Servicio Activity','Facturas Transacciones','Pendientes por Facturar','Presupuesto de Ventas','Paquete Masivo Zonas')";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoActivity($consultaEstado) {
        $fechaConsulta = $consultaEstado == "Mayor" ? date("Y-m-d", strtotime("$fecha -1 day")) : $fechaConsulta = date("Y-m-d");
        try {
            $sql = "SELECT * FROM `erroresactualizacion` WHERE ((Fecha='$fechaConsulta' AND Hora>='21:00:00') or (Fecha=curdate())) AND ServicioSRF IN ('Servicio Activity')";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoZonas() {
        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $sql = "SELECT * FROM `erroresactualizacion` WHERE ((Fecha='$fechaConsulta' AND Hora>='23:00:00') or (Fecha=curdate())) AND ServicioSRF IN ('Facturas Transacciones','Pendientes por Facturar','Presupuesto de Ventas')";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoResumenProceso() {
        //$fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            //$sql = "SELECT * FROM `logprocesosindividuales` WHERE ((Fecha='$fechaConsulta' AND `Hora`>='01:00:00') OR Fecha = CURDATE( )) AND `IdentificadorEstado`='1' ORDER BY `Id`";
            $sql = "SELECT * FROM `logprocesosindividuales` WHERE (Fecha=CURDATE()) AND `IdentificadorEstado`='1' ORDER BY `Id`";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoResumenProcesoIndividual($identificadorproceso) {
        $fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $sql = "SELECT * FROM `logprocesosindividuales` WHERE ((Fecha='$fechaConsulta' AND `Hora`>='21:00:00') OR (Fecha=CURDATE() AND `Hora`<='06:00:00')) AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='$identificadorproceso' ORDER BY `Id`";
            //$sql = "SELECT * FROM `logprocesosindividuales` WHERE (Fecha = CURDATE( )) AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='".$identificadorproceso."' ORDER BY `Id`";			
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoResumenProcesoIndividualError($identificadorproceso) {
        //$fechaConsulta = date("Y-m-d", strtotime("$fecha -1 day"));
        try {
            $sql = "SELECT * FROM `logprocesosindividuales` WHERE (Fecha=CURDATE() AND `Hora`>='21:00:00') AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='$identificadorproceso' ORDER BY `Id`";
            //$sql = "SELECT * FROM `logprocesosindividuales` WHERE (Fecha=CURDATE()) AND `IdentificadorEstado`='1' AND `IdentificadorProceso`='$identificadorproceso' ORDER BY `Id`";			
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getMensajeCorreoVerificacionProcesoIndividual($columna, $zona) {
        try {
            $sql = "SELECT `" . $columna . "` FROM `zonaventasglobales` WHERE `CodZonaVentas`='$zona'";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function VerificarClientesNuevos() {
        try {
            $sql = "SELECT Identificador,CodigoTipoDocumento,IdClienteVerificado FROM `clienteverificado` WHERE Estado='0' ORDER BY IdClienteVerificado LIMIT 1";
            return Yii::app()->db->createCommand($sql)->queryRow();
        } catch (Exception $ex) {
            return FALSE;
        }
    }

    public function getCuentalienteFactura($numerofactura, $agencia) {
        try {
            $sql = "SELECT CuentaCliente FROM `facturasaldo` where NumeroFactura='$numerofactura'";
            return $this->ExcecuteQueryRowInAgency($sql, $agencia);
        } catch (Exception $ex) {
            
        }
    }

    public function getReciboCheque($IdReciboCajaFacturas, $agencia) {
        try {
            $sql = "SELECT * FROM `reciboscheque` as cheque join `reciboscajafacturas` as reciCaja on reciCaja.Id=cheque.IdReciboCajaFacturas WHERE IdReciboCajaFacturas='$IdReciboCajaFacturas'";
            return $this->ExcecuteQueryAllInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getSaldoLimiteAcuardoLinea($idAcuerdoLinea, $agencia) {
        try {
            $sql = "SELECT `Saldo`, PorcentajeDescuentoLinea2 FROM `acuerdoscomercialesdescuentolinea` WHERE `IdAcuerdoComercial`='$idAcuerdoLinea'";
            return $this->ExcecuteQueryRowInAgency($sql, $agencia);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function insertLogPedidosEnviados($idPedido, $respuesta, $descipcionEstado, $estado, $fechaConsulta, $fechaEnvio, $fechafinenvio) {
        try {
            $sql = "INSERT INTO `LogPedidosEnviados`(`IdPedido`,`FechaConsulta`,`FechaEnvio`,`Respuesta`,`FechageneraXml`,`DescripcionEstado`,`Estado`) VALUES ('$idPedido','$fechaConsulta','$fechaEnvio','$respuesta','$fechafinenvio','$descipcionEstado','$estado')";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function getProcessingMethods() {
        $sql = "SELECT `idmethod`,`method`,`processobject` FROM `tblwspu_methods` WHERE `state`='1' AND `stateprocess`='1' AND `statestatic`='1'";
        return Yii::app()->db->createCommand($sql)->queryAll();
    }

    public function ExcecuteQueryRowInAgency($sql, $agencia) {
        try {
            switch ($agencia) {
                case '001':
                    return Yii::app()->Apartado->createCommand($sql)->queryRow();
                    break;
                case '002':
                    return Yii::app()->Bogota->createCommand($sql)->queryRow();
                    break;
                case '003':
                    return Yii::app()->Cali->createCommand($sql)->queryRow();
                    break;
                case '004':
                    return Yii::app()->Duitama->createCommand($sql)->queryRow();
                    break;
                case '005':
                    return Yii::app()->Ibague->createCommand($sql)->queryRow();
                    break;
                case '006':
                    return Yii::app()->Medellin->createCommand($sql)->queryRow();
                    break;
                case '007':
                    return Yii::app()->Monteria->createCommand($sql)->queryRow();
                    break;
                case '008':
                    return Yii::app()->Pasto->createCommand($sql)->queryRow();
                    break;
                case '009':
                    return Yii::app()->Pereira->createCommand($sql)->queryRow();
                    break;
                case '010':
                    return Yii::app()->Popayan->createCommand($sql)->queryRow();
                    break;
                case '011':
                    return Yii::app()->Villavicencio->createCommand($sql)->queryRow();
                    break;
                default:
                    return "";
                    break;
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function ExcecuteQueryAllInAgency($sql, $agencia) {
        try {
            switch ($agencia) {
                case '001':
                    return Yii::app()->Apartado->createCommand($sql)->queryAll();
                    break;
                case '002':
                    return Yii::app()->Bogota->createCommand($sql)->queryAll();
                    break;
                case '003':
                    return Yii::app()->Cali->createCommand($sql)->queryAll();
                    break;
                case '004':
                    return Yii::app()->Duitama->createCommand($sql)->queryAll();
                    break;
                case '005':
                    return Yii::app()->Ibague->createCommand($sql)->queryAll();
                    break;
                case '006':
                    return Yii::app()->Medellin->createCommand($sql)->queryAll();
                    break;
                case '007':
                    return Yii::app()->Monteria->createCommand($sql)->queryAll();
                    break;
                case '008':
                    return Yii::app()->Pasto->createCommand($sql)->queryAll();
                    break;
                case '009':
                    return Yii::app()->Pereira->createCommand($sql)->queryAll();
                    break;
                case '010':
                    return Yii::app()->Popayan->createCommand($sql)->queryAll();
                    break;
                case '011':
                    return Yii::app()->Villavicencio->createCommand($sql)->queryAll();
                    break;
                default:
                    return "";
                    break;
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    public function ExcecuteQueryInAgency($sql, $agencia) {
        try {
            switch ($agencia) {
                case '001':
                    Yii::app()->Apartado->createCommand($sql)->query();
                    break;
                case '002':
                    Yii::app()->Bogota->createCommand($sql)->query();
                    break;
                case '003':
                    Yii::app()->Cali->createCommand($sql)->query();
                    break;
                case '004':
                    Yii::app()->Duitama->createCommand($sql)->query();
                    break;
                case '005':
                    Yii::app()->Ibague->createCommand($sql)->query();
                    break;
                case '006':
                    Yii::app()->Medellin->createCommand($sql)->query();
                    break;
                case '007':
                    Yii::app()->Monteria->createCommand($sql)->query();
                    break;
                case '008':
                    Yii::app()->Pasto->createCommand($sql)->query();
                    break;
                case '009':
                    Yii::app()->Pereira->createCommand($sql)->query();
                    break;
                case '010':
                    Yii::app()->Popayan->createCommand($sql)->query();
                    break;
                case '011':
                    Yii::app()->Villavicencio->createCommand($sql)->query();
                    break;
                default:
                    break;
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

}
