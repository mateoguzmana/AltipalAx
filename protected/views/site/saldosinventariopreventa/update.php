<?php
/* @var $this SaldosinventariopreventaController */
/* @var $model Saldosinventariopreventa */

$this->breadcrumbs=array(
	'Saldosinventariopreventas'=>array('index'),
	$model->Id=>array('view','id'=>$model->Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Saldosinventariopreventa', 'url'=>array('index')),
	array('label'=>'Create Saldosinventariopreventa', 'url'=>array('create')),
	array('label'=>'View Saldosinventariopreventa', 'url'=>array('view', 'id'=>$model->Id)),
	array('label'=>'Manage Saldosinventariopreventa', 'url'=>array('admin')),
);
?>

<h1>Update Saldosinventariopreventa <?php echo $model->Id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>