<?php

/**
 * This is the model class for table "devoluciones".
 *
 * The followings are the available columns in table 'devoluciones':
 * @property integer $IdDevolucion
 * @property string $CodAsesor
 * @property string $CodZonaVentas
 * @property string $CuentaCliente
 * @property string $CodigoMotivoDevolucion
 * @property string $CuentaProveedor
 * @property string $CodigoSitio
 * @property integer $TotalDevolucion
 * @property double $ValorDevolucion
 * @property string $FechaDevolucion
 * @property string $HoraInicio
 * @property string $HoraFinal
 * @property string $Estado
 * @property string $Observacion
 * @property integer $Web
 * @property string $ArchivoXml
 * @property string $IdDevolucionMaquina
 * @property string $IdentificadorEnvio
 * @property integer $Autoriza
 * @property string $QuienAutoriza
 * @property string $FechaAutorizacion
 * @property string $HoraAutorizacion
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property integer $ExtraRuta
 * @property integer $Ruta
 * @property string $Imei
 */
class Devoluciones extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'devoluciones';
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
            array('CodAsesor, CodZonaVentas, CuentaCliente, CodigoMotivoDevolucion, CuentaProveedor, CodigoSitio, TotalDevolucion, ValorDevolucion, FechaDevolucion, HoraFinal, IdDevolucionMaquina, IdentificadorEnvio, CodigoCanal, ExtraRuta, Ruta', 'required'),
            array('TotalDevolucion, Web, Autoriza, ExtraRuta, Ruta', 'numerical', 'integerOnly' => true),
            array('ValorDevolucion', 'numerical'),
            array('CodAsesor', 'length', 'max' => 16),
            array('CodZonaVentas, CuentaCliente, CodigoMotivoDevolucion, CuentaProveedor, CodigoCanal, Responsable', 'length', 'max' => 25),
            array('CodigoSitio, IdentificadorEnvio', 'length', 'max' => 15),
            array('Estado', 'length', 'max' => 1),
            array('IdDevolucionMaquina', 'length', 'max' => 60),
            array('QuienAutoriza', 'length', 'max' => 100),
            array('Imei', 'length', 'max' => 50),
            array('HoraInicio, Observacion, ArchivoXml, FechaAutorizacion, HoraAutorizacion', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdDevolucion, CodAsesor, CodZonaVentas, CuentaCliente, CodigoMotivoDevolucion, CuentaProveedor, CodigoSitio, TotalDevolucion, ValorDevolucion, FechaDevolucion, HoraInicio, HoraFinal, Estado, Observacion, Web, ArchivoXml, IdDevolucionMaquina, IdentificadorEnvio, Autoriza, QuienAutoriza, FechaAutorizacion, HoraAutorizacion, CodigoCanal, Responsable, ExtraRuta, Ruta, Imei', 'safe', 'on' => 'search'),
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
            'IdDevolucion' => 'Id Devolucion',
            'CodAsesor' => 'Cod Asesor',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CuentaCliente' => 'Cuenta Cliente',
            'CodigoMotivoDevolucion' => 'Codigo Motivo Devolucion',
            'CuentaProveedor' => 'Cuenta Proveedor',
            'CodigoSitio' => 'Codigo Sitio',
            'TotalDevolucion' => 'Total Devolucion',
            'ValorDevolucion' => 'Valor Devolucion',
            'FechaDevolucion' => 'Fecha Devolucion',
            'HoraInicio' => 'Hora Inicio',
            'HoraFinal' => 'Hora Final',
            'Estado' => 'Estado',
            'Observacion' => 'Observacion',
            'Web' => 'Web',
            'ArchivoXml' => 'Archivo Xml',
            'IdDevolucionMaquina' => 'Id Devolucion Maquina',
            'IdentificadorEnvio' => 'Identificador Envio',
            'Autoriza' => 'Autoriza',
            'QuienAutoriza' => 'Quien Autoriza',
            'FechaAutorizacion' => 'Fecha Autorizacion',
            'HoraAutorizacion' => 'Hora Autorizacion',
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

        $criteria->compare('IdDevolucion', $this->IdDevolucion);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);
        $criteria->compare('CodigoMotivoDevolucion', $this->CodigoMotivoDevolucion, true);
        $criteria->compare('CuentaProveedor', $this->CuentaProveedor, true);
        $criteria->compare('CodigoSitio', $this->CodigoSitio, true);
        $criteria->compare('TotalDevolucion', $this->TotalDevolucion);
        $criteria->compare('ValorDevolucion', $this->ValorDevolucion);
        $criteria->compare('FechaDevolucion', $this->FechaDevolucion, true);
        $criteria->compare('HoraInicio', $this->HoraInicio, true);
        $criteria->compare('HoraFinal', $this->HoraFinal, true);
        $criteria->compare('Estado', $this->Estado, true);
        $criteria->compare('Observacion', $this->Observacion, true);
        $criteria->compare('Web', $this->Web);
        $criteria->compare('ArchivoXml', $this->ArchivoXml, true);
        $criteria->compare('IdDevolucionMaquina', $this->IdDevolucionMaquina, true);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio, true);
        $criteria->compare('Autoriza', $this->Autoriza);
        $criteria->compare('QuienAutoriza', $this->QuienAutoriza, true);
        $criteria->compare('FechaAutorizacion', $this->FechaAutorizacion, true);
        $criteria->compare('HoraAutorizacion', $this->HoraAutorizacion, true);
        $criteria->compare('CodigoCanal', $this->CodigoCanal, true);
        $criteria->compare('Responsable', $this->Responsable, true);
        $criteria->compare('ExtraRuta', $this->ExtraRuta);
        $criteria->compare('Ruta', $this->Ruta);
        $criteria->compare('Imei', $this->Imei, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Devoluciones the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
 
}
