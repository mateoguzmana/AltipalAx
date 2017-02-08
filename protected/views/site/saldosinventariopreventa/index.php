<?php
/* @var $this SaldosinventariopreventaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Saldosinventariopreventas',
);

$this->menu=array(
	array('label'=>'Create Saldosinventariopreventa', 'url'=>array('create')),
	array('label'=>'Manage Saldosinventariopreventa', 'url'=>array('admin')),
);
?>

<h1>Saldosinventariopreventas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
