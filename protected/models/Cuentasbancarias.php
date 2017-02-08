<?php

/**
 * This is the model class for table "cuentasbancarias".
 *
 * The followings are the available columns in table 'cuentasbancarias':
 * @property string $CodCuentaBancaria
 * @property string $NombreCuentaBancaria
 * @property string $NumeroCuentaBancaria
 * @property integer $CodBanco
 *
 * The followings are the available model relations:
 * @property Bancos $codBanco
 */
class Cuentasbancarias extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cuentasbancarias';
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
			array('CodCuentaBancaria, NumeroCuentaBancaria, CodBanco', 'required'),
			array('CodBanco', 'numerical', 'integerOnly'=>true),
			array('CodCuentaBancaria', 'length', 'max'=>75),
			array('NombreCuentaBancaria', 'length', 'max'=>120),
			array('NumeroCuentaBancaria', 'length', 'max'=>35),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('CodCuentaBancaria, NombreCuentaBancaria, NumeroCuentaBancaria, CodBanco', 'safe', 'on'=>'search'),
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
			'codBanco' => array(self::BELONGS_TO, 'Bancos', 'CodBanco'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CodCuentaBancaria' => 'Cod Cuenta Bancaria',
			'NombreCuentaBancaria' => 'Nombre Cuenta Bancaria',
			'NumeroCuentaBancaria' => 'Numero Cuenta Bancaria',
			'CodBanco' => 'Cod Banco',
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

		$criteria->compare('CodCuentaBancaria',$this->CodCuentaBancaria,true);
		$criteria->compare('NombreCuentaBancaria',$this->NombreCuentaBancaria,true);
		$criteria->compare('NumeroCuentaBancaria',$this->NumeroCuentaBancaria,true);
		$criteria->compare('CodBanco',$this->CodBanco);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cuentasbancarias the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
