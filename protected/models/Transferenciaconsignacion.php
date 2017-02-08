<?php

/**
 * This is the model class for table "transferenciaconsignacion".
 *
 * The followings are the available columns in table 'transferenciaconsignacion':
 * @property integer $IdTransferencia
 * @property string $CodAsesor
 * @property string $CodZonaVentas
 * @property string $CuentaCliente
 * @property string $CodigoSitio
 * @property string $CodigoAlmacen
 * @property string $FechaTransferencia
 * @property string $HoraDigitado
 * @property string $HoraEnviado
 * @property string $Estado
 * @property string $ArchivoXml
 * @property integer $Web
 * @property string $PedidoMaquina
 * @property string $IdentificadorEnvio
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property integer $ExtraRuta
 * @property string $Ruta
 * @property string $Imei
 */
class Transferenciaconsignacion extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'transferenciaconsignacion';
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
            array('CodZonaVentas, CuentaCliente, CodigoSitio, CodigoAlmacen, PedidoMaquina, IdentificadorEnvio, ExtraRuta, Ruta', 'required'),
            array('Web, ExtraRuta', 'numerical', 'integerOnly' => true),
            array('CodAsesor', 'length', 'max' => 16),
            array('CodZonaVentas, CuentaCliente, IdentificadorEnvio', 'length', 'max' => 15),
            array('CodigoSitio, CodigoAlmacen, Estado, CodigoCanal, Responsable', 'length', 'max' => 25),
            array('PedidoMaquina', 'length', 'max' => 60),
            array('Ruta', 'length', 'max' => 3),
            array('Imei', 'length', 'max' => 50),
            array('FechaTransferencia, HoraDigitado, HoraEnviado, ArchivoXml', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdTransferencia, CodAsesor, CodZonaVentas, CuentaCliente, CodigoSitio, CodigoAlmacen, FechaTransferencia, HoraDigitado, HoraEnviado, Estado, ArchivoXml, Web, PedidoMaquina, IdentificadorEnvio, CodigoCanal, Responsable, ExtraRuta, Ruta, Imei', 'safe', 'on' => 'search'),
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
            'IdTransferencia' => 'Id Transferencia',
            'CodAsesor' => 'Cod Asesor',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CuentaCliente' => 'Cuenta Cliente',
            'CodigoSitio' => 'Codigo Sitio',
            'CodigoAlmacen' => 'Codigo Almacen',
            'FechaTransferencia' => 'Fecha Transferencia',
            'HoraDigitado' => 'Hora Digitado',
            'HoraEnviado' => 'Hora Enviado',
            'Estado' => 'Estado',
            'ArchivoXml' => 'Archivo Xml',
            'Web' => 'Web',
            'PedidoMaquina' => 'Pedido Maquina',
            'IdentificadorEnvio' => 'Identificador Envio',
            'CodigoCanal' => 'Codigo Canal',
            'Responsable' => 'Responsable',
            'ExtraRuta' => 'Extra Ruta',
            'Ruta' => 'Ruta',
            'Imei' => 'Imei',
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

        $criteria->compare('IdTransferencia', $this->IdTransferencia);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);
        $criteria->compare('CodigoSitio', $this->CodigoSitio, true);
        $criteria->compare('CodigoAlmacen', $this->CodigoAlmacen, true);
        $criteria->compare('FechaTransferencia', $this->FechaTransferencia, true);
        $criteria->compare('HoraDigitado', $this->HoraDigitado, true);
        $criteria->compare('HoraEnviado', $this->HoraEnviado, true);
        $criteria->compare('Estado', $this->Estado, true);
        $criteria->compare('ArchivoXml', $this->ArchivoXml, true);
        $criteria->compare('Web', $this->Web);
        $criteria->compare('PedidoMaquina', $this->PedidoMaquina, true);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio, true);
        $criteria->compare('CodigoCanal', $this->CodigoCanal, true);
        $criteria->compare('Responsable', $this->Responsable, true);
        $criteria->compare('ExtraRuta', $this->ExtraRuta);
        $criteria->compare('Ruta', $this->Ruta, true);
        $criteria->compare('Imei', $this->Imei, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Transferenciaconsignacion the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getDatosZona($zonaVentas) {

        $connection = Multiple::getConexionZonaVentas();
        $sql = "SELECT NombreZonadeVentas FROM `zonaventas` where CodZonaVentas = '$zonaVentas'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getDetalleKit($codigoVariante) {
        $sql = "SELECT
                l.`CodigoArticuloKit`,
                ld.CodigoCaracteristica1,
                ld.CodigoArticuloComponente,
                ld.CodigoUnidadMedida
                FROM 
                `listademateriales` l
                INNER JOIN listadematerialesdetalle ld ON l.`CodigoListaMateriales`=ld.CodigoListaMateriales
                WHERE 
                `CodigoArticuloKit`='$codigoVariante'";
        $connection = Multiple::getConexionZonaVentas();
        return $connection->createCommand($sql)->queryAll();
    }

    public function getTransferenciaConsignacion($CodZonaVentas) {
        $sql = "SELECT * FROM `transferenciaconsignacion` where CodZonaVentas = '$CodZonaVentas' AND Estado=''";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getTransferenciaConsignacionDescripcion($id) {
        $sql = "SELECT * FROM `descripciontransferenciaconsignacion` WHERE `IdTransferencia`='$id'";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function UpdateTransfConsigTerminarRuta($zona, $agencia) {
        $sql = "UPDATE `transferenciaconsignacion` SET IdentificadorEnvio='1' WHERE CodZonaVentas ='$zona' AND FechaTransferencia = CURDATE() AND IdentificadorEnvio='0'";
        $consulta = new Multiple();
        $dataReader = $consulta->queryAgencia($agencia, $sql);
        return $dataReader;
    }

    public function cargarCargarCodigoGrupoPrecio($zonaVentas, $cuentaCliente) {
        try {
            Yii::import('application.extensions.multiple.Multiple');
            $sql = "SELECT `CodigoGrupoPrecio` FROM `clienteruta` WHERE  `CodZonaVentas`='$zonaVentas' AND `CuentaCliente`='$cuentaCliente';";
            $connection = Multiple::getConexionZonaVentas();
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $exc) {
            echo 'Error';
            return false;
        }
    }

    public function getPortafolioProductosTranferenciaConsignacion($zonaVentas, $GrupopPrecio) {
        $sql = "SELECT p.CodigoVariante, p.CodigoArticulo, p.NombreArticulo, p.CodigoArticulo, p.CodigoCaracteristica1, p.CodigoCaracteristica2, p.CodigoGrupoVentas, ac.IdAcuerdoComercial, ac.PrecioVenta
        FROM zonaventas z
        INNER JOIN gruposventas g ON g.CodigoGrupoVentas=z.CodigoGrupoVentas
        INNER JOIN portafolio p ON p.CodigoGrupoVentas=g.CodigoGrupoVentas
        INNER JOIN acuerdoscomercialesprecioventa ac ON p.CodigoVariante=ac.CodigoVariante
        WHERE z.`CodZonaVentas`='$zonaVentas'
        AND ac.PrecioVenta>0
        AND ac.CodigoGrupoPrecio='$GrupopPrecio'
        ORDER BY p.CodigoVariante, ac.PrecioVenta DESC";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getPortafolioProductos($zonaVentas) {
        $sql = "SELECT p.CodigoVariante, p.CodigoArticulo, p.NombreArticulo, p.CodigoArticulo, p.CodigoCaracteristica1, p.CodigoCaracteristica2, p.CodigoGrupoVentas
        FROM zonaventas z
        INNER JOIN gruposventas g ON g.CodigoGrupoVentas = z.CodigoGrupoVentas
        INNER JOIN portafolio p ON p.CodigoGrupoVentas = g.CodigoGrupoVentas
        WHERE z.`CodZonaVentas`='$zonaVentas'";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }

    public function getAcuerdoComercialArticuloTransferenciaConsignacionSitio($cuentaCliente, $codigoVariante, $codigoSitio, $zonaVentas) {
        $sql = "
            SELECT 
             a.CodigoVariante,
                        a.PrecioVenta,
                        a.CodigoUnidadMedida,
                        a.NombreUnidadMedida,
                        a.IdAcuerdoComercial
            FROM 
            `acuerdoscomercialesprecioventa` a
            INNER JOIN clienteruta cr ON a.CuentaCliente= cr.CuentaCliente
            
            WHERE a.`CodigoVariante`='$codigoVariante' 
            AND a.`TipoCuentaCliente`='1' 
            AND cr.CuentaCliente='$cuentaCliente'
            AND cr.CodZonaVentas='$zonaVentas'
            AND a.sitio='$codigoSitio'
            AND a.FechaInicio < CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getAcuerdoComercialGrupoTransferenciaConsignacionSitio($cuentaCliente, $codigoVariante, $codigoSitio, $zonaVentas) {
        $sql = "SELECT 
                a.CodigoVariante,
                           a.PrecioVenta,
                           a.CodigoUnidadMedida,
                           a.NombreUnidadMedida,
                           a.IdAcuerdoComercial
               FROM 
               `acuerdoscomercialesprecioventa` a
               INNER JOIN clienteruta cr ON a.CodigoGrupoPrecio= cr.CodigoGrupoPrecio
               WHERE a.`CodigoVariante`='$codigoVariante' 
               AND a.`TipoCuentaCliente`='2' 
               AND cr.CuentaCliente='$cuentaCliente'
               AND cr.CodZonaVentas='$zonaVentas'    
               AND a.sitio='$codigoSitio'
               AND a.FechaInicio < CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getAcuerdoComercialArticuloTransferenciaConsignacion($cuentaCliente, $codigoVariante, $zonaVentas) {
        $sql = "SELECT 
             a.CodigoVariante, a.PrecioVenta, a.CodigoUnidadMedida,a.NombreUnidadMedida,a.IdAcuerdoComercial
            FROM `acuerdoscomercialesprecioventa` a
            INNER JOIN clienteruta cr ON a.CuentaCliente= cr.CuentaCliente
            WHERE a.`CodigoVariante`='$codigoVariante' 
            AND a.`TipoCuentaCliente`='1' 
            AND cr.CuentaCliente='$cuentaCliente'
            AND cr.CodZonaVentas='$zonaVentas'
            AND a.sitio='$codigoSitio'
            AND a.FechaInicio < CURDATE()";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getAcuerdoComercialGrupoTransferenciaConsignacion($cuentaCliente, $codigoVariante, $zonaVentas) {
        $sql = "SELECT 
                a.CodigoVariante,
                           a.PrecioVenta,
                           a.CodigoUnidadMedida,
                           a.NombreUnidadMedida,
                           a.IdAcuerdoComercial
               FROM `acuerdoscomercialesprecioventa` a
               INNER JOIN clienteruta cr ON a.CodigoGrupoPrecio= cr.CodigoGrupoPrecio
               WHERE a.`CodigoVariante`='$codigoVariante' 
               AND a.`TipoCuentaCliente`='2' 
               AND cr.CuentaCliente='$cuentaCliente'
               AND cr.CodZonaVentas='$zonaVentas'    
               AND a.sitio='$codigoSitio'
               AND a.FechaInicio < CURDATE()
            ";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getTotalAcuerodPrecioVentaSitioAlamcen($sitio, $alamcen) {        
        $sql = "SELECT COUNT(*) as totalacuerdos FROM `acuerdoscomercialesprecioventa` WHERE Sitio = '$sitio' AND Almacen = '$alamcen'";
        $connection = Multiple::getConexionZonaVentas();
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getTransaccionExistente($id) {
        try {            
            $sql = "SELECT COUNT(*) AS transacciones FROM `transaccionesax` WHERE `CodTipoDocumentoActivity`='8' AND `IdDocumento`='$id'";
            $connection = Multiple::getConexionZonaVentas();
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryRow();
            return $dataReader;
        } catch (Exception $ex) {
            echo $ex->getMessage('Error');
        }
    }

}
