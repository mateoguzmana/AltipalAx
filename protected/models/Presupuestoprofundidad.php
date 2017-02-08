<?php

/**
 * This is the model class for table "presupuestoprofundidad".
 *
 * The followings are the available columns in table 'presupuestoprofundidad':
 * @property integer $Id
 * @property integer $IdPresupuesto
 * @property string $Presupuestado
 * @property string $Tipo
 * @property string $CodDimension
 * @property string $NombreDimension
 * @property string $Ejecutado
 * @property string $PorcentajeCumplimiento
 * @property string $Indicador
 */
class Presupuestoprofundidad extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'presupuestoprofundidad';
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
            array('IdPresupuesto, Presupuestado, Tipo, CodDimension, NombreDimension, Ejecutado, PorcentajeCumplimiento, Indicador', 'required'),
            array('IdPresupuesto', 'numerical', 'integerOnly' => true),
            array('Presupuestado, Tipo, CodDimension, NombreDimension, Ejecutado, PorcentajeCumplimiento, Indicador', 'length', 'max' => 25),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, IdPresupuesto, Presupuestado, Tipo, CodDimension, NombreDimension, Ejecutado, PorcentajeCumplimiento, Indicador', 'safe', 'on' => 'search'),
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
            'Presupuestado' => 'Presupuestado',
            'Tipo' => 'Tipo',
            'CodDimension' => 'Cod Dimension',
            'NombreDimension' => 'Nombre Dimension',
            'Ejecutado' => 'Ejecutado',
            'PorcentajeCumplimiento' => 'Porcentaje Cumplimiento',
            'Indicador' => 'Indicador',
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
        $criteria->compare('Presupuestado', $this->Presupuestado, true);
        $criteria->compare('Tipo', $this->Tipo, true);
        $criteria->compare('CodDimension', $this->CodDimension, true);
        $criteria->compare('NombreDimension', $this->NombreDimension, true);
        $criteria->compare('Ejecutado', $this->Ejecutado, true);
        $criteria->compare('PorcentajeCumplimiento', $this->PorcentajeCumplimiento, true);
        $criteria->compare('Indicador', $this->Indicador, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Presupuestoprofundidad the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
