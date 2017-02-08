<?php

/**
 * This is the model class for table "administrador".
 *
 * The followings are the available columns in table 'administrador':
 * @property integer $Id
 * @property string $Cedula
 * @property string $Usuario
 * @property string $Clave
 * @property string $Nombres
 * @property string $Apellidos
 * @property string $Email
 * @property string $Telefono
 * @property string $Celular
 * @property integer $IdPerfil
 * @property string $Direccion
 * @property integer $IdTipoUsuario
 * @property integer $Activo
 */
class Administrador extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'administrador';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('Cedula, Usuario, Clave, Nombres, Apellidos, Email, IdPerfil, Direccion, IdTipoUsuario', 'required'),
			array('IdPerfil, IdTipoUsuario, Activo', 'numerical', 'integerOnly'=>true),
			array('Cedula, Usuario, Email, Direccion', 'length', 'max'=>50),
			array('Clave', 'length', 'max'=>16),
			array('Nombres, Apellidos', 'length', 'max'=>25),
			array('Telefono', 'length', 'max'=>30),
			array('Celular', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('Id, Cedula, Usuario, Clave, Nombres, Apellidos, Email, Telefono, Celular, IdPerfil, Direccion, IdTipoUsuario, Activo', 'safe', 'on'=>'search'),
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
			'Cedula' => 'Cedula',
			'Usuario' => 'Usuario',
			'Clave' => 'Clave',
			'Nombres' => 'Nombres',
			'Apellidos' => 'Apellidos',
			'Email' => 'Email',
			'Telefono' => 'Telefono',
			'Celular' => 'Celular',
			'IdPerfil' => 'Id Perfil',
			'Direccion' => 'Direccion',
			'IdTipoUsuario' => 'Id Tipo Usuario',
			'Activo' => 'Activo',
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
		$criteria->compare('Cedula',$this->Cedula,true);
		$criteria->compare('Usuario',$this->Usuario,true);
		$criteria->compare('Clave',$this->Clave,true);
		$criteria->compare('Nombres',$this->Nombres,true);
		$criteria->compare('Apellidos',$this->Apellidos,true);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Telefono',$this->Telefono,true);
		$criteria->compare('Celular',$this->Celular,true);
		$criteria->compare('IdPerfil',$this->IdPerfil);
		$criteria->compare('Direccion',$this->Direccion,true);
		$criteria->compare('IdTipoUsuario',$this->IdTipoUsuario);
		$criteria->compare('Activo',$this->Activo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Administrador the static model class
	 */
	public static function model($className=__CLASS__)
	{
            Yii::import('application.extensions.multiple.Multiple'); 
            return parent::model($className);
	}
        
         public function getAsesorComercial($codZonaVentas, $clave) {

            //$connection=Multiple::getConexionZonaVentas($codZonaVentas);
             
             $connection=Yii::app()->db;
             $sql='SELECT `CodZonaVentas`,`CodAgencia` FROM `zonaventasglobales` WHERE `CodZonaVentas`="'.$codZonaVentas.'"';
             $command = $connection->createCommand($sql);
             $dataReader = $command->queryRow();              
             
              
             $agencia=$dataReader['CodAgencia'];  
            
             if($agencia=="001"){
                
                $connection=Yii::app()->Apartado;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }   
             
             
            if($agencia=="002"){
                
                $connection=Yii::app()->Bogota;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }  
            
             
            if($agencia=="003"){
                
                $connection=Yii::app()->Cali;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }  
            
             if($agencia=="004"){
                
                $connection=Yii::app()->Duitama;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }  
             
              if($agencia=="005"){
                
                $connection=Yii::app()->Ibague;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }  
            
            if($agencia=="006"){
                
                $connection=Yii::app()->Medellin;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }  
            
            
            if($agencia=="007"){
                
                $connection=Yii::app()->Monteria;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            }  
            
            
            if($agencia=="008"){
                
                $connection=Yii::app()->Pasto;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            } 
            
              if($agencia=="009"){
                
                $connection=Yii::app()->Pereira;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            } 
            
              if($agencia=="010"){
                
                $connection=Yii::app()->Popayan;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            } 
            
              if($agencia=="011"){
                
                $connection=Yii::app()->Villavicencio;
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();
               return $dataReader;
                
            } 
            
             /*$connection=Yii::app()->db;
                          
                $sql = "SELECT * FROM 
                       `zonaventas` z 
                       INNER JOIN asesorescomerciales a ON a.CodAsesor = z.CodAsesor 
                       WHERE 
                       z.`CodZonaVentas`='$codZonaVentas'
                       AND a.Clave='$clave'";
               $command = $connection->createCommand($sql);              
               $dataReader = $command->queryRow();              
               
               return $dataReader;*/
             
        }
}
