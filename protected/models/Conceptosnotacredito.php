<?php

/**
 * This is the model class for table "conceptosnotacredito".
 *
 * The followings are the available columns in table 'conceptosnotacredito':
 * @property integer $Id
 * @property string $CodigoConceptoNotaCredito
 * @property string $NombreConceptoNotaCredito
 * @property integer $Interfaz
 *
 * The followings are the available model relations:
 * @property Responsablenota $interfaz
 */
class Conceptosnotacredito extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function getDbConnection() {
        return self::setConexion();
    }

    public function tableName() {
        return 'conceptosnotacredito';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('CodigoConceptoNotaCredito, Interfaz', 'required'),
            array('Interfaz', 'numerical', 'integerOnly' => true),
            array('CodigoConceptoNotaCredito', 'length', 'max' => 25),
            array('NombreConceptoNotaCredito', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, CodigoConceptoNotaCredito, NombreConceptoNotaCredito, Interfaz', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'interfaz' => array(self::BELONGS_TO, 'Responsablenota', 'Interfaz'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'CodigoConceptoNotaCredito' => 'Codigo Concepto Nota Credito',
            'NombreConceptoNotaCredito' => 'Nombre Concepto Nota Credito',
            'Interfaz' => 'Interfaz',
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
        $criteria->compare('CodigoConceptoNotaCredito', $this->CodigoConceptoNotaCredito, true);
        $criteria->compare('NombreConceptoNotaCredito', $this->NombreConceptoNotaCredito, true);
        $criteria->compare('Interfaz', $this->Interfaz);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Conceptosnotacredito the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
