<?php

/**
 * This is the model class for table "erroresactualizacion".
 *
 * The followings are the available columns in table 'erroresactualizacion':
 * @property integer $Id
 * @property string $MensajeActivity
 * @property string $MensajeServicio
 * @property string $Fecha
 * @property string $Hora
 * @property string $ServicioSRF
 * @property string $TablasActualizar
 * @property string $Parametros
 * @property string $Agencia
 */
class Erroresactualizacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'erroresactualizacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('MensajeActivity, MensajeServicio, Fecha, Hora, ServicioSRF, TablasActualizar, Parametros, Agencia', 'required'),
			array('MensajeActivity', 'length', 'max'=>200),
			array('ServicioSRF', 'length', 'max'=>35),
			array('TablasActualizar', 'length', 'max'=>75),
			array('Parametros, Agencia', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, MensajeActivity, MensajeServicio, Fecha, Hora, ServicioSRF, TablasActualizar, Parametros, Agencia', 'safe', 'on'=>'search'),
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
			'MensajeActivity' => 'Mensaje Activity',
			'MensajeServicio' => 'Mensaje Servicio',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
			'ServicioSRF' => 'Servicio Srf',
			'TablasActualizar' => 'Tablas Actualizar',
			'Parametros' => 'Parametros',
			'Agencia' => 'Agencia',
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
		$criteria->compare('MensajeActivity',$this->MensajeActivity,true);
		$criteria->compare('MensajeServicio',$this->MensajeServicio,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);
		$criteria->compare('ServicioSRF',$this->ServicioSRF,true);
		$criteria->compare('TablasActualizar',$this->TablasActualizar,true);
		$criteria->compare('Parametros',$this->Parametros,true);
		$criteria->compare('Agencia',$this->Agencia,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Erroresactualizacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
        public function getlogErrores(){
        $fecha_hoy1 = date('Y-m-d');
        $fecha_inicia=date("Y-m-d", strtotime("$fecha_hoy1 - 1 days"));
        $connection = Yii::app()->db;
        $sql = "SELECT * FROM  erroresactualizacion WHERE fecha BETWEEN '".$fecha_inicia."' AND '".date('Y-m-d')."' ";
        $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
            
        }
		
        public function getlogErroresfecha($ini,$fin){            
        $connection = Yii::app()->db;
        $sql = "SELECT * FROM  erroresactualizacion WHERE fecha BETWEEN '".$ini."' AND '".$fin."' ";
       
 $command = $connection->createCommand($sql);
        // Se obtiene el resultado de la base de datos
        $dataReader = $command->queryAll();
        return $dataReader;
            
        }
		
}
