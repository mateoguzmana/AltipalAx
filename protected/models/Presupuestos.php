<?php

/**
 * This is the model class for table "presupuestos".
 *
 * The followings are the available columns in table 'presupuestos':
 * @property integer $Id
 * @property string $CodZonaVentas
 * @property string $Agencia
 * @property string $NombreAgencia
 * @property string $Año
 * @property string $Mes
 * @property string $DiasHabiles
 * @property string $DiasTranscurridos
 */
class Presupuestos extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'presupuestos';
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
			array('CodZonaVentas, Agencia, NombreAgencia, Año, Mes, DiasHabiles, DiasTranscurridos', 'required'),
			array('CodZonaVentas, Agencia, NombreAgencia, Año, Mes, DiasHabiles, DiasTranscurridos', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, CodZonaVentas, Agencia, NombreAgencia, Año, Mes, DiasHabiles, DiasTranscurridos', 'safe', 'on'=>'search'),
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
			'CodZonaVentas' => 'Cod Zona Ventas',
			'Agencia' => 'Agencia',
			'NombreAgencia' => 'Nombre Agencia',
			'Año' => 'Año',
			'Mes' => 'Mes',
			'DiasHabiles' => 'Dias Habiles',
			'DiasTranscurridos' => 'Dias Transcurridos',
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
		$criteria->compare('CodZonaVentas',$this->CodZonaVentas,true);
		$criteria->compare('Agencia',$this->Agencia,true);
		$criteria->compare('NombreAgencia',$this->NombreAgencia,true);
		$criteria->compare('Año',$this->Año,true);
		$criteria->compare('Mes',$this->Mes,true);
		$criteria->compare('DiasHabiles',$this->DiasHabiles,true);
		$criteria->compare('DiasTranscurridos',$this->DiasTranscurridos,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Presupuestos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
