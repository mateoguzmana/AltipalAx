<?php

/**
 * This is the model class for table "presupuestodimenciones".
 *
 * The followings are the available columns in table 'presupuestodimenciones':
 * @property integer $Id
 * @property integer $IdPresupuesto
 * @property integer $CodDimension
 * @property integer $NombreDimension
 * @property string $Presupuestado
 * @property string $Ejecutado
 * @property string $PorcentajeCumplimiento
 * @property string $Tipo
 * @property string $Indicador
 */
class Presupuestodimenciones extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'presupuestodimenciones';
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
            array('IdPresupuesto, CodDimension, NombreDimension, Presupuestado, Ejecutado, PorcentajeCumplimiento, Tipo, Indicador', 'required'),
            array('IdPresupuesto, CodDimension, NombreDimension', 'numerical', 'integerOnly' => true),
            array('Presupuestado, Ejecutado, PorcentajeCumplimiento, Tipo, Indicador', 'length', 'max' => 25),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, IdPresupuesto, CodDimension, NombreDimension, Presupuestado, Ejecutado, PorcentajeCumplimiento, Tipo, Indicador', 'safe', 'on' => 'search'),
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
            'CodDimension' => 'Cod Dimension',
            'NombreDimension' => 'Nombre Dimension',
            'Presupuestado' => 'Presupuestado',
            'Ejecutado' => 'Ejecutado',
            'PorcentajeCumplimiento' => 'Porcentaje Cumplimiento',
            'Tipo' => 'Tipo',
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
        $criteria->compare('CodDimension', $this->CodDimension);
        $criteria->compare('NombreDimension', $this->NombreDimension);
        $criteria->compare('Presupuestado', $this->Presupuestado, true);
        $criteria->compare('Ejecutado', $this->Ejecutado, true);
        $criteria->compare('PorcentajeCumplimiento', $this->PorcentajeCumplimiento, true);
        $criteria->compare('Tipo', $this->Tipo, true);
        $criteria->compare('Indicador', $this->Indicador, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Presupuestodimenciones the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
