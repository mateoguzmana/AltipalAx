<?php

class Focalizados extends CActiveRecord {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getSemanas($ano = '', $mes = '') {

        if ($mes != "") {

            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `semanas` WHERE Ano = '$ano' AND Mes = '$mes'";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;
        } else {
            
            $connection = Yii::app()->db;
            $sql = "SELECT * FROM `semanas`";
            $command = $connection->createCommand($sql);
            $dataReader = $command->queryAll();
            return $dataReader;  
            
        }
    }
    
    public function getSemanasMes($mes){
        
          $connection = Yii::app()->db;
          $sql = "SELECT COUNT(*) AS semanasingresadas FROM `semanas` WHERE  Mes = '$mes'";
          $command = $connection->createCommand($sql);
          $dataReader = $command->queryRow();
          return $dataReader;
    }
    
    
    public function InsertSemanas($ano,$mes,$semana,$fechaini,$fechafin,$usuario){
        
          $connection = Yii::app()->db;
          $sql = "INSERT INTO `semanas` (`Ano`, `Mes`, `Semana`, `FechaInicial`, `FechaFinal`, `Hora`, `Fecha`, `IdUsuario`) VALUES ('$ano','$mes','$semana','$fechaini','$fechafin',CURTIME(),CURDATE(),'$usuario') ";
          $command = $connection->createCommand($sql);
          $dataReader = $command->query();
          return $dataReader;
    }
    
    public function getDeleteSemana($id){
        
       $connection = Yii::app()->db;
       $sql = "DELETE FROM `semanas` WHERE `Id` = '$id' ";
       $command = $connection->createCommand($sql);
       $dataReader = $command->query();
       return $dataReader; 
    }
    
    public function getSemanaYaResgistrada($ano,$mes,$semana){
        
         $connection = Yii::app()->db;
          $sql = "SELECT COUNT(*) AS semanayaregistrada FROM `semanas` WHERE  Mes = '$mes' AND Ano = '$ano' AND Semana = '$semana'";
          $command = $connection->createCommand($sql);
          $dataReader = $command->queryRow();
          return $dataReader;
        
    }
    
    public function getFechasExistentes($fechaini,$fechafin){
        
          $connection = Yii::app()->db;
          $sql = "SELECT COUNT(*) AS FechasExistentes FROM `semanas` WHERE  FechaInicial = '$fechaini' AND FechaFinal = '$fechafin'";
          $command = $connection->createCommand($sql);
          $dataReader = $command->queryRow();
          return $dataReader; 
        
    }
    
     public function getAgencias($cedula) {
 
        $connection = Yii::app()->db;
        $sql = "SELECT DISTINCT(ca.CodAgencia) as CodAgencia,agen.Nombre FROM `administrador` a
        Inner JOIN configuracionadministrador ca ON a.Id=ca.IdAdministrador 
        Inner JOIN agencia as agen on ca.CodAgencia=agen.CodAgencia WHERE `Cedula`='$cedula'";
        $command = $connection->createCommand($sql);
        $dataReader = $command->queryAll();
        return $dataReader;
    }
    
    public function getClientesZona($agencia,$zona){
      
        
        $connection = new Multiple();
        $sql = "SELECT cli.NombreCliente,cli.CuentaCliente FROM `cliente` cli INNER JOIN clienteruta clirut ON cli.CuentaCliente=clirut.CuentaCliente WHERE clirut.CodZonaVentas = '$zona' GROUP BY cli.CuentaCliente";
         $dataReader = $connection->consultaAgencia($agencia,$sql);
         return $dataReader;
         
    }
    
    public function InsertEjecucionActividad($agencia,$zonas,$cliente,$fechaini,$fechafin,$descripcion,$inversion){
        
        $connection = new Multiple();
        $sql = "INSERT INTO `ejecucionactividad`(`CodZonaVentas`, `CuentaCliente`, `Fechainicio`, `Fechafin`, `Descripcion`, `Inversion`, `Ejecucion`) VALUES ('$zonas','$cliente','$fechaini','$fechafin','$descripcion','$inversion','0')";
        $dataReader = $connection->queryAgencia($agencia,$sql);
        return $dataReader;
        
    }
    
    public function getActividades($zona = '',$agencia,$cuantcliente = ''){
        
       if($zona !=""){ 
           
        $connection = new Multiple();
        $sql = "SELECT * FROM `ejecucionactividad` where CodZonaVentas = '$zona'";
        $dataReader = $connection->consultaAgencia($agencia,$sql);
        return $dataReader; 
        
       }else if($cuantcliente != ""){
           
        $connection = new Multiple();
        $sql = "SELECT * FROM `ejecucionactividad` where CuentaCliente = '$cuantcliente'";
        $dataReader = $connection->consultaAgencia($agencia,$sql);
        return $dataReader; 
           
       }
        
    }
    
}
