<?php

/**
 * This is the model class for table "saldosinventariopreventa".
 *
 * The followings are the available columns in table 'saldosinventariopreventa':
 * @property integer $Id
 * @property string $CodigoSitio
 * @property string $NombreSitio
 * @property string $CodigoAlmacen
 * @property string $CodigoVariante
 * @property string $CodigoArticulo
 * @property string $CodigoCaracteristica1
 * @property string $CodigoCaracteristica2
 * @property string $CodigoTipo
 * @property string $Disponible
 * @property string $CodigoUnidadMedida
 * @property string $NombreUnidadMedida
 */
class Saldosinventariopreventa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'saldosinventariopreventa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('CodigoVariante, CodigoUnidadMedida, NombreUnidadMedida', 'required'),
			array('CodigoSitio, CodigoAlmacen, CodigoArticulo, CodigoCaracteristica2, CodigoUnidadMedida, NombreUnidadMedida', 'length', 'max'=>25),
			array('NombreSitio, CodigoVariante, CodigoCaracteristica1, CodigoTipo', 'length', 'max'=>50),
			array('Disponible', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, CodigoSitio, NombreSitio, CodigoAlmacen, CodigoVariante, CodigoArticulo, CodigoCaracteristica1, CodigoCaracteristica2, CodigoTipo, Disponible, CodigoUnidadMedida, NombreUnidadMedida', 'safe', 'on'=>'search'),
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
			'CodigoSitio' => 'Codigo Sitio',
			'NombreSitio' => 'Nombre Sitio',
			'CodigoAlmacen' => 'Codigo Almacen',
			'CodigoVariante' => 'Codigo Variante',
			'CodigoArticulo' => 'Codigo Articulo',
			'CodigoCaracteristica1' => 'Codigo Caracteristica1',
			'CodigoCaracteristica2' => 'Codigo Caracteristica2',
			'CodigoTipo' => 'Codigo Tipo',
			'Disponible' => 'Disponible',
			'CodigoUnidadMedida' => 'Codigo Unidad Medida',
			'NombreUnidadMedida' => 'Nombre Unidad Medida',
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
		$criteria->compare('CodigoSitio',$this->CodigoSitio,true);
		$criteria->compare('NombreSitio',$this->NombreSitio,true);
		$criteria->compare('CodigoAlmacen',$this->CodigoAlmacen,true);
		$criteria->compare('CodigoVariante',$this->CodigoVariante,true);
		$criteria->compare('CodigoArticulo',$this->CodigoArticulo,true);
		$criteria->compare('CodigoCaracteristica1',$this->CodigoCaracteristica1,true);
		$criteria->compare('CodigoCaracteristica2',$this->CodigoCaracteristica2,true);
		$criteria->compare('CodigoTipo',$this->CodigoTipo,true);
		$criteria->compare('Disponible',$this->Disponible,true);
		$criteria->compare('CodigoUnidadMedida',$this->CodigoUnidadMedida,true);
		$criteria->compare('NombreUnidadMedida',$this->NombreUnidadMedida,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Saldosinventariopreventa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
