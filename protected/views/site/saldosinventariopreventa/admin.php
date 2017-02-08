<?php
/* @var $this SaldosinventariopreventaController */
/* @var $model Saldosinventariopreventa */

$this->breadcrumbs=array(
	'Saldosinventariopreventas'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Saldosinventariopreventa', 'url'=>array('index')),
	array('label'=>'Create Saldosinventariopreventa', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#saldosinventariopreventa-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Saldosinventariopreventas</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'saldosinventariopreventa-grid',
        'htmlOptions' => array('class' => 'table table-bordered'),
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'Id',
		'CodigoSitio',
		'NombreSitio',
		'CodigoAlmacen',
		'CodigoVariante',
		'CodigoArticulo',
		/*
		'CodigoCaracteristica1',
		'CodigoCaracteristica2',
		'CodigoTipo',
		'Disponible',
		'CodigoUnidadMedida',
		'NombreUnidadMedida',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
