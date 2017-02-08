<?php

/**
 * This is the model class for table "aprovacionpedido".
 *
 * The followings are the available columns in table 'aprovacionpedido':
 * @property integer $Id
 * @property integer $IdPedido
 * @property integer $IdDetallePedido
 * @property string $AutorizaDscto
 * @property string $FechaAutorizacionDscto
 * @property string $HoraAutorizacionDscto
 * @property integer $QuienAutorizaDscto
 * @property integer $EstadoRevisadoAltipal
 * @property integer $EstadoRevisadoProveedor
 * @property integer $MotivoRechazoAltipal
 * @property integer $MotivoRechazoProveedor
 * @property integer $EstadoRechazoAltipal
 * @property integer $EstadoRechazoProveedor
 * @property string $UsuarioAutorizoDsctoAltipal
 * @property string $UsuarioAutorizoDsctoProveedor
 * @property string $NombreAutorizoDsctoAltipal
 * @property string $NombreAutorizoDsctoProveedor
 * @property string $FechaAutorizaAltipal
 * @property string $FechaAutorizaProveedor
 * @property string $HoraAutorizaAltipal
 * @property string $HoraAutorizaProveedor
 */
class Aprovacionpedido extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aprovacionpedido';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('IdPedido, IdDetallePedido, AutorizaDscto, FechaAutorizacionDscto, HoraAutorizacionDscto, QuienAutorizaDscto, EstadoRevisadoAltipal, EstadoRevisadoProveedor, MotivoRechazoAltipal, MotivoRechazoProveedor, EstadoRechazoAltipal, EstadoRechazoProveedor, UsuarioAutorizoDsctoAltipal, UsuarioAutorizoDsctoProveedor, NombreAutorizoDsctoAltipal, NombreAutorizoDsctoProveedor, FechaAutorizaAltipal, FechaAutorizaProveedor, HoraAutorizaAltipal, HoraAutorizaProveedor', 'required'),
			array('IdPedido, IdDetallePedido, QuienAutorizaDscto, EstadoRevisadoAltipal, EstadoRevisadoProveedor, MotivoRechazoAltipal, MotivoRechazoProveedor, EstadoRechazoAltipal, EstadoRechazoProveedor', 'numerical', 'integerOnly'=>true),
			array('AutorizaDscto, UsuarioAutorizoDsctoAltipal, UsuarioAutorizoDsctoProveedor', 'length', 'max'=>25),
			array('NombreAutorizoDsctoAltipal, NombreAutorizoDsctoProveedor', 'length', 'max'=>75),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, IdPedido, IdDetallePedido, AutorizaDscto, FechaAutorizacionDscto, HoraAutorizacionDscto, QuienAutorizaDscto, EstadoRevisadoAltipal, EstadoRevisadoProveedor, MotivoRechazoAltipal, MotivoRechazoProveedor, EstadoRechazoAltipal, EstadoRechazoProveedor, UsuarioAutorizoDsctoAltipal, UsuarioAutorizoDsctoProveedor, NombreAutorizoDsctoAltipal, NombreAutorizoDsctoProveedor, FechaAutorizaAltipal, FechaAutorizaProveedor, HoraAutorizaAltipal, HoraAutorizaProveedor', 'safe', 'on'=>'search'),
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
			'IdDetallePedido' => 'Id Detalle Pedido',
			'AutorizaDscto' => 'Autoriza Dscto',
			'FechaAutorizacionDscto' => 'Fecha Autorizacion Dscto',
			'HoraAutorizacionDscto' => 'Hora Autorizacion Dscto',
			'QuienAutorizaDscto' => 'Quien Autoriza Dscto',
			'EstadoRevisadoAltipal' => 'Estado Revisado Altipal',
			'EstadoRevisadoProveedor' => 'Estado Revisado Proveedor',
			'MotivoRechazoAltipal' => 'Motivo Rechazo Altipal',
			'MotivoRechazoProveedor' => 'Motivo Rechazo Proveedor',
			'EstadoRechazoAltipal' => 'Estado Rechazo Altipal',
			'EstadoRechazoProveedor' => 'Estado Rechazo Proveedor',
			'UsuarioAutorizoDsctoAltipal' => 'Usuario Autorizo Dscto Altipal',
			'UsuarioAutorizoDsctoProveedor' => 'Usuario Autorizo Dscto Proveedor',
			'NombreAutorizoDsctoAltipal' => 'Nombre Autorizo Dscto Altipal',
			'NombreAutorizoDsctoProveedor' => 'Nombre Autorizo Dscto Proveedor',
			'FechaAutorizaAltipal' => 'Fecha Autoriza Altipal',
			'FechaAutorizaProveedor' => 'Fecha Autoriza Proveedor',
			'HoraAutorizaAltipal' => 'Hora Autoriza Altipal',
			'HoraAutorizaProveedor' => 'Hora Autoriza Proveedor',
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
		$criteria->compare('IdDetallePedido',$this->IdDetallePedido);
		$criteria->compare('AutorizaDscto',$this->AutorizaDscto,true);
		$criteria->compare('FechaAutorizacionDscto',$this->FechaAutorizacionDscto,true);
		$criteria->compare('HoraAutorizacionDscto',$this->HoraAutorizacionDscto,true);
		$criteria->compare('QuienAutorizaDscto',$this->QuienAutorizaDscto);
		$criteria->compare('EstadoRevisadoAltipal',$this->EstadoRevisadoAltipal);
		$criteria->compare('EstadoRevisadoProveedor',$this->EstadoRevisadoProveedor);
		$criteria->compare('MotivoRechazoAltipal',$this->MotivoRechazoAltipal);
		$criteria->compare('MotivoRechazoProveedor',$this->MotivoRechazoProveedor);
		$criteria->compare('EstadoRechazoAltipal',$this->EstadoRechazoAltipal);
		$criteria->compare('EstadoRechazoProveedor',$this->EstadoRechazoProveedor);
		$criteria->compare('UsuarioAutorizoDsctoAltipal',$this->UsuarioAutorizoDsctoAltipal,true);
		$criteria->compare('UsuarioAutorizoDsctoProveedor',$this->UsuarioAutorizoDsctoProveedor,true);
		$criteria->compare('NombreAutorizoDsctoAltipal',$this->NombreAutorizoDsctoAltipal,true);
		$criteria->compare('NombreAutorizoDsctoProveedor',$this->NombreAutorizoDsctoProveedor,true);
		$criteria->compare('FechaAutorizaAltipal',$this->FechaAutorizaAltipal,true);
		$criteria->compare('FechaAutorizaProveedor',$this->FechaAutorizaProveedor,true);
		$criteria->compare('HoraAutorizaAltipal',$this->HoraAutorizaAltipal,true);
		$criteria->compare('HoraAutorizaProveedor',$this->HoraAutorizaProveedor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Aprovacionpedido the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
