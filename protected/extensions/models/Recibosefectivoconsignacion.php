<?php

/**
 * This is the model class for table "recibosefectivoconsignacion".
 *
 * The followings are the available columns in table 'recibosefectivoconsignacion':
 * @property integer $Id
 * @property integer $IdReciboCajaFacturas
 * @property integer $NroConsignacionEfectivo
 * @property string $CodBanco
 * @property string $CodCuentaBancaria
 * @property string $Fecha
 * @property double $Valor
 * @property double $ValorTotal
 * @property int $TipoConsignacion
 */
class Recibosefectivoconsignacion extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'recibosefectivoconsignacion';
	}
        
           public function getDbConnection()
            {
                return self::setConexion();
            }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdReciboCajaFacturas, NroConsignacionEfectivo, CodBanco, CodCuentaBancaria, Fecha, Valor, ValorTotal,TipoConsignacion', 'required'),
			array('IdReciboCajaFacturas, NroConsignacionEfectivo', 'numerical', 'integerOnly'=>true),
			array('Valor, ValorTotal', 'numerical'),
			array('CodBanco', 'length', 'max'=>25),
			array('CodCuentaBancaria', 'length', 'max'=>75),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, IdReciboCajaFacturas, NroConsignacionEfectivo, CodBanco, CodCuentaBancaria, Fecha, Valor, ValorTotal, TipoConsignacion', 'safe', 'on'=>'search'),
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
			'IdReciboCajaFacturas' => 'Id Recibo Caja Facturas',
			'NroConsignacionEfectivo' => 'Nro Consignacion Efectivo',
			'CodBanco' => 'Cod Banco',
			'CodCuentaBancaria' => 'Cod Cuenta Bancaria',
			'Fecha' => 'Fecha',
			'Valor' => 'Valor',
			'ValorTotal' => 'Valor Total',
			'TipoConsignacion' => 'Tipo Consignacion'
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
		$criteria->compare('IdReciboCajaFacturas',$this->IdReciboCajaFacturas);
		$criteria->compare('NroConsignacionEfectivo',$this->NroConsignacionEfectivo);
		$criteria->compare('CodBanco',$this->CodBanco,true);
		$criteria->compare('CodCuentaBancaria',$this->CodCuentaBancaria,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Valor',$this->Valor);
		$criteria->compare('ValorTotal',$this->ValorTotal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Recibosefectivoconsignacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
