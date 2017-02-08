<?php

/**
 * This is the model class for table "presupuestofabricante".
 *
 * The followings are the available columns in table 'presupuestofabricante':
 * @property integer $Id
 * @property integer $IdPresupuesto
 * @property string $CodigoFabricante
 * @property string $NombreFabricante
 * @property double $Pesos
 * @property double $Devoluciones
 * @property double $CuotaPesos
 * @property double $Cumplimiento
 */
class Presupuestofabricante extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'presupuestofabricante';
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
            array('IdPresupuesto, CodigoFabricante, NombreFabricante, Pesos, Devoluciones, CuotaPesos, Cumplimiento', 'required'),
            array('IdPresupuesto', 'numerical', 'integerOnly' => true),
            array('Pesos, Devoluciones, CuotaPesos, Cumplimiento', 'numerical'),
            array('CodigoFabricante, NombreFabricante', 'length', 'max' => 25),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, IdPresupuesto, CodigoFabricante, NombreFabricante, Pesos, Devoluciones, CuotaPesos, Cumplimiento', 'safe', 'on' => 'search'),
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
            'IdPresupuesto' => 'Id Presupuesto',
            'CodigoFabricante' => 'Codigo Fabricante',
            'NombreFabricante' => 'Nombre Fabricante',
            'Pesos' => 'Pesos',
            'Devoluciones' => 'Devoluciones',
            'CuotaPesos' => 'Cuota Pesos',
            'Cumplimiento' => 'Cumplimiento',
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
        $criteria->compare('IdPresupuesto', $this->IdPresupuesto);
        $criteria->compare('CodigoFabricante', $this->CodigoFabricante, true);
        $criteria->compare('NombreFabricante', $this->NombreFabricante, true);
        $criteria->compare('Pesos', $this->Pesos);
        $criteria->compare('Devoluciones', $this->Devoluciones);
        $criteria->compare('CuotaPesos', $this->CuotaPesos);
        $criteria->compare('Cumplimiento', $this->Cumplimiento);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Presupuestofabricante the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
