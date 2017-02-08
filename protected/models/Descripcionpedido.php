<?php

/**
 * This is the model class for table "descripcionpedido".
 *
 * The followings are the available columns in table 'descripcionpedido':
 * @property integer $Id
 * @property integer $IdPedido
 * @property string $CodVariante
 * @property string $CodigoArticulo
 * @property string $NombreArticulo
 * @property string $CodigoTipo
 * @property integer $Cantidad
 * @property string $ValorUnitario
 * @property string $Iva
 * @property string $Impoconsumo
 * @property string $CodigoUnidadMedida
 * @property string $NombreUnidadMedida
 * @property string $CuentaProveedor
 * @property integer $Saldo
 * @property string $DsctoLinea
 * @property string $DsctoMultiLinea
 * @property string $DsctoEspecial
 * @property string $DsctoEspecialAltipal
 * @property string $DsctoEspecialProveedor
 * @property string $ValorBruto
 * @property string $ValorDsctoLinea
 * @property string $ValorDsctoMultiLinea
 * @property string $ValorDsctoEspecial
 * @property string $BaseIva
 * @property string $ValorIva
 * @property string $ValorImpoconsumo
 * @property string $TotalPrecioNeto
 * @property integer $PedidoMaquina
 * @property integer $IdentificadorEnvio
 * @property integer $EstadoTerminacion
 * @property string $CodLote
 * @property string $IdAcuerdoPrecioVenta
 * @property string $IdAcuerdoLinea
 * @property string $IdAcuerdoMultilinea
 */
