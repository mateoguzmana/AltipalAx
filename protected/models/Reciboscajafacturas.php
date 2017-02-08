<?php

/**
 * This is the model class for table "reciboscajafacturas".
 *
 * The followings are the available columns in table 'reciboscajafacturas':
 * @property integer $Id
 * @property integer $IdReciboCaja
 * @property string $ZonaVentaFactura
 * @property string $NumeroFactura
 * @property integer $ValorAbono
 * @property string $DtoProntoPago
 * @property string $CodMotivoSaldo
 * @property string $ValorFactura
 * @property string $SaldoFactura
 * @property string $CuentaCliente
 */
class Reciboscajafacturas extends AgenciaActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'reciboscajafacturas';
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
            array('IdReciboCaja, ZonaVentaFactura, NumeroFactura, ValorAbono, ValorFactura, SaldoFactura, CuentaCliente', 'required'),
            array('IdReciboCaja, ValorAbono', 'numerical', 'integerOnly' => true),
            array('ZonaVentaFactura, NumeroFactura, ValorFactura, SaldoFactura, CuentaCliente', 'length', 'max' => 25),
            array('DtoProntoPago', 'length', 'max' => 10),
            array('CodMotivoSaldo', 'length', 'max' => 15),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('Id, IdReciboCaja, ZonaVentaFactura, NumeroFactura, ValorAbono, DtoProntoPago, CodMotivoSaldo, ValorFactura, SaldoFactura, CuentaCliente', 'safe', 'on' => 'search'),
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
            'IdReciboCaja' => 'Id Recibo Caja',
            'ZonaVentaFactura' => 'Zona Venta Factura',
            'NumeroFactura' => 'Numero Factura',
            'ValorAbono' => 'Valor Abono',
            'DtoProntoPago' => 'Dto Pronto Pago',
            'CodMotivoSaldo' => 'Cod Motivo Saldo',
            'ValorFactura' => 'Valor Factura',
            'SaldoFactura' => 'Saldo Factura',
            'CuentaCliente' => 'Cuenta Cliente',
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
        $criteria->compare('IdReciboCaja', $this->IdReciboCaja);
        $criteria->compare('ZonaVentaFactura', $this->ZonaVentaFactura, true);
        $criteria->compare('NumeroFactura', $this->NumeroFactura, true);
        $criteria->compare('ValorAbono', $this->ValorAbono);
        $criteria->compare('DtoProntoPago', $this->DtoProntoPago, true);
        $criteria->compare('CodMotivoSaldo', $this->CodMotivoSaldo, true);
        $criteria->compare('ValorFactura', $this->ValorFactura, true);
        $criteria->compare('SaldoFactura', $this->SaldoFactura, true);
        $criteria->compare('CuentaCliente', $this->CuentaCliente, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Reciboscajafacturas the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
