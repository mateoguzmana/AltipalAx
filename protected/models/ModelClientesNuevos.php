<?php


class ModelClientesNuevos extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
            Yii::import('application.extensions.multiple.Multiple'); 
		return parent::model($className);
	}
        
        public function getBuscarCiudades() {
		$connection=Multiple::getConexionZonaVentas();  
		$sql = "SELECT NombreCiudad,CodigoCiudad,CodigoDepartamento,CodigoBarrio FROM `Localizacion` GROUP BY CodigoCiudad,NombreCiudad";
         	$command = $connection -> createCommand($sql);
	 	$dataReader = $command -> queryAll();
	 	return $dataReader;
	}
        
        public function getDepartamento($codCiudad,$codDepartamento) {
		$connection=Multiple::getConexionZonaVentas();  
                $sql = "SELECT CodigoDepartamento,NombreDepartamento,CodigoCiudad FROM `Localizacion` WHERE `CodigoCiudad` = '$codCiudad'  AND  CodigoDepartamento = '$codDepartamento' GROUP BY  CodigoDepartamento";
        	$command = $connection -> createCommand($sql);
	 	$dataReader = $command -> queryAll();
	 	return $dataReader;
	}

	public function getBarrios($CodDepartamento,$codCiudad) {
		$connection=Multiple::getConexionZonaVentas();  
		$sql = "SELECT CodigoBarrio,NombreBarrio  FROM `Localizacion` where CodigoCiudad = '$codCiudad' and CodigoDepartamento = '$CodDepartamento'";
        	$command = $connection -> createCommand($sql);
		$dataReader = $command -> queryAll();
		return $dataReader;
	}
         
        public function getTipoVia(){
            
                $connection=Multiple::getConexionZonaVentas();  
		$sql = "SELECT * FROM `tipovia`";
        	$command = $connection -> createCommand($sql);
		$dataReader = $command -> queryAll();
		return $dataReader;   
        }
        
        public function getTipoViaComplemento(){
            
                $connection=Multiple::getConexionZonaVentas();  
		$sql = "SELECT * FROM `tipoviacomplemento`";
        	$command = $connection -> createCommand($sql);
		$dataReader = $command -> queryAll();
		return $dataReader;   
        }
        
        
        public function getOtrosBarrio($Ciudad,$Departamento){
            
          $connection=Multiple::getConexionZonaVentas();  
          $sql = "SELECT NombreBarrio,CodigoBarrio FROM `Localizacion` where CodigoCiudad = '$Ciudad' and CodigoDepartamento = '$Departamento' and NombreLocalidad = 'SIN LOCALIDAD' AND NombreBarrio =  'BARRIO SIN DEFINIR'";
          $command = $connection -> createCommand($sql);
	  $dataReader = $command -> queryRow();
	 return $dataReader;  
            
        }
                
        
        
}
