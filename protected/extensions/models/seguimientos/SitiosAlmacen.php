<?php

 
class SitiosAlmacen extends CActiveRecord
{
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getsitiosAlmacen($zona){
            
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `zonaventaalmacen` WHERE CodZonaVentas = '$zona'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
            
        }
        
       
}
