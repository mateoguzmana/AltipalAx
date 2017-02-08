<?php

/**
 * This is the model class for table "registroexcepciones".
 *
 * The followings are the available columns in table 'registroexcepciones':
 * @property integer $Id
 * @property string $Descripcion
 * @property string $Fecha
 * @property string $Hora
 */
class Registroexcepciones extends AgenciaActiveRecord
{
	
	public function tableName()
	{
		return 'registroexcepciones';
	}
        
        public function getDbConnection()
        {
           return self::setConexion();
        }

	
	public function rules()	{
		
		return array(
			array('Descripcion, Fecha, Hora', 'required'),			
			array('Id, Descripcion, Fecha, Hora', 'safe', 'on'=>'search'),
		);
	}

	
	public function relations()
	{
		
		return array(
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'Id' => 'ID',
			'Descripcion' => 'Descripcion',
			'Fecha' => 'Fecha',
			'Hora' => 'Hora',
		);
	}

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('Id',$this->Id);
		$criteria->compare('Descripcion',$this->Descripcion,true);
		$criteria->compare('Fecha',$this->Fecha,true);
		$criteria->compare('Hora',$this->Hora,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	
	public static function model($className=__CLASS__)
	{
            Yii::import('application.extensions.multiple.Multiple'); 
            return parent::model($className);
	}
        
        
        public function setRegistroexcepciones($txtDescripcion) {
             
            try {         
              
            $fecha=  date('Y-m-d');   
            $hora=  date('H:m:s');  
            
            $connection=Multiple::getConexionZonaVentas(); 
            $sql = "INSERT INTO  registroexcepciones (Descripcion,Fecha,Hora)
                    VALUES ('$txtDescripcion','$fecha','$hora');";

            $command = $connection->createCommand($sql);
            $dataReader = $command->query();            
                
            } catch (Exception $exc) {
                
            }
        } 
}
