<?php

/**
 * This is the model class for table "detalleencuestas".
 *
 * The followings are the available columns in table 'detalleencuestas':
 * @property integer $IdDetalle
 * @property integer $IdEncuesta
 * @property integer $IdPregunta
 * @property integer $IdRespuesta
 * @property string $Texto
 * @property string $Foto
 */
class Detalleencuestas extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'detalleencuestas';
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
            array('IdEncuesta, IdPregunta, IdRespuesta, Texto, Foto', 'required'),
            array('IdEncuesta, IdPregunta, IdRespuesta', 'numerical', 'integerOnly' => true),
            array('Texto, Foto', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('IdDetalle, IdEncuesta, IdPregunta, IdRespuesta, Texto, Foto', 'safe', 'on' => 'search'),
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
            'IdDetalle' => 'Id Detalle',
            'IdEncuesta' => 'Id Encuesta',
            'IdPregunta' => 'Id Pregunta',
            'IdRespuesta' => 'Id Respuesta',
            'Texto' => 'Texto',
            'Foto' => 'Foto',
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

        $criteria->compare('IdDetalle', $this->IdDetalle);
        $criteria->compare('IdEncuesta', $this->IdEncuesta);
        $criteria->compare('IdPregunta', $this->IdPregunta);
        $criteria->compare('IdRespuesta', $this->IdRespuesta);
        $criteria->compare('Texto', $this->Texto, true);
        $criteria->compare('Foto', $this->Foto, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Detalleencuestas the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
