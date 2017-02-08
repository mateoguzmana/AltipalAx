<?php

/**
 * This is the model class for table "noventas".
 *
 * The followings are the available columns in table 'noventas':
 * @property integer $Id
 * @property string $CodAsesor
 * @property string $CodZonaVentas
 * @property string $CuentaCliente
 * @property string $FechaNoVenta
 * @property string $HoraNoVenta
 * @property string $CodMotivoNoVenta
 * @property integer $IdentificadorEnvio
 * @property string $EstadoXml
 * @property integer $Web
 * @property string $CodigoCanal
 * @property string $Responsable
 * @property string $Imei
 */
class Noventas extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'noventas';
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
			array('CodZonaVentas, IdentificadorEnvio, CodigoCanal', 'required'),
			array('IdentificadorEnvio, Web', 'numerical', 'integerOnly'=>true),
			array('CodAsesor, CuentaCliente', 'length', 'max'=>50),
			array('CodZonaVentas, CodMotivoNoVenta', 'length', 'max'=>15),
			array('EstadoXml', 'length', 'max'=>100),
			array('CodigoCanal, Responsable', 'length', 'max'=>25),
			array('Imei', 'length', 'max'=>50),
			array('FechaNoVenta, HoraNoVenta', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, CodAsesor, CodZonaVentas, CuentaCliente, FechaNoVenta, HoraNoVenta, CodMotivoNoVenta, IdentificadorEnvio, EstadoXml, Web, CodigoCanal, Responsable, Imei', 'safe', 'on'=>'search'),
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
			'CodZonaVentas' => 'Cod Zona Ventas',
			'CuentaCliente' => 'Cuenta Cliente',
			'FechaNoVenta' => 'Fecha No Venta',
			'HoraNoVenta' => 'Hora No Venta',
			'CodMotivoNoVenta' => 'Cod Motivo No Venta',
			'IdentificadorEnvio' => 'Identificador Envio',
			'EstadoXml' => 'Estado Xml',
			'Web' => 'Web',
			'CodigoCanal' => 'Codigo Canal',
			'Responsable' => 'Responsable',
			'Imei' => 'Imei',
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
		$criteria->compare('CodZonaVentas',$this->CodZonaVentas,true);
		$criteria->compare('CuentaCliente',$this->CuentaCliente,true);
		$criteria->compare('FechaNoVenta',$this->FechaNoVenta,true);
		$criteria->compare('HoraNoVenta',$this->HoraNoVenta,true);
		$criteria->compare('CodMotivoNoVenta',$this->CodMotivoNoVenta,true);
		$criteria->compare('IdentificadorEnvio',$this->IdentificadorEnvio);
		$criteria->compare('EstadoXml',$this->EstadoXml,true);
		$criteria->compare('Web',$this->Web);
		$criteria->compare('CodigoCanal',$this->CodigoCanal,true);
		$criteria->compare('Responsable',$this->Responsable,true);
		$criteria->compare('Imei',$this->Imei,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Noventas the static model class
	 */
	public static function model($className=__CLASS__)
	{
            Yii::import('application.extensions.multiple.Multiple');
            return parent::model($className);
	}
        
         public function getNoVentasEchas($zonaVentas, $cliente) {
             
        $connection=Multiple::getConexionZonaVentas(); 
        $sql = "SELECT COUNT(*) AS registros FROM `noventas` where CodZonaVentas = '$zonaVentas' and CuentaCliente = '$cliente' and FechaNoVenta = CURDATE()";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
    public function getClientesNoVentas($cliente) {

        $connection=Multiple::getConexionZonaVentas(); 
        $sql = "SELECT `CuentaCliente`,`NombreCliente`,`NombreBusqueda` FROM `cliente` WHERE `CuentaCliente` = '$cliente'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getZonaNoVentas($zonaVentas) {

        $connection=Multiple::getConexionZonaVentas(); 
        $sql = "SELECT `CodZonaVentas`,`NombreZonadeVentas` FROM `zonaventas` WHERE `CodZonaVentas` = '$zonaVentas' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }

    public function getNoVentasAsesor($zonaVentas) {


        $connection=Multiple::getConexionZonaVentas(); 
        $sql = "SELECT zona.CodAsesor,asesor.Nombre FROM zonaventas zona join asesorescomerciales asesor on zona.CodAsesor=asesor.CodAsesor WHERE CodZonaVentas = '$zonaVentas' ";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryRow();
        return $dataReader;
    }
    
    public function UpdateNoventaTerminarRuta($zona,$agencia){
        
      $consulta = new Multiple();
      $sql = "UPDATE `noventas` SET `IdentificadorEnvio`='1' WHERE `CodZonaVentas`= '$zona' AND `FechaNoVenta` = CURDATE() AND `IdentificadorEnvio`='0'";
      $dataReader = $consulta->queryAgencia($agencia,$sql);
      return $dataReader;  
     
    }
}
