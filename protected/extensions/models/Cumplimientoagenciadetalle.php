<?php

/**
 * This is the model class for table "cumplimientoagenciadetalle".
 *
 * The followings are the available columns in table 'cumplimientoagenciadetalle':
 * @property integer $Id
 * @property integer $IdCumplimientoAgencia
 * @property string $Presupuestado
 * @property string $NombreDimension
 * @property string $Ejecutado
 * @property string $Cumplimiento
 */
class Cumplimientoagenciadetalle extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cumplimientoagenciadetalle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdCumplimientoAgencia, Presupuestado, NombreDimension, Ejecutado, Cumplimiento', 'required'),
			array('IdCumplimientoAgencia', 'numerical', 'integerOnly'=>true),
			array('Presupuestado, NombreDimension, Ejecutado, Cumplimiento', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, IdCumplimientoAgencia, Presupuestado, NombreDimension, Ejecutado, Cumplimiento', 'safe', 'on'=>'search'),
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
			'IdCumplimientoAgencia' => 'Id Cumplimiento Agencia',
			'Presupuestado' => 'Presupuestado',
			'NombreDimension' => 'Nombre Dimension',
			'Ejecutado' => 'Ejecutado',
			'Cumplimiento' => 'Cumplimiento',
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
		$criteria->compare('IdCumplimientoAgencia',$this->IdCumplimientoAgencia);
		$criteria->compare('Presupuestado',$this->Presupuestado,true);
		$criteria->compare('NombreDimension',$this->NombreDimension,true);
		$criteria->compare('Ejecutado',$this->Ejecutado,true);
		$criteria->compare('Cumplimiento',$this->Cumplimiento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cumplimientoagenciadetalle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
