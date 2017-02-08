<?php

/**
 * This is the model class for table "asesorescomerciales".
 *
 * The followings are the available columns in table 'asesorescomerciales':
 * @property string $CodAsesor
 * @property string $Nombre
 * @property string $Telefono
 * @property string $CodDimensionFinancieraZonaVenta
 * @property string $CodDimensionFinancieraCentroCosto
 * @property string $CodDimensionFinancieraUnidadNegocio
 * @property string $CodZonadeVentas
 *
 * The followings are the available model relations:
 * @property Zonaventas $codZonadeVentas
 * @property Grupovendedores[] $grupovendedores
 * @property Transaccionesabiertas[] $transaccionesabiertases
 */
class Asesorescomerciales extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'asesorescomerciales';
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
			array('CodAsesor', 'required'),
			array('CodAsesor, CodDimensionFinancieraZonaVenta, CodDimensionFinancieraCentroCosto, CodDimensionFinancieraUnidadNegocio, CodZonadeVentas', 'length', 'max'=>15),
			array('Nombre', 'length', 'max'=>180),
			array('Telefono', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('CodAsesor, Nombre, Telefono, CodDimensionFinancieraZonaVenta, CodDimensionFinancieraCentroCosto, CodDimensionFinancieraUnidadNegocio, CodZonadeVentas', 'safe', 'on'=>'search'),
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
			'codZonadeVentas' => array(self::BELONGS_TO, 'Zonaventas', 'CodZonadeVentas'),
			'grupovendedores' => array(self::HAS_MANY, 'Grupovendedores', 'CodAsesor'),
			'transaccionesabiertases' => array(self::HAS_MANY, 'Transaccionesabiertas', 'CodAsesorComercial'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'CodAsesor' => 'Cod Asesor',
			'Nombre' => 'Nombre',
			'Telefono' => 'Telefono',
			'CodDimensionFinancieraZonaVenta' => 'Cod Dimension Financiera Zona Venta',
			'CodDimensionFinancieraCentroCosto' => 'Cod Dimension Financiera Centro Costo',
			'CodDimensionFinancieraUnidadNegocio' => 'Cod Dimension Financiera Unidad Negocio',
			'CodZonadeVentas' => 'Cod Zonade Ventas',
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

		$criteria->compare('CodAsesor',$this->CodAsesor,true);
		$criteria->compare('Nombre',$this->Nombre,true);
		$criteria->compare('Telefono',$this->Telefono,true);
		$criteria->compare('CodDimensionFinancieraZonaVenta',$this->CodDimensionFinancieraZonaVenta,true);
		$criteria->compare('CodDimensionFinancieraCentroCosto',$this->CodDimensionFinancieraCentroCosto,true);
		$criteria->compare('CodDimensionFinancieraUnidadNegocio',$this->CodDimensionFinancieraUnidadNegocio,true);
		$criteria->compare('CodZonadeVentas',$this->CodZonadeVentas,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asesorescomerciales the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
