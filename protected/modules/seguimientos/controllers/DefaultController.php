<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
            
             Yii::app()->clientScript->registerScriptFile(
                Yii::app()->baseUrl . '/scripts/seguimientos/informezonaventas/informeZonaVentas.js', CClientScript::POS_END
        );
		$this->render('index');
	}
}