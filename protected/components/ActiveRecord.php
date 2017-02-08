<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CaliActiveRecord extends CActiveRecord {
   
    private static $cali = null;
 
    protected static function getCaliDbConnection()
    {
        if (self::$cali !== null)
            return self::$cali;
        else
        {
            self::$cali = Yii::app()->cali;
            if (self::$cali instanceof CDbConnection)
            {
                self::$cali->setActive(true);
                return self::$cali;
            }
            else
                throw new CDbException(Yii::t('yii','Active Record requires a "cali" CDbConnection application component.'));
        }
    }

}
?>
