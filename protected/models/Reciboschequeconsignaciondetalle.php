<?php

/**
 * This is the model class for table "reciboschequeconsignaciondetalle".
 *
 * The followings are the available columns in table 'reciboschequeconsignaciondetalle':
 * @property integer $Id
 * @property integer $IdRecibosChequeConsignacion
 * @property integer $NroChequeConsignacion
 * @property string $CodBanco
 * @property string $CuentaBancaria
 * @property string $Fecha
 * @property double $Valor
 * @property double $ValorTotal
 */
class Reciboschequeconsignaciondetalle extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'reciboschequeconsignaciondetalle';
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
            array('IdRecibosChequeConsignacion, NroChequeConsignacion, CodBanco, CuentaBancaria, Fecha, Valor, ValorTotal', 'required'),
            array('IdRecibosChequeConsignacion, NroChequeConsignacion', 'numerical', 'integerOnly' => true),
            array('Valor, ValorTotal', 'numerical'),
            array('CodBanco', 'length', 'max' => 25),
            array('CuentaBancaria', 'length', 'max' => 75),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, IdRecibosChequeConsignacion, NroChequeConsignacion, CodBanco, CuentaBancaria, Fecha, Valor, ValorTotal', 'safe', 'on' => 'search'),
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
            'IdRecibosChequeConsignacion' => 'Id Recibos Cheque Consignacion',
            'NroChequeConsignacion' => 'Nro Cheque Consignacion',
            'CodBanco' => 'Cod Banco',
            'CuentaBancaria' => 'Cuenta Bancaria',
            'Fecha' => 'Fecha',
            'Valor' => 'Valor',
            'ValorTotal' => 'Valor Total',
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
        $criteria->compare('IdRecibosChequeConsignacion', $this->IdRecibosChequeConsignacion);
        $criteria->compare('NroChequeConsignacion', $this->NroChequeConsignacion);
        $criteria->compare('CodBanco', $this->CodBanco, true);
        $criteria->compare('CuentaBancaria', $this->CuentaBancaria, true);
        $criteria->compare('Fecha', $this->Fecha, true);
        $criteria->compare('Valor', $this->Valor);
        $criteria->compare('ValorTotal', $this->ValorTotal);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Reciboschequeconsignaciondetalle the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
