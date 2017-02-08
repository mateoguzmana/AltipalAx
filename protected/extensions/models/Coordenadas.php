<?php

/**
 * This is the model class for table "coordenadas".
 *
 * The followings are the available columns in table 'coordenadas':
 * @property integer $Id
 * @property string $CuentaCliente
 * @property string $IdDocumento
 * @property string $Origen
 * @property string $Longitud
 * @property string $Latitud
 * @property string $Fecha
 * @property string $Hora
 * @property string $CodZonaVentas
 * @property string $CodAsesor
 */
class Coordenadas extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'coordenadas';
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
            array('CuentaCliente, IdDocumento, Origen, Longitud, Latitud, Fecha, Hora, CodZonaVentas, CodAsesor', 'required'),
            array('CuentaCliente, IdDocumento, Origen', 'length', 'max' => 25),
            array('Longitud, Latitud', 'length', 'max' => 50),
            array('CodZonaVentas, CodAsesor', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, CuentaCliente, IdDocumento, Origen, Longitud, Latitud, Fecha, Hora, CodZonaVentas, CodAsesor', 'safe', 'on' => 'search'),
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
            'Id' => 'ID',
            'CuentaCliente' => 'Cuenta Cliente',
            'IdDocumento' => 'Id Documento',
            'Origen' => 'Origen',
            'Longitud' => 'Longitud',
            'Latitud' => 'Latitud',
            'Fecha' => 'Fecha',
            'Hora' => 'Hora',
            'CodZonaVentas' => 'Cod Zona Ventas',
            'CodAsesor' => 'Cod Asesor',
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

        $criteria->compare('Id', $this->Id);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);
        $criteria->compare('IdDocumento', $this->IdDocumento, true);
        $criteria->compare('Origen', $this->Origen, true);
        $criteria->compare('Longitud', $this->Longitud, true);
        $criteria->compare('Latitud', $this->Latitud, true);
        $criteria->compare('Fecha', $this->Fecha, true);
        $criteria->compare('Hora', $this->Hora, true);
        $criteria->compare('CodZonaVentas', $this->CodZonaVentas, true);
        $criteria->compare('CodAsesor', $this->CodAsesor, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Coordenadas the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
