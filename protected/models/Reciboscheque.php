<?php

/**
 * This is the model class for table "reciboscheque".
 *
 * The followings are the available columns in table 'reciboscheque':
 * @property integer $Id
 * @property integer $IdReciboCajaFacturas
 * @property integer $NroCheque
 * @property string $CodBanco
 * @property string $CuentaCheque
 * @property string $Fecha
 * @property string $Girado
 * @property string $Otro
 * @property double $Valor
 * @property integer $Posfechado
 * @property string $ArchivoXml
 * @property double $ValorTotal
 */
class Reciboscheque extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reciboscheque';
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
			array('IdReciboCajaFacturas, NroCheque, CodBanco, CuentaCheque, Fecha, Valor, ValorTotal', 'required'),
			array('IdReciboCajaFacturas, NroCheque, Posfechado', 'numerical', 'integerOnly'=>true),
			array('Valor, ValorTotal', 'numerical'),
			array('CodBanco', 'length', 'max'=>25),
			array('CuentaCheque, ArchivoXml', 'length', 'max'=>75),
			array('Girado', 'length', 'max'=>7),
			array('Otro', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, IdReciboCajaFacturas, NroCheque, CodBanco, CuentaCheque, Fecha, Girado, Otro, Valor, Posfechado, ArchivoXml, ValorTotal', 'safe', 'on'=>'search'),
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
			'NroCheque' => 'Nro Cheque',
			'CodBanco' => 'Cod Banco',
			'CuentaCheque' => 'Cuenta Cheque',
			'Fecha' => 'Fecha',
			'Girado' => 'Girado',
			'Otro' => 'Otro',
			'Valor' => 'Valor',
			'Posfechado' => 'Posfechado',
			'ArchivoXml' => 'Archivo Xml',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('IdReciboCajaFacturas',$this->IdReciboCajaFacturas);
		$criteria->compare('NroCheque',$this->NroCheque);
		$criteria->compare('CodBanco',$this->CodBanco,true);
		$criteria->compare('CuentaCheque',$this->CuentaCheque,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Girado',$this->Girado,true);
		$criteria->compare('Otro',$this->Otro,true);
		$criteria->compare('Valor',$this->Valor);
		$criteria->compare('Posfechado',$this->Posfechado);
		$criteria->compare('ArchivoXml',$this->ArchivoXml,true);
		$criteria->compare('ValorTotal',$this->ValorTotal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reciboscheque the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
