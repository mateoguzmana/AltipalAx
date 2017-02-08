<?php

/**
 * This is the model class for table "encuestas".
 *
 * The followings are the available columns in table 'encuestas':
 * @property integer $IdEncuesta
 * @property integer $IdTituloEncuesta
 * @property string $CuentaCliente
 * @property string $CodZonaVentas
 * @property string $CodAsesor
 * @property string $FechaEnvio
 * @property string $HoraEnvio
 * @property string $FechaDispositivo
 * @property string $HoraDispositivo
 * @property integer $Consecutivo
 * @property integer $IdentificadorEnvio
 */
class Encuestas extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'encuestas';
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
            array('IdTituloEncuesta, CuentaCliente, CodZonaVentas, CodAsesor, FechaEnvio, HoraEnvio, FechaDispositivo, HoraDispositivo, Consecutivo, IdentificadorEnvio', 'required'),
            array('IdTituloEncuesta, Consecutivo, IdentificadorEnvio', 'numerical', 'integerOnly' => true),
            array('CuentaCliente, CodZonaVentas', 'length', 'max' => 50),
            array('CodAsesor', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdEncuesta, IdTituloEncuesta, CuentaCliente, CodZonaVentas, CodAsesor, FechaEnvio, HoraEnvio, FechaDispositivo, HoraDispositivo, Consecutivo, IdentificadorEnvio', 'safe', 'on' => 'search'),
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
            'IdEncuesta' => 'Id Encuesta',
            'IdTituloEncuesta' => 'Id Titulo Encuesta',
            'CuentaCliente' => 'Cuenta Cliente',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CodAsesor' => 'Cod Asesor',
            'FechaEnvio' => 'Fecha Envio',
            'HoraEnvio' => 'Hora Envio',
            'FechaDispositivo' => 'Fecha Dispositivo',
            'HoraDispositivo' => 'Hora Dispositivo',
            'Consecutivo' => 'Consecutivo',
            'IdentificadorEnvio' => 'Identificador Envio',
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

        $criteria->compare('IdEncuesta', $this->IdEncuesta);
        $criteria->compare('IdTituloEncuesta', $this->IdTituloEncuesta);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);
        $criteria->compare('FechaEnvio', $this->FechaEnvio, true);
        $criteria->compare('HoraEnvio', $this->HoraEnvio, true);
        $criteria->compare('FechaDispositivo', $this->FechaDispositivo, true);
        $criteria->compare('HoraDispositivo', $this->HoraDispositivo, true);
        $criteria->compare('Consecutivo', $this->Consecutivo);
        $criteria->compare('IdentificadorEnvio', $this->IdentificadorEnvio);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Encuestas the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
