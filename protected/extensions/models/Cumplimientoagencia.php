<?php

/**
 * This is the model class for table "cumplimientoagencia".
 *
 * The followings are the available columns in table 'cumplimientoagencia':
 * @property integer $Id
 * @property string $DiasHabiles
 * @property string $DiasTranscurridos
 * @property string $Mes
 * @property string $Año
 * @property string $CodAgencia
 * @property string $NombreAgencia
 */
class Cumplimientoagencia extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cumplimientoagencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('DiasHabiles, DiasTranscurridos, Mes, Año, CodAgencia, NombreAgencia', 'required'),
			array('DiasHabiles, DiasTranscurridos, Mes, Año, CodAgencia, NombreAgencia', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, DiasHabiles, DiasTranscurridos, Mes, Año, CodAgencia, NombreAgencia', 'safe', 'on'=>'search'),
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
			'DiasHabiles' => 'Dias Habiles',
			'DiasTranscurridos' => 'Dias Transcurridos',
			'Mes' => 'Mes',
			'Año' => 'Año',
			'CodAgencia' => 'Cod Agencia',
			'NombreAgencia' => 'Nombre Agencia',
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
		$criteria->compare('DiasHabiles',$this->DiasHabiles,true);
		$criteria->compare('DiasTranscurridos',$this->DiasTranscurridos,true);
		$criteria->compare('Mes',$this->Mes,true);
		$criteria->compare('Año',$this->Año,true);
		$criteria->compare('CodAgencia',$this->CodAgencia,true);
		$criteria->compare('NombreAgencia',$this->NombreAgencia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cumplimientoagencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
