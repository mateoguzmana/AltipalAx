<?php

/**
 * This is the model class for table "reciboscaja".
 *
 * The followings are the available columns in table 'reciboscaja':
 * @property integer $Id
 * @property string $CodAsesor
 * @property string $ZonaVenta
 * @property string $CuentaCliente
 * @property string $Fecha
 * @property string $Hora
 * @property string $Provisional
 * @property string $Estado
 * @property string $ArchivoXml
 * @property integer $IdentificadorEnvio
 * @property string $ReciboMaquina
 * @property integer $Web
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property integer $ExtraRuta
 * @property integer $Ruta
 * @property string $Imei
 * @property string $EstadoChequePosfechado
 */
class Reciboscaja extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reciboscaja';
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
			array('CodAsesor, ZonaVenta, CuentaCliente, Fecha, Hora, Provisional, Estado, IdentificadorEnvio, CodigoCanal, ExtraRuta, Ruta', 'required'),
			array('IdentificadorEnvio, Web, ExtraRuta, Ruta', 'numerical', 'integerOnly'=>true),
			array('CodAsesor', 'length', 'max'=>16),
			array('ZonaVenta, CuentaCliente, CodigoCanal, Responsable', 'length', 'max'=>25),
			array('Provisional, ArchivoXml', 'length', 'max'=>75),
			array('Estado, EstadoChequePosfechado', 'length', 'max'=>1),
			array('ReciboMaquina', 'length', 'max'=>60),
			array('Imei', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, CodAsesor, ZonaVenta, CuentaCliente, Fecha, Hora, Provisional, Estado, ArchivoXml, IdentificadorEnvio, ReciboMaquina, Web, CodigoCanal, Responsable, ExtraRuta, Ruta, Imei, EstadoChequePosfechado', 'safe', 'on'=>'search'),
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
			'CodAsesor' => 'Cod Asesor',
			'ZonaVenta' => 'Zona Venta',
			'CuentaCliente' => 'Cuenta Cliente',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'Provisional' => 'Provisional',
			'Estado' => 'Estado',
			'ArchivoXml' => 'Archivo Xml',
			'IdentificadorEnvio' => 'Identificador Envio',
			'ReciboMaquina' => 'Recibo Maquina',
			'Web' => 'Web',
			'CodigoCanal' => 'Codigo Canal',
			'Responsable' => 'Responsable',
			'ExtraRuta' => 'Extra Ruta',
			'Ruta' => 'Ruta',
			'Imei' => 'Imei',
			'EstadoChequePosfechado' => 'Estado Cheque Posfechado',
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
		$criteria->compare('CodAsesor',$this->CodAsesor,true);
		$criteria->compare('ZonaVenta',$this->ZonaVenta,true);
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('Provisional',$this->Provisional,true);
		$criteria->compare('Estado',$this->Estado,true);
		$criteria->compare('ArchivoXml',$this->ArchivoXml,true);
		$criteria->compare('IdentificadorEnvio',$this->IdentificadorEnvio);
		$criteria->compare('ReciboMaquina',$this->ReciboMaquina,true);
		$criteria->compare('Web',$this->Web);
		$criteria->compare('CodigoCanal',$this->CodigoCanal,true);
		$criteria->compare('Responsable',$this->Responsable,true);
		$criteria->compare('ExtraRuta',$this->ExtraRuta);
		$criteria->compare('Ruta',$this->Ruta);
		$criteria->compare('Imei',$this->Imei,true);
		$criteria->compare('EstadoChequePosfechado',$this->EstadoChequePosfechado,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reciboscaja the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
