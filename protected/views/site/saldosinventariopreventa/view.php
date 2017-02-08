<?php
/* @var $this SaldosinventariopreventaController */
/* @var $model Saldosinventariopreventa */

$this->breadcrumbs=array(
	'Saldosinventariopreventas'=>array('index'),
	$model->Id,
);

$this->menu=array(
	array('label'=>'List Saldosinventariopreventa', 'url'=>array('index')),
	array('label'=>'Create Saldosinventariopreventa', 'url'=>array('create')),
	array('label'=>'Update Saldosinventariopreventa', 'url'=>array('update', 'id'=>$model->Id)),
	array('label'=>'Delete Saldosinventariopreventa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->Id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Saldosinventariopreventa', 'url'=>array('admin')),
);
?>

<h1>View Saldosinventariopreventa #<?php echo $model->Id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'Id',
		'CodigoSitio',
		'NombreSitio',
		'CodigoAlmacen',
		'CodigoVariante',
		'CodigoArticulo',
		'CodigoCaracteristica1',
		'CodigoCaracteristica2',
		'CodigoTipo',
		'Disponible',
		'CodigoUnidadMedida',
		'NombreUnidadMedida',
	),
)); ?>
