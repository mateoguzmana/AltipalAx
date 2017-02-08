<?php

/**
 * This is the model class for table "notascreditofoto".
 *
 * The followings are the available columns in table 'notascreditofoto':
 * @property integer $IdNotaCredito
 * @property integer $id
 * @property string $Nombre
 * @property string $CodZonaVentas
 * @property string $CuentaCliente
 * @property string $Factura
 * @property string $Fecha
 * @property string $Hora
 */
class Notascreditofoto extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notascreditofoto';
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
			array('IdNotaCredito, Nombre, CodZonaVentas, CuentaCliente, Factura, Fecha, Hora', 'required'),
			array('IdNotaCredito', 'numerical', 'integerOnly'=>true),
			array('Nombre, CodZonaVentas, CuentaCliente, Factura', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IdNotaCredito, id, Nombre, CodZonaVentas, CuentaCliente, Factura, Fecha, Hora', 'safe', 'on'=>'search'),
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
			'IdNotaCredito' => 'Id Nota Credito',
			'id' => 'ID',
			'Nombre' => 'Nombre',
			'CodZonaVentas' => 'Cod Zona Ventas',
			'CuentaCliente' => 'Cuenta Cliente',
			'Factura' => 'Factura',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
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

		$criteria->compare('IdNotaCredito',$this->IdNotaCredito);
		$criteria->compare('id',$this->id);
		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('CodZonaVentas',$this->CodZonaVentas,true);
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('Factura',$this->Factura,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notascreditofoto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
