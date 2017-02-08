<?php

/**
 * This is the model class for table "configuracionaprobaciondocumentos".
 *
 * The followings are the available columns in table 'configuracionaprobaciondocumentos':
 * @property integer $IdAdministrador
 * @property integer $IdPerfilAprobacion
 * @property integer $EnvioCorreo
 * @property string $CodigoProveedor
 */
class Configuracionaprobaciondocumentos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'configuracionaprobaciondocumentos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdAdministrador, IdPerfilAprobacion, EnvioCorreo, CodigoProveedor', 'required'),
			array('IdAdministrador, IdPerfilAprobacion, EnvioCorreo', 'numerical', 'integerOnly'=>true),
			array('CodigoProveedor', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IdAdministrador, IdPerfilAprobacion, EnvioCorreo, CodigoProveedor', 'safe', 'on'=>'search'),
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
			'IdAdministrador' => 'Id Administrador',
			'IdPerfilAprobacion' => 'Id Perfil Aprobacion',
			'EnvioCorreo' => 'Envio Correo',
			'CodigoProveedor' => 'Codigo Proveedor',
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

		$criteria->compare('IdAdministrador',$this->IdAdministrador);
		$criteria->compare('IdPerfilAprobacion',$this->IdPerfilAprobacion);
		$criteria->compare('EnvioCorreo',$this->EnvioCorreo);
		$criteria->compare('CodigoProveedor',$this->CodigoProveedor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Configuracionaprobaciondocumentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
