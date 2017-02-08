<?php

/**
 * This is the model class for table "facturasaldo".
 *
 * The followings are the available columns in table 'facturasaldo':
 * @property integer $Id
 * @property string $NumeroFactura
 * @property string $CuentaCliente
 * @property string $FechaFactura
 * @property string $ValorNetoFactura
 * @property string $CodigoCondicionPago
 * @property string $DtoProntoPagoNivel1
 * @property string $FechaDtoProntoPagoNivel1
 * @property string $DtoProntoPagoNivel2
 * @property string $FechaDtoProntoPagoNivel2
 * @property string $SaldoFactura
 * @property string $CodigoZonaVentas
 * @property string $CedulaAsesorComercial
 * @property string $FechaVencimientoFactura
 */
class Facturasaldo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'facturasaldo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NumeroFactura, CuentaCliente, ValorNetoFactura, CodigoCondicionPago, SaldoFactura, CodigoZonaVentas, CedulaAsesorComercial', 'length', 'max'=>25),
			array('DtoProntoPagoNivel1, DtoProntoPagoNivel2', 'length', 'max'=>10),
			array('FechaFactura, FechaDtoProntoPagoNivel1, FechaDtoProntoPagoNivel2, FechaVencimientoFactura', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, NumeroFactura, CuentaCliente, FechaFactura, ValorNetoFactura, CodigoCondicionPago, DtoProntoPagoNivel1, FechaDtoProntoPagoNivel1, DtoProntoPagoNivel2, FechaDtoProntoPagoNivel2, SaldoFactura, CodigoZonaVentas, CedulaAsesorComercial, FechaVencimientoFactura', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'NumeroFactura' => 'Numero Factura',
			'CuentaCliente' => 'Cuenta Cliente',
			'FechaFactura' => 'Fecha Factura',
			'ValorNetoFactura' => 'Valor Neto Factura',
			'CodigoCondicionPago' => 'Codigo Condicion Pago',
			'DtoProntoPagoNivel1' => 'Dto Pronto Pago Nivel1',
			'FechaDtoProntoPagoNivel1' => 'Fecha Dto Pronto Pago Nivel1',
			'DtoProntoPagoNivel2' => 'Dto Pronto Pago Nivel2',
			'FechaDtoProntoPagoNivel2' => 'Fecha Dto Pronto Pago Nivel2',
			'SaldoFactura' => 'Saldo Factura',
			'CodigoZonaVentas' => 'Codigo Zona Ventas',
			'CedulaAsesorComercial' => 'Cedula Asesor Comercial',
			'FechaVencimientoFactura' => 'Fecha Vencimiento Factura',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('NumeroFactura',$this->NumeroFactura,true);
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('FechaFactura',$this->FechaFactura,true);
		$criteria->compare('ValorNetoFactura',$this->ValorNetoFactura,true);
		$criteria->compare('CodigoCondicionPago',$this->CodigoCondicionPago,true);
		$criteria->compare('DtoProntoPagoNivel1',$this->DtoProntoPagoNivel1,true);
		$criteria->compare('FechaDtoProntoPagoNivel1',$this->FechaDtoProntoPagoNivel1,true);
		$criteria->compare('DtoProntoPagoNivel2',$this->DtoProntoPagoNivel2,true);
		$criteria->compare('FechaDtoProntoPagoNivel2',$this->FechaDtoProntoPagoNivel2,true);
		$criteria->compare('SaldoFactura',$this->SaldoFactura,true);
		$criteria->compare('CodigoZonaVentas',$this->CodigoZonaVentas,true);
		$criteria->compare('CedulaAsesorComercial',$this->CedulaAsesorComercial,true);
		$criteria->compare('FechaVencimientoFactura',$this->FechaVencimientoFactura,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Facturasaldo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
