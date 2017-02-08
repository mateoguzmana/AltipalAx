<?php

/**
 * This is the model class for table "norecaudos".
 *
 * The followings are the available columns in table 'norecaudos':
 * @property integer $Id
 * @property string $CodZonaVentas
 * @property string $CodAsesor
 * @property string $CuentaCliente
 * @property string $Fecha
 * @property string $FechaProximaVisita
 * @property string $Hora
 * @property string $CodMotivoGestion
 * @property string $Observacion
 * @property integer $Estado
 * @property integer $Web
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property integer $ExtraRuta
 * @property string $Ruta
 */
class Norecaudos extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'norecaudos';
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
			array('CodZonaVentas, CodAsesor, CuentaCliente, Fecha, FechaProximaVisita, Hora, CodMotivoGestion, Observacion, Estado, CodigoCanal, ExtraRuta, Ruta', 'required'),
			array('Estado, Web, ExtraRuta', 'numerical', 'integerOnly'=>true),
			array('CodZonaVentas, CodAsesor, CodMotivoGestion', 'length', 'max'=>15),
			array('CuentaCliente, Responsable', 'length', 'max'=>25),
			array('Observacion, CodigoCanal', 'length', 'max'=>50),
			array('Ruta', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, CodZonaVentas, CodAsesor, CuentaCliente, Fecha, FechaProximaVisita, Hora, CodMotivoGestion, Observacion, Estado, Web, CodigoCanal, Responsable, ExtraRuta, Ruta', 'safe', 'on'=>'search'),
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
			'CodAsesor' => 'Cod Asesor',
			'CuentaCliente' => 'Cuenta Cliente',
			'Fecha' => 'Fecha',
			'FechaProximaVisita' => 'Fecha Proxima Visita',
			'Hora' => 'Hora',
			'CodMotivoGestion' => 'Cod Motivo Gestion',
			'Observacion' => 'Observacion',
			'Estado' => 'Estado',
			'Web' => 'Web',
			'CodigoCanal' => 'Codigo Canal',
			'Responsable' => 'Responsable',
			'ExtraRuta' => 'Extra Ruta',
			'Ruta' => 'Ruta',
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
		$criteria->compare('CodAsesor',$this->CodAsesor,true);
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('FechaProximaVisita',$this->FechaProximaVisita,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('CodMotivoGestion',$this->CodMotivoGestion,true);
		$criteria->compare('Observacion',$this->Observacion,true);
		$criteria->compare('Estado',$this->Estado);
		$criteria->compare('Web',$this->Web);
		$criteria->compare('CodigoCanal',$this->CodigoCanal,true);
		$criteria->compare('Responsable',$this->Responsable,true);
		$criteria->compare('ExtraRuta',$this->ExtraRuta);
		$criteria->compare('Ruta',$this->Ruta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Norecaudos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
