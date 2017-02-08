<?php

 
class SitiosAlmacen extends CActiveRecord
{
	 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function getsitiosAlmacen($zona){
            $sql = "SELECT * FROM `zonaventaalmacen` WHERE CodZonaVentas = '$zona'";
            return Yii::app()->db->createCommand($sql)->queryAll();            
        }
       
}
