<?php

/**
 * This is the model class for table "mensajes".
 *
 * The followings are the available columns in table 'mensajes':
 * @property integer $IdMensaje
 * @property string $IdDestinatario
 * @property string $IdRemitente
 * @property string $FechaMensaje
 * @property string $HoraMensaje
 * @property string $Mensaje
 * @property string $Estado
 * @property string $CodAsesor
 */
class MensajeTerminarRuta extends AgenciaActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mensajes';
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
			array('IdDestinatario, IdRemitente, CodAsesor', 'length', 'max'=>16),
			array('Mensaje', 'length', 'max'=>600),
			array('Estado', 'length', 'max'=>12),
			array('FechaMensaje, HoraMensaje', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('IdMensaje, IdDestinatario, IdRemitente, FechaMensaje, HoraMensaje, Mensaje, Estado, CodAsesor', 'safe', 'on'=>'search'),
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
			'IdMensaje' => 'Id Mensaje',
			'IdDestinatario' => 'Id Destinatario',
			'IdRemitente' => 'Id Remitente',
			'FechaMensaje' => 'Fecha Mensaje',
			'HoraMensaje' => 'Hora Mensaje',
			'Mensaje' => 'Mensaje',
			'Estado' => 'Estado',
			'CodAsesor' => 'Cod Asesor',
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

		$criteria->compare('IdMensaje',$this->IdMensaje);
		$criteria->compare('IdDestinatario',$this->IdDestinatario,true);
		$criteria->compare('IdRemitente',$this->IdRemitente,true);
		$criteria->compare('FechaMensaje',$this->FechaMensaje,true);
		$criteria->compare('HoraMensaje',$this->HoraMensaje,true);
		$criteria->compare('Mensaje',$this->Mensaje,true);
		$criteria->compare('Estado',$this->Estado,true);
		$criteria->compare('CodAsesor',$this->CodAsesor,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Mensajes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
