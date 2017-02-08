<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AgenciaActiveRecord extends CActiveRecord {

   
    private static $Bogota=null;
    private static $Medellin=null;
    private static $Cali=null;
    private static $Apartado=null;
    private static $Duitama=null;
    private static $Ibague=null;
    private static $Monteria=null;
    private static $Pasto=null;
    private static $Pereira=null;
    private static $Popayan=null;
    private static $Villavicencio=null;

   
    
    protected static function setConexion($agenciaP="") {

        
        if($agenciaP!=""){
            $agencia=$agenciaP;
        }else{
            if (Yii::app()->user->hasState('_Agencia'))
                $agencia = Yii::app()->user->getState('_Agencia');
            else{
                $agencia='000';
            }   
        }
         
        
        
        switch ($agencia) {
            
            case '001':
                if (self::$Apartado !== null)
                    return self::$Apartado;
                else {
                    self::$Apartado = Yii::app()->Apartado;
                    if (self::$Apartado instanceof CDbConnection) {
                        self::$Apartado->setActive(true);
                        return self::$Apartado;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;

            case '002':
                if (self::$Bogota !== null)
                    return self::$Bogota;
                else {
                    self::$Bogota = Yii::app()->Bogota;
                    if (self::$Bogota instanceof CDbConnection) {
                        self::$Bogota->setActive(true);
                        return self::$Bogota;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;
            

            case '003':
                if (self::$Cali !== null)
                    return self::$Cali;
                else {
                    self::$Cali = Yii::app()->Cali;
                    if (self::$Cali instanceof CDbConnection) {
                        self::$Cali->setActive(true);
                        return self::$Cali;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;
                
            

            case '004':
                if (self::$Duitama !== null)
                    return self::$Duitama;
                else {
                    self::$Duitama = Yii::app()->Duitama;
                    if (self::$Duitama instanceof CDbConnection) {
                        self::$Duitama->setActive(true);
                        return self::$Duitama;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;

            case '005':
                if (self::$Ibague !== null)
                    return self::$Ibague;
                else {
                    self::$Ibague = Yii::app()->Ibague;
                    if (self::$Ibague instanceof CDbConnection) {
                        self::$Ibague->setActive(true);
                        return self::$Ibague;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;
                
                
            case '006':
                if (self::$Medellin !== null)
                    return self::$Medellin;
                else {
                    self::$Medellin = Yii::app()->Medellin;
                    if (self::$Medellin instanceof CDbConnection) {
                        self::$Medellin->setActive(true);
                        return self::$Medellin;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }

                break;

            case '007':
                if (self::$Monteria !== null)
                    return self::$Monteria;
                else {
                    self::$Monteria = Yii::app()->Monteria;
                    if (self::$Monteria instanceof CDbConnection) {
                        self::$Monteria->setActive(true);
                        return self::$Monteria;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;

            case '008':
                if (self::$Pasto !== null)
                    return self::$Pasto;
                else {
                    self::$Pasto = Yii::app()->Pasto;
                    if (self::$Pasto instanceof CDbConnection) {
                        self::$Pasto->setActive(true);
                        return self::$Pasto;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;

            case '009':
                if (self::$Pereira !== null)
                    return self::$Pereira;
                else {
                    self::$Pereira = Yii::app()->Pereira;
                    if (self::$Pereira instanceof CDbConnection) {
                        self::$Pereira->setActive(true);
                        return self::$Pereira;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;

            case '010':
                if (self::$Popayan !== null)
                    return self::$Popayan;
                else {
                    self::$Popayan = Yii::app()->Popayan;
                    if (self::$Popayan instanceof CDbConnection) {
                        self::$Popayan->setActive(true);
                        return self::$Popayan;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;

            case '011':
                if (self::$Villavicencio !== null)
                    return self::$Villavicencio;
                else {
                    self::$Villavicencio = Yii::app()->Villavicencio;
                    if (self::$Villavicencio instanceof CDbConnection) {
                        self::$Villavicencio->setActive(true);
                        return self::$Villavicencio;
                    } else
                        throw new CDbException(Yii::t('yii', 'Active Record requires a "apartado" CDbConnection application component.'));
                }
                break;
                
                
        }
    }

}

?>
