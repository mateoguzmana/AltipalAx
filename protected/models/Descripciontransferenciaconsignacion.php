<?php

/**
 * This is the model class for table "descripciontransferenciaconsignacion".
 *
 * The followings are the available columns in table 'descripciontransferenciaconsignacion':
 * @property integer $IdTransferencia
 * @property string $CodVariante
 * @property string $CodigoArticulo
 * @property string $NombreArticulo
 * @property string $Cantidad
 * @property string $UnidadMedida
 * @property string $PedidoMaquina
 * @property string $IdentificadorEnvio
 */
class Descripciontransferenciaconsignacion extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'descripciontransferenciaconsignacion';
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
			array('IdTransferencia, CodVariante, CodigoArticulo, NombreArticulo, Cantidad, UnidadMedida, IdentificadorEnvio', 'required'),
			array('IdTransferencia', 'numerical', 'integerOnly'=>true),
			array('CodVariante, CodigoArticulo, Cantidad, UnidadMedida', 'length', 'max'=>50),
			array('NombreArticulo', 'length', 'max'=>150),
			array('PedidoMaquina, IdentificadorEnvio', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IdTransferencia, CodVariante, CodigoArticulo, NombreArticulo, Cantidad, UnidadMedida, PedidoMaquina, IdentificadorEnvio', 'safe', 'on'=>'search'),
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
			'IdTransferencia' => 'Id Transferencia',
			'CodVariante' => 'Cod Variante',
			'CodigoArticulo' => 'Codigo Articulo',
			'NombreArticulo' => 'Nombre Articulo',
			'Cantidad' => 'Cantidad',
			'UnidadMedida' => 'Unidad Medida',
			'PedidoMaquina' => 'Pedido Maquina',
			'IdentificadorEnvio' => 'Identificador Envio',
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

		$criteria->compare('IdTransferencia',$this->IdTransferencia);
		$criteria->compare('CodVariante',$this->CodVariante,true);
		$criteria->compare('CodigoArticulo',$this->CodigoArticulo,true);
		$criteria->compare('NombreArticulo',$this->NombreArticulo,true);
		$criteria->compare('Cantidad',$this->Cantidad,true);
		$criteria->compare('UnidadMedida',$this->UnidadMedida,true);
		$criteria->compare('PedidoMaquina',$this->PedidoMaquina,true);
		$criteria->compare('IdentificadorEnvio',$this->IdentificadorEnvio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Descripciontransferenciaconsignacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
