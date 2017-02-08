<?php
/* @var $this SaldosinventariopreventaController */
/* @var $model Saldosinventariopreventa */

$this->breadcrumbs=array(
	'Saldosinventariopreventas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Saldosinventariopreventa', 'url'=>array('index')),
	array('label'=>'Manage Saldosinventariopreventa', 'url'=>array('admin')),
);
?>

<h1>Create Saldosinventariopreventa</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>