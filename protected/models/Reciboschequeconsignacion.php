<?php

/**
 * This is the model class for table "reciboschequeconsignacion".
 *
 * The followings are the available columns in table 'reciboschequeconsignacion':
 * @property integer $Id
 * @property integer $IdReciboCajaFacturas
 * @property integer $NroConsignacionCheque
 * @property string $CodBanco
 * @property string $CodCuentaBancaria
 * @property string $Fecha
 *
 * The followings are the available model relations:
 * @property Reciboscajafacturas $idReciboCajaFacturas
 * @property Cuentasbancarias $codCuentaBancaria
 * @property Bancos $codBanco
 * @property Reciboschequeconsignaciondetalle[] $reciboschequeconsignaciondetalles
 */
class Reciboschequeconsignacion extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reciboschequeconsignacion';
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
			array('IdReciboCajaFacturas, NroConsignacionCheque, CodBanco, CodCuentaBancaria, Fecha', 'required'),
			array('IdReciboCajaFacturas, NroConsignacionCheque', 'numerical', 'integerOnly'=>true),
			array('CodBanco', 'length', 'max'=>25),
			array('CodCuentaBancaria', 'length', 'max'=>75),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, IdReciboCajaFacturas, NroConsignacionCheque, CodBanco, CodCuentaBancaria, Fecha', 'safe', 'on'=>'search'),
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
			'idReciboCajaFacturas' => array(self::BELONGS_TO, 'Reciboscajafacturas', 'IdReciboCajaFacturas'),
			'codCuentaBancaria' => array(self::BELONGS_TO, 'Cuentasbancarias', 'CodCuentaBancaria'),
			'codBanco' => array(self::BELONGS_TO, 'Bancos', 'CodBanco'),
			'reciboschequeconsignaciondetalles' => array(self::HAS_MANY, 'Reciboschequeconsignaciondetalle', 'IdRecibosChequeConsignacion'),
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
			'NroConsignacionCheque' => 'Nro Consignacion Cheque',
			'CodBanco' => 'Cod Banco',
			'CodCuentaBancaria' => 'Cod Cuenta Bancaria',
			'Fecha' => 'Fecha',
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
		$criteria->compare('NroConsignacionCheque',$this->NroConsignacionCheque);
		$criteria->compare('CodBanco',$this->CodBanco,true);
		$criteria->compare('CodCuentaBancaria',$this->CodCuentaBancaria,true);
		$criteria->compare('Fecha',$this->Fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reciboschequeconsignacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
