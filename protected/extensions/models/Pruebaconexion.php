<?php

/**
 * This is the model class for table "pruebaconexion".
 *
 * The followings are the available columns in table 'pruebaconexion':
 * @property integer $Id
 * @property string $Nombre
 */
class Pruebaconexion extends CActiveRecord
{
    
	public static function model($className=__CLASS__)
	{
                Yii::import('application.extensions.multiple.Multiple'); 
		return parent::model($className);
	}        
        
        public function getDepartamentos() {
           $sql = "SELECT * FROM `ciudades`";           
           return Multiple::multiConsulta($sql);
	}
}