class Descripcionpedido extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'descripcionpedido';
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
			array('IdPedido, CodVariante, CodigoArticulo, NombreArticulo, CodigoTipo, Cantidad, ValorUnitario, Iva, Impoconsumo, CodigoUnidadMedida, NombreUnidadMedida, CuentaProveedor, Saldo, DsctoLinea, DsctoMultiLinea, ValorBruto, ValorDsctoLinea, ValorDsctoMultiLinea, ValorDsctoEspecial, BaseIva, ValorIva, ValorImpoconsumo, TotalPrecioNeto, IdAcuerdoPrecioVenta, IdAcuerdoLinea, IdAcuerdoMultilinea', 'required'),
			array('IdPedido, Cantidad, Saldo, PedidoMaquina, IdentificadorEnvio, EstadoTerminacion', 'numerical', 'integerOnly'=>true),
			array('CodVariante, CodigoArticulo, CodigoTipo, CodigoUnidadMedida, NombreUnidadMedida, CuentaProveedor, CodLote', 'length', 'max'=>25),
			array('NombreArticulo', 'length', 'max'=>100),
			array('ValorUnitario, Iva, Impoconsumo, DsctoLinea, DsctoMultiLinea, DsctoEspecial, DsctoEspecialAltipal, DsctoEspecialProveedor, ValorBruto, ValorDsctoLinea, ValorDsctoMultiLinea, ValorDsctoEspecial, BaseIva, ValorIva, ValorImpoconsumo, TotalPrecioNeto, IdAcuerdoPrecioVenta, IdAcuerdoLinea, IdAcuerdoMultilinea', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, IdPedido, CodVariante, CodigoArticulo, NombreArticulo, CodigoTipo, Cantidad, ValorUnitario, Iva, Impoconsumo, CodigoUnidadMedida, NombreUnidadMedida, CuentaProveedor, Saldo, DsctoLinea, DsctoMultiLinea, DsctoEspecial, DsctoEspecialAltipal, DsctoEspecialProveedor, ValorBruto, ValorDsctoLinea, ValorDsctoMultiLinea, ValorDsctoEspecial, BaseIva, ValorIva, ValorImpoconsumo, TotalPrecioNeto, PedidoMaquina, IdentificadorEnvio, EstadoTerminacion, CodLote, IdAcuerdoPrecioVenta, IdAcuerdoLinea, IdAcuerdoMultilinea', 'safe', 'on'=>'search'),
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
			'IdPedido' => 'Id Pedido',
			'CodVariante' => 'Cod Variante',
			'CodigoArticulo' => 'Codigo Articulo',
			'NombreArticulo' => 'Nombre Articulo',
			'CodigoTipo' => 'Codigo Tipo',
			'Cantidad' => 'Cantidad',
			'ValorUnitario' => 'Valor Unitario',
			'Iva' => 'Iva',
			'Impoconsumo' => 'Impoconsumo',
			'CodigoUnidadMedida' => 'Codigo Unidad Medida',
			'NombreUnidadMedida' => 'Nombre Unidad Medida',
			'CuentaProveedor' => 'Cuenta Proveedor',
			'Saldo' => 'Saldo',
			'DsctoLinea' => 'Dscto Linea',
			'DsctoMultiLinea' => 'Dscto Multi Linea',
			'DsctoEspecial' => 'Dscto Especial',
			'DsctoEspecialAltipal' => 'Dscto Especial Altipal',
			'DsctoEspecialProveedor' => 'Dscto Especial Proveedor',
			'ValorBruto' => 'Valor Bruto',
			'ValorDsctoLinea' => 'Valor Dscto Linea',
			'ValorDsctoMultiLinea' => 'Valor Dscto Multi Linea',
			'ValorDsctoEspecial' => 'Valor Dscto Especial',
			'BaseIva' => 'Base Iva',
			'ValorIva' => 'Valor Iva',
			'ValorImpoconsumo' => 'Valor Impoconsumo',
			'TotalPrecioNeto' => 'Total Precio Neto',
			'PedidoMaquina' => 'Pedido Maquina',
			'IdentificadorEnvio' => 'Identificador Envio',
			'EstadoTerminacion' => 'Estado Terminacion',
			'CodLote' => 'Cod Lote',
			'IdAcuerdoPrecioVenta' => 'Id Acuerdo Precio Venta',
			'IdAcuerdoLinea' => 'Id Acuerdo Linea',
			'IdAcuerdoMultilinea' => 'Id Acuerdo Multilinea',
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
		$criteria->compare('IdPedido',$this->IdPedido);
		$criteria->compare('CodVariante',$this->CodVariante,true);
		$criteria->compare('CodigoArticulo',$this->CodigoArticulo,true);
		$criteria->compare('NombreArticulo',$this->NombreArticulo,true);
		$criteria->compare('CodigoTipo',$this->CodigoTipo,true);
		$criteria->compare('Cantidad',$this->Cantidad);
		$criteria->compare('ValorUnitario',$this->ValorUnitario,true);
		$criteria->compare('Iva',$this->Iva,true);
		$criteria->compare('Impoconsumo',$this->Impoconsumo,true);
		$criteria->compare('CodigoUnidadMedida',$this->CodigoUnidadMedida,true);
		$criteria->compare('NombreUnidadMedida',$this->NombreUnidadMedida,true);
		$criteria->compare('CuentaProveedor',$this->CuentaProveedor,true);
		$criteria->compare('Saldo',$this->Saldo);
		$criteria->compare('DsctoLinea',$this->DsctoLinea,true);
		$criteria->compare('DsctoMultiLinea',$this->DsctoMultiLinea,true);
		$criteria->compare('DsctoEspecial',$this->DsctoEspecial,true);
		$criteria->compare('DsctoEspecialAltipal',$this->DsctoEspecialAltipal,true);
		$criteria->compare('DsctoEspecialProveedor',$this->DsctoEspecialProveedor,true);
		$criteria->compare('ValorBruto',$this->ValorBruto,true);
		$criteria->compare('ValorDsctoLinea',$this->ValorDsctoLinea,true);
		$criteria->compare('ValorDsctoMultiLinea',$this->ValorDsctoMultiLinea,true);
		$criteria->compare('ValorDsctoEspecial',$this->ValorDsctoEspecial,true);
		$criteria->compare('BaseIva',$this->BaseIva,true);
		$criteria->compare('ValorIva',$this->ValorIva,true);
		$criteria->compare('ValorImpoconsumo',$this->ValorImpoconsumo,true);
		$criteria->compare('TotalPrecioNeto',$this->TotalPrecioNeto,true);
		$criteria->compare('PedidoMaquina',$this->PedidoMaquina);
		$criteria->compare('IdentificadorEnvio',$this->IdentificadorEnvio);
		$criteria->compare('EstadoTerminacion',$this->EstadoTerminacion);
		$criteria->compare('CodLote',$this->CodLote,true);
		$criteria->compare('IdAcuerdoPrecioVenta',$this->IdAcuerdoPrecioVenta,true);
		$criteria->compare('IdAcuerdoLinea',$this->IdAcuerdoLinea,true);
		$criteria->compare('IdAcuerdoMultilinea',$this->IdAcuerdoMultilinea,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Descripcionpedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
