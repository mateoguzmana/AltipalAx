<?php

/**
 * This is the model class for table "clientesencuestados".
 *
 * The followings are the available columns in table 'clientesencuestados':
 * @property integer $Id
 * @property string $CuentaCliente
 * @property integer $IdEncuesta
 * @property string $Fecha
 * @property string $Hora
 * @property string $CodZonaVentas
 * @property string $CodAgencia
 */
class Clientesencuestados extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'clientesencuestados';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CuentaCliente, IdEncuesta, Fecha, Hora, CodZonaVentas, CodAgencia', 'required'),
			array('IdEncuesta', 'numerical', 'integerOnly'=>true),
			array('CuentaCliente', 'length', 'max'=>25),
			array('CodZonaVentas, CodAgencia', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, CuentaCliente, IdEncuesta, Fecha, Hora, CodZonaVentas, CodAgencia', 'safe', 'on'=>'search'),
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
			'CuentaCliente' => 'Cuenta Cliente',
			'IdEncuesta' => 'Id Encuesta',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'CodZonaVentas' => 'Cod Zona Ventas',
			'CodAgencia' => 'Cod Agencia',
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
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('IdEncuesta',$this->IdEncuesta);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('CodZonaVentas',$this->CodZonaVentas,true);
		$criteria->compare('CodAgencia',$this->CodAgencia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Clientesencuestados the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
