<?php

/**
 * This is the model class for table "transferenciaautoventa".
 *
 * The followings are the available columns in table 'transferenciaautoventa':
 * @property integer $IdTransferenciaAutoventa
 * @property string $CodAsesor
 * @property string $CodZonaVentas
 * @property string $CodZonaVentasTransferencia
 * @property string $FechaTransferenciaAutoventa
 * @property string $HoraDigitado
 * @property string $HoraEnviado
 * @property string $Estado
 * @property string $ArchivoXml
 * @property integer $Web
 * @property string $PedidoMaquina
 * @property string $IdentificadorEnvio
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property string $CodigoUbicacionOrigen
 * @property string $CodigoUbicacionDestino
 * @property string $Imei
 * @property string $TotalTransferencia
 */
class Transferenciaautoventa extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'transferenciaautoventa';
    }

    public function getDbConnection() {
        return self::setConexion();
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CodZonaVentas, CodZonaVentasTransferencia, PedidoMaquina, IdentificadorEnvio, CodigoCanal, CodigoUbicacionOrigen, CodigoUbicacionDestino, TotalTransferencia', 'required'),
            array('Web', 'numerical', 'integerOnly' => true),
            array('CodAsesor, CodZonaVentasTransferencia', 'length', 'max' => 16),
            array('CodZonaVentas, IdentificadorEnvio', 'length', 'max' => 15),
            array('Estado, CodigoCanal, Responsable, CodigoUbicacionOrigen, CodigoUbicacionDestino, TotalTransferencia', 'length', 'max' => 25),
            array('PedidoMaquina', 'length', 'max' => 60),
            array('Imei', 'length', 'max' => 50),
            array('FechaTransferenciaAutoventa, HoraDigitado, HoraEnviado, ArchivoXml', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdTransferenciaAutoventa, CodAsesor, CodZonaVentas, CodZonaVentasTransferencia, FechaTransferenciaAutoventa, HoraDigitado, HoraEnviado, Estado, ArchivoXml, Web, PedidoMaquina, IdentificadorEnvio, CodigoCanal, Responsable, CodigoUbicacionOrigen, CodigoUbicacionDestino, Imei, TotalTransferencia', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'IdTransferenciaAutoventa' => 'Id Transferencia Autoventa',
            'CodAsesor' => 'Cod Asesor',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CodZonaVentasTransferencia' => 'Cod Zona Ventas Transferencia',
            'FechaTransferenciaAutoventa' => 'Fecha Transferencia Autoventa',
            'HoraDigitado' => 'Hora Digitado',
            'HoraEnviado' => 'Hora Enviado',
            'Estado' => 'Estado',
            'ArchivoXml' => 'Archivo Xml',
            'Web' => 'Web',
            'PedidoMaquina' => 'Pedido Maquina',
            'IdentificadorEnvio' => 'Identificador Envio',
            'CodigoCanal' => 'Codigo Canal',
            'Responsable' => 'Responsable',
            'CodigoUbicacionOrigen' => 'Codigo Ubicacion Origen',
            'CodigoUbicacionDestino' => 'Codigo Ubicacion Destino',
            'Imei' => 'Imei',
            'TotalTransferencia' => 'Total Transferencia',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('IdTransferenciaAutoventa', $this->IdTransferenciaAutoventa);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CodZonaVentasTransferencia', $this->CodZonaVentasTransferencia, true);
        $criteria->compare('FechaTransferenciaAutoventa', $this->FechaTransferenciaAutoventa, true);
        $criteria->compare('HoraDigitado', $this->HoraDigitado, true);
        $criteria->compare('HoraEnviado', $this->HoraEnviado, true);
        $criteria->compare('Estado', $this->Estado, true);
        $criteria->compare('ArchivoXml', $this->ArchivoXml, true);
        $criteria->compare('Web', $this->Web);
        $criteria->compare('PedidoMaquina', $this->PedidoMaquina, true);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio, true);
        $criteria->compare('CodigoCanal', $this->CodigoCanal, true);
        $criteria->compare('Responsable', $this->Responsable, true);
        $criteria->compare('CodigoUbicacionOrigen', $this->CodigoUbicacionOrigen, true);
        $criteria->compare('CodigoUbicacionDestino', $this->CodigoUbicacionDestino, true);
        $criteria->compare('Imei', $this->Imei, true);
        $criteria->compare('TotalTransferencia', $this->TotalTransferencia, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Transferenciaautoventa the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getTransferenciaAutoventa($codzona) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT transfe.IdTransferenciaAutoventa,transfe.CodAsesor,transfe.CodZonaVentas,descr.CodigoUnidadMedida,descr.CodVariante,transfe.FechaTransferenciaAutoventa,descr.Cantidad,transfe.CodigoUbicacionOrigen,transfe.CodigoUbicacionDestino,descr.Lote,descr.NombreUnidadMedida FROM `transferenciaautoventa` transfe 
		JOIN  descripciontransferenciaautoventa descr on transfe.IdTransferenciaAutoventa=descr.IdTransferenciaAutoventa 
		where CodZonaVentas = '$codzona' AND Estado = ''";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getDescripcionTrnasAtoventa($id) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT * FROM `descripciontransferenciaautoventa` WHERE IdTransferenciaAutoventa = '$id'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function UpdateTransAuto($zona, $agencia) {

        $consulta = new Multiple();
        $sql = "UPDATE `transferenciaautoventa` SET IdentificadorEnvio='1' WHERE CodZonaVentas = '$zona' AND FechaTransferenciaAutoventa = CURDATE() AND IdentificadorEnvio='0'";
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function getTransfereciasAutoventasSinAceptar($zonaVentas) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT SUM(transdp.Cantidad ) as Cantidad , trasn.* FROM `transferenciaautoventa` trasn INNER JOIN descripciontransferenciaautoventa transdp ON trasn.IdTransferenciaAutoventa=transdp.IdTransferenciaAutoventa WHERE trasn.`CodZonaVentasTransferencia` = '$zonaVentas' AND trasn.`FechaTerminacion` = 0000-00-00 AND  trasn.`EstadoTransaccion` = '0' GROUP BY trasn.IdTransferenciaAutoventa";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }

    public function getSitios($zonaVentas) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT zalma.CodigoUbicacion,zalma.CodigoSitio,zalma.CodigoAlmacen,sit.Nombre FROM `zonaventaalmacen` zalma INNER JOIN sitios sit ON zalma.CodigoSitio=sit.CodSitio  where zalma.CodZonaVentas = '$zonaVentas'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }

    public function getTransferencias($id) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT * FROM `transferenciaautoventa` trasn INNER JOIN descripciontransferenciaautoventa transdp ON trasn.IdTransferenciaAutoventa=transdp.IdTransferenciaAutoventa WHERE trasn.`IdTransferenciaAutoventa` = '$id'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }

    public function getSaldosAutoventa($CodigoUbicacion, $CodVariante, $lote) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT  * FROM `saldosinventarioautoventayconsignacion`  where CodigoUbicacion = '$CodigoUbicacion'  AND CodigoVariante = '$CodVariante' AND LoteArticulo = '$lote'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }

    public function UpdateTransFerencia($id) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "UPDATE `transferenciaautoventa` SET EstadoTransaccion='1' WHERE IdTransferenciaAutoventa = '$id'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }
    
    
      public function UpdateMensaje($zonaVentas) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "UPDATE `mensajes` SET Estado='1' WHERE IdDestinatario = '$zonaVentas'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }
    
    public function UpdateSaldo($CodigoUbicacion, $CodVariante, $saldo) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "UPDATE `saldosinventarioautoventayconsignacion` SET Disponible='$saldo' WHERE CodigoUbicacion = '$CodigoUbicacion' AND CodigoVariante = '$CodVariante'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }

    public function getPortafolio($CodVariante) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "SELECT CodigoCaracteristica1,CodigoCaracteristica2,CodigoTipo  FROM `portafolio` where CodigoVariante = '$CodVariante'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }
    
    
    public function insertSaldoAutoventa($codsitio,$nombre,$codalamcen,$codubicacion,$codvariante,$codArticulo,$carateristica1,$carateristica2,$lote,$tipo,$codUnidad,$codNombreUnidad,$disponible) {

        try {

            $connection = Multiple::getConexionZonaVentas();
            $sql = "INSERT INTO `saldosinventarioautoventayconsignacion`(`CodigoSitio`, `NombreSitio`, `CodigoAlmacen`, `CodigoUbicacion`, `CodigoVariante`, `CodigoArticulo`, `Caracteristica1`, `Caracteristica2`, `LoteArticulo`, `CodigoTipo`, `CodigoUnidadMedida`, `NombreUnidadMedida`, `Disponible`, `FechaVencimiento`) VALUES ('$codsitio','$nombre','$codalamcen','$codubicacion','$codvariante','$codArticulo','$carateristica1','$carateristica2','$lote','$tipo','$codUnidad','$codNombreUnidad','$disponible','0000-00-00',)";
            $command = $connection->createCommand($sql);
            $dataReader = $command->query();
            return $dataReader;
        } catch (Exception $ex) {

            echo $ex->getMessage('Error');
        }
    }

}
